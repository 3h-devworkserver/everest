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

  // public function index(){
  //   $mainTravellers = MainTraveller::all();
  //   return $mainTravellers;
  // }

  public function index(){
        $table = $this->CustomerDatatable();
        return view('backend.flight.customer.index', compact('table'));
  }

  public function CustomerDatatable(){
      // $pacakges = Packages::select('id','title'); 
      $route = route('api.table.customer');              
      return Datatable::table()
      ->addColumn(trans('Id'), trans('Name'), trans('Email'), trans('Customer Type'), trans('Created At'))
      ->addColumn(trans('Actions'))
      ->setUrl($route)
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

public function registeredCustomers(){
     $route = route('api.table.customer.registered');              
      $table = Datatable::table()
      ->addColumn(trans('Id'), trans('Name'), trans('Email'), trans('Customer Type'), trans('Created At'))
      ->addColumn(trans('Actions'))
      ->setUrl($route)
      ->render();

        return view('backend.flight.customer.index', compact('table'));
}


}

