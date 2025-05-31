@extends('layouts.app')
@section('content')

<body class="bg-gray-50 text-gray-800">
    <div class="grid grid-cols-12 min-h-screen">
        <!-- Sidebar -->
        <div id="sidebar" class="hidden md:block md:col-span-3 lg:col-span-2 bg-white shadow-lg h-full z-10 p-6">
            <div class="flex items-center gap-3 mb-10">
                <div class="w-10 h-10 bg-gradient-to-r from-primary to-secondary text-white rounded-full flex items-center justify-center font-bold text-lg">S</div>
                <span class="text-xl font-semibold text-gray-700">Seller</span>
            </div>
            <nav>
                <ul class="space-y-4">
                    <li><a href="{{ route('seller.dashboard') }}" class="flex items-center gap-2 hover:text-primary"><i class="ri-dashboard-line"></i> Dashboard</a></li>
                    <li><a href="{{ route('seller.events.index') }}" class="flex items-center gap-2 hover:text-primary"><i class="ri-calendar-event-line"></i> Events</a></li>
                    <li><a href="{{ route('seller.sales') }}" class="flex items-center gap-2 hover:text-primary"><i class="ri-money-dollar-circle-line"></i> Sales</a></li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="col-span-12 md:col-span-9 lg:col-span-10 px-6 py-8 relative">
            <!-- Profile Section -->
            <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-md p-6 relative">
                <!-- Profile Picture -->
                <div class="relative w-28 h-28 mx-auto mb-4">
                    <img src="https://readdy.ai/api/search-image?query=professional%20portrait%20photo%20of%20a%20young%20middle%20eastern%20man&width=200&height=200&seq=avatar1&orientation=squarish"
                        class="w-full h-full rounded-full object-cover border-4 border-white shadow" alt="Profile Picture">
                    <label for="profile-photo-upload"
                        class="absolute bottom-0 right-0 bg-primary text-white p-1 rounded-full cursor-pointer shadow hover:bg-secondary transition">
                        <i class="ri-pencil-line text-sm"></i>
                    </label>
                    <input id="profile-photo-upload" type="file" class="hidden" />
                </div>

                <!-- Name + Date -->
                <div class="text-center">
                    <h2 class="text-2xl font-semibold">{{ Auth::user()->name }}</h2>
                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::now()->format('D, M d, Y') }}</p>
                </div>

                <!-- Optional Details -->
                <div class="mt-6 text-center">
                    <a href="#" class="inline-block bg-secondary text-white px-4 py-2 rounded-full hover:bg-primary transition">Edit Profile</a>
                </div>
            </div>

            @yield('sub_content')
        </div>
    </div>
</body>
@endsection
