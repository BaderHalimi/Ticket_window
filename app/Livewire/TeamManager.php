<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\role_permission as RoleUserAssignment;
use Illuminate\Support\Facades\Auth;
class TeamManager extends Component
{
    public $users;
    public $usersWithRoles;
    public $roles;
    public $permissions;

    public $newRoleName;
    public $newRolePermissionIds = [];
    public $activeTab = 'roles';

    public $selectedUserId;
    public $selectedRoleId;

    // للتاجر الحالي
    public $merchantId;

    // لدعم Accordion & Edit
    public $roleAccordionOpen = null;
    public $editingRoleId = null;
    public $editRoleName;
    public $editRolePermissionIds = [];

    public $UserEmail;
    public $UserPassword;
    public $UserFname, $UserLname;
    public $UserId = null;


    public function mount()
    {
        $this->merchantId = auth()->id();
        $this->loadData();
    }

    public function loadData()
    {
        $assignments = RoleUserAssignment::where('merchant_id', $this->merchantId)
        ->with(['employee', 'role'])
        ->get();

    $this->usersWithRoles = $assignments
        ->groupBy('employee_id')
        ->map(function ($group) {
            return [
                'employee' => $group->first()->employee,
                'roles'    => $group->pluck('role'),
            ];
        })->values();
            //dd($this->usersWithRoles);

            $this->users = User::whereNotNull('additional_data')
            ->whereJsonContains('additional_data->workIn', Auth::id())->get();
                    //dd($this->users);
            // $this->users = User::whereNotNull('additional_data')->get()
            // ->filter(function ($user) {
            //     return !empty($user->additional_data['workIn'])
            //         && in_array(Auth::id(), $user->additional_data['workIn']);
            // });
        
            //dd($this->users);        
        $this->roles = Role::all();
        $this->permissions = Permission::all();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetAccordion();
    }

    public function resetAccordion()
    {
        $this->roleAccordionOpen = null;
        $this->editingRoleId = null;
        $this->editRoleName = '';
        $this->editRolePermissionIds = [];
    }

    public function toggleRoleAccordion($roleId)
    {
        $this->roleAccordionOpen = $this->roleAccordionOpen === $roleId ? null : $roleId;
        $this->editingRoleId = null;
    }

    public function startEditingRole($roleId)
    {
        $this->editingRoleId = $roleId;
        $role = Role::findOrFail($roleId);
        $this->editRoleName = $role->name;

        $additional = is_array($role->additional_data)
            ? $role->additional_data
            : json_decode($role->additional_data, true);

        $this->editRolePermissionIds = $additional['permissions'] ?? [];
    }

    public function updateRole()
    {
        $role = Role::findOrFail($this->editingRoleId);
        $role->name = $this->editRoleName;

        $additional = is_array($role->additional_data)
            ? $role->additional_data
            : json_decode($role->additional_data, true);

        $additional['permissions'] = $this->editRolePermissionIds;
        $role->additional_data = json_encode($additional);
        $role->save();

        session()->flash('success', '✅ تم تحديث الرول بنجاح!');
        $this->resetAccordion();
        $this->loadData();
    }
    public function editUser($userId){
        $user = User::find($userId);
        $this->UserId = $user->id;

        $this->UserEmail = $user->email;
        $this->UserPassword = '';
        $this->UserFname = $user->f_name;
        $this->UserLname = $user->l_name;
        //fetch_Permetions($userId);
        //dd(has_Permetion($userId, 'overview_page'));
        //$this->adduser($userId);
    }
    public function canceledit(){
        $this->UserId = null;
        $this->UserEmail = '';
        $this->UserPassword = '';
        $this->UserFname = '';
        $this->UserLname = '';
    }
    public function deleteUser()
    {
        if ($this->UserId) {
            $user = User::find($this->UserId);
            if ($user) {
                $data = $user->additional_data ?? [];
    
                $workIn = $data['workIn'] ?? [];
                $role = RoleUserAssignment::where('merchant_id', $this->merchantId)
                    ->where('employee_id', $user->id)
                    ->delete();
    
                $workIn = array_filter($workIn, function ($id) {
                    return $id != Auth::id();
                });
    
                $data['workIn'] = array_values($workIn); 
                $user->additional_data = $data;
                $user->save();
                //dd($user->additional_data);
    
                session()->flash('success', '🗑️ تم إزالة العامل من فريقك بنجاح!');
                $this->loadData();
            } else {
                session()->flash('error', '❗ المستخدم غير موجود!');
            }
        } else {
            session()->flash('error', '❗ لا يوجد مستخدم لتعديله!');
        }
        $this->canceledit();
    }
    
    Public function adduser()
    {
        if ($this->UserId) {
            $user = User::find($this->UserId);

        } else {
            $user = new User();
            //$user->password = bcrypt($this->UserPassword);
        }
        $user->email = $this->UserEmail;
        $user->password = bcrypt($this->UserPassword);
        $user->f_name = $this->UserFname;
        $user->l_name = $this->UserLname;

        $user->additional_data = [
            'workIn' => [Auth::id()],
        ];
        $user->save();
        $this->canceledit();

        session()->flash('success', '✅ تم إضافة المستخدم بنجاح!');
        $this->loadData();
    }
    public function createRole()
    {
        $role = new Role();
        $role->name = $this->newRoleName;
        $role->additional_data = json_encode([
            'permissions' => $this->newRolePermissionIds
        ]);
        $role->save();

        session()->flash('success', '✅ تم إنشاء الرول بنجاح!');
        $this->newRoleName = '';
        $this->newRolePermissionIds = [];

        $this->loadData();
    }

    public function deleteRole($roleId)
    {
        $role = Role::findOrFail($roleId);
        $role->delete();

        session()->flash('success', '🗑️ تم حذف الرول بنجاح!');
        $this->resetAccordion();
        $this->loadData();
    }
    public function removeRoleFromEmployee($employeeId, $roleId)
    {
        RoleUserAssignment::where('merchant_id', $this->merchantId)
            ->where('employee_id', $employeeId)
            ->where('role_id', $roleId)
            ->delete();
    
        session()->flash('success', '✅ تم حذف الرول من الموظف بنجاح!');
        $this->loadData();
    }
    
    public function assignWorkerToMerchant()
    {
        if (!$this->selectedUserId || !$this->selectedRoleId) {
            session()->flash('error', '❗ اختر العامل والرول أولًا!');
            return;
        }
    
        // Check if already exists
        $exists = RoleUserAssignment::where('merchant_id', $this->merchantId)
            ->where('employee_id', $this->selectedUserId)
            ->where('role_id', $this->selectedRoleId)
            ->exists();
    
        if (!$exists) {
            RoleUserAssignment::create([
                'merchant_id' => $this->merchantId,
                'employee_id'     => $this->selectedUserId,
                'role_id'     => $this->selectedRoleId,
            ]);
        }
    
        session()->flash('success', '✅ تم ربط العامل بالرول بنجاح!');
        $this->selectedUserId = '';
        $this->selectedRoleId = '';
    
        $this->loadData();
    }
    

    public function render()
    {
        return view('livewire.team-manager');
    }
}
