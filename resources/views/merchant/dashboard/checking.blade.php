
@extends('merchant.layouts.app')
@section('content')
<div class="flex-1 p-8">
    <div class="space-y-8">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-slate-800">التحقق من التذاكر</h2>
        </div>

        @livewire('merchant.dashboard.tickets_check')

    </div>
</div>


@endsection
