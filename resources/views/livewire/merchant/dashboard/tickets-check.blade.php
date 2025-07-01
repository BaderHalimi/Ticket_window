<div class="grid lg:grid-cols-2 gap-8">

    {{-- التحقق اليدوي --}}
    <div class="rounded-2xl border border-slate-200 bg-white shadow-lg p-6">
        <h3 class="text-xl font-semibold mb-2">التحقق اليدوي</h3>
        <p class="text-sm text-slate-500 mb-4">أدخل رقم التذكرة أو الحجز للتحقق من صلاحيته.</p>
        <input wire:model.defer="code"
               class="w-full rounded-lg border border-slate-300 px-4 py-2 mb-2 focus:ring-2 focus:ring-orange-500"
               placeholder="أدخل رقم التذكرة...">
        <button wire:click="check"
                class="w-full bg-orange-500 text-white rounded-lg py-2 font-bold hover:bg-orange-600 transition">
            تحقق الآن
        </button>

        @if ($error)
            <div class="mt-4 text-red-600">{{ $error }}</div>
        @endif
    </div>

    {{-- التحقق بالكاميرا --}}
    <div class="rounded-2xl border border-slate-200 bg-slate-50 border-dashed shadow-lg p-6 text-center">
        <h3 class="text-xl font-semibold mb-4">مسح الكود</h3>

        <video id="qr-video" class="w-full rounded-lg bg-black aspect-video mb-4" autoplay playsinline></video>

        <button wire:ignore
                onclick="startScanner()"
                class="border bg-white hover:bg-slate-100 rounded-lg py-2 px-4 font-bold">
            فتح الكاميرا للمسح
        </button>
    </div>

    {{-- عرض البيانات بعد التحقق --}}
    @if($reservation)
        <div class="lg:col-span-2 mt-8 bg-white border rounded-lg shadow p-6">
            <h4 class="text-lg font-bold text-orange-600 mb-4">بيانات التذكرة</h4>
            <p><span class="font-semibold">الكود:</span> {{ $reservation->code }}</p>
            <p><span class="font-semibold">الخدمة:</span> {{ $reservation->offering->name ?? 'غير متوفر' }}</p>
            <p><span class="font-semibold">السعر:</span> {{ $reservation->price }} ريال</p>
            <p><span class="font-semibold">الكمية:</span> {{ $reservation->quantity }}</p>
            <p><span class="font-semibold">الحالة:</span> {{ $reservation->additional_data['type'] ?? 'غير محدد' }}</p>
        </div>
    @endif

</div>

@push('scripts')
<script>
    let stream = null;

    function startScanner() {
        const video = document.getElementById('qr-video');

        if (stream) {
            video.srcObject = stream;
            return;
        }

        navigator.mediaDevices.getUserMedia({
            video: {
                facingMode: 'environment',
                frameRate: { ideal: 60, max: 60 }
            }
        })
        .then(function(mediaStream) {
            stream = mediaStream;
            video.srcObject = mediaStream;
            video.play();
        })
        .catch(function(err) {
            console.error("Error accessing camera: ", err);
            alert("فشل في فتح الكاميرا: " + err.message);
        });
    }
</script>
@endpush
