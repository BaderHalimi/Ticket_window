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

    <label class="block text-base font-semibold mb-3 text-gray-700">{{ __('Sessions') }}</label>

    <div class="overflow-auto max-h-72 border border-gray-300 rounded bg-white">
        <table class="w-full min-w-max table-auto border-collapse border border-gray-300">

            <thead class="bg-gray-100 text-gray-700 font-medium">
                <tr>
                    <th class="border px-3 py-2">{{ __('Speaker') }}</th>
                    <th class="border px-3 py-2">{{ __('Time') }}</th>
                    <th class="border px-3 py-2">{{ __('Description') }}</th>
                    <th class="border px-3 py-2">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="text-center text-gray-800">
                @forelse ($sessions as $index => $session)
                <tr class="hover:bg-gray-50 transition">
                    <td class="border px-2 py-1">{{ $session['speaker'] }}</td>
                    <td class="border px-2 py-1">{{ $session['time'] }}</td>
                    <td class="border px-2 py-1 max-w-xs">
                        <div class="max-h-20 overflow-y-auto break-words">
                            {{ $session['description'] }}
                        </div>
                    </td>
                    <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                        <button wire:click="openEditModal({{ $index }})"
                            class="text-blue-600 hover:text-blue-800"
                            title="{{ __('Edit') }}">
                            <i class="ri-edit-line text-lg"></i>
                        </button>
                        <button onclick="confirmDeleteSession({{ $index }}, '{{ $this->getId() }}')"
                                class="text-red-600 hover:text-red-800"
                                title="{{ __('Delete') }}"
                                data-component-id="{{ $this->getId() }}">
                            <i class="ri-delete-bin-line text-lg"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="border px-4 py-8 text-gray-500 text-center">
                        <div class="flex flex-col items-center">
                            <i class="ri-calendar-line text-4xl mb-2 text-gray-300"></i>
                            <p>{{ __('No sessions added yet') }}</p>
                            <p class="text-sm">{{ __('Click "Add Session" to create your first session') }}</p>
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
            + {{ __('Add Session') }}
        </button>
    </div>

    {{-- {{ __('Create Session Modal') }} --}}
    @if($showCreateModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 mx-4 relative">
            <h3 class="text-lg font-semibold mb-4">{{ __('Add New Session') }}</h3>

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

            <form wire:submit="createSession">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block mb-1 font-medium">{{ __('Speaker') }} <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="newSession.speaker"
                            class="w-full p-2 border rounded @error('newSession.speaker') border-red-500 @enderror"
                            placeholder="{{ __('Enter speaker name') }}"
                            maxlength="255" />
                        @error('newSession.speaker')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-1">{{ __('Enter the name of the speaker (2-255 characters, letters and numbers only)') }}</p>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">{{ __('Time') }} <span class="text-red-500">*</span></label>
                        <input type="time" wire:model="newSession.time"
                            class="w-full p-2 border rounded @error('newSession.time') border-red-500 @enderror" />
                        @error('newSession.time')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-1">{{ __('Select the session time') }}</p>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">{{ __('Description') }} <span class="text-red-500">*</span></label>
                        <textarea wire:model="newSession.description"
                            rows="3"
                            class="w-full p-2 border rounded resize-none @error('newSession.description') border-red-500 @enderror"
                            placeholder="{{ __('Describe the session content and objectives') }}"
                            maxlength="1000"></textarea>
                        @error('newSession.description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-1">{{ __('Describe the session content (10-1000 characters)') }}</p>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button"
                        wire:click="closeCreateModal"
                        class="px-4 py-2 border rounded hover:bg-gray-100">{{ __('Cancel') }}</button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="createSession">{{ __('Create Session') }}</span>
                        <span wire:loading wire:target="createSession" class="flex items-center">
                            <i class="ri-loader-4-line animate-spin mr-2"></i>
                            {{ __('Creating...') }}
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- {{ __('Edit Session Modal') }} --}}
    @if($showEditModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 mx-4 relative">
            <h3 class="text-lg font-semibold mb-4">{{ __('Edit Session') }}</h3>

            <form wire:submit="updateSession">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block mb-1 font-medium">{{ __('Speaker') }} <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="editSession.speaker"
                            class="w-full p-2 border rounded @error('editSession.speaker') border-red-500 @enderror"
                            placeholder="{{ __('Enter speaker name') }}"
                            maxlength="255" />
                        @error('editSession.speaker')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-1">{{ __('Enter the name of the speaker (2-255 characters, letters and numbers only)') }}</p>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">{{ __('Time') }} <span class="text-red-500">*</span></label>
                        <input type="time" wire:model="editSession.time"
                            class="w-full p-2 border rounded @error('editSession.time') border-red-500 @enderror" />
                        @error('editSession.time')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-1">{{ __('Select the session time') }}</p>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">{{ __('Description') }} <span class="text-red-500">*</span></label>
                        <textarea wire:model="editSession.description"
                            rows="3"
                            class="w-full p-2 border rounded resize-none @error('editSession.description') border-red-500 @enderror"
                            placeholder="{{ __('Describe the session content and objectives') }}"
                            maxlength="1000"></textarea>
                        @error('editSession.description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-1">{{ __('Describe the session content (10-1000 characters)') }}</p>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button"
                        wire:click="closeEditModal"
                        class="px-4 py-2 border rounded hover:bg-gray-100">{{ __('Cancel') }}</button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="updateSession">{{ __('Save Changes') }}</span>
                        <span wire:loading wire:target="updateSession" class="flex items-center">
                            <i class="ri-loader-4-line animate-spin mr-2"></i>
                            {{ __('Saving...') }}
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

<script>
    function confirmDeleteSession(index) {
        Swal.fire({
            title: '{{ __("Are you sure?") }}',
            text: '{{ __("You won\'t be able to revert this!") }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: '{{ __("Yes, delete it!") }}',
            cancelButtonText: '{{ __("Cancel") }}',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // استخدام Livewire للحذف
                Livewire.find('{{ $this->getId() }}').call('removeSession', index);

                Swal.fire({
                    title: '{{ __("Deleted!") }}',
                    text: '{{ __("Session has been deleted.") }}',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    }
</script>

</div>
