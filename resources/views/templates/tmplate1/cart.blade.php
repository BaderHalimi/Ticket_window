@extends('templates.tmplate1.layouts.app')
@section('content')
<!-- Navbar -->
<nav class="bg-white shadow-md py-4 px-6 fixed top-0 inset-x-0 z-50">
    <div class="container mx-auto flex items-center justify-between">
        <!-- اسم الموقع -->
        <a href="{{ route('template1.index',['id'=>$merchant->id]) }}" class="text-xl font-bold text-orange-600">
            {{ $merchant->business_name ?? 'اسم الموقع' }}
        </a>

        <!-- روابط -->
        <!-- <div class="space-x-4">
            <a href="{{ route('home') }}" class="text-gray-700 hover:text-orange-500 font-medium transition">الصفحة الرئيسية</a>
            {{-- يمكنك إضافة روابط إضافية هنا --}}
        </div> -->
    </div>
</nav>

<!-- تعويض للمسافة بسبب الـ navbar الثابت -->
<div class="h-20"></div>

 @livewire('tepmlates.template1.cart', ['carts' => $carts,'merchant' => $merchant])



@endsection
