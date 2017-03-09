<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageGallery extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */


	protected $table = 'package_gallery';	
	protected $fillable = ['name', 'package_id','image','default', 'type',];





	// protected $table = 'block_image';	
	// protected $fillable = ['package_id','image','caption'];
}