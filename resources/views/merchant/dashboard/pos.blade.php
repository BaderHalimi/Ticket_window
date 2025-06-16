@extends('merchant.layouts.app')
@section('content')

<div class="flex-1 p-8">
  <div class="space-y-8">
    <div class="flex justify-between items-center">
      <h2 class="text-3xl font-bold text-slate-800">البيع الداخلي (POS)</h2>
    </div>

    <div dir="rtl">
      <!-- التبويبات -->
      <div role="tablist" class="grid grid-cols-2 h-10 rounded-md bg-muted p-1 text-muted-foreground">
        <button type="button" role="tab" aria-selected="true" class="flex items-center gap-2 justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 data-[state=active]:bg-white data-[state=active]:text-black data-[state=active]:shadow-sm">
          <svg class="h-4 w-4" ...></svg>
          إنشاء حجز يدوي
        </button>
        <button type="button" role="tab" aria-selected="false" class="flex items-center gap-2 justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2">
          <svg class="h-4 w-4" ...></svg>
          قائمة الحجوزات الداخلية
        </button>
      </div>

      <!-- محتوى التبويب -->
      <div class="mt-6 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 pt-6">
        <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
          <div class="flex flex-col space-y-1.5 p-6">
            <h3 class="text-xl font-semibold leading-none tracking-tight">إنشاء حجز جديد</h3>
            <p class="text-sm text-slate-500">أدخل تفاصيل الحجز للعميل الذي يقوم بالدفع من المقر.</p>
          </div>

          <div class="p-6 pt-0 space-y-6">

            <div class="grid md:grid-cols-2 gap-6">
              <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">نوع الخدمة</label>
                <button type="button" class="flex h-10 w-full items-center justify-between rounded-md border bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                  <span>اختر نوع الخدمة...</span>
                  <svg class="h-4 w-4 opacity-50" ...></svg>
                </button>
              </div>

              <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">العنصر المحدد</label>
                <button type="button" class="flex h-10 w-full items-center justify-between rounded-md border bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                  <span>اختر العنصر...</span>
                  <svg class="h-4 w-4 opacity-50" ...></svg>
                </button>
              </div>
            </div>

            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700 mb-2" for="tickets">عدد التذاكر / الأشخاص</label>
              <input type="number" class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent" id="tickets" placeholder="1" value="1">
            </div>

            <div class="grid md:grid-cols-2 gap-6">
              <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700 mb-2" for="customerName">اسم العميل (اختياري)</label>
                <div class="relative">
                  <svg class="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" ...></svg>
                  <input class="w-full rounded-lg border border-slate-300 px-4 py-3 pr-10 text-sm focus:ring-2 focus:ring-orange-500" id="customerName" placeholder="مثال: خالد محمد">
                </div>
              </div>

              <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700 mb-2" for="customerPhone">رقم الجوال</label>
                <div class="relative">
                  <svg class="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" ...></svg>
                  <input class="w-full rounded-lg border border-slate-300 px-4 py-3 pr-10 text-sm focus:ring-2 focus:ring-orange-500" id="customerPhone" placeholder="05xxxxxxxx">
                </div>
              </div>
            </div>

            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700 mb-2" for="customerEmail">البريد الإلكتروني (اختياري)</label>
              <div class="relative">
                <svg class="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" ...></svg>
                <input type="email" class="w-full rounded-lg border border-slate-300 px-4 py-3 pr-10 text-sm focus:ring-2 focus:ring-orange-500" id="customerEmail" placeholder="email@example.com">
              </div>
            </div>

            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700 mb-2">وسيلة الدفع</label>
              <button type="button" class="flex h-10 w-full items-center justify-between rounded-md border bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                <span>💵 نقدًا</span>
                <svg class="h-4 w-4 opacity-50" ...></svg>
              </button>
            </div>

            <button class="inline-flex items-center justify-center text-sm font-medium bg-orange-500 hover:bg-orange-600 text-white rounded-md h-11 px-8 w-full focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2">
              <svg class="w-5 h-5 ml-2" ...></svg>
              إنشاء الحجز وطباعة التذكرة
            </button>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
