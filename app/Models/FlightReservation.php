<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlightReservation extends Model 
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'flight_reservations';
    
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function travellers()
    {
        return $this->hasMany('App\Models\TravellerInfo','booking_id');
    }



}