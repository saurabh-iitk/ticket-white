<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class EventTicket extends Model
{
    //use SoftDeletes;
    
    protected $table = "event_tickets";
    protected $primaryKey = "id";
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id','event_schedule_id','event_show_time_id','layout_id'
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function event_ticket_lists()
    {
        return $this->hasMany('App\Models\EventTicketList');
    }
    
}
