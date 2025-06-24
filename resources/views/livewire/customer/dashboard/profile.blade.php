<form wire:submit.prevent="save" class="max-w-5xl mx-auto mt-12 bg-white p-8 rounded-xl shadow space-y-6" enctype="multipart/form-data">
    <div class="flex items-center gap-6">
        <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-200">
            @if (isset(Auth::user()->additional_data['profile_image']))
                <img src="{{ asset('storage/' . Auth::user()->additional_data['profile_image']) }}" class="w-full h-full object-cover" />
            @else
                <img src="https://via.placeholder.com/150" class="w-full h-full object-cover" />
            @endif
        </div>
        
        <label class="inline-block cursor-pointer bg-gray-100 px-4 py-2 rounded-md border text-sm">
            تغيير الصورة
            <input type="file" wire:model="image" hidden accept="image/*">
        </label>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1">الاسم الأول</label>
            <input type="text" wire:model.lazy="f_name" class="w-full border rounded-md p-2" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">الاسم الأخير</label>
            <input type="text" wire:model.lazy="l_name" class="w-full border rounded-md p-2" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">البريد الإلكتروني</label>
            <input type="email" wire:model.lazy="email" disabled class="w-full border bg-gray-100 rounded-md p-2" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">رقم الجوال</label>
            <input type="text" wire:model.lazy="phone" class="w-full border rounded-md p-2" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">كلمة المرور الجديدة</label>
            <input type="password" wire:model.lazy="password" class="w-full border rounded-md p-2" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 pt-4">
        <div class="flex items-center justify-between bg-slate-50 p-3 rounded-lg">
            <span class="text-sm font-medium">إشعارات البريد الإلكتروني</span>
            <input type="checkbox" wire:model.lazy="notify_email" class="form-checkbox rounded text-blue-600">
        </div>

        <div class="flex items-center justify-between bg-slate-50 p-3 rounded-lg">
            <span class="text-sm font-medium">إشعارات SMS</span>
            <input type="checkbox" wire:model.lazy="notify_sms" class="form-checkbox rounded text-blue-600">
        </div>
    </div>
</form>
