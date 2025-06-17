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
    <div data-state="active" data-orientation="horizontal" role="tabpanel" aria-labelledby="radix-:r3:-trigger-merchant" id="radix-:r3:-content-merchant" tabindex="0" class="mt-2 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" bis_skin_checked="1" style="animation-duration: 0s;">
        <div class="min-h-screen bg-slate-100 flex" dir="rtl" bis_skin_checked="1">
            <aside class="w-64 bg-white p-6 flex flex-col shrink-0 border-l border-slate-200">
                <div class="flex items-center gap-3 mb-10" bis_skin_checked="1">
                    <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-white">
                            <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path>
                            <path d="M13 5v2"></path>
                            <path d="M13 17v2"></path>
                            <path d="M13 11v2"></path>
                        </svg></div>
                    <h1 class="text-xl font-bold text-slate-800">شباك التذاكر</h1>
                </div>
                @livewire('merchant.aside.nav')
                <div class="mt-auto p-4 border-t" bis_skin_checked="1">
                    <form action="{{route('logout')}}" method="post">
                        @csrf
                        <button type="submit" class="inline-flex items-center rounded-md font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-10 px-4 py-2 w-full justify-start text-base text-red-500 hover:text-red-600 hover:bg-red-50"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 ml-3">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" x2="9" y1="12" y2="12"></line>
                            </svg>تسجيل الخروج</button>
                    </form>
                </div>
            </aside>
            <main class="flex-1 overflow-y-auto flex flex-col">
                <header class="bg-white shadow-sm p-4 flex justify-between items-center sticky top-0 z-30">
                    <div class="flex-1 min-w-0" bis_skin_checked="1">
                        <div class="w-64" bis_skin_checked="1"><button type="button" role="combobox" aria-controls="radix-:r8:" aria-expanded="false" aria-autocomplete="none" dir="rtl" data-state="closed" class="flex h-10 items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 w-full"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 ml-2">
                                    <line x1="6" x2="6" y1="3" y2="15"></line>
                                    <circle cx="18" cy="6" r="3"></circle>
                                    <circle cx="6" cy="18" r="3"></circle>
                                    <path d="M18 9a9 9 0 0 1-9 9"></path>
                                </svg><span style="pointer-events: none;">كل الفروع</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 opacity-50" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></button></div>
                    </div>
                    <div class="flex items-center gap-4" bis_skin_checked="1"><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 w-10 relative text-slate-600"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                                <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
                                <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
                            </svg><span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span></button><span class="relative flex shrink-0 overflow-hidden rounded-full cursor-pointer h-9 w-9" type="button" id="radix-:r9:" aria-haspopup="menu" aria-expanded="false" data-state="closed"><img class="aspect-square h-full w-full" alt="Merchant" src="https://images.unsplash.com/photo-1600486913747-55e5470d6f40?q=80&amp;w=200"></span></div>
                </header>
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>

</html>
