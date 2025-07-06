<div class="max-w-7xl mx-auto px-4 py-10 space-y-12 bg-gray-50">
    <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">📊 لوحة التقارير والتحليلات</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 text-center">
            <h3 class="text-xl font-semibold mb-3">📈 صافي المبيعات</h3>
            <p class="text-3xl font-bold text-green-600">{{ number_format($netSales, 0) }} ريال</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 text-center">
            <h3 class="text-xl font-semibold mb-3">✅ إجمالي الدفع</h3>
            <p class="text-3xl font-bold text-blue-600">{{ number_format($totalPay, 0) }} ريال</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 text-center">
            <h3 class="text-xl font-semibold mb-3">🔁 إجمالي الاسترداد</h3>
            <p class="text-3xl font-bold text-red-600">{{ number_format($totalRefund, 0) }} ريال</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 text-center">
            <h3 class="text-xl font-semibold mb-3">💸 خسائر القسائم</h3>
            <p class="text-3xl font-bold text-yellow-500">{{ number_format($couponLoss, 0) }} ريال</p>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-12">

        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
            <h3 class="text-xl font-semibold mb-3">مبيعات حسب المنتج</h3>
            <canvas id="productChart"></canvas>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
            <h3 class="text-xl font-semibold mb-3">طرق الدفع</h3>
            <canvas id="paymentChart"></canvas>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
            <h3 class="text-xl font-semibold mb-3">الحالة</h3>
            <canvas id="statusChart"></canvas>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
            <h3 class="text-xl font-semibold mb-3">أفضل 5 عملاء</h3>
            <canvas id="usersChart"></canvas>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 col-span-full">
            <h3 class="text-xl font-semibold mb-3">المبيعات اليومية</h3>
            <canvas id="dailyChart"></canvas>
        </div>
    </div>
</div>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const colors = ['#F97316', '#FACC15', '#34D399', '#60A5FA', '#A78BFA', '#F472B6', '#FB923C'];

    new Chart(document.getElementById('productChart'), {
        type: 'bar',
        data: {
            labels: @json($salesByProduct->keys()),
            datasets: [{
                label: 'ريال',
                data: @json($salesByProduct->values()),
                backgroundColor: colors
            }]
        },
        options: { plugins: { legend: { display: false } } }
    });

    new Chart(document.getElementById('paymentChart'), {
        type: 'doughnut',
        data: {
            labels: @json($countByPaymentMethod->keys()),
            datasets: [{
                data: @json($countByPaymentMethod->values()),
                backgroundColor: colors
            }]
        }
    });

    new Chart(document.getElementById('statusChart'), {
        type: 'pie',
        data: {
            labels: @json($countByStatus->keys()),
            datasets: [{
                data: @json($countByStatus->values()),
                backgroundColor: colors
            }]
        }
    });

    new Chart(document.getElementById('usersChart'), {
        type: 'bar',
        data: {
            labels: @json($topUsers->keys()),
            datasets: [{
                label: 'ريال',
                data: @json($topUsers->values()),
                backgroundColor: colors
            }]
        },
        options: { plugins: { legend: { display: false } } }
    });

    const dailyLabels = @json($dailySales->keys());
    const dailyData = @json($dailySales->values()->map(fn($d) => $d['total']));
    const dailyNotes = @json($dailySales->values()->map(fn($d) => implode(' - ', $d['notes'])));

    new Chart(document.getElementById('dailyChart'), {
        type: 'bar',
        data: {
            labels: dailyLabels,
            datasets: [{
                label: 'ريال',
                data: dailyData,
                backgroundColor: '#60A5FA'
            }]
        },
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        afterBody: function(context) {
                            let idx = context[0].dataIndex;
                            return dailyNotes[idx] ? 'ملاحظات: ' + dailyNotes[idx] : '';
                        }
                    }
                }
            },
            scales: { y: { beginAtZero: true } }
        }
    });
});
</script>
@endpush
