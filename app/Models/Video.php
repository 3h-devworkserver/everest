<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model {

    protected $table = 'p_videos';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    protected $fillable = ['user_id', 'video'];

    public function user() {
        return $this->belongsTo('App\Models\Access\User\User');
    }

    public static function getAllVideos() {
        
        $videos = self::select('users.username', 'p_videos.video', 'p_videos.id', 'p_videos.pages_id', 'p_videos.created_at')
                ->leftjoin('users', 'p_videos.user_id', '=', 'users.id')
                ->get();
        
        return $videos;
    }

}
