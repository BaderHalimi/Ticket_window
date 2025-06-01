@extends('visitor.layouts.app')
@section('title', 'Dashboard - ')
@push('styles')
<style>
    .price-slider {
        position: relative;
        width: 100%;
        height: 6px;
        background: #ddd;
        border-radius: 5px;
    }

    .range-input {
        position: relative;
        width: 100%;
    }

    .range-input input {
        position: absolute;
        width: 100%;
        top: -5px;
        z-index: 10;
        -webkit-appearance: none;
        appearance: none;
        background: transparent;
        pointer-events: none;
    }

    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 18px;
        height: 18px;
        background: #ffffff;
        border: 1px solid #007bff;
        border-radius: 50%;
        cursor: pointer;
        pointer-events: all;
        position: relative;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
    }

    .progress-bar {
        position: absolute;
        height: 6px;
        background: #5b91cf;
        border-radius: 5px;
        z-index: 1;
    }

    :where([class^="ri-"])::before {
        content: "\f3c2";
    }

    body {
        font-family: 'Quicksand', sans-serif;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(87, 181, 231, 0.05) 50%, rgba(177, 156, 217, 0.1) 100%);
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
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
    }

    .neumorphism {
        box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.05),
            -5px -5px 15px rgba(255, 255, 255, 0.8);
    }

    .card-hover:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 15px 30px rgba(87, 181, 231, 0.1);
    }

    .particle {
        position: absolute;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(87, 181, 231, 0.5) 0%, rgba(177, 156, 217, 0.5) 100%);
        pointer-events: none;
        opacity: 0.2;
    }

    .search-bar:focus {
        box-shadow: 0 0 0 3px rgba(87, 181, 231, 0.3);
    }

    .status-confirmed {
        background-color: rgba(34, 197, 94, 0.2);
        color: rgb(34, 197, 94);
    }

    .status-pending {
        background-color: rgba(234, 179, 8, 0.2);
        color: rgb(234, 179, 8);
    }

    .status-canceled {
        background-color: rgba(239, 68, 68, 0.2);
        color: rgb(239, 68, 68);
    }

    .carousel {
        scroll-snap-type: x mandatory;
        scrollbar-width: none;
    }

    .carousel::-webkit-scrollbar {
        display: none;
    }

    .carousel-item {
        scroll-snap-align: start;
    }

    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
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
<div class="max-w-5xl mx-auto py-12">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Restaurant Details</h1>
        <a href="{{  route('visitor.restaurent.index') }}" class="gradient-button text-white px-4 py-2 rounded-lg shadow-md">
            <i class="ri-arrow-left-line"></i> Back to Restaurants
        </a>
    </div>

    <div class="glassmorphism p-10 rounded-lg shadow-lg grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <img src="{{ Storage::url($restaurant->image) }}" alt="Restaurant Image" class="rounded-lg shadow-lg w-full h-auto object-cover">
        </div>
        <div>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ $user->name }}</h2>
            <p class="text-gray-600 mb-2"><strong>Location:</strong> {{ $restaurant->name }}</p>
            <p class="text-gray-600 mb-2"><strong>Branch:</strong> {{ $restaurant->location }}</p>
            <p class="text-gray-600 mb-2"><strong>Average Price:</strong> SAR {{ number_format($restaurant->hour_price, 2) }}</p>
            <p class="text-gray-600 mb-2"><strong>Rating:</strong> ⭐ {{ number_format($restaurant->rating, 1) }} / 5</p>
            <p class="text-gray-600 mb-4"><strong>Status:</strong> 
                <span class="{{ $restaurant->status === 'open' ? 'text-green-600' : 'text-red-600' }}">
                    {{ ucfirst($restaurant->status) }}
                </span>
            </p>
        </div>
        <div class="col-span-2">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Description</h3>
            <p class="text-gray-700 mb-6">{{ $restaurant->description }}</p>
        
            <div class="text-right">
                <a href="#" 
                   class="gradient-button text-white px-6 py-3 rounded-lg shadow-lg text-lg font-semibold inline-flex items-center">
                    <i class="ri-restaurant-line mr-2"></i> احجز طاولة
                </a>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto mt-12 px-4">
    <h3 class="text-2xl font-bold text-gray-800 mb-6">📷 صور توضيحية</h3>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        @foreach (json_decode($restaurant->gallery ?? '[]', true) as $index => $image)
            <div class="cursor-pointer">
                <img src="{{ Storage::url($image) }}" 
                     alt="صورة"
                     onclick="openImageViewer({{ $index }})"
                     class="rounded-lg shadow-md object-cover w-full h-32 sm:h-40 md:h-48 hover:scale-105 transition-transform duration-300">
            </div>
        @endforeach
    </div>
</div>

<!-- Image Viewer Modal -->
<div id="imageViewer" 
     class="fixed inset-0 bg-black bg-opacity-80 backdrop-blur-md flex items-center justify-center z-50 hidden">
    <div class="relative max-w-4xl max-h-[80vh] w-full mx-4 bg-white rounded-lg overflow-hidden shadow-lg flex flex-col items-center">
        <!-- Close Button -->
        <button onclick="closeImageViewer()" 
                class="absolute top-4 right-4 text-black bg-white bg-opacity-70 rounded-full p-3 hover:bg-opacity-90 transition shadow-lg text-2xl font-bold">
            &#10005;
        </button>

        <!-- Image Display -->
        <img id="viewerImage" src="" alt="عرض الصورة" 
             class="max-w-full max-h-[70vh] object-contain select-none">

        <!-- Navigation Buttons -->
        <div class="flex justify-between w-full bg-white bg-opacity-70 p-4">
            <button onclick="previousImage()" 
                    class="text-black bg-white bg-opacity-80 px-6 py-3 rounded shadow hover:bg-opacity-100 transition font-semibold text-lg">
                السابق
            </button>
            <button onclick="nextImage()" 
                    class="text-black bg-white bg-opacity-80 px-6 py-3 rounded shadow hover:bg-opacity-100 transition font-semibold text-lg">
                التالي
            </button>
        </div>
    </div>
</div>


<script>
    // جلب الصور من المتغير المرسل من الباك إند
    const images = @json(json_decode($restaurant->gallery ?? '[]', true));

    let currentIndex = 0;

    function openImageViewer(index) {
        currentIndex = index;
        document.getElementById('viewerImage').src = images[currentIndex] ? `{{ asset('storage') }}/` + images[currentIndex] : '';
        document.getElementById('imageViewer').classList.remove('hidden');
    }

    function closeImageViewer() {
        document.getElementById('imageViewer').classList.add('hidden');
    }

    function previousImage() {
        if (currentIndex > 0) {
            currentIndex--;
        } else {
            currentIndex = images.length - 1; // رجوع للصورة الأخيرة
        }
        document.getElementById('viewerImage').src = `{{ asset('storage') }}/` + images[currentIndex];
    }

    function nextImage() {
        if (currentIndex < images.length - 1) {
            currentIndex++;
        } else {
            currentIndex = 0; // العودة للأولى
        }
        document.getElementById('viewerImage').src = `{{ asset('storage') }}/` + images[currentIndex];
    }
</script>



@endsection
