<?php namespace App\Http\Controllers\Frontend\Auth;

use Illuminate\Http\Request;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Http\Requests\Frontend\Access\LoginRequest;
use App\Http\Requests\Frontend\Access\RegisterRequest;
use App\Repositories\Frontend\Auth\AuthenticationContract;
use App\Models\Access\User\User;
use App\Models\Access\Role\Role;
use App\Models\Menu;
use Hash;
use Mail;
use Validator;

/**
 * Class AuthController
 * @package App\Http\Controllers\Frontend\Auth
 */
class AuthController extends Controller
{

    use ThrottlesLogins;

    /**
     * @param AuthenticationContract $auth
     */
    public function __construct(AuthenticationContract $auth)
    {
        $this->auth = $auth;
    }

       /**
     * @return \Illuminate\View\View
     */
    public function getRegister()
    {
        return view('frontend.auth.register');
    }

//register page for traveller
    public function getTravellerRegister(){
        return view('frontend.auth.travellerregister')
        ->with('menus', Menu::where('parent_id', 0)->orderby('order')->get())
        ->with('meta_title', 'Traveller Register | Upeverest')
        ->with('meta_keywords', 'Traveller Register | Upeverest') 
        ->with('meta_desc', 'Traveller Register | Upeverest');
    }

    public function getTravellerUserRole() {
        return Role::where('name', 'Traveller')->first();
    }

//register traveller from frontend register page
public function postTravellerRegister(Request $request){
   $this->validate($request, [
      'title' => 'required',
      'fname' => 'required',
      'lname' => 'required',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|confirmed|min:6',
      'country' => 'required',
      'state' => 'required',
    ]);

      $user = User::create([
          'fname'=> $request->fname,
          'mname'=> $request->mname,
          'lname'=> $request->lname,
          'email'=> $request->email,
          'password'=> Hash::make($request->password),
          'confirmation_code' => md5(uniqid(mt_rand(), true)),
          'status'=> 1,
          'confirmed'=> 0,
      ]);

      $user->attachRole($this->getTravellerUserRole());

      $user->profile()->create([
          'title'=> $request->title,
          'fname'=> $request->fname,
          'mname'=> $request->mname,
          'lname'=> $request->lname,
          'email'=> $request->email,
          'address'=> $request->address,
          'nationality'=> $request->country,
          'state'=> $request->state,
          'phone_type'=> $request->phone_type,
          'phone'=> $request->phone_number,
          'document_type'=> $request->document_type,
          'document_no'=> $request->document_no,
        ]);

        if(!empty($user->mname)){
            $name = $user->fname.' '.$user->mname.' '.$user->lname;
        }else{
            $name = $user->fname.' '.$user->lname;
        }

     Mail::send('emails.confirm', ['token' => $user->confirmation_code], function ($message) use ($user, $name) {
            $message->to($user->email, $name)->subject('Confirm your account!');
        });
  
      return redirect('/register')->withFlashSuccess('Confirmation email is sent to your email');
    }



    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postGuideRegister(RegisterRequest $request)
    {
        $data['stat']='error';
        if (config('access.users.confirm_email')) {
            $this->auth->create($request->all());
            $data['stat']='confirm';
            $data['success']='Your account was successfully created. We have sent you an e-mail to confirm your account.';
            return response()->json($data);
        } else {
            //Use native auth login because do not need to check status when registering
          
            $data['stat']='ok';
            auth()->login($this->auth->create($request->all()));
             
            return response()->json($data);
        }
    }  

     /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    // public function postTravellerRegister(RegisterRequest $request)
    // {
    //     $data['stat']='error';
    //     if (config('access.users.confirm_email')) {
    //         $this->auth->create($request->all());
    //         $data['stat']='confirm';
    //         $data['success']='Your account was successfully created. We have sent you an e-mail to confirm your account.';
    //         return response()->json($data);
    //     } else {
    //         //Use native auth login because do not need to check status when registering
    //        // $this->auth->create($request->all());
    //         $data['stat']='ok';
    //         // $data['stat']='ok';
    //           auth()->login($this->auth->create($request->all()));
    //         // return redirect()->route('frontend.dashboard');
    //         //$data['msg'] =$request->all();
    //         return response()->json($data);
    //     }
    //     // $data['msg'] =$request->all();
    //     // return response()->json($data);
    // }

    //  public function postTravellerRegister(RegisterRequest $request)
    // {
    //     $data['stat']='error';
    //     if (config('access.users.confirm_email')) {
    //         $this->auth->create($request->all());
    //         $data['stat']='confirm';
    //         $data['success']='Your account was successfully created. We have sent you an e-mail to confirm your account.';
    //         return response()->json($data);
    //     } else {
    //         //Use native auth login because do not need to check status when registering
    //        // $this->auth->create($request->all());
    //         $data['stat']='ok';
    //         // $data['stat']='ok';
    //           auth()->login($this->auth->create($request->all()));
    //         // return redirect()->route('frontend.dashboard');
    //         //$data['msg'] =$request->all();
    //         return response()->json($data);
    //     }
    //     // $data['msg'] =$request->all();
    //     // return response()->json($data);
    // }

 

 /**
     * @param  LoginRequest                        $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postTravellerLogin(Request $request)
    {   
        if($request->ajax()){
            $validator = Validator::make($request->all(), [       
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if($validator->fails()){
                $data['stat'] = 'error';
                $data['msg'] =  'Invalid Email or Password';
                return $data;
            }
        }
        else{
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required',
            ]);
        }
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        //Don't know why the exception handler is not catching this
        try {

            $traveller = $this->auth->travellerLogin($request);

            if ($throttles) {
                $this->clearLoginAttempts($request);
            }
            //for ajax -flight
            if ($request->ajax()) {
                $data['stat'] = 'success';
                $data['id'] = $traveller->id;
                return $data;
            }

            return redirect()->intended('/traveller/dashboard');
        } catch (GeneralException $e) {
            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            if ($throttles) {
                $this->incrementLoginAttempts($request);
            }

            if ($request->ajax()) {
                $data['stat'] = 'error';
                $data['msg'] = $e->getMessage();
                return $data;
            }

            return redirect()->back()->withInput()->withFlashDanger($e->getMessage());
        }
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(LoginRequest $request)
    {
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $data['stat'] = "error";
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request))
            return $this->sendLockoutResponse($request);

        //Don't know why the exception handler is not catching this
        try {
            
            $this->auth->login($request);
            $data['stat'] = "ok";
            if ($throttles)
                $this->clearLoginAttempts($request);

            if(access()->hasRole(1))
                 $data['access'] = 1;

            elseif(access()->hasRole(2))
                 $data['access'] = 2;
            
            elseif(access()->hasRole(3))
                 $data['access'] = 3;
            
            else
                 $data['access'] = 3;

           if ($request->has('refferer')) {
                $data['refferer'] = $request->refferer;
            }
           return response()->json($data);
            //return redirect()->intended('/dashboard');
        } catch (GeneralException $e) {
            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
             if ($throttles)
                 $this->incrementLoginAttempts($request);

            // return redirect()->back()->withInput()->withFlashDanger($e->getMessage());
             $data['msg']=$e->getMessage();
            return response()->json($data);
        }
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getAdminLogin()
    {
        
        return view('frontend.auth.login')->withClass('adminLoginArea');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getTravellerLogin()
    {
        return view('frontend.auth.travellerlogin')->withClass('travellerLoginArea')
        ->with('menus', Menu::where('parent_id', 0)->orderby('order')->get())
        ->with('meta_title', 'Traveller Login | Upeverest')
        ->with('meta_keywords', 'Traveller Login | Upeverest') 
        ->with('meta_desc', 'Traveller Login | Upeverest');
    }

     /**
     * @param  LoginRequest                        $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAdminLogin(LoginRequest $request)
    {
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        //Don't know why the exception handler is not catching this
        try {
            $this->auth->login($request);

            if ($throttles) {
                $this->clearLoginAttempts($request);
            }

            return redirect()->intended('/admin/dashboard');
        } catch (GeneralException $e) {
            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            if ($throttles) {
                $this->incrementLoginAttempts($request);
            }

            return redirect()->back()->withInput()->withFlashDanger($e->getMessage());
        }
    }


    /**
     * @param Request $request
     * @param $provider
     * @return mixed
     */
    public function loginThirdParty(Request $request, $provider)
    {
        return $this->auth->loginThirdParty($request->all(), $provider);
        //echo $request->utype;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout()
    {
        $this->auth->logout();
        return redirect()->route('auth.admin');
    }

    /**
     * @param $token
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function confirmAccount($token)
    {
        //Don't know why the exception handler is not catching this
        try {
            $this->auth->confirmAccount($token);
            return redirect()->route('home')->withFlashSuccess("Your account has been successfully confirmed!");
        } catch (GeneralException $e) {
            return redirect()->back()->withInput()->withFlashDanger($e->getMessage());
        }
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function resendConfirmationEmail($user_id)
    {
        //Don't know why the exception handler is not catching this
        try {
            $this->auth->resendConfirmationEmail($user_id);
            return redirect()->route('home')->withFlashSuccess("A new confirmation e-mail has been sent to the address on file.");
        } catch (GeneralException $e) {
            return redirect()->back()->withInput()->withFlashDanger($e->getMessage());
        }
    }

    /**
     * Helper methods to get laravel's ThrottleLogin class to work with this package
     */

    /**
     * Get the path to the login route.
     *
     * @return string
     */
    public function loginPath()
    {
        return property_exists($this, 'loginPath') ? $this->loginPath : '/auth/login';
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {
        return property_exists($this, 'username') ? $this->username : 'email';
    }

    /**
     * Determine if the class is using the ThrottlesLogins trait.
     *
     * @return bool
     */
    protected function isUsingThrottlesLoginsTrait()
    {
        return in_array(
            ThrottlesLogins::class, class_uses_recursive(get_class($this))
        );
    }

    /**
     * Generates social login links based on what is enabled
     * @return string
     */
    protected function getSocialLinks()
    {
        $socialite_enable = [];
        $socialite_links = '';

        if (getenv('GITHUB_CLIENT_ID') != '')
            $socialite_enable[] = link_to_route('auth.provider', trans('labels.login_with', ['social_media' => 'Github']), 'github');

        if (getenv('FACEBOOK_CLIENT_ID') != '')
            $socialite_enable[] = link_to_route('auth.provider', trans('labels.login_with', ['social_media' => 'Facebook']), 'facebook');

        if (getenv('TWITTER_CLIENT_ID') != '')
            $socialite_enable[] = link_to_route('auth.provider', trans('labels.login_with', ['social_media' => 'Twitter']), 'twitter');

        if (getenv('GOOGLE_CLIENT_ID') != '')
            $socialite_enable[] = link_to_route('auth.provider', trans('labels.login_with', ['social_media' => 'Google']), 'google');

        for ($i = 0; $i < count($socialite_enable); $i++) {
            $socialite_links .= ($socialite_links != '' ? '&nbsp;|&nbsp;' : '') . $socialite_enable[$i];
        }

        return $socialite_links;
    }
}
