<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'promocode';
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    public $totalCount = 14;
 

}
