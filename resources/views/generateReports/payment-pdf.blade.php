<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Report PDF</title>
    <style>
        body { 
            font-family: sans-serif; 
            font-size: 12px; 
            margin: 20px;
        }
        .header {
            margin-bottom: 25px;
            border-bottom: 2px solid #2c5aa0;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #2c5aa0;
            font-size: 24px;
            margin: 0;
            font-weight: bold;
        }
        .header h2 {
            color: #333;
            font-size: 18px;
            margin: 5px 0 0 0;
            font-weight: normal;
        }
        .summary-cards {
            display: table;
            width: 100%;
            margin: 20px 0;
        }
        .summary-card { 
            display: table-cell;
            width: 23%; 
            margin-right: 1%; 
            padding: 15px; 
            border: 1px solid #ddd; 
            border-radius: 8px;
            text-align: center;
            vertical-align: top;
        }
        .summary-card h4 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 11px;
        }
        .summary-card .value {
            font-size: 16px;
            font-weight: bold;
            color: #2c5aa0;
        }
        .chart-container { 
            text-align: center; 
            margin: 20px 0; 
            page-break-inside: avoid;
        }
        .table-container {
            margin-top: 20px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px;
        }
        th, td { 
            padding: 8px 4px; 
            border: 1px solid #ccc; 
            text-align: left;
            font-size: 10px;
        }
        th { 
            background-color: #f8f9fa; 
            font-weight: bold;
            color: #333;
        }
        .status-complete { color: #28a745; font-weight: bold; }
        .status-pending { color: #ffc107; font-weight: bold; }
        .status-overdue { color: #dc3545; font-weight: bold; }
        .not-paid { color: #dc3545; font-style: italic; }
        .view-type {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div style="display: table; width: 100%; margin-bottom: 15px;">
            <div style="display: table-cell; width: 120px; vertical-align: middle;">
<img src="{{ public_path('assets/ppuk_logo.png') }}" alt="Taska Hikmah Logo" style="width: 100px; height: auto;">
            </div>
            <div style="display: table-cell; vertical-align: middle; text-align: center;">
                <h1 style="margin: 0; color:rgb(255, 153, 9); font-size: 24px;">Taska Hikmah</h1>
                <h2 style="margin: 5px 0 0 0; color: #333; font-size: 18px;">Payment Report</h2>
                <div class="view-type">
            @if($viewType === 'day')
                <br>Daily Report - {{ \Carbon\Carbon::parse($selectedDate)->format('F j, Y') }}
            @else
                <br>Monthly Report - {{ \Carbon\Carbon::parse($selectedDate)->format('F Y') }}
            @endif
        </div>


            </div>
            <div style="display: table-cell; width: 120px;"></div>
        </div>
        
    </div>

    <div class="summary-cards">
        <div class="summary-card">
            <h4>Total Collected</h4>
            <div class="value">RM {{ number_format($totalCollected, 2) }}</div>
        </div>
        <div class="summary-card">
            <h4>Paid</h4>
            <div class="value">{{ $paidCount }}</div>
        </div>
        <div class="summary-card">
            <h4>Unpaid</h4>
            <div class="value">{{ $unpaidCount }}</div>
        </div>
        <div class="summary-card">
            <h4>Overdue</h4>
            <div class="value">{{ $overdueCount }}</div>
        </div>
    </div>

    @if($chartImage)
    <div class="chart-container">
        <h3>Payment Trend Chart</h3>
        <img src="{{ $chartImage }}" style="max-width: 100%; height: auto;">
    </div>
    @endif

    <div class="table-container">
        <h3>Payment Records ({{ $payments->count() }} Total)</h3>
        <table>
            <thead>
                <tr>
                    <th>Children Name</th>
                    <th>Parent Name</th>
                    <th>Payment Amount</th>
                    <th>Created At</th>
                    <th>Due Date</th>
                    <th>Payment Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td>{{ $payment->child->child_name ?? '-' }}</td>
                        <td>
                            @php
                                $parentRecord = $payment->parentRecord;
                                $names = [];
                                if ($parentRecord) {
                                    if ($parentRecord->father) $names[] = $parentRecord->father->father_name;
                                    if ($parentRecord->mother) $names[] = $parentRecord->mother->mother_name;
                                    if ($parentRecord->guardian) $names[] = $parentRecord->guardian->guardian_name;
                                }
                                echo !empty($names) ? implode(' & ', $names) : 'N/A';
                            @endphp
                        </td>
                        <td>RM {{ number_format($payment->payment_amount, 2) }}</td>
                        <td>{{ $payment->created_at->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($payment->payment_duedate)->format('d/m/Y') }}</td>
                        <td>
                            @if ($payment->paymentByParents_date)
                                {{ \Carbon\Carbon::parse($payment->paymentByParents_date)->format('d/m/Y') }}
                            @else
                                <span class="not-paid">Not paid yet</span>
                            @endif
                        </td>
                        <td>
                            @if($payment->payment_status === 'Complete')
                                <span class="status-complete">{{ $payment->payment_status }}</span>
                            @elseif($payment->payment_status === 'Overdue')
                                <span class="status-overdue">{{ $payment->payment_status }}</span>
                            @else
                                <span class="status-pending">{{ $payment->payment_status }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px; color: #666;">
                            No payment data available for the selected period.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 30px; font-size: 10px; color: #666; text-align: center;">
        Generated on {{ now()->format('F j, Y \a\t g:i A') }}
    </div>
</body>
</html>