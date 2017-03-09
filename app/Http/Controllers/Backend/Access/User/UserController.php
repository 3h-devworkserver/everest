<?php namespace App\Http\Controllers\Backend\Access\User;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\User\UserContract;
use App\Repositories\Backend\Role\RoleRepositoryContract;
use App\Repositories\Frontend\Auth\AuthenticationContract;
use App\Http\Requests\Backend\Access\User\CreateUserRequest;
use App\Http\Requests\Backend\Access\User\StoreUserRequest;
use App\Http\Requests\Backend\Access\User\EditUserRequest;
use App\Http\Requests\Backend\Access\User\MarkUserRequest;
use App\Http\Requests\Backend\Access\User\UpdateUserRequest;
use App\Http\Requests\Backend\Access\User\DeleteUserRequest;
use App\Http\Requests\Backend\Access\User\RestoreUserRequest;
use App\Http\Requests\Backend\Access\User\StoreLicenceRequest;
use App\Http\Requests\Backend\Access\User\ChangeUserPasswordRequest;
use App\Http\Requests\Backend\Access\User\UpdateUserPasswordRequest;
use App\Repositories\Backend\Permission\PermissionRepositoryContract;
use App\Http\Requests\Backend\Access\User\PermanentlyDeleteUserRequest;
use App\Http\Requests\Backend\Access\User\ResendConfirmationEmailRequest;
use App\Repositories\Frontend\Profileupload;
use Illuminate\Http\Request;
use Datatable;
use Illuminate\Http\Response;
use DB;
use Input;
use App\Models\Gallery;
use App\Models\Profile;
use App\Models\Booking;
use App\Models\Availability;
use App\Models\Setting;


/**
 * Class UserController
 */
class UserController extends Controller {

	/**
	 * @var UserContract
	 */
	protected $users;

	/**
	 * @var RoleRepositoryContract
	 */
	protected $roles;

	/**
	 * @var PermissionRepositoryContract
	 */
	protected $permissions;

	/**
	 * @param UserContract $users
	 * @param RoleRepositoryContract $roles
	 * @param PermissionRepositoryContract $permissions
	 */
	public function __construct(UserContract $users, RoleRepositoryContract $roles, PermissionRepositoryContract $permissions) {
		$this->users = $users;
		$this->roles = $roles;
		$this->permissions = $permissions;
	}

	
	/**
	 * @return mixed
	 */
	public function index() {
		
		 $table = $this->setDatatable('1');
		 return view('backend.access.index', compact('table'));
	}

	/**
	 * @return mixed
	 */
	public function getGuides() {
		
		 $table = $this->setDatatable(1,2); //first arg is status and second is role of users
		 return view('backend.access.getguide', compact('table'));
	}


	/**
	 * @return mixed
	 */
	public function getTravellers() {
		
		 $table = $this->setDatatable(1,3);
		 return view('backend.access.index', compact('table'));
	}


	/**
	 * @return mixed
	 */
	public function getAddGuide() {
		// $mainGuideArea = DB::table('profiles')->lists('mGuidingArea', 'id');
		// $mystring = implode(",", $mainGuideArea);
		// $myArray = explode(',', $mystring);
		// $uniqueString = array_unique($myArray);
		// $language = DB::table('profiles')->lists('language');
		// $languagestring = implode(",", $language);
		// $lanArray = explode(',', $languagestring);
		// $lanString = array_unique($lanArray);

		$mainGuideArea = DB::table('guideareas')->lists('guide_area');
		$languages = DB::table('languages')->lists('language');
		 return view('backend.access.addguide')
		  ->with('options',$mainGuideArea)
		  ->with('language',$languages)
		  ->withRoles($this->roles->getAllRoles('sort', 'asc', true))
			->withPermissions($this->permissions->getAllPermissions());
		
	}


	/**
	 * @return mixed
	 */
	public function getGeneralUsers() {
		
		 // $table = $this->setDatatable(1,3);
		 return view('backend.general.index')
		 ->withRoles($this->roles->getAllRoles());
	}

	/**
	 * @return mixed
	 */
	public function postAddGuide() {
		
		 $table = $this->setDatatable(1,3);
		 return view('backend.general.index')
		 ->withRoles($this->roles->getAllRoles());
	}



	/**
	 * @return mixed
	 */
	public function postAvailability() {
		$datas = $_POST['id'];
		parse_str($datas,$data);
		$userid= $data['id'];


		$dates = $_POST['dates'];
		$mystring = implode(",", $dates);



		Availability::where('guide_id', $userid)->update(array(
            'availibility'    =>  $mystring
        ));
		
		return response()->json(array('success' => 'Availability Dates was successfully Assigned.'));
	}

	/**
	 * @return mixed
	 */
	public function postLicence(UserContract $license, Request $request) {
		$userid = $_POST['id'];
		$result = $license->upload($license);
		
        if ($request->ajax())
{
	$images = DB::table('gallerys')
	->where('user_id', $userid)
	->where('type','license')->orderBy('created_at', 'desc')->paginate(8);
	
	$html = view('backend.gallery.addguideLicence')->with('licenses', $images)->render();
	
            return response()->json(array('success' => 'Licence was successfully Uploaded.', 'html' => $html));

      //return response()->json(array('success' => 'Licence was successfully Uploaded.'));
     //return response()->json($datas);
}
		return redirect()->back()->withFlashSuccess(trans("alerts.users.licenceuploaded"));

	}

// commented -- yojan
// 	/**
// 	 * @return mixed
// 	 */
// 	public function postCertification(UserContract $license, Request $request) {
// 		$userid = Input::get('id');
// 		$result = $license->certification($license);
//         if ($result == true)
// {

	
//             return response()->json(array('success' => 'User Certification was successfully Verified.'));

//       //return response()->json(array('success' => 'Licence was successfully Uploaded.'));
//      //return response()->json($datas);
// }
// 		return response()->json(array('success' => 'Something went wrong please check.'));

// 	}

//commented -- yojan
	// /**
	//  * @return mixed
	//  */
	// public function postProfilePic(UserContract $license, Request $request) {
		
	// 	$userid = ($request['user_id']);
	// 	$path = ($request['path']);
	// 	Profile::where('user_id', $userid)->update(['profileImg' => $path]);
        
 //        return response()->json(array('success' => 'Profile Picture was successfully Set.'));
	// }



	/**
	 * @param CreateUserRequest $request
	 * @return mixed
     */
	public function create(CreateUserRequest $request) {
		return view('backend.access.create')
			->withRoles($this->roles->getAllRoles('sort', 'asc', true))
			->withPermissions($this->permissions->getAllPermissions());
	}

	/**
	 * @param StoreUserRequest $request
	 * @return mixed
     */
	public function store(StoreUserRequest $request) {
		$datas =  $this->users->create(
			$request->except('assignees_roles', 'permission_user'),
			$request->only('assignees_roles'),
			$request->only('permission_user')
		);
		// return response()->json($datas);
		 return redirect()->route('admin.access.users.index')->withFlashSuccess(trans("alerts.users.created"));
	}

	/**
	 * @param $id
	 * @param EditUserRequest $request
	 * @return mixed
     */
	public function edit($id, Request $request) {
		$user = $this->users->findOrThrowException($id, true);
		// return $user;
		// $videos = $user->gallery()->where('type','video')->orderBy('created_at', 'desc')->get();
		// $license = $user->gallery()->where('type','license')->orderBy('created_at', 'desc')->get();
		// $images = $user->gallery()->where('type','image')->orderBy('created_at', 'desc')->get();

// 		$availibility = DB::table('availabilitys')
// 		->select('availibility')
// 		->where('guide_id', $id)
// 		->first();
// 		$mainGuideArea = DB::table('guideareas')->lists('guide_area');
// 		$languages = DB::table('languages')->lists('language');
// 		$selectedMarea = $user->Profile->mGuidingArea;
// 		$filteredarea = DB::table('guideareas')->where('guide_area', '!=' , $selectedMarea)->lists('guide_area');

// 		$selectedGender = $user->gender;
// 		$selectedOarea = $user->Profile->oGuidingArea;
// 		$explodestring = explode(',', $selectedOarea);

// 		$selectedlang = $user->Profile->language;
// 		$explodestringlan = explode(' ', $selectedlang);
// if($availibility)
// {
// 		foreach ($availibility as $available) {
// 			$available;
// 		}

// 	}
// 	else
// 	{
// 		$available ='';
// 	}
	// $user->gallery()->where('type','license')->orderBy('created_at', 'desc')->paginate(8);
		if ($request->ajax()) {
            $html = view('backend.gallery.images')->with('gallerys', $images)->render();
            return response()->json(array('success' => true, 'html' => $html));
        }
       //testing
        // return $user->roles->first();
        // return $user->permissions->lists('id')->all();
        // $permissions =  $this->permissions->getAllPermissions();
        // return $permissions[0]['dependencies'];

        // $arrayName = [33, 45, 50];
        // $arrayName = array('0' =>33 , '1'=>45 );
        // var_dump($arrayName);
        // echo "<br>";
        // var_dump(json_encode($arrayName)); die();
       // end of testing
		return view('backend.access.edit')
			->withUser($user)
			// ->withGallerys($images)
			// ->withVideos($videos)
			// ->withLicenses($license)
			// ->withGuidearea($filteredarea)
			// ->withSelectedarea($selectedMarea)
			// ->withSelectedoarea($explodestring)
			// ->withSelectedlang($explodestringlan)
			// ->withGuidelanguage($languages)
			// ->withAvailibility($available)
			// ->withUserRoles($user->roles->lists('id')->all())
			->withUserrole($user->roles->first())
			->withRoles($this->roles->getAllRoles('sort', 'asc', true))
			->withUserpermissions($user->permissions->lists('id')->all())
			->withPermissions($this->permissions->getAllPermissions());

	}

	/**
	 * @param $id
	 * @param UpdateUserRequest $request
	 * @return mixed
	 */
	public function update($id, UpdateUserRequest $request) {
		// return $request->all();
		if(isset($request['assignees_roles'])){
			$this->users->roleUpdate($id,$request->only('assignees_roles'),$request->only('permission_user'));
			$this->users->update($id,$request->except('assignees_roles', 'permission_user'));
		}
		else
			$this->users->update($id,$request->except('assignees_roles', 'permission_user'));

		 return redirect()->route('admin.access.users.edit', $id)->withFlashSuccess(trans("alerts.users.updated"));
	}
//commented previous code
	// public function update($id, UpdateUserRequest $request) {
		
	// 	if(isset($request['roles']))
	// 		$this->users->roleUpdate($id,$request->only('assignees_roles'),$request->only('permission_user'));
	// 	else
	// 		$this->users->update($id,$request->except('assignees_roles', 'permission_user'));

	// 	 return redirect()->route('admin.access.users.edit', $id)->withFlashSuccess(trans("alerts.users.updated"));
	// }


//commented --yojan
	// /**
	//  * @param $id
	//  * @param UpdateUserRequest $request
	//  * @return mixed
	//  */
	// public function postEditAvailability() {
	// 	$datas = $_POST['id'];
	// 	parse_str($datas,$data);
	// 	$userid= $data['id'];

	// 	$dates = $_POST['dates'];
	// 	$mystring = implode(",", $dates);


	// 	Availability::where('guide_id', $userid)->update(array(
 //            'availibility'    =>  $mystring
 //        ));

	// 	return response()->json(array('success' => 'Availability Dates was successfully Updated.'));
	// }



	/**
	 * @param $id
	 * @param DeleteUserRequest $request
	 * @return mixed
     */
	public function destroy($id, DeleteUserRequest $request) {

		$this->users->delete($id);
		return redirect()->back()->withFlashSuccess(trans("alerts.users.deleted"));
	}

	/**
	 * @param $id
	 * @param PermanentlyDeleteUserRequest $request
	 * @return mixed
     */
	public function delete($id, PermanentlyDeleteUserRequest $request) {

		$this->users->delete($id);
		return redirect()->back()->withFlashSuccess(trans("alerts.users.deleted_permanently"));
	}

	/**
	 * @param $id
	 * @param RestoreUserRequest $request
	 * @return mixed
     */
	public function restore($id, RestoreUserRequest $request) {
		$this->users->restore($id);
		return redirect()->back()->withFlashSuccess(trans("alerts.users.restored"));
	}

	/**
	 * @param $id
	 * @param $status
	 * @param MarkUserRequest $request
	 * @return mixed
     */
	public function mark($id, $status, MarkUserRequest $request) {
		$this->users->mark($id, $status);
		return redirect()->back()->withFlashSuccess(trans("alerts.users.updated"));
	}

	/**
	 * @return mixed
	 */
	public function deactivated() {
		$table = $this->setDatatable('0');
        return view('backend.access.deactivated', compact('table'));
	}

	/**
	 * @return mixed
	 */
	public function deleted() {
		return view('backend.access.deleted')
			->withUsers($this->users->getDeletedUsersPaginated(25));
	}

	/**
	 * @return mixed
	 */
	public function banned() {
		return view('backend.access.banned')
			->withUsers($this->users->getUsersPaginated(25, 2));
	}

	/**
	 * @param $id
	 * @param ChangeUserPasswordRequest $request
	 * @return mixed
     */
	public function changePassword($id, ChangeUserPasswordRequest $request) {
		return view('backend.access.change-password')
			->withUser($this->users->findOrThrowException($id));
	}

	/**
	 * @param $id
	 * @param UpdateUserPasswordRequest $request
	 * @return mixed
	 */
	public function updatePassword($id, UpdateUserPasswordRequest $request) {
		$this->users->updatePassword($id, $request->all());
		return redirect()->route('admin.access.users.index')->withFlashSuccess(trans("alerts.users.updated_password"));
	}

	/**
	 * @param $user_id
	 * @param AuthenticationContract $auth
	 * @param ResendConfirmationEmailRequest $request
	 * @return mixed
     */
	public function resendConfirmationEmail($user_id, AuthenticationContract $auth, ResendConfirmationEmailRequest $request) {
		$auth->resendConfirmationEmail($user_id);
		return redirect()->back()->withFlashSuccess(trans("alerts.users.confirmation_email"));
	}


	public function picUpload(ProfileUpload $hood){
		$hood->upload();
		return $hood->result();
	}



	/**
     * Create DataTable HTML
     *
     * @return mixed
     * @throws \Exception
     */
    private function setDatatable($status,$role=null)
    {
        

        if ($status) {
            
            if ($role!=null && $role==2)
            	$route = route('api.table.users.guides');
            elseif ($role!=null && $role==3)
            	$route = route('api.table.users.travellers');

            else
            	$route = route('api.table.users');
        }

        else
            $route = route('api.table.users.deactivated');

            return Datatable::table()
            ->addColumn(trans('crud.users.id'), trans('crud.users.name'), trans('crud.users.email'), trans('crud.users.confirmed'),trans('crud.users.roles'),trans('crud.users.certified'),trans('crud.users.created'))
            ->addColumn(trans('crud.actions'))
            ->setUrl($route)
            ->setOptions(['responsive' => true, 'oLanguage' => trans('crud.datatables'), 'fnInitComplete' => "function(oSettings, json) {formLoad()}"])
            ->setOrder(array(4=>'asc')) // sort by roles
            ->render();

       
    }

    public function getVideo(Request $request){
		$guide = $this->user->findOrThrowException(auth()->id());
		$gallerys = $guide->gallery()->where('type','video')->orderBy('created_at', 'desc')->paginate(12);
		
	
		return view('backend.videos',compact('guide'))->withGallerys($gallerys)->withClass('gallery');
	}

    
    
}