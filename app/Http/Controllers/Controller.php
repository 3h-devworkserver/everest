<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\ESewaIpn;
use App\Models\Promocode;
use View;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
abstract class Controller extends BaseController {

	use DispatchesJobs, ValidatesRequests;

	public function __construct(){
						$valentinesShow = 'true';
						// $obj = new ESewaIpn;
						// $esewa = ESewaIpn::select('refId')->distinct()->get(['refId']); 
						// // echo $obj->totalCount;
						// 	$count = count($esewa);
						$obj = new Promocode;
						// $esewa = Promocode::select('refId')->distinct()->get(['refId']); 
                        $esewa = Promocode::select('refId')->distinct()->where('refId', '!=', '')->get(['refId']); 
						
						// echo $obj->totalCount;
							$count = count($esewa);
						if ($count >= $obj->totalCount ) {
							$valentinesShow = 'false';
						}

    	View::share ( 'valentinesShow', $valentinesShow );
    }
}