<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\role_permission as RoleUserAssignment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
    protected $rules = [
        'UserFname' => 'required|string|min:2',
        'UserLname' => 'required|string|min:2',
        'UserEmail'  => 'required|email|unique:users,email',
        'UserPassword' => 'required|min:6',
    ];
    public $Amerchantid,$finalID;
    public function mount($merchantid = null , $finalID)
    {
        $this->Amerchantid = $merchantid;
        $this->finalID = $finalID;
        //dd($this->finalID);
        $this->merchantId = $finalID;
        $this->loadData();
    }

    public function loadData()
    {
        $assignments = RoleUserAssignment::where('merchant_id', $this->merchantId)
        ->with(['employee', 'role'])
        ->get();

    $this->usersWithRoles = $assignments
        //->reject(fn ($item) => $item->employee_id === Auth::id())
        ->groupBy('employee_id')
        ->map(function ($group) {
            return [
                'employee' => $group->first()->employee,
                'roles'    => $group->pluck('role'),
            ];
        })->values();
        //dd($this->usersWithRoles);
            //dd($this->usersWithRoles);

            $this->users = User::whereNotNull('additional_data')
            ->whereJsonContains('additional_data->workIn', $this->finalID)->get();
                    //dd($this->users);
            // $this->users = User::whereNotNull('additional_data')->get()
            // ->filter(function ($user) {
            //     return !empty($user->additional_data['workIn'])
            // });

            //dd($this->users);
        //$this->roles = Role::all();
        $this->roles = Role::where("created_by", $this->finalID)->get();
        //dd(Role::all());
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
        if(!can_enter( $this->Amerchantid, 'role_edit')){
            return;
        }
        $this->toggleRoleAccordion($roleId);
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
        if(!can_enter($this->Amerchantid, 'role_edit' )){
            return;
        }
        $role = Role::findOrFail($this->editingRoleId);
        $role->name = $this->editRoleName;

        $additional = is_array($role->additional_data)
            ? $role->additional_data
            : json_decode($role->additional_data, true);

        $additional['permissions'] = $this->editRolePermissionIds;
        $role->additional_data = json_encode($additional);
        $role->save();

    session()->flash('success', __('team.role_updated_successfully'));
        $this->resetAccordion();
        $this->loadData();
    }
    public function editUser($userId){
        if(!can_enter( $this->Amerchantid,'team_manager_edit' )){
            return;
        }
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
        if(!can_enter($this->Amerchantid ,'team_manager_kick')){
            return;
        }
        if ($this->UserId) {
            $user = User::find($this->UserId);
            if ($user) {
                $data = $user->additional_data ?? [];

                $workIn = $data['workIn'] ?? [];
                $role = RoleUserAssignment::where('merchant_id', $this->merchantId)
                    ->where('employee_id', $user->id)
                    ->delete();

                $workIn = array_filter($workIn, function ($id) {
                    return $id != $this->finalID;
                });

                $data['workIn'] = array_values($workIn);
                $user->additional_data = $data;
                $user->save();
                //dd($user->additional_data);

                session()->flash('success', __('team.user_removed_successfully'));
                $this->loadData();
            } else {
                session()->flash('error', __('team.user_not_found'));
            }
        } else {
            session()->flash('error', __('team.no_user_to_edit'));
        }
        $this->canceledit();
    }

    Public function adduser()
    {
        if(!can_enter($this->Amerchantid , 'team_manager_create')){
            return;
        }
        if ($this->UserId) {
            $user = User::find($this->UserId);

        } else {
            $user = new User();
            //$user->password = bcrypt($this->UserPassword);
        }
        $this->validate();
        $user->email = $this->UserEmail;
        $user->password = Hash::make($this->UserPassword);
        $user->f_name = $this->UserFname;
        $user->role = 'merchant';
        //$user->status = 'active';
        $user->l_name = $this->UserLname;

        $user->additional_data = [
            'workIn' => [$this->finalID],
        ];
        $user->save();
        $this->canceledit();

    session()->flash('success', __('team.user_added_successfully'));
        $this->loadData();
    }
    public function createRole()
    {
        if(!can_enter($this->Amerchantid , 'role_create')){
            return;
        }
        // تحقق من اسم الرول
        if(empty($this->newRoleName) || !is_string($this->newRoleName)) {
            session()->flash('error', __('team.role_name_required'));
            return;
        }
        // Validate at least one permission
        if(empty($this->newRolePermissionIds) || count($this->newRolePermissionIds) < 1) {
            session()->flash('error', __('team.role_permission_required'));
            return;
        }
        $role = new Role();
        $role->name = $this->newRoleName;
        $role->created_by = $this->finalID;
        $role->additional_data = json_encode([
            'permissions' => $this->newRolePermissionIds
        ]);
        $role->save();

    session()->flash('success', __('team.role_created_successfully'));
        $this->newRoleName = '';
        $this->newRolePermissionIds = [];

        $this->loadData();
    }

    public function deleteRole($roleId)
    {
        if(!can_enter($this->Amerchantid , 'role_delete')){
            return;
        }

        $role = Role::findOrFail($roleId);
        $role->delete();

    session()->flash('success', __('team.role_deleted_successfully'));
        $this->resetAccordion();
        $this->loadData();
    }
    public function removeRoleFromEmployee($employeeId, $roleId)
    {
        if(!can_enter($this->Amerchantid , 'team_manager_edit')){
            return;
        }

        RoleUserAssignment::where('merchant_id', $this->merchantId)
            ->where('employee_id', $employeeId)
            ->where('role_id', $roleId)
            ->delete();

    session()->flash('success', __('team.role_removed_from_employee'));
        $this->loadData();
    }

    public function assignWorkerToMerchant()
    {
        if(!can_enter($this->Amerchantid , 'team_manager_edit')){
            return;
        }
        if (!$this->selectedUserId || !$this->selectedRoleId) {
            session()->flash('error', __('team.select_user_and_role_first'));
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

    session()->flash('success', __('team.role_assigned_to_employee'));
        $this->selectedUserId = '';
        $this->selectedRoleId = '';

        $this->loadData();
    }


    public function render()
    {
        return view('livewire.team-manager');
    }
}
