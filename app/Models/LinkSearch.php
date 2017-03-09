<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkSearch extends Model {

    protected $table = 'linksearch';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    protected $fillable = ['user_id', 'keyword', 'url'];

    public function user() {
        return $this->belongsTo('App\Models\Access\User\User');
    }

    public static function getAllLinkSearch() {
        $linksearch = self::select('users.username', 'linksearch.id', 'linksearch.keyword', 'linksearch.url', 'linksearch.created_at')
                ->leftjoin('users', 'linksearch.user_id', '=', 'users.id')
                ->get();

        return $linksearch;
    }

}
