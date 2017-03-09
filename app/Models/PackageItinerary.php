<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageItinerary extends Model
{


     protected $table = 'package_itinerary';
     protected $fillable = ['day_it','title_it','content_it', 'walk_it', 'package_id', 'order_it'
      						];


}