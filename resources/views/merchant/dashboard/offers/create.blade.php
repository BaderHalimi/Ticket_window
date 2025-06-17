@extends('merchant.layouts.app')
@section('content')

<div class="flex-1 p-8">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-6 space-y-6">
        <h2 class="text-2xl font-bold text-slate-800">إضافة خدمة جديدة</h2>

        <form method="POST" action="{{ route('merchant.dashboard.offer.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">الاسم</label>
                    <input type="text" name="name" class="w-full border rounded-md p-2" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">الموقع</label>
                    <input type="text" name="location" class="w-full border rounded-md p-2" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">السعر</label>
                    <input type="number" name="price" class="w-full border rounded-md p-2" step="0.01" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">صورة</label>
                    <input type="file" name="image" class="w-full border rounded-md p-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">وقت البدء</label>
                    <input type="datetime-local" name="start_time" class="w-full border rounded-md p-2" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">وقت الانتهاء</label>
                    <input type="datetime-local" name="end_time" class="w-full border rounded-md p-2" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">الحالة</label>
                    <select name="status" class="w-full border rounded-md p-2" required>
                        <option value="active">فعال</option>
                        <option value="inactive">غير فعال</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">النوع</label>
                    <select name="type" class="w-full border rounded-md p-2" required>
                        <option value="restaurant">مطعم</option>
                        <option value="events">فعالية</option>
                        <option value="conferences">مؤتمر</option>
                        <option value="experiences">مؤتمر</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">الفئة</label>
                    <select name="category" class="w-full border rounded-md p-2">
                        <option value="vip">VIP</option>
                        <option value="one_day">فعالية يوم واحد</option>
                        <option value="several_days">فعالية على عدة أيام</option>
                        <option value="reapeted">فعالية متكررة شهريًا</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">الوصف</label>
                    <textarea name="description" rows="3" class="w-full border rounded-md p-2"></textarea>
                </div>

                <div>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="has_chairs" id="hasChairs" class="form-checkbox">
                        <span>تحتوي على مقاعد</span>
                    </label>
                </div>

                <div id="chairsCountContainer" style="display: none;">
                    <label class="block text-sm font-medium mb-1">عدد المقاعد</label>
                    <input type="number" name="chairs_count" class="w-full border rounded-md p-2">
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition">حفظ الخدمة</button>
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
