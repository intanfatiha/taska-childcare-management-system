<x-app-layout>
    
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 bg-gradient-to-r from-indigo-50 to-purple-100 p-6 rounded-lg shadow-sm">
            <h2 class="text-3xl font-bold text-indigo-800">{{ __('Payment Report') }}</h2>
        </div>

        <!-- Filter & Buttons Section -->
        <div class="flex flex-wrap justify-between items-end mb-6 gap-4">
            <!-- Filter Form --> 
            <form method="GET" action="{{ route('payment.report') }}" class="flex items-center gap-4">
                <div>
                    <label for="selected_date" class="block text-sm font-medium text-gray-700 mb-1">Select Date:</label>
                    <input type="date" id="selected_date" name="selected_date" value="{{ $selectedDate }}"
                        class="border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                
                <!-- View Type Toggle -->
                <div>
                    <label for="view_type" class="block text-sm font-medium text-gray-700 mb-1">View:</label>
                    <select name="view_type" id="view_type" class="border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="month" {{ request('view_type', 'month') === 'month' ? 'selected' : '' }}>Monthly View</option>
                        <option value="day" {{ request('view_type') === 'day' ? 'selected' : '' }}>Daily View</option>
                    </select>
                </div>
                
                <button type="submit"
                    class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition mt-1 ">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </form>

            <!-- Export/Print Buttons -->
            <div class="flex gap-2">
                <!-- Export PDF Form (with chart image and filter type) -->
                <form id="chartImageForm" action="{{ route('generateReports.export.pdf') }}" method="POST">
                    @csrf
                    <input type="hidden" name="chartImage" id="chartImageInput">
                    <input type="hidden" name="selected_date" value="{{ $selectedDate }}">
                    <input type="hidden" name="view_type" value="{{ request('view_type', 'month') }}">
                    <input type="hidden" name="chart_filter" id="chartFilterInput" value="monthly">
                    <button type="submit"
                        class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition flex items-center">
                        <i class="fas fa-file-pdf mr-2"></i>Export PDF
                    </button>
                </form>

                <!-- <button onclick="printDashboard()"
                    class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition flex items-center">
                    <i class="fas fa-print mr-2"></i>Print
                </button> -->
            </div>
        </div>
<!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-green-100 p-4 rounded-xl shadow">
                <h3 class="text-lg font-semibold text-green-700">
                    Total Collected
                    @if(request('view_type') === 'day')
                        <small class="block text-xs text-green-600 mt-1">{{ \Carbon\Carbon::parse($selectedDate)->format('M j, Y') }}</small>
                    @else
                        <small class="block text-xs text-green-600 mt-1">{{ \Carbon\Carbon::parse($selectedDate)->format('F Y') }}</small>
                    @endif
                </h3>
                <p class="text-2xl font-bold text-green-900 mt-2">RM {{ number_format($totalCollected, 2) }}</p>
            </div>
            <div class="bg-blue-100 p-4 rounded-xl shadow">
                <h3 class="text-lg font-semibold text-blue-700">
                    Paid
                    @if(request('view_type') === 'day')
                        <small class="block text-xs text-blue-600 mt-1">{{ \Carbon\Carbon::parse($selectedDate)->format('M j, Y') }}</small>
                    @else
                        <small class="block text-xs text-blue-600 mt-1">{{ \Carbon\Carbon::parse($selectedDate)->format('F Y') }}</small>
                    @endif
                </h3>
                <p class="text-2xl font-bold text-blue-900 mt-2">{{ $paidCount }}</p>
            </div>
            <div class="bg-yellow-100 p-4 rounded-xl shadow">
                <h3 class="text-lg font-semibold text-yellow-700">
                    Unpaid
                    @if(request('view_type') === 'day')
                        <small class="block text-xs text-yellow-600 mt-1">{{ \Carbon\Carbon::parse($selectedDate)->format('M j, Y') }}</small>
                    @else
                        <small class="block text-xs text-yellow-600 mt-1">{{ \Carbon\Carbon::parse($selectedDate)->format('F Y') }}</small>
                    @endif
                </h3>
                <p class="text-2xl font-bold text-yellow-900 mt-2">{{ $unpaidCount }}</p>
            </div>
            <div class="bg-red-100 p-4 rounded-xl shadow">
                <h3 class="text-lg font-semibold text-red-700">
                    Overdue
                    @if(request('view_type') === 'day')
                        <small class="block text-xs text-red-600 mt-1">{{ \Carbon\Carbon::parse($selectedDate)->format('M j, Y') }}</small>
                    @else
                        <small class="block text-xs text-red-600 mt-1">{{ \Carbon\Carbon::parse($selectedDate)->format('F Y') }}</small>
                    @endif
                </h3>
                <p class="text-2xl font-bold text-red-900 mt-2">{{ $overdueCount }}</p>
            </div>
        </div>

        <!-- Chart Section -->
        <script>
            const paymentTrend = {
                monthly: @json($monthlyTrend),
                weekly: @json($weeklyTrend),
                daily: @json($dailyTrend)
            };
        </script>
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-700">Payment Trend</h2>
                <select id="filterTypePayment"
                    class="bg-white border border-gray-300 px-3 py-1.5 rounded-xl text-sm shadow-sm text-gray-600">
                    <option value="monthly" selected>Monthly</option>
                    <option value="weekly">Weekly</option>
                    <option value="daily">Daily</option>
                </select>
            </div>
            <div class="relative h-80">
                <canvas id="paymentTrendChart" class="w-full h-full max-h-[320px]"></canvas>
            </div>
        </div>

        <!-- Payment Table -->
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-700">
                    Payment Table - 
                    @if(request('view_type') === 'day')
                        {{ \Carbon\Carbon::parse($selectedDate)->format('F j, Y') }}
                    @else
                        {{ \Carbon\Carbon::parse($selectedDate)->format('F Y') }}
                    @endif
                </h2>
                <div class="text-sm text-gray-500">Total Records: {{ $payments->count() }}</div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2 text-left">Children Name</th>
                            <th class="border px-4 py-2 text-left">Parent Name</th>
                            <th class="border px-4 py-2 text-left">Payment Amount</th>
                            <th class="border px-4 py-2 text-left">Created At</th>
                            <th class="border px-4 py-2 text-left">Due Date</th>
                            <th class="border px-4 py-2 text-left">Payment Date</th>
                            <th class="border px-4 py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td class="border px-4 py-2">{{ $payment->child->child_name ?? '-' }}</td>
                                <td class="border px-4 py-2">
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
                                <td class="border px-4 py-2">RM {{ number_format($payment->payment_amount, 2) }}</td>
                               <td class="border px-4 py-2">{{ $payment->created_at->format('d/m/Y') }}</td>


                                <td class="border px-4 py-2">
                                    {{ \Carbon\Carbon::parse($payment->payment_duedate)->format('d/m/Y') }}
                                </td>
                                <td class="border px-4 py-2">
                                    @if ($payment->paymentByParents_date)
                                        {{ \Carbon\Carbon::parse($payment->paymentByParents_date)->format('d/m/Y') }}
                                    @else
                                        <span class="text-red-500 font-semibold">Not paid yet</span>
                                    @endif
                                </td>
                                <td class="border px-4 py-2">
                                    @if($payment->payment_status === 'Complete')
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded">{{ $payment->payment_status }}</span>
                                    @elseif($payment->payment_status === 'Overdue')
                                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded">{{ $payment->payment_status }}</span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded">{{ $payment->payment_status }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-500">
                                    <i class="fas fa-money-bill-wave text-4xl mb-2 block text-gray-300"></i>
                                    No payment data available for the selected period.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterSelect = document.getElementById('filterTypePayment');
            const chartFilterInput = document.getElementById('chartFilterInput');
            const trendCtx = document.getElementById('paymentTrendChart').getContext('2d');
            let trendChart;

            function renderTrendChart(type) {
                let labels = [];
                let data = [];
                if (type === 'monthly') {
                    labels = paymentTrend.monthly.map(d => d.period);
                    data = paymentTrend.monthly.map(d => d.total);
                } else if (type === 'weekly') {
                    labels = paymentTrend.weekly.map(d => d.year + '-W' + d.week);
                    data = paymentTrend.weekly.map(d => d.total);
                } else {
                    labels = paymentTrend.daily.map(d => d.period);
                    data = paymentTrend.daily.map(d => d.total);
                }

                if (trendChart) trendChart.destroy();
                trendChart = new Chart(trendCtx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Payments Made',
                            data: data,
                            backgroundColor: '#6366f1',
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

                // Update hidden input with current filter for PDF export
                chartFilterInput.value = type;
            }

            filterSelect.addEventListener('change', function () {
                renderTrendChart(this.value);
            });

            renderTrendChart('monthly');
        });
    </script>

    <!-- Capture Chart as Base64 and Submit -->
    <script>
        document.querySelector('#chartImageForm').addEventListener('submit', function (e) {
            const chartCanvas = document.getElementById('paymentTrendChart');
            const imageData = chartCanvas.toDataURL('image/png');
            document.getElementById('chartImageInput').value = imageData;
        });

        function printDashboard() {
            window.print();
        }
    </script>
</x-app-layout>