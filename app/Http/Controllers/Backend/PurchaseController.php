<?php 
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Datatable;
use App\Models\Access\User\User;
use App\Models\Booking;
use App\Models\Packages;
use App\Models\PackageDatePrice;

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
    $booking = Booking::findOrFail($id);

    //details for flight reservation
    if($booking->type == 'flight'){
      $flight = $booking->flightReservation;
      $flightDetail = json_decode($flight->flight_detail);
      if ($flight->return_type == 'R') {
        $returnFlightDetail = json_decode($flight->returnflight_detail);
      }else{
        $returnFlightDetail = '';
      }
      $mainTraveller = $flight->mainTraveller->profile;
      return view('backend.purchase.summary', compact('booking', 'flight', 'flightDetail', 'returnFlightDetail', 'mainTraveller'));
    }else{

      //detail for package booking
      $packageBooking = $booking->packageBooking;
      $package = Packages::findOrFail($packageBooking->package_selected);
      $datePrice = PackageDatePrice::findOrFail($packageBooking->dateprice_selected);
      // return $datePrice;
       if (!empty($packageBooking->addon_selected)) {
        $addon = explode(',', $packageBooking->addon_selected);
        $addonDetail = explode(',', $packageBooking->addon_packages_detail);
      }else{
        $addon = '';
      }
      $mainTraveller = $packageBooking->mainTraveller->profile;
      // return $addonDetail;
      return view('backend.purchase.summary', compact('booking', 'packageBooking', 'package', 'addon', 'addonDetail', 'datePrice', 'mainTraveller'));
    }
  }



}

