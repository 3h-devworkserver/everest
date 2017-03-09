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


    public function user()
    {
        return $this->belongsTo('App\Models\Access\User\User','user_id');
    }

    

}