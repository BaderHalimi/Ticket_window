@extends('merchant.layouts.app')
@section('content')
<div class="flex-1 p-8" bis_skin_checked="1">
    <div bis_skin_checked="1" style="opacity: 1; transform: none;">
        <div class="space-y-8" bis_skin_checked="1">
            <div class="flex justify-between items-center" bis_skin_checked="1">
                <h2 class="text-3xl font-bold text-slate-800">التحقق من التذاكر</h2>
            </div>
            <div class="grid lg:grid-cols-2 gap-8" bis_skin_checked="1">
                <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg" bis_skin_checked="1">
                    <div class="flex flex-col space-y-1.5 p-6" bis_skin_checked="1">
                        <h3 class="text-xl font-semibold leading-none tracking-tight flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ticket">
                                <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path>
                                <path d="M13 5v2"></path>
                                <path d="M13 17v2"></path>
                                <path d="M13 11v2"></path>
                            </svg> التحقق اليدوي</h3>
                        <p class="text-sm text-slate-500">أدخل رقم التذكرة أو الحجز للتحقق من صلاحيته.</p>
                    </div>
                    <div class="p-6 pt-0 space-y-4" bis_skin_checked="1"><input class="flex h-10 w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all" placeholder="أدخل رقم التذكرة..." value=""><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-orange-500 hover:bg-orange-500/90 h-10 px-4 py-2 w-full bg-orange-500 text-white">تحقق الآن</button></div>
                </div>
                <div class="rounded-2xl border border-slate-200 text-slate-900 shadow-lg flex flex-col items-center justify-center bg-slate-50 border-dashed" bis_skin_checked="1">
                    <div class="flex flex-col space-y-1.5 p-6" bis_skin_checked="1">
                        <h3 class="text-xl font-semibold leading-none tracking-tight flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-qr-code">
                                <rect width="5" height="5" x="3" y="3" rx="1"></rect>
                                <rect width="5" height="5" x="16" y="3" rx="1"></rect>
                                <rect width="5" height="5" x="3" y="16" rx="1"></rect>
                                <path d="M21 16h-3a2 2 0 0 0-2 2v3"></path>
                                <path d="M21 21v.01"></path>
                                <path d="M12 7v3a2 2 0 0 1-2 2H7"></path>
                                <path d="M3 12h.01"></path>
                                <path d="M12 3h.01"></path>
                                <path d="M12 16v.01"></path>
                                <path d="M16 12h1"></path>
                                <path d="M21 12v.01"></path>
                                <path d="M12 21v-1"></path>
                            </svg> مسح الكود</h3>
                    </div>
                    <div class="p-6 pt-0 text-center" bis_skin_checked="1"><img alt="QR Code Scanner" class="w-32 h-32 mx-auto mb-4" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&amp;data=Example"><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">فتح كاميرا المسح</button></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
