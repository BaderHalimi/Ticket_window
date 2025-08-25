<form wire:submit.prevent="save">
    <div class="space-y-4">
        <!-- Success/Error Messages -->
        @if (session()->has('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                <div class="flex items-center">
                    <i class="ri-check-circle-line text-xl mr-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                <div class="flex items-center">
                    <i class="ri-error-warning-line text-xl mr-2"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-4">
            <!-- Service Name -->
            <div>
                <label class="block text-sm font-medium mb-1">
                    {{ __('service name') }} <span class="text-red-500" style="font-weight: bold;">*</span>
                </label>
                <input type="text" wire:model.lazy="name"
                       class="w-full border rounded-md p-2 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ __($message) }}</p>
                @enderror
                @if(isset($successFields['name']))
                    <p class="text-green-500 text-xs mt-1">{{ __($successFields['name']) }}</p>
                @endif
                @if(isset($errorFields['name']))
                    <p class="text-red-500 text-xs mt-1">{{ __($errorFields['name']) }}</p>
                @endif
            </div>

            @if ($type != 'restaurant')
            <!-- Location -->
            <div>
                <label class="block text-sm font-medium mb-1">
                    {{ __('location') }} <span class="text-red-500" style="font-weight: bold;">*</span>
                </label>
                <input type="text" wire:model.lazy="location"
                       class="w-full border rounded-md p-2 @error('location') border-red-500 @enderror">
                @error('location')
                    <p class="text-red-500 text-xs mt-1">{{ __($message) }}</p>
                @enderror
                @if(isset($successFields['location']))
                    <p class="text-green-500 text-xs mt-1">{{ __($successFields['location']) }}</p>
                @endif
                @if(isset($errorFields['location']))
                    <p class="text-red-500 text-xs mt-1">{{ __($errorFields['location']) }}</p>
                @endif
            </div>
            @endif


            {{-- <div>
                <label class="block text-sm font-medium mb-1">السعر</label>
                <input type="number" wire:model.lazy="price" step="0.01" class="w-full border rounded-md p-2">
            </div> --}}
@if ($type != 'restaurant')



            <div>
                <label class="block text-sm font-medium mb-1">{{ __('type') }} <span class="text-red-500" style="font-weight: bold;">*</span></label>
                <select wire:model.lazy="type" class="w-full border rounded-md p-2">
                    {{-- <option value="restaurant">مطعم</option> --}}
                    <option value="events">{{ __('event') }}</option>
                    <option value="services">{{ __('service') }}</option>
                    {{-- <option value="conference">مؤتمر</option> --}}
                    {{-- <option value="experiences">تجربة</option> --}}
                </select>
            </div>
@endif

@if ($type == 'restaurant')



            <div>
                <label class="block text-sm font-medium mb-1">{{ __('type') }}</label>
                <select wire:model.lazy="services_type" class="w-full border rounded-md p-2">
                    {{-- <option value="restaurant">مطعم</option> --}}
                    <option value="services">{{ __('service') }}</option>
                    {{-- <option value="conference">مؤتمر</option> --}}
                    {{-- <option value="experiences">تجربة</option> --}}
                </select>
            </div>
@endif
@if ($type == 'events')

<div class="space-y-4">
    <!-- اختيار نوع الفعالية -->
    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
        <i class="ri-calendar-event-line text-indigo-500 text-lg"></i>
        {{ __('event type') }}
    </label>
    <div class="relative">
        <i class="ri-list-check text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
        <select wire:model.lazy="category" id="event_category"
            class="w-full border border-gray-300 rounded-xl p-3 pr-10 bg-white shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
            <option value="">-- {{ __('select event type') }} --</option>
            <option value="conference">{{ __('conference') }}</option>
            <option value="exhibition">{{ __('exhibition') }}</option>
            <option value="children_event">{{ __('children event') }}</option>
            <option value="online">{{ __('online event') }}</option>
            <option value="workshop">{{ __('workshop / training course') }}</option>
            <option value="social_party">{{ __('social event / party') }}</option>
            <option value="sports_fitness">{{ __('sport / fitness') }}</option>
        </select>
    </div>

    <!-- اختيار الفعالية الفعلية -->
    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
        <i class="ri-settings-3-line text-indigo-500 text-lg"></i>
        {{ __('actual event') }}
    </label>
    <div class="relative">
        <i class="ri-checkbox-circle-line text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
        <select wire:model.lazy="services_type" id="event_name"
            class="w-full border border-gray-300 rounded-xl p-3 pr-10 bg-white shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
            <option value="">{{ __('select actual event') }}</option>

            {{-- المؤتمرات --}}
            @if($category == 'conference')
                <option value="tech_conference">{{ __('technical conference') }}</option>
                <option value="business_conference">{{ __('business conference') }}</option>
                <option value="medical_conference">{{ __('medical conference') }}</option>
                <option value="educational_conference">{{ __('educational conference') }}</option>
                <option value="cultural_conference">{{ __('cultural conference') }}</option>
                <option value="scientific_conference">{{ __('scientidic conference') }}</option>
                <option value="press_conference">{{ __('press conference') }}</option>
            @endif

            {{-- المعارض --}}
            @if($category == 'exhibition')
                <option value="art_exhibition">{{ __('artical exhibition') }}</option>
                <option value="tech_exhibition">{{ __('technical exhibition') }}</option>
                <option value="trade_exhibition">{{ __('trade exhibition') }}</option>
                <option value="fashion_exhibition">{{ __('fashion exhibition') }}</option>
                <option value="car_exhibition">{{ __('cars exhibition') }}</option>
                <option value="book_fair">{{ __('book fair') }}</option>
                <option value="food_exhibition">{{ __('food exhibition') }}</option>
            @endif

            {{-- فعاليات الأطفال --}}
            @if($category == 'children_event')
                <option value="kids_show">{{ __('kids show') }}</option>
                <option value="kids_workshop">{{ __('kids workshop') }}</option>
                <option value="kids_party">{{ __('kids party') }}</option>
                <option value="kids_festival">{{ __('kids festival') }}</option>
                <option value="storytelling_event">{{ __('storytelling party') }}</option>
                <option value="kids_theater">{{ __('kids theater') }}</option>
            @endif

            {{-- الفعاليات الأونلاين --}}
            @if($category == 'online')
                <option value="webinar">{{ __('webinar') }}</option>
                <option value="online_training">{{ __('online training') }}</option>
                <option value="virtual_meeting">{{ __('virtual meeting') }}</option>
                <option value="online_conference">{{ __('online conference') }}</option>
                <option value="online_workshop">{{ __('online workshop') }}</option>
                <option value="online_show">{{ __('online show') }}</option>
            @endif

            {{-- الورشات والدورات --}}
            @if($category == 'workshop')
                <option value="technical_workshop">{{ __('technical workshop') }}</option>
                <option value="art_workshop">{{ __('art workshop') }}</option>
                <option value="business_training">{{ __('business training') }}</option>
                <option value="language_course">{{ __('language course') }}</option>
                <option value="photography_workshop">{{ __('photography workshop') }}</option>
                <option value="culinary_workshop">{{ __('culinary workshop') }}</option>
            @endif

            {{-- الفعاليات الاجتماعية والحفلات --}}
            @if($category == 'social_party')
                <option value="wedding">{{ __('wedding') }}</option>
                <option value="birthday">{{ __('birthday') }}</option>
                <option value="community_event">{{ __('community event') }}</option>
                <option value="graduation_party">{{ __('graduation party') }}</option>
                <option value="charity_event">{{ __('charity event') }}</option>
                <option value="family_gathering">{{ __('family gathering') }}</option>
            @endif

            {{-- الرياضة واللياقة --}}
            @if($category == 'sports_fitness')
                <option value="marathon">{{ __('marathon') }}</option>
                <option value="fitness_class">{{ __('fitness class') }}</option>
                <option value="tournament">{{ __('tournament') }}</option>
                <option value="football_match">{{ __('football match') }}</option>
                <option value="basketball_match">{{ __('basketball match') }}</option>
                <option value="yoga_session">{{ __('yoga session') }}</option>
                <option value="cycling_event">{{ __('cycling event') }}</option>
            @endif
        </select>
    </div>

</div>

@endif

@if ($type == 'services')

    <div >
        <label class="block text-sm font-medium mb-1">{{ __('centrality') }}</label>
        <select wire:model.lazy="center" class="w-full border rounded-md p-2">
            <option value="">{{ __('is the service central') }}</option>
            <option value="place">{{ __('central') }}</option>
            <option value="mobile">{{ __('mobile') }}</option>

        </select>

    </div>

<div class="space-y-4">
    <!-- اختيار الفئة -->
    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
        <i class="ri-folder-2-line text-indigo-500 text-lg"></i>
        {{ __('category') }}
    </label>
    <div class="relative">
        <i class="ri-list-check text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
        <select wire:model.lazy="category" id="category"
            class="w-full border border-gray-300 rounded-xl p-3 pr-10 bg-white shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
            <option value="">{{ __('select service type (group)') }}</option>
            <option value="digital">{{ __('digital services') }}</option>
            <option value="consulting">{{ __('consulting services') }}</option>
            <option value="restaurant">{{ __('restaurants') }}</option>
            <option value="educational">{{ __('educational and training services') }}</option>
            <option value="technical">{{ __('technical services and support') }}</option>
            <option value="personal">{{ __('personal services') }}</option>
            <option value="central">{{ __('central and entertainment services') }}</option>
            <option value="business">{{ __('business and logistics services') }}</option>
            <option value="medical">{{ __('medical and health services') }}</option>
            <option value="real_estate">{{ __('real estate services') }}</option>
            <option value="tourism">{{ __('tourism and travel services') }}</option>
            <option value="financial">{{ __('financial services') }}</option>
            <option value="maintenance">{{ __('maintenance and repair services') }}</option>
            <option value="other">{{ __('other') }}</option>
        </select>
    </div>

    <!-- اختيار الخدمة -->
    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
        <i class="ri-tools-line text-indigo-500 text-lg"></i>
        {{ __('actual service') }}
    </label>
    <div class="relative">
        <i class="ri-settings-3-line text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
        <select wire:model.lazy="services_type" id="service_name"
            class="w-full border border-gray-300 rounded-xl p-3 pr-10 bg-white shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
            <option value="">{{ __('select actual service') }}</option>

            @if($category == 'digital')
                <option value="graphic_design">{{ __('graphic design') }}</option>
                <option value="web_development">{{ __('web development and programming') }}</option>
                <option value="app_development">{{ __('app development') }}</option>
                <option value="video_editing">{{ __('video editing and montage') }}</option>
                <option value="content_writing">{{ __('content writing') }}</option>
                <option value="translation">{{ __('translation') }}</option>
                <option value="seo">{{ __('search engine optimization') }}</option>
                <option value="digital_marketing">{{ __('digital marketing') }}</option>
            @endif

            @if($category == 'consulting')
                <option value="financial_consulting">{{ __('financial consulting') }}</option>
                <option value="legal_consulting">{{ __('legal consulting') }}</option>
                <option value="marketing_consulting">{{ __('marketing consulting') }}</option>
                <option value="tech_consulting">{{ __('technical consulting') }}</option>
                <option value="engineering_consulting">{{ __('engineering consulting') }}</option>
            @endif

            @if($category == 'educational')
                <option value="online_courses">{{ __('online courses') }}</option>
                <option value="workshops">{{ __('workshops') }}</option>
                <option value="coaching">{{ __('individual coaching') }}</option>
                <option value="educational_content">{{ __('educational content') }}</option>
            @endif

            @if($category == 'technical')
                <option value="tech_support">{{ __('technical support') }}</option>
                <option value="device_maintenance">{{ __('device maintenance') }}</option>
                <option value="hosting">{{ __('web hosting and management') }}</option>
                <option value="server_management">{{ __('server management') }}</option>
            @endif

            @if($category == 'personal')
                <option value="photography">{{ __('photography') }}</option>
                <option value="videography">{{ __('videography') }}</option>
                <option value="interior_design">{{ __('interior design') }}</option>
                <option value="event_planning">{{ __('event planning') }}</option>
                <option value="fitness_training">{{ __('fitness training') }}</option>
            @endif

            @if($category == 'central')
                <option value="restaurants">{{ __('restaurants') }}</option>
                <option value="cafes">{{ __('cafes') }}</option>
                <option value="theaters">{{ __('theaters') }}</option>
                <option value="cinemas">{{ __('cinemas') }}</option>
                <option value="party_halls">{{ __('party halls') }}</option>
                <option value="conference_halls">{{ __('conference halls') }}</option>
                <option value="arcades">{{ __('game arcades') }}</option>
                <option value="equipment_rental">{{ __('equipment rental') }}</option>
                <option value="car_rental">{{ __('car rental') }}</option>
                <option value="bike_rental">{{ __('bike rental') }}</option>
                <option value="clothing_rental">{{ __('clothing rental') }}</option>
            @endif

            @if($category == 'business')
                <option value="shipping">{{ __('shipping and delivery') }}</option>
                <option value="inventory_management">{{ __('inventory management') }}</option>
                <option value="packaging">{{ __('packaging') }}</option>
                <option value="warehousing">{{ __('warehousing') }}</option>
            @endif

            @if($category == 'medical')
                <option value="online_medical_consulting">{{ __('online medical consulting') }}</option>
                <option value="lab_tests">{{ __('lab tests analysis') }}</option>
                <option value="physiotherapy">{{ __('physiotherapy') }}</option>
            @endif

            @if($category == 'real_estate')
                <option value="property_sales">{{ __('property sales') }}</option>
                <option value="property_rental">{{ __('property rental') }}</option>
                <option value="property_management">{{ __('property management') }}</option>
                <option value="property_valuation">{{ __('property valuation') }}</option>
            @endif

            @if($category == 'tourism')
                <option value="ticket_booking">{{ __('ticket booking') }}</option>
                <option value="trip_planning">{{ __('trip planning') }}</option>
                <option value="hotel_booking">{{ __('hotel booking') }}</option>
            @endif

            @if($category == 'financial')
                <option value="money_transfer">{{ __('money transfer') }}</option>
                <option value="loans">{{ __('loans') }}</option>
                <option value="investment">{{ __('investment') }}</option>
                <option value="portfolio_management">{{ __('portfolio management') }}</option>
            @endif

            @if($category == 'maintenance')
                <option value="car_repair">{{ __('car repair') }}</option>
                <option value="bike_repair">{{ __('bike repair') }}</option>
                <option value="ac_maintenance">{{ __('air conditioning maintenance') }}</option>
                <option value="computer_repair">{{ __('computer repair') }}</option>
                <option value="phone_repair">{{ __('phone repair') }}</option>
                <option value="plumbing">{{ __('plumbing repair') }}</option>
                <option value="electrical">{{ __('electrical work') }}</option>
                <option value="furniture_repair">{{ __('furniture repair') }}</option>
                <option value="home_appliance_repair">{{ __('home appliance repair') }}</option>
                <option value="elevator_maintenance">{{ __('elevator maintenance') }}</option>
                <option value="door_window_repair">{{ __('door and window repair') }}</option>
                <option value="agriculture_tools_repair">{{ __('agricultural tools repair') }}</option>
            @endif

            @if($category == 'other')
                <option value="other">{{ __('other') }}</option>
            @endif
        </select>
    </div>
</div>

@endif

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium mb-1">
                    {{ __('description') }} <span class="text-red-500" style="font-weight: bold;">*</span>
                </label>
                <textarea wire:model.lazy="description" rows="4"
                          class="w-full border rounded-md p-2 @error('description') border-red-500 @enderror"
                          placeholder="{{ __('Describe your service in detail...') }}"></textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ __($message) }}</p>
                @enderror
                @if(isset($successFields['description']))
                    <p class="text-green-500 text-xs mt-1">{{ __($successFields['description']) }}</p>
                @endif
                @if(isset($errorFields['description']))
                    <p class="text-red-500 text-xs mt-1">{{ __($errorFields['description']) }}</p>
                @endif
                <div class="text-xs text-gray-500 mt-1">
                    {{ __('Minimum 10 characters, maximum 2000 characters') }}
                </div>
            </div>

            <!-- Save Button -->
            <!-- <div class="flex justify-end pt-4">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors duration-200 flex items-center gap-2">
                    <i class="ri-save-line"></i>
                    {{ __('Save Information') }}
                </button>
            </div> -->

{{--
            <div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" wire:model.lazy="has_chairs" class="form-checkbox">
                    <span>تحتوي على مقاعد</span>
                </label>
            </div>

            @if ($offering->has_chairs)
                <div>
                    <label class="block text-sm font-medium mb-1">عدد المقاعد</label>
                    <input type="number" wire:model.lazy="chairs_count" class="w-full border rounded-md p-2">
                </div>
            @endif
        </div> --}}
    </div>
</form>
