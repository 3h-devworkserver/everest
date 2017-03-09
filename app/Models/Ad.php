<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model {

    protected $table = 'page_ads';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    protected $fillable = ['user_id', 'ads', 'link'];

    public function user() {
        return $this->belongsTo('App\Models\Access\User\User');
    }

    public static function getAllAds() {
        $ads = self::select('users.username', 'page_ads.ads', 'page_ads.id', 'page_ads.pages_id', 'page_ads.created_at')
                ->leftjoin('users', 'page_ads.user_id', '=', 'users.id')
                ->get();

        return $ads;
    }

}
