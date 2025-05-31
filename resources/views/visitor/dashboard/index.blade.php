@extends('visitor.layouts.app')
@section('title', 'Dashboard - ')
@push('styles')
<style>
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


<!-- Main Content -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Recent Activity Widget -->
    <!-- <div class="lg:col-span-1">
        <div
            class="glassmorphism rounded-xl p-6 h-full transition-all duration-300 card-hover">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold">Recent Bookings</h2>
                <span class="text-primary text-sm cursor-pointer">View all</span>
            </div>

            <div class="space-y-4">
                <div
                    class="p-3 rounded-lg bg-white bg-opacity-50 border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-medium">Dubai Jazz Festival</h3>
                            <p class="text-sm text-gray-600">
                                May 28, 2025 • 7:30 PM
                            </p>
                        </div>
                        <span
                            class="status-confirmed text-xs px-3 py-1 rounded-full">Confirmed</span>
                    </div>
                    <div class="flex mt-3 gap-2">
                        <button
                            class="flex items-center justify-center gap-1 text-xs bg-white px-3 py-1.5 rounded-full border border-gray-200 !rounded-button whitespace-nowrap">
                            <i class="ri-qr-code-line ri-sm"></i> View QR
                        </button>
                        <button
                            class="flex items-center justify-center gap-1 text-xs bg-white px-3 py-1.5 rounded-full border border-gray-200 !rounded-button whitespace-nowrap">
                            <i class="ri-file-pdf-line ri-sm"></i> Download PDF
                        </button>
                    </div>
                </div>

                <div
                    class="p-3 rounded-lg bg-white bg-opacity-50 border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-medium">Riyadh Season Concert</h3>
                            <p class="text-sm text-gray-600">
                                June 5, 2025 • 8:00 PM
                            </p>
                        </div>
                        <span class="status-pending text-xs px-3 py-1 rounded-full">Pending</span>
                    </div>
                    <div class="flex mt-3 gap-2">
                        <button
                            class="flex items-center justify-center gap-1 text-xs bg-white px-3 py-1.5 rounded-full border border-gray-200 !rounded-button whitespace-nowrap">
                            <i class="ri-bank-card-line ri-sm"></i> Complete Payment
                        </button>
                    </div>
                </div>

                <div
                    class="p-3 rounded-lg bg-white bg-opacity-50 border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-medium">Cairo Film Festival</h3>
                            <p class="text-sm text-gray-600">
                                May 15, 2025 • 6:00 PM
                            </p>
                        </div>
                        <span class="status-canceled text-xs px-3 py-1 rounded-full">Canceled</span>
                    </div>
                    <div class="flex mt-3 gap-2">
                        <button
                            class="flex items-center justify-center gap-1 text-xs bg-white px-3 py-1.5 rounded-full border border-gray-200 !rounded-button whitespace-nowrap">
                            <i class="ri-refresh-line ri-sm"></i> Rebook
                        </button>
                    </div>
                </div>
            </div>

            <button
                class="w-full mt-6 py-3 text-center gradient-button text-white rounded-lg !rounded-button whitespace-nowrap font-medium">
                View All Bookings
            </button>
        </div>
    </div> -->

    <!-- Featured Events Grid -->
    <div class="lg:col-span-2">
        <!-- Search Section -->
        <div class="mb-10">
            <div class="glassmorphism rounded-full p-2 flex items-center w-full mx-auto">
                <div
                    class="w-10 h-10 flex items-center justify-center text-gray-500">
                    <i class="ri-search-line ri-xl"></i>
                </div>
                <input
                    type="text"
                    placeholder="Search for events, restaurants, or exhibitions..."
                    class="search-bar w-full bg-transparent border-none outline-none px-2 py-2 text-gray-700 placeholder-gray-500" />
                <button
                    class="gradient-button text-white px-5 mx-3 py-2 rounded-full whitespace-nowrap font-medium">
                    Search
                </button>
            </div>
        </div>
        <h2 class="text-xl font-semibold mb-6">Featured Events</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Event Card 1 -->
            <div
                class="glassmorphism rounded-xl overflow-hidden transition-all duration-300 card-hover">
                <div class="h-40 bg-gray-200 relative">
                    <img
                        src="https://readdy.ai/api/search-image?query=luxury%20concert%20hall%20with%20stage%20lighting%20and%20crowd%2C%20professional%20photography%2C%20high%20quality%20image%20with%20dramatic%20lighting%2C%20cinematic%20atmosphere%2C%20high-end%20venue&width=600&height=300&seq=event1&orientation=landscape"
                        alt="Concert Event"
                        class="w-full h-full object-cover object-top" />
                    <div
                        class="absolute top-3 right-3 bg-white bg-opacity-90 px-3 py-1 rounded-full text-sm font-semibold">
                        $120
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-lg">
                        International Symphony Orchestra
                    </h3>
                    <div
                        class="flex items-center gap-1 text-gray-600 text-sm mt-1">
                        <i class="ri-calendar-line ri-sm"></i>
                        <span>June 15, 2025</span>
                    </div>
                    <div
                        class="flex items-center gap-1 text-gray-600 text-sm mt-1">
                        <i class="ri-map-pin-line ri-sm"></i>
                        <span>Dubai Opera House</span>
                    </div>
                    <button
                        class="w-full mt-4 py-2 gradient-button text-white rounded-lg !rounded-button whitespace-nowrap font-medium">
                        Book Now
                    </button>
                </div>
            </div>

            <!-- Event Card 2 -->
            <div
                class="glassmorphism rounded-xl overflow-hidden transition-all duration-300 card-hover">
                <div class="h-40 bg-gray-200 relative">
                    <img
                        src="https://readdy.ai/api/search-image?query=luxury%20art%20exhibition%20gallery%20with%20modern%20artworks%20displayed%2C%20professional%20photography%2C%20high%20quality%20image%20with%20elegant%20lighting%2C%20sophisticated%20atmosphere%2C%20high-end%20venue&width=600&height=300&seq=event2&orientation=landscape"
                        alt="Art Exhibition"
                        class="w-full h-full object-cover object-top" />
                    <div
                        class="absolute top-3 right-3 bg-white bg-opacity-90 px-3 py-1 rounded-full text-sm font-semibold">
                        $75
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-lg">Modern Art Exhibition</h3>
                    <div
                        class="flex items-center gap-1 text-gray-600 text-sm mt-1">
                        <i class="ri-calendar-line ri-sm"></i>
                        <span>June 10-20, 2025</span>
                    </div>
                    <div
                        class="flex items-center gap-1 text-gray-600 text-sm mt-1">
                        <i class="ri-map-pin-line ri-sm"></i>
                        <span>Riyadh Art Center</span>
                    </div>
                    <button
                        class="w-full mt-4 py-2 gradient-button text-white rounded-lg !rounded-button whitespace-nowrap font-medium">
                        Book Now
                    </button>
                </div>
            </div>

            <!-- Event Card 3 -->
            <div
                class="glassmorphism rounded-xl overflow-hidden transition-all duration-300 card-hover">
                <div class="h-40 bg-gray-200 relative">
                    <img
                        src="https://readdy.ai/api/search-image?query=luxury%20theater%20with%20red%20velvet%20seats%20and%20dramatic%20stage%20lighting%2C%20professional%20photography%2C%20high%20quality%20image%20with%20elegant%20atmosphere%2C%20high-end%20venue&width=600&height=300&seq=event3&orientation=landscape"
                        alt="Theater Show"
                        class="w-full h-full object-cover object-top" />
                    <div
                        class="absolute top-3 right-3 bg-white bg-opacity-90 px-3 py-1 rounded-full text-sm font-semibold">
                        $95
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-lg">Shakespeare's Hamlet</h3>
                    <div
                        class="flex items-center gap-1 text-gray-600 text-sm mt-1">
                        <i class="ri-calendar-line ri-sm"></i>
                        <span>June 8, 2025</span>
                    </div>
                    <div
                        class="flex items-center gap-1 text-gray-600 text-sm mt-1">
                        <i class="ri-map-pin-line ri-sm"></i>
                        <span>Cairo National Theater</span>
                    </div>
                    <button
                        class="w-full mt-4 py-2 gradient-button text-white rounded-lg !rounded-button whitespace-nowrap font-medium">
                        Book Now
                    </button>
                </div>
            </div>

            <!-- Event Card 4 -->
            <div
                class="glassmorphism rounded-xl overflow-hidden transition-all duration-300 card-hover">
                <div class="h-40 bg-gray-200 relative">
                    <img
                        src="https://readdy.ai/api/search-image?query=luxury%20music%20festival%20with%20stage%20and%20colorful%20lighting%20at%20night%2C%20professional%20photography%2C%20high%20quality%20image%20with%20vibrant%20atmosphere%2C%20high-end%20outdoor%20venue&width=600&height=300&seq=event4&orientation=landscape"
                        alt="Music Festival"
                        class="w-full h-full object-cover object-top" />
                    <div
                        class="absolute top-3 right-3 bg-white bg-opacity-90 px-3 py-1 rounded-full text-sm font-semibold">
                        $150
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-lg">Summer Music Festival</h3>
                    <div
                        class="flex items-center gap-1 text-gray-600 text-sm mt-1">
                        <i class="ri-calendar-line ri-sm"></i>
                        <span>July 1-3, 2025</span>
                    </div>
                    <div
                        class="flex items-center gap-1 text-gray-600 text-sm mt-1">
                        <i class="ri-map-pin-line ri-sm"></i>
                        <span>Jeddah Waterfront</span>
                    </div>
                    <button
                        class="w-full mt-4 py-2 gradient-button text-white rounded-lg !rounded-button whitespace-nowrap font-medium">
                        Book Now
                    </button>
                </div>
            </div>
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
</script>


@endpush
