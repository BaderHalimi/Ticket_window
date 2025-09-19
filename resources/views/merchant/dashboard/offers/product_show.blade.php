@extends('merchant.layouts.app', ['merchant' => $merchantid ?? false])
@section('content')
    <div class="max-w-7xl mx-auto p-8 bg-white rounded-xl shadow-lg mt-8">
        {{-- قسم الأسئلة المطلوبة من المستخدم --}}


        @if ($offer->type == 'events' && !empty($offer->calendar))
            <div class="mb-8 border rounded-lg p-6 bg-gradient-to-r from-purple-50 to-pink-50 shadow">
                <h3 class="text-lg font-bold mb-4 text-gray-800 flex items-center">
                    <i class="ri-calendar-event-line mr-2 text-purple-600"></i>
                    {{ __('تواريخ الفعاليات') }}
                </h3>
                @foreach ($offer->calendar as $i => $event)
                    <div class="border rounded-lg p-4 mb-4 bg-white shadow-sm">
                        <div class="font-bold text-purple-700 mb-2">{{ __('فعالية') }} #{{ $i + 1 }}</div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-gray-700">
                            <div>
                                <span>{{ __('تاريخ البداية') }}: <b>{{ $event['start_date'] ?? '-' }}</b></span>
                            </div>
                            <div>
                                <span>{{ __('تاريخ النهاية') }}: <b>{{ $event['end_date'] ?? '-' }}</b></span>
                            </div>
                            <div>
                                <span>{{ __('وقت البداية') }}: <b>{{ $event['start_time'] ?? '-' }}</b></span>
                            </div>
                            <div>
                                <span>{{ __('وقت النهاية') }}: <b>{{ $event['end_time'] ?? '-' }}</b></span>
                            </div>
                        </div>
                    </div>
                @endforeach
                @if (count($offer->calendar) == 0)
                    <div class="text-center py-8 text-gray-500">
                        <i class="ri-calendar-line text-4xl mb-2"></i>
                        <p>{{ __('لا توجد فعاليات مضافة') }}</p>
                    </div>
                @endif
            </div>
        @endif
        <div class="flex flex-col md:flex-row gap-8">
            <!-- صورة المنتج -->
            <div class="flex-shrink-0 w-full md:w-1/3 flex items-start justify-center">
                <img src="{{ Storage::url($offer->image ?? '/img/ad-placeholder.jpg') }}" alt="صورة المنتج"
                    class="rounded-lg w-100 h-60 object-cover border">
            </div>
            <!-- تفاصيل المنتج -->
            <div class="flex-1 flex flex-col justify-between">
                <div>
                    <!-- قسم المعلومات الأساسية -->
                    <h2 class="text-3xl font-bold text-slate-800 mb-2">{{ $offer->name }}</h2>
                    <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <span class="font-semibold text-slate-700">النوع:</span>
                            <span class="text-slate-600">{{ $offer->type ?? ($offer->features['type'] ?? '-') }}</span>
                        </div>
                        <div>
                            <span class="font-semibold text-slate-700">الفئة الرئيسية:</span>
                            <span
                                class="text-slate-600">{{ $offer->category ?? ($offer->features['category'] ?? '-') }}</span>
                        </div>
                        <div>
                            <span class="font-semibold text-slate-700">الفئة الفرعية/الخدمة الفعلية:</span>
                            <span
                                class="text-slate-600">{{ $offer->services_type ?? ($offer->features['services_type'] ?? '-') }}</span>
                        </div>
                        <div>
                            <span class="font-semibold text-slate-700">الموقع:</span>
                            <span
                                class="text-slate-600">{{ $offer->location ?? ($offer->features['location'] ?? '-') }}</span>
                        </div>
                        @if (isset($offer->center) || isset($offer->features['center']))
                            <div>
                                <span class="font-semibold text-slate-700">مركزية الخدمة:</span>
                                <span class="text-slate-600">{{ $offer->center ?? $offer->features['center'] }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- قسم الوصف التفصيلي -->
                    <div class="mb-6">
                        <span class="font-semibold text-slate-700">الوصف:</span>
                        <p class="text-base text-gray-600 mt-2">
                            {{ $offer->description ?? ($offer->features['description'] ?? '-') }}</p>
                    </div>

                    <!-- قسم إعدادات الحجز والجدولة -->
                    @php $f = $offer->features ?? []; @endphp

                    @if (!empty($f['booking_duration']))
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">مدة الحجز:</span>
                            <span class="ml-2">{{ $f['booking_duration'] }}
                                {{ $f['booking_unit'] == 'hour' ? 'ساعة' : 'دقيقة' }}</span>
                        </div>
                    @endif

                    @if (!empty($f['work_schedule']))
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">جدول أيام وساعات العمل:</span>
                            <table class="w-full mt-2 border rounded-lg overflow-hidden">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="p-2">اليوم</th>
                                        <th class="p-2">وقت البدء</th>
                                        <th class="p-2">وقت الإغلاق</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($f['work_schedule'] as $day => $info)
                                        @if (!empty($info['enabled']))
                                            <tr class="border-b">
                                                <td class="p-2">{{ __($day) }}</td>
                                                <td class="p-2">{{ $info['start'] ?? '-' }}</td>
                                                <td class="p-2">{{ $info['end'] ?? '-' }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if (!empty($f['closed_days']))
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">الأيام المغلقة:</span>
                            <ul class="list-disc list-inside text-sm text-slate-700 mt-2">
                                @foreach ($f['closed_days'] as $day)
                                    <li>{{ $day }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (!empty($f['user_limit']))
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">عدد المستخدمين المسموح به لكل حجز:</span>
                            <span class="ml-2">{{ $f['user_limit'] }}</span>
                        </div>
                    @endif

                    @if (!empty($f['max_user_time']))
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">الحد الأقصى للحجز في نفس الوقت:</span>
                            <span class="ml-2">{{ $f['max_user_time'] }} لكل {{ $f['max_user_unit'] ?? '-' }}</span>
                        </div>
                    @endif

                    @if (!empty($f['eventMaxQuantity']))
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">الحد الأقصى للمشاركين في الفعالية:</span>
                            <span class="ml-2">{{ $f['eventMaxQuantity'] }}</span>
                        </div>
                    @endif

                    @if (!empty($f['booking_deadline_minutes']))
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">موعد إغلاق الحجز قبل البدء:</span>
                            <span class="ml-2">{{ $f['booking_deadline_minutes'] }} دقيقة</span>
                        </div>
                    @endif

                    @if (!empty($f['selected_branches']))
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">الفروع المقدمة للخدمة:</span>
                            <ul class="list-disc list-inside text-sm text-slate-700 mt-2">
                                @foreach ($f['selected_branches'] as $branch)
                                    <li>{{ $branch }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @php $f = $offer->features ?? []; @endphp

                    @if (!empty($f['sessions']))
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">الجلسات:</span>
                            <table class="w-full mt-2 border rounded-lg overflow-hidden">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="p-2">المتحدث</th>
                                        <th class="p-2">التاريخ</th>
                                        <th class="p-2">الوقت</th>
                                        <th class="p-2">المكان</th>
                                        <th class="p-2">الوصف</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($f['sessions'] as $session)
                                        <tr class="border-b">
                                            <td class="p-2">{{ $session['speaker'] ?? '-' }}</td>
                                            <td class="p-2">{{ $session['date'] ?? '-' }}</td>
                                            <td class="p-2">{{ $session['time'] ?? '-' }}</td>
                                            <td class="p-2">{{ $session['location'] ?? '-' }}</td>
                                            <td class="p-2">{{ $session['description'] ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if (!empty($f['destination']))
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">الوجهات السياحية:</span>
                            <ul class="list-disc list-inside text-sm text-slate-700 mt-2">
                                @foreach ($f['destination'] as $dest)
                                    <li>{{ $dest['name'] ?? '-' }} - {{ $dest['description'] ?? '-' }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (!empty($f['products']))
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">المنتجات:</span>
                            <ul class="list-disc list-inside text-sm text-slate-700 mt-2">
                                @foreach ($f['products'] as $prod)
                                    <li>{{ $prod['name'] ?? '-' }} - {{ $prod['description'] ?? '-' }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (!empty($f['support_devices']))
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">الأجهزة المدعومة:</span>
                            <ul class="list-disc list-inside text-sm text-slate-700 mt-2">
                                @foreach ($f['support_devices'] as $dev)
                                    <li>{{ $dev['name'] ?? '-' }} - {{ $dev['description'] ?? '-' }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (!empty($f['train_workshops']))
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">ورش العمل:</span>
                            <ul class="list-disc list-inside text-sm text-slate-700 mt-2">
                                @foreach ($f['train_workshops'] as $ws)
                                    <li>{{ $ws['name'] ?? '-' }} - {{ $ws['description'] ?? '-' }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (!empty($f['eventlinks']))
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">روابط الفعالية:</span>
                            <ul class="list-disc list-inside text-sm text-slate-700 mt-2">
                                @foreach ($f['eventlinks'] as $link)
                                    <li><a href="{{ $link['url'] ?? '#' }}" class="text-blue-600 underline"
                                            target="_blank">{{ $link['title'] ?? $link['url'] }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (!empty($f['games']))
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">الألعاب:</span>
                            <ul class="list-disc list-inside text-sm text-slate-700 mt-2">
                                @foreach ($f['games'] as $game)
                                    <li>{{ $game['name'] ?? '-' }} - {{ $game['description'] ?? '-' }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (!empty($f['kidshops']))
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">متاجر الأطفال:</span>
                            <ul class="list-disc list-inside text-sm text-slate-700 mt-2">
                                @foreach ($f['kidshops'] as $shop)
                                    <li>{{ $shop['name'] ?? '-' }} - {{ $shop['description'] ?? '-' }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (!empty($f['cartoons']))
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">الكرتون:</span>
                            <ul class="list-disc list-inside text-sm text-slate-700 mt-2">
                                @foreach ($f['cartoons'] as $cartoon)
                                    <li>{{ $cartoon['name'] ?? '-' }} - {{ $cartoon['description'] ?? '-' }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (!empty($f['portfolio']))
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">البورتفوليو:</span>
                            <ul class="list-disc list-inside text-sm text-slate-700 mt-2">
                                @foreach ($f['portfolio'] as $item)
                                    <li>{{ $item['title'] ?? '-' }} - {{ $item['description'] ?? '-' }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (!empty($f['speakers']))
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">المتحدثون:</span>
                            <ul class="list-disc list-inside text-sm text-slate-700 mt-2">
                                @foreach ($f['speakers'] as $sp)
                                    <li>{{ $sp['name'] ?? '-' }} - {{ $sp['bio'] ?? '-' }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (!empty($f['sponsors']))
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">الرعاة:</span>
                            <ul class="list-disc list-inside text-sm text-slate-700 mt-2">
                                @foreach ($f['sponsors'] as $sponsor)
                                    <li>{{ $sponsor['name'] ?? '-' }} - {{ $sponsor['description'] ?? '-' }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (!empty($f['activities']))
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">الأنشطة:</span>
                            <ul class="list-disc list-inside text-sm text-slate-700 mt-2">
                                @foreach ($f['activities'] as $act)
                                    <li>{{ $act['name'] ?? '-' }} - {{ $act['description'] ?? '-' }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (!empty($f['services']))
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">الخدمات:</span>
                            <ul class="list-disc list-inside text-sm text-slate-700 mt-2">
                                @foreach ($f['services'] as $serv)
                                    <li>{{ $serv['name'] ?? '-' }} - {{ $serv['description'] ?? '-' }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (!empty($f['tools']))
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">الأدوات:</span>
                            <ul class="list-disc list-inside text-sm text-slate-700 mt-2">
                                @foreach ($f['tools'] as $tool)
                                    <li>{{ $tool['name'] ?? '-' }} - {{ $tool['description'] ?? '-' }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- قسم الأسعار والعروض الترويجية -->
                    <div class="mb-8">
                        <span class="font-semibold text-slate-700 text-lg">السعر الأساسي:</span>
                        <span
                            class="text-2xl font-bold text-orange-600 ml-2">{{ $offer->price ?? ($offer->features['base_price'] ?? '-') }}
                            ريال</span>
                    </div>

                    @if (!empty($offer->features['coupons']))
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">الكوبونات المتاحة:</span>
                            <table class="w-full mt-2 border rounded-lg overflow-hidden">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="p-2">الكود</th>
                                        <th class="p-2">نوع الخصم</th>
                                        <th class="p-2">قيمة الخصم</th>
                                        <th class="p-2">تاريخ الانتهاء</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($offer->features['coupons'] as $coupon)
                                        <tr class="border-b">
                                            <td class="p-2">{{ $coupon['code'] }}</td>
                                            <td class="p-2">
                                                {{ $coupon['type'] == 'percentage' ? 'نسبة مئوية' : 'مبلغ ثابت' }}</td>
                                            <td class="p-2">
                                                {{ $coupon['discount'] }}{{ $coupon['type'] == 'percentage' ? '%' : ' ريال' }}
                                            </td>
                                            <td class="p-2">{{ $coupon['expires_at'] ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if (!empty($offer->features['enable_discounts']) && $offer->features['enable_discounts'])
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">الخصومات المجدولة:</span>
                            <div
                                class="bg-gradient-to-r from-emerald-50 to-green-50 rounded-lg p-4 border border-emerald-200 mt-2">
                                <div class="flex flex-col md:flex-row md:items-center gap-4">
                                    <div>
                                        <span class="font-semibold">تاريخ البداية:</span>
                                        <span>{{ $offer->features['discount_start'] ?? '-' }}</span>
                                    </div>
                                    <div>
                                        <span class="font-semibold">تاريخ النهاية:</span>
                                        <span>{{ $offer->features['discount_end'] ?? '-' }}</span>
                                    </div>
                                    <div>
                                        <span class="font-semibold">نسبة الخصم:</span>
                                        <span>{{ $offer->features['discount_percent'] ?? '-' }}%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (!empty($offer->features['enable_cancellation']) && $offer->features['enable_cancellation'])
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">سياسة الإلغاء:</span>
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-2">
                                <div class="flex flex-col md:flex-row md:items-center gap-4">
                                    <div>
                                        <span class="font-semibold">رسوم الإلغاء:</span>
                                        <span>{{ $offer->features['cancellation_fee'] ?? '-' }}%</span>
                                    </div>
                                    <div>
                                        <span class="font-semibold">آخر وقت للإلغاء:</span>
                                        <span>{{ $offer->features['cancellation_deadline_minutes'] ?? '-' }} دقيقة قبل
                                            البدء</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (
                        !empty($offer->features['enable_pricing_packages']) &&
                            $offer->features['enable_pricing_packages'] &&
                            !empty($offer->features['pricing_packages']))
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">الباقات:</span>
                            <table class="w-full mt-2 border rounded-lg overflow-hidden">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="p-2">اسم الباقة</th>
                                        <th class="p-2">السعر</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($offer->features['pricing_packages'] as $pkg)
                                        <tr class="border-b">
                                            <td class="p-2">{{ $pkg['label'] }}</td>
                                            <td class="p-2">{{ $pkg['price'] }} ريال</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    <div class="mb-4">
                        <span class="font-semibold text-slate-700">نوع الخدمة:</span>
                        <span class="text-slate-600">{{ $offer->features['type'] ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <span class="font-semibold text-slate-700">تاريخ الحجز الأقصى:</span>
                        <span class="text-slate-600">{{ $offer->features['max_reservation_date'] ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <span class="font-semibold text-slate-700">سياسة الإلغاء:</span>
                        <span class="text-slate-600">{{ $offer->features['enable_cancellation'] ? 'مسموح' : 'غير مسموح' }}
                            @if ($offer->features['enable_cancellation'])
                                (رسوم الإلغاء: {{ $offer->features['cancellation_fee'] }} ريال، قبل
                                {{ $offer->features['cancellation_deadline_minutes'] }} دقيقة)
                            @endif
                        </span>
                    </div>
                    <div class="mb-4">
                        <span class="font-semibold text-slate-700">الكوبونات المتاحة:</span>
                        @if (!empty($offer->features['coupons']))
                            <ul class="list-disc list-inside text-sm text-slate-700 mt-2">
                                @foreach ($offer->features['coupons'] as $coupon)
                                    <li>كود: <span class="font-bold">{{ $coupon['code'] }}</span> - خصم:
                                        {{ $coupon['discount'] }}% - ينتهي: {{ $coupon['expires_at'] }}</li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-slate-600">لا يوجد</span>
                        @endif
                    </div>
                    <div class="mb-8">
                        <span class="font-semibold text-slate-700 text-lg">أيام العمل:</span>
                        <table class="w-full mt-2 border rounded-lg overflow-hidden">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-2 text-right">اليوم</th>
                                    <th class="p-2 text-right">من</th>
                                    <th class="p-2 text-right">إلى</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($offer->features['days'] as $day => $times)
                                    <tr class="border-b">
                                        <td class="p-2">{{ __($day) }}</td>
                                        <td class="p-2">{{ $times['from'] }}</td>
                                        <td class="p-2">{{ $times['to'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if (!empty($offer->features['Offerfeatures']))
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">مزايا العرض:</span>
                            <table class="w-full mt-2 border rounded-lg overflow-hidden">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="p-2 text-right">الاسم</th>
                                        <th class="p-2 text-right">الوصف</th>
                                        <th class="p-2 text-center">الصورة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($offer->features['Offerfeatures'] as $feature)
                                        <tr class="border-b">
                                            <td class="p-2">{{ $feature['name'] }}</td>
                                            <td class="p-2">{{ $feature['description'] }}</td>
                                            <td class="p-2 text-center">
                                                @if (!empty($feature['image']))
                                                    <img src="{{ asset('storage/' . $feature['image']) }}"
                                                        alt="صورة الميزة"
                                                        class="mx-auto w-20 h-14 object-cover rounded" />
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if (!empty($offer->features['plats']))
                        <div class="mb-8">
                            <span class="font-semibold text-slate-700 text-lg">الأطباق:</span>
                            <table class="w-full mt-2 border rounded-lg overflow-hidden">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="p-2 text-right">اسم الطبق</th>
                                        <th class="p-2 text-right">الوصف</th>
                                        <th class="p-2 text-center">الصورة</th>
                                        <th class="p-2 text-center">السعر</th>
                                        <th class="p-2 text-center">السعرات الحرارية</th>
                                        <th class="p-2 text-center">مسببات الحساسية</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($offer->features['plats'] as $plat)
                                        <tr class="border-b">
                                            <td class="p-2">{{ $plat['name'] }}</td>
                                            <td class="p-2">{{ $plat['description'] }}</td>
                                            <td class="p-2 text-center">
                                                @if (!empty($plat['image']))
                                                    <img src="{{ Storage::url($plat['image']) }}"
                                                        alt="{{ $plat['name'] }}"
                                                        class="mx-auto w-16 h-12 object-cover rounded" />
                                                @endif
                                            </td>
                                            <td class="p-2 text-center">{{ $plat['price'] }}</td>
                                            <td class="p-2 text-center">{{ $plat['calories'] ?? '-' }}</td>
                                            <td class="p-2 text-center">{{ $plat['allergens'] ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if (!empty($offer->faqs) && is_array($offer->faqs) && count($offer->faqs) > 0)
                        <div class="mb-8 border rounded-lg p-6 bg-gradient-to-r from-yellow-50 to-orange-50 shadow">
                            <h3 class="text-lg font-bold mb-4 text-gray-800 flex items-center">
                                <i class="ri-question-line mr-2 text-yellow-600"></i>
                                {{ __('الأسئلة المطلوب الإجابة عليها من قبل المستخدم') }}
                            </h3>
                            <div class="space-y-6">
                                @foreach ($offer->faqs as $faq)
                                    <div
                                        class="space-y-3 border border-slate-200 rounded-lg p-4 @if (($faq['status'] ?? null) === 'critical') bg-red-50 border-red-300 @endif">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-base text-gray-700">
                                                <i class="ri-question-fill text-yellow-600"></i>
                                                {{ $faq['question'] ?? '-' }}
                                            </span>
                                            @if (($faq['status'] ?? null) === 'critical')
                                                <span class="px-2 py-1 bg-red-600 text-white text-xs rounded">مطلوب</span>
                                            @endif
                                        </div>
                                        @if (!empty($faq['translations']) && is_array($faq['translations']))
                                            <div class="space-y-2">
                                                <h4 class="text-sm font-semibold text-gray-600">الترجمات:</h4>
                                                <div class="grid md:grid-cols-2 gap-4">
                                                    @foreach ($faq['translations'] as $trans)
                                                        <div class="border p-3 rounded-md bg-slate-50">
                                                            <div class="text-xs text-gray-500 mb-1">اللغة: <span
                                                                    class="font-bold">{{ $trans['lang'] ?? '-' }}</span>
                                                            </div>
                                                            <div class="text-sm text-gray-700">
                                                                {{ $trans['question'] ?? '-' }}</div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    {{-- قسم أوقات العمل والفعاليات --}}
                    @if ($offer->type == 'services' && (!empty($offer->default_day) || !empty($offer->day)))
                        <div class="mb-8 border rounded-lg p-6 bg-gradient-to-r from-blue-50 to-indigo-50 shadow">
                            <h3 class="text-lg font-bold mb-4 text-gray-800 flex items-center">
                                <i class="ri-calendar-line mr-2 text-blue-600"></i>
                                {{ __('أوقات العمل') }}
                            </h3>
                            @if (!empty($offer->default_day))
                                <div class="mb-4 p-3 bg-blue-100 border border-blue-300 rounded">
                                    <div class="flex items-center gap-2">
                                        <i class="ri-time-line text-blue-600"></i>
                                        <span class="font-bold">{{ __('الوقت الافتراضي لجميع الأيام') }}</span>
                                    </div>
                                    <div class="mt-2 text-sm text-gray-700">
                                        <span>{{ __('من') }}:
                                            <b>{{ $offer->default_day['from'] ?? '-' }}</b></span>
                                        <span class="mx-2">|</span>
                                        <span>{{ __('إلى') }}: <b>{{ $offer->default_day['to'] ?? '-' }}</b></span>
                                    </div>
                                </div>
                            @endif
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @php
                                    $dayNames = [
                                        'saturday' => __('السبت'),
                                        'sunday' => __('الأحد'),
                                        'monday' => __('الاثنين'),
                                        'tuesday' => __('الثلاثاء'),
                                        'wednesday' => __('الأربعاء'),
                                        'thursday' => __('الخميس'),
                                        'friday' => __('الجمعة'),
                                    ];
                                @endphp
                                @foreach (['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $dayName)
                                    @if (!empty($offer->day[$dayName]))
                                        <div class="border rounded-lg p-4 bg-white shadow-sm">
                                            <div class="font-bold text-blue-700 mb-2">{{ $dayNames[$dayName] }}</div>
                                            <div class="text-sm text-gray-700">
                                                <span>{{ __('من') }}:
                                                    <b>{{ $offer->from_time[$dayName] ?? '-' }}</b></span>
                                                <span class="mx-2">|</span>
                                                <span>{{ __('إلى') }}:
                                                    <b>{{ $offer->to_time[$dayName] ?? '-' }}</b></span>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            @if (!empty($offer->active_max_reservation_date) && !empty($offer->max_reservation_date))
                                <div class="mt-6 p-3 bg-gray-100 border rounded flex items-center gap-2">
                                    <i class="ri-calendar-event-line text-blue-600"></i>
                                    <span class="font-bold">{{ __('تاريخ نهاية الحجز') }}:</span>
                                    <span class="text-blue-700 font-bold">{{ $offer->max_reservation_date }}</span>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
                {{-- <div class="mt-6">
                <button class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-lg font-bold text-lg transition">طلب الخدمة</button>
            </div> --}}
            </div>
        </div>
    </div>
@endsection
