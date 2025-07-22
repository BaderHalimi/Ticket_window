<div>
<div class="w-full max-w-3xl mx-auto h-[90vh] bg-white shadow-xl rounded-3xl overflow-hidden ring-1 ring-gray-200 flex flex-col">

    {{-- معلومات البروفايل --}}
    <div class="flex items-center gap-4 p-4 border-b">
        <img src="{{ Storage::url(auth()->user()->additional_data['profile_picture']) }}"
             alt="Profile"
             class="w-14 h-14 rounded-full object-cover ring-2 ring-orange-500 shadow-sm">
        <div class="flex-1">
            <h2 class="text-lg font-bold text-gray-800">
                {{ auth()->user()->f_name }} {{ auth()->user()->l_name }}
            </h2>
            <p class="text-sm text-gray-500">{{ auth()->user()->business_name }}</p>
            <p class="text-xs text-gray-400">{{ auth()->user()->email }}</p>
        </div>
    </div>

    {{-- الكارتات داخل Scroll --}}
    <div class="flex-1 overflow-y-auto p-4 space-y-4">

        @forelse ($carts as $cart)
            <div class="bg-orange-50 hover:bg-orange-100 transition rounded-xl p-4 shadow-sm border flex justify-between items-center">
                <div>
                    <h3 class="font-semibold text-gray-800 text-md">
                        {{ $cart->offering->name }} ({{ $cart->item_type }})
                    </h3>
                    @php
                        $branch = null;

                        if (isset($cart->additional_data['branch'])) {
                            $branchId = $cart->additional_data['branch'];
                            $branch = \App\Models\Merchant\Branch::find($branchId);
                        }

                    @endphp
                    <p class="text-sm text-gray-600">الكمية: {{ $cart->quantity }}</p>
                    <p class="text-sm text-gray-600">السعر: {{ $cart->price }} د.ج</p>
                    <p class="text-sm text-gray-600">الفرع: {{  $branch->name ?? 'غير محدد' }}</p>
                    <p class="text-sm text-gray-600">التاريخ: {{ ($cart->additional_data['selected_date']) ?? '-' }}</p>
                    <p class="text-sm text-gray-600">الوقت: {{ ($cart->additional_data['selected_time']) ?? '-' }}</p>
                </div>

                <div class="flex flex-col gap-2 items-end">
                    <button wire:click="delete({{ $cart->id }})"
                            class="px-4 py-1 bg-red-500 hover:bg-red-600 text-white rounded-xl shadow text-sm">
                        حذف
                    </button>
                    <button wire:click="checkout({{ $cart->id }})"
                            class="px-4 py-1 bg-green-500 hover:bg-green-600 text-white rounded-xl shadow text-sm">
                        دفع
                    </button>
                </div>
            </div>
        @empty
            <div class="text-center text-gray-400">السلة فارغة</div>
        @endforelse

    </div>

    {{-- الدفع الكلي ثابت --}}
    <div class="p-4 border-t bg-white sticky bottom-0 flex justify-between items-center">
        <div class="text-md font-bold text-gray-700">
            المجموع: {{ $carts->sum('price') }} د.ج
        </div>
        <button wire:click="checkout_all"
                class="px-6 py-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-xl shadow-md transition">
            دفع الكل
        </button>
    </div>
</div>
</div>