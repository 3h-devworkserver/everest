<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Access\User\User;
use App\Models\Setting;
use App\Models\Page;
use App\Models\Menu;
use App\Models\InnerPage;
use App\Models\StaticBlock;
use App\Models\Summitteers;
use App\Models\Packages;
use App\Models\PackageGallery;
use App\Models\TravellerInfo;
use App\Models\Promocode;
use App\Models\ESewaIpn;
use App\Models\Contact;
use App\Models\PackageBooking;
use Session;
use App\Repositories\Frontend\User\UserContract;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use DB;
use Input;
use Illuminate\Http\Request;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Models\PackageDatePrice;
use App\Models\Booking;
use File;
use Hash;
use Mail;
use Validator;
use Auth;
use Image;

/**
 * Class PackageController
 * @package App\Http\Controllers
 */
class PackageController extends Controller {
    /**
     * @return \Illuminate\View\View
     */

    /**
     * @var UserContract
     */
    protected $users;

    public function __construct(UserContract $users) {
        $this->users = $users;
        parent::__construct();
    }

    public function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    // function for viewing detail of package
    public function packageDetail($slug){
        $esewa = Promocode::select('refId')->distinct()->where('refId', '!=', '')->get(['refId']); 
        $count = count($esewa);
        $menus = Menu::where('parent_id', 0)->orderby('order')->get();
        $package = Packages::where('slug',$slug)->first();
        if (empty($package)) {
            abort(404);
        }
        $page = InnerPage::where('slug', 'trekking')->first();
        $packageCategory =  $package->packageCategory;
        foreach($packageCategory as $category){
            if ($category->title == 'Valentine\'s Special'){
                return view('frontend.package.valentines', compact('count','package','page', 'menus', 'meta_title', 'meta_keywords', 'meta_desc'))->withClass($slug . '-page')
                ->with('meta_title', $package->title)
                ->with('meta_keywords', 'Valentine\'s Special Package Valentine\'s Offer')
                ->with('meta_desc', 'Valentine\'s Special Package for couple')
                ->with('title', $package->title);
            }
        }
        return view('frontend.package.classic-everest', compact('package','page', 'menus', 'meta_title', 'meta_keywords', 'meta_desc'))->withClass($slug . '-page')
        ->with('meta_title', $package->title)
        ->with('meta_keywords', $page->meta_key)
        ->with('meta_desc', $page->meta_desc)
        ->with('title', $package->title);
    }

// generates other gallery list image except first six
    public function generateMoreLists(Request $request){
        $id = $request->id;
        $package= Packages::findOrFail($id);
        $max= count($package->galleryLists);
        // $lists = PackageGallery::where('package_id', $package->id)->where('type', 'list')->skip(6)->take($max - 6)->get();
        $lists = PackageGallery::where('package_id', $package->id)->where('type', 'list')->skip(3)->take($max - 3)->get();
        return $lists->toArray();

    }

// for Valentines special packages
    public function valentinesBooking($slug, $datePrice){
        $obj = new Promocode;
        $esewa = Promocode::select('refId')->distinct()->where('refId', '!=', '')->get(['refId']); 

        $count = count($esewa);
        if ($count >= $obj->totalCount ) {
            abort(404);
        }

        $menus = Menu::where('parent_id', 0)->orderby('order')->get();
        $dPrice = PackageDatePrice::findOrFail($datePrice);
        // $page = InnerPage::where('slug', 'trekking')->first();
        $package = Packages::where('slug', $slug)->first();
        // return $dPrice->package->id;
        if ($dPrice->package->id != $package->id ) {
            abort(404);
        }
        $rand = $this->generateRandomString(4);

        $packages = Packages::where('id', '!=',  21)->where('status', 1)->get();

        return view('frontend.package.valentinesbooking', compact('rand','package','packages','datePrice','page', 'menus', 'slug', 'dPrice', 'count'))->withClass($slug . '-page')
        ->with('meta_title', $package->title)
        ->with('meta_keywords', 'Valentine\'s Special Package Valentine\'s Offer')
        ->with('meta_desc', 'Valentine\'s Special Package for couple')
        ->with('title', $package->title);
    }

// add extension package id in promocode table
    public function addExtPackage(Request $request){
        if(empty($request->promocode)){
            $data['stat'] = 'error';
            $data['msg'] = 'Empty Promocode';
            return $data;
        }
        $string = '';
        if(!empty($request->data)){
            $string = implode(",", $request->data);
        }
    // return $string;
        $promo = Promocode::where('promocode', $request->promocode)->first();
        if (empty($promo)) {
            $data['stat'] = 'error';
            $data['msg'] = 'Invalid Promocode';
            return $data;
        }
        $promo->update(['ext_package' => $string]);
        $data['stat'] = 'ok';
        $data['msg'] = 'Extension package updated';
        return $data;
    }

//valentine booking success
    
    public function valentinesBookingSuccess(Request $request, $slug, $datePrice, $promocode){
        if($request->q == 'su' && (!empty($request->oid)) && (!empty($request->amt)) && (!empty($request->refId)) ){

            $menus = Menu::where('parent_id', 0)->orderby('order')->get();
            $dPrice = PackageDatePrice::findOrFail($datePrice);
            $package = Packages::where('slug', $slug)->first();
            $itinerarys= $package->itinerarys;

            if ($dPrice->package->id != $package->id ) {
                abort(404);
            }
            $rand = $this->generateRandomString(4);

            $promo = Promocode::where('promocode', $promocode)->first();
            if (!empty($promo)) {
                $promo->update([
                    'oid'=>$request->oid,
                    'amt'=>$request->amt,
                    'refId'=>$request->refId,
                    ]);

                $promoRow = Promocode::where('promocode', $promocode)->first();

                $extension = '';

                if(!empty($promoRow->ext_package)){
                    $pack = explode(",",$promoRow->ext_package);
                    $i=0;
                    foreach($pack as $p){
                        $str = Packages::where('id', $p)->value('title');
                            // return $str;
                        if($i ==0){
                            $extension = $str;
                        }else{
                            $extension = $extension.', '.$str;
                        }
                        $i++;
                    }
                }
                

//added code for email
                $payment = $promoRow->toArray();
                $user = $promoRow;
                $setting = Setting::first();

 // send email to user
                Mail::send('frontend.promocode.successPaymentUser',['user' => $user, 'payment' =>$payment, 'dPrice'=>$dPrice, 'package'=>$package, 'extension'=>$extension, 'itinerarys'=>$itinerarys], function($message) use ($user) {
                   $message->from('noreply@upeverest.com', 'Up Everest')
                   ->to($user['email'], $user['fullname'])
                   ->subject('Your purchase details');
               });

// send email to admin
                Mail::send('frontend.promocode.sucessPaymentAdminNotIpn',['user' => $user, 'payment' =>$payment, 'dPrice'=>$dPrice, 'package'=>$package, 'extension'=>$extension, 'itinerarys'=>$itinerarys], function($message) use ($user) {
                   $message->from('noreply@upeverest.com', 'Up Everest')
                   ->to('sanjeev@avdigitals.com', 'Admin')
                   ->cc('rupen@appliedvalue.com.np', 'Admin')
                   ->bcc('yankey@upeverest.com', 'Admin')
                   ->subject('User has purchased package');
               });

//end of added code

                return view('frontend.package.valentinesbooking', compact('rand','package','datePrice','page', 'menus', 'slug', 'dPrice', 'promo', 'promoRow'))
                        // ->with('success', 'You have successfully purchased Package')
                ->with('success', '<p class="package_success_msg">Thanks for booking with us. Your reservation has been confirmed with the following details: <br><br>Airlines: Yeti Airlines <br>Hotel: Lakeside Retreat.<br><br>Your flight ticket with details will be sent to you within 12 working hrs. <br><br>Note: Incase you don\'t see mail in your inbox, plz check your spam folder.</p>')
                ->with('purchase', 'true')->withClass($slug . '-page')
                ->with('meta_title', $package->title)
                ->with('meta_keywords', 'Valentine\'s Special Package Valentine\'s Offer')
                ->with('meta_desc', 'Valentine\'s Special Package for couple')
                ->with('title', $package->title);
            }
        }else{
            abort(404);
        }
    }

//esewa ipn
    public function esewaIpn(Request $request){
        // return $request->all();
       $validator =  Validator::make($request->all(), [
        'refId' => 'required',
        'transactionDate' => 'required',
        'totalAmount' => 'required',
        'serviceCode' => 'required',
        'serviceName' => 'required',
        'productId' => 'required',
        'productDeliveryCharge' => 'required',
        'productServiceCharge' => 'required',
        'taxAmount' => 'required',
        ]);
       if ($validator->fails()) {
        abort(404);
    }else{

        $promocode =Promocode::where('refId', $request->refId)->first();
        if(empty($promocode)){
            abort(404);
        }

               //  return $promocode;

        $payment = ESewaIpn::create([
            'promocode_id'=>$promocode->id,
            'refId'=>$request->refId,
            'transactionDate'=>$request->transactionDate,
            'totalAmount'=>$request->totalAmount,
            'serviceCode'=>$request->serviceCode,
            'serviceName'=>$request->serviceName,
            'productId'=>$request->productId,
            'productDeliveryCharge'=>$request->productDeliveryCharge,
            'productServiceCharge'=>$request->productServiceCharge,
            'taxAmount'=>$request->taxAmount,
            ]);
        $payment = $payment->toArray();
        $user = $promocode;
        $setting = Setting::first();
                //if(!empty($setting)){
               //     $adminEmail = $setting->adminEmail;
              //  }
//  $package = Packages::findOrFail(21);
//return $package->datesPrices[0];


// // send email to user
//     Mail::send('frontend.promocode.successPaymentUser',['user' => $user], function($message) use ($user) {
//          $message->from('noreply@upeverest.com', 'Up Everest')
//             ->to($user['email'], $user['fullname'])
//             ->subject('Successfully purchased Package');
//         });

// // send email to admin
//     Mail::send('frontend.promocode.successPaymentAdmin',['user' => $user, 'payment'=> $payment], function($message) use ($user) {
//          $message->from('noreply@upeverest.com', 'Up Everest')
//            ->to('sanjeev@avdigitals.com', 'Admin')
//             ->cc('rupen@appliedvalue.com.np', 'Admin')
//             ->bcc('yankey@upeverest.com', 'Admin')
//             ->subject('User has purchased package');
//         });

    }
}

//update promocode table info
public function UpdatePromoCodeInfo(Request $request){
    if($request->ajax()){
        parse_str($_POST['data'], $promocodeInfo);

//update into db
        $promocode= Promocode::where('promocode', $promocodeInfo['promo_code'])->first();
        $update = $promocode->update([
            'fullname'=> $promocodeInfo['fullname'],
            'valentine_fullname'=> $promocodeInfo['valentine_fullname'],
            'contact'=> $promocodeInfo['contact'],
            'email'=> $promocodeInfo['email'],
            'promocode'=> $promocodeInfo['promo_code']
            ]);
        if (!empty($update)) {
            $data['stat']= 'ok';
            $data['msg']= 'Information updated successfully';
            return $data;
        }else{
            $data['stat']= 'error';
            $data['msg']= 'Updating of information failed';
            return $data;
        }

    }
}

//check promocode
public function checkPromoCode(Request $request){
   $data['stat'] = 'error';
   $data['msg'] = 'Unauthorized Access';
   if(!empty($request->promocode)){
                // return "here";
    $promo = Promocode::where('promocode', $request->promocode)->first();
    if(!empty($promo)){
        if (!empty($promo->refId)) {
            $data['stat'] = 'error';
            $data['msg'] = 'Promo Code already used';
            return $data;
        }
        if($request->promocode == $promo->promocode){
            $promo->ext_package = '';
            $promo->save();
            $data['stat'] = 'ok';
            $data['msg'] = 'Promo Code is valid';
            $data['row'] = $promo;
        }
    }else{
        $data['stat'] = 'error';
        $data['msg'] = 'Invalid Promo Code';
    }
}else{
    $data['stat'] = 'error';
    $data['msg'] = 'Please enter Promo Code';
}
return $data;
}

public function bookingStep1($slug, $datePrice){
    $menus = Menu::where('parent_id', 0)->orderby('order')->get();
    $dPrice = PackageDatePrice::findOrFail($datePrice);
    $page = InnerPage::where('slug', 'trekking')->first();
    $package = Packages::where('slug', $slug)->where('status', 1)->first();

    if ($dPrice->package->id != $package->id ) {
        abort(404);
    }
    // $addon = Packages::where('status', 1)->where('pack_type', 'addon')->get();
    if($package->addon_package){
        $addon = explode(',', $package->addon_package);
    }else{
        $addon = [];
    }
    return view('frontend.package.bookingstep1', compact('package','datePrice','page', 'menus', 'slug', 'dPrice', 'addon'))->withClass($slug . '-page')
    ->with('meta_title', 'Booking Step 1')
    ->with('meta_keywords', $page->meta_key)
    ->with('meta_desc', $page->meta_desc)
    ->with('title', 'Booking Step 1');
}

public function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

public function username($fname,$lname,$rand=null){
        $number = mt_rand(100, 999); // better than rand()
        $username = strtolower($fname).'-'.strtolower($lname).$rand;
        if ($this->usernameExists($username)) {
            return $this->username($fname,$lname,$number);
        }

        return $username;
    }
    public function usernameExists($username){
        return User::where('username', $username)->exists();        
    }
    private function validateRoleAmount($user, $roles) {
        //Validate that there's at least one role chosen, placing this here so
        //at lease the user can be updated first, if this fails the roles will be
        //kept the same as before the user was updated
        if (count($roles) == 0) {
            //Deactivate user
            $user->status = 0;
            $user->save();

            $exception = new UserNeedsRolesException();
            $exception->setValidationErrors('You must choose at lease one role. User has been created but deactivated.');

            //Grab the user id in the controller
            $exception->setUserID($user->id);
            throw $exception;
        }
    }

    public function bookingStep2($slug, $datePrice, Request $request){
        $datePriceRow = PackageDatePrice::findOrFail($datePrice);
        $packageId = $datePriceRow->package->id;
        if(Auth::guest()){
            $validator = Validator::make($request->all(), [       
                'password' => 'required|min:6|confirmed',
                ]);
            if ($validator->fails())
            {
                return redirect()->back()->with('invalid', "Error in password fields");
            }
        }

        $arry= $request->all();

//check for invalid no of travellers
        if (empty($request->adult)) {
            return redirect()->back()->with('invalid', "Invalid number of travellers");
        }

//check for valid email
        foreach($request->email as $mail){
            $email = $this->test_input($mail);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return redirect()->back()->with('invalid', "Invalid Email provided");
            }
        }

        if( in_array("", $request->title) ){
            $msg = "Title field required ";
            return redirect()->back()->with('invalid', $msg);
        }

        if( in_array("", $request->fname) ){
            $msg = "Firstname field required ";
            return redirect()->back()->with('invalid', $msg);
        }

        if( in_array("", $request->lname) ){
            $msg = "Lastname field required ";
            return redirect()->back()->with('invalid', $msg);
        }

        if( in_array("", $request->dob_year) ){
            $msg = "DOB field required ";
            return redirect()->back()->with('invalid', $msg);
        }
        if( in_array("", $request->dob_month) ){
            $msg = "DOB field required ";
            return redirect()->back()->with('invalid', $msg);
        }
        if( in_array("", $request->dob_day) ){
            $msg = "DOB field required ";
            return redirect()->back()->with('invalid', $msg);
        }

        if( in_array("", $request->passport) ){
            $msg = "Passport number field required ";
            return redirect()->back()->with('invalid', $msg);
        }

        if( in_array("", $request->issue_year) ){
            $msg = "Passport issue date field required ";
            return redirect()->back()->with('invalid', $msg);
        }
        if( in_array("", $request->issue_month) ){
            $msg = "Passport issue date field required ";
            return redirect()->back()->with('invalid', $msg);
        }
        if( in_array("", $request->issue_day) ){
            $msg = "Passport issue date field required ";
            return redirect()->back()->with('invalid', $msg);
        }

        if( in_array("", $request->exp_year) ){
            $msg = "Passport expiry date field required ";
            return redirect()->back()->with('invalid', $msg);
        }
        if( in_array("", $request->exp_month) ){
            $msg = "Passport expiry date field required ";
            return redirect()->back()->with('invalid', $msg);
        }
        if( in_array("", $request->exp_day) ){
            $msg = "Passport expiry date field required ";
            return redirect()->back()->with('invalid', $msg);
        }

        if( in_array("", $request->address) ){
            $msg = "Address field required ";
            return redirect()->back()->with('invalid', $msg);
        }

        if( in_array("", $request->city) ){
            $msg = "City field required ";
            return redirect()->back()->with('invalid', $msg);
        }

        if( in_array("", $request->postal_zip) ){
            $msg = "Postal/Zip Code field required ";
            return redirect()->back()->with('invalid', $msg);
        }

        if( in_array("", $request->country) ){
            $msg = "Country field required ";
            return redirect()->back()->with('invalid', $msg);
        }

        if( in_array("", $request->em_fname) ){
            $msg = "Emergency First Name field required ";
            return redirect()->back()->with('invalid', $msg);
        }
        if( in_array("", $request->em_lname) ){
            $msg = "Emergency Last Name field required ";
            return redirect()->back()->with('invalid', $msg);
        }

        if( in_array("", $request->em_phone) ){
            $msg = "Emergency Phone Number field required ";
            return redirect()->back()->with('invalid', $msg);
        }

        if( in_array("", $request->em_country) ){
            $msg = "Emergency person's Country field required ";
            return redirect()->back()->with('invalid', $msg);
        }

//end of validation

        //saving request array to variable to use it in next steps
        $data = $request;
        $request->session()->put('packageInfo', $request->except('image'));

        $count = count($request->fname);
        $time = time();
        $destination_path = 'images/packages-new/passport/tmp';
        $random = str_random(10)."-".$time;
        $filename = array();
         for ($i=0; $i < $count; $i++) { 
            $files = $request->file('image');
            $prevFiles = $request->prevImage;
            if(!empty($files)){
                if(!empty($files[$i])){
                    $filename[$i] = $time. '-' .str_random(4).'-' . $files[$i]->getClientOriginalName();
                    $files[$i]->move($destination_path, $filename[$i]);
                }else{
                    if(!empty($prevFiles)){
                        if(!empty($prevFiles[$i])){
                            $filename[$i] = $prevFiles[$i];
                        }else{
                            $filename[$i] = '';
                        }
                    }else{
                        $filename[$i] = '';
                    }
                }
            }else{
                $filename[$i] = '';
            }
        }
      $request->session()->put('filenames', $filename);

// //for sending email
// $traveller = array();
// $traveller['email']= $travellers[0]->email;
// if (!empty($travellers[0]->mname)) {
//     $traveller['name'] = $travellers[0]->fname.' '.$travellers[0]->mname.' '.$travellers[0]->lname;
// }else{
//     $traveller['name'] = $travellers[0]->fname.' '.$travellers[0]->lname;
// }
// $traveller['password'] = $pass;

// //send email to lead traveller
// Mail::send('backend.email.travellerregister.emailtemplate',['traveller' => $traveller], function($message) use ($traveller) {
//          $message->from('admin@upeverest.com', 'Up Everest')
//             ->to($traveller['email'], $traveller['name'])
//             ->subject('Registered Successfully in Up Everest');
//         });


$menus = Menu::where('parent_id', 0)->orderby('order')->get();
$page = InnerPage::where('slug', 'trekking')->first();
$package = Packages::where('slug', $slug)->first();
$dPrice = PackageDatePrice::findOrFail($datePrice);

if ($dPrice->package->id != $package->id ) {
    abort(404);
}

return view('frontend.package.bookingstep2', compact('data', 'filename', 'package','dPrice','datePrice', 'page', 'menus', 'slug'))->withClass($slug . '-page')
->with('meta_title', 'Booking Step 2')
->with('meta_keywords', $page->meta_key)
->with('meta_desc', $page->meta_desc)
->with('title', 'Booking Step 2')
->with('totalAmount', $request->total_amount)
->with('extensionText', $request->extensionText);
        
}

public function bookingStep1EditGET($slug, $datePrice, Request $request){
    $datas = $request->session()->get('packageInfo');
    // return $datas;
    $filenames = $request->session()->get('filenames');

    $menus = Menu::where('parent_id', 0)->orderby('order')->get();
    $dPrice = PackageDatePrice::findOrFail($datePrice);
    $page = InnerPage::where('slug', 'trekking')->first();
    $package = Packages::where('slug', $slug)->where('status', 1)->first();

    if ($dPrice->package->id != $package->id ) {
        abort(404);
    }
    if($package->addon_package){
        $addon = explode(',', $package->addon_package);
    }else{
        $addon = [];
    }
    return view('frontend.package.bookingstep1edit', compact('datas', 'filenames', 'package','datePrice','page', 'menus', 'slug', 'dPrice', 'addon'))->withClass($slug . '-page')
    ->with('meta_title', 'Booking Step 1')
    ->with('meta_keywords', $page->meta_key)
    ->with('meta_desc', $page->meta_desc)
    ->with('title', 'Booking Step 1');
}

public function bookingStep3($slug, $datePrice, Request $request){
 $this->validate($request, [
    'condition' => 'required',
    ]);
    $datePriceRow = PackageDatePrice::findOrFail($datePrice);
    $packageId = $datePriceRow->package->id;
    $datas = $request->session()->get('packageInfo');

    $datas= (object)$datas;

        $count = count($datas->fname);
        $time = time();
        $destination_path = 'images/packages-new/passport';
        $tmp_path = 'images/packages-new/passport/tmp';
        $random = str_random(10)."-".$time;

        $filenames = $request->session()->get('filenames');

        foreach($filenames as $filename){
            if(!empty($filename)){
                if(File::exists($tmp_path.'/'.$filename)){
                    $img = Image::make($tmp_path.'/'.$filename);
                    $img->save($destination_path.'/'.$filename);
                    if (File::exists($tmp_path.'/'.$filename)) {
                        unlink($tmp_path.'/'.$filename);
                    }

                }
            }
        }

    //insert lead traveller info in user table
    if (Auth::guest()) {
        $user = new User;
        $user->fname = $datas->fname[0];
        $user->mname = $datas->mname[0];
        $user->lname = $datas->lname[0];
        $user->username = $this->username($datas->fname[0], $datas->lname[0]);
        $user->email = $datas->email[0];
        $user->password = Hash::make($datas->password);
        // $user->gender = '';
        $user->status =  1;
        // $user->confirmation_code = md5(uniqid(mt_rand(), true));
        // $user->confirmed = isset($input['confirmed']) ? 1 : 0;
        $user->confirmed = 1 ;

        //insert data in users table as well as assigned_roles table
        if ($user->save()) {
            //User Created, Validate Roles
            $this->validateRoleAmount($user, 'Traveller');
            $role = \App\Models\Access\Role\Role::where('name', 'Traveller')->first();
            //Attach new roles
            $user->attachRole($role);
        }
    }

    for ($i=0; $i < $count; $i++) { 

        //getting userid
        if (Auth::check()) {
           $userId = Auth::user()->id;
        }else{
            $userId = $user->id;
        }

        //insert data in travller_info table
        if ($i == 0) {

            if (!empty($datas->addon_pack)) {
                $addon_pack = implode(',', $datas->addon_pack);
            }else{
                $addon_pack = '';
            }
            if (!empty($datas->addon_packages_detail)) {
                $addon_packages_detail = implode(',', $datas->addon_packages_detail);
            }else{
                $addon_packages_detail = '';
            }

            //storing booking information
            $booking = Booking::create([
                'group_id'=> $random,
                'user_id'=> $userId,
                // 'order_id'=> $this->generateRandomString(),
                'type'=> 'package',
                'status'=> 'unpaid',
            ]);

            $packageBooking = $booking->packageBooking()->create([
                "token"=> $this->generateRandomString(8),
                "order_id"=> $this->generateRandomString(8),
                "total_person" => $count,
                "package_selected" => $packageId,
                "dateprice_selected" => $datePrice,
                "addon_selected" => $addon_pack,
                "main_package_amount" => $datas->main_package_amount,
                "total_amount" => $datas->total_amount,
                "addon_packages_detail" => $addon_packages_detail,
            ]); 

            $mainTraveller = $packageBooking->mainTraveller()->create([
                "user_id" => $userId,
                "type" => 'package',
                "person_type" => 'lead',
            ]);

            //changing user_id to null for logged in user for storing in profile table
            // as profile table will already have logged in user's profile(ie. to avoid 1:m relation)
            if (Auth::check()) {
               $userId = '';
            }

            $mainTraveller->profile()->create([
                "user_id" => $userId,
                "title" => $datas->title[$i],
                "fname" => $datas->fname[$i],
                "mname" => $datas->mname[$i],
                "lname" => $datas->lname[$i],
                "phone" => $datas->phone[$i],  
                "dob_year" => $request->dob_year[$i],
                "dob_month" => $request->dob_month[$i],
                "dob_day" => $request->dob_day[$i],
                "email" => $datas->email[$i],  
                "document_type" => 'passport',
                "document_no" => $datas->passport[$i],
                "nationality" => $datas->nationality[$i],  
                "issue_year" => $datas->issue_year[$i],
                "issue_month" => $datas->issue_month[$i],
                "issue_day" => $datas->issue_day[$i],
                "issue_place" => $datas->issue_place[$i],
                "document_img" => $filenames[$i],
                "exp_year" => $datas->exp_year[$i],
                "exp_month" => $datas->exp_month[$i],
                "exp_day" => $datas->exp_day[$i],
                "address" => $datas->address[$i],
                "city" => $datas->city[$i],
                "postal_zip" => $datas->postal_zip[$i],
                "state" => $datas->state[$i],
                "country" => $datas->country[$i],
                "em_fname" => $datas->em_fname[$i],
                "em_lname" => $datas->em_lname[$i],
                "em_phone" => $datas->em_phone[$i],
                "em_state" => $datas->em_state[$i],
                "em_country" => $datas->em_country[$i],
            ]);

        }else{

            $otherTravellers[$i] = $mainTraveller->otherTravellers()->create([
                "person_type" => 'other',
            ]);

            $otherTravellers[$i]->profile()->create([
                "title" => $datas->title[$i],
                "fname" => $datas->fname[$i],
                "mname" => $datas->mname[$i],
                "lname" => $datas->lname[$i],
                "phone" => $datas->phone[$i],  
                "dob_year" => $request->dob_year[$i],
                "dob_month" => $request->dob_month[$i],
                "dob_day" => $request->dob_day[$i],
                "email" => $datas->email[$i],  
                "document_type" => 'passport',
                "document_no" => $datas->passport[$i],
                "nationality" => $datas->nationality[$i],  
                "issue_year" => $datas->issue_year[$i],
                "issue_month" => $datas->issue_month[$i],
                "issue_day" => $datas->issue_day[$i],
                "issue_place" => $datas->issue_place[$i],
                "document_img" => $filenames[$i],
                "exp_year" => $datas->exp_year[$i],
                "exp_month" => $datas->exp_month[$i],
                "exp_day" => $datas->exp_day[$i],
                "address" => $datas->address[$i],
                "city" => $datas->city[$i],
                "postal_zip" => $datas->postal_zip[$i],
                "state" => $datas->state[$i],
                "country" => $datas->country[$i],
            ]);
        }
    }


 $menus = Menu::where('parent_id', 0)->orderby('order')->get();
 $page = InnerPage::where('slug', 'trekking')->first();
 $package = Packages::where('slug', $slug)->first();
 $dPrice = PackageDatePrice::findOrFail($datePrice);

 if ($dPrice->package->id != $package->id ) {
    abort(404);
}

return view('frontend.package.bookingstep3', compact('booking', 'packageBooking', 'datas', 'package','dPrice','datePrice', 'page', 'menus', 'slug'))->withClass($slug . '-page')
->with('meta_title', 'Booking Step 3')
->with('meta_keywords', $page->meta_key)
->with('meta_desc', $page->meta_desc)
->with('title', 'Booking Step 3');;
}

public function bookingStep3Payment($slug, $datePrice, Request $request){
    // return $request->all();
    $this->validate($request, [
        'optionsRadios' => 'required',
        'name' => 'required',
        'credit_card' => 'required',
        'exp_year' => 'required',
        'exp_month' => 'required',
        // 'cw' => 'required',
        ]);

    return "validated";

}

public function contactPackage(Request $request){
    $data['stat']="error";
    $data['msg']='<div class="alert alert-danger">Sorry, Something went wrong !! Please try again later.</div>';
    if($request->ajax()){
        parse_str($_POST['data'], $contactInfo);

        $datePriceId = $contactInfo['dateprice'];
        $datePrice = PackageDatePrice::findOrFail($datePriceId);
        $packageId = $datePrice->package->id;
    Contact::create([
    'fullname'=>$contactInfo['fullname'],
    'contact'=>$contactInfo['contact'],
    'email'=>$contactInfo['email'],
    'message'=>$contactInfo['message'],
    'dateprice_id'=>$contactInfo['dateprice'],
    'package_id'=>$packageId,
    ]);
        $setting = Setting::first();
        if(!empty($setting)){
            $adminEmail = $setting->adminEmail;
// return $adminEmail;

// send email to user
            Mail::send('emails.packagecontact.packageContact',['contactInfo' => $contactInfo], function($message) use ($contactInfo) {
               $message->from('noreply@upeverest.com', 'Up Everest')
               ->to($contactInfo['email'], $contactInfo['fullname'])
               ->subject('Contact Information sent to admin');
           });

// send email to admin
            Mail::send('emails.packagecontact.packageContactAdmin',['contactInfo' => $contactInfo, 'packageId'=>$packageId], function($message) use ($contactInfo, $adminEmail) {
               $message->from('noreply@upeverest.com', 'Up Everest')
               ->to('yojan@3hammers.com', 'Admin')
               // ->to('sanjeev@avdigitals.com', 'Admin')
               // ->cc('rupen@appliedvalue.com.np', 'Admin')
               // ->bcc('yankey@upeverest.com', 'Admin')
               ->subject('User can sent contact email');
           });

            $data['stat']="ok";
            $data['msg']='<div class="alert alert-success">Thanks for contacting us.<br> We will contact you soon.</div>';
            return $data;

        }
    }
    return $data;
}




}