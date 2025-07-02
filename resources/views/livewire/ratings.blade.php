<div class="max-w-md mx-auto p-6 bg-white border rounded-2xl shadow-lg space-y-6">
    @if ($visible)

        @if (session()->has('message'))
            <div class="p-3 text-green-800 bg-green-100 border border-green-300 rounded-lg text-sm text-center">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="p-3 text-red-800 bg-red-100 border border-red-300 rounded-lg text-sm text-center">
                {{ session('error') }}
            </div>
        @endif

        <h2 class="text-2xl font-bold text-gray-800 text-center">التقييم والمراجعة</h2>

        <!-- النجوم -->
        <div class="text-center">
            <label class="block text-gray-700 font-semibold mb-3">التقييم بالنجوم:</label>
            <div class="flex justify-center items-center gap-3 rtl:space-x-reverse">
                @for ($i = 1; $i <= 5; $i++)
                    <button
                        wire:click="$set('rating', {{ $i }})"
                        type="button"
                        class="focus:outline-none transform hover:scale-110 transition-transform duration-200"
                    >
                        @if ($rating >= $i)
                            <!-- RemixIcon star-fill -->
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-9 h-9 text-yellow-400">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                        @else
                            <!-- RemixIcon star-line -->
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-9 h-9 text-yellow-400" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                        @endif
                    </button>
                @endfor
            </div>
        </div>

        <!-- المراجعة -->
        <div class="mt-6">
            <label for="review" class="block text-gray-700 font-semibold mb-2">اكتب مراجعتك:</label>
            <textarea
                id="review"
                wire:model="review"
                rows="4"
                class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition resize-none"
                placeholder="اكتب رأيك عن الخدمة هنا..."
            ></textarea>
        </div>

        <div class="text-center mt-4">
            <button
                wire:click="hideComponent"
                class="bg-green-600 hover:bg-green-700 text-white font-semibold px-8 py-2 rounded-full shadow-md transition"
            >
                تم الإرسال
            </button>
        </div>
    @endif
</div>
