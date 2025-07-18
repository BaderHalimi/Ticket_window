<div class="w-full max-w-6xl mx-auto">

    {{-- البانر --}}
    <div class="relative w-full h-52 md:h-64 bg-cover bg-center rounded-b-3xl shadow-2xl ring-1 ring-orange-200"
         style="background-image: url('{{ asset('storage/' . $merchant['additional_data']['banner']) }}')">
    </div>

    {{-- الصورة الشخصية --}}
    <div class="relative w-full flex justify-center -mt-16 md:-mt-20 z-10">
        <img src="{{ asset('storage/' . $merchant['additional_data']['profile_picture']) }}"
             class="w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-white shadow-2xl object-cover ring-2 ring-orange-400" />
    </div>

    {{-- معلومات التاجر --}}
    <div class="text-center mt-4 px-4">
        <h1 class="text-2xl md:text-3xl font-bold text-slate-800">{{ $merchant['f_name'] }} {{ $merchant['l_name'] }}</h1>
        <p class="text-slate-600 mt-1 text-lg font-medium">{{ $merchant['business_name'] }}</p>
        <p class="text-slate-500 text-sm">{{ $merchant['phone'] }}</p>

        {{-- روابط تواصل اجتماعي --}}
        @if(isset($merchant['additional_data']['social_links']))
            <div class="flex justify-center gap-4 mt-4 text-2xl text-slate-700">
                @foreach($merchant['additional_data']['social_links'] as $link)
                    @php
                        $platform = '';
                        if (str_contains($link, 'instagram')) $platform = 'instagram';
                        elseif (str_contains($link, 'facebook')) $platform = 'facebook';
                        elseif (str_contains($link, 'tiktok')) $platform = 'tiktok';
                        else $platform = 'global';
                    @endphp

                    <a href="{{ $link }}" target="_blank" class="hover:text-orange-500 transition duration-300">
                        <i class="ri-{{ $platform }}-fill"></i>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    {{-- العروض --}}
    <div class="mt-10 px-4">
        <h2 class="text-2xl font-bold mb-6 text-slate-800 flex items-center gap-2">
            <i class="ri-shopping-bag-3-line text-orange-500"></i> العروض المتاحة
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($offers_collection as $offer)
            <div class="bg-white shadow-lg hover:shadow-xl ring-1 ring-orange-100 rounded-2xl overflow-hidden transition duration-300">
                <img src="{{ asset('storage/' . $offer['image']) }}" class="w-full h-40 object-cover" />
        
                <div class="p-4 space-y-2">
                    <h3 class="text-lg font-bold text-slate-800">{{ $offer['name'] }}</h3>
                    <p class="text-sm text-slate-600">{{ Str::limit($offer['description'], 100) }}</p>
        
                    <div class="text-sm text-slate-700 mt-2 space-y-1">
                        <p class="flex items-center gap-1">
                            <i class="ri-map-pin-line text-orange-500"></i> {{ $offer['location'] }}
                        </p>
                        <p class="flex items-center gap-1">
                            <i class="ri-cash-line text-orange-500"></i> {{ $offer['price'] }} د.ج
                        </p>
                    </div>
        
                    @php
                        $features = $offer['features'];
                        if (is_string($features)) $features = json_decode($features, true);
                        $calendar = $features['calendar'][0] ?? null;
                    @endphp
        
                    @if($calendar)
                        <div class="text-sm text-slate-600 mt-2 space-y-1">
                            <p class="flex items-center gap-1">
                                <i class="ri-time-line text-orange-500"></i> {{ $calendar['start_time'] }} - {{ $calendar['end_time'] }}
                            </p>
                            <p class="flex items-center gap-1">
                                <i class="ri-calendar-line text-orange-500"></i> {{ $calendar['start_date'] }} إلى {{ $calendar['end_date'] }}
                            </p>
                        </div>
                    @endif
        
                    {{-- زر الحجز --}}
                    <div class="pt-4">
                        <a href="#"
                           class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold px-4 py-2 rounded-xl shadow transition-all duration-300">
                            <i class="ri-calendar-check-line text-lg"></i>
                            حجز الآن
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
        
        </div>
    </div>

    {{-- مساحة تحتية للفصل عن الفوتر --}}
    <div class="h-24"></div>
</div>
