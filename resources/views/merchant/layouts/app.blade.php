<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ config('app.name') }}</title>
  <link rel="shortcut icon" href="{{ asset('assets/logo/Ticket-Window-01.png') }}" type="image/x-icon">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
  <style>
    * {
      font-family: "Cairo", sans-serif;
    }
  </style>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
  @stack('styles')
</head>

<body class="bg-slate-100 font-sans">
  <div class="relative h-screen flex overflow-hidden" dir="rtl">
    <!-- Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden md:hidden"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="
      fixed inset-y-0 right-0 w-64 bg-white p-6 flex flex-col border-l border-slate-200 z-40
      transform translate-x-full transition-transform duration-300 ease-in-out
      md:relative md:translate-x-0 md:flex md:w-64 md:transform-none
      overflow-y-auto
    ">
      <!-- Close button on mobile -->
      <button id="closeBtn" class="md:hidden mb-4 self-end text-slate-600 hover:text-orange-500">
        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>

      <div class="flex items-center gap-3 mb-10">
        <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z" />
            <path d="M13 5v2" />
            <path d="M13 17v2" />
            <path d="M13 11v2" />
          </svg>
        </div>
        <h1 class="text-xl font-bold text-slate-800">{{ config('app.name') }}</h1>
      </div>

      @livewire('merchant.aside.nav')

      <div class="mt-auto p-4 border-t">
        <form action="{{ route('logout') }}" method="post">
          @csrf
          <button type="submit" class="inline-flex items-center rounded-md font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 h-10 px-4 py-2 w-full justify-start text-base text-red-500 hover:text-red-600 hover:bg-red-50">
            <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
              <polyline points="16 17 21 12 16 7"></polyline>
              <line x1="21" x2="9" y1="12" y2="12"></line>
            </svg>
            تسجيل الخروج
          </button>
        </form>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
      <header class="bg-white shadow-sm p-4 flex justify-between items-center sticky top-0 z-30 flex-row md:flex-row-reverse">
        <!-- Burger button -->
        <button id="burgerBtn" class="md:hidden text-slate-600 hover:text-orange-500">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>

        <!-- User Info + Notification -->
        <div class="flex items-center gap-4">
          @livewire('notif-bell')

          <div class="flex items-center gap-2">
            <span class="text-slate-800 font-bold text-sm hidden md:inline">
              {{ auth('merchant')->user()->name }}
            </span>
            <img class="h-10 w-10 rounded-full border border-slate-300 object-cover"
                 src="{{ asset('storage/' . (auth('merchant')->user()->additional_data['profile_image'] ?? 'default-user.png')) }}"
                 alt="User">
          </div>
        </div>
      </header>

      <div class="p-6 lg:p-8">
        @yield('content')
      </div>
    </main>
  </div>

  @livewireScripts
  @stack('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const burgerBtn = document.getElementById('burgerBtn');
      const closeBtn = document.getElementById('closeBtn');
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');

      function openSidebar() {
        sidebar.classList.remove('translate-x-full');
        sidebar.classList.add('translate-x-0');
        overlay.classList.remove('hidden');
      }

      function closeSidebar() {
        sidebar.classList.add('translate-x-full');
        sidebar.classList.remove('translate-x-0');
        overlay.classList.add('hidden');
      }

      if (burgerBtn) burgerBtn.addEventListener('click', openSidebar);
      if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
      if (overlay) overlay.addEventListener('click', closeSidebar);
    });
  </script>
</body>
</html>
