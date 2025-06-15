<!-- Navbar -->
    <nav class="fixed top-0 left-0 w-full z-50 px-4 sm:px-8 bg-white bg-opacity-70 backdrop-blur">
        <div class="mx-[5%] flex justify-between items-center">
            <div class="flex justify-center items-center">
                <img style="max-width: 60px; max-height: 100%;" src="{{ asset('assets/logo/Ticket-Window-01.png') }}"
                    alt="">
                <h1 class="font-bold text-orange-500">{{ config('app.name') }}</h1>
            </div>
            <div class="hidden sm:flex text-sm font-medium text-gray-700 gap-4">
                <a href="{{ route('home') }}" wire:click.prevent="checkAccess('{{ route('home') }}')" class="@if(Route::is('home')) text-orange-500 border-b-2 border-orange-500 transition duration-500 @else hover:text-orange-500 @endif py-2 px-3">الرئيسية</a>
                <a href="{{ route('features') }}" wire:click.prevent="checkAccess('{{ route('features') }}')" class="@if(Route::is('features')) text-orange-500 border-b-2 border-orange-500 transition duration-500 @else hover:text-orange-500 @endif py-2 px-3">المميزات</a>
                <a href="{{ route('merchant') }}" wire:click.prevent="checkAccess('{{ route('merchant') }}')" class="@if(Route::is('merchant')) text-orange-500 border-b-2 border-orange-500 transition duration-500 @else hover:text-orange-500 @endif py-2 px-3">رحلة التاجر</a>
                <a href="{{ route('partners') }}" wire:click.prevent="checkAccess('{{ route('partners') }}')" class="@if(Route::is('partners')) text-orange-500 border-b-2 border-orange-500 transition duration-500 @else hover:text-orange-500 @endif py-2 px-3">نظام الشركاء</a>
                <a href="#" wire:click.prevent="checkAccess('{{ route('partners') }}')" class="@if(Route::is('partners')) text-orange-500 border-b-2 border-orange-500 transition duration-500 @else hover:text-orange-500 @endif py-2 px-3">المحفظة والحماية</a>
                <a href="#" wire:click.prevent="checkAccess('{{ route('partners') }}')" class="@if(Route::is('partners')) text-orange-500 border-b-2 border-orange-500 transition duration-500 @else hover:text-orange-500 @endif py-2 px-3">الأدوار والرحلات</a>
                <a href="#" wire:click.prevent="checkAccess('{{ route('partners') }}')" class="@if(Route::is('partners')) text-orange-500 border-b-2 border-orange-500 transition duration-500 @else hover:text-orange-500 @endif py-2 px-3">الأسعار</a>
                <a href="#" wire:click.prevent="checkAccess('{{ route('partners') }}')" class="@if(Route::is('partners')) text-orange-500 border-b-2 border-orange-500 transition duration-500 @else hover:text-orange-500 @endif py-2 px-3">لوحة التحكم</a>
            </div>
        </div>
    </nav>
