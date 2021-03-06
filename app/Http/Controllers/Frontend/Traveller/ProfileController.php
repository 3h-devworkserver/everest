<?php namespace App\Http\Controllers\Frontend\Traveller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
use File;
use App\Models\Menu;
use App\Models\Booking;

/**
 * Class ProfileController
 * @package App\Http\Controllers\Frontend
 */
class ProfileController extends Controller {

	public function dashboard(){
		$user = Auth::user();
		// return $user->userPackageBookingsLimit;
		$menus = Menu::where('parent_id', 0)->orderby('order')->get();
		return view('frontend.traveller.dashboard', compact('user', 'menus'))
		->with('meta_title', 'Traveller Dashboard | Upeverest')
	    ->with('meta_keywords', 'Traveller Dashboard, Upeverest')
	    ->with('meta_desc', 'Traveller Dashboard, Upeverest')
		->with('class', 'home');
	}

	public function profile(){
		$user = Auth::user();
		$profile = Auth::user()->profile;
		$menus = Menu::where('parent_id', 0)->orderby('order')->get();

		return view('frontend.traveller.profile', compact('user', 'profile', 'menus'))
		->with('meta_title', 'Traveller Profile | Upeverest')
	    ->with('meta_keywords', 'Traveller Profile, Upeverest')
	    ->with('meta_desc', 'Traveller Profile, Upeverest')
		->with('class', 'home');
	}

	public function history(){
		$user = Auth::user();
		$menus = Menu::where('parent_id', 0)->orderby('order')->get();
		return view('frontend.traveller.history', compact('user', 'menus'))
		->with('meta_title', 'Traveller Purchase History | Upeverest')
	    ->with('meta_keywords', 'Traveller Purchase History, Upeverest')
	    ->with('meta_desc', 'Traveller Purchase History, Upeverest')
		->with('class', 'home');
	}

	public function updateProfile(Request $request){
		$this->validate($request, [
	        'fname' => 'required',
			'lname' => 'required',
			'email' => 'required|email|unique:users,email,'.Auth::user()->id,
			'dob_year' => 'required',
			'dob_month' => 'required',
			'dob_day' => 'required',
			'gender' => 'required',
			'phone' => 'required',
	    ]);

		$traveller = Auth::user();
		$profile = $traveller->profile();

		$traveller->update([
			'fname' => $request->fname,
			'mname' => $request->mname,
			'lname' => $request->lname,
			'email' => $request->email,
		]);

		$profile->update([
			'title' => $request->title,
			'fname' => $request->fname,
			'mname' => $request->mname,
			'lname' => $request->lname,
			'email' => $request->email,
			'gender' => $request->gender,
			'dob_year' => $request->dob_year,
			'dob_month' => $request->dob_month,
			'dob_day' => $request->dob_day,
			'address' => $request->address,
			'phone' => $request->phone,
		]);

			return redirect()->route('frontend.traveller.profile')->withFlashSuccess('Profile Updated Successfully');
	}

	public function updateProfileImage(Request $request){
		$this->validate($request, [
			'upload' => 'image|max:2000',
	    ]);
		if ($request->hasFile('upload')) {
	      $file = $request->file('upload');
	      $destination_path = 'images/user/profile';
	      $filename = time() . '-'.str_random(4) . $file->getClientOriginalName();
	      $file->move($destination_path, $filename);

	      if (!empty(Auth::user()->profile->profile_pic)) {
	      	$prevImg = Auth::user()->profile->profile_pic;
	      }

	      Auth::user()->profile->update([
	      	'profile_pic' => $filename,
	      ]);

	      if (!empty($prevImg)) {
		    if (File::exists($destination_path.'/'.$prevImg)) {
	            unlink($destination_path.'/'.$prevImg);
	        }
	      }

	    }else{
			return redirect()->route('frontend.traveller.profile')->withFlashWarning('No image was chosen');
	    }
		return redirect()->route('frontend.traveller.profile')->withFlashSuccess('Profile Updated Successfully');

	}

	public function changepassword(Request $request){
		$this->validate($request, [
			'old_password' => 'required|min:6',
      		'password' => 'required|confirmed|min:6',
	    ]);

	    // if(Auth::user()->password == $request->old_password){
		if (Hash::check($request->old_password, Auth::user()->password)){
	    	Auth::user()->update([
	    		'password' => Hash::make($request->password),
	    	]);
			return redirect()->route('frontend.traveller.profile')->withFlashSuccess('Password Updated Successfully');
	    }else{
			return redirect()->route('frontend.traveller.profile')->withFlashSuccess('Old Password does not match');
	    }
	}

	public function updatePassport(Request $request){
		$this->validate($request, [
			'document_type' => 'required',
			'document_no' => 'required',
			'issue_year' => 'required_if:document_type,passport',
			'issue_month' => 'required_if:document_type,passport',
			'issue_day' => 'required_if:document_type,passport',
			'exp_year' => 'required_if:document_type,passport',
			'exp_month' => 'required_if:document_type,passport',
			'exp_day' => 'required_if:document_type,passport',
	    ]);

	    if ($request->hasFile('passport_img')) {
	      $file = $request->file('passport_img');
	      $destination_path = 'images/user/document';
	      $filename = time() . '-'.str_random(4) . $file->getClientOriginalName();
	      $file->move($destination_path, $filename);

	      if (!empty(Auth::user()->profile->document_img)) {
	      	$prevImg = Auth::user()->profile->document_img;
	      }
	      if ($request->document_type == 'passport') {
	      	Auth::user()->profile->update([
	      	'document_type' => $request->document_type,
	      	'document_no' => $request->document_no,
	      	'document_img' => $filename,
	      	'issue_year' => $request->issue_year,
	      	'issue_month' => $request->issue_month,
	      	'issue_day' => $request->issue_day,
	      	'exp_year' => $request->exp_year,
	      	'exp_month' => $request->exp_month,
	      	'exp_day' => $request->exp_day,
	      	]);		
	      }else{
	      	Auth::user()->profile->update([
	      	'document_type' => $request->document_type,
	      	'document_no' => $request->document_no,
	      	'document_img' => $filename,
	      	'issue_year' => '',
	      	'issue_month' => '',
	      	'issue_day' => '',
	      	'exp_year' => '',
	      	'exp_month' => '',
	      	'exp_day' => '',
	      	]);	
	      }
	      
	      	if (!empty($prevImg)) {
			    if (File::exists($destination_path.'/'.$prevImg)) {
		            unlink($destination_path.'/'.$prevImg);
		        }
	      	}

	    }else{

	    	if ($request->document_type == 'passport') {
		    	Auth::user()->profile->update([
		      	'document_type' => $request->document_type,
		      	'document_no' => $request->document_no,
		      	'issue_year' => $request->issue_year,
		      	'issue_month' => $request->issue_month,
		      	'issue_day' => $request->issue_day,
		      	'exp_year' => $request->exp_year,
		      	'exp_month' => $request->exp_month,
		      	'exp_day' => $request->exp_day,
		      	]);
		    }else{
		    	Auth::user()->profile->update([
		      	'document_type' => $request->document_type,
		      	'document_no' => $request->document_no,
		      	'issue_year' => '',
		      	'issue_month' => '',
		      	'issue_day' => '',
		      	'exp_year' => '',
		      	'exp_month' => '',
		      	'exp_day' => '',
		      	]);
		    }
	    }
		return redirect()->route('frontend.traveller.profile')->withFlashSuccess('Document Information Updated Successfully');

	}

	public function purchaseDetail($id){
		$booking = Booking::findOrFail($id);
		if ($booking->user_id != Auth::user()->id) {
			abort(404);
		}

		if ($booking->type == 'package') {
			$package = $booking->packageBooking->package;
			$dPrice = $booking->packageBooking->datePrice;
			$packageBooking = $booking->packageBooking;
			$mainTraveller = $packageBooking->mainTraveller;
			return view('frontend.traveller.packagedetail', compact('package', 'dPrice', 'packageBooking', 'mainTraveller'))
			->with('meta_title', 'Booking Detail| Upeverest')
		    ->with('meta_keywords', 'Booking Detail, Upeverest')
		    ->with('meta_desc', 'Booking Detail, Upeverest')
			->with('class', 'home');
		}else{
			if ($booking->flightReservation->return_type == 'R') {
				$flightDetail = json_decode($booking->flightReservation->flight_detail);
				$returnFlightDetail = json_decode($booking->flightReservation->returnflight_detail);
			}else{
				$flightDetail = json_decode($booking->flightReservation->flight_detail);
				$returnFlightDetail = '';
			}
			return view('frontend.traveller.flightdetail', compact('flightDetail', 'returnFlightDetail'))
			->with('meta_title', 'Booking Detail| Upeverest')
		    ->with('meta_keywords', 'Booking Detail, Upeverest')
		    ->with('meta_desc', 'Booking Detail, Upeverest')
			->with('class', 'home');
		}
	}
	
}