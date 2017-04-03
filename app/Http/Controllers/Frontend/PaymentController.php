<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\MainTraveller;
use App\Models\OtherTraveller;
use App\Models\FlightReservation;
use App\Models\PackageBooking;
use App\Models\Booking;
use Carbon\Carbon;
use DB;

class PaymentController extends Controller {

public function flightBookingSuccess($token, Request $request){
    if($request->q == 'su' && (!empty($request->oid)) && (!empty($request->amt)) && (!empty($request->refId)) ){

        DB::transaction(function () use ($token, $request) {

            $flightReservation = FlightReservation::where('token', $token)->first();
            if(!empty($flightReservation) && $flightReservation->total_amount == $request->amt){
            // if(!empty($flightReservation) ){
                $flightReservation->update([
                    'refId' => $request->refId,
                    'status' =>'paid',
                    'payment_type' =>'esewa',
                    'token' => '',
                ]);
            }else{
                abort(404);
            }
            
            $booking = Booking::findOrFail($flightReservation->booking_id);
            $booking->update([
                'status' =>'paid',
                'purchased_at' =>Carbon::now(),
            ]);
            
        //mail need to be send to user as well as admin

        // send email to user
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

        });
            return redirect('/success');
// return $booking;
    }
    
}

public function packageBookingSuccess($token, Request $request){
    if($request->q == 'su' && (!empty($request->oid)) && (!empty($request->amt)) && (!empty($request->refId)) ){
        
        DB::transaction(function () {

            $packageBooking = PackageBooking::where('token', $token)->first();
            if(!empty($packageBooking) && $packageBooking->total_amount == $request->amt){
            // if(!empty($packageBooking) ){
                $packageBooking->update([
                    'refId' => $request->refId,
                    'status' =>'paid',
                    'payment_type' =>'esewa',
                    'token' => '',
                ]);
            }else{
                abort(404);
            }
            
            $booking = Booking::findOrFail($packageBooking->booking_id);
            $booking->update([
                'status' =>'paid',
                'purchased_at' =>Carbon::now(),
            ]);

        //mail need to be send to user as well as admin

        // send email to user
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

        });
            return redirect('/success'); 
    }
    
}


}