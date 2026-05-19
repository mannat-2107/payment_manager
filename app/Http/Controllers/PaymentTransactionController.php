<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\PayrollRecord;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = PaymentTransaction::with(['employee.user', 'payrollRecord']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->method) {
            $query->where('payment_method', $request->method);
        }

        if ($request->search) {
            $query->whereHas('employee.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->orWhere('transaction_reference', 'like', '%' . $request->search . '%');
        }

        $transactions = $query->latest()->paginate(15);

        $totalPaid    = PaymentTransaction::where('status', 'success')->sum('amount');
        $totalPending = PaymentTransaction::whereIn('status', ['initiated', 'processing'])->count();
        $totalFailed  = PaymentTransaction::where('status', 'failed')->count();
        $totalSuccess = PaymentTransaction::where('status', 'success')->count();

        return view('transactions.index', compact(
            'transactions',
            'totalPaid',
            'totalPending',
            'totalFailed',
            'totalSuccess'
        ));
    }

    public function create()
    {
        $employees      = Employee::with('user')->where('status', 'active')->get();
        $payrollRecords = PayrollRecord::with('employee.user')
                                       ->where('status', 'approved')
                                       ->get();
        return view('transactions.create', compact('employees', 'payrollRecords'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id'    => 'required|exists:employees,id',
            'amount'         => 'required|numeric|min:1',
            'payment_method' => 'required|in:bank_transfer,cheque,cash',
            'remarks'        => 'nullable|string|max:500',
        ]);

        $reference = 'TXN' . strtoupper(uniqid());
        $employee  = Employee::find($request->employee_id);

        PaymentTransaction::create([
            'employee_id'           => $request->employee_id,
            'payroll_record_id'     => $request->payroll_record_id ?? null,
            'transaction_reference' => $reference,
            'amount'                => $request->amount,
            'payment_method'        => $request->payment_method,
            'status'                => 'initiated',
            'bank_name'             => $employee->bank_name,
            'account_number'        => $employee->account_number,
            'ifsc_code'             => $employee->ifsc_code,
            'remarks'               => $request->remarks,
        ]);

        return redirect()->route('transactions.index')
                         ->with('success', 'Transaction initiated successfully.');
    }

    public function show(PaymentTransaction $transaction)
    {
        $transaction->load(['employee.user', 'employee.department', 'payrollRecord']);
        return view('transactions.show', compact('transaction'));
    }

    public function update(Request $request, PaymentTransaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:initiated,processing,success,failed,reversed',
        ]);

        $data = ['status' => $request->status];

        if ($request->status === 'success') {
            $data['paid_at'] = now();

            if ($transaction->payrollRecord) {
                $transaction->payrollRecord->update(['status' => 'paid']);
            }

            try {
                \Mail::to($transaction->employee->user->email)
                     ->send(new \App\Mail\PaymentConfirmationMail($transaction));
            } catch (\Exception $e) {
                \Log::error('Payment email failed: ' . $e->getMessage());
            }
        }

        if ($request->status === 'failed') {
            $data['failure_reason'] = $request->failure_reason ?? 'Payment failed';
        }

        $transaction->update($data);

        return redirect()->route('transactions.index')
                         ->with('success', 'Transaction status updated.' .
                                ($request->status === 'success' ? ' Email sent to employee.' : ''));
    }

    public function retry(PaymentTransaction $transaction)
    {
        if ($transaction->status !== 'failed') {
            return back()->with('error', 'Only failed transactions can be retried.');
        }

        PaymentTransaction::create([
            'employee_id'           => $transaction->employee_id,
            'payroll_record_id'     => $transaction->payroll_record_id,
            'transaction_reference' => 'TXN' . strtoupper(uniqid()),
            'amount'                => $transaction->amount,
            'payment_method'        => $transaction->payment_method,
            'status'                => 'initiated',
            'bank_name'             => $transaction->bank_name,
            'account_number'        => $transaction->account_number,
            'ifsc_code'             => $transaction->ifsc_code,
            'remarks'               => 'Retry of ' . $transaction->transaction_reference,
        ]);

        return redirect()->route('transactions.index')
                         ->with('success', 'Transaction retried successfully.');
    }

    public function receipt(PaymentTransaction $transaction)
    {
        $transaction->load(['employee.user', 'employee.department', 'payrollRecord']);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'transactions.receipt',
            compact('transaction')
        );

        return $pdf->download('receipt-' . $transaction->transaction_reference . '.pdf');
    }

    public function bulkPay(Request $request)
    {
        $approvedPayrolls = PayrollRecord::where('status', 'approved')
                                          ->with('employee')
                                          ->get();

        if ($approvedPayrolls->isEmpty()) {
            return redirect()->route('transactions.index')
                             ->with('error', 'No approved payrolls found.');
        }

        $count = 0;

        foreach ($approvedPayrolls as $payroll) {
            $txn = PaymentTransaction::create([
                'employee_id'           => $payroll->employee_id,
                'payroll_record_id'     => $payroll->id,
                'transaction_reference' => 'TXN' . strtoupper(uniqid()),
                'amount'                => $payroll->net_salary,
                'payment_method'        => 'bank_transfer',
                'status'                => 'success',
                'bank_name'             => $payroll->employee->bank_name,
                'account_number'        => $payroll->employee->account_number,
                'ifsc_code'             => $payroll->employee->ifsc_code,
                'remarks'               => 'Bulk payment — ' . Carbon::create()->month($payroll->month)->format('F') . ' ' . $payroll->year,
                'paid_at'               => now(),
            ]);

            $payroll->update(['status' => 'paid']);

            try {
                \Mail::to($payroll->employee->user->email)
                     ->send(new \App\Mail\PaymentConfirmationMail($txn));
            } catch (\Exception $e) {
                \Log::error('Bulk payment email failed: ' . $e->getMessage());
            }

            $count++;
        }

        return redirect()->route('transactions.index')
                         ->with('success', $count . ' payments processed successfully.');
    }

    public function destroy(PaymentTransaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')
                         ->with('success', 'Transaction deleted.');
    }

    // Used by EMPLOYEE — checks the transaction belongs to them
public function receiptOwn(PaymentTransaction $transaction)
{
    $employee = Employee::where('user_id', auth()->id())->firstOrFail();

    abort_if($transaction->employee_id !== $employee->id, 403, 'This receipt does not belong to you.');

    $transaction->load(['employee.user', 'employee.department', 'payrollRecord']);

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
        'transactions.receipt',
        compact('transaction')
    );

    return $pdf->download('receipt-' . $transaction->transaction_reference . '.pdf');
}
}
