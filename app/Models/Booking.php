<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model 
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bookings';
    
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function flightReservation()
    {
        return $this->hasOne('App\Models\FlightReservation','booking_id');
    }

    public function packageBooking()
    {
        return $this->hasOne('App\Models\PackageBooking','booking_id');
    }

}