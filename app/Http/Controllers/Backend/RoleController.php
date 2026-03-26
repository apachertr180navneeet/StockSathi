<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
}