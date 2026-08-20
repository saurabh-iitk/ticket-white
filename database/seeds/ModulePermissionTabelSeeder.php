<?php

use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\Permission;
use App\Models\RoleModulePermission;

class ModulePermissionTabelSeeder extends Seeder
{
    private $modules_with_permissions = [
        'user_Manage Users+1' => [
            'index' => 'List',
            'store' => 'Add',
            'update' => 'Update',
            'destroy' => 'Delete'
        ],
        'role_Manage Roles+1' => [
            'index' => 'List',
            'store' => 'Add',
            'update' => 'Update'
        ],
        'module_Manage Modules+1' => [
            'index' => 'List'
        ]
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->truncate();
        
        foreach($this->modules_with_permissions as $module => $permissions)
        {
            $module_data = explode('_',$module);
            $module_display_name = explode('+', $module_data[1]);
            $new_module = Module::create(['name' => $module_data[0], 'display_name' => $module_display_name[0]]);
            $module_visibility = explode(',', $module_display_name[1]);
            
            foreach ($permissions as $key => $permission)
            {   
                $permission_arr = [
                    'module_id' => $new_module->id,
                    'name' => $module_data[0].'_'.$key,
                    'display_name' => $permission
                ];
                
                Permission::create($permission_arr);
            }
        }
        
        $modules = DB::table('modules')->get();
        
        foreach ($modules as $module)
        {
            $permissions = DB::table('permissions')->where('module_id',$module->id)->get();

            foreach ($permissions as $permission)
            {
                $permissionarr = explode('_', $permission->name);
                
                RoleModulePermission::create([
                    'role_id' => 1,
                    'module_id' => $module->id,
                    'permission_id' => $permission->id,
                    'module_permission_name' => $module->name.'_'.$permissionarr[1]
                ]);
            }
        }
    }
}
