<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Report PDF</title>
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
            color: rgb(255, 153, 9);
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
        .date-info {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
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
        .status-attend { color: #28a745; font-weight: bold; }
        .status-absent { color: #dc3545; font-weight: bold; }
        .time-in { color: #28a745; font-weight: normal; }
        .time-out { color: #007bff; font-weight: normal; }
        .overtime { color: #dc3545; font-weight: bold; }
        .na-text { color: #6c757d; font-style: italic; }
    </style>
</head>
<body>
    <div class="header">
        <div style="display: table; width: 100%; margin-bottom: 15px;">
            <div style="display: table-cell; width: 120px; vertical-align: middle;">
                <img src="{{ public_path('assets/ppuk_logo.png') }}" alt="Taska Hikmah Logo" style="width: 100px; height: auto;">
            </div>
            <div style="display: table-cell; vertical-align: middle; text-align: center;">
                <h1 style="margin: 0; color: rgb(255, 153, 9); font-size: 24px;">Taska Hikmah</h1>
                <h2 style="margin: 5px 0 0 0; color: #333; font-size: 18px;">Attendance Report</h2>
                <div class="date-info">
                    <br>Daily Report - {{ \Carbon\Carbon::parse($selectedDate)->format('F j, Y') }}
                </div>
            </div>
            <div style="display: table-cell; width: 120px;"></div>
        </div>
    </div>

    <div class="summary-cards">
        <div class="summary-card">
            <h4>Total Children</h4>
            <div class="value">{{ $totalChildren }}</div>
        </div>
        <div class="summary-card">
            <h4>Present</h4>
            <div class="value">{{ $presentCount }}</div>
        </div>
        <div class="summary-card">
            <h4>Absent</h4>
            <div class="value">{{ $absentCount }}</div>
        </div>
        <div class="summary-card">
            <h4>Attendance Rate</h4>
            <div class="value">{{ $attendanceRate }}%</div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-container" style="display: table; width: 100%; margin: 20px 0;">
        @if($pieChartImage)
        <div style="display: table-cell; width: 48%; vertical-align: top; padding-right: 2%;">
            <div class="chart-container">
                <h3>Attendance Summary</h3>
                <img src="data:image/png;base64,{{ $pieChartImage }}" style="max-width: 100%; height: auto;">
            </div>
        </div>
        @endif
        
        @if($barChartImage)
        <div style="display: table-cell; width: 48%; vertical-align: top; padding-left: 2%;">
            <div class="chart-container">
                <h3>Overtime Trend</h3>
                <img src="data:image/png;base64,{{ $barChartImage }}" style="max-width: 100%; height: auto;">
            </div>
        </div>
        @endif
    </div>

    <!-- If only one chart exists, center it -->
    @if($pieChartImage && !$barChartImage)
    <div class="chart-container">
        <h3>Attendance Summary</h3>
        <img src="data:image/png;base64,{{ $pieChartImage }}" style="max-width: 60%; height: auto;">
    </div>
    @elseif($barChartImage && !$pieChartImage)
    <div class="chart-container">
        <h3>Overtime Trend</h3>
        <img src="data:image/png;base64,{{ $barChartImage }}" style="max-width: 60%; height: auto;">
    </div>
    @endif

    <div class="table-container">
        <h3>Attendance Records ({{ $attendances->count() }} Total)</h3>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Child Name</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Overtime</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $index => $attendance)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $attendance->child->child_name ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($attendance->attendance_date)->format('d/m/Y') }}</td>
                        <td>
                            @if($attendance->attendance_status === 'attend')
                                <span class="status-attend">{{ ucfirst($attendance->attendance_status) }}</span>
                            @else
                                <span class="status-absent">{{ ucfirst($attendance->attendance_status) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($attendance->time_in)
                                <span class="time-in">{{ \Carbon\Carbon::parse($attendance->time_in)->format('g:i A') }}</span>
                            @else
                                <span class="na-text">-</span>
                            @endif
                        </td>
                        <td>
                            @if($attendance->time_out)
                                <span class="time-out">{{ \Carbon\Carbon::parse($attendance->time_out)->format('g:i A') }}</span>
                            @else
                                <span class="na-text">-</span>
                            @endif
                        </td>
                        <td>
                            @if($attendance->attendance_overtime && $attendance->attendance_overtime > 0)
                                <span class="overtime">{{ $attendance->attendance_overtime }} min</span>
                            @else
                                <span class="na-text">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px; color: #666;">
                            No attendance data available for the selected date.
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