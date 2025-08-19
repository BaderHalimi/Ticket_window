@php
    $profile = $offering->user->additional_data['profile_picture'] ?? null;
    $id = $offering->user->id;
    $gallery = $offering->features['gallery'] ?? [];
@endphp

<div class="max-w-7xl mx-auto bg-white shadow-lg rounded-2xl overflow-hidden p-6 space-y-8">
    {{-- زر الرجوع --}}
    <a href="{{ route('template', $id) }}" wire:navigate
        class="inline-flex items-center text-sm text-orange-600 hover:underline">
        ← الرجوع
    </a>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
        {{-- صورة رئيسية --}}
        @if ($offering->image)
            <div class="w-full h-full">
                <img src="{{ Storage::url($offering->image) }}" alt="{{ $offering->name }}"
                    class="w-full h-72 md:h-full object-cover rounded-xl shadow-md transition-all duration-300">
            </div>
        @endif

        {{-- معلومات الخدمة --}}
        <div class="space-y-4">
            <h1 class="text-3xl font-bold text-gray-800">{{ $offering->name }}</h1>
            <p class="text-sm text-gray-500">الموقع: {{ $offering->location }}</p>
            <p class="text-xl text-green-600 font-semibold">السعر: {{ $offering->price }} دج</p>

            {{-- وصف الخدمة --}}
            <div
                class="text-sm text-slate-600 leading-relaxed max-h-48 overflow-y-auto border-t pt-4 whitespace-pre-line">
                {!! nl2br(e($offering->description)) !!}
            </div>

            {{-- التاجر --}}
            @if ($offering->user)
                <a href="{{ route('template', $id) }}" wire:navigate
                    class="bg-white text-gray-700  
                   transition duration-300 ease-in-out
                   hover:bg-slate-400 hover:text-white hover:shadow-lg">

                    <div class="flex items-center gap-4 border-t pt-4">
                        <img src="{{ $profile ? Storage::url($profile) : 'https://ui-avatars.com/api/?name=' . urlencode($offering->user->f_name . ' ' . $offering->user->l_name) }}"
                            alt="صورة التاجر" class="w-14 h-14 rounded-full object-cover shadow">

                        <div>
                            <p class="text-sm font-medium text-gray-700">
                                {{ $offering->user->business_name ?? $offering->user->f_name . ' ' . $offering->user->l_name }}
                            </p>
                            <p class="text-xs text-gray-500">صاحب الخدمة</p>
                        </div>
                    </div>
                </a>
            @endif
        </div>
    </div>

    {{-- الجاليري --}}
    @if (is_array($gallery) && count($gallery))
        <div x-data="{ open: false, currentImage: null }" class="border-t pt-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">صور إضافية:</h3>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach ($gallery as $img)
                    <img src="{{ Storage::url($img) }}" @click="open = true; currentImage = '{{ Storage::url($img) }}'"
                        class="cursor-pointer object-cover h-32 w-full rounded-xl hover:scale-105 transition-transform duration-200 shadow-sm"
                        alt="صورة إضافية">
                @endforeach
            </div>

            <div x-show="open" x-transition @keydown.escape.window="open = false"
                class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">
                <div class="relative max-w-3xl w-full px-6">
                    <button class="absolute top-4 right-4 text-white text-3xl font-bold"
                        @click="open = false">&times;</button>

                    <img x-show="currentImage" x-transition :src="currentImage" alt="معاينة"
                        class="rounded-xl max-h-[80vh] w-full object-contain shadow-xl border-4 border-white">
                </div>
            </div>
        </div>
    @endif

    @livewire("templates.template1.components.activities", ["offering" => $offering])
    @livewire("templates.template1.components.cartoons", ["offering" => $offering])
    @livewire("templates.template1.components.destination", ["offering" => $offering])
    @livewire("templates.template1.components.eventlinks", ["offering" => $offering])
    @livewire("templates.template1.components.games", ["offering" => $offering])
    @livewire("templates.template1.components.kidshops", ["offering" => $offering])
    @livewire("templates.template1.components.offer-features", ["offering" => $offering])
    @livewire("templates.template1.components.plats", ["offering" => $offering])
    @livewire("templates.template1.components.portfolio", ["offering" => $offering])
    @livewire("templates.template1.components.products", ["offering" => $offering])
    @livewire("templates.template1.components.services", ["offering" => $offering])
    @livewire("templates.template1.components.session", ["offering" => $offering])
    @livewire("templates.template1.components.speakers", ["offering" => $offering])
    @livewire("templates.template1.components.sponsors", ["offering" => $offering])
    @livewire("templates.template1.components.support-devices", ["offering" => $offering])
    @livewire("templates.template1.components.tools", ["offering" => $offering])
    @livewire("templates.template1.components.train-workshops", ["offering" => $offering])
</div>
