<div>
@if ($type == "events")
<div>
    <p class="text-red-600">لايتم اضهار الصور حتى يتم الحفض</p>

    
    @if ($category === 'conference')
        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">الجلسات</label>
        
            <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
                <thead class="bg-gray-100 text-gray-700 font-medium">
                    <tr>
                        <th class="border px-3 py-2">المتحدث</th>
                        <th class="border px-3 py-2">التاريخ</th>
                        <th class="border px-3 py-2">الوقت</th>
                        <th class="border px-3 py-2">المكان</th>
                        <th class="border px-3 py-2">الوصف</th>
                        <th class="border px-3 py-2">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-center text-gray-800">
                    @foreach ($sessions as $index => $session)
                        <tr class="hover:bg-gray-50 transition">
                            @if ($editingIndex === $index)
                                {{-- حالة التعديل --}}
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sessions.{{ $index }}.speaker" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="date" wire:model.lazy="sessions.{{ $index }}.date" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="time" wire:model.lazy="sessions.{{ $index }}.time" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sessions.{{ $index }}.location" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sessions.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="saveRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSession({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @else
                                {{-- حالة العرض --}}
                                <td class="border px-2 py-1">{{ $session['speaker'] }}</td>
                                <td class="border px-2 py-1">{{ $session['date'] }}</td>
                                <td class="border px-2 py-1">{{ $session['time'] }}</td>
                                <td class="border px-2 py-1">{{ $session['location'] }}</td>
                                <td class="border px-2 py-1">{{ $session['description'] }}</td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="editRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                        <i class="ri-edit-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSession({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addSession" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف جلسة
                </button>
        
                <button type="button" wire:click="saveSessions" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل الجلسات
                </button>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">الرعاة</label>
        
            <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
                <thead class="bg-gray-100 text-gray-700 font-medium">
                    <tr>
                        <th class="border px-3 py-2">الاسم</th>
                        <th class="border px-3 py-2">المستوى</th>
                        <th class="border px-3 py-2">الرابط</th>
                        <th class="border px-3 py-2">الوصف</th>
                        <th class="border px-3 py-2">الشعار</th>
                        <th class="border px-3 py-2">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-center text-gray-800">
                    @foreach ($sponsors as $index => $sponsor)
                        <tr class="hover:bg-gray-50 transition">
                            @if ($sponsorEditingIndex === $index)
                                {{-- حالة التعديل --}}
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.name" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.level" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="url" wire:model.lazy="sponsors.{{ $index }}.link" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="file" wire:model="sponsors.{{ $index }}.logo" class="text-sm" />
                                    @if (isset($sponsor['logo']) && is_object($sponsor['logo']))
                                        <img src="{{ $sponsor['logo']->temporaryUrl() }}" class="w-16 h-16 object-contain mt-2" />
                                    @endif
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="saveSponsorRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @else
                                {{-- حالة العرض --}}
                                <td class="border px-2 py-1">{{ $sponsor['name'] }}</td>
                                <td class="border px-2 py-1">{{ $sponsor['level'] }}</td>
                                <td class="border px-2 py-1">
                                    <a href="{{ $sponsor['link'] }}" target="_blank" class="text-blue-600 hover:underline">الرابط</a>
                                </td>
                                <td class="border px-2 py-1">{{ $sponsor['description'] }}</td>
                                <td class="border px-2 py-1">
                                    @if ($sponsor['logo'])
                                    <img src="{{ asset('storage/' . $sponsor['logo']) }}" class="w-16 h-16 object-contain" />
                                    @else
                                    <span class="text-gray-400 text-xs">لا يوجد</span>
                                    @endif
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="editSponsorRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                        <i class="ri-edit-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addSponsor" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف راعٍ
                </button>
        
                <button type="button" wire:click="saveSponsors" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل الرعاة
                </button>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">المتحدثين</label>

            <div class="flex gap-4 overflow-x-auto py-2 px-1">
                @foreach ($speakers as $index => $speaker)
                    <div class="min-w-[250px] max-w-[250px] bg-white border rounded-lg shadow-sm p-3 relative">
                        
                        {{-- صورة المتحدث --}}
                        <div class="w-full h-32 bg-gray-100 rounded mb-2 flex items-center justify-center overflow-hidden">
                            @if(is_string($speaker['image']) && $speaker['image'] !== '')
                                <img src="{{ Storage::url($speaker['image']) }}" class="object-cover w-full h-full" alt="speaker image">
                            @else
                                <span class="text-gray-400">لا صورة</span>
                            @endif
                        </div>

                        {{-- بيانات المتحدث --}}
                        @if ($SpeakereditingIndex === $index)
                            <div class="space-y-2">
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.name" placeholder="الاسم" class="w-full p-1 border rounded text-sm" />
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.title" placeholder="الوظيفة/اللقب" class="w-full p-1 border rounded text-sm" />
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.cv" placeholder="رابط السيرة الذاتية" class="w-full p-1 border rounded text-sm" />
                                <textarea wire:model.lazy="speakers.{{ $index }}.shortDescreption" placeholder="نبذة قصيرة" class="w-full p-1 border rounded text-sm"></textarea>
                                <input type="file" wire:model="speakers.{{ $index }}.image" class="w-full text-sm" />
                            </div>

                            <div class="flex justify-between mt-2 text-sm">
                                <button wire:click="saveSpeaker({{ $index }})" class="text-green-600 hover:text-green-800"><i class="ri-save-line text-lg"></i></button>
                                <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                            </div>
                        @else
                            <div class="space-y-1 text-sm text-gray-800">
                                <p><strong>{{ $speaker['name'] }}</strong></p>
                                <p>{{ $speaker['title'] }}</p>
                                <p class="text-xs text-gray-600">{{ $speaker['shortDescreption'] }}</p>
                            </div>

                            <div class="flex justify-between mt-2 text-sm">
                                <button wire:click="editSpeaker({{ $index }})" class="text-blue-600 hover:text-blue-800"><i class="ri-edit-line text-lg"></i></button>
                                <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- زر الإضافة والحفظ --}}
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addSpeaker" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف متحدث
                </button>

                <button type="button" wire:click="saveSpeakers" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل المتحدثين
                </button>
            </div>
        </div>
        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">الفعاليات الجانبية</label>
        
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 max-h-[400px] overflow-y-auto pr-1">
                @foreach ($activities as $index => $activity)
                    <div class="border rounded-md p-4 shadow-sm bg-white relative">
                        @if ($activityeditingIndex === $index)
                            {{-- حالة التعديل --}}
                            <div class="space-y-2">
                                <input type="text" wire:model.lazy="activities.{{ $index }}.title" placeholder="عنوان الفعالية" class="w-full p-2 border rounded text-sm">
                                <input type="time" wire:model.lazy="activities.{{ $index }}.time" class="w-full p-2 border rounded text-sm">
                                <input type="text" wire:model.lazy="activities.{{ $index }}.location" placeholder="الموقع" class="w-full p-2 border rounded text-sm">
                                <textarea wire:model.lazy="activities.{{ $index }}.description" placeholder="الوصف" class="w-full p-2 border rounded text-sm"></textarea>
                                
                                <input type="file" wire:model="activities.{{ $index }}.image" class="w-full p-1 border rounded text-sm">
                                
                                <div class="flex justify-end gap-2 mt-2">
                                    <button wire:click="saveActivityRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </div>
                            </div>
                        @else
                            {{-- حالة العرض --}}
                            <div class="space-y-1">
                                <h3 class="font-semibold text-sm text-gray-800">{{ $activity['title'] }}</h3>
                                <p class="text-xs text-gray-500">{{ $activity['time'] }} | {{ $activity['location'] }}</p>
                                <p class="text-sm text-gray-600 line-clamp-3">{{ $activity['description'] }}</p>
        
                                @if (!empty($activity['image']))
                                    <img src="{{ asset('storage/' . $activity['image']) }}" class="mt-2 w-full h-28 object-cover rounded" alt="Activity Image">
                                @endif
                            </div>
        
                            <div class="absolute top-2 left-2 flex gap-2">
                                <button wire:click="editActivityRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                    <i class="ri-edit-line text-lg"></i>
                                </button>
                                <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addActivity" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف فعالية
                </button>
        
                <button type="button" wire:click="saveActivities" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ الفعاليات
                </button>
            </div>
        </div>
    
    @endif
    
    @if ($category === 'exhibition')
        <div class="mb-6">
        <label class="block text-base font-semibold mb-3 text-gray-700">المنتجات</label>
    
        {{-- الشريط الأفقي --}}
        <div class="flex overflow-x-auto gap-4 pb-2">
            @foreach ($products as $index => $product)
                <div class="flex-shrink-0 w-64 border rounded-lg shadow-sm bg-white">
                    @if ($productsEditingIndex === $index)
                        {{-- حالة التعديل --}}
                        <div class="p-3 flex flex-col gap-2">
                            <input type="text" wire:model.lazy="products.{{ $index }}.name" placeholder="اسم المنتج" class="p-2 border rounded text-sm">
                            <input type="file" wire:model.lazy="products.{{ $index }}.image" class="p-2 border rounded text-sm">
                            <input type="text" wire:model.lazy="products.{{ $index }}.price" placeholder="السعر" class="p-2 border rounded text-sm">
                            <input type="text" wire:model.lazy="products.{{ $index }}.category" placeholder="التصنيف" class="p-2 border rounded text-sm">
                            <input type="text" wire:model.lazy="products.{{ $index }}.booth" placeholder="رقم الجناح" class="p-2 border rounded text-sm">
                            <input type="text" wire:model.lazy="products.{{ $index }}.link" placeholder="رابط المنتج" class="p-2 border rounded text-sm">
                            <textarea wire:model.lazy="products.{{ $index }}.description" placeholder="الوصف" class="p-2 border rounded text-sm"></textarea>
                            
                            <div class="flex justify-between mt-2">
                                <button wire:click="saveProduct({{ $index }})" class="text-green-600 hover:text-green-800">
                                    <i class="ri-save-line text-lg"></i>
                                </button>
                                <button wire:click="removeProduct({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </div>
                        </div>
                    @else
                        {{-- حالة العرض --}}
                        <img src="{{ is_string($product['image']) ? asset('storage/'.$product['image']) : 'https://via.placeholder.com/300x200' }}" class="w-full h-40 object-cover rounded-t-lg">
                        <div class="p-3">
                            <h3 class="font-bold text-sm">{{ $product['name'] }}</h3>
                            <p class="text-xs text-gray-600 mb-1">{{ $product['category'] }} - جناح {{ $product['booth'] }}</p>
                            <p class="text-green-600 font-semibold">{{ $product['price'] }} ر.س</p>
                            <p class="text-xs text-gray-700 line-clamp-3">{{ $product['description'] }}</p>
                            
                            <div class="flex justify-between mt-2">
                                <button wire:click="editProduct({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                    <i class="ri-edit-line text-lg"></i>
                                </button>
                                <button wire:click="removeProduct({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    
        {{-- أزرار إضافة وحفظ --}}
        <div class="flex items-center mt-4 gap-3">
            <button type="button" wire:click="addProduct" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                + أضف منتج
            </button>
    
            <button type="button" wire:click="saveProducts" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                حفظ كل المنتجات
            </button>
        </div>
        </div>
    
        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">الرعاة</label>
        
            <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
                <thead class="bg-gray-100 text-gray-700 font-medium">
                    <tr>
                        <th class="border px-3 py-2">الاسم</th>
                        <th class="border px-3 py-2">المستوى</th>
                        <th class="border px-3 py-2">الرابط</th>
                        <th class="border px-3 py-2">الوصف</th>
                        <th class="border px-3 py-2">الشعار</th>
                        <th class="border px-3 py-2">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-center text-gray-800">
                    @foreach ($sponsors as $index => $sponsor)
                        <tr class="hover:bg-gray-50 transition">
                            @if ($sponsorEditingIndex === $index)
                                {{-- حالة التعديل --}}
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.name" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.level" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="url" wire:model.lazy="sponsors.{{ $index }}.link" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="file" wire:model="sponsors.{{ $index }}.logo" class="text-sm" />
                                    @if (isset($sponsor['logo']) && is_object($sponsor['logo']))
                                        <img src="{{ $sponsor['logo']->temporaryUrl() }}" class="w-16 h-16 object-contain mt-2" />
                                    @endif
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="saveSponsorRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @else
                                {{-- حالة العرض --}}
                                <td class="border px-2 py-1">{{ $sponsor['name'] }}</td>
                                <td class="border px-2 py-1">{{ $sponsor['level'] }}</td>
                                <td class="border px-2 py-1">
                                    <a href="{{ $sponsor['link'] }}" target="_blank" class="text-blue-600 hover:underline">الرابط</a>
                                </td>
                                <td class="border px-2 py-1">{{ $sponsor['description'] }}</td>
                                <td class="border px-2 py-1">
                                    @if ($sponsor['logo'])
                                    <img src="{{ asset('storage/' . $sponsor['logo']) }}" class="w-16 h-16 object-contain" />
                                    @else
                                    <span class="text-gray-400 text-xs">لا يوجد</span>
                                    @endif
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="editSponsorRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                        <i class="ri-edit-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addSponsor" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف راعٍ
                </button>
        
                <button type="button" wire:click="saveSponsors" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل الرعاة
                </button>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">المتحدثين</label>

            <div class="flex gap-4 overflow-x-auto py-2 px-1">
                @foreach ($speakers as $index => $speaker)
                    <div class="min-w-[250px] max-w-[250px] bg-white border rounded-lg shadow-sm p-3 relative">
                        
                        {{-- صورة المتحدث --}}
                        <div class="w-full h-32 bg-gray-100 rounded mb-2 flex items-center justify-center overflow-hidden">
                            @if(is_string($speaker['image']) && $speaker['image'] !== '')
                                <img src="{{ Storage::url($speaker['image']) }}" class="object-cover w-full h-full" alt="speaker image">
                            @else
                                <span class="text-gray-400">لا صورة</span>
                            @endif
                        </div>

                        {{-- بيانات المتحدث --}}
                        @if ($SpeakereditingIndex === $index)
                            <div class="space-y-2">
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.name" placeholder="الاسم" class="w-full p-1 border rounded text-sm" />
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.title" placeholder="الوظيفة/اللقب" class="w-full p-1 border rounded text-sm" />
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.cv" placeholder="رابط السيرة الذاتية" class="w-full p-1 border rounded text-sm" />
                                <textarea wire:model.lazy="speakers.{{ $index }}.shortDescreption" placeholder="نبذة قصيرة" class="w-full p-1 border rounded text-sm"></textarea>
                                <input type="file" wire:model="speakers.{{ $index }}.image" class="w-full text-sm" />
                            </div>

                            <div class="flex justify-between mt-2 text-sm">
                                <button wire:click="saveSpeaker({{ $index }})" class="text-green-600 hover:text-green-800"><i class="ri-save-line text-lg"></i></button>
                                <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                            </div>
                        @else
                            <div class="space-y-1 text-sm text-gray-800">
                                <p><strong>{{ $speaker['name'] }}</strong></p>
                                <p>{{ $speaker['title'] }}</p>
                                <p class="text-xs text-gray-600">{{ $speaker['shortDescreption'] }}</p>
                            </div>

                            <div class="flex justify-between mt-2 text-sm">
                                <button wire:click="editSpeaker({{ $index }})" class="text-blue-600 hover:text-blue-800"><i class="ri-edit-line text-lg"></i></button>
                                <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- زر الإضافة والحفظ --}}
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addSpeaker" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف متحدث
                </button>

                <button type="button" wire:click="saveSpeakers" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل المتحدثين
                </button>
            </div>
        </div>
        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">الفعاليات الجانبية</label>
        
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 max-h-[400px] overflow-y-auto pr-1">
                @foreach ($activities as $index => $activity)
                    <div class="border rounded-md p-4 shadow-sm bg-white relative">
                        @if ($activityeditingIndex === $index)
                            {{-- حالة التعديل --}}
                            <div class="space-y-2">
                                <input type="text" wire:model.lazy="activities.{{ $index }}.title" placeholder="عنوان الفعالية" class="w-full p-2 border rounded text-sm">
                                <input type="time" wire:model.lazy="activities.{{ $index }}.time" class="w-full p-2 border rounded text-sm">
                                <input type="text" wire:model.lazy="activities.{{ $index }}.location" placeholder="الموقع" class="w-full p-2 border rounded text-sm">
                                <textarea wire:model.lazy="activities.{{ $index }}.description" placeholder="الوصف" class="w-full p-2 border rounded text-sm"></textarea>
                                
                                <input type="file" wire:model="activities.{{ $index }}.image" class="w-full p-1 border rounded text-sm">
                                
                                <div class="flex justify-end gap-2 mt-2">
                                    <button wire:click="saveActivityRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </div>
                            </div>
                        @else
                            {{-- حالة العرض --}}
                            <div class="space-y-1">
                                <h3 class="font-semibold text-sm text-gray-800">{{ $activity['title'] }}</h3>
                                <p class="text-xs text-gray-500">{{ $activity['time'] }} | {{ $activity['location'] }}</p>
                                <p class="text-sm text-gray-600 line-clamp-3">{{ $activity['description'] }}</p>
        
                                @if (!empty($activity['image']))
                                    <img src="{{ asset('storage/' . $activity['image']) }}" class="mt-2 w-full h-28 object-cover rounded" alt="Activity Image">
                                @endif
                            </div>
        
                            <div class="absolute top-2 left-2 flex gap-2">
                                <button wire:click="editActivityRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                    <i class="ri-edit-line text-lg"></i>
                                </button>
                                <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addActivity" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف فعالية
                </button>
        
                <button type="button" wire:click="saveActivities" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ الفعاليات
                </button>
            </div>
        </div>
    
    @endif
    @if ($category === 'children_event')
        <div class="mb-6 font-sans">
            <label class="block text-2xl font-extrabold mb-6 text-pink-600">🎲 الألعاب</label>
        
            <div class="flex space-x-6 overflow-x-auto pb-4">
                @foreach ($games as $index => $game)
                    <div class="flex-shrink-0 w-72 bg-gradient-to-br from-pink-100 via-pink-200 to-pink-300 rounded-xl shadow-lg p-5 relative text-gray-800">
                        @if ($gamesEditingIndex === $index)
                            <input 
                                type="text" 
                                wire:model.lazy="games.{{ $index }}.name" 
                                placeholder="اسم اللعبة" 
                                class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-400 font-semibold text-lg text-pink-700"
                            />
                            <textarea 
                                wire:model.lazy="games.{{ $index }}.description" 
                                placeholder="وصف اللعبة" 
                                rows="3"
                                class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm resize-none"
                            ></textarea>
                            <input 
                                type="text" 
                                wire:model.lazy="games.{{ $index }}.age_range" 
                                placeholder="الفئة العمرية" 
                                class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm"
                            />
                            <input 
                                type="text" 
                                wire:model.lazy="games.{{ $index }}.location" 
                                placeholder="المكان" 
                                class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm"
                            />
                            <input 
                                type="text" 
                                wire:model.lazy="games.{{ $index }}.supervisor" 
                                placeholder="المشرف" 
                                class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm"
                            />
                            <textarea 
                                wire:model.lazy="games.{{ $index }}.rules" 
                                placeholder="قوانين اللعبة" 
                                rows="2"
                                class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm resize-none"
                            ></textarea>
        
                            <label class="block mb-2 font-semibold text-pink-600">صورة اللعبة</label>
                            <input 
                                type="file" 
                                wire:model="games.{{ $index }}.image" 
                                accept="image/*"
                                class="mb-3 w-full text-sm text-pink-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pink-100 file:text-pink-700 hover:file:bg-pink-200 cursor-pointer"
                            />
        
                            <div class="flex justify-end space-x-3 rtl:space-x-reverse">
                                <button 
                                    wire:click="saveGame({{ $index }})" 
                                    class="text-pink-600 hover:text-pink-800 transition text-xl" 
                                    title="حفظ"
                                >
                                    <i class="ri-save-line"></i>
                                </button>
                                <button 
                                    wire:click="removeGame({{ $index }})" 
                                    class="text-red-600 hover:text-red-800 transition text-xl" 
                                    title="حذف"
                                >
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
        
                        @else
                            <div class="h-40 rounded-lg overflow-hidden mb-4 bg-pink-50 flex items-center justify-center">
                                @if (!empty($game['image']) && !is_object($game['image']))
                                    <img src="{{ asset('storage/' . $game['image']) }}" alt="صورة اللعبة" class="object-cover w-full h-full" />
                                @elseif(is_object($game['image']))
                                    <img src="{{ $game['image']->temporaryUrl() }}" alt="صورة مؤقتة" class="object-cover w-full h-full" />
                                @else
                                    <i class="ri-gamepad-line text-6xl text-pink-400"></i>
                                @endif
                            </div>
                            <h3 class="text-xl font-bold text-pink-700 mb-1 truncate">{{ $game['name'] ?: 'بدون اسم' }}</h3>
                            <p class="text-sm text-pink-600 mb-1">الفئة العمرية: <span class="font-semibold">{{ $game['age_range'] ?: 'غير محددة' }}</span></p>
                            <p class="text-sm text-gray-700 mb-2 h-12 overflow-hidden">{{ $game['description'] ?: 'لا يوجد وصف' }}</p>
                            <p class="text-xs text-gray-500 mb-1">المكان: {{ $game['location'] ?: 'غير محدد' }}</p>
                            <p class="text-xs text-gray-500 mb-3">المشرف: {{ $game['supervisor'] ?: 'غير محدد' }}</p>
        
                            <div class="flex justify-between items-center">
                                <button 
                                    wire:click="editGame({{ $index }})" 
                                    class="text-pink-600 hover:text-pink-800 transition text-xl" 
                                    title="تعديل"
                                >
                                    <i class="ri-edit-line"></i>
                                </button>
                                <button 
                                    wire:click="removeGame({{ $index }})" 
                                    class="text-red-600 hover:text-red-800 transition text-xl" 
                                    title="حذف"
                                >
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        
            <div class="flex justify-between items-center mt-6">
                <button 
                    type="button" 
                    wire:click="addGame" 
                    class="px-5 py-2 bg-pink-600 hover:bg-pink-700 text-white rounded-lg font-semibold transition"
                >
                    + أضف لعبة جديدة
                </button>
        
                <button 
                    type="button" 
                    wire:click="saveGames" 
                    class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition"
                >
                    حفظ كل الألعاب
                </button>
            </div>
        </div>
    
    
        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">الرعاة</label>
        
            <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
                <thead class="bg-gray-100 text-gray-700 font-medium">
                    <tr>
                        <th class="border px-3 py-2">الاسم</th>
                        <th class="border px-3 py-2">المستوى</th>
                        <th class="border px-3 py-2">الرابط</th>
                        <th class="border px-3 py-2">الوصف</th>
                        <th class="border px-3 py-2">الشعار</th>
                        <th class="border px-3 py-2">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-center text-gray-800">
                    @foreach ($sponsors as $index => $sponsor)
                        <tr class="hover:bg-gray-50 transition">
                            @if ($sponsorEditingIndex === $index)
                                {{-- حالة التعديل --}}
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.name" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.level" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="url" wire:model.lazy="sponsors.{{ $index }}.link" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="file" wire:model="sponsors.{{ $index }}.logo" class="text-sm" />
                                    @if (isset($sponsor['logo']) && is_object($sponsor['logo']))
                                        <img src="{{ $sponsor['logo']->temporaryUrl() }}" class="w-16 h-16 object-contain mt-2" />
                                    @endif
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="saveSponsorRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @else
                                {{-- حالة العرض --}}
                                <td class="border px-2 py-1">{{ $sponsor['name'] }}</td>
                                <td class="border px-2 py-1">{{ $sponsor['level'] }}</td>
                                <td class="border px-2 py-1">
                                    <a href="{{ $sponsor['link'] }}" target="_blank" class="text-blue-600 hover:underline">الرابط</a>
                                </td>
                                <td class="border px-2 py-1">{{ $sponsor['description'] }}</td>
                                <td class="border px-2 py-1">
                                    @if ($sponsor['logo'])
                                    <img src="{{ asset('storage/' . $sponsor['logo']) }}" class="w-16 h-16 object-contain" />
                                    @else
                                    <span class="text-gray-400 text-xs">لا يوجد</span>
                                    @endif
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="editSponsorRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                        <i class="ri-edit-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addSponsor" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف راعٍ
                </button>
        
                <button type="button" wire:click="saveSponsors" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل الرعاة
                </button>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">المتحدثين</label>

            <div class="flex gap-4 overflow-x-auto py-2 px-1">
                @foreach ($speakers as $index => $speaker)
                    <div class="min-w-[250px] max-w-[250px] bg-white border rounded-lg shadow-sm p-3 relative">
                        
                        {{-- صورة المتحدث --}}
                        <div class="w-full h-32 bg-gray-100 rounded mb-2 flex items-center justify-center overflow-hidden">
                            @if(is_string($speaker['image']) && $speaker['image'] !== '')
                                <img src="{{ Storage::url($speaker['image']) }}" class="object-cover w-full h-full" alt="speaker image">
                            @else
                                <span class="text-gray-400">لا صورة</span>
                            @endif
                        </div>

                        {{-- بيانات المتحدث --}}
                        @if ($SpeakereditingIndex === $index)
                            <div class="space-y-2">
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.name" placeholder="الاسم" class="w-full p-1 border rounded text-sm" />
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.title" placeholder="الوظيفة/اللقب" class="w-full p-1 border rounded text-sm" />
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.cv" placeholder="رابط السيرة الذاتية" class="w-full p-1 border rounded text-sm" />
                                <textarea wire:model.lazy="speakers.{{ $index }}.shortDescreption" placeholder="نبذة قصيرة" class="w-full p-1 border rounded text-sm"></textarea>
                                <input type="file" wire:model="speakers.{{ $index }}.image" class="w-full text-sm" />
                            </div>

                            <div class="flex justify-between mt-2 text-sm">
                                <button wire:click="saveSpeaker({{ $index }})" class="text-green-600 hover:text-green-800"><i class="ri-save-line text-lg"></i></button>
                                <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                            </div>
                        @else
                            <div class="space-y-1 text-sm text-gray-800">
                                <p><strong>{{ $speaker['name'] }}</strong></p>
                                <p>{{ $speaker['title'] }}</p>
                                <p class="text-xs text-gray-600">{{ $speaker['shortDescreption'] }}</p>
                            </div>

                            <div class="flex justify-between mt-2 text-sm">
                                <button wire:click="editSpeaker({{ $index }})" class="text-blue-600 hover:text-blue-800"><i class="ri-edit-line text-lg"></i></button>
                                <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- زر الإضافة والحفظ --}}
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addSpeaker" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف متحدث
                </button>

                <button type="button" wire:click="saveSpeakers" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل المتحدثين
                </button>
            </div>
        </div>
        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">الفعاليات الجانبية</label>
        
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 max-h-[400px] overflow-y-auto pr-1">
                @foreach ($activities as $index => $activity)
                    <div class="border rounded-md p-4 shadow-sm bg-white relative">
                        @if ($activityeditingIndex === $index)
                            {{-- حالة التعديل --}}
                            <div class="space-y-2">
                                <input type="text" wire:model.lazy="activities.{{ $index }}.title" placeholder="عنوان الفعالية" class="w-full p-2 border rounded text-sm">
                                <input type="time" wire:model.lazy="activities.{{ $index }}.time" class="w-full p-2 border rounded text-sm">
                                <input type="text" wire:model.lazy="activities.{{ $index }}.location" placeholder="الموقع" class="w-full p-2 border rounded text-sm">
                                <textarea wire:model.lazy="activities.{{ $index }}.description" placeholder="الوصف" class="w-full p-2 border rounded text-sm"></textarea>
                                
                                <input type="file" wire:model="activities.{{ $index }}.image" class="w-full p-1 border rounded text-sm">
                                
                                <div class="flex justify-end gap-2 mt-2">
                                    <button wire:click="saveActivityRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </div>
                            </div>
                        @else
                            {{-- حالة العرض --}}
                            <div class="space-y-1">
                                <h3 class="font-semibold text-sm text-gray-800">{{ $activity['title'] }}</h3>
                                <p class="text-xs text-gray-500">{{ $activity['time'] }} | {{ $activity['location'] }}</p>
                                <p class="text-sm text-gray-600 line-clamp-3">{{ $activity['description'] }}</p>
        
                                @if (!empty($activity['image']))
                                    <img src="{{ asset('storage/' . $activity['image']) }}" class="mt-2 w-full h-28 object-cover rounded" alt="Activity Image">
                                @endif
                            </div>
        
                            <div class="absolute top-2 left-2 flex gap-2">
                                <button wire:click="editActivityRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                    <i class="ri-edit-line text-lg"></i>
                                </button>
                                <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addActivity" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف فعالية
                </button>
        
                <button type="button" wire:click="saveActivities" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ الفعاليات
                </button>
            </div>
        </div>

        <div class="mb-6 font-sans">
            <label class="block text-2xl font-extrabold mb-6 text-indigo-600">🦸‍♂️ الشخصيات الكرتونية</label>
        
            <div class="flex space-x-6 overflow-x-auto pb-4">
                @foreach ($cartoons as $index => $cartoon)
                    <div class="flex-shrink-0 w-72 bg-gradient-to-br from-indigo-100 via-indigo-200 to-indigo-300 rounded-xl shadow-lg p-5 relative text-gray-800">
                        @if ($cartoonEditingIndex === $index)
                            <input 
                                type="text" 
                                wire:model.lazy="cartoons.{{ $index }}.name" 
                                placeholder="اسم الشخصية" 
                                class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-400 font-semibold text-lg text-indigo-700"
                            />
                            <textarea 
                                wire:model.lazy="cartoons.{{ $index }}.description" 
                                placeholder="وصف الشخصية" 
                                rows="3"
                                class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-400 text-sm resize-none"
                            ></textarea>
        
                            <label class="block mb-2 font-semibold text-indigo-600">صورة الشخصية</label>
                            <input 
                                type="file" 
                                wire:model="cartoons.{{ $index }}.image" 
                                accept="image/*"
                                class="mb-3 w-full text-sm text-indigo-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200 cursor-pointer"
                            />
        
                            <div class="flex justify-end space-x-3 rtl:space-x-reverse">
                                <button wire:click="saveCartoon({{ $index }})" class="text-indigo-600 hover:text-indigo-800 transition text-xl" title="حفظ">
                                    <i class="ri-save-line"></i>
                                </button>
                                <button wire:click="removeCartoon({{ $index }})" class="text-red-600 hover:text-red-800 transition text-xl" title="حذف">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        @else
                            <div class="h-40 rounded-lg overflow-hidden mb-4 bg-indigo-50 flex items-center justify-center">
                                @if (!empty($cartoon['image']) && !is_object($cartoon['image']))
                                    <img src="{{ asset('storage/' . $cartoon['image']) }}" alt="صورة الشخصية" class="object-cover w-full h-full" />
                                @elseif(is_object($cartoon['image']))
                                    <img src="{{ $cartoon['image']->temporaryUrl() }}" alt="صورة مؤقتة" class="object-cover w-full h-full" />
                                @else
                                    <i class="ri-user-3-line text-6xl text-indigo-400"></i>
                                @endif
                            </div>
                            <h3 class="text-xl font-bold text-indigo-700 mb-1 truncate">{{ $cartoon['name'] ?: 'بدون اسم' }}</h3>
                            <p class="text-sm text-indigo-600 mb-2 h-16 overflow-hidden">{{ $cartoon['description'] ?: 'لا يوجد وصف' }}</p>
        
                            <div class="flex justify-between items-center">
                                <button wire:click="editCartoon({{ $index }})" class="text-indigo-600 hover:text-indigo-800 transition text-xl" title="تعديل">
                                    <i class="ri-edit-line"></i>
                                </button>
                                <button wire:click="removeCartoon({{ $index }})" class="text-red-600 hover:text-red-800 transition text-xl" title="حذف">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        
            <div class="flex justify-between items-center mt-6">
                <button type="button" wire:click="addCartoon" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition">
                    + أضف شخصية كرتونية جديدة
                </button>
        
                <button type="button" wire:click="saveCartoons" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition">
                    حفظ كل الشخصيات
                </button>
            </div>
        </div>
        <div class="mb-6 font-sans">
            <label class="block text-2xl font-extrabold mb-6 text-teal-600">🛠️ ورش العمل</label>
        
            <div class="flex space-x-6 overflow-x-auto pb-4">
                @foreach ($workshops as $index => $workshop)
                    <div class="flex-shrink-0 w-72 bg-gradient-to-br from-teal-100 via-teal-200 to-teal-300 rounded-xl shadow-lg p-5 relative text-gray-800">
                        @if ($workshopEditingIndex === $index)
                            <input 
                                type="text" 
                                wire:model.lazy="workshops.{{ $index }}.title" 
                                placeholder="عنوان الورشة" 
                                class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-400 font-semibold text-lg text-teal-700"
                            />
                            <textarea 
                                wire:model.lazy="workshops.{{ $index }}.description" 
                                placeholder="وصف الورشة" 
                                rows="3"
                                class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-400 text-sm resize-none"
                            ></textarea>
        
                            <label class="block mb-2 font-semibold text-teal-600">صورة الورشة</label>
                            <input 
                                type="file" 
                                wire:model="workshops.{{ $index }}.image" 
                                accept="image/*"
                                class="mb-3 w-full text-sm text-teal-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-100 file:text-teal-700 hover:file:bg-teal-200 cursor-pointer"
                            />
        
                            <div class="flex justify-end space-x-3 rtl:space-x-reverse">
                                <button wire:click="saveWorkshop({{ $index }})" class="text-teal-600 hover:text-teal-800 transition text-xl" title="حفظ">
                                    <i class="ri-save-line"></i>
                                </button>
                                <button wire:click="removeWorkshop({{ $index }})" class="text-red-600 hover:text-red-800 transition text-xl" title="حذف">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        @else
                            <div class="h-40 rounded-lg overflow-hidden mb-4 bg-teal-50 flex items-center justify-center">
                                @if (!empty($workshop['image']) && !is_object($workshop['image']))
                                    <img src="{{ asset('storage/' . $workshop['image']) }}" alt="صورة الورشة" class="object-cover w-full h-full" />
                                @elseif(is_object($workshop['image']))
                                    <img src="{{ $workshop['image']->temporaryUrl() }}" alt="صورة مؤقتة" class="object-cover w-full h-full" />
                                @else
                                    <i class="ri-tools-line text-6xl text-teal-400"></i>
                                @endif
                            </div>
                            <h3 class="text-xl font-bold text-teal-700 mb-1 truncate">{{ $workshop['title'] ?: 'بدون عنوان' }}</h3>
                            <p class="text-sm text-teal-600 mb-2 h-16 overflow-hidden">{{ $workshop['description'] ?: 'لا يوجد وصف' }}</p>
        
                            <div class="flex justify-between items-center">
                                <button wire:click="editWorkshop({{ $index }})" class="text-teal-600 hover:text-teal-800 transition text-xl" title="تعديل">
                                    <i class="ri-edit-line"></i>
                                </button>
                                <button wire:click="removeWorkshop({{ $index }})" class="text-red-600 hover:text-red-800 transition text-xl" title="حذف">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        
            <div class="flex justify-between items-center mt-6">
                <button type="button" wire:click="addWorkshop" class="px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg font-semibold transition">
                    + أضف ورشة جديدة
                </button>
        
                <button type="button" wire:click="saveWorkshops" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition">
                    حفظ كل الورش
                </button>
            </div>
        </div>
                
    
    @endif
    @if ($category == "online")
        <p class="text-yellow-500">في حالة وجود مواقع دخول المرور يكون بكود الحجز الذي عند اليوزر</p>

        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">الجلسات</label>
        
            <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
                <thead class="bg-gray-100 text-gray-700 font-medium">
                    <tr>
                        <th class="border px-3 py-2">المتحدث</th>
                        <th class="border px-3 py-2">التاريخ</th>
                        <th class="border px-3 py-2">الوقت</th>
                        <th class="border px-3 py-2">المكان</th>
                        <th class="border px-3 py-2">الوصف</th>
                        <th class="border px-3 py-2">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-center text-gray-800">
                    @foreach ($sessions as $index => $session)
                        <tr class="hover:bg-gray-50 transition">
                            @if ($editingIndex === $index)
                                {{-- حالة التعديل --}}
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sessions.{{ $index }}.speaker" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="date" wire:model.lazy="sessions.{{ $index }}.date" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="time" wire:model.lazy="sessions.{{ $index }}.time" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sessions.{{ $index }}.location" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sessions.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="saveRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSession({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @else
                                {{-- حالة العرض --}}
                                <td class="border px-2 py-1">{{ $session['speaker'] }}</td>
                                <td class="border px-2 py-1">{{ $session['date'] }}</td>
                                <td class="border px-2 py-1">{{ $session['time'] }}</td>
                                <td class="border px-2 py-1">{{ $session['location'] }}</td>
                                <td class="border px-2 py-1">{{ $session['description'] }}</td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="editRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                        <i class="ri-edit-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSession({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addSession" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف جلسة
                </button>
        
                <button type="button" wire:click="saveSessions" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل الجلسات
                </button>
            </div>
        </div>
        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">الرعاة</label>
        
            <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
                <thead class="bg-gray-100 text-gray-700 font-medium">
                    <tr>
                        <th class="border px-3 py-2">الاسم</th>
                        <th class="border px-3 py-2">المستوى</th>
                        <th class="border px-3 py-2">الرابط</th>
                        <th class="border px-3 py-2">الوصف</th>
                        <th class="border px-3 py-2">الشعار</th>
                        <th class="border px-3 py-2">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-center text-gray-800">
                    @foreach ($sponsors as $index => $sponsor)
                        <tr class="hover:bg-gray-50 transition">
                            @if ($sponsorEditingIndex === $index)
                                {{-- حالة التعديل --}}
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.name" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.level" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="url" wire:model.lazy="sponsors.{{ $index }}.link" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="file" wire:model="sponsors.{{ $index }}.logo" class="text-sm" />
                                    @if (isset($sponsor['logo']) && is_object($sponsor['logo']))
                                        <img src="{{ $sponsor['logo']->temporaryUrl() }}" class="w-16 h-16 object-contain mt-2" />
                                    @endif
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="saveSponsorRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @else
                                {{-- حالة العرض --}}
                                <td class="border px-2 py-1">{{ $sponsor['name'] }}</td>
                                <td class="border px-2 py-1">{{ $sponsor['level'] }}</td>
                                <td class="border px-2 py-1">
                                    <a href="{{ $sponsor['link'] }}" target="_blank" class="text-blue-600 hover:underline">الرابط</a>
                                </td>
                                <td class="border px-2 py-1">{{ $sponsor['description'] }}</td>
                                <td class="border px-2 py-1">
                                    @if ($sponsor['logo'])
                                    <img src="{{ asset('storage/' . $sponsor['logo']) }}" class="w-16 h-16 object-contain" />
                                    @else
                                    <span class="text-gray-400 text-xs">لا يوجد</span>
                                    @endif
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="editSponsorRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                        <i class="ri-edit-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addSponsor" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف راعٍ
                </button>
        
                <button type="button" wire:click="saveSponsors" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل الرعاة
                </button>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">المتحدثين</label>

            <div class="flex gap-4 overflow-x-auto py-2 px-1">
                @foreach ($speakers as $index => $speaker)
                    <div class="min-w-[250px] max-w-[250px] bg-white border rounded-lg shadow-sm p-3 relative">
                        
                        {{-- صورة المتحدث --}}
                        <div class="w-full h-32 bg-gray-100 rounded mb-2 flex items-center justify-center overflow-hidden">
                            @if(is_string($speaker['image']) && $speaker['image'] !== '')
                                <img src="{{ Storage::url($speaker['image']) }}" class="object-cover w-full h-full" alt="speaker image">
                            @else
                                <span class="text-gray-400">لا صورة</span>
                            @endif
                        </div>

                        {{-- بيانات المتحدث --}}
                        @if ($SpeakereditingIndex === $index)
                            <div class="space-y-2">
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.name" placeholder="الاسم" class="w-full p-1 border rounded text-sm" />
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.title" placeholder="الوظيفة/اللقب" class="w-full p-1 border rounded text-sm" />
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.cv" placeholder="رابط السيرة الذاتية" class="w-full p-1 border rounded text-sm" />
                                <textarea wire:model.lazy="speakers.{{ $index }}.shortDescreption" placeholder="نبذة قصيرة" class="w-full p-1 border rounded text-sm"></textarea>
                                <input type="file" wire:model="speakers.{{ $index }}.image" class="w-full text-sm" />
                            </div>

                            <div class="flex justify-between mt-2 text-sm">
                                <button wire:click="saveSpeaker({{ $index }})" class="text-green-600 hover:text-green-800"><i class="ri-save-line text-lg"></i></button>
                                <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                            </div>
                        @else
                            <div class="space-y-1 text-sm text-gray-800">
                                <p><strong>{{ $speaker['name'] }}</strong></p>
                                <p>{{ $speaker['title'] }}</p>
                                <p class="text-xs text-gray-600">{{ $speaker['shortDescreption'] }}</p>
                            </div>

                            <div class="flex justify-between mt-2 text-sm">
                                <button wire:click="editSpeaker({{ $index }})" class="text-blue-600 hover:text-blue-800"><i class="ri-edit-line text-lg"></i></button>
                                <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- زر الإضافة والحفظ --}}
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addSpeaker" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف متحدث
                </button>

                <button type="button" wire:click="saveSpeakers" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل المتحدثين
                </button>
            </div>
        </div>
        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">الفعاليات الجانبية</label>
        
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 max-h-[400px] overflow-y-auto pr-1">
                @foreach ($activities as $index => $activity)
                    <div class="border rounded-md p-4 shadow-sm bg-white relative">
                        @if ($activityeditingIndex === $index)
                            {{-- حالة التعديل --}}
                            <div class="space-y-2">
                                <input type="text" wire:model.lazy="activities.{{ $index }}.title" placeholder="عنوان الفعالية" class="w-full p-2 border rounded text-sm">
                                <input type="time" wire:model.lazy="activities.{{ $index }}.time" class="w-full p-2 border rounded text-sm">
                                <input type="text" wire:model.lazy="activities.{{ $index }}.location" placeholder="الموقع" class="w-full p-2 border rounded text-sm">
                                <textarea wire:model.lazy="activities.{{ $index }}.description" placeholder="الوصف" class="w-full p-2 border rounded text-sm"></textarea>
                                
                                <input type="file" wire:model="activities.{{ $index }}.image" class="w-full p-1 border rounded text-sm">
                                
                                <div class="flex justify-end gap-2 mt-2">
                                    <button wire:click="saveActivityRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </div>
                            </div>
                        @else
                            {{-- حالة العرض --}}
                            <div class="space-y-1">
                                <h3 class="font-semibold text-sm text-gray-800">{{ $activity['title'] }}</h3>
                                <p class="text-xs text-gray-500">{{ $activity['time'] }} | {{ $activity['location'] }}</p>
                                <p class="text-sm text-gray-600 line-clamp-3">{{ $activity['description'] }}</p>
        
                                @if (!empty($activity['image']))
                                    <img src="{{ asset('storage/' . $activity['image']) }}" class="mt-2 w-full h-28 object-cover rounded" alt="Activity Image">
                                @endif
                            </div>
        
                            <div class="absolute top-2 left-2 flex gap-2">
                                <button wire:click="editActivityRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                    <i class="ri-edit-line text-lg"></i>
                                </button>
                                <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addActivity" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف فعالية
                </button>
        
                <button type="button" wire:click="saveActivities" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ الفعاليات
                </button>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">روابط الفعالية</label>
        
            <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
                <thead class="bg-gray-100 text-gray-700 font-medium">
                    <tr>
                        <th class="border px-3 py-2">المنصة</th>
                        <th class="border px-3 py-2">الرابط</th>
                        <th class="border px-3 py-2">الوصف</th>
                        <th class="border px-3 py-2">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-center text-gray-800">
                    @foreach ($links as $index => $link)
                        <tr class="hover:bg-gray-50 transition">
                            @if ($linksEditingIndex === $index)
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="links.{{ $index }}.platform" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="links.{{ $index }}.url" class="w-full p-1 border rounded text-sm" />
                                </td>

                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="links.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="saveLink({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeLink({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @else
                                <td class="border px-2 py-1">{{ $link['platform'] }}</td>
                                <td class="border px-2 py-1">
                                    <a href="{{ $link['url'] }}" target="_blank" class="text-blue-500 underline">{{ $link['url'] }}</a>
                                </td>
                                <td class="border px-2 py-1">{{ $link['description'] }}</td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="editLink({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                        <i class="ri-edit-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeLink({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addLink" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف رابط
                </button>
        
                <button type="button" wire:click="saveLinks" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل الروابط
                </button>
            </div>
        </div>
        
    @endif
    @if ($category == "workshop")
        <div class="mb-6">
            <label class="block text-lg font-semibold mb-3 text-gray-700">الدورات & الورش التدريبية</label>
        
            <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
                <thead class="bg-gray-100 text-gray-700 font-medium">
                    <tr>
                        <th class="border px-3 py-2">العنوان</th>
                        <th class="border px-3 py-2">الوصف</th>
                        <th class="border px-3 py-2">المدة</th>
                        <th class="border px-3 py-2">المكان</th>
                        <th class="border px-3 py-2">المدرب</th>
                        <th class="border px-3 py-2">الشهادة</th>
                        <th class="border px-3 py-2">الصورة</th>
                        <th class="border px-3 py-2">الإجراءات</th>
                    </tr>
                </thead>
        
                <tbody class="text-center text-gray-800">
                    @foreach ($trainingWorkshops as $index => $w)
                        <tr class="hover:bg-gray-50 transition">
                            @if ($trainingWorkshopsEditingIndex === $index)
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="trainingWorkshops.{{ $index }}.title" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="trainingWorkshops.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="trainingWorkshops.{{ $index }}.duration" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="trainingWorkshops.{{ $index }}.location" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="trainingWorkshops.{{ $index }}.instructor" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <label class="inline-flex items-center gap-2">
                                        <input type="checkbox" wire:model.lazy="trainingWorkshops.{{ $index }}.certificate" class="form-checkbox h-4 w-4" />
                                        <span class="text-sm">نعم</span>
                                    </label>
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="file" wire:model="trainingWorkshops.{{ $index }}.image" accept="image/*" class="w-full text-sm" />
                                    @if (isset($trainingWorkshops[$index]['image']) && is_object($trainingWorkshops[$index]['image']))
                                        <img src="{{ $trainingWorkshops[$index]['image']->temporaryUrl() }}" class="mt-2 h-20 object-cover mx-auto" />
                                    @elseif(!empty($trainingWorkshops[$index]['image']))
                                        <img src="{{ asset('storage/' . $trainingWorkshops[$index]['image']) }}" class="mt-2 h-20 object-cover mx-auto" />
                                    @endif
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="saveTrainingWorkshop({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeTrainingWorkshop({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @else
                                <td class="border px-2 py-1">{{ $w['title'] }}</td>
                                <td class="border px-2 py-1">{{ $w['description'] }}</td>
                                <td class="border px-2 py-1">{{ $w['duration'] }}</td>
                                <td class="border px-2 py-1">{{ $w['location'] }}</td>
                                <td class="border px-2 py-1">{{ $w['instructor'] }}</td>
                                <td class="border px-2 py-1">{{ $w['certificate'] ? 'نعم' : 'لا' }}</td>
                                <td class="border px-2 py-1">
                                    @if (!empty($w['image']) && !is_object($w['image']))
                                        <img src="{{ asset('storage/' . $w['image']) }}" class="h-16 object-cover mx-auto" />
                                    @else
                                        <span class="text-gray-400 text-xs">لا صورة</span>
                                    @endif
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="editTrainingWorkshop({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                        <i class="ri-edit-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeTrainingWorkshop({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addTrainingWorkshop" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف ورشة / دورة
                </button>
        
                <button type="button" wire:click="saveTrainingWorkshops" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل الورش والدورات
                </button>
            </div>
        </div>
        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">الرعاة</label>
        
            <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
                <thead class="bg-gray-100 text-gray-700 font-medium">
                    <tr>
                        <th class="border px-3 py-2">الاسم</th>
                        <th class="border px-3 py-2">المستوى</th>
                        <th class="border px-3 py-2">الرابط</th>
                        <th class="border px-3 py-2">الوصف</th>
                        <th class="border px-3 py-2">الشعار</th>
                        <th class="border px-3 py-2">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-center text-gray-800">
                    @foreach ($sponsors as $index => $sponsor)
                        <tr class="hover:bg-gray-50 transition">
                            @if ($sponsorEditingIndex === $index)
                                {{-- حالة التعديل --}}
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.name" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.level" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="url" wire:model.lazy="sponsors.{{ $index }}.link" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="text" wire:model.lazy="sponsors.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="file" wire:model="sponsors.{{ $index }}.logo" class="text-sm" />
                                    @if (isset($sponsor['logo']) && is_object($sponsor['logo']))
                                        <img src="{{ $sponsor['logo']->temporaryUrl() }}" class="w-16 h-16 object-contain mt-2" />
                                    @endif
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="saveSponsorRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @else
                                {{-- حالة العرض --}}
                                <td class="border px-2 py-1">{{ $sponsor['name'] }}</td>
                                <td class="border px-2 py-1">{{ $sponsor['level'] }}</td>
                                <td class="border px-2 py-1">
                                    <a href="{{ $sponsor['link'] }}" target="_blank" class="text-blue-600 hover:underline">الرابط</a>
                                </td>
                                <td class="border px-2 py-1">{{ $sponsor['description'] }}</td>
                                <td class="border px-2 py-1">
                                    @if ($sponsor['logo'])
                                    <img src="{{ asset('storage/' . $sponsor['logo']) }}" class="w-16 h-16 object-contain" />
                                    @else
                                    <span class="text-gray-400 text-xs">لا يوجد</span>
                                    @endif
                                </td>
                                <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                    <button wire:click="editSponsorRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                        <i class="ri-edit-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addSponsor" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف راعٍ
                </button>
        
                <button type="button" wire:click="saveSponsors" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل الرعاة
                </button>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">المتحدثين</label>

            <div class="flex gap-4 overflow-x-auto py-2 px-1">
                @foreach ($speakers as $index => $speaker)
                    <div class="min-w-[250px] max-w-[250px] bg-white border rounded-lg shadow-sm p-3 relative">
                        
                        {{-- صورة المتحدث --}}
                        <div class="w-full h-32 bg-gray-100 rounded mb-2 flex items-center justify-center overflow-hidden">
                            @if(is_string($speaker['image']) && $speaker['image'] !== '')
                                <img src="{{ Storage::url($speaker['image']) }}" class="object-cover w-full h-full" alt="speaker image">
                            @else
                                <span class="text-gray-400">لا صورة</span>
                            @endif
                        </div>

                        {{-- بيانات المتحدث --}}
                        @if ($SpeakereditingIndex === $index)
                            <div class="space-y-2">
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.name" placeholder="الاسم" class="w-full p-1 border rounded text-sm" />
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.title" placeholder="الوظيفة/اللقب" class="w-full p-1 border rounded text-sm" />
                                <input type="text" wire:model.lazy="speakers.{{ $index }}.cv" placeholder="رابط السيرة الذاتية" class="w-full p-1 border rounded text-sm" />
                                <textarea wire:model.lazy="speakers.{{ $index }}.shortDescreption" placeholder="نبذة قصيرة" class="w-full p-1 border rounded text-sm"></textarea>
                                <input type="file" wire:model="speakers.{{ $index }}.image" class="w-full text-sm" />
                            </div>

                            <div class="flex justify-between mt-2 text-sm">
                                <button wire:click="saveSpeaker({{ $index }})" class="text-green-600 hover:text-green-800"><i class="ri-save-line text-lg"></i></button>
                                <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                            </div>
                        @else
                            <div class="space-y-1 text-sm text-gray-800">
                                <p><strong>{{ $speaker['name'] }}</strong></p>
                                <p>{{ $speaker['title'] }}</p>
                                <p class="text-xs text-gray-600">{{ $speaker['shortDescreption'] }}</p>
                            </div>

                            <div class="flex justify-between mt-2 text-sm">
                                <button wire:click="editSpeaker({{ $index }})" class="text-blue-600 hover:text-blue-800"><i class="ri-edit-line text-lg"></i></button>
                                <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- زر الإضافة والحفظ --}}
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addSpeaker" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف متحدث
                </button>

                <button type="button" wire:click="saveSpeakers" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ كل المتحدثين
                </button>
            </div>
        </div>
        <div class="mb-6">
            <label class="block text-base font-semibold mb-3 text-gray-700">الفعاليات الجانبية</label>
        
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 max-h-[400px] overflow-y-auto pr-1">
                @foreach ($activities as $index => $activity)
                    <div class="border rounded-md p-4 shadow-sm bg-white relative">
                        @if ($activityeditingIndex === $index)
                            {{-- حالة التعديل --}}
                            <div class="space-y-2">
                                <input type="text" wire:model.lazy="activities.{{ $index }}.title" placeholder="عنوان الفعالية" class="w-full p-2 border rounded text-sm">
                                <input type="time" wire:model.lazy="activities.{{ $index }}.time" class="w-full p-2 border rounded text-sm">
                                <input type="text" wire:model.lazy="activities.{{ $index }}.location" placeholder="الموقع" class="w-full p-2 border rounded text-sm">
                                <textarea wire:model.lazy="activities.{{ $index }}.description" placeholder="الوصف" class="w-full p-2 border rounded text-sm"></textarea>
                                
                                <input type="file" wire:model="activities.{{ $index }}.image" class="w-full p-1 border rounded text-sm">
                                
                                <div class="flex justify-end gap-2 mt-2">
                                    <button wire:click="saveActivityRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                        <i class="ri-save-line text-lg"></i>
                                    </button>
                                    <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </div>
                            </div>
                        @else
                            {{-- حالة العرض --}}
                            <div class="space-y-1">
                                <h3 class="font-semibold text-sm text-gray-800">{{ $activity['title'] }}</h3>
                                <p class="text-xs text-gray-500">{{ $activity['time'] }} | {{ $activity['location'] }}</p>
                                <p class="text-sm text-gray-600 line-clamp-3">{{ $activity['description'] }}</p>
        
                                @if (!empty($activity['image']))
                                    <img src="{{ asset('storage/' . $activity['image']) }}" class="mt-2 w-full h-28 object-cover rounded" alt="Activity Image">
                                @endif
                            </div>
        
                            <div class="absolute top-2 left-2 flex gap-2">
                                <button wire:click="editActivityRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                    <i class="ri-edit-line text-lg"></i>
                                </button>
                                <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        
            <div class="flex items-center mt-4 gap-3">
                <button type="button" wire:click="addActivity" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    + أضف فعالية
                </button>
        
                <button type="button" wire:click="saveActivities" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                    حفظ الفعاليات
                </button>
            </div>
        </div>
    @endif

    @if ($category =="social_party")
    <div class="mb-6">
        <label class="block text-base font-semibold mb-3 text-gray-700">الجلسات</label>
    
        <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
            <thead class="bg-gray-100 text-gray-700 font-medium">
                <tr>
                    <th class="border px-3 py-2">المؤدي</th>
                    <th class="border px-3 py-2">التاريخ</th>
                    <th class="border px-3 py-2">الوقت</th>
                    <th class="border px-3 py-2">المكان</th>
                    <th class="border px-3 py-2">الوصف</th>
                    <th class="border px-3 py-2">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="text-center text-gray-800">
                @foreach ($sessions as $index => $session)
                    <tr class="hover:bg-gray-50 transition">
                        @if ($editingIndex === $index)
                            {{-- حالة التعديل --}}
                            <td class="border px-2 py-1">
                                <input type="text" wire:model.lazy="sessions.{{ $index }}.speaker" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="date" wire:model.lazy="sessions.{{ $index }}.date" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="time" wire:model.lazy="sessions.{{ $index }}.time" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="text" wire:model.lazy="sessions.{{ $index }}.location" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="text" wire:model.lazy="sessions.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                <button wire:click="saveRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                    <i class="ri-save-line text-lg"></i>
                                </button>
                                <button wire:click="removeSession({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </td>
                        @else
                            {{-- حالة العرض --}}
                            <td class="border px-2 py-1">{{ $session['speaker'] }}</td>
                            <td class="border px-2 py-1">{{ $session['date'] }}</td>
                            <td class="border px-2 py-1">{{ $session['time'] }}</td>
                            <td class="border px-2 py-1">{{ $session['location'] }}</td>
                            <td class="border px-2 py-1">{{ $session['description'] }}</td>
                            <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                <button wire:click="editRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                    <i class="ri-edit-line text-lg"></i>
                                </button>
                                <button wire:click="removeSession({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    
        <div class="flex items-center mt-4 gap-3">
            <button type="button" wire:click="addSession" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                + أضف جلسة
            </button>
    
            <button type="button" wire:click="saveSessions" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                حفظ كل الجلسات
            </button>
        </div>
    </div>

    <div class="mb-6">
        <label class="block text-base font-semibold mb-3 text-gray-700">الرعاة</label>
    
        <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
            <thead class="bg-gray-100 text-gray-700 font-medium">
                <tr>
                    <th class="border px-3 py-2">الاسم</th>
                    <th class="border px-3 py-2">المستوى</th>
                    <th class="border px-3 py-2">الرابط</th>
                    <th class="border px-3 py-2">الوصف</th>
                    <th class="border px-3 py-2">الشعار</th>
                    <th class="border px-3 py-2">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="text-center text-gray-800">
                @foreach ($sponsors as $index => $sponsor)
                    <tr class="hover:bg-gray-50 transition">
                        @if ($sponsorEditingIndex === $index)
                            {{-- حالة التعديل --}}
                            <td class="border px-2 py-1">
                                <input type="text" wire:model.lazy="sponsors.{{ $index }}.name" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="text" wire:model.lazy="sponsors.{{ $index }}.level" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="url" wire:model.lazy="sponsors.{{ $index }}.link" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="text" wire:model.lazy="sponsors.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="file" wire:model="sponsors.{{ $index }}.logo" class="text-sm" />
                                @if (isset($sponsor['logo']) && is_object($sponsor['logo']))
                                    <img src="{{ $sponsor['logo']->temporaryUrl() }}" class="w-16 h-16 object-contain mt-2" />
                                @endif
                            </td>
                            <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                <button wire:click="saveSponsorRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                    <i class="ri-save-line text-lg"></i>
                                </button>
                                <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </td>
                        @else
                            {{-- حالة العرض --}}
                            <td class="border px-2 py-1">{{ $sponsor['name'] }}</td>
                            <td class="border px-2 py-1">{{ $sponsor['level'] }}</td>
                            <td class="border px-2 py-1">
                                <a href="{{ $sponsor['link'] }}" target="_blank" class="text-blue-600 hover:underline">الرابط</a>
                            </td>
                            <td class="border px-2 py-1">{{ $sponsor['description'] }}</td>
                            <td class="border px-2 py-1">
                                @if ($sponsor['logo'])
                                <img src="{{ asset('storage/' . $sponsor['logo']) }}" class="w-16 h-16 object-contain" />
                                @else
                                <span class="text-gray-400 text-xs">لا يوجد</span>
                                @endif
                            </td>
                            <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                <button wire:click="editSponsorRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                    <i class="ri-edit-line text-lg"></i>
                                </button>
                                <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    
        <div class="flex items-center mt-4 gap-3">
            <button type="button" wire:click="addSponsor" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                + أضف راعٍ
            </button>
    
            <button type="button" wire:click="saveSponsors" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                حفظ كل الرعاة
            </button>
        </div>
    </div>

    <div class="mb-6">
        <label class="block text-base font-semibold mb-3 text-gray-700">المؤدين</label>

        <div class="flex gap-4 overflow-x-auto py-2 px-1">
            @foreach ($speakers as $index => $speaker)
                <div class="min-w-[250px] max-w-[250px] bg-white border rounded-lg shadow-sm p-3 relative">
                    
                    {{-- صورة المتحدث --}}
                    <div class="w-full h-32 bg-gray-100 rounded mb-2 flex items-center justify-center overflow-hidden">
                        @if(is_string($speaker['image']) && $speaker['image'] !== '')
                            <img src="{{ Storage::url($speaker['image']) }}" class="object-cover w-full h-full" alt="speaker image">
                        @else
                            <span class="text-gray-400">لا صورة</span>
                        @endif
                    </div>

                    {{-- بيانات المتحدث --}}
                    @if ($SpeakereditingIndex === $index)
                        <div class="space-y-2">
                            <input type="text" wire:model.lazy="speakers.{{ $index }}.name" placeholder="الاسم" class="w-full p-1 border rounded text-sm" />
                            <input type="text" wire:model.lazy="speakers.{{ $index }}.title" placeholder="الوظيفة/اللقب" class="w-full p-1 border rounded text-sm" />
                            <input type="text" wire:model.lazy="speakers.{{ $index }}.cv" placeholder="رابط السيرة الذاتية" class="w-full p-1 border rounded text-sm" />
                            <textarea wire:model.lazy="speakers.{{ $index }}.shortDescreption" placeholder="نبذة قصيرة" class="w-full p-1 border rounded text-sm"></textarea>
                            <input type="file" wire:model="speakers.{{ $index }}.image" class="w-full text-sm" />
                        </div>

                        <div class="flex justify-between mt-2 text-sm">
                            <button wire:click="saveSpeaker({{ $index }})" class="text-green-600 hover:text-green-800"><i class="ri-save-line text-lg"></i></button>
                            <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                        </div>
                    @else
                        <div class="space-y-1 text-sm text-gray-800">
                            <p><strong>{{ $speaker['name'] }}</strong></p>
                            <p>{{ $speaker['title'] }}</p>
                            <p class="text-xs text-gray-600">{{ $speaker['shortDescreption'] }}</p>
                        </div>

                        <div class="flex justify-between mt-2 text-sm">
                            <button wire:click="editSpeaker({{ $index }})" class="text-blue-600 hover:text-blue-800"><i class="ri-edit-line text-lg"></i></button>
                            <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- زر الإضافة والحفظ --}}
        <div class="flex items-center mt-4 gap-3">
            <button type="button" wire:click="addSpeaker" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                + أضف متحدث
            </button>

            <button type="button" wire:click="saveSpeakers" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                حفظ كل المتحدثين
            </button>
        </div>
    </div>
    <div class="mb-6">
        <label class="block text-base font-semibold mb-3 text-gray-700">الفعاليات الجانبية</label>
    
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 max-h-[400px] overflow-y-auto pr-1">
            @foreach ($activities as $index => $activity)
                <div class="border rounded-md p-4 shadow-sm bg-white relative">
                    @if ($activityeditingIndex === $index)
                        {{-- حالة التعديل --}}
                        <div class="space-y-2">
                            <input type="text" wire:model.lazy="activities.{{ $index }}.title" placeholder="عنوان الفعالية" class="w-full p-2 border rounded text-sm">
                            <input type="time" wire:model.lazy="activities.{{ $index }}.time" class="w-full p-2 border rounded text-sm">
                            <input type="text" wire:model.lazy="activities.{{ $index }}.location" placeholder="الموقع" class="w-full p-2 border rounded text-sm">
                            <textarea wire:model.lazy="activities.{{ $index }}.description" placeholder="الوصف" class="w-full p-2 border rounded text-sm"></textarea>
                            
                            <input type="file" wire:model="activities.{{ $index }}.image" class="w-full p-1 border rounded text-sm">
                            
                            <div class="flex justify-end gap-2 mt-2">
                                <button wire:click="saveActivityRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                    <i class="ri-save-line text-lg"></i>
                                </button>
                                <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </div>
                        </div>
                    @else
                        {{-- حالة العرض --}}
                        <div class="space-y-1">
                            <h3 class="font-semibold text-sm text-gray-800">{{ $activity['title'] }}</h3>
                            <p class="text-xs text-gray-500">{{ $activity['time'] }} | {{ $activity['location'] }}</p>
                            <p class="text-sm text-gray-600 line-clamp-3">{{ $activity['description'] }}</p>
    
                            @if (!empty($activity['image']))
                                <img src="{{ asset('storage/' . $activity['image']) }}" class="mt-2 w-full h-28 object-cover rounded" alt="Activity Image">
                            @endif
                        </div>
    
                        <div class="absolute top-2 left-2 flex gap-2">
                            <button wire:click="editActivityRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                <i class="ri-edit-line text-lg"></i>
                            </button>
                            <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                <i class="ri-delete-bin-line text-lg"></i>
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    
        <div class="flex items-center mt-4 gap-3">
            <button type="button" wire:click="addActivity" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                + أضف فعالية
            </button>
    
            <button type="button" wire:click="saveActivities" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                حفظ الفعاليات
            </button>
        </div>
    </div>
    @endif

    @if ($category == "sports_fitness")
    <div class="mb-6">
        <label class="block text-base font-semibold mb-3 text-gray-700">الجلسات & المباريات</label>
    
        <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
            <thead class="bg-gray-100 text-gray-700 font-medium">
                <tr>
                    <th class="border px-3 py-2">المؤدي</th>
                    <th class="border px-3 py-2">التاريخ</th>
                    <th class="border px-3 py-2">الوقت</th>
                    <th class="border px-3 py-2">المكان</th>
                    <th class="border px-3 py-2">الوصف</th>
                    <th class="border px-3 py-2">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="text-center text-gray-800">
                @foreach ($sessions as $index => $session)
                    <tr class="hover:bg-gray-50 transition">
                        @if ($editingIndex === $index)
                            {{-- حالة التعديل --}}
                            <td class="border px-2 py-1">
                                <input type="text" wire:model.lazy="sessions.{{ $index }}.speaker" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="date" wire:model.lazy="sessions.{{ $index }}.date" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="time" wire:model.lazy="sessions.{{ $index }}.time" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="text" wire:model.lazy="sessions.{{ $index }}.location" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="text" wire:model.lazy="sessions.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                <button wire:click="saveRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                    <i class="ri-save-line text-lg"></i>
                                </button>
                                <button wire:click="removeSession({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </td>
                        @else
                            {{-- حالة العرض --}}
                            <td class="border px-2 py-1">{{ $session['speaker'] }}</td>
                            <td class="border px-2 py-1">{{ $session['date'] }}</td>
                            <td class="border px-2 py-1">{{ $session['time'] }}</td>
                            <td class="border px-2 py-1">{{ $session['location'] }}</td>
                            <td class="border px-2 py-1">{{ $session['description'] }}</td>
                            <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                <button wire:click="editRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                    <i class="ri-edit-line text-lg"></i>
                                </button>
                                <button wire:click="removeSession({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    
        <div class="flex items-center mt-4 gap-3">
            <button type="button" wire:click="addSession" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                + أضف جلسة
            </button>
    
            <button type="button" wire:click="saveSessions" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                حفظ كل الجلسات
            </button>
        </div>
    </div>

    <div class="mb-6">
        <label class="block text-base font-semibold mb-3 text-gray-700">الرعاة</label>
    
        <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm">
            <thead class="bg-gray-100 text-gray-700 font-medium">
                <tr>
                    <th class="border px-3 py-2">الاسم</th>
                    <th class="border px-3 py-2">المستوى</th>
                    <th class="border px-3 py-2">الرابط</th>
                    <th class="border px-3 py-2">الوصف</th>
                    <th class="border px-3 py-2">الشعار</th>
                    <th class="border px-3 py-2">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="text-center text-gray-800">
                @foreach ($sponsors as $index => $sponsor)
                    <tr class="hover:bg-gray-50 transition">
                        @if ($sponsorEditingIndex === $index)
                            {{-- حالة التعديل --}}
                            <td class="border px-2 py-1">
                                <input type="text" wire:model.lazy="sponsors.{{ $index }}.name" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="text" wire:model.lazy="sponsors.{{ $index }}.level" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="url" wire:model.lazy="sponsors.{{ $index }}.link" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="text" wire:model.lazy="sponsors.{{ $index }}.description" class="w-full p-1 border rounded text-sm" />
                            </td>
                            <td class="border px-2 py-1">
                                <input type="file" wire:model="sponsors.{{ $index }}.logo" class="text-sm" />
                                @if (isset($sponsor['logo']) && is_object($sponsor['logo']))
                                    <img src="{{ $sponsor['logo']->temporaryUrl() }}" class="w-16 h-16 object-contain mt-2" />
                                @endif
                            </td>
                            <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                <button wire:click="saveSponsorRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                    <i class="ri-save-line text-lg"></i>
                                </button>
                                <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </td>
                        @else
                            {{-- حالة العرض --}}
                            <td class="border px-2 py-1">{{ $sponsor['name'] }}</td>
                            <td class="border px-2 py-1">{{ $sponsor['level'] }}</td>
                            <td class="border px-2 py-1">
                                <a href="{{ $sponsor['link'] }}" target="_blank" class="text-blue-600 hover:underline">الرابط</a>
                            </td>
                            <td class="border px-2 py-1">{{ $sponsor['description'] }}</td>
                            <td class="border px-2 py-1">
                                @if ($sponsor['logo'])
                                <img src="{{ asset('storage/' . $sponsor['logo']) }}" class="w-16 h-16 object-contain" />
                                @else
                                <span class="text-gray-400 text-xs">لا يوجد</span>
                                @endif
                            </td>
                            <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                                <button wire:click="editSponsorRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                    <i class="ri-edit-line text-lg"></i>
                                </button>
                                <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    
        <div class="flex items-center mt-4 gap-3">
            <button type="button" wire:click="addSponsor" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                + أضف راعٍ
            </button>
    
            <button type="button" wire:click="saveSponsors" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                حفظ كل الرعاة
            </button>
        </div>
    </div>

    <div class="mb-6">
        <label class="block text-base font-semibold mb-3 text-gray-700">الشخصيات & الرياضيون</label>

        <div class="flex gap-4 overflow-x-auto py-2 px-1">
            @foreach ($speakers as $index => $speaker)
                <div class="min-w-[250px] max-w-[250px] bg-white border rounded-lg shadow-sm p-3 relative">
                    
                    {{-- صورة المتحدث --}}
                    <div class="w-full h-32 bg-gray-100 rounded mb-2 flex items-center justify-center overflow-hidden">
                        @if(is_string($speaker['image']) && $speaker['image'] !== '')
                            <img src="{{ Storage::url($speaker['image']) }}" class="object-cover w-full h-full" alt="speaker image">
                        @else
                            <span class="text-gray-400">لا صورة</span>
                        @endif
                    </div>

                    {{-- بيانات المتحدث --}}
                    @if ($SpeakereditingIndex === $index)
                        <div class="space-y-2">
                            <input type="text" wire:model.lazy="speakers.{{ $index }}.name" placeholder="الاسم" class="w-full p-1 border rounded text-sm" />
                            <input type="text" wire:model.lazy="speakers.{{ $index }}.title" placeholder="الوظيفة/اللقب" class="w-full p-1 border rounded text-sm" />
                            <input type="text" wire:model.lazy="speakers.{{ $index }}.cv" placeholder="رابط السيرة الذاتية" class="w-full p-1 border rounded text-sm" />
                            <textarea wire:model.lazy="speakers.{{ $index }}.shortDescreption" placeholder="نبذة قصيرة" class="w-full p-1 border rounded text-sm"></textarea>
                            <input type="file" wire:model="speakers.{{ $index }}.image" class="w-full text-sm" />
                        </div>

                        <div class="flex justify-between mt-2 text-sm">
                            <button wire:click="saveSpeaker({{ $index }})" class="text-green-600 hover:text-green-800"><i class="ri-save-line text-lg"></i></button>
                            <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                        </div>
                    @else
                        <div class="space-y-1 text-sm text-gray-800">
                            <p><strong>{{ $speaker['name'] }}</strong></p>
                            <p>{{ $speaker['title'] }}</p>
                            <p class="text-xs text-gray-600">{{ $speaker['shortDescreption'] }}</p>
                        </div>

                        <div class="flex justify-between mt-2 text-sm">
                            <button wire:click="editSpeaker({{ $index }})" class="text-blue-600 hover:text-blue-800"><i class="ri-edit-line text-lg"></i></button>
                            <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- زر الإضافة والحفظ --}}
        <div class="flex items-center mt-4 gap-3">
            <button type="button" wire:click="addSpeaker" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                + أضف شخصية
            </button>

            <button type="button" wire:click="saveSpeakers" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                حفظ كل الشخصيات
            </button>
        </div>
    </div>
    <div class="mb-6">
        <label class="block text-base font-semibold mb-3 text-gray-700">الفعاليات الجانبية</label>
    
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 max-h-[400px] overflow-y-auto pr-1">
            @foreach ($activities as $index => $activity)
                <div class="border rounded-md p-4 shadow-sm bg-white relative">
                    @if ($activityeditingIndex === $index)
                        {{-- حالة التعديل --}}
                        <div class="space-y-2">
                            <input type="text" wire:model.lazy="activities.{{ $index }}.title" placeholder="عنوان الفعالية" class="w-full p-2 border rounded text-sm">
                            <input type="time" wire:model.lazy="activities.{{ $index }}.time" class="w-full p-2 border rounded text-sm">
                            <input type="text" wire:model.lazy="activities.{{ $index }}.location" placeholder="الموقع" class="w-full p-2 border rounded text-sm">
                            <textarea wire:model.lazy="activities.{{ $index }}.description" placeholder="الوصف" class="w-full p-2 border rounded text-sm"></textarea>
                            
                            <input type="file" wire:model="activities.{{ $index }}.image" class="w-full p-1 border rounded text-sm">
                            
                            <div class="flex justify-end gap-2 mt-2">
                                <button wire:click="saveActivityRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                    <i class="ri-save-line text-lg"></i>
                                </button>
                                <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </div>
                        </div>
                    @else
                        {{-- حالة العرض --}}
                        <div class="space-y-1">
                            <h3 class="font-semibold text-sm text-gray-800">{{ $activity['title'] }}</h3>
                            <p class="text-xs text-gray-500">{{ $activity['time'] }} | {{ $activity['location'] }}</p>
                            <p class="text-sm text-gray-600 line-clamp-3">{{ $activity['description'] }}</p>
    
                            @if (!empty($activity['image']))
                                <img src="{{ asset('storage/' . $activity['image']) }}" class="mt-2 w-full h-28 object-cover rounded" alt="Activity Image">
                            @endif
                        </div>
    
                        <div class="absolute top-2 left-2 flex gap-2">
                            <button wire:click="editActivityRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                <i class="ri-edit-line text-lg"></i>
                            </button>
                            <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                <i class="ri-delete-bin-line text-lg"></i>
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    
        <div class="flex items-center mt-4 gap-3">
            <button type="button" wire:click="addActivity" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                + أضف فعالية
            </button>
    
            <button type="button" wire:click="saveActivities" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                حفظ الفعاليات
            </button>
        </div>
    </div>
    @endif

    <div class="mb-6">
        <label class="block text-base font-semibold mb-3 text-gray-700">الخدمات المتوفرة</label>
    
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 max-h-[400px] overflow-y-auto pr-1">
            @foreach ($services as $index => $activity)
                <div class="border rounded-md p-4 shadow-sm bg-white relative">
                    @if ($servicesEditingIndex === $index)
                        {{-- حالة التعديل --}}
                        <div class="space-y-2">
                            <input type="text" wire:model.lazy="services.{{ $index }}.title" placeholder="عنوان الخدمة" class="w-full p-2 border rounded text-sm">
                            <input type="time" wire:model.lazy="services.{{ $index }}.time" class="w-full p-2 border rounded text-sm">
                            <input type="text" wire:model.lazy="services.{{ $index }}.location" placeholder="الموقع" class="w-full p-2 border rounded text-sm">
                            <textarea wire:model.lazy="services.{{ $index }}.description" placeholder="الوصف" class="w-full p-2 border rounded text-sm"></textarea>
                            
                            <input type="file" wire:model="services.{{ $index }}.image" class="w-full p-1 border rounded text-sm">
                            
                            <div class="flex justify-end gap-2 mt-2">
                                <button wire:click="saveServiceRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                    <i class="ri-save-line text-lg"></i>
                                </button>
                                <button wire:click="removeService({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </div>
                        </div>
                    @else
                        {{-- حالة العرض --}}
                        <div class="space-y-1">
                            <h3 class="font-semibold text-sm text-gray-800">{{ $activity['title'] }}</h3>
                            <p class="text-xs text-gray-500">{{ $activity['time'] }} | {{ $activity['location'] }}</p>
                            <p class="text-sm text-gray-600 line-clamp-3">{{ $activity['description'] }}</p>
    
                            @if (!empty($activity['image']))
                                <img src="{{ asset('storage/' . $activity['image']) }}" class="mt-2 w-full h-28 object-cover rounded" alt="Activity Image">
                            @endif
                        </div>
    
                        <div class="absolute top-2 left-2 flex gap-2">
                            <button wire:click="editServiceRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                                <i class="ri-edit-line text-lg"></i>
                            </button>
                            <button wire:click="removeService({{ $index }})" class="text-red-600 hover:text-red-800">
                                <i class="ri-delete-bin-line text-lg"></i>
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    
        <div class="flex items-center mt-4 gap-3">
            <button type="button" wire:click="addService" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                + أضف خدمة
            </button>
    
            <button type="button" wire:click="saveServices" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                حفظ الخدمات
            </button>
        </div>
    </div>
</div>

@endif

@if ($type == "services")
    
@endif


</div>