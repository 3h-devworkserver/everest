<?php namespace App\Http\Controllers\Frontend\Traveller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


/**
 * Class ProfileController
 * @package App\Http\Controllers\Frontend
 */
class ProfileController extends Controller {

	public function dashboard(){
		return view('frontend.traveller.dashboard')->with('class', 'home');
	}

	public function profile(){
		return view('frontend.traveller.profile')->with('class', 'home');
	}

	public function account(){
		return view('frontend.traveller.account')->with('class', 'home');
	}

	public function history(){
		return view('frontend.traveller.history')->with('class', 'home');
	}

	public function image(){
		return view('frontend.traveller.image')->with('class', 'home');
	}
	
}