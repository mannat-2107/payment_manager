<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\PayrollRecord;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;

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
            $query->whereHas('employee.user', function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%');
            })->orWhere('transaction_reference', 'like', '%'.$request->search.'%');
        }

        $transactions = $query->latest()->paginate(15);

        $totalPaid       = PaymentTransaction::where('status', 'success')->sum('amount');
        $totalPending    = PaymentTransaction::whereIn('status', ['initiated', 'processing'])->count();
        $totalFailed     = PaymentTransaction::where('status', 'failed')->count();
        $totalSuccess    = PaymentTransaction::where('status', 'success')->count();

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

        $employee = Employee::find($request->employee_id);

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
        }

        if ($request->status === 'failed') {
            $data['failure_reason'] = $request->failure_reason ?? 'Payment failed';
        }

        $transaction->update($data);

        return redirect()->route('transactions.index')
                         ->with('success', 'Transaction status updated.');
    }

    public function retry(PaymentTransaction $transaction)
    {
        if ($transaction->status !== 'failed') {
            return back()->with('error', 'Only failed transactions can be retried.');
        }

        $reference = 'TXN' . strtoupper(uniqid());

        PaymentTransaction::create([
            'employee_id'           => $transaction->employee_id,
            'payroll_record_id'     => $transaction->payroll_record_id,
            'transaction_reference' => $reference,
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
}