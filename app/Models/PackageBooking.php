<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageBooking extends Model 
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'packages_bookings';
    
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

    public function mainTraveller()
    {
        return $this->hasOne('App\Models\MainTraveller','package_booking_id');
    }

    public function package()
    {
        return $this->belongsTo('App\Models\Packages','package_selected');
    }

    public function datePrice()
    {
        return $this->belongsTo('App\Models\PackageDatePrice','dateprice_selected');
    }

    

}