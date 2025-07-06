<div class="max-w-6xl mx-auto p-8 bg-white shadow-2xl rounded-3xl border border-gray-200">

    <h2 class="text-4xl font-bold mb-8 text-center text-gray-800 flex items-center justify-center gap-2">
        <i class="ri-settings-3-line text-blue-500"></i> إعدادات الموقع
    </h2>

    @if (session()->has('success'))
        <div class="mb-6 rounded-lg bg-green-100 border border-green-300 text-green-700 px-4 py-3 text-center shadow">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabs -->
    <div class="flex flex-wrap justify-center mb-10 gap-3">
        @foreach([
            'general'=>'⚙️ عام',
            'contact'=>'📞 تواصل',
            'social'=>'🌐 روابط اجتماعية',
            'payment'=>'💰 الدفع',
            'policy'=>'📜 سياسة الخصوصية',
            'terms'=>'📑 الشروط والأحكام'
        ] as $key => $label)
            <button
                wire:click="$set('tab', '{{ $key }}')"
                class="px-5 py-2 rounded-full text-sm font-semibold shadow transition-all duration-200
                       {{ $tab == $key ? 'bg-blue-600 text-white hover:bg-blue-700' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                {{ $label }}
            </button>
        @endforeach
    </div>

    <form wire:submit.prevent="save" class="space-y-10">

        <!-- GENERAL -->
        @if ($tab == 'general')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">🖼️ شعار الموقع</label>
                @if ($setup->logo)
                    <div class="my-3">
                        <img src="{{ asset('storage/' . $setup->logo) }}" class="h-24 rounded-lg shadow border">
                    </div>
                @endif
                <input wire:model="logo" type="file"
                    class="block w-full border-gray-300 rounded-xl shadow-sm text-sm file:rounded-full file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">📛 اسم الموقع</label>
                <input wire:model.defer="name" type="text"
                    class="mt-1 w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
        </div>
        @endif

        <!-- CONTACT -->
        @if ($tab == 'contact')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">📧 البريد الإلكتروني</label>
                <input wire:model.defer="email" type="email"
                    class="mt-1 w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">📞 رقم الهاتف</label>
                <input wire:model.defer="phone" type="text"
                    class="mt-1 w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
        </div>
        @endif

        <!-- SOCIAL -->
        @if ($tab == 'social')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">🌐 Facebook</label>
                <input wire:model.defer="social_links.facebook" type="text"
                    class="mt-1 w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">🐦 Twitter</label>
                <input wire:model.defer="social_links.twitter" type="text"
                    class="mt-1 w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">📸 Instagram</label>
                <input wire:model.defer="social_links.instagram" type="text"
                    class="mt-1 w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
        </div>
        @endif

        <!-- PAYMENT -->
        @if ($tab == 'payment')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">💰 العملة الافتراضية</label>
                <input wire:model.defer="additional_data.currency" type="text"
                    class="mt-1 w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">💱 العملات المسموحة (بفواصل)</label>
                <input wire:model.defer="additional_data.allowed_currencies" type="text"
                    class="mt-1 w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
            <div class="md:col-span-2 flex items-center gap-3 mt-3">
                <input wire:model.defer="additional_data.auto_accept" type="checkbox"
                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                <span class="text-sm text-gray-700">✅ قبول تلقائي للطلبات</span>
            </div>
        </div>
        @endif

        <!-- POLICY -->
        @if ($tab == 'policy')
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">📜 سياسة الخصوصية</label>
            <textarea wire:model.defer="additional_data.policy" rows="8"
                class="mt-1 w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 text-sm"></textarea>
        </div>
        @endif

        <!-- TERMS -->
        @if ($tab == 'terms')
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">📑 الشروط والأحكام</label>
            <textarea wire:model.defer="additional_data.terms" rows="8"
                class="mt-1 w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 text-sm"></textarea>
        </div>
        @endif

        <div class="text-center pt-6">
            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2 rounded-full bg-green-600 text-white hover:bg-green-700 focus:ring-2 focus:ring-green-500 shadow transition">
                <i class="ri-save-line"></i> حفظ الإعدادات
            </button>
        </div>
    </form>
</div>
