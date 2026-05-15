<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Receipt</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; font-size: 13px; color: #333; padding: 30px; }
        .header { text-align: center; margin-bottom: 30px; }
        .logo { display: inline-flex; align-items: center; gap: 10px; margin-bottom: 8px; }
        .logo-icon { width: 40px; height: 40px; background: #2563eb; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
        .logo-text { font-size: 20px; font-weight: bold; color: #1e40af; }
        .subtitle { font-size: 12px; color: #6b7280; }
        .receipt-box { border: 2px solid #e5e7eb; border-radius: 12px; padding: 24px; margin-bottom: 20px; }
        .receipt-title { font-size: 18px; font-weight: bold; color: #111827; margin-bottom: 4px; }
        .receipt-ref { font-size: 12px; color: #6b7280; font-family: monospace; margin-bottom: 20px; }
        .status-success { display: inline-block; background: #d1fae5; color: #065f46; padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: bold; margin-bottom: 20px; }
        .status-pending { display: inline-block; background: #fef3c7; color: #92400e; padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: bold; margin-bottom: 20px; }
        .status-failed { display: inline-block; background: #fee2e2; color: #991b1b; padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: bold; margin-bottom: 20px; }
        .amount-box { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 16px; text-align: center; margin-bottom: 20px; }
        .amount-label { font-size: 12px; color: #6b7280; margin-bottom: 4px; }
        .amount-value { font-size: 32px; font-weight: bold; color: #16a34a; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px; }
        .info-item label { font-size: 11px; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 3px; }
        .info-item p { font-size: 13px; color: #111827; font-weight: 500; }
        .divider { border: none; border-top: 1px solid #e5e7eb; margin: 20px 0; }
        .bank-section { background: #f9fafb; border-radius: 8px; padding: 16px; }
        .bank-title { font-size: 12px; font-weight: bold; color: #6b7280; text-transform: uppercase; margin-bottom: 12px; }
        .bank-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; }
        .footer p { font-size: 11px; color: #9ca3af; margin-bottom: 4px; }
        .watermark { position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-45deg); font-size: 80px; color: rgba(0,0,0,0.03); font-weight: bold; z-index: -1; }
    </style>
</head>
<body>

<div class="watermark">PAYMANAGER</div>

<div class="header">
    <div class="logo">
        <div class="logo-text">💰 PayManager</div>
    </div>
    <div class="subtitle">Payment Transaction Receipt</div>
</div>

<div class="receipt-box">
    <div class="receipt-title">Payment Receipt</div>
    <div class="receipt-ref">Ref: {{ $transaction->transaction_reference }}</div>

    @if($transaction->status === 'success')
        <div class="status-success">✓ Payment Successful</div>
    @elseif($transaction->status === 'failed')
        <div class="status-failed">✗ Payment Failed</div>
    @else
        <div class="status-pending">⏳ {{ ucfirst($transaction->status) }}</div>
    @endif

    <div class="amount-box">
        <div class="amount-label">Amount Paid</div>
        <div class="amount-value">₹{{ number_format($transaction->amount, 0) }}</div>
    </div>

    <div class="info-grid">
        <div class="info-item">
            <label>Employee Name</label>
            <p>{{ $transaction->employee->user->name }}</p>
        </div>
        <div class="info-item">
            <label>Employee Code</label>
            <p>{{ $transaction->employee->employee_code }}</p>
        </div>
        <div class="info-item">
            <label>Designation</label>
            <p>{{ $transaction->employee->designation }}</p>
        </div>
        <div class="info-item">
            <label>Department</label>
            <p>{{ $transaction->employee->department->name }}</p>
        </div>
        <div class="info-item">
            <label>Payment Method</label>
            <p>{{ ucwords(str_replace('_', ' ', $transaction->payment_method)) }}</p>
        </div>
        <div class="info-item">
            <label>Transaction Date</label>
            <p>{{ $transaction->created_at->format('d M Y, h:i A') }}</p>
        </div>
        @if($transaction->paid_at)
        <div class="info-item">
            <label>Paid On</label>
            <p>{{ $transaction->paid_at->format('d M Y, h:i A') }}</p>
        </div>
        @endif
        @if($transaction->remarks)
        <div class="info-item">
            <label>Remarks</label>
            <p>{{ $transaction->remarks }}</p>
        </div>
        @endif
    </div>

    <hr class="divider">

    <div class="bank-section">
        <div class="bank-title">Bank Details</div>
        <div class="bank-grid">
            <div class="info-item">
                <label>Bank Name</label>
                <p>{{ $transaction->bank_name ?? '—' }}</p>
            </div>
            <div class="info-item">
                <label>Account Number</label>
                <p>{{ $transaction->account_number ?? '—' }}</p>
            </div>
            <div class="info-item">
                <label>IFSC Code</label>
                <p>{{ $transaction->ifsc_code ?? '—' }}</p>
            </div>
        </div>
    </div>
</div>

<div class="footer">
    <p>This is a computer generated receipt and does not require a signature.</p>
    <p>Generated on {{ now()->format('d M Y, h:i A') }} by PayManager</p>
    <p style="margin-top: 8px; color: #d1d5db;">© {{ now()->year }} PayManager — Employee Payment Platform</p>
</div>

</body>
</html>