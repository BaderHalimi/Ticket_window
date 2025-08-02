@extends('layouts.view')
@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">أدخل رمز التحقق</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{route("otpConfermation.store")}}">
        @csrf


        <div class="mb-4">
            <label for="otp" class="block text-gray-700 mb-1">رمز التحقق</label>
            <input type="text" name="otp" id="otp" required
                   class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <p id="otp-error" class="text-red-500 text-sm mt-1 hidden">الرمز غير صحيح</p>
        </div>

        <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition opacity-50 cursor-not-allowed"
                disabled>
            تأكيد الرمز
        </button>
    </form>
</div>

{{-- سكريبت التحقق --}}
<script>
    // المتغير الصحيح من الباك اند
    const correctOtp = "{{ $otp }}";

    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('otp');
        const button = document.querySelector('button[type="submit"]');
        const errorText = document.getElementById('otp-error');

        input.addEventListener('input', function () {
            if (input.value === correctOtp) {
                button.disabled = false;
                button.classList.remove('opacity-50', 'cursor-not-allowed');
                errorText.classList.add('hidden');
            } else {
                button.disabled = true;
                button.classList.add('opacity-50', 'cursor-not-allowed');
                errorText.classList.remove('hidden');
            }
        });
    });
</script>
@endsection
