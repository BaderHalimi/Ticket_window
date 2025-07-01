<div class="grid lg:grid-cols-2 gap-8">

    {{-- Manual Verification --}}
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

    {{-- QR Code Scanner --}}
    <div class="rounded-2xl border border-slate-200 bg-slate-50 border-dashed shadow-lg p-6 text-center">
        <h3 class="text-xl font-semibold mb-4">مسح الكود</h3>

        <div id="qr-reader" class="w-full rounded-lg bg-black aspect-video mb-4"></div>
        <div id="qr-result" class="hidden text-green-600 font-semibold mb-2">تم مسح الكود بنجاح!</div>

        <button id="start-scanner"
                class="border bg-white hover:bg-slate-100 rounded-lg py-2 px-4 font-bold">
            فتح الكاميرا للمسح
        </button>
        <button id="stop-scanner"
                class="hidden border bg-red-500 text-white hover:bg-red-600 rounded-lg py-2 px-4 font-bold">
            إيقاف المسح
        </button>
    </div>

    {{-- Display verification results --}}
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
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    let qrScanner = null;

    document.addEventListener('DOMContentLoaded', function() {
        const startBtn = document.getElementById('start-scanner');
        const stopBtn = document.getElementById('stop-scanner');
        const qrResult = document.getElementById('qr-result');

        startBtn.addEventListener('click', startScanner);
        stopBtn.addEventListener('click', stopScanner);

        function startScanner() {
            if (qrScanner) return; // بالفعل يعمل

            qrScanner = new Html5Qrcode("qr-reader");

            qrScanner.start(
                { facingMode: "environment" },
                {
                    fps: 10,
                    qrbox: 250
                },
                (decodedText, decodedResult) => {
                    qrResult.classList.remove('hidden');
                    stopScanner();

                    // إرسال الكود إلى Livewire
                    @this.set('code', decodedText);
                    @this.check();
                },
                (errorMessage) => {
                    // تجاهل الأخطاء اللحظية (اختياري)
                    console.log(errorMessage);
                })
                .then(() => {
                    startBtn.classList.add('hidden');
                    stopBtn.classList.remove('hidden');
                })
                .catch((err) => {
                    console.error(err);
                    alert('حدث خطأ أثناء تشغيل الماسح');
                });
        }

        function stopScanner() {
            if (qrScanner) {
                qrScanner.stop().then(() => {
                    qrScanner.clear();
                    qrScanner = null;
                    startBtn.classList.remove('hidden');
                    stopBtn.classList.add('hidden');
                }).catch((err) => {
                    console.error('حدث خطأ عند إيقاف الماسح', err);
                });
            }
        }

        document.addEventListener('livewire:update', function() {
            stopScanner();
        });
    });
</script>
@endpush
