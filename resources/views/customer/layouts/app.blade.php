<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name') }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/logo/Ticket-Window-01.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <style>
        .floating-animation {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0);
            }
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
    <style>
        * {
            font-family: "Cairo", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
            font-variation-settings:
                "slnt" 0;
        }
    </style>
</head>

<body class="font-sans">
    <div data-state="inactive" data-orientation="horizontal" role="tabpanel" aria-labelledby="radix-:r4:-trigger-customer" id="radix-:r4:-content-customer" tabindex="0" class="ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" bis_skin_checked="1" hidden=""></div>
    <div data-state="active" data-orientation="horizontal" role="tabpanel" aria-labelledby="radix-:r4:-trigger-merchant" id="radix-:r4:-content-merchant" tabindex="0" class="ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" bis_skin_checked="1" style="">
        <div class="max-h-screen h-screen bg-slate-100 flex" dir="rtl" bis_skin_checked="1">
            <aside class="w-64 bg-white p-6 flex flex-col shrink-0 border-l border-slate-200 overflow-hidden">
                <div class="flex items-center gap-3 mb-10" bis_skin_checked="1">
                    <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-white">
                            <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path>
                            <path d="M13 5v2"></path>
                            <path d="M13 17v2"></path>
                            <path d="M13 11v2"></path>
                        </svg></div>
                    <h1 class="text-xl font-bold text-slate-800">{{ config('app.name') }}</h1>
                </div>
                @livewire('customer.aside.nav')
                
                <div class="mt-auto p-4 border-t" bis_skin_checked="1">
                    <form action="{{route('logout')}}"  method="post">
                        @csrf
                    <button type="submit" class="inline-flex items-center rounded-md font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-10 px-4 py-2 w-full justify-start text-base text-red-500 hover:text-red-600 hover:bg-red-50"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 ml-3">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" x2="9" y1="12" y2="12"></line>
                        </svg>تسجيل الخروج</button></form>
                    </div>
            </aside>
            <main class="flex-1 overflow-y-auto">
                <header class="bg-white shadow-sm p-4 flex justify-between items-center sticky top-0 z-30">
                    <div></div>
                    <div class="flex items-center gap-4" bis_skin_checked="1"><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-gray-100 hover:text-gray-100-foreground h-10 w-10 relative text-slate-600"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                                <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
                                <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
                            </svg><span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span></button><span class="relative flex shrink-0 overflow-hidden rounded-full cursor-pointer h-9 w-9" type="button" id="radix-:r10:" aria-haspopup="menu" aria-expanded="false" data-state="closed"><img class="aspect-square h-full w-full" alt="Merchant" src="https://images.unsplash.com/photo-1600486913747-55e5470d6f40?q=80&amp;w=200"></span></div>
                </header>
                <div class="p-6 lg:p-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    <div data-state="inactive" data-orientation="horizontal" role="tabpanel" aria-labelledby="radix-:r4:-trigger-partner" hidden="" id="radix-:r4:-content-partner" tabindex="0" class="mt-2 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" bis_skin_checked="1"></div>
    <div data-state="inactive" data-orientation="horizontal" role="tabpanel" aria-labelledby="radix-:r4:-trigger-admin" hidden="" id="radix-:r4:-content-admin" tabindex="0" class="mt-2 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" bis_skin_checked="1"></div>
    @livewireScripts
    @stack('scripts')
    <script>
        function initBurgerMenu() {
            let burgerBtn = document.getElementById('burgerBtn');
            let mobileMenu = document.getElementById('mobileMenu');

            if (burgerBtn && mobileMenu) {
                // تخلص من كل الأحداث القديمة عن طريق استبدال العنصر بنفسه (clone)
                const newBtn = burgerBtn.cloneNode(true);
                burgerBtn.parentNode.replaceChild(newBtn, burgerBtn);
                burgerBtn = newBtn;

                burgerBtn.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        }

        document.addEventListener('DOMContentLoaded', initBurgerMenu);
        document.addEventListener('livewire:navigated', initBurgerMenu);
    </script>


</body>

</html>
