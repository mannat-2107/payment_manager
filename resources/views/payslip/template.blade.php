<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payslip</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 22px;
            color: #2563eb;
            margin: 0;
        }
        .header p {
            margin: 4px 0;
            color: #666;
        }
        .section-title {
            background: #2563eb;
            color: white;
            padding: 6px 12px;
            font-weight: bold;
            margin-bottom: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table td {
            padding: 7px 12px;
            border: 1px solid #e5e7eb;
        }
        table th {
            padding: 7px 12px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            font-weight: bold;
        }
        .info-table td:first-child {
            font-weight: bold;
            width: 30%;
            background: #f9fafb;
        }
        .amount {
            text-align: right;
        }
        .total-row td {
            font-weight: bold;
            background: #f3f4f6;
        }
        .net-salary {
            background: #dcfce7;
            border: 2px solid #16a34a;
            padding: 15px;
            text-align: center;
            margin-top: 10px;
        }
        .net-salary h2 {
            margin: 0;
            color: #16a34a;
            font-size: 20px;
        }
        .footer {
            margin-top: 30px;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
            text-align: center;
            color: #9ca3af;
            font-size: 11px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h1>Payment Platform</h1>
        <p>Salary Slip for the month of
            {{ DateTime::createFromFormat('!m', $payroll->month)->format('F') }}
            {{ $payroll->year }}
        </p>
    </div>

    <!-- Employee Info -->
    <p class="section-title">Employee Details</p>
    <table class="info-table">
        <tr>
            <td>Employee Name</td>
            <td>{{ $payroll->employee->user->name }}</td>
            <td>Employee Code</td>
            <td>{{ $payroll->employee->employee_code }}</td>
        </tr>
        <tr>
            <td>Designation</td>
            <td>{{ $payroll->employee->designation }}</td>
            <td>Department</td>
            <td>{{ $payroll->employee->department->name }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{ $payroll->employee->user->email }}</td>
            <td>Status</td>
            <td>{{ ucfirst($payroll->status) }}</td>
        </tr>
    </table>

    <!-- Earnings and Deductions -->
    <table>
        <thead>
            <tr>
                <th>Earnings</th>
                <th class="amount">Amount (₹)</th>
                <th>Deductions</th>
                <th class="amount">Amount (₹)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Basic Salary</td>
                <td class="amount">{{ number_format($payroll->basic, 2) }}</td>
                <td>Provident Fund (PF)</td>
                <td class="amount">{{ number_format($payroll->pf, 2) }}</td>
            </tr>
            <tr>
                <td>House Rent Allowance (HRA)</td>
                <td class="amount">{{ number_format($payroll->hra, 2) }}</td>
                <td>ESI</td>
                <td class="amount">{{ number_format($payroll->esi, 2) }}</td>
            </tr>
            <tr>
                <td>Allowances</td>
                <td class="amount">{{ number_format($payroll->allowances, 2) }}</td>
                <td>TDS</td>
                <td class="amount">{{ number_format($payroll->tds, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td>Gross Salary</td>
                <td class="amount">{{ number_format($payroll->gross, 2) }}</td>
                <td>Total Deductions</td>
                <td class="amount">{{ number_format($payroll->total_deductions, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Net Salary -->
    <div class="net-salary">
        <h2>Net Salary: ₹{{ number_format($payroll->net_salary, 2) }}</h2>
        <p style="margin:4px 0;color:#166534">
            {{ DateTime::createFromFormat('!m', $payroll->month)->format('F') }}
            {{ $payroll->year }}
        </p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>This is a computer generated payslip and does not require a signature.</p>
        <p>Generated on {{ now()->format('d M Y') }}</p>
    </div>

</body>
</html>