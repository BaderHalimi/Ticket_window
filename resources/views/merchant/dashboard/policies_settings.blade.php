@extends('merchant.layouts.app')
@section('content')

<div class="flex-1 p-8">
  <div class="space-y-8">
    <div class="flex justify-between items-center">
      <h2 class="text-3xl font-bold text-slate-800">السياسات والإعدادات</h2>
      <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-orange-500 hover:bg-orange-600 h-10 px-4 py-2 text-white">
        <svg class="w-4 h-4 ml-2" ...></svg>
        حفظ الإعدادات
      </button>
    </div>

    <!-- سياسة الإلغاء -->
    <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
      <div class="flex flex-col space-y-1.5 p-6">
        <h3 class="text-xl font-semibold tracking-tight flex items-center gap-2">
          <svg class="lucide lucide-file-text" ...></svg>
          سياسة الإلغاء والاسترجاع
        </h3>
        <p class="text-sm text-slate-500">حدد الشروط التي يمكن للعملاء بموجبها إلغاء حجوزاتهم واسترداد أموالهم.</p>
      </div>
      <div class="p-6 pt-0 space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2" for="cancellation-policy">نص السياسة</label>
          <textarea id="cancellation-policy" class="w-full rounded-md border bg-white px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 mt-2 min-h-[120px]" placeholder="مثال: لا يمكن استرجاع المبلغ قبل 24 ساعة من موعد الفعالية..."></textarea>
        </div>
        <div class="flex items-center space-x-2 space-x-reverse">
          <button type="button" role="checkbox" aria-checked="false" data-state="unchecked" value="on" id="allow-refund"
            class="peer h-4 w-4 shrink-0 rounded-sm border border-orange-500 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-orange-500 text-white">
          </button>
          <label for="allow-refund" class="block text-sm font-medium text-gray-700 mb-2">السماح بالاسترجاع التلقائي وفقًا للشروط</label>
        </div>
      </div>
    </div>

    <!-- إعدادات الدفع -->
    <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
      <div class="flex flex-col space-y-1.5 p-6">
        <h3 class="text-xl font-semibold tracking-tight flex items-center gap-2">
          <svg class="lucide lucide-credit-card" ...></svg>
          إعدادات الدفع
        </h3>
        <p class="text-sm text-slate-500">اختر وسائل الدفع التي ترغب في توفيرها لعملائك.</p>
      </div>
      <div class="p-6 pt-0 space-y-4">

        @php
          $payments = [
            ['id' => 'visa-mastercard', 'label' => 'بطاقات فيزا وماستركارد'],
            ['id' => 'mada', 'label' => 'مدى'],
            ['id' => 'apple-pay', 'label' => 'Apple Pay'],
            ['id' => 'stc-pay', 'label' => 'STC Pay', 'checked' => false],
          ];
        @endphp

        @foreach ($payments as $payment)
        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
          <label for="{{ $payment['id'] }}" class="block text-sm font-medium text-gray-700 mb-2">{{ $payment['label'] }}</label>
          <button type="button" role="checkbox"
            aria-checked="{{ $payment['checked'] ?? true ? 'true' : 'false' }}"
            data-state="{{ $payment['checked'] ?? true ? 'checked' : 'unchecked' }}"
            value="on" id="{{ $payment['id'] }}"
            class="peer h-4 w-4 shrink-0 rounded-sm border border-orange-500 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-orange-500 text-white">
            @if (($payment['checked'] ?? true) === true)
              <span data-state="checked" class="flex items-center justify-center text-current">
                <svg class="h-4 w-4" ...></svg>
              </span>
            @endif
          </button>
        </div>
        @endforeach

      </div>
    </div>
  </div>
</div>

@endsection
