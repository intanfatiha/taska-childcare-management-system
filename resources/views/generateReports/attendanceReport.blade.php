<x-app-layout>

<script>
    const overtimeData = {
        daily: @json($overtimeDaily),
        weekly: @json($overtimeWeekly),
        monthly: @json($overtimeMonthly)
    };
    const attendanceData = {
        daily: @json($attendanceDaily),
        weekly: @json($attendanceWeekly),
        monthly: @json($attendanceMonthly)
    };
</script>

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <!-- Header Section with Gradient -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 bg-gradient-to-r from-indigo-50 to-purple-100 p-6 rounded-lg shadow-sm">
        <div>
            <h2 class="text-3xl font-bold text-indigo-800">
                {{ __('Attendance Report') }}
            </h2>
        </div>
    </div>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Children Attendance Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4">
        <!-- Date Filter and PDF Export -->
        <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
            <form method="GET" action="{{ route('attendance.report') }}" class="flex items-center gap-4">
                <div>
                    <label for="selected_date" class="block text-sm font-medium text-gray-700 mb-1">Select Date:</label>
                    <input type="date" id="selected_date" name="selected_date" value="{{ $selectedDate }}"
                        class="border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <button type="submit"
                    class="mt-6 px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </form>

            <!-- Updated PDF Export Button with Chart Capture -->
            <div class="flex gap-2">
                <!-- Chart Capture Form -->
                <form id="attendanceChartForm" action="{{ route('attendance.report.pdf.post') }}" method="POST">
                    @csrf
                    <input type="hidden" name="pieChartImage" id="pieChartImageInput">
                    <input type="hidden" name="barChartImage" id="barChartImageInput">
                    <input type="hidden" name="selected_date" value="{{ $selectedDate }}">
                    <button type="submit"
                        class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition flex items-center">
                        <i class="fas fa-file-pdf mr-2"></i>Export PDF
                    </button>
                </form>
                
                <!-- <button onclick="printAttendanceReport()"
                    class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition flex items-center">
                    <i class="fas fa-print mr-2"></i>Print
                </button> -->
            </div>
        </div>

        <!-- Attendance Stats Summary -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-blue-100 p-4 rounded-xl shadow">
                <h3 class="text-lg font-semibold text-blue-700">Total Children</h3>
                <p class="text-2xl font-bold text-blue-900 mt-2">{{ $totalChildren }}</p>
            </div>
            <div class="bg-green-100 p-4 rounded-xl shadow">
                <h3 class="text-lg font-semibold text-green-700">Present</h3>
                <p class="text-2xl font-bold text-green-900 mt-2">{{ $presentCount }}</p>
            </div>
            <div class="bg-red-100 p-4 rounded-xl shadow">
                <h3 class="text-lg font-semibold text-red-700">Absent</h3>
                <p class="text-2xl font-bold text-red-900 mt-2">{{ $absentCount }}</p>
            </div>
            <div class="bg-yellow-50 p-4 rounded-xl shadow">
                <h3 class="text-lg font-semibold text-yellow-700">Attendance Rate</h3>
                <p class="text-2xl font-bold text-yellow-900 mt-2">{{ $attendanceRate }}%</p>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-xl p-6 print:shadow-none print:border print:border-gray-300">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-700">Attendance Summary</h2>
                    <select id="filterTypePie"
                        class="bg-white border border-gray-300 px-3 py-1.5 rounded-xl text-sm shadow-sm text-gray-600">
                        <option value="daily">Daily</option>
                        <option value="weekly" selected>Weekly</option>
                        <option value="monthly">Monthly</option>
                    </select>
                </div>
                <div class="relative h-80 flex items-center justify-center">
                    <canvas id="attendancePieChart" class="max-w-full max-h-[320px]"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-6 print:shadow-none print:border print:border-gray-300">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-700">Overtime Summary</h2>
                    <select id="filterTypeOvertime"
                        class="bg-white border border-gray-300 px-3 py-1.5 rounded-xl text-sm shadow-sm text-gray-600">
                        <option value="daily">Daily</option>
                        <option value="weekly" selected>Weekly</option>
                        <option value="monthly">Monthly</option>
                    </select>
                </div>
                <div class="relative h-80">
                    <canvas id="overtimeChart" class="w-full h-full max-h-[320px]"></canvas>
                </div>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="bg-white rounded-2xl shadow-xl p-6 print:shadow-none print:border print:border-gray-300" id="attendanceTable">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-700">Attendance Table ({{ $selectedDate }})</h2>
                <div class="text-sm text-gray-500">Total Records: {{ count($attendances) }}</div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto text-sm">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-left">
                        <tr>
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">Child Name</th>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Time In</th>
                            <th class="px-4 py-3">Time Out</th>
                            <th class="px-4 py-3">Overtime</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attendances as $index => $attendance)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 font-medium">{{ $attendance->child->child_name }}</td>
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($attendance->attendance_date)->format('M d, Y') }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $attendance->attendance_status === 'attend' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ ucfirst($attendance->attendance_status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @if($attendance->time_in)
                                    <span class="text-green-600 font-medium">
                                        {{ \Carbon\Carbon::parse($attendance->time_in)->format('g:i A') }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($attendance->time_out)
                                    <span class="text-blue-600 font-medium">
                                        {{ \Carbon\Carbon::parse($attendance->time_out)->format('g:i A') }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($attendance->attendance_overtime && $attendance->attendance_overtime > 0)
                                    <span class="text-red-600 font-bold">{{ $attendance->attendance_overtime }} min</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @if($attendances->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center py-8 text-gray-500">
                                <i class="fas fa-calendar-times text-4xl mb-2 block text-gray-300"></i>
                                No attendance data available for this date.
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
    @media print {
        .no-print,
        button,
        .flex.gap-2,
        nav,
        .sidebar,
        aside,
        [class*="sidebar"],
        [class*="nav"],
        [class*="menu"],
        form,
        input,
        select,
        .min-h-screen > div:first-child {
            display: none !important;
            visibility: hidden !important;
        }

        body {
            font-size: 12px !important;
            line-height: 1.4 !important;
            color: black !important;
            background: white !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .max-w-7xl {
            max-width: 100% !important;
            margin: 0 !important;
            padding: 10px !important;
            width: 100% !important;
        }

        @page {
            margin: 0.5in;
            size: A4;
        }

        .bg-gradient-to-r {
            background: white !important;
            border: 2px solid #333 !important;
            margin-bottom: 15px !important;
        }

        .grid.grid-cols-1.md\\:grid-cols-4 {
            display: table !important;
            width: 100% !important;
            page-break-inside: avoid;
            margin: 15px 0 !important;
        }

        .bg-blue-100, .bg-green-100, .bg-red-100, .bg-yellow-50 {
            display: table-cell !important;
            border: 1px solid #ccc !important;
            background: white !important;
            width: 25% !important;
            padding: 8px !important;
            text-align: center !important;
            vertical-align: top !important;
        }

        .bg-white.rounded-2xl.shadow-xl {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
            page-break-inside: avoid;
            margin: 15px 0 !important;
            border-radius: 0 !important;
        }

        table {
            border-collapse: collapse !important;
            width: 100% !important;
            font-size: 9px !important;
            margin-top: 10px !important;
        }

        th, td {
            border: 1px solid #333 !important;
            padding: 3px !important;
            text-align: left !important;
            word-wrap: break-word !important;
        }

        th {
            background-color: #f0f0f0 !important;
            font-weight: bold !important;
        }

        canvas {
            display: none !important;
        }

        .relative.h-80::after {
            content: "[Chart would appear here in PDF export]";
            display: block;
            text-align: center;
            padding: 40px;
            border: 1px dashed #ccc;
            color: #666;
            font-style: italic;
        }
    }
    </style>

    <!-- Chart.js and Font Awesome -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

    <!-- Chart Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Overtime Chart
        const overtimeCtx = document.getElementById('overtimeChart').getContext('2d');
        let overtimeChart;

        function renderOvertimeChart(type) {
            const data = overtimeData[type];
            const labels = data.map(d => d.label);
            const totals = data.map(d => Math.abs(d.total)); // Always positive

            if (overtimeChart) overtimeChart.destroy();
            overtimeChart = new Chart(overtimeCtx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Overtime (min)',
                        data: totals,
                        backgroundColor: '#3498db',
                        borderRadius: 10,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true },
                        x: { ticks: { autoSkip: true, maxTicksLimit: 12 } }
                    }
                }
            });
        }

        // Attendance Pie Chart
        const pieCtx = document.getElementById('attendancePieChart').getContext('2d');
        let pieChart;

        function renderPieChart(type) {
            let present = 0, absent = 0;
            if (type === 'daily') {
                const today = "{{ $selectedDate }}";
                attendanceData.daily.forEach(d => {
                    if (d.attendance_date === today) {
                        if (d.attendance_status === 'attend') present += d.total;
                        if (d.attendance_status === 'absent') absent += d.total;
                    }
                });
            } else if (type === 'weekly') {
                // Get current week
                const now = new Date("{{ $selectedDate }}");
                const year = now.getFullYear();
                const week = getWeekNumber(now);
                attendanceData.weekly.forEach(d => {
                    if (d.year == year && d.week == week) {
                        if (d.attendance_status === 'attend') present += d.total;
                        if (d.attendance_status === 'absent') absent += d.total;
                    }
                });
            } else if (type === 'monthly') {
                const month = "{{ \Carbon\Carbon::parse($selectedDate)->format('Y-m') }}";
                attendanceData.monthly.forEach(d => {
                    if (d.month === month) {
                        if (d.attendance_status === 'attend') present += d.total;
                        if (d.attendance_status === 'absent') absent += d.total;
                    }
                });
            }

            if (pieChart) pieChart.destroy();
            pieChart = new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Present', 'Absent'],
                    datasets: [{
                        data: [present, absent],
                        backgroundColor: ['#2ecc71', '#e74c3c'],
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        }

        // Helper to get ISO week number
        function getWeekNumber(date) {
            date = new Date(Date.UTC(date.getFullYear(), date.getMonth(), date.getDate()));
            const dayNum = date.getUTCDay() || 7;
            date.setUTCDate(date.getUTCDate() + 4 - dayNum);
            const yearStart = new Date(Date.UTC(date.getUTCFullYear(),0,1));
            return Math.ceil((((date - yearStart) / 86400000) + 1)/7);
        }

        // Event listeners
        document.getElementById('filterTypeOvertime').addEventListener('change', function () {
            renderOvertimeChart(this.value);
        });

        document.getElementById('filterTypePie').addEventListener('change', function () {
            renderPieChart(this.value);
        });

        // Initial render
        renderOvertimeChart('weekly');
        renderPieChart('weekly');
    });

    // Chart Capture for PDF Export
    document.querySelector('#attendanceChartForm').addEventListener('submit', function (e) {
        // Capture pie chart
        const pieCanvas = document.getElementById('attendancePieChart');
        if (pieCanvas) {
            const pieImageData = pieCanvas.toDataURL('image/png');
            document.getElementById('pieChartImageInput').value = pieImageData;
        }
        
        // Capture bar chart (overtime chart)
        const barCanvas = document.getElementById('overtimeChart');
        if (barCanvas) {
            const barImageData = barCanvas.toDataURL('image/png');
            document.getElementById('barChartImageInput').value = barImageData;
        }
    });

    // Print Function
    function printAttendanceReport() {
        const originalTitle = document.title;
        const selectedDate = "{{ $selectedDate }}";
        const dateFormatted = new Date(selectedDate).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        document.title = `Attendance Report - ${dateFormatted} - Taska Hikmah`;
        
        window.print();
        
        setTimeout(() => {
            document.title = originalTitle;
        }, 1000);
    }
    </script>

</x-app-layout>