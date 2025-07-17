@extends('merchant.layouts.app')
@section('content')

<div class="flex-1 p-8">
  <div class="space-y-8">

    <!-- رأس الصفحة وزر التصدير -->
    <div class="flex justify-between items-center">
      <h2 class="text-3xl font-bold text-slate-800">التقارير والتحليلات</h2>
      <button class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-slate-300 bg-white hover:bg-orange-100 hover:text-orange-700 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 h-10 px-4 py-2">
        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
          <polyline points="7 10 12 15 17 10"></polyline>
          <line x1="12" x2="12" y1="15" y2="3"></line>
        </svg>
        تصدير الكل
      </button>
    </div>

    <!-- كروت الإحصائيات -->
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">

      <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
        <div class="flex flex-col space-y-1.5 p-6">
          <h3 class="text-xl font-semibold flex items-center gap-2">
            <svg class="lucide lucide-bar-chart2 w-5 h-5"></svg>
            إجمالي المبيعات
          </h3>
        </div>
        <div class="p-6 pt-0 text-3xl font-bold">{{ number_format($wallet->balance, 0, '.', ',') }} ريال</div>
      </div>

      <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
        <div class="flex flex-col space-y-1.5 p-6">
          <h3 class="text-xl font-semibold flex items-center gap-2">
            <svg class="lucide lucide-pie-chart w-5 h-5"></svg>
            نسبة الإلغاء
          </h3>
        </div>
        <div class="p-6 pt-0 text-3xl font-bold">

          {{ $refundPercent }}%
        </div>
      </div>

      <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
        <div class="flex flex-col space-y-1.5 p-6">
          <h3 class="text-xl font-semibold flex items-center gap-2">
            <svg class="lucide lucide-users w-5 h-5"></svg>
            الزوار الفعليون
          </h3>
        </div>
        <div class="p-6 pt-0 text-3xl font-bold">{{ number_format($views, 0, '.', ',') }}</div>
      </div>

      <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
        <div class="flex flex-col space-y-1.5 p-6">
          <h3 class="text-xl font-semibold flex items-center gap-2">
            <svg class="lucide lucide-calendar w-5 h-5"></svg>
            أوقات الذروة
          </h3>
        </div>
        <div class="p-6 pt-0 text-xl font-bold">
           @if($maxHour !== null)
           {{ \Carbon\Carbon::createFromTime($maxHour)->format('h A') }} - {{ $maxDay }}
           @else
            لا يوجد بيانات
          @endif
        </div>
      </div>

    </div>

    <!-- التقارير الرسومية -->
    <div class="grid lg:grid-cols-2 gap-6">

      <!-- تقرير المبيعات الشهري -->
      <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
        <div class="flex flex-col space-y-1.5 p-6">
            <h3 class="text-xl font-semibold leading-none">تقرير المبيعات الأسبوعي</h3>
            <p class="text-sm text-slate-500">نظرة على أداء المبيعات خلال الأيام الماضية.</p>
        </div>
        <div class="p-6 pt-0 h-72">
            <div id="weekly-sales-chart" class="w-full h-full"></div>
        </div>
    </div>

      <!-- أداء الفعاليات -->
      <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
        <div class="flex flex-col space-y-1.5 p-6">
          <h3 class="text-xl font-semibold leading-none">أداء الفعاليات</h3>
          <p class="text-sm text-slate-500">توزيع الحجوزات على الخدمات المختلفة.</p>
        </div>
        <div class="p-6 pt-0 h-72">
          <div class="w-full h-full relative">
            <div id="servicePieChart" class="w-full h-full"></div>
          </div>
        </div>
      </div>

      <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
        <div class="flex flex-col space-y-1.5 p-6">
          <h3 class="text-xl font-semibold leading-none">أداء الفعاليات</h3>
          <p class="text-sm text-slate-500">توزيع الحجوزات على الخدمات المختلفة.</p>
        </div>
        <div class="p-6 pt-0 h-72">
          <div class="w-full h-full relative">
              <div id="donutChart"  class="w-full h-full"></div>
          </div>
        </div>
      </div>



  </div>

  <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
    <div class="flex flex-col space-y-1.5 p-6">
      <h3 class="text-xl font-semibold leading-none">أداء الفعاليات</h3>
      <p class="text-sm text-slate-500">توزيع الحجوزات على الخدمات المختلفة.</p>
    </div>
    <div class="p-6 pt-0 h-72">
      <div class="w-full h-full relative">
        <div id="sales_chart"  class="w-full h-full"></div>
      </div>
    </div>
  </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
<script>
  const offersPercent = @json($offersPercent);
  //const peak_time  = @json($Peak_Time);
</script>
<script>
    const chart = echarts.init(document.getElementById('servicePieChart'));

    const offersData = offersPercent.map(item => {
        return {
            name: item.offer?.name ?? 'بدون اسم',
            value: item.percentage

        };
    });

    const option1 = {
        title: {
            text: 'توزيع الحجوزات',
            left: 'center'
        },
        tooltip: {
            trigger: 'item'
        },
        legend: {
            bottom: 10,
            left: 'center'
        },
        series: [
            {
                name: 'الخدمة',
                type: 'pie',
                radius: '60%',
                data: offersData,
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                },
                label: {
                    formatter: '{b}: {d}%' // {b} = الاسم، {d} = النسبة
                }
            }
        ]
    };

    chart.setOption(option1);
</script>

<script>
  const salesData = @json(array_values($sells_day));
  const dayLabels = @json(array_keys($sells_day));

  const chartDom = document.getElementById('weekly-sales-chart');
  const myChart = echarts.init(chartDom);

  const option2 = {
      tooltip: {
          trigger: 'axis'
      },
      xAxis: {
          type: 'category',
          data: dayLabels
      },
      yAxis: {
          type: 'value'
      },
      series: [{
          data: salesData,
          type: 'bar',
          itemStyle: {
              color: '#3b82f6',
              borderRadius: [4, 4, 0, 0]
          }
      }]
  };

  myChart.setOption(option2);
</script>

<script>
const donutChartDom = document.getElementById('donutChart');
const donutChart = echarts.init(donutChartDom);

  const Pay = @json($PayPercent);
  const refund = @json($refundPercent);
  const allPayments = @json($all_payments);
  const allRefunds = @json($all_refunds);
  const option3 = {
      title: {
          text: 'الإحصائيات',
          left: 'center'
      },
      tooltip: {
          trigger: 'item'
      },
      legend: {
          orient: 'vertical',
          left: 'left'
      },
      series: [
          {
              name: 'البيانات',
              type: 'pie',
              radius: ['40%', '70%'], // Donut
              avoidLabelOverlap: false,
              label: {
                  show: true,
                  formatter: '{b}: {d}%',
                  fontSize: 10
              },
              labelLine: {
                  show: true
              },
              data: [
                {
                    value: refund,
                    name: `الإلغاءات ${allRefunds}`
                },
                {
                    value: Pay,
                    name: `المدفوعات التامة ${allPayments}`
                }
            ]

          }
      ]
  };

  donutChart.setOption(option3);
</script>

<script>
  const peak_time = {!! json_encode($Peak_Time) !!}; // تم تمريره من PHP
  const data = [];

  for (const day in peak_time) {
      for (let hour = 0; hour < 24; hour++) {
          const sales = peak_time[day][hour];
          if (sales > 0) {
              data.push({
                  name: `${day} - ${hour}`,
                  value: [ `${day} ${hour}:00`, sales ]
              });
          }
      }
  }

  const chartDom4 = document.getElementById('sales_chart');
  const myChart4 = echarts.init(chartDom4);
  const option = {
      title: {
          text: 'مبيعات حسب الساعة خلال الأسبوع'
      },
      tooltip: {
          trigger: 'axis'
      },
      toolbox: {
          feature: {
              dataZoom: {
                  yAxisIndex: 'none'
              },
              restore: {},
              saveAsImage: {}
          }
      },
      dataZoom: [
          {
              type: 'slider',
              start: 0,
              end: 100
          },
          {
              type: 'inside'
          }
      ],
      xAxis: {
          type: 'category',
          data: data.map(d => d.value[0]),
          name: 'اليوم - الساعة',
          axisLabel: {
              rotate: 45
          }
      },
      yAxis: {
          type: 'value',
          name: 'عدد المبيعات'
      },
      series: [{
          data: data.map(d => d.value[1]),
          type: 'line',
          smooth: true,
          symbolSize: 8,
          lineStyle: {
              width: 3
          }
      }]
  };

  myChart4.setOption(option);
</script>

@endsection



