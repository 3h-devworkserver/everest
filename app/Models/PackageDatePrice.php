<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageDatePrice extends Model
{


     protected $table = 'package_dateprice';
     protected $fillable = ['description', 'package_id', 'daterange', 'price', 'status', 'short_description',
      						];

     public function package(){
     	return $this->belongsTo('App\Models\Packages');
     }


}
