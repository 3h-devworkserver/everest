<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;


class InnerPage extends Model
{

 	use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
    ];

    protected $table = 'inner_pages';

    protected $fillable = ['title', 'slug', 'content', 'meta_key', 'meta_title', 'meta_desc'];
}
