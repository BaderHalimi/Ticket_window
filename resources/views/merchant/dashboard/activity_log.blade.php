@extends('merchant.layouts.app')
@section('content')

<div class="flex-1 p-8">
  @livewire('under-review')
  <div style="opacity: 1; transform: none;">
    <div class="space-y-8">
      <h2 class="text-3xl font-bold text-slate-800">---</h2>
      <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
        <div class="flex flex-col space-y-1.5 p-6">
          <h3 class="text-xl font-semibold leading-none tracking-tight">---</h3>
          <p class="text-sm text-slate-500">---</p>
        </div>
        <div class="p-6 pt-0">
          <div class="relative">
            <div class="absolute left-5 top-0 h-full w-0.5 bg-slate-200"></div>
            <div class="space-y-8">

              {{-- مثال للعنصر المعدل --}}
              <div class="flex items-start gap-4 relative">
                <div class="w-11 h-11 bg-orange-100 rounded-full flex items-center justify-center z-10 ring-4 ring-orange-200">
                  <svg class="w-5 h-5 text-orange-500" ...>...</svg>
                </div>
                <div class="flex-1 pt-2">
                  <div class="flex justify-between items-center">
                    <div>
                      <p class="font-semibold text-slate-800">--- 
                        <span class="font-normal text-slate-600">---</span></p>
                      <div class="flex items-center gap-2 text-sm text-slate-500 mt-1">
                        <span class="relative flex shrink-0 overflow-hidden rounded-full w-6 h-6">
                          <img class="aspect-square h-full w-full" src="...">
                        </span>
                        <span>---</span>
                      </div>
                    </div>
                    <p class="text-sm text-slate-400">---</p>
                  </div>
                </div>
              </div>

              {{-- كرر التعديل لباقي العناصر بنفس الطريقة --}}

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
