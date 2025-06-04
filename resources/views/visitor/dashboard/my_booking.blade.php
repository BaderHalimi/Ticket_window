@extends('visitor.layouts.app')
@section('title', 'My Tickets - ')

@push('styles')
<style>
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

    .card-hover:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 15px 30px rgba(87, 181, 231, 0.1);
    }

    /* مودال QR */
    .qr-modal {
        position: fixed !important;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999 !important;
    }

    .qr-modal.active {
        display: flex;
    }

    .qr-modal .modal-content {
        background: white;
        border-radius: 12px;
        padding: 20px;
        width: 320px;
        text-align: center;
        position: relative;
    }

    .qr-modal button {
        cursor: pointer;
    }
</style>
@endpush


@section('sub_content')

<div class="max-w-5xl mx-auto py-10">
    <h2 class="text-3xl font-bold text-indigo-900 mb-8">My Bookings</h2>

    <div class="space-y-6">
        <!-- Booking Card -->
        @foreach($bookings as $booking)
        @php

        //$data = $ticket->event??$ticket->additional_data->event;
        $formatted_y = \Carbon\Carbon::parse($booking->branch->open_at)->format('h:i A');
        $formatted_h = \Carbon\Carbon::parse($booking->branch->close_at)->format('h:i A');
        @endphp

        <div class="glassmorphism p-6 rounded-xl transition-all duration-300 card-hover flex justify-between items-center">
            <div class="flex items-center space-x-4">
            <div class="bg-indigo-100 rounded-full flex items-center justify-center">
                <img src="{{Storage::url($booking->branch->image)  }}" alt="" class="h-20 w-full rounded-md object-cover">

            </div>

            <div>
                <h3 class="text-xl font-semibold">{{ $booking->branch->name }}</h3>
                <p class="text-sm text-gray-600">{{ $formatted_y }} • {{ $formatted_h }}</p>
                <p class="text-sm text-gray-600">code : {{ $booking->code }}</p>
            </div>
            <div class="flex flex-col items-end">
                <span class="px-4 py-1 rounded-full text-sm font-medium
                    @if($booking->status == 'confirmed') status-confirmed
                    @elseif($booking->status == 'pending') status-pending
                    @else status-canceled @endif">
                    {{ ucfirst($booking->status) }}
                </span>

                <div class="flex mt-4 space-x-2">
                    <a href="#" class="view-qr-btn flex items-center gap-1 bg-white hover:bg-gray-600 hover:border-gray-600 hover:text-white px-4 py-2 rounded-full border border-gray-200 text-sm transition duration-50"
                    data-code="{{ $booking->code }}">
                    <i class="ri-qr-code-line ri-sm"></i> View QR
                </a>

                    <a href="{{-- route('visitor.download_pdf', $booking->id) --}}" class="flex items-center gap-1 bg-white px-3 py-1.5 rounded-full border border-gray-200 text-sm">
                        <i class="ri-file-pdf-line ri-sm"></i> PDF
                    </a>
                    @if($booking->status == 'pending')
                    <form action ="{{route('visitor.my_bookings.pay', $booking->id)}} " method="POST"><button type="submit" class="flex items-center gap-1 bg-white px-3 py-1.5 rounded-full border border-gray-200 text-sm">
                    @csrf
                        <i class="ri-bank-card-line ri-sm"></i> Pay Now
                    </button>
                    </form>
                    @endif
                    @if($booking->status == 'canceled')
                    <a href="{{-- route('visitor.rebook', $booking->id) --}}" class="flex items-center gap-1 bg-white px-3 py-1.5 rounded-full border border-gray-200 text-sm">
                        <i class="ri-refresh-line ri-sm"></i> Rebook
                    </a>
                    @endif
                </div>
                
            </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection


<!-- مودال QR -->
<div id="qr-modal" class="fixed top-0 right-0 w-full z-50 glassmorphism qr-modal">
    <div class="modal-content text-center">
        <div id="qr-code-container" class="mb-4 text-center px-4"></div>

        <button id="download-btn" class="download-btn bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-2">
            Download
        </button>


        <button id="close-qr-btn" class="close-qr-btn text-gray-500 px-4 py-2 rounded hover:bg-red-500 hover:text-white mt-2">Close</button>
    </div>
</div>


@push('scripts')
<!-- تضمين مكتبة QRCode.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const modal = document.getElementById('qr-modal');
        const qrContainer = document.getElementById('qr-code-container');
        const closeBtn = document.getElementById('close-qr-btn');
        const downloadBtn = document.getElementById('download-btn');
        let qrInstance = null;

        // عند الضغط على زر View QR
        document.querySelectorAll('.view-qr-btn').forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault();

                // حذف QR السابق لو موجود
                qrContainer.innerHTML = "";

                // جلب الكود من data attribute
                const code = btn.getAttribute('data-code');

                // انشاء QR جديد
                qrInstance = new QRCode(qrContainer, {
                    text: code,
                });

                // عرض المودال
                modal.classList.add('active');
            });
        });

        // إغلاق المودال
        closeBtn.addEventListener('click', () => {
            modal.classList.remove('active');
            qrContainer.innerHTML = "";
        });

        // تحميل صورة QR
        downloadBtn.addEventListener('click', () => {
            const img = qrContainer.querySelector('img');
            if (img) {
                const link = document.createElement('a');
                link.href = img.src;
                link.download = 'qr-ticket.png';
                link.click();
            }
        });

        // إغلاق المودال عند الضغط خارج المحتوى (اختياري)
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('active');
                qrContainer.innerHTML = "";
            }
        });
    });
</script>
@endpush

@section('sub_content')

<div class="max-w-5xl mx-auto py-10">
    <h2 class="text-3xl font-bold text-indigo-900 mb-8">My Bookings</h2>

    <div class="space-y-6">
        <!-- Booking Card -->
        @foreach($bookings as $booking)
        @php

        //$data = $ticket->event??$ticket->additional_data->event;
        $formatted_y = \Carbon\Carbon::parse($booking->branch->open_at)->format('h:i A');
        $formatted_h = \Carbon\Carbon::parse($booking->branch->close_at)->format('h:i A');
        @endphp

        <div class="glassmorphism p-6 rounded-xl transition-all duration-300 card-hover flex justify-between items-center">
            <div class="flex items-center space-x-4">
            <div class="bg-indigo-100 rounded-full flex items-center justify-center">
                <img src="{{Storage::url($booking->branch->image)  }}" alt="" class="h-20 w-full rounded-md object-cover">

            </div>

            <div>
                <h3 class="text-xl font-semibold">{{ $booking->branch->name }}</h3>
                <p class="text-sm text-gray-600">{{ $formatted_y }} • {{ $formatted_h }}</p>
                <p class="text-sm text-gray-600">code : {{ $booking->code }}</p>
            </div>
            <div class="flex flex-col items-end">
                <span class="px-4 py-1 rounded-full text-sm font-medium
                    @if($booking->status == 'confirmed') status-confirmed
                    @elseif($booking->status == 'pending') status-pending
                    @else status-canceled @endif">
                    {{ ucfirst($booking->status) }}
                </span>

                <div class="flex mt-4 space-x-2">
                    <a href="#" class="view-qr-btn flex items-center gap-1 bg-white hover:bg-gray-600 hover:border-gray-600 hover:text-white px-4 py-2 rounded-full border border-gray-200 text-sm transition duration-50"
                    data-code="{{ $booking->code }}">
                    <i class="ri-qr-code-line ri-sm"></i> View QR
                </a>

                    <a href="{{-- route('visitor.download_pdf', $booking->id) --}}" class="flex items-center gap-1 bg-white px-3 py-1.5 rounded-full border border-gray-200 text-sm">
                        <i class="ri-file-pdf-line ri-sm"></i> PDF
                    </a>
                    @if($booking->status == 'pending')
                    <a href="{{-- route('visitor.pay_now', $booking->id) --}}" class="flex items-center gap-1 bg-white px-3 py-1.5 rounded-full border border-gray-200 text-sm">
                        <i class="ri-bank-card-line ri-sm"></i> Pay Now
                    </a>
                    @endif
                    @if($booking->status == 'canceled')
                    <a href="{{-- route('visitor.rebook', $booking->id) --}}" class="flex items-center gap-1 bg-white px-3 py-1.5 rounded-full border border-gray-200 text-sm">
                        <i class="ri-refresh-line ri-sm"></i> Rebook
                    </a>
                    @endif
                </div>
                
            </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection


<!-- مودال QR -->
<div id="qr-modal" class="fixed top-0 right-0 w-full z-50 glassmorphism qr-modal">
    <div class="modal-content text-center">
        <div id="qr-code-container" class="mb-4 text-center px-4"></div>

        <button id="download-btn" class="download-btn bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-2">
            Download
        </button>


        <button id="close-qr-btn" class="close-qr-btn text-gray-500 px-4 py-2 rounded hover:bg-red-500 hover:text-white mt-2">Close</button>
    </div>
</div>


@push('scripts')
<!-- تضمين مكتبة QRCode.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const modal = document.getElementById('qr-modal');
        const qrContainer = document.getElementById('qr-code-container');
        const closeBtn = document.getElementById('close-qr-btn');
        const downloadBtn = document.getElementById('download-btn');
        let qrInstance = null;

        // عند الضغط على زر View QR
        document.querySelectorAll('.view-qr-btn').forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault();

                // حذف QR السابق لو موجود
                qrContainer.innerHTML = "";

                // جلب الكود من data attribute
                const code = btn.getAttribute('data-code');

                // انشاء QR جديد
                qrInstance = new QRCode(qrContainer, {
                    text: code,
                });

                // عرض المودال
                modal.classList.add('active');
            });
        });

        // إغلاق المودال
        closeBtn.addEventListener('click', () => {
            modal.classList.remove('active');
            qrContainer.innerHTML = "";
        });

        // تحميل صورة QR
        downloadBtn.addEventListener('click', () => {
            const img = qrContainer.querySelector('img');
            if (img) {
                const link = document.createElement('a');
                link.href = img.src;
                link.download = 'qr-ticket.png';
                link.click();
            }
        });

        // إغلاق المودال عند الضغط خارج المحتوى (اختياري)
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('active');
                qrContainer.innerHTML = "";
            }
        });
    });
</script>
@endpush
