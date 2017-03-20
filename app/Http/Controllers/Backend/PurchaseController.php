<?php 
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Datatable;
use App\Models\Access\User\User;
use App\Models\Booking;

class PurchaseController extends Controller
{

  public function index(){
    $route = route('api.table.purchase');              
    $table = Datatable::table()
      ->addColumn(trans('Id'), trans('Order Id'), trans('Customer'), trans('Purchase Type'), trans('Purchased At'))
      ->addColumn(trans('Actions'))
      ->setUrl($route)
      ->setOrder([4=>'desc'])
      ->render();
      return view('backend.purchase.index', compact('table'));
  }

  public function summary($id){
    return Booking::findOrFail($id);
  }



}

