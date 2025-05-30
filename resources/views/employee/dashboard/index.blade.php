@extends('employee.layouts.app')
@section('title', 'Dashboard - ')

@push('styles')
<style>
    body {
        font-family: 'Quicksand', sans-serif;
        background: linear-gradient(135deg, #f0f9ff 0%, #e6e6fa 100%);
        min-height: 100vh;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: 'Space Grotesk', sans-serif;
    }

    .glassmorphism {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 12px 32px rgba(106, 90, 205, 0.1);
    }

    .card-hover:hover {
        transform: translateY(-5px) scale(1.01);
        box-shadow: 0 20px 40px rgba(106, 90, 205, 0.15);
    }

    .gradient-button {
        background: linear-gradient(135deg, #57B5E7 0%, #B19CD9 100%);
        transition: all 0.3s ease;
    }

    .gradient-button:hover {
        background: linear-gradient(135deg, #4da8d9 0%, #a28cc7 100%);
        transform: translateY(-2px);
    }
</style>
@endpush

@section('sub_content')

<div class="p-6 space-y-4 max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800">قائمة التذاكر</h2>

    <div class="grid grid-cols-1 gap-4">
        <!-- Ticket Card -->
        <div class="glassmorphism rounded-xl p-4 flex justify-between items-center card-hover transition duration-300">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">#1254 - طلب صيانة كمبيوتر</h3>
                <div class="text-sm text-gray-500 mt-1 space-x-2 rtl:space-x-reverse">
                    <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-xs">عاجل</span>
                    <span class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-xs">مفتوح</span>
                </div>
            </div>
            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                <!-- عرض -->
                <button class="text-blue-600 hover:text-blue-800" title="عرض">
                    <i class="ri-eye-line text-xl"></i>
                </button>
                <!-- تحديث -->
                <button class="text-yellow-500 hover:text-yellow-700" title="تحديث">
                    <i class="ri-refresh-line text-xl"></i>
                </button>
                <!-- طباعة -->
                <button class="text-purple-600 hover:text-purple-800" title="طباعة">
                    <i class="ri-printer-line text-xl"></i>
                </button>
                <!-- عرض QR -->
                <button class="text-teal-600 hover:text-teal-800" title="عرض QR">
                    <i class="ri-qr-code-line text-xl"></i>
                </button>
                <!-- حذف -->
                <button class="text-red-600 hover:text-red-800" title="حذف">
                    <i class="ri-delete-bin-line text-xl"></i>
                </button>
            </div>
        </div>

        <!-- نسخة ثانية لتوضيح تعدد التذاكر -->
        <div class="glassmorphism rounded-xl p-4 flex justify-between items-center card-hover transition duration-300">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">#1255 - شكوى بطء الانترنت</h3>
                <div class="text-sm text-gray-500 mt-1 space-x-2 rtl:space-x-reverse">
                    <span class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-xs">حرج</span>
                    <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded-full text-xs">قيد الانتظار</span>
                </div>
            </div>
            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                <button class="text-blue-600 hover:text-blue-800" title="عرض">
                    <i class="ri-eye-line text-xl"></i>
                </button>
                <button class="text-yellow-500 hover:text-yellow-700" title="تحديث">
                    <i class="ri-refresh-line text-xl"></i>
                </button>
                <button class="text-purple-600 hover:text-purple-800" title="طباعة">
                    <i class="ri-printer-line text-xl"></i>
                </button>
                <button class="text-teal-600 hover:text-teal-800" title="عرض QR">
                    <i class="ri-qr-code-line text-xl"></i>
                </button>
                <button class="text-red-600 hover:text-red-800" title="حذف">
                    <i class="ri-delete-bin-line text-xl"></i>
                </button>
            </div>
        </div>
    </div>
</div>

</script>



@endsection