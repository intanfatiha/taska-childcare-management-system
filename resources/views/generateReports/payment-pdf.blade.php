<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Report PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .summary-card { display: inline-block; width: 23%; margin-right: 1%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; }
        .chart-container { text-align: center; margin: 20px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px; border: 1px solid #ccc; text-align: left; }
        th { background-color: #f3f3f3; }
    </style>
</head>
<body>
    <h2>Payment Report - {{ $selectedDate }}</h2>

    <div>
        <div class="summary-card"><strong>Total Collected:</strong><br>RM {{ number_format($totalCollected, 2) }}</div>
        <div class="summary-card"><strong>Paid:</strong><br>{{ $paidCount }}</div>
        <div class="summary-card"><strong>Unpaid:</strong><br>{{ $unpaidCount }}</div>
        <div class="summary-card"><strong>Overdue:</strong><br>{{ $overdueCount }}</div>
    </div>

    <div class="chart-container">
        <h3>Payment Trend Chart</h3>
        <img src="{{ $chartImage }}" style="max-width: 100%; height: auto;">
    </div>

    <h3>Payment Table</h3>
    <table>
        <thead>
            <tr>
                <th>Children Name</th>
                <th>Parent Name</th>
                <th>Amount</th>
                <th>Payment Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($childParents as $payment)
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
                    <td>
                        @if ($payment->paymentByParents_date)
                            {{ \Carbon\Carbon::parse($payment->paymentByParents_date)->format('Y-m-d') }}
                        @else
                            Not paid yet
                        @endif
                    </td>
                    <td>{{ $payment->payment_status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
