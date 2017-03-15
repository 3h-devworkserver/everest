<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model 
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'profiles';
    
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];


    public function user()
    {
        return $this->belongsTo('App\Models\Access\User\User');
    }


}