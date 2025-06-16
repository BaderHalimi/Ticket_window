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
            <svg class="lucide lucide-bar-chart2 w-5 h-5" ...></svg>
            إجمالي المبيعات
          </h3>
        </div>
        <div class="p-6 pt-0 text-3xl font-bold">45,231 ريال</div>
      </div>

      <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
        <div class="flex flex-col space-y-1.5 p-6">
          <h3 class="text-xl font-semibold flex items-center gap-2">
            <svg class="lucide lucide-pie-chart w-5 h-5" ...></svg>
            نسبة الإلغاء
          </h3>
        </div>
        <div class="p-6 pt-0 text-3xl font-bold">5.4%</div>
      </div>

      <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
        <div class="flex flex-col space-y-1.5 p-6">
          <h3 class="text-xl font-semibold flex items-center gap-2">
            <svg class="lucide lucide-users w-5 h-5" ...></svg>
            الزوار الفعليون
          </h3>
        </div>
        <div class="p-6 pt-0 text-3xl font-bold">1,890</div>
      </div>

      <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
        <div class="flex flex-col space-y-1.5 p-6">
          <h3 class="text-xl font-semibold flex items-center gap-2">
            <svg class="lucide lucide-calendar w-5 h-5" ...></svg>
            أوقات الذروة
          </h3>
        </div>
        <div class="p-6 pt-0 text-xl font-bold">الخميس - 8 مساءً</div>
      </div>

    </div>

    <!-- التقارير الرسومية -->
    <div class="grid lg:grid-cols-2 gap-6">

      <!-- تقرير المبيعات الشهري -->
      <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
        <div class="flex flex-col space-y-1.5 p-6">
          <h3 class="text-xl font-semibold leading-none">تقرير المبيعات الشهري</h3>
          <p class="text-sm text-slate-500">نظرة على أداء المبيعات خلال الأشهر الماضية.</p>
        </div>
        <div class="p-6 pt-0 h-72">
          {{-- استبدل هذا بسكربت الرسم البياني الحقيقي --}}
          <div class="w-full h-full flex items-center justify-center text-slate-400">
            <span>📊 سيتم عرض الرسم البياني هنا</span>
          </div>
        </div>
      </div>

      <!-- أداء الفعاليات -->
      <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
        <div class="flex flex-col space-y-1.5 p-6">
          <h3 class="text-xl font-semibold leading-none">أداء الفعاليات</h3>
          <p class="text-sm text-slate-500">توزيع الحجوزات على الخدمات المختلفة.</p>
        </div>
        <div class="p-6 pt-0 h-72">
          {{-- استبدل هذا بالرسم البياني الدائري الفعلي --}}
          <div class="w-full h-full flex items-center justify-center text-slate-400">
            <span>🥧 سيتم عرض الرسم البياني هنا</span>
          </div>
        </div>
      </div>

    </div>

  </div>
</div>

@endsection
