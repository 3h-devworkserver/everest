<?php 
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Laracasts\Flash\Flash;
use Datatable;
use Input;
use File;
use Validator;
use App\Models\MainTraveller;

class CustomerController extends Controller
{

  public function index(){
        $table = $this->registeredCustomers();
        return view('backend.flight.customer.index', compact('table'));
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
      ->addColumn(trans('Id'), trans('Name'), trans('Email'), trans('Customer Type'), trans('Created At'))
      ->addColumn(trans('Actions'))
      ->setUrl($route)
      ->setOrder([4=>'desc'])
      ->render();

}

  public function edit($id){
    $mainTraveller = MainTraveller::findOrFail($id);
    return $mainTraveller;
    return view('backend.packages.options.edit', compact('mainTraveller'));
  }

  public function destroy($id){
    $mainTraveller = MainTraveller::findOrFail($id);
    return $mainTraveller;
    $mainTraveller->delete();
    return redirect('admin/customers')->withFlashSuccess('Customer Deleted Successfully');
}




}

