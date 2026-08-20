<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\Role;
use App\Models\Module;
use Illuminate\Support\Facades\Session;
use App\Models\Permission;
use App\Models\RoleModulePermission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        
        return view('auth.user.role.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.user.role.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Role::create([
            'name' => $request->name
        ]);
        
        return redirect('/role');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $roles = Role::with(['modules.permission', 'modules.module'])->where('id', $id)->get();
        $modulePermissions = [];
        $roleName = '';
        
        $roles->transform(function($role) use(&$modulePermissions, &$roleName)
        {
            $roleName = $role->name;
            
            $role->modules->map(function($module) use(&$modulePermissions) {
                if(!array_key_exists($module->module->display_name, $modulePermissions))
                {
                    $modulePermissions[$module->module->display_name] = [];
                }
                
                $modulePermissions[$module->module->display_name][] = $module->permission->display_name;
            });
        });
        
        $role = json_decode(json_encode([
            'name' => $roleName,
            'permissions' => $modulePermissions
        ]));
        
        //dd($role);
        return view('auth.user.role.show',compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = Role::with(['modules.permission', 'modules.module'])->where('id', $id)->get();
        $modulePermissions = [];
        $roleName = '';
        
        $roles->transform(function($role) use(&$modulePermissions, &$roleName)
        {
            $roleName = $role->name;
            
            $role->modules->map(function($module) use(&$modulePermissions) {
                $modulePermissions[] = $module->module_id.'_'.$module->permission_id;
            });
        });
        
        $role = json_decode(json_encode([
            'name' => $roleName,
            'id' => $id,
            'permissions' => $modulePermissions
        ]));
        
        $modulesWithPermissions = Module::with('permissions')->get();
        
        return view('auth.user.role.edit',compact('role', 'modulesWithPermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::where('id', $id)->first();
        
        $role->name = $request->name;
        $role->save();
        
        $modules_permissions = $request->modules_permissions;
        RoleModulePermission::where('role_id', $id)->delete();
        
        foreach ($modules_permissions as $module_permission)
        {
            $permission = explode('_', $module_permission);
            $module_permission_name = Permission::where('id', $permission[1])->first();
            
            RoleModulePermission::create([
                'role_id' => $id,
                'module_id' => $permission[0],
                'permission_id' => $permission[1],
                'module_permission_name' => $module_permission_name->name
            ]);
        }
        
        if(\Auth::user()->role_id === $role->id)
        {
            $roleModulePermission = RoleModulePermission::where('role_id', \Auth::user()->role_id)->pluck('module_permission_name');
        
            Session::put('permissions', $roleModulePermission);
        }
        
        return redirect('/role');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::where('id', $id)->delete();
        
        return redirect('/role');
    }
}
