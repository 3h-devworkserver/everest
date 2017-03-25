<?php 
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Datatable;
use File;
use Validator;
use Hash;
use App\Models\Access\User\User;
use App\Models\Access\Role\Role;

class CustomerController extends Controller
{

  public function index(){
        $table = $this->registeredCustomers();
        return view('backend.customer.index', compact('table'));
  }

  // public function CustomerDatatable(){
  //     // $pacakges = Packages::select('id','title'); 
  //     $route = route('api.table.customer');              
  //     return Datatable::table()
  //     ->addColumn(trans('Id'), trans('Name'), trans('Email'), trans('Customer Type'), trans('Created At'))
  //     ->addColumn(trans('Actions'))
  //     ->setUrl($route)
  //     ->setOrder([4=>'desc'])
  //     ->render();
  // }

  public function registeredCustomers(){
     $route = route('api.table.customer.registered');              
      return $table = Datatable::table()
      ->addColumn(trans('Id'), trans('Name'), trans('Email'), trans('Created At'))
      ->addColumn(trans('Actions'))
      ->setUrl($route)
      ->setOrder([4=>'desc'])
      ->render();

}

  public function create(){
    return view('backend.customer.create');
  }

  public function store(Request $request){
    // return $request->all();
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
          'status'=> 1,
          'confirmed'=> 1,
      ]);

      $user->attachRole($this->getTravellerUserRole());

    if ($request->hasFile('profilePic')) {
      $file = $request->file('profilePic');
      $destination_path = 'images/user/profile';
      $filename = time() . '-'.str_random(4) . $file->getClientOriginalName();
      $file->move($destination_path, $filename);
    }else{
      $filename = '';
    }

    if ($request->hasFile('DocUpload')) {
      $file = $request->file('DocUpload');
      $destination_path = 'images/user/document';
      $filename2 = time() . '-' . $file->getClientOriginalName();
      $file->move($destination_path, $filename2);
    }else{
      $filename2 = '';
    }

      $user->profile()->create([
          'title'=> $request->title,
          'fname'=> $request->fname,
          'mname'=> $request->mname,
          'lname'=> $request->lname,
          'email'=> $request->email,
          'profile_pic'=> $filename,
          'document_img'=> $filename2,
          'address'=> $request->address,
          'nationality'=> $request->country,
          'state'=> $request->state,
          'phone_type'=> $request->phone_type,
          'phone'=> $request->phone_number,
          'document_type'=> $request->document_type,
          'document_no'=> $request->document_no,
        ]);
  
      return redirect()->route('admin.customers.index');
  }

  public function getTravellerUserRole() {
    return Role::where('name', 'Traveller')->first();
  }

  public function edit($id){
    $customer = User::findOrFail($id);
    return view('backend.customer.edit', compact('customer'));
  }

  public function update(Request $request, $id){
    // return $request->all();

    $this->validate($request, [
      'title' => 'required',
      'fname' => 'required',
      'lname' => 'required',
      'email' => 'required|email|unique:users,email,'.$id,
      'password' => 'required|confirmed|min:6',
      'country' => 'required',
      'state' => 'required',
    ]);

    $user = User::findOrFail($id);
  if($user->password == $request->password){
    $user->update([
      'fname'=> $request->fname,
      'mname'=> $request->mname,
      'lname'=> $request->lname,
      'email'=> $request->email,
    ]);
  }else{
      $user->update([
      'fname'=> $request->fname,
      'mname'=> $request->mname,
      'lname'=> $request->lname,
      'email'=> $request->email,
      'password'=> Hash::make($request->password),
    ]);
  }

    if ($request->hasFile('profilePic')) {
      $file = $request->file('profilePic');
      $destination_path = 'images/user/profile';
      $filename = time() . '-' . $file->getClientOriginalName();
      $file->move($destination_path, $filename);
    }else{
      $filename = $user->profile->profile_pic;
    }

    if ($request->hasFile('DocUpload')) {
      $file = $request->file('DocUpload');
      $destination_path = 'images/user/document';
      $filename2 = time() . '-' . $file->getClientOriginalName();
      $file->move($destination_path, $filename2);
    }else{
      $filename2 = $user->profile->document_img;
    }

    $user->profile()->update([
      'title'=> $request->title,
      'fname'=> $request->fname,
      'mname'=> $request->mname,
      'lname'=> $request->lname,
      'email'=> $request->email,
      'profile_pic'=> $filename,
      'document_img'=> $filename2,
      'address'=> $request->address,
      'nationality'=> $request->country,
      'state'=> $request->state,
      'phone_type'=> $request->phone_type,
      'phone'=> $request->phone_number,
      'document_type'=> $request->document_type,
      'document_no'=> $request->document_no,
    ]);

    return redirect()->route('admin.customers.edit', $id)->withFlashSuccess('Information Updated Successfullly');

  }

  public function destroy($id){
    $customer = User::findOrFail($id);
    // return $customer;
    $customer->update([
        'status'=>'0',
        'deleted_at' => \Carbon\Carbon::now(),
      ]);
    return redirect('admin/customers')->withFlashSuccess('Customer Deleted Successfully');
}




}

