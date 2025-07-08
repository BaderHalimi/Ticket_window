<form wire:submit.prevent="save">
    <div class="space-y-4">
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">الوصف المختصر</label>
                <input type="text" wire:model.lazy="name" class="w-full border rounded-md p-2">
            </div>

            @if ($type != 'restaurant')
                
            <div>
                <label class="block text-sm font-medium mb-1">الموقع</label>
                <input type="text" wire:model.lazy="location" class="w-full border rounded-md p-2">
            </div>
            @endif


            {{-- <div>
                <label class="block text-sm font-medium mb-1">السعر</label>
                <input type="number" wire:model.lazy="price" step="0.01" class="w-full border rounded-md p-2">
            </div> --}}
@if ($type != 'restaurant')
            
    

            <div>
                <label class="block text-sm font-medium mb-1">النوع</label>
                <select wire:model.lazy="type" class="w-full border rounded-md p-2">
                    {{-- <option value="restaurant">مطعم</option> --}}
                    <option value="events">فعالية</option>
                    <option value="services">خدمة</option>
                    {{-- <option value="conference">مؤتمر</option> --}}
                    {{-- <option value="experiences">تجربة</option> --}}
                </select>
            </div>
@endif

@if ($type == 'restaurant')
            
    

            <div>
                <label class="block text-sm font-medium mb-1">النوع</label>
                <select wire:model.lazy="services_type" class="w-full border rounded-md p-2">
                    {{-- <option value="restaurant">مطعم</option> --}}
                    <option value="services">خدمة</option>
                    {{-- <option value="conference">مؤتمر</option> --}}
                    {{-- <option value="experiences">تجربة</option> --}}
                </select>
            </div>
@endif

            <div>
                <label class="block text-sm font-medium mb-1">الفئة</label>
                <select wire:model.lazy="category" class="w-full border rounded-md p-2">
                    <option value="vip">VIP</option>
                    <option value="one_day">فعالية يوم واحد</option>
                    <option value="several_days">عدة أيام</option>
                    <option value="reapeted">متكررة</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">الوصف</label>
                <textarea wire:model.lazy="description" rows="3" class="w-full border rounded-md p-2"></textarea>
            </div>

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
