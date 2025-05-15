
<!DOCTYPE html>
<html>
<head>
    <title>Attendance Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f4f4f4;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Attendance Report</h2>
    <p>Date: {{ $selectedDate }}</p>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Date</th>
                <th>Attend/Absent</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->child->child_name }}</td>
                    <td>{{ $attendance->time_in ?? 'N/A' }}</td>
                    <td>{{ $attendance->time_out ?? 'N/A' }}</td>
                    <td>{{ $attendance->attendance_date }}</td>
                    <td>{{ ucfirst($attendance->attendance_status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No attendance records found for the selected date.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>