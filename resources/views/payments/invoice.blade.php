<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monthly Invoice</title>
    <style>
        @page {
            size: A4;
            margin: 40px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            margin: 0;
            padding: 40px;
            line-height: 1.4;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #800080;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .logo img {
            height: 60px;
        }

        .invoice-title h2 {
            font-size: 24px;
            margin: 0;
            color: #800080;
        }

        .invoice-info {
            font-size: 13px;
            margin-top: 10px;
        }

        .addresses {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .from, .to {
            width: 45%;
            font-size: 14px;
        }

        .from h4, .to h4 {
            color: #800080;
            margin-bottom: 10px;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th {
            background-color: #800080;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        th:last-child, td:last-child {
            text-align: right;
        }

        .totals {
            width: 300px;
            margin-left: auto;
            border: 1px solid #ddd;
            padding: 20px;
        }

        .totals table {
            margin: 0;
        }

        .totals td {
            border: none;
            padding: 8px 0;
        }

        .totals .total-row {
            border-top: 2px solid #800080;
            font-weight: bold;
            font-size: 16px;
        }

        @media print {
            body {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">
            <img src="{{ asset('assets/ppuk_logo.png') }}" alt="Logo">
        </div>
        <div class="invoice-title">
            <h2>Monthly Invoice</h2>
            <div class="invoice-info">
                <div>Invoice #: {{ $payment->id }}</div>
                <div>Date: {{ \Carbon\Carbon::now()->format('d M Y') }}</div>
                <div>Due: {{ \Carbon\Carbon::parse($payment->payment_duedate)->format('d M Y') }}</div>
            </div>
        </div>
    </div>

    <div class="addresses">
        <div class="from">
            <h4>From</h4>
            <div><strong>Taska Hikmah</strong></div>
            <div>Parit Raja, UTHM</div>
            <div>Johor, Malaysia</div>
            <div>+60 12-345 6789</div>
        </div>
        <div class="to">
            <h4>Bill To</h4>
            @php
                $names = [];
                if ($payment->parentRecord) {
                    if ($payment->parentRecord->father) $names[] = $payment->parentRecord->father->father_name;
                    if ($payment->parentRecord->mother) $names[] = $payment->parentRecord->mother->mother_name;
                    if ($payment->parentRecord->guardian) $names[] = $payment->parentRecord->guardian->guardian_name;
                }
            @endphp
            <div><strong>{{ implode(' & ', $names) ?: 'N/A' }}</strong></div>
            <div>{{ $payment->parentRecord->address ?? 'Address not provided' }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Total Fee (RM)</th>
                <th>Qty</th>
                <th>Overtime Fee</th>
                <th>Total (RM)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Monthly Childcare Fee</td>
                <td>{{ number_format($payment->payment_amount, 2) }}</td>
                <td>1</td>
                <td>RM0.00</td>
                <td>{{ number_format($payment->payment_amount, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td>Subtotal:</td>
                <td style="text-align: right;">RM {{ number_format($payment->payment_amount, 2) }}</td>
            </tr>
            <tr>
                <td>Overtime:</td>
                <td style="text-align: right;">RM 0.00</td>
            </tr>
            <tr class="total-row">
                <td>Total:</td>
                <td style="text-align: right;">RM {{ number_format($payment->payment_amount, 2) }}</td>
            </tr>
        </table>
    </div>

</body>
</html>