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

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div id="restaurants" class="lg:col-span-3">
        <!-- Search Section -->
        <div class="mb-10 flex justify-between">
            <div class="glassmorphism rounded-full p-2 flex items-center w-full max-w-3xl">
                <form action="" method="GET" class="flex items-center w-full">
                    <div class="w-10 h-10 flex items-center justify-center text-gray-500">
                        <i class="ri-search-line ri-xl"></i>
                    </div>
                    <input
                        type="text" name="search"
                        placeholder="Search for restaurants..."
                        class="search-bar w-full bg-transparent border-none outline-none px-3 py-2 text-gray-700 placeholder-gray-500" />
                    <button
                        class="gradient-button text-white px-5 mx-3 py-2 rounded-full whitespace-nowrap font-medium">
                        Search
                    </button>
                </form>
            </div>
        </div>

        <div id="cards_container" class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($branchs as $restaurant)
            <div class="card-hover glassmorphism p-3 rounded-lg shadow-lg transition-transform">
                <div>
                    @if($restaurant->status === 'open')
                        <div class="absolute top-3 left-3 bg-green-600 text-white bg-opacity-90 px-3 py-1 rounded-full text-sm font-semibold">
                            Open
                        </div>
                    @else
                        <div class="absolute top-3 left-3 bg-red-600 text-white bg-opacity-90 px-3 py-1 rounded-full text-sm font-semibold">
                            Closed
                        </div>
                    @endif
                    <img src="{{ Storage::url($restaurant->image) }}" alt="{{ $restaurant->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
                    <div class="absolute top-3 right-3 bg-white bg-opacity-90 px-3 py-1 rounded-full text-sm font-semibold">
                        {{ $restaurant->hour_price }} SAR/hr
                    </div>
                </div>
                <h2 class="text-xl font-semibold text-gray-800">{{ $restaurant->name }}</h2>
                <p class="text-gray-600 mt-2">Tables: {{ $restaurant->tables }}</p>
                <p class="text-gray-500 mt-1"><span class="text-black"><i class="ri-map-pin-line ri-sm"></i></span> {{ $restaurant->location }}</p>
                <p class="text-gray-500 mt-1">
                    <i class="ri-time-line"></i> {{ \Carbon\Carbon::parse($restaurant->open_at)->format('g:i A') }} - {{ \Carbon\Carbon::parse($restaurant->close_at)->format('g:i A') }}
                </p>
                <a href="{{ route('visitor.restaurent.show', $restaurant->id) }}">
                    <button class="w-full mt-4 py-2 gradient-button text-white rounded-lg whitespace-nowrap font-medium">
                        Book a Table
                    </button>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection


@push('scripts')
<script id="particles-animation">
    document.addEventListener("DOMContentLoaded", function() {
        const container = document.getElementById("particles-container");
        const particleCount = 30;

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement("div");
            particle.classList.add("particle");

            // Random size between 5px and 15px
            const size = Math.random() * 10 + 5;
            particle.style.width = `${size}px`;
            particle.style.height = `${size}px`;

            // Random position
            const posX = Math.random() * 100;
            const posY = Math.random() * 100;
            particle.style.left = `${posX}%`;
            particle.style.top = `${posY}%`;

            // Random opacity
            particle.style.opacity = Math.random() * 0.2 + 0.1;

            // Animation
            const duration = Math.random() * 20 + 10;
            const delay = Math.random() * 5;

            particle.style.animation = `float ${duration}s ease-in-out ${delay}s infinite`;

            container.appendChild(particle);
        }

        // Add keyframes for floating animation
        const style = document.createElement("style");
        style.textContent = `
                      @keyframes float {
                          0% {
                              transform: translate(0, 0);
                          }
                          50% {
                              transform: translate(${Math.random() * 30 - 15}px, ${Math.random() * 30 - 15}px);
                          }
                          100% {
                              transform: translate(0, 0);
                          }
                      }
                  `;
        document.head.appendChild(style);
    });
    document.getElementById('calender_toggle_1').addEventListener('click', function() {
        calenderToggle();
    });
    document.getElementById('calender_toggle').addEventListener('click', function() {
        calenderToggle();
    });

    function calenderToggle() {
        const calenderBtn = document.getElementById('calender_toggle');
        calenderBtn.classList.toggle('hidden');
        const calender = document.getElementById('calender');
        calender.classList.toggle('hidden');
        const cardsConatiner = document.getElementById('cards_conatiner');
        cardsConatiner.classList.toggle('md:grid-cols-3');
        cardsConatiner.classList.toggle('md:grid-cols-2');
        const events = document.getElementById('events');
        events.classList.toggle('lg:col-span-3');
        events.classList.toggle('lg:col-span-2');
    }

    // Calendar functionality
    document.addEventListener('DOMContentLoaded', function() {
        const calendarDays = document.querySelectorAll('.calendar-day');

        calendarDays.forEach(day => {
            day.addEventListener('click', function() {
                // Skip if it's a previous month day
                if (this.classList.contains('text-indigo-300')) return;

                // Toggle active state
                const isActive = this.classList.contains('calendar-day-active');

                if (!isActive) {
                    this.classList.add('calendar-day-active', 'text-primary', 'font-bold', 'glow');
                    this.classList.remove('text-indigo-700');
                } else {
                    this.classList.remove('calendar-day-active', 'text-primary', 'font-bold', 'glow');
                    this.classList.add('text-indigo-700');
                }
            });
        });

        // Initialize current month and year
        const monthYear = document.getElementById('monthYear');
        const currentDate = new Date();
        monthYear.textContent = currentDate.toLocaleString('default', {
            month: 'long',
            year: 'numeric'
        });

        // Load current month days
        loadMonthDays(currentDate.getFullYear(), currentDate.getMonth());

        document.getElementById('prevMonth').addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            monthYear.textContent = currentDate.toLocaleString('default', {
                month: 'long',
                year: 'numeric'
            });
            loadMonthDays(currentDate.getFullYear(), currentDate.getMonth());
        });

        document.getElementById('nextMonth').addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            monthYear.textContent = currentDate.toLocaleString('default', {
                month: 'long',
                year: 'numeric'
            });
            loadMonthDays(currentDate.getFullYear(), currentDate.getMonth());
        });
    });

    function loadMonthDays(year, month) {
        const calendarDays = document.getElementById('calendarDays');
        calendarDays.innerHTML = '';

        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const numDays = lastDay.getDate();
        const startDay = firstDay.getDay();

        // Empty slots for previous month
        for (let i = 0; i < startDay; i++) {
            const emptyDay = document.createElement('button');
            emptyDay.classList.add('calendar-day', 'w-8', 'h-8', 'flex', 'items-center', 'justify-center', 'rounded-full', 'text-transparent', 'text-sm');
            calendarDays.appendChild(emptyDay);
        }

        // Days of current month
        for (let day = 1; day <= numDays; day++) {
            const dayButton = document.createElement('button');
            dayButton.textContent = day;
            dayButton.classList.add('calendar-day', 'w-8', 'h-8', 'flex', 'items-center', 'justify-center', 'rounded-full', 'text-indigo-700', 'text-sm');

            dayButton.addEventListener('click', function(e) {
                e.preventDefault(); // منع الحدث الافتراضي

                // إزالة التحديد من كل الأيام
                document.querySelectorAll('.calendar-day-active').forEach(el => {
                    el.classList.remove('calendar-day-active', 'text-primary', 'font-bold', 'glow', 'gradient-button');
                    // el.classList.add('text-indigo-700');
                });

                // تفعيل التحديد لليوم الحالي
                this.classList.add('active', 'glow', 'gradient-button');
                // this.classList.remove('text-indigo-700');

                // تعيين التاريخ المحدد في hidden input
                const selectedDate = new Date(year, month, day);
                const yearStr = selectedDate.getFullYear();
                const monthStr = ('0' + (selectedDate.getMonth() + 1)).slice(-2);
                const dayStr = ('0' + selectedDate.getDate()).slice(-2);
                document.getElementById('selectedDate').value = `${yearStr}-${monthStr}-${dayStr}`;
            });

            calendarDays.appendChild(dayButton);
        }

        // Empty slots for next month
        const endDay = lastDay.getDay();
        for (let i = endDay + 1; i < 7; i++) {
            const emptyDay = document.createElement('button');
            emptyDay.classList.add('calendar-day', 'w-8', 'h-8', 'flex', 'items-center', 'justify-center', 'rounded-full', 'text-transparent', 'text-sm');
            calendarDays.appendChild(emptyDay);
        }
    }
</script>
<script id="calendarInteraction">
    document.addEventListener('DOMContentLoaded', function() {
        const calendarDays = document.querySelectorAll('.calendar-day');

        calendarDays.forEach(day => {
            day.addEventListener('click', function() {
                // Skip if it's a previous month day
                if (this.classList.contains('text-indigo-300')) return;

                // Toggle active state
                const isActive = this.classList.contains('calendar-day-active');

                if (!isActive) {
                    this.classList.add('calendar-day-active', 'glow');
                    this.classList.remove('text-indigo-700');
                } else {
                    this.classList.remove('calendar-day-active', 'glow');
                    this.classList.add('text-indigo-700');
                }
            });
        });
    });
</script>
<script>
    const minPrice = document.getElementById("minPrice");
    const maxPrice = document.getElementById("maxPrice");
    const minPriceBubble = document.getElementById("minPriceBubble");
    const maxPriceBubble = document.getElementById("maxPriceBubble");
    const progress = document.getElementById("progress");

    function updatePriceRange() {
        document.getElementById("priceChanged").value = "true";
        let minVal = parseInt(minPrice.value);
        let maxVal = parseInt(maxPrice.value);

        if (minVal >= maxVal) {
            minVal = maxVal - 1;
            minPrice.value = minVal;
        }

        const minPercent = ((minVal - minPrice.min) / (minPrice.max - minPrice.min)) * 100;
        const maxPercent = ((maxVal - minPrice.min) / (minPrice.max - minPrice.min)) * 100;

        progress.style.left = minPercent + "%";
        progress.style.width = (maxPercent - minPercent) + "%";

        minPriceBubble.textContent = `${minVal} SAR`;
        maxPriceBubble.textContent = `${maxVal==3000?'100,000':maxVal} SAR`;

        minPriceBubble.style.left = minPercent + "%";
        maxPriceBubble.style.left = maxPercent + "%";
    }

    minPrice.addEventListener("input", updatePriceRange);
    maxPrice.addEventListener("input", updatePriceRange);

    updatePriceRange();
</script>
@endpush