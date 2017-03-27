<?php namespace App\Models\Access\User\Traits\Relationship;

use App\Models\Access\User\UserProvider;
use App\Models\Profile;
use App\Models\Guide;
use App\Models\Gallery;
use App\Models\Review;
use App\Models\Availability;
use App\Models\Booking;
/**
 * Class UserRelationship
 * @package App\Models\Access\User\Traits\Relationship
 */
trait UserRelationship {

    /**
     * Many-to-Many relations with Role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(config('access.role'), config('access.assigned_roles_table'), 'user_id', 'role_id');
    }

    /**
     * Many-to-Many relations with Permission.
     * ONLY GETS PERMISSIONS ARE NOT ASSOCIATED WITH A ROLE
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(config('access.permission'), config('access.permission_user_table'), 'user_id', 'permission_id');
    }

    public function profile(){
        return $this->hasOne(Profile::class,'user_id','id');
    }

    public function userBookings(){
        return $this->hasMany(Booking::class,'user_id', 'id')->where('status', 'paid');
    }

    public function userPackageBookings(){
        return $this->hasMany(Booking::class,'user_id','id')->where('type', 'package')->where('status', 'paid');
    }
    public function userPackageBookingsLimit(){
        return $this->hasMany(Booking::class,'user_id','id')->where('type', 'package')->where('status', 'paid')->limit(3);
    }

    public function userFlightBookingsLimit(){
        return $this->hasMany(Booking::class,'user_id','id')->where('type', 'flight')->where('status', 'paid')->limit(3);
    }



//commented , not used --yojan
    // /**
    //  * @return mixed
    //  */
    // public function providers() {
    //     return $this->hasMany(UserProvider::class);
    // }

    // public function profile(){
    //     return $this->hasOne(Profile::class,'user_id','id');
    // }

    // public function guide(){
    //     return $this->hasOne(Guide::class);
    // }

    // public function reviews() {
    //     return $this->hasMany(Review::class,'user_id','id');
    // }

    // public function availibility() {
    //     return $this->hasMany(Availability::class,'user_id','id');
    // }

    // public function gallery() {
    //     return $this->hasMany(Gallery::class,'user_id','id');
    // }
   
    
}