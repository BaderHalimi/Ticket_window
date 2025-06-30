@extends('merchant.layouts.app')

@section('content')
<div class="flex-1 p-8">
  
  <div class="space-y-8">
    <h2 class="text-3xl font-bold text-slate-800">المحفظة المالية والسحب</h2>

    <div class="grid md:grid-cols-3 gap-6">

      {{-- المسحوبات المعالجة --}}
      <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-xl hover:shadow-2xl transition">
        <div class="flex flex-col space-y-2 p-6">
          <h3 class="text-xl font-semibold tracking-tight text-orange-600">المسحوبات المعالجة</h3>
          <div class="text-4xl font-bold text-slate-900 mt-2">{{ number_format($checkedTotal, 2) }} ريال</div>
          <p class="text-sm text-slate-500 mt-1">المبالغ التي تم صرفها بعد الموافقة.</p>
        </div>
      </div>

      {{-- الرصيد القابل للسحب (أهم بطاقة في الوسط) --}}
      <div class="rounded-2xl border-2 border-orange-400 bg-white text-slate-900 shadow-2xl hover:shadow-3xl transition transform hover:scale-105">
        <div class="flex flex-col space-y-2 p-6">
          <h3 class="text-xl font-bold tracking-tight text-orange-700">الرصيد القابل للسحب</h3>
          <div class="text-5xl font-extrabold text-slate-900 mt-2">{{ number_format($netTotal, 2) }} ريال</div>
          <p class="text-sm text-slate-500 mt-1">رصيدك المتاح حاليا للسحب.</p>

          {{-- زر طلب السحب --}}
          @if ($netTotal > 0)

          <form action="{{route("merchant.dashboard.withdraws.store")}}" method="POST" class="mt-4">
            @csrf
            <input type="hidden" name="transaction_ids" value="{{ $pendingReservations }}">
            <input type="hidden" name="amount" value="{{ $netTotal }}">

            <button type="submit" class="w-full inline-flex items-center justify-center rounded-lg bg-gradient-to-r from-orange-400 to-orange-600 text-white text-base font-bold py-3 shadow-lg hover:from-orange-500 hover:to-orange-700 focus:ring-4 focus:ring-orange-300 transition">
              <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"></path>
              </svg>
              طلب سحب
            </button>
          </form>
          @endif

        </div>
      </div>

      {{-- الرصيد الملغي / المحجوز --}}
      <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-xl hover:shadow-2xl transition">
        <div class="flex flex-col space-y-2 p-6">
          <h3 class="text-xl font-semibold tracking-tight text-orange-600">الرصيد الملغي / المحجوز</h3>
          <div class="text-4xl font-bold text-slate-900 mt-2">{{ number_format($cancelledTotal, 2) }} ريال</div>
          <p class="text-sm text-slate-500 mt-1">رصيد غير متاح حاليا للسحب.</p>
        </div>
      </div>

    </div>

    {{-- سجل عمليات السحب (اختياري) --}}
{{-- سجل عمليات السحب --}}
<div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-xl mt-8 overflow-x-auto">
    <div class="flex justify-between items-center p-6 border-b border-slate-200 bg-gradient-to-r from-orange-50 to-white">
      <h3 class="text-xl font-semibold tracking-tight text-orange-600">سجل عمليات السحب</h3>
    </div>
  
    @if($withdraws->isEmpty())
      <div class="p-6 text-slate-500 text-center">
        لا توجد عمليات سحب سابقة حتى الآن.
      </div>
    @else
      <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-orange-50">
          <tr>
            <th class="px-6 py-3 text-right text-xs font-medium text-orange-800 uppercase tracking-wider">معرّف السحب</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-orange-800 uppercase tracking-wider">المستخدم</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-orange-800 uppercase tracking-wider">المبلغ (ريال)</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-orange-800 uppercase tracking-wider">الحالة</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-orange-800 uppercase tracking-wider">التاريخ</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-slate-200">
          @foreach($withdraws as $withdraw)
            <tr class="hover:bg-orange-50 transition">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-slate-700">{{ $withdraw->withdraw_id }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                {{ $withdraw->user->f_name ?? 'مستخدم غير معروف' }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 font-bold">{{ number_format($withdraw->amount, 2) }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm">
                @if($withdraw->status === 'pending')
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">قيد المعالجة</span>
                @elseif($withdraw->status === 'completed')
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">مكتمل</span>
                @elseif($withdraw->status === 'cancelled')
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">ملغي</span>
                @endif
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                {{ $withdraw->created_at->format('Y-m-d H:i') }}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
  

  </div>
</div>
@endsection
