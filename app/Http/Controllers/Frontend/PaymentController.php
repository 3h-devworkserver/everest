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

            //ticket issue 
            $result = '<Itinerary><Passenger><Airline>YT</Airline><PnrNo>A1G0GK</PnrNo><Title></Title><Gender>M</Gender><FirstName>MR NELSONJ PANDEYJJ</FirstName><LastName></LastName><PaxNo></PaxNo><PaxType>ADULT</PaxType><Nationality>NP</Nationality><PaxId></PaxId><IssueFrom>PLZ010</IssueFrom><AgencyName>PLZ010</AgencyName><IssueDate>14-NOV-2016</IssueDate><IssueBy>YETI</IssueBy><FlightNo>675</FlightNo><FlightDate>29-NOV-2016</FlightDate><Departure>KTM</Departure><FlightTime>955</FlightTime><TicketNo>9992101956497</TicketNo><BarCodeValue>669282249</BarCodeValue><BarcodeImage>http://unitsoln.com/us/b2b/barcode/img/9992101956497.png</BarcodeImage><Arrival>PKR</Arrival><ArrivalTime>10:05</ArrivalTime><Sector>KTM-PKR</Sector><ClassCode>N</ClassCode><Currency>NPR</Currency><Fare>2360</Fare><Surcharge>1585</Surcharge><TaxCurrency>NPR</TaxCurrency><Tax>200</Tax><CommissionAmount>259.6</CommissionAmount><Refundable>Refundable</Refundable><ReportingTime>One Hour Before Flight Time</ReportingTime><FreeBaggage>20 KG</FreeBaggage></Passenger><Passenger><Airline>YT</Airline><PnrNo>A1G0GK</PnrNo><Title></Title><Gender>M</Gender><FirstName>MR NELSONJ PANDEYJJ</FirstName><LastName></LastName><PaxNo></PaxNo><PaxType>ADULT</PaxType><Nationality>NP</Nationality><PaxId></PaxId><IssueFrom>PLZ010</IssueFrom><AgencyName>PLZ010</AgencyName><IssueDate>14-NOV-2016</IssueDate><IssueBy>YETI</IssueBy><FlightNo>686</FlightNo><FlightDate>30-NOV-2016</FlightDate><Departure>PKR</Departure><FlightTime>1620</FlightTime><TicketNo>9992101956498</TicketNo><BarCodeValue>669282249</BarCodeValue><BarcodeImage>http://unitsoln.com/us/b2b/barcode/img/9992101956498.png</BarcodeImage><Arrival>KTM</Arrival><ArrivalTime>10:05</ArrivalTime><Sector>PKR-KTM</Sector><ClassCode>N</ClassCode><Currency>NPR</Currency><Fare>2360</Fare><Surcharge>1585</Surcharge><TaxCurrency>NPR</TaxCurrency><Tax>200</Tax><CommissionAmount>259.6</CommissionAmount><Refundable>Refundable</Refundable><ReportingTime>One Hour Before Flight Time</ReportingTime><FreeBaggage>20 KG</FreeBaggage></Passenger></Itinerary>';


            //end of ticket issue
            
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
        
        DB::transaction(function () use ($token, $request) {

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

        //ticket issue 
            // $result = '<Itinerary>
            //         <Passenger><Airline>YT</Airline><PnrNo>A1G0GK</PnrNo><Title></Title><Gender>M</Gender><FirstName>MR NELSONJ PANDEYJJ</FirstName><LastName></LastName><PaxNo></PaxNo><PaxType>ADULT</PaxType><Nationality>NP</Nationality><PaxId></PaxId><IssueFrom>PLZ010</IssueFrom><AgencyName>PLZ010</AgencyName><IssueDate>14-NOV-2016</IssueDate><IssueBy>YETI</IssueBy><FlightNo>675</FlightNo><FlightDate>29-NOV-2016</FlightDate><Departure>KTM</Departure><FlightTime>955</FlightTime><TicketNo>9992101956497</TicketNo><BarCodeValue>669282249</BarCodeValue><BarcodeImage>http://unitsoln.com/us/b2b/barcode/img/9992101956497.png</BarcodeImage><Arrival>PKR</Arrival><ArrivalTime>10:05</ArrivalTime><Sector>KTM-PKR</Sector><ClassCode>N</ClassCode><Currency>NPR</Currency><Fare>2360</Fare><Surcharge>1585</Surcharge><TaxCurrency>NPR</TaxCurrency><Tax>200</Tax><CommissionAmount>259.6</CommissionAmount><Refundable>Refundable</Refundable><ReportingTime>One Hour Before Flight Time</ReportingTime><FreeBaggage>20 KG</FreeBaggage></Passenger>
            //         <Passenger><Airline>YT</Airline><PnrNo>A1G0GK</PnrNo><Title></Title><Gender>M</Gender><FirstName>MR NELSONJ PANDEYJJ</FirstName><LastName></LastName><PaxNo></PaxNo><PaxType>ADULT</PaxType><Nationality>NP</Nationality><PaxId></PaxId><IssueFrom>PLZ010</IssueFrom><AgencyName>PLZ010</AgencyName><IssueDate>14-NOV-2016</IssueDate><IssueBy>YETI</IssueBy><FlightNo>686</FlightNo><FlightDate>30-NOV-2016</FlightDate><Departure>PKR</Departure><FlightTime>1620</FlightTime><TicketNo>9992101956498</TicketNo><BarCodeValue>669282249</BarCodeValue><BarcodeImage>http://unitsoln.com/us/b2b/barcode/img/9992101956498.png</BarcodeImage><Arrival>KTM</Arrival><ArrivalTime>10:05</ArrivalTime><Sector>PKR-KTM</Sector><ClassCode>N</ClassCode><Currency>NPR</Currency><Fare>2360</Fare><Surcharge>1585</Surcharge><TaxCurrency>NPR</TaxCurrency><Tax>200</Tax><CommissionAmount>259.6</CommissionAmount><Refundable>Refundable</Refundable><ReportingTime>One Hour Before Flight Time</ReportingTime><FreeBaggage>20 KG</FreeBaggage></Passenger>
            // </Itinerary>';

            // $res_xml = simplexml_load_string($result);
            // $res_xml = simplexml_load_string($result->return);
            // var_dump($result);
            // echo "<pre>";
            // print_r($res_xml);
            // echo "</pre>";
            // print_r($res_xml->Passenger);   

        //end of ticket issue
            

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