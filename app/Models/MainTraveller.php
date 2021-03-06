<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class MainTraveller extends Model
{

 protected $table = 'main_travellers';
     // protected $fillable = ['title','user_id', 'group_id', 'fname','mname','lname', 'email', 'phone',
     // 						'dob_year', 'dob_month', 'dob_day', 'passport', 'nationality', 'passport_img',
     // 						'issue_year', 'issue_month', 'issue_day', 'issue_place', 'exp_year',
     // 						 'exp_month', 'exp_day','address', 'city','postal_zip', 'state',
     // 						 'country', 'em_fname', 'em_lname', 'em_phone', 'em_state', 'em_country', 
     // 						 'package_selected', 'dateprice_selected' , 'addon_selected','person_type', 'type',
     // 						 'issue_country', 'phone_type', 'em_phone_type', 'em_email', 
     //  						];

      	protected $guarded = ['id'];

      	public function profile(){
        	return $this->hasOne('App\Models\Profile', 'main_traveller_id');
    	}

    	public function otherTravellers(){
        	return $this->hasMany('App\Models\OtherTraveller', 'main_traveller_id');
    	}

    	public function user(){
        	return $this->belongsTo('App\Models\Access\User\User', 'user_id');
    	}



}