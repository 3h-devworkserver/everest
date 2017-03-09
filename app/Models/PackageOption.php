<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageOption extends Model
{


     protected $table = 'package_option';
     protected $fillable = ['name','content','designation', 'type', 'package_id','type_name',
      						];

public function package(){
	return $this->belongsTo('App\Models\Packages');
}

}
