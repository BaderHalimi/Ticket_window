@extends('customer.layouts.app')

@section('content')
<div class="opacity-100">
    <div class="space-y-6">
        <!-- عنوان الصفحة -->
        <div>
            <h1 class="text-3xl font-bold text-slate-800">حجوزاتي</h1>
            <p class="text-slate-500 mt-1">جميع حجوزاتك السابقة والقادمة.</p>
        </div>

        <!-- صندوق الحجوزات -->
        <div class="rounded-2xl border border-slate-200 bg-white shadow-lg">
            <div class="p-6">
                <div class="overflow-auto">
                    <table class="w-full text-sm border-separate border-spacing-y-2">
                        <thead>
                            <tr class="text-right text-slate-600">
                                <th class="px-4 py-2">Code</th>
                                <th class="px-4 py-2">Title</th>
                                <th class="px-4 py-2">Location</th>
                                <th class="px-4 py-2">Time</th>
                                <th class="px-4 py-2">Price</th>
                                <th class="px-4 py-2 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($Reservations as $reservation)
                                @php
                                    $offering = $reservation->offering;
                                    $features = is_string($offering->features ?? '') ? json_decode($offering->features) : (object) ($offering->features ?? []);
                                @endphp
                                <tr class="bg-white shadow-sm rounded-md">
                                    <td class="px-4 py-2 font-medium">
                                        {{ $reservation->code }}
                                    </td>
                                    <td class="px-4 py-2">{{ $offering->name ?? '—' }}</td>
                                    <td class="px-4 py-2">{{ $offering->location ?? '—' }}</td>
                                    <td class="px-4 py-2">{{ $offering->start_time ? $offering->start_time->format('Y-m-d H:i') : '—' }}</td>
                                    <td class="px-4 py-2">{{ $reservation->price }} SAR</td>
                                    <td class="px-4 py-2 text-center flex justify-center gap-2">
                                        <!-- QR Icon -->
                                        <button onclick="showQR(`{{ $reservation->code }}`)" class="text-gray-600 hover:text-black text-xl">
                                            <i class="ri-qr-code-line"></i>
                                        </button>

                                        <!-- PDF Icon -->
                                        <button onclick="downloadPDF({{ json_encode([
                                            'code' => $reservation->code,
                                            'type' => $reservation->item_type === 'event' ? 'Event Ticket' : 'Table Booking',
                                            'title' => $offering->name,
                                            'location' => $offering->location,
                                            'time' => $offering->start_time,
                                            'price' => $reservation->price
                                        ]) }})" class="text-gray-600 hover:text-black text-xl">
                                            <i class="ri-file-pdf-line"></i>
                                        </button>

                                        <!-- Cancel Icon -->
                                        @if (!empty($features->enable_cancellation) && $features->enable_cancellation)
                                            <button onclick="cancelReservation('{{ route('customer.dashboard.tickets.cancel', $reservation->id) }}')"
                                                    class="text-red-600 hover:text-red-800 text-xl">
                                                <i class="ri-close-circle-line"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-slate-500 py-4">No reservations yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- QR Popup -->
<div id="qrPopup" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg text-center w-96">
        <div id="qrContainer" class="mb-4 w-100 flex justify-center"></div>
        <a id="downloadQRBtn" href="#" download="qr-code.png"
           class="w-full block bg-green-600 text-white py-2 rounded hover:bg-green-700 text-sm">Download QR</a>
        <button onclick="hideQR()" class="w-full mt-2 text-red-600 hover:underline text-sm">Close</button>
    </div>
</div>

<!-- Libraries -->
<link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
    let currentQR;

    function showQR(code) {
        const canvas = document.createElement('canvas');
        const qr = new QRious({
            element: canvas,
            value: code,
            size: 200,
        });
        currentQR = canvas.toDataURL('image/png');
        document.getElementById('qrContainer').innerHTML = '';
        document.getElementById('qrContainer').appendChild(canvas);
        document.getElementById('downloadQRBtn').href = currentQR;
        document.getElementById('qrPopup').classList.remove('hidden');
    }

    function hideQR() {
        document.getElementById('qrPopup').classList.add('hidden');
        document.getElementById('qrContainer').innerHTML = '';
    }

    function downloadPDF(data) {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        doc.setFontSize(14);
        doc.text(`Reservation Details`, 10, 20);
        doc.setFontSize(12);
        doc.text(`Code: ${data.code}`, 10, 30);
        doc.text(`Type: ${data.type}`, 10, 40);
        doc.text(`Title: ${data.title}`, 10, 50);
        doc.text(`Location: ${data.location}`, 10, 60);
        doc.text(`Time: ${data.time}`, 10, 70);
        doc.text(`Price: $${data.price}`, 10, 80);

        doc.save(`reservation-${data.code}.pdf`);
    }

    function cancelReservation(url) {
        if (confirm('هل أنت متأكد أنك تريد إلغاء هذا الحجز؟')) {
            window.location.href = url;
        }
    }
</script>
@endsection
