<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use SoftDeletes;
    
    protected $table = "bookings";
    protected $primaryKey = "id";
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*protected $fillable = [
        'event_id','venue_id'
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
    public function booking_details()
    {
        return $this->hasMany('App\Models\BookingDetail');
    }

    public function booking_payments()
    {
        return $this->hasMany('App\Models\BookingPayment');
    }
    
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    
    
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    
    public function paymentTransaction()
    {
        return $this->hasOne(PaymentTransaction::class, 'booking_id');
    }


}
