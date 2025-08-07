<div>
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
    


</div>
