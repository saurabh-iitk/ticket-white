<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class EventTicketList extends Model
{
    //use SoftDeletes;
    
    protected $table = "event_ticket_lists";
    protected $primaryKey = "id";
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*protected $fillable = [
        'event_ticket_id','ticket_type_id','total_ticket','base_price','total_discount','discounted_amount','final_price'
    ];*/

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event_ticket()
    {
        return $this->belongsTo('App\Models\EventTicket');
    }
    
}
