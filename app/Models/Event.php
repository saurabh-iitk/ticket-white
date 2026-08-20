<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use SoftDeletes;
    
    protected $table = "events";
    protected $primaryKey = "id";
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'state_id','state', 'event_state', 'city_id','venue_id','sub_venue_id','organizer_id','event_title','event_description','start_date','end_date','event_banner','event_video','event_category','event_type','recurring_type','is_published','gst_name','gst_no','invoice_prefix'
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
    
}
