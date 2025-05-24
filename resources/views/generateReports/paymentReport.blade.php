<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 bg-gradient-to-r from-indigo-50 to-purple-100 p-6 rounded-lg shadow-sm">
            <div>
                <h2 class="text-3xl font-bold text-indigo-800">
                    {{ __('Payment Report') }}
                </h2>
            </div>
        </div>

        <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
        <form method="GET" action="{{ route('attendance.report') }}" class="flex items-center gap-4">
            

        <!-- PDF Export Button -->
        <div class="flex gap-2">
            <a href=""
                class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition flex items-center">
                <i class="fas fa-file-pdf mr-2"></i>Export PDF
            </a>
            <button onclick="printDashboard()"
                class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition flex items-center">
                <i class="fas fa-print mr-2"></i>Print
            </button>
        </div>
    </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-green-100 p-4 rounded-xl shadow">
                <h3 class="text-lg font-semibold text-green-700">Total Collected</h3>
                <p class="text-2xl font-bold text-green-900 mt-2">RM {{ number_format($totalCollected, 2) }}</p>
            </div>
            <div class="bg-blue-100 p-4 rounded-xl shadow">
                <h3 class="text-lg font-semibold text-blue-700">Paid</h3>
                <p class="text-2xl font-bold text-blue-900 mt-2">{{ $paidCount }}</p>
            </div>
            <div class="bg-yellow-100 p-4 rounded-xl shadow">
                <h3 class="text-lg font-semibold text-yellow-700">Unpaid</h3>
                <p class="text-2xl font-bold text-yellow-900 mt-2">{{ $unpaidCount }}</p>
            </div>
            <div class="bg-red-100 p-4 rounded-xl shadow">
                <h3 class="text-lg font-semibold text-red-700">Overdue</h3>
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
                <h2 class="text-xl font-semibold text-gray-700">Payment Table</h2>
                <div class="text-sm text-gray-500">Total Records: {{ $payments->count() }}</div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2 text-left">Children Name</th>
                            <th class="border px-4 py-2 text-left">Parent Name</th>
                            <th class="border px-4 py-2 text-left">Payment Amount</th>
                            <th class="border px-4 py-2 text-left">Payment Date</th>
                            <th class="border px-4 py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td class="border px-4 py-2">{{ $payment->child->child_name ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $payment->parent->parent_name ?? '-' }}</td>
                                <td class="border px-4 py-2">RM {{ number_format($payment->payment_amount, 2) }}</td>
                                <td class="border px-4 py-2">{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d') : '-' }}</td>
                                <td class="border px-4 py-2">
                                    @if($payment->status === 'Paid')
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded">{{ $payment->status }}</span>
                                    @elseif($payment->status === 'Overdue')
                                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded">{{ $payment->status }}</span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded">{{ $payment->status }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-gray-500">
                                    <i class="fas fa-money-bill-wave text-4xl mb-2 block text-gray-300"></i>
                                    No payment data available.
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
        }

        document.getElementById('filterTypePayment').addEventListener('change', function () {
            renderTrendChart(this.value);
        });

        renderTrendChart('monthly');
    });
    </script>
</x-app-layout>