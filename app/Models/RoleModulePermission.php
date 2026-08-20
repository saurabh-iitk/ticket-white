<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleModulePermission extends Model
{
    protected $table = "role_module_permissions";
    protected $primaryKey = "id";
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'module_id', 'permission_id', 'module_permission_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [ ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [ ];
    
    public function permission()
    {
        return $this->hasOne('App\Models\Permission','id','permission_id');
    }
    
    public function module()
    {
        return $this->hasOne('App\Models\Module','id','module_id');
    }
}
