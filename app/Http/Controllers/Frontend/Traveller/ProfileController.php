<?php namespace App\Http\Controllers\Frontend\Traveller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;


/**
 * Class ProfileController
 * @package App\Http\Controllers\Frontend
 */
class ProfileController extends Controller {

	public function dashboard(){
		return view('frontend.traveller.dashboard')->with('class', 'home');
	}

	public function profile(){
		$user = Auth::user();
		$profile = Auth::user()->profile;

		return view('frontend.traveller.profile', compact('user', 'profile'))->with('class', 'home');
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

	      Auth::user()->profile->update([
	      	'profile_pic' => $filename,
	      ]);
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
	
}