<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-8">Merchant Admin Panel</h1>

    {{-- Tabs Navigation --}}
    <div class="flex border-b mb-6">
        <button
            wire:click="setActiveTab('roles')"
            class="px-4 py-2 text-sm font-medium border-b-2 transition-colors duration-200 flex items-center gap-2"
            @class([
                'border-blue-500 text-blue-500' => $activeTab === 'roles',
                'border-transparent text-gray-500 hover:text-blue-500' => $activeTab !== 'roles',
            ])
        >
            <i class="ri-shield-line"></i>
            إدارة الرولات والصلاحيات
        </button>

        <button
            wire:click="setActiveTab('workers')"
            class="px-4 py-2 text-sm font-medium border-b-2 transition-colors duration-200 ml-4 flex items-center gap-2"
            @class([
                'border-blue-500 text-blue-500' => $activeTab === 'workers',
                'border-transparent text-gray-500 hover:text-blue-500' => $activeTab !== 'workers',
            ])
        >
            <i class="ri-team-line"></i>
            إدارة العمال
        </button>
    </div>

    {{-- Section 1: Roles --}}
    @if ($activeTab === 'roles')
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
            <i class="ri-shield-line"></i> إضافة رول جديد مع صلاحياته
        </h2>

        @if (session()->has('success'))
            <div class="mb-4 text-green-600 font-medium flex items-center gap-2">
                <i class="ri-checkbox-circle-line"></i> {{ session('success') }}
            </div>
        @endif

        {{-- Add New Role Form --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">اسم الرول</label>
            <input type="text" wire:model="newRoleName" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">الصلاحيات</label>
            <select wire:model="newRolePermissionIds" multiple class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                @foreach($permissions as $permission)
                    <option value="{{ $permission->id }}">{{ $permission->key }}</option>
                @endforeach
            </select>
            <small class="text-gray-500">امسك Ctrl/Cmd لاختيار أكثر من صلاحية</small>
        </div>

        <button wire:click="createRole" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition flex items-center gap-2">
            <i class="ri-add-line"></i> إضافة الرول
        </button>

        <hr class="my-6">

        <h3 class="text-lg font-semibold mb-3">قائمة الرولات الحالية وصلاحياتها</h3>

        <div class="space-y-4">
            @foreach($roles as $role)
            <div class="border rounded overflow-hidden shadow">
                <div
                    class="flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-gray-100 transition cursor-pointer"
                    wire:click="toggleRoleAccordion({{ $role->id }})"
                >
                    <div class="flex items-center gap-2">
                        <i class="ri-shield-line"></i>
                        <span class="font-medium">{{ $role->name }}</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <button
                            type="button"
                            wire:click.stop="startEditingRole({{ $role->id }})"
                            class="hover:text-blue-600"
                            title="تعديل"
                        >
                            <i class="ri-pencil-line"></i>
                        </button>

                        <button
                            type="button"
                            wire:click.stop="deleteRole({{ $role->id }})"
                            class="hover:text-red-600"
                            title="حذف"
                        >
                            <i class="ri-delete-bin-line"></i>
                        </button>

                        <span
                            class="transform transition-transform duration-300"
                            @class(['rotate-180' => $roleAccordionOpen === $role->id])
                        >
                            <i class="ri-arrow-down-s-line"></i>
                        </span>
                    </div>
                </div>

                @if ($roleAccordionOpen === $role->id)
                <div class="px-4 py-3 bg-white border-t">
                    @if ($editingRoleId === $role->id)
                        <div class="mb-3">
                            <label class="block text-sm font-medium mb-1">اسم الرول</label>
                            <input type="text" wire:model="editRoleName" class="w-full border rounded px-3 py-2">
                        </div>

                        <div class="mb-3">
                            <label class="block text-sm font-medium mb-1">الصلاحيات</label>
                            <select wire:model="editRolePermissionIds" multiple class="w-full border rounded px-3 py-2">
                                @foreach($permissions as $permission)
                                    <option value="{{ $permission->id }}">{{ $permission->key }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button
                            wire:click="updateRole"
                            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition flex items-center gap-2"
                        >
                            <i class="ri-save-line"></i> حفظ التعديلات
                        </button>
                    @else
                        @php
                            $add = json_decode($role->additional_data, true);
                            $permIds = $add['permissions'] ?? [];
                        @endphp

                        @if(count($permIds))
                            <ul class="list-disc list-inside text-sm text-gray-700 mt-2">
                                @foreach($permIds as $permId)
                                    @php
                                        $perm = $permissions->firstWhere('id', $permId);
                                    @endphp
                                    <li>{{ $perm ? $perm->key : 'Unknown Permission' }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500 text-sm mt-2">لا يوجد صلاحيات مرتبطة بهذا الرول</p>
                        @endif
                    @endif
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Section 2: Workers --}}
    @if ($activeTab === 'workers')
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
            <i class="ri-team-line"></i> إضافة عامل وربطه برول
        </h2>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">اضافة عامل</label>

            <input wire:model="UserEmail" type="email" placeholder="ايميل العامل" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
            <div class="flex gap-3 mt-3">
                <input wire:model="UserFname" type="text" placeholder="الاسم الاول" class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                <input wire:model="UserLname" type="text" placeholder="الاسم الثاني" class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
            </div>
            <input wire:model="UserPassword" type="password" placeholder="كلمة السر" class="w-full mt-3 border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">

            @if (!$UserId)
            <button wire:click="adduser" class="bg-blue-500 text-white px-4 py-2 mt-3 rounded hover:bg-blue-600 transition flex items-center gap-2">
                <i class="ri-add-line"></i> إضافة العامل
            </button>
            @endif
            @if ($UserId)
                <div class="flex flex-wrap gap-3 mt-3">

                    <button wire:click="adduser" class="bg-lime-500 text-white px-4 py-2 mt-3 rounded hover:bg-lime-600 transition flex items-center gap-2">
                        <i class="ri-pencil-line"></i> تعديل العامل
                    </button>
                    <button wire:click="canceledit" class="bg-red-200 text-white px-4 py-2 mt-3 rounded hover:bg-red-400 transition flex items-center gap-2">
                        <i class="ri-pencil-line"></i> الغاء التعديل
                    </button>
                    <button wire:click="deleteUser" class="bg-red-500 text-white px-4 py-2 mt-3 rounded hover:bg-red-600 transition flex items-center gap-2">
                        <i class="ri-pencil-line"></i> طرد العامل
                    </button>
                </div>
            @endif
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">اختر العامل</label>
            <select wire:model="selectedUserId" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                <option value="">-- اختر العامل --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->f_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">اختر الرول</label>
            <select wire:model="selectedRoleId" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                <option value="">-- اختر الرول --</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <button wire:click="assignWorkerToMerchant" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition flex items-center gap-2">
            <i class="ri-add-line"></i> إضافة العامل
        </button>

        <hr class="my-6">

        <h3 class="text-lg font-semibold mb-3">قائمة العمال المرتبطين بأدوار</h3>

        <div class="space-y-4">
            @foreach($usersWithRoles as $user)
                <div class="border rounded p-4">
                    <h4 class="font-bold flex items-center gap-2">
                        <i class="ri-user-line"></i> {{ $user['employee']->f_name }}
                        <button wire:click="editUser({{ $user['employee']->id }})" class="text-blue-500 text-sm hover:underline ml-2">
                            <i class="ri-pencil-line"></i> تعديل
                        </button>
                    </h4>
                    @if($user['roles']->count())
                        <ul class="list-disc list-inside text-sm text-gray-700 mt-2">
                            @foreach($user['roles'] as $role)
                            <li class="flex items-center justify-between">
                                <span>{{ $role->name }}</span>
                                <button wire:click="removeRoleFromEmployee({{ $user['employee']->id }}, {{ $role->id }})" class="text-red-500 text-sm hover:underline flex items-center gap-1">
                                    <i class="ri-delete-bin-line"></i> حذف
                                </button>
                            </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500 text-sm mt-2">❗ لا يوجد أدوار مرتبطة بهذا العامل</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
