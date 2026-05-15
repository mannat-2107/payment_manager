@component('mail::message')

# Payment Confirmation

Dear {{ $user->name }},

Your salary payment has been processed successfully.

---

@component('mail::panel')
**Transaction Reference:** {{ $transaction->transaction_reference }}

**Amount Paid:** ₹{{ number_format($transaction->amount, 0) }}

**Payment Method:** {{ ucwords(str_replace('_', ' ', $transaction->payment_method)) }}

**Employee Code:** {{ $employee->employee_code }}

**Date:** {{ $transaction->paid_at ? $transaction->paid_at->format('d M Y, h:i A') : now()->format('d M Y, h:i A') }}

**Status:** ✅ Success
@endcomponent

---

@component('mail::table')
| Detail | Info |
|:-------|:-----|
| Bank Name | {{ $transaction->bank_name ?? '—' }} |
| Account Number | {{ $transaction->account_number ?? '—' }} |
| IFSC Code | {{ $transaction->ifsc_code ?? '—' }} |
@endcomponent

If you have any questions about this payment, please contact your HR department.

Thanks,
**PayManager Team**

@endcomponent