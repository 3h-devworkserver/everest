<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PackageGallery;
class Packages extends Model
{


     protected $table = 'packages';
     protected $fillable = ['title','slug','description','duration', 'trek_period', 'trek_type',
     						'trek_st_end', 'altitude', 'warning', 'best_period', 'flight',
     						'status', 'feat_img', 'short_desc', 'long_desc', 'price', 'category',
     						'latitude', 'longitude','map_address', 'map_image', 'pack_type', 'addon_package', 'short_desc2' 
      						];

    public function itinerarys(){
    	return $this->hasMany('App\Models\PackageItinerary', 'package_id')->orderBy('order_it','asc');
    }
    public function datesPrices(){
      return $this->hasMany('App\Models\PackageDatePrice', 'package_id');
    }
    public function galleryRotators(){
        return $this->hasMany('App\Models\PackageGallery', 'package_id')->where('type', 'rotator');
    }
    public function galleryRotatorsDefault(){
        return $this->hasMany('App\Models\PackageGallery', 'package_id')->where('default', 1)->limit(1);
    }

    public function galleryLists(){
        return $this->hasMany('App\Models\PackageGallery', 'package_id')->where('type', 'list');
    }

    public function options(){
        return $this->hasMany('App\Models\PackageOption', 'package_id');
    }

    public function optionsAccomodation(){
        return $this->hasMany('App\Models\PackageOption', 'package_id')->where('type', 'accomodation');
    }
    public function optionsExpert(){
        return $this->hasMany('App\Models\PackageOption', 'package_id')->where('type', 'expert');
    }

    public function packageCategory(){
       return $this->belongsToMany('App\Models\PackageCategory',"package_pivot_category","package_id", "category_id");
    }
    // public function packageCategoryId(){
    //    return $this->belongsToMany('App\Models\PackageCategory',"package_pivot_category","package_id", "category_id")->value('id');
    // }


    //  protected $table = 'packages';
    // protected $fillable = ['title','content','short_desc', 'price', 'image','video'];
}
