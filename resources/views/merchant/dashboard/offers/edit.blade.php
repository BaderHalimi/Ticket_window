@extends('merchant.layouts.app')
@section('content')

<div class="flex-1 p-8">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-6 space-y-6">
        <h2 class="text-2xl font-bold text-slate-800">تعديل الخدمة</h2>

        <form method="POST" action="{{ route('merchant.dashboard.offer.update', $offer->id) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">الاسم</label>
                    <input type="text" name="name" class="w-full border rounded-md p-2" value="{{ old('name', $offer->name) }}" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">الموقع</label>
                    <input type="text" name="location" class="w-full border rounded-md p-2" value="{{ old('location', $offer->location) }}" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">السعر</label>
                    <input type="number" name="price" step="0.01" class="w-full border rounded-md p-2" value="{{ old('price', $offer->price) }}" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">صورة</label>
                    <input type="file" name="image" class="w-full border rounded-md p-2">
                    @if($offer->image)
                        <div class="mt-2 text-sm text-slate-600">حالياً: <span class="underline">{{ $offer->image }}</span></div>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">وقت البدء</label>
                    <input type="datetime-local" name="start_time" class="w-full border rounded-md p-2" value="{{ old('start_time', \Carbon\Carbon::parse($offer->start_time)->format('Y-m-d\TH:i')) }}" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">وقت الانتهاء</label>
                    <input type="datetime-local" name="end_time" class="w-full border rounded-md p-2" value="{{ old('end_time', \Carbon\Carbon::parse($offer->end_time)->format('Y-m-d\TH:i')) }}" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">الحالة</label>
                    <select name="status" class="w-full border rounded-md p-2" required>
                        <option value="active" {{ old('status', $offer->status) === 'active' ? 'selected' : '' }}>فعال</option>
                        <option value="inactive" {{ old('status', $offer->status) === 'inactive' ? 'selected' : '' }}>غير فعال</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">النوع</label>
                    <select name="type" class="w-full border rounded-md p-2" required>
                        <option value="restaurant" {{ old('type', $offer->type) === 'restaurant' ? 'selected' : '' }}>مطعم</option>
                        <option value="events" {{ old('type', $offer->type) === 'events' ? 'selected' : '' }}>فعالية</option>
                        <option value="conferences" {{ old('type', $offer->type) === 'conferences' ? 'selected' : '' }}>مؤتمر</option>
                        <option value="experiences" {{ old('type', $offer->type) === 'experiences' ? 'selected' : '' }}>تجربة</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">الفئة</label>
                    <select name="category" class="w-full border rounded-md p-2">
                        <option value="vip" {{ old('category', $offer->category) === 'vip' ? 'selected' : '' }}>VIP</option>
                        <option value="one_day" {{ old('category', $offer->category) === 'one_day' ? 'selected' : '' }}>فعالية يوم واحد</option>
                        <option value="several_days" {{ old('category', $offer->category) === 'several_days' ? 'selected' : '' }}>فعالية على عدة أيام</option>
                        <option value="reapeted" {{ old('category', $offer->category) === 'reapeted' ? 'selected' : '' }}>فعالية متكررة شهريًا</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">الوصف</label>
                    <textarea name="description" rows="3" class="w-full border rounded-md p-2">{{ old('description', $offer->description) }}</textarea>
                </div>

                <div>
                    @php
                        $hasChairs = false;
                        if ($offer->has_chairs == 1) {
                            $hasChairs = true;
                        
                        }
                    @endphp
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="has_chairs" id="hasChairs" class="form-checkbox"  {{ $hasChairs ? 'checked' : '' }}>
                        <span>تحتوي على مقاعد</span>
                    </label>
                </div>

                <div id="chairsCountContainer" style="display: {{ old('has_chairs', $offer->has_chairs) ? 'block' : 'none' }};">
                    <label class="block text-sm font-medium mb-1">عدد المقاعد</label>
                    <input type="number" name="chairs_count" class="w-full border rounded-md p-2" value="{{ old('chairs_count', $offer->chairs_count) }}">
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition">تحديث الخدمة</button>
            </div>
        </form>
    </div>
</div>

<script>
    const hasChairsCheckbox = document.getElementById('hasChairs');
    const chairsCountContainer = document.getElementById('chairsCountContainer');

    hasChairsCheckbox.addEventListener('change', function () {
        chairsCountContainer.style.display = this.checked ? 'block' : 'none';
    });
</script>

@endsection
