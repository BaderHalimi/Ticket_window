<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ LoadConfig()->setup->name ?? null  }}</title>
    <link rel="shortcut icon" href="{{ Storage::url(LoadConfig()->setup->logo ?? null) }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <style>
        * {
            font-family: "Cairo", sans-serif;
        }

        #sidebar {
            transition: transform 0.3s ease-in-out;
        }

        /* تنسيق مخصص لأزرار SweetAlert2 */
        .swal2-confirm-custom {
            background-color: #dc2626 !important;
            color: white !important;
            border: none !important;
            border-radius: 0.375rem !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 600 !important;
            font-size: 0.875rem !important;
            cursor: pointer !important;
            transition: all 0.2s ease-in-out !important;
            margin: 0 0.25rem !important;
            min-width: 80px !important;
        }

        .swal2-confirm-custom:hover {
            background-color: #b91c1c !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 8px rgba(220, 38, 38, 0.3) !important;
        }

        .swal2-confirm-custom:focus {
            outline: none !important;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.3) !important;
        }

        .swal2-cancel-custom {
            background-color: #6b7280 !important;
            color: white !important;
            border: none !important;
            border-radius: 0.375rem !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 600 !important;
            font-size: 0.875rem !important;
            cursor: pointer !important;
            transition: all 0.2s ease-in-out !important;
            margin: 0 0.25rem !important;
            min-width: 80px !important;
        }

        .swal2-cancel-custom:hover {
            background-color: #4b5563 !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 8px rgba(107, 114, 128, 0.3) !important;
        }

        .swal2-cancel-custom:focus {
            outline: none !important;
            box-shadow: 0 0 0 3px rgba(107, 114, 128, 0.3) !important;
        }

        /* تنسيق عام للمودال */
        .swal2-rtl {
            direction: rtl !important;
            text-align: right !important;
        }

        .swal2-popup {
            border-radius: 0.75rem !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
        }

        .swal2-icon.swal2-warning {
            border-color: #f59e0b !important;
            color: #f59e0b !important;
        }

        .swal2-icon.swal2-success {
            border-color: #10b981 !important;
            color: #10b981 !important;
        }

        /* إصلاح مشكلة عدم ظهور الأزرار */
        .swal2-actions {
            margin: 1.25rem 0 0 0 !important;
            gap: 0.5rem !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
        }

        .swal2-styled {
            display: inline-block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>
@if(session('error') || session('success') || session('message'))
    @php
        $message = session('error') ?? session('success') ?? session('message');
        $type = session('error') ? 'error' : (session('success') ? 'success' : 'info');
        $bgColor = match($type) {
            'success' => 'bg-green-500',
            'error' => 'bg-red-500',
            'info' => 'bg-gray-700',
        };
    @endphp

    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 2500)"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-x-10"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 translate-x-10"
        class="fixed bottom-5 right-5 z-50 max-w-xs w-full {{ $bgColor }} text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-3"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            @if($type === 'success')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            @elseif($type === 'error')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            @else
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m0-4h.01M12 18h.01" />
            @endif
        </svg>
        <span class="text-sm font-medium">{{ $message }}</span>
    </div>
@endif

<body class="bg-slate-100 font-sans">
    <div class="relative h-screen flex overflow-hidden" dir="rtl" x-data="{ openSidebar: true }">



        <!-- ✅ السايدبار -->
        <div
            x-show="openSidebar"
            x-transition:enter="transition-all transform ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-full"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition-all transform ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-full"
            @click.outside.window="if(window.innerWidth < 768) openSidebar = false"
            class="fixed inset-y-0 right-0 w-64 bg-white p-6 flex flex-col border-l border-slate-200 z-40 overflow-y-auto shadow-xl md:relative md:shadow-none md:block">
            <aside id="sidebar" class="w-full">
                <!-- Logo -->
                <div class="flex items-center gap-3 mb-10">
                    <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z" />
                            <path d="M13 5v2" />
                            <path d="M13 17v2" />
                            <path d="M13 11v2" />
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-slate-800">{{ LoadConfig()->setup->name ?? null  }}</h1>
                </div>

                @livewire('merchant.aside.nav',['merchant'=>$merchant??false])

                <div class="mt-auto p-4 border-t">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="inline-flex items-center rounded-md font-medium transition-colors focus:outline-none focus:ring-2 h-10 px-4 py-2 w-full justify-start text-base text-red-500 hover:text-red-600 hover:bg-red-50">
                            <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" x2="9" y1="12" y2="12"></line>
                            </svg>
                            تسجيل الخروج
                        </button>
                    </form>
                </div>
            </aside>
        </div>


        @php
        $user = auth()->user();

        if ($merchant) {
            $user = \App\Models\User::find($merchant);
        }

        @endphp
        <main class="relative flex-1 overflow-y-auto">

            <header class="bg-white shadow p-4 sticky top-0 z-30 flex justify-between items-center">
                <!-- ✅ زر البرغر الثابت دائمًا -->
                <button @click="openSidebar = !openSidebar"
                    class="absolute top-4 right-4 bg-white z-50 py-2 px-4 rounded-md transition">
                    <i class="ri-menu-3-line text-2xl text-slate-800 hover:text-orange-600"></i>
                </button>
                <!-- نضع العناصر في يسار الشاشة دائمًا مهما كان حجم الجهاز -->
                <div class="flex items-center gap-4 ltr:ml-auto rtl:mr-auto">
                    <a href="{{ route('template', $user->id) }}" target="_blank" class="text-slate-600 hover:text-orange-500" aria-label="عرض المتجر">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M1.5 12s4-7.5 10.5-7.5S22.5 12 22.5 12s-4 7.5-10.5 7.5S1.5 12 1.5 12z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </a>

                    @livewire('notif-bell')

                    <div class="flex items-center gap-2">
                        {{-- <span class="text-slate-800 font-bold text-sm hidden md:inline">
                            {{ $user->f_name . " " . $user->l_name ?? 'تاجر غير معروف' }}
                        </span> --}}
                        <img class="h-10 w-10 rounded-full border border-slate-300 object-cover"
                            src="{{ asset('storage/' . ($user->additional_data['profile_picture'] ?? 'default-user.png')) }}"
                            alt="User">
                    </div>
                </div>
            </header>
            <div class="sm:p-6 lg:p-8">
                @yield('content')
            </div>
        </main>
    </div>
    <script src="https://cdn.tiny.cloud/1/evqw8zgybaz9h1ukpi5qcps683qv0ef37icy3d3o5xjbo9it/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
    @livewireScripts

    {{-- دوال SweetAlert2 العامة --}}
    <script>
        // إعدادات SweetAlert2 المشتركة
        const swalConfig = {
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            customClass: {
                popup: 'swal2-rtl',
                title: 'text-lg font-bold text-gray-800',
                htmlContainer: 'text-gray-600',
                confirmButton: 'swal2-confirm-custom',
                cancelButton: 'swal2-cancel-custom'
            },
            buttonsStyling: false,
            reverseButtons: true
        };

        const swalSuccessConfig = {
            customClass: {
                popup: 'swal2-rtl',
                title: 'text-lg font-bold text-green-800',
                htmlContainer: 'text-green-600'
            },
            timer: 2000,
            showConfirmButton: false
        };
        // دالة حذف الجلسة
        function confirmDeleteSession(index, componentId) {
            Swal.fire({
                ...swalConfig,
                title: '{{ __("Are you sure?") }}',
                text: '{!! __("You won\'t be able to revert this!") !!}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '{{ __("Yes, delete it!") }}',
                cancelButtonText: '{{ __("Cancel") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    // استخدام Livewire للحذف
                    Livewire.find(componentId).call('removeSession', index);

                    Swal.fire({
                        ...swalSuccessConfig,
                        title: '{{ __("Deleted!") }}',
                        text: '{{ __("Session has been deleted.") }}',
                        icon: 'success'
                    });
                }
            });
        }

        // دالة حذف الرابط
        function confirmDeleteLink(index, componentId) {
            Swal.fire({
                ...swalConfig,
                title: '{{ __("Are you sure?") }}',
                text: '{!! __("You won\'t be able to revert this!") !!}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '{{ __("Yes, delete it!") }}',
                cancelButtonText: '{{ __("Cancel") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    // استخدام Livewire للحذف
                    Livewire.find(componentId).call('removeLink', index);

                    Swal.fire({
                        ...swalSuccessConfig,
                        title: '{{ __("Deleted!") }}',
                        text: '{{ __("Link has been deleted.") }}',
                        icon: 'success'
                    });
                }
            });
        }

        // دالة حذف الأيام المغلقة
        function confirmDeleteClosedDay(index, componentId) {
            Swal.fire({
                ...swalConfig,
                title: '{{ __("Are you sure?") }}',
                text: '{{ __("You won\'t be able to revert this!") }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '{{ __("Yes, delete it!") }}',
                cancelButtonText: '{{ __("Cancel") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    // استخدام Livewire للحذف
                    Livewire.find(componentId).call('removeClosedDay', index);

                    Swal.fire({
                        ...swalSuccessConfig,
                        title: '{{ __("Deleted!") }}',
                        text: '{{ __("Closed day has been deleted.") }}',
                        icon: 'success'
                    });
                }
            });
        }

        // دالة عامة لعرض رسائل النجاح
        function showSuccessMessage(title, text) {
            Swal.fire({
                ...swalSuccessConfig,
                title: title,
                text: text,
                icon: 'success'
            });
        }

        // دالة عامة لعرض رسائل الخطأ
        function showErrorMessage(title, text) {
            Swal.fire({
                customClass: {
                    popup: 'swal2-rtl',
                    title: 'text-lg font-bold text-red-800',
                    htmlContainer: 'text-red-600'
                },
                title: title,
                text: text,
                icon: 'error',
                confirmButtonText: '{{ __("OK") }}',
                confirmButtonColor: '#dc2626',
                buttonsStyling: false,
                customClass: {
                    ...swalConfig.customClass,
                    title: 'text-lg font-bold text-red-800',
                    htmlContainer: 'text-red-600'
                }
            });
        }
    </script>

    @stack('scripts')
</body>

</html>
