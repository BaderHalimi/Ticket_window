<div class="space-y-8 p-6 bg-gradient-to-br from-gray-50 to-white rounded-xl shadow-sm">

    {{-- عرض الأخطاء العامة --}}
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-r-lg">
            <div class="flex items-center mb-2">
                <i class="ri-error-warning-line mr-2 text-lg"></i>
                <h4 class="font-bold">{{ __('Please fix the following errors:') }}</h4>
            </div>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- نصائح وإرشادات --}}
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
        <div class="flex items-start">
            <i class="ri-lightbulb-line text-blue-600 text-xl mr-3 mt-1"></i>
            <div>
                <h4 class="font-bold text-blue-800 mb-2">{{ __('Image Tips') }}</h4>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li class="flex items-center">
                        <i class="ri-check-line mr-2 text-green-600"></i>
                        {{ __('Use high-quality images for better presentation') }}
                    </li>
                    <li class="flex items-center">
                        <i class="ri-check-line mr-2 text-green-600"></i>
                        {{ __('Main image appears first in search results') }}
                    </li>
                    <li class="flex items-center">
                        <i class="ri-check-line mr-2 text-green-600"></i>
                        {{ __('Gallery images help customers see more details') }}
                    </li>
                    <li class="flex items-center">
                        <i class="ri-check-line mr-2 text-green-600"></i>
                        {{ __('Recommended aspect ratio: 4:3 or 16:9') }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
    {{-- الصورة الأساسية --}}
    <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
        <div class="flex items-center mb-4 gap-4">
            <i class="ri-image-line text-2xl text-blue-600 mr-3"></i>
            <div>
                <h3 class="text-lg font-bold text-gray-800">{{ __('Main Image') }}</h3>
                <p class="text-sm text-gray-600">{{ __('Upload the primary image for your offering') }}</p>
            </div>
        </div>

        {{-- منطقة رفع الصورة الأساسية --}}
        <div class="relative">
            <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-blue-400 transition-colors duration-300 bg-gradient-to-br from-blue-50 to-indigo-50">
                <input type="file"
                       wire:model="image"
                       accept="image/*"
                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                       id="main-image-input">

                <div class="space-y-4">
                    <div class="mx-auto w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="ri-upload-cloud-2-line text-2xl text-blue-600"></i>
                    </div>

                    <div>
                        <p class="text-lg font-medium text-gray-700">{{ __('Click to upload main image') }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ __('PNG, JPG, JPEG up to 5MB') }}</p>
                        <p class="text-xs text-gray-400 mt-2">{{ __('Recommended size: 800x600 pixels') }}</p>
                    </div>

                    <button type="button"
                            onclick="document.getElementById('main-image-input').click()"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <i class="ri-upload-line mr-2"></i>
                        {{ __('Choose File') }}
                    </button>
                </div>
            </div>

            {{-- Loading indicator --}}
            <div wire:loading wire:target="image" class="absolute inset-0 bg-white bg-opacity-75 rounded-xl flex items-center justify-center">
                <div class="flex items-center space-x-2">
                    <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
                    <span class="text-blue-600 font-medium">{{ __('Uploading...') }}</span>
                </div>
            </div>
        </div>

        {{-- عرض الصورة الحالية --}}
        @if ($offering->image)
            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                <h4 class="text-sm font-medium text-gray-700 mb-3 flex items-center">
                    <i class="ri-image-2-line mr-2 text-green-600"></i>
                    {{ __('Current Image') }}
                </h4>
                <div class="relative inline-block">
                    <img src="{{ Storage::url($offering->image) }}"
                         class="h-32 w-48 object-cover rounded-lg shadow-md border-2 border-white"
                         alt="{{ __('Main Image') }}">
                    <div class="absolute -top-2 -right-2 bg-green-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs">
                        <i class="ri-check-line"></i>
                    </div>
                </div>
            </div>
        @endif

        {{-- رسالة الخطأ --}}
        @error('image')
            <div class="mt-3 p-3 bg-red-100 border border-red-300 text-red-700 rounded-lg flex items-center">
                <i class="ri-error-warning-line mr-2"></i>
                <span class="text-sm">{{ $message }}</span>
            </div>
        @enderror
    </div>

    {{-- معرض الصور --}}
    <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-4">
                <i class="ri-gallery-line text-2xl text-purple-600 mr-3"></i>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">{{ __('Image Gallery') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('Add multiple images to showcase your offering') }}</p>
                </div>
            </div>
            <div class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                {{ count($gallery) }}/{{ $maxGalleryImages ?? 10 }} {{ __('images') }}
            </div>
        </div>

        {{-- منطقة رفع صور المعرض --}}
        @if(count($gallery) < ($maxGalleryImages ?? 10))
            <div class="relative mb-6">
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-purple-400 transition-colors duration-300 bg-gradient-to-br from-purple-50 to-pink-50">
                    <input type="file"
                           wire:model="gallery1"
                           accept="image/*"
                           multiple
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                           id="gallery-input">

                    <div class="space-y-3">
                        <div class="mx-auto w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="ri-gallery-upload-line text-xl text-purple-600"></i>
                        </div>

                        <div>
                            <p class="text-base font-medium text-gray-700">{{ __('Add gallery images') }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ __('Select multiple images at once') }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ __('PNG, JPG, JPEG up to 3MB each') }}</p>
                        </div>

                        <button type="button"
                                onclick="document.getElementById('gallery-input').click()"
                                class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200">
                            <i class="ri-add-line mr-2"></i>
                            {{ __('Add Images') }}
                        </button>
                    </div>
                </div>

                {{-- Loading indicator --}}
                <div wire:loading wire:target="gallery1" class="absolute inset-0 bg-white bg-opacity-75 rounded-xl flex items-center justify-center">
                    <div class="flex items-center space-x-2">
                        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-purple-600"></div>
                        <span class="text-purple-600 font-medium">{{ __('Uploading images...') }}</span>
                    </div>
                </div>
            </div>
        @else
            <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex items-center">
                    <i class="ri-information-line text-yellow-600 mr-2"></i>
                    <span class="text-sm text-yellow-800">{{ __('Maximum number of images reached') }} ({{ $maxGalleryImages ?? 10 }})</span>
                </div>
            </div>
        @endif

        {{-- عرض صور المعرض --}}
        @if(count($gallery) > 0)
            <div class="space-y-4">
                <h4 class="text-sm font-medium text-gray-700 flex items-center">
                    <i class="ri-image-2-line mr-2 text-green-600"></i>
                    {{ __('Gallery Images') }} ({{ count($gallery) }})
                </h4>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($gallery as $index => $imagePath)
                        @php
                            $url = is_array($imagePath) ? Storage::url($imagePath['path'] ?? '') : Storage::url($imagePath);
                        @endphp
                        <div class="relative group bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200"
                             wire:key="gallery-image-{{ $index }}">

                            {{-- الصورة --}}
                            <div class="aspect-square">
                                <img src="{{ $url }}"
                                     class="w-full h-full object-cover"
                                     alt="{{ __('Gallery Image') }} {{ $index + 1 }}"
                                     loading="lazy">
                            </div>

                            {{-- أزرار التحكم --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end justify-center pb-3">
                                <div class="flex space-x-2 gap-2">
                                    {{-- زر المعاينة --}}
                                    <button type="button"
                                            onclick="previewImage('{{ $url }}')"
                                            class="bg-blue-600 hover:bg-blue-700 text-white p-2.5 rounded-full transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-110 border-2 border-white/20"
                                            title="{{ __('Preview') }}">
                                        <i class="ri-eye-line text-sm font-bold"></i>
                                    </button>

                                    {{-- زر الحذف --}}
                                    <button type="button"
                                            wire:click="removeGalleryImage({{ $index }})"
                                            class="bg-red-600 hover:bg-red-700 text-white p-2.5 rounded-full transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-110 border-2 border-white/20"
                                            title="{{ __('Delete') }}">
                                        <i class="ri-delete-bin-line text-sm font-bold"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- أزرار التحكم البديلة للشاشات الصغيرة --}}
                            <div class="absolute top-2 right-2 flex space-x-1 gap-1 md:hidden">
                                {{-- زر المعاينة --}}
                                <button type="button"
                                        onclick="previewImage('{{ $url }}')"
                                        class="bg-blue-600/90 hover:bg-blue-700 text-white p-1.5 rounded-full transition-all duration-200 shadow-md border border-white/30"
                                        title="{{ __('Preview') }}">
                                    <i class="ri-eye-line text-xs"></i>
                                </button>

                                {{-- زر الحذف --}}
                                <button type="button"
                                        wire:click="removeGalleryImage({{ $index }})"
                                        class="bg-red-600/90 hover:bg-red-700 text-white p-1.5 rounded-full transition-all duration-200 shadow-md border border-white/30"
                                        title="{{ __('Delete') }}">
                                    <i class="ri-delete-bin-line text-xs"></i>
                                </button>
                            </div>

                            {{-- رقم الصورة --}}
                            <div class="absolute top-2 left-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white text-xs px-2.5 py-1 rounded-full font-bold shadow-lg border border-white/30">
                                {{ $index + 1 }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-center py-12 text-gray-500">
                <i class="ri-gallery-line text-4xl mb-3 text-gray-300"></i>
                <p class="text-lg font-medium">{{ __('No gallery images yet') }}</p>
                <p class="text-sm">{{ __('Add some images to showcase your offering') }}</p>
            </div>
        @endif

        {{-- رسالة الخطأ للمعرض --}}
        @error('gallery1')
            <div class="mt-4 p-3 bg-red-100 border border-red-300 text-red-700 rounded-lg flex items-center">
                <i class="ri-error-warning-line mr-2"></i>
                <span class="text-sm">{{ $message }}</span>
            </div>
        @enderror

        @error('gallery1.*')
            <div class="mt-4 p-3 bg-red-100 border border-red-300 text-red-700 rounded-lg flex items-center">
                <i class="ri-error-warning-line mr-2"></i>
                <span class="text-sm">{{ $message }}</span>
            </div>
        @enderror
    </div>

    

</div>

<script>
    

    // تحسين تجربة السحب والإفلات
    document.addEventListener('DOMContentLoaded', function() {
        const dropZones = document.querySelectorAll('[id$="-input"]');

        dropZones.forEach(dropZone => {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });

            dropZone.addEventListener('drop', handleDrop, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function highlight(e) {
            const dropZone = e.target.closest('.border-dashed');
            if (dropZone) {
                dropZone.classList.add('border-blue-500', 'bg-blue-100');
            }
        }

        function unhighlight(e) {
            const dropZone = e.target.closest('.border-dashed');
            if (dropZone) {
                dropZone.classList.remove('border-blue-500', 'bg-blue-100');
            }
        }

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            // تحديث input بالملفات المسحوبة
            e.target.files = files;
            e.target.dispatchEvent(new Event('change', { bubbles: true }));
        }
    });

    // تحسين عرض الأخطاء
    document.addEventListener('livewire:init', () => {
        Livewire.on('gallery-error', (event) => {
            Swal.fire({
                title: '{{ __("Upload Error") }}',
                text: event.message,
                icon: 'error',
                confirmButtonText: '{{ __("OK") }}'
            });
        });

        Livewire.on('gallery-success', (event) => {
            Swal.fire({
                title: '{{ __("Success") }}',
                text: event.message,
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
        });
    });
</script>
