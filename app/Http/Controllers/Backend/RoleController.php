<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class RoleController extends Controller
{
    public function AllPermission(){
        $permissions = Permission::all();
        return view('admin.backend.pages.permission.all_permission',compact('permissions')); 
    }
    // End Method 

     public function AddPermission(){ 
        return view('admin.backend.pages.permission.add_permission'); 
    }
    // End Method 

    public function StorePermission(Request $request){

        Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        $notification = array(
            'message' => 'Permission Inserted Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->route('all.permission')->with($notification); 
    }
     // End Method 

     public function EditPermission($id){
        $permissions = Permission::find($id);
        return view('admin.backend.pages.permission.edit_permission',compact('permissions'));

     }
     // End Method 

     public function UpdatePermission(Request $request){
        $per_id = $request->id;

        Permission::find($per_id)->update([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        $notification = array(
            'message' => 'Permission Updated Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->route('all.permission')->with($notification); 
    }
     // End Method 

    public function DeletePermission($id){
        Permission::find($id)->delete();

        $notification = array(
            'message' => 'Permission Deleted Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->back()->with($notification); 

    }
    // End Method

    public function AllRoles(){
        try {
            $roles = Role::all();
            return view('admin.backend.pages.role.all_role', compact('roles'));

        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => 'Something went wrong while fetching roles!',
                'alert-type' => 'error'
            ]);
        }
    }
    // End Method 


    public function AddRoles(){ 
        try {
            return view('admin.backend.pages.role.add_role'); 

        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => 'Unable to load add role page!',
                'alert-type' => 'error'
            ]);
        }
    }
    // End Method 


    public function StoreRoles(Request $request){
        try {

            // Validation
            $request->validate([
                'name' => 'required|unique:roles,name|max:255'
            ]);

            Role::create([
                'name' => $request->name, 
            ]);

            return redirect()->route('all.roles')->with([
                'message' => 'Role Inserted Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with([
                'message' => 'Failed to insert role!',
                'alert-type' => 'error'
            ]);
        }
    }
    // End Method  


    public function EditRoles($id){
        try {

            $roles = Role::findOrFail($id);
            return view('admin.backend.pages.role.edit_role', compact('roles'));

        } catch (\Exception $e) {
            return redirect()->route('all.roles')->with([
                'message' => 'Role not found!',
                'alert-type' => 'error'
            ]);
        }
    }
    // End Method 


    public function UpdateRoles(Request $request){
        try {

            $request->validate([
                'name' => 'required|max:255|unique:roles,name,' . $request->id
            ]);

            $role = Role::findOrFail($request->id);

            $role->update([
                'name' => $request->name, 
            ]);

            return redirect()->route('all.roles')->with([
                'message' => 'Role Updated Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with([
                'message' => 'Failed to update role!',
                'alert-type' => 'error'
            ]);
        }
    }
    // End Method 


    public function DeleteRoles($id){
        try {

            $role = Role::findOrFail($id);
            $role->delete();

            return redirect()->back()->with([
                'message' => 'Role Deleted Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => 'Failed to delete role!',
                'alert-type' => 'error'
            ]);
        }
    }
    // End Method


    ///////////////// Add Role Permission All Methods /////////

    public function AddRolesPermission(){
        try {
            $roles = Role::all();
            $permissions = Permission::all();
            $permission_groups = User::getpermissionGroups();

            return view('admin.backend.pages.rolesetup.add_roles_permission',
                compact('roles','permissions','permission_groups'));

        } catch (\Exception $e) {
            dd($e);
            Log::error('AddRolesPermission Error: '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }
    // End Method


    public function RolePermissionStore(Request $request){
        try {
            $request->validate([
                'role_id' => 'required|exists:roles,id',
                'permission' => 'required|array'
            ]);

            DB::beginTransaction();

            foreach ($request->permission as $permissionId) {
                DB::table('role_has_permissions')->insert([
                    'role_id' => $request->role_id,
                    'permission_id' => $permissionId,
                ]);
            }

            DB::commit();

            return redirect()->route('all.roles.permission')->with([
                'message' => 'Role Permission Added Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('RolePermissionStore Error: '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'Failed to add role permissions!',
                'alert-type' => 'error'
            ]);
        }
    }
    // End Method


    public function AllRolesPermission(){
        try {
            $roles = Role::all();

            return view('admin.backend.pages.rolesetup.all_roles_permission', compact('roles'));

        } catch (\Exception $e) {
            Log::error('AllRolesPermission Error: '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'Unable to fetch roles!',
                'alert-type' => 'error'
            ]);
        }
    }
    // End Method


    public function AdminEditRoles($id){
        try {
            $role = Role::findOrFail($id);
            $permissions = Permission::all();
            $permission_groups = User::getpermissionGroups();

            return view('admin.backend.pages.rolesetup.edit_roles_permission',
                compact('role','permissions','permission_groups'));

        } catch (\Exception $e) {
            Log::error('AdminEditRoles Error: '.$e->getMessage());

            return redirect()->route('all.roles.permission')->with([
                'message' => 'Role not found!',
                'alert-type' => 'error'
            ]);
        }
    }
    // End Method


    public function AdminRolesUpdate(Request $request, $id){
        try {
            $role = Role::findOrFail($id);
            $permissions = $request->permission;

            if (!empty($permissions)) {
                $permissionNames = Permission::whereIn('id', $permissions)
                    ->pluck('name')
                    ->toArray();

                $role->syncPermissions($permissionNames);
            } else {
                $role->syncPermissions([]);
            }

            return redirect()->route('all.roles.permission')->with([
                'message' => 'Role Permission Updated Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {
            Log::error('AdminRolesUpdate Error: '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'Failed to update role permissions!',
                'alert-type' => 'error'
            ]);
        }
    }
    // End Method


    public function AdminDeleteRoles($id){
        try {
            $role = Role::findOrFail($id);
            $role->delete();

            return redirect()->back()->with([
                'message' => 'Role Permission Deleted Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {
            Log::error('AdminDeleteRoles Error: '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'Failed to delete role!',
                'alert-type' => 'error'
            ]);
        }
    }
    // End Method
}