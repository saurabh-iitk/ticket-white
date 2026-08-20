<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = "modules";
    protected $primaryKey = "id";
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'display_name'
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
    
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower(preg_replace('/\s+/', '',$value));
    }
    
    public function permissions()
    {
        return $this->hasMany('App\Models\Permission','module_id','id');
    }
}