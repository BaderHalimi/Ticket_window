<div class="mb-6" dir="rtl">
    <!-- Success Message -->
    @if (session()->has('success'))
        <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Message -->
    @if (session()->has('error'))
        <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <label class="block text-base font-semibold mb-3 text-gray-700">{{ __('Event Links') }}</label>

    <div class="overflow-auto max-h-72 border border-gray-300 rounded bg-white">
        <table class="w-full min-w-max table-auto border-collapse border border-gray-300">
            <thead class="bg-gray-100 text-gray-700 font-medium">
                <tr>
                    <th class="border px-3 py-2 whitespace-nowrap">{{ __('Platform') }}</th>
                    <th class="border px-3 py-2 whitespace-nowrap">{{ __('URL') }}</th>
                    <th class="border px-3 py-2 whitespace-nowrap">{{ __('Description') }}</th>
                    <th class="border px-3 py-2 whitespace-nowrap">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="text-center text-gray-800">
                @forelse ($links as $index => $link)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="border px-2 py-1 whitespace-nowrap">{{ $link['platform'] }}</td>
                        <td class="border px-2 py-1 whitespace-nowrap">
                            <a href="{{ $link['url'] }}" target="_blank" class="text-blue-500 underline break-all">{{ $link['url'] }}</a>
                        </td>
                        <td class="border px-2 py-1 max-w-xs">
                            <div class="max-h-20 overflow-y-auto break-words">
                                {{ $link['description'] }}
                            </div>
                        </td>
                        <td class="border px-2 py-1 flex justify-center gap-2 items-center whitespace-nowrap">
                            <button wire:click="openEditModal({{ $index }})"
                                    class="text-blue-600 hover:text-blue-800"
                                    title="{{ __('Edit') }}">
                                <i class="ri-edit-line text-lg"></i>
                            </button>
                            <button onclick="confirmDeleteLink(`{{ $index }}`, '{{ $this->getId() }}')"
                                    class="text-red-600 hover:text-red-800"
                                    title="{{ __('Delete') }}"
                                    data-component-id="{{ $this->getId() }}">
                                <i class="ri-delete-bin-line text-lg"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-8 text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="ri-link text-4xl mb-2"></i>
                                <p>{{ __('No links added yet') }}</p>
                                <p class="text-sm">{{ __('Click "Add Link" to create your first link') }}</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex items-center mt-4">
        <button type="button"
                wire:click="openCreateModal"
                class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
            + {{ __('Add Link') }}
        </button>
    </div>

    {{-- {{ __('Create Link Modal') }} --}}
    @if($showCreateModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 mx-4 relative">
                <h3 class="text-lg font-semibold mb-4">{{ __('Add New Link') }}</h3>

                <!-- Error Message inside Create Modal -->
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form wire:submit="createLink">
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block mb-1 font-medium">{{ __('Platform') }} <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="newLink.platform"
                                class="w-full p-2 border rounded @error('newLink.platform') border-red-500 @enderror"
                                placeholder="{{ __('Enter platform name') }}"
                                maxlength="255" />
                            @error('newLink.platform')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-xs mt-1">{{ __('Enter platform name (e.g., Facebook, YouTube, Instagram)') }}</p>
                        </div>

                        <div>
                            <label class="block mb-1 font-medium">{{ __('URL') }} <span class="text-red-500">*</span></label>
                            <input type="url" wire:model="newLink.url"
                                class="w-full p-2 border rounded @error('newLink.url') border-red-500 @enderror"
                                placeholder="{{ __('Enter URL') }}"
                                maxlength="500" />
                            @error('newLink.url')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-xs mt-1">{{ __('Enter full URL starting with http:// or https://') }}</p>
                        </div>

                        <div>
                            <label class="block mb-1 font-medium">{{ __('Description') }} <span class="text-red-500">*</span></label>
                            <textarea wire:model="newLink.description"
                                class="w-full p-2 border rounded @error('newLink.description') border-red-500 @enderror"
                                placeholder="{{ __('Enter description') }}"
                                rows="4"
                                maxlength="1000"></textarea>
                            @error('newLink.description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-xs mt-1">{{ __('Describe what this link provides (10-1000 characters)') }}</p>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button"
                            wire:click="closeCreateModal"
                            class="px-4 py-2 border rounded hover:bg-gray-100">{{ __('Cancel') }}</button>
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="createLink">{{ __('Create Link') }}</span>
                            <span wire:loading wire:target="createLink" class="flex items-center">
                                <i class="ri-loader-4-line animate-spin mr-2"></i>
                                {{ __('Creating...') }}
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- {{ __('Edit Link Modal') }} --}}
    @if($showEditModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 mx-4 relative">
                <h3 class="text-lg font-semibold mb-4">{{ __('Edit Link') }}</h3>

                <form wire:submit="updateLink">
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block mb-1 font-medium">{{ __('Platform') }} <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="editLink.platform"
                                class="w-full p-2 border rounded @error('editLink.platform') border-red-500 @enderror"
                                placeholder="{{ __('Enter platform name') }}"
                                maxlength="255" />
                            @error('editLink.platform')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-xs mt-1">{{ __('Enter platform name (e.g., Facebook, YouTube, Instagram)') }}</p>
                        </div>

                        <div>
                            <label class="block mb-1 font-medium">{{ __('URL') }} <span class="text-red-500">*</span></label>
                            <input type="url" wire:model="editLink.url"
                                class="w-full p-2 border rounded @error('editLink.url') border-red-500 @enderror"
                                placeholder="{{ __('Enter URL') }}"
                                maxlength="500" />
                            @error('editLink.url')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-xs mt-1">{{ __('Enter full URL starting with http:// or https://') }}</p>
                        </div>

                        <div>
                            <label class="block mb-1 font-medium">{{ __('Description') }} <span class="text-red-500">*</span></label>
                            <textarea wire:model="editLink.description"
                                class="w-full p-2 border rounded @error('editLink.description') border-red-500 @enderror"
                                placeholder="{{ __('Enter description') }}"
                                rows="4"
                                maxlength="1000"></textarea>
                            @error('editLink.description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-xs mt-1">{{ __('Describe what this link provides (10-1000 characters)') }}</p>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button"
                            wire:click="closeEditModal"
                            class="px-4 py-2 border rounded hover:bg-gray-100">{{ __('Cancel') }}</button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="updateLink">{{ __('Save Changes') }}</span>
                            <span wire:loading wire:target="updateLink" class="flex items-center">
                                <i class="ri-loader-4-line animate-spin mr-2"></i>
                                {{ __('Saving...') }}
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
