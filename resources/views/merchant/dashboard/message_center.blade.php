@extends('merchant.layouts.app')
@section('content')

@livewire('chat_center')
{{-- <div style="opacity: 1; transform: none;">
  @livewire('under-review')

  <div class="space-y-8">
    <h2 class="text-3xl font-bold text-slate-800">مركز الرسائل</h2>
    <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg h-[calc(100vh-12rem)] flex">
      
      <!-- القائمة الجانبية -->
      <div class="w-1/3 border-l p-4 flex flex-col">
        <div class="relative mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
               fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
               class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.3-4.3"></path>
          </svg>
          <input class="flex h-10 w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all pl-10" placeholder="بحث في المحادثات...">
        </div>

        <div class="flex-grow overflow-y-auto space-y-2">
          <div class="p-3 rounded-lg cursor-pointer flex items-start gap-3 bg-orange-100">
            <span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full">
              <img class="aspect-square h-full w-full" src="https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?q=80&amp;w=200">
            </span>
            <div class="flex-grow">
              <div class="flex justify-between items-center">
                <p class="font-semibold text-sm">فهد صالح</p>
                <p class="text-xs text-slate-400">10:30ص</p>
              </div>
              <div class="flex justify-between items-center mt-1">
                <p class="text-xs text-slate-500 truncate">مرحباً، هل يمكن تغيير موعد الحجز؟</p>
                <div class="w-5 h-5 bg-orange-500 text-white text-xs rounded-full flex items-center justify-center">2</div>
              </div>
            </div>
          </div>

          <div class="p-3 rounded-lg cursor-pointer flex items-start gap-3 hover:bg-slate-50">
            <span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full">
              <img class="aspect-square h-full w-full" src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?q=80&amp;w=200">
            </span>
            <div class="flex-grow">
              <div class="flex justify-between items-center">
                <p class="font-semibold text-sm">مجموعة شركات النمو</p>
                <p class="text-xs text-slate-400">9:15ص</p>
              </div>
              <div class="flex justify-between items-center mt-1">
                <p class="text-xs text-slate-500 truncate">شكرًا على الخدمة الممتازة!</p>
              </div>
            </div>
          </div>

          <div class="p-3 rounded-lg cursor-pointer flex items-start gap-3 hover:bg-slate-50">
            <span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full">
              <img class="aspect-square h-full w-full" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&amp;w=200">
            </span>
            <div class="flex-grow">
              <div class="flex justify-between items-center">
                <p class="font-semibold text-sm">سارة علي</p>
                <p class="text-xs text-slate-400">أمس</p>
              </div>
              <div class="flex justify-between items-center mt-1">
                <p class="text-xs text-slate-500 truncate">لدي استفسار بخصوص الفاتورة.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- الرسائل -->
      <div class="w-2/3 flex flex-col">
        <div class="p-4 border-b flex items-center gap-3">
          <span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full">
            <img class="aspect-square h-full w-full" src="https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?q=80&amp;w=200">
          </span>
          <div>
            <p class="font-bold">فهد صالح</p>
            <p class="text-xs text-green-500">متصل الآن</p>
          </div>
        </div>

        <div class="flex-grow p-6 overflow-y-auto bg-slate-50 space-y-6">
          <div class="flex justify-start">
            <div class="max-w-xs lg:max-w-md p-3 rounded-2xl bg-white rounded-bl-none shadow-sm">
              <p>مرحباً، هل يمكن تغيير موعد الحجز؟</p>
              <p class="text-xs mt-1 text-slate-400">10:30ص</p>
            </div>
          </div>

          <div class="flex justify-end">
            <div class="max-w-xs lg:max-w-md p-3 rounded-2xl bg-orange-500 text-white rounded-br-none">
              <p>أهلاً بك، بالتأكيد. ما هو الموعد الجديد الذي ترغب به؟</p>
              <p class="text-xs mt-1 text-white/70">10:31ص</p>
            </div>
          </div>
        </div>

        <div class="p-4 border-t bg-white flex items-center gap-2">
          <input class="flex h-10 w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all flex-grow" placeholder="اكتب رسالتك هنا...">
          <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 w-10">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="w-5 h-5">
              <path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l8.57-8.57A4 4 0 1 1 18 8.84l-8.59 8.57a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
            </svg>
          </button>
          <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-orange-500 hover:bg-orange-600 h-10 px-4 py-2 gradient-bg text-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="w-5 h-5">
              <path d="m22 2-7 20-4-9-9-4Z"></path>
              <path d="M22 2 11 13"></path>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</div> --}}

@endsection
