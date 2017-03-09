<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageCategory extends Model
{


     protected $table = 'package_category';
     protected $fillable = ['title','description',
      						];


     public function package(){
       return $this->belongsToMany('App\Models\Packages',"package_pivot_category", "category_id", "package_id")->where('status', 1);
     }

}
