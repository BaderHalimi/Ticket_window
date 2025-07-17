@extends('layouts.app')
@section('content')
    <main class="pt-16">
        <div bis_skin_checked="1" style="opacity: 1; transform: none;">
            <div class="min-h-screen bg-orange-500/5 py-12" bis_skin_checked="1">
                <div class="container mx-auto px-4" bis_skin_checked="1">
                    <div class="max-w-2xl mx-auto" bis_skin_checked="1" style="opacity: 1; transform: none;">
                        <div class="bg-white/70 backdrop-blur-xl rounded-2xl shadow-xl p-8 md:p-10 border"
                            bis_skin_checked="1">
                            <div class="text-center mb-8" bis_skin_checked="1">
                                <div class="w-20 h-20 bg-orange-500 rounded-3xl flex items-center justify-center mx-auto mb-4 shadow-lg"
                                    bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="h-10 w-10 text-white">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg></div>
                                <h1 class="text-3xl md:text-4xl font-bold text-orange-500 mb-2">انضم كتاجر</h1>
                                <p class="text-gray-600">ابدأ رحلتك في إدارة أعمالك بكفاءة واحترافية.</p>
                            </div>
                            <form action="{{ route('signup') }}" method="POST" class="space-y-6">
                                @csrf
                                <div class="grid md:grid-cols-2 gap-6" bis_skin_checked="1">
                                    <div bis_skin_checked="1">
                                        <label class="block text-sm font-medium text-gray-700 mb-2" for="firstName">الاسم
                                            الأول</label>
                                        <input name="f_name"
                                            class="flex h-10 w-full rounded-lg border bg-white px-4 py-3 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all @error('f_name') border-red-500 @else border-slate-300 @enderror"
                                            required="" value="{{ old('f_name') }}" id="firstName"
                                            placeholder="أدخل اسمك الأول">
                                        @error('f_name')
                                            <label for="f_name" class="text-red-500">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div bis_skin_checked="1">
                                        <label class="block text-sm font-medium text-gray-700 mb-2" for="lastName">اسم
                                            العائلة</label>
                                        <input name="l_name"
                                            class="flex h-10 w-full rounded-lg border bg-white px-4 py-3 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all @error('l_name') border-red-500 @else border-slate-300 @enderror"
                                            required="" value="{{ old('l_name') }}" id="lastName"
                                            placeholder="أدخل اسم العائلة">
                                        @error('l_name')
                                            <label for="l_name" class="text-red-500">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>
                                <div bis_skin_checked="1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="email">البريد
                                        الإلكتروني</label>
                                    <input name="email" type="email"
                                        class="flex h-10 w-full rounded-lg border bg-white px-4 py-3 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                                        required="" id="email" placeholder="example@domain.com">
                                </div>
                                <div bis_skin_checked="1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="phone">رقم
                                        الهاتف</label>
                                    <input name="phone" type="tel"
                                        class="flex h-10 w-full rounded-lg border bg-white px-4 py-3 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all @error('phone') border-red-500 @else border-slate-300 @enderror"
                                        required="" id="phone" placeholder="+966 5X XXX XXXX"
                                        value="{{ old('phone') }}" pattern="\+d{3}\s5\d\s\d{3}\s\d{4}" maxlength="17">
                                    @error('phone')
                                        <label for="phone" class="text-red-500">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="grid md:grid-cols-2 gap-6" bis_skin_checked="1">
                                    <div bis_skin_checked="1">
                                        <label class="block text-sm font-medium text-gray-700 mb-2" for="password">كلمة
                                            المورور</label>
                                        <input name="password"
                                            class="flex h-10 w-full rounded-lg border bg-white px-4 py-3 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all @error('password') border-red-500 @else border-slate-300 @enderror"
                                            required="" id="password" type="password" placeholder="كلمة المرور">
                                        @error('password')
                                            <label for="password" class="text-red-500">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div bis_skin_checked="1">
                                        <label class="block text-sm font-medium text-gray-700 mb-2"
                                            for="password_confirmation">التحقق من كلمة المرور</label>
                                        <input name="password_confirmation"
                                            class="flex h-10 w-full rounded-lg border bg-white px-4 py-3 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                                            required="" type="password" id="lastName"
                                            placeholder="الحقق من كلمة المرور">
                                    </div>
                                </div>

                                <div bis_skin_checked="1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="activityType">نوع
                                        النشاط</label>
                                    <select name="business_type" required="" id="activityType"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all bg-white @error('business_type') border-red-500 @else border-slate-300 @enderror">
                                        <option @selected(old('business_type') == null || old('business_type') == '') disabled value="">اختر نوع النشاط</option>
                                        <option @selected(old('business_type') == 'events') value="events">تنظيم الفعاليات</option>
                                        <option @selected(old('business_type') == 'restaurant') value="restaurant">مطعم</option>
                                        <option @selected(old('business_type') == 'show') value="show">معارض</option>
                                        <option @selected(old('business_type') == 'other') value="other">أخرى</option>
                                    </select>
                                    @error('business_type')
                                        <label for="phone" class="text-red-500">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div id="otherInputContainer"
                                    @if (old('business_type', '') == 'other') style="display: none;" @else style="display: block;" @endif
                                    class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="otherInput">يرجى
                                        تحديد نوع النشاط</label>
                                    <input type="text" id="otherInput" name="other_business_type"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all bg-white @error('other_business_type') border-red-500 @else border-slate-300 @enderror"
                                        value="{{ old('other_business_type') }}" placeholder="اكتب نوع النشاط">
                                    @error('other_business_type')
                                        <label for="otherInput" class="text-red-500">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div bis_skin_checked="1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="businessName">اسم
                                        النشاط التجاري</label>
                                    <input name="business_name"
                                        class="flex h-10 w-full rounded-lg border bg-white px-4 py-3 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all @error('business_name') border-red-500 @else border-slate-300 @enderror"
                                        value="{{ old('business_name') }}" required="" id="businessName"
                                        placeholder="أدخل اسم نشاطك التجاري">
                                    @error('businessName')
                                        <label for="businessName" class="text-red-500">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div bis_skin_checked="1" class="text-sm">
                                    <span>عبر تقديمك طلب التسجيل فإنك بذلك تكون قد وافقت على <a class="text-blue-600 hover:underline" href="#">سياسات
                                            الخصوصية</a> و <a class="text-blue-600 hover:underline" href="#">شروط الاستخدام</a></span>
                                </div>
                                <button
                                    class="inline-flex items-center justify-center ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-orange-500 hover:bg-orange-500/90 h-11 rounded-md px-8 w-full bg-orange-500 text-white py-6 text-lg font-semibold transform hover:scale-105 transition-transform"
                                    type="submit">إرسال طلب التسجيل</button>
                            </form>
                            <div class="text-center mt-4">هل لديك حساب؟ <a href="{{ route('login') }}"
                                    class="text-orange-500 font-bold">تسجيل الدخول</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        const activitySelect = document.getElementById("activityType");
        const otherInputContainer = document.getElementById("otherInputContainer");
        const otherInput = document.getElementById("otherInput");

        activitySelect.addEventListener("change", function() {
            if (this.value === "other") {
                otherInputContainer.style.display = "block";
                otherInput.required = true;
            } else {
                otherInputContainer.style.display = "none";
                otherInput.required = false;
            }
        });
    </script>
@endsection
