<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use DB;
use Auth;
use Crypt;
use Validator;
use App\Models\Menu;
use App\Models\MainTraveller;
use App\Models\OtherTraveller;
use App\Models\FlightReservation;

class FlightController extends Controller {
    private $strUserId = 'UPEVES';
    private $strPassword = 'PASSWORD';
    private $strAgencyId = 'PLZ106';

    private $strWsdl = 'http://dev.usbooking.org/us/UnitedSolutions?wsdl';
    private $strEndpoint = 'http://dev.usbooking.org/us/UnitedSolutions';
    private $strNamespace = 'http://booking.us.org';

    public $countries = array
    (
        'AF' => 'Afghanistan',
        'AX' => 'Aland Islands',
        'AL' => 'Albania',
        'DZ' => 'Algeria',
        'AS' => 'American Samoa',
        'AD' => 'Andorra',
        'AO' => 'Angola',
        'AI' => 'Anguilla',
        'AQ' => 'Antarctica',
        'AG' => 'Antigua And Barbuda',
        'AR' => 'Argentina',
        'AM' => 'Armenia',
        'AW' => 'Aruba',
        'AU' => 'Australia',
        'AT' => 'Austria',
        'AZ' => 'Azerbaijan',
        'BS' => 'Bahamas',
        'BH' => 'Bahrain',
        'BD' => 'Bangladesh',
        'BB' => 'Barbados',
        'BY' => 'Belarus',
        'BE' => 'Belgium',
        'BZ' => 'Belize',
        'BJ' => 'Benin',
        'BM' => 'Bermuda',
        'BT' => 'Bhutan',
        'BO' => 'Bolivia',
        'BA' => 'Bosnia And Herzegovina',
        'BW' => 'Botswana',
        'BV' => 'Bouvet Island',
        'BR' => 'Brazil',
        'IO' => 'British Indian Ocean Territory',
        'BN' => 'Brunei Darussalam',
        'BG' => 'Bulgaria',
        'BF' => 'Burkina Faso',
        'BI' => 'Burundi',
        'KH' => 'Cambodia',
        'CM' => 'Cameroon',
        'CA' => 'Canada',
        'CV' => 'Cape Verde',
        'KY' => 'Cayman Islands',
        'CF' => 'Central African Republic',
        'TD' => 'Chad',
        'CL' => 'Chile',
        'CN' => 'China',
        'CX' => 'Christmas Island',
        'CC' => 'Cocos (Keeling) Islands',
        'CO' => 'Colombia',
        'KM' => 'Comoros',
        'CG' => 'Congo',
        'CD' => 'Congo, Democratic Republic',
        'CK' => 'Cook Islands',
        'CR' => 'Costa Rica',
        'CI' => 'Cote D\'Ivoire',
        'HR' => 'Croatia',
        'CU' => 'Cuba',
        'CY' => 'Cyprus',
        'CZ' => 'Czech Republic',
        'DK' => 'Denmark',
        'DJ' => 'Djibouti',
        'DM' => 'Dominica',
        'DO' => 'Dominican Republic',
        'EC' => 'Ecuador',
        'EG' => 'Egypt',
        'SV' => 'El Salvador',
        'GQ' => 'Equatorial Guinea',
        'ER' => 'Eritrea',
        'EE' => 'Estonia',
        'ET' => 'Ethiopia',
        'FK' => 'Falkland Islands (Malvinas)',
        'FO' => 'Faroe Islands',
        'FJ' => 'Fiji',
        'FI' => 'Finland',
        'FR' => 'France',
        'GF' => 'French Guiana',
        'PF' => 'French Polynesia',
        'TF' => 'French Southern Territories',
        'GA' => 'Gabon',
        'GM' => 'Gambia',
        'GE' => 'Georgia',
        'DE' => 'Germany',
        'GH' => 'Ghana',
        'GI' => 'Gibraltar',
        'GR' => 'Greece',
        'GL' => 'Greenland',
        'GD' => 'Grenada',
        'GP' => 'Guadeloupe',
        'GU' => 'Guam',
        'GT' => 'Guatemala',
        'GG' => 'Guernsey',
        'GN' => 'Guinea',
        'GW' => 'Guinea-Bissau',
        'GY' => 'Guyana',
        'HT' => 'Haiti',
        'HM' => 'Heard Island & Mcdonald Islands',
        'VA' => 'Holy See (Vatican City State)',
        'HN' => 'Honduras',
        'HK' => 'Hong Kong',
        'HU' => 'Hungary',
        'IS' => 'Iceland',
        'IN' => 'India',
        'ID' => 'Indonesia',
        'IR' => 'Iran, Islamic Republic Of',
        'IQ' => 'Iraq',
        'IE' => 'Ireland',
        'IM' => 'Isle Of Man',
        'IL' => 'Israel',
        'IT' => 'Italy',
        'JM' => 'Jamaica',
        'JP' => 'Japan',
        'JE' => 'Jersey',
        'JO' => 'Jordan',
        'KZ' => 'Kazakhstan',
        'KE' => 'Kenya',
        'KI' => 'Kiribati',
        'KR' => 'Korea',
        'KW' => 'Kuwait',
        'KG' => 'Kyrgyzstan',
        'LA' => 'Lao People\'s Democratic Republic',
        'LV' => 'Latvia',
        'LB' => 'Lebanon',
        'LS' => 'Lesotho',
        'LR' => 'Liberia',
        'LY' => 'Libyan Arab Jamahiriya',
        'LI' => 'Liechtenstein',
        'LT' => 'Lithuania',
        'LU' => 'Luxembourg',
        'MO' => 'Macao',
        'MK' => 'Macedonia',
        'MG' => 'Madagascar',
        'MW' => 'Malawi',
        'MY' => 'Malaysia',
        'MV' => 'Maldives',
        'ML' => 'Mali',
        'MT' => 'Malta',
        'MH' => 'Marshall Islands',
        'MQ' => 'Martinique',
        'MR' => 'Mauritania',
        'MU' => 'Mauritius',
        'YT' => 'Mayotte',
        'MX' => 'Mexico',
        'FM' => 'Micronesia, Federated States Of',
        'MD' => 'Moldova',
        'MC' => 'Monaco',
        'MN' => 'Mongolia',
        'ME' => 'Montenegro',
        'MS' => 'Montserrat',
        'MA' => 'Morocco',
        'MZ' => 'Mozambique',
        'MM' => 'Myanmar',
        'NA' => 'Namibia',
        'NR' => 'Nauru',
        'NP' => 'Nepal',
        'NL' => 'Netherlands',
        'AN' => 'Netherlands Antilles',
        'NC' => 'New Caledonia',
        'NZ' => 'New Zealand',
        'NI' => 'Nicaragua',
        'NE' => 'Niger',
        'NG' => 'Nigeria',
        'NU' => 'Niue',
        'NF' => 'Norfolk Island',
        'MP' => 'Northern Mariana Islands',
        'NO' => 'Norway',
        'OM' => 'Oman',
        'PK' => 'Pakistan',
        'PW' => 'Palau',
        'PS' => 'Palestinian Territory, Occupied',
        'PA' => 'Panama',
        'PG' => 'Papua New Guinea',
        'PY' => 'Paraguay',
        'PE' => 'Peru',
        'PH' => 'Philippines',
        'PN' => 'Pitcairn',
        'PL' => 'Poland',
        'PT' => 'Portugal',
        'PR' => 'Puerto Rico',
        'QA' => 'Qatar',
        'RE' => 'Reunion',
        'RO' => 'Romania',
        'RU' => 'Russian Federation',
        'RW' => 'Rwanda',
        'BL' => 'Saint Barthelemy',
        'SH' => 'Saint Helena',
        'KN' => 'Saint Kitts And Nevis',
        'LC' => 'Saint Lucia',
        'MF' => 'Saint Martin',
        'PM' => 'Saint Pierre And Miquelon',
        'VC' => 'Saint Vincent And Grenadines',
        'WS' => 'Samoa',
        'SM' => 'San Marino',
        'ST' => 'Sao Tome And Principe',
        'SA' => 'Saudi Arabia',
        'SN' => 'Senegal',
        'RS' => 'Serbia',
        'SC' => 'Seychelles',
        'SL' => 'Sierra Leone',
        'SG' => 'Singapore',
        'SK' => 'Slovakia',
        'SI' => 'Slovenia',
        'SB' => 'Solomon Islands',
        'SO' => 'Somalia',
        'ZA' => 'South Africa',
        'GS' => 'South Georgia And Sandwich Isl.',
        'ES' => 'Spain',
        'LK' => 'Sri Lanka',
        'SD' => 'Sudan',
        'SR' => 'Suriname',
        'SJ' => 'Svalbard And Jan Mayen',
        'SZ' => 'Swaziland',
        'SE' => 'Sweden',
        'CH' => 'Switzerland',
        'SY' => 'Syrian Arab Republic',
        'TW' => 'Taiwan',
        'TJ' => 'Tajikistan',
        'TZ' => 'Tanzania',
        'TH' => 'Thailand',
        'TL' => 'Timor-Leste',
        'TG' => 'Togo',
        'TK' => 'Tokelau',
        'TO' => 'Tonga',
        'TT' => 'Trinidad And Tobago',
        'TN' => 'Tunisia',
        'TR' => 'Turkey',
        'TM' => 'Turkmenistan',
        'TC' => 'Turks And Caicos Islands',
        'TV' => 'Tuvalu',
        'UG' => 'Uganda',
        'UA' => 'Ukraine',
        'AE' => 'United Arab Emirates',
        'GB' => 'United Kingdom',
        'US' => 'United States',
        'UM' => 'United States Outlying Islands',
        'UY' => 'Uruguay',
        'UZ' => 'Uzbekistan',
        'VU' => 'Vanuatu',
        'VE' => 'Venezuela',
        'VN' => 'Viet Nam',
        'VG' => 'Virgin Islands, British',
        'VI' => 'Virgin Islands, U.S.',
        'WF' => 'Wallis And Futuna',
        'EH' => 'Western Sahara',
        'YE' => 'Yemen',
        'ZM' => 'Zambia',
        'ZW' => 'Zimbabwe',
        );

//return to home page with  http-get method is used
public function returnHome(){
    return redirect()->route('home');
}

//search flight from seperate search flight search page
public function searchFormFlight(){

    //flight sector code
        //ini_set("max_execution_time",120);
        $wsdl              = 'http://dev.usbooking.org/us/UnitedSolutions?wsdl';
        $endpoint          =  array('location'=>'http://dev.usbooking.org/us/UnitedSolutions');
        $soapClient        = new \SoapClient($wsdl, $endpoint);
        $soapHeaders       = array();
        $namespace         = 'http://booking.us.org';
        $elementName = 'SectorCode';
        $authenticationHeader = array('strUserId' => 'UPEVES');
        // $authenticationHeader = array('strUserId' => 'UPEVES','strPassword'=>'PASSWORD','strAgencyId'=>'PLZ106','strSectorFrom'=>'KTM','strSectorTo'=>'PKR','strFlightDate'=>'25-FEB-2017','strReturnDate'=>'28-FEB-2017','strTripType'=>'R','strNationality'=>'NP','intAdult'=>'1','intChild'=>'0');
        $soapHeader = new \SoapHeader($namespace, $elementName, $authenticationHeader); $soapHeaders[] = $soapHeader; $soapClient->__setSoapHeaders($soapHeaders);

        $result = $soapClient->SectorCode($authenticationHeader);
        $res_xml = simplexml_load_string($result->return);
        $sector = $res_xml->Sector;

    return view('frontend.flight.flightsearch')
    ->with('class', 'home')
    ->with('sector', $sector)
    ->with('countries', $this->countries)
    ->with('meta_title', 'Flight Search | Upeverest')
    ->with('meta_keywords', 'Flight Search, Upeverest')
    ->with('meta_desc', 'Flight Search, Upeverest');
}

// function for flight search and display available flight
public function searchFlight(Request $request){
    if ($request->trip_type == 'R') {
     $this->validate($request, [
        'departure' => 'required',
        'arrival' => 'required',
        'date_depart' => 'required',
        'date_return' => 'required',
        'trip_type' => 'required',
        'adult' => 'required',
        'country' => 'required',
        ]);
 }else{
    $this->validate($request, [
        'departure' => 'required',
        'arrival' => 'required',
        'date_depart' => 'required',
        'trip_type' => 'required',
        'adult' => 'required',
        'country' => 'required',
        ]);
}
// return $request->all();
$departure = $request->departure;
$departureFull = $request->depart_full;
$arrival = $request->arrival;
$arrivalFull = $request->arrival_full;
$country = $request->country;
$date_depart = $request->date_depart;
$trip_type = $request->trip_type;
$adult = $request->adult;
$child = $request->child;
$infant = $request->infant;
if ($request->trip_type == 'R') {
    $date_return = $request->date_return;
}else{
    $request->request->add(['date_return' => '']);
    $date_return = $request->date_return;
}
$menus = Menu::where('parent_id', 0)->orderby('order')->get();
$meta_title= 'Choose a Flight | Upeverest';
$meta_keywords= 'Flight Booking, Upeverest';
$meta_desc= 'Flight Booking, Upeverest'; 
        // return $request->all();

        // $request->session()->put('departure', $request->departure);
        // $request->session()->put('arrival', $request->arrival);
        // $request->session()->put('date_depart', $request->date_depart);
        // $request->session()->put('trip_type', $request->trip_type);
        // $request->session()->put('adult', $request->adult);
        // $request->session()->put('child', $request->child);
        // $request->session()->put('infant', $request->infant);
        // $request->session()->put('date_return', $request->date_return);
        // return $request->all();

ini_set("max_execution_time",240);
$wsdl              = $this->strWsdl;
$endpoint          =  array('location'=>$this->strEndpoint);
$soapClient        = new \SoapClient($wsdl, $endpoint);
$soapHeaders       = array();
$namespace         = $this->strNamespace;
$elementName = 'FlightAvailability';

$authenticationHeader = array('strUserId' => $this->strUserId,'strPassword'=>$this->strPassword,'strAgencyId'=>$this->strAgencyId,'strSectorFrom'=>$request->departure,'strSectorTo'=>$request->arrival,'strFlightDate'=>$request->date_depart,'strReturnDate'=>$request->date_return,'strTripType'=>$request->trip_type,'strNationality'=>$request->country,'intAdult'=>$request->adult,'intChild'=>$request->child);
$soapHeader = new \SoapHeader($namespace, $elementName, $authenticationHeader); $soapHeaders[] = $soapHeader; $soapClient->__setSoapHeaders($soapHeaders);

$result = $soapClient->FlightAvailability($authenticationHeader);
$res_xml = simplexml_load_string($result->return);

$elementName = 'SectorCode';
$authenticationHeader = array('strUserId' => $this->strUserId);
$soapHeader = new \SoapHeader($namespace, $elementName, $authenticationHeader); $soapHeaders[] = $soapHeader; $soapClient->__setSoapHeaders($soapHeaders);

$result2 = $soapClient->SectorCode($authenticationHeader);
$res_xml2 = simplexml_load_string($result2->return);
$sector = $res_xml2->Sector;

foreach($sector as $sect){
    if ($sect->SectorCode == $departure) {
        $departureFull = ucfirst(strtolower($sect->SectorName));
        break;
    }
}

foreach($sector as $sect){
    if ($sect->SectorCode == $arrival) {
        $arrivalFull = ucfirst(strtolower($sect->SectorName));
        break;
    }
}

$outAvailability = $res_xml->Outbound->Availability;
$inAvailability = $res_xml->Inbound->Availability;

return view('frontend.flight.flightselection', compact('outAvailability', 'inAvailability', 'sector', 'departure', 'departureFull', 'arrival', 'arrivalFull', 'country', 'date_depart', 'date_return', 'trip_type', 'adult', 'child', 'infant', 'menus', 'meta_title', 'meta_keywords', 'meta_desc'))->with('class', 'home')->with('countries', $this->countries);
}

public function reviewFlight(Request $request){
 if ($request->tripType == 'R') {
     $this->validate($request, [
        'flightId' => 'required',
        'returnFlightId' => 'required',
        ]);
     $flightDetail = json_decode($request->flightDetail) ;
     $returnFlightDetail = json_decode($request->returnFlightDetail) ;
     $trip_type = 'R';
 }else{
    $this->validate($request, [
        'flightId' => 'required',
        ]);
    $flightDetail = json_decode($request->flightDetail) ;
    $returnFlightDetail = '' ;
    $trip_type = 'O';
}
$country = $request->country;
$departure = $request->departure;
$arrival = $request->arrival;
$menus = Menu::where('parent_id', 0)->orderby('order')->get();
$meta_title= 'Flight Review | Upeverest';
$meta_keywords= 'Flight Booking, Upeverest';
$meta_desc= 'Flight Booking, Upeverest'; 

return view('frontend.flight.flightreview', compact('flightDetail', 'returnFlightDetail', 'menus', 'meta_title', 'meta_keywords', 'meta_desc', 'country', 'trip_type', 'departure', 'arrival'))->with('class', 'home');

}

public function passengersFlight(Request $request){

    // return Crypt::decrypt($request->userId);

    // if( (!empty($request->username)) && (!empty($request->password)) ){
        
    // }

if ($request->tripType == 'R') {
     $this->validate($request, [
        'flightDetail' => 'required',
        'returnFlightDetail' => 'required',
        ]);
     $flightDetail = json_decode($request->flightDetail) ;
     $returnFlightDetail = json_decode($request->returnFlightDetail) ;
     $trip_type = 'R';
}else{
    $this->validate($request, [
        'flightDetail' => 'required',
        ]);
    $flightDetail = json_decode($request->flightDetail) ;
    $returnFlightDetail = '' ;
    $trip_type = 'O';
}
$country = $request->country;
$departure = $request->departure;
$arrival = $request->arrival;
// if(!empty($request->userId)){
//     if(Auth::check()){
//         if(Auth::user()->id == $request->userId){
//             $userId = $request->userId;
//         }else{
//             return redirect()->route('home');
//         }
//     }
// }else{
//     if(Auth::check()){
//         $userId = Auth::user()->id;
//     }
//     $userId = '';
// }
$menus = Menu::where('parent_id', 0)->orderby('order')->get();
    return view('frontend.flight.flightpassengerdetail', compact('menus', 'flightDetail', 'returnFlightDetail', 'trip_type', 'country', 'departure', 'arrival'))
    ->with('class', 'home')
    ->with('prevValidationJs', 'true')
    ->with('countries', $this->countries)
    ->with('meta_title', 'Flight Passengers Detail | Upeverest')
    ->with('meta_keywords', 'Flight Passengers Detail, Upeverest')
    ->with('meta_desc', 'Flight Passengers Detail, Upeverest');
}



public function passengersDetail(Request $request){
    // return $request->all();

    $adultCount = count($request->adult_fname);
    $childCount = count($request->child_fname);
    $time = time();
    $destination_path = 'images/flight-passenger/document';
    $random = str_random(10)."-".$time;


//validation
if($request->trip_type == 'R'){
   $validator = Validator::make($request->all(), [       
        'trip_type' => 'required',
        'flight_id' => 'required',
        'returnflight_id' => 'required',
        'flightDetail' => 'required',
        'returnFlightDetail' => 'required',
        // 'main_traveller' => 'required',
        // 'main_traveller_email' => 'required',
        // 'main_traveller_country' => 'required',
        'totalAmount' => 'required',
        ]);
}else{
    $validator = Validator::make($request->all(), [       
        'trip_type' => 'required',
        'flight_id' => 'required',
        'flightDetail' => 'required',
        // 'main_traveller' => 'required',
        // 'main_traveller_email' => 'required',
        // 'main_traveller_country' => 'required',
        'totalAmount' => 'required',
        ]);
}
    if ($validator->fails())
    {
        return redirect()->route('home');
    }


// return "1";

if($adultCount != 0){
    if(empty($request->main_traveller) ){
        return redirect()->route('home');
    }
    if( in_array("", $request->adult_title) ){
        return redirect()->route('home');
    }
    if( in_array("", $request->adult_fname) ){
        return redirect()->route('home');
    }
    if( in_array("", $request->adult_lname) ){
        return redirect()->route('home');
    }
    if( in_array("", $request->adult_document_type) ){
        return redirect()->route('home');
    }
    if( in_array("", $request->adult_document_no) ){
        return redirect()->route('home');
    }
    if( in_array("", $request->adult_nationality) ){
        return redirect()->route('home');
    }
    if( in_array("", $request->adult_email) ){
        return redirect()->route('home');
    }
    if( in_array("", $request->adult_phone_type) ){
        return redirect()->route('home');
    }
    if( in_array("", $request->adult_phone_no) ){
        return redirect()->route('home');
    }
}

// return "2";

if($childCount != 0){
    if($adultCount == 0){
        if(empty($request->main_child_traveller)){
            // return $request->main_child_traveller;
            return redirect()->route('home');
        }
    }

    // return "3";

    if( in_array("", $request->child_title) ){
        return redirect()->route('home');
    }
    if( in_array("", $request->child_fname) ){
        return redirect()->route('home');
    }
    if( in_array("", $request->child_lname) ){
        return redirect()->route('home');
    }
    if( in_array("", $request->child_dob_year) ){
        return redirect()->route('home');
    }
    if( in_array("", $request->child_dob_month) ){
        return redirect()->route('home');
    }
    if( in_array("", $request->child_dob_day) ){
        return redirect()->route('home');
    }
    if( in_array("", $request->child_document_type) ){
        return redirect()->route('home');
    }
    if( in_array("", $request->child_document_no) ){
        return redirect()->route('home');
    }
    if( in_array("", $request->child_nationality) ){
        return redirect()->route('home');
    }
    if( in_array("", $request->child_email) ){
        return redirect()->route('home');
    }
    if( in_array("", $request->child_phone_type) ){
        return redirect()->route('home');
    }
    if( in_array("", $request->child_phone_no) ){
        return redirect()->route('home');
    }
   
}
// return "here";
//getting userid
    if (Auth::check()) {
       $userId = Auth::user()->id;
    }else{
        $userId = '';
    }



//storing flight reservation detail in db
    $flightReservation = FlightReservation::create([
        'group_id'=> $random,
        'user_id'=> $userId,
        'return_type'=> $request->trip_type,
        'flight_id'=> $request->flight_id,
        'returnflight_id'=> $request->returnflight_id,
        'total_amount'=> $request->totalAmount,
        'flight_detail'=> $request->flightDetail,
        'returnflight_detail'=> $request->returnFlightDetail,
    ]); 


//storing adult(normal and main traveller) info 

    $files = $request->file('adult_document_image');
            $k = 0;

        if(!empty($files)){

            while($k < $adultCount){
                if(!empty($files[$k])){
                    $filename[$k] = $time. '-'.str_random(4).'-' . $files[$k]->getClientOriginalName();
                    $files[$k]->move($destination_path, $filename[$k]);
                }else{
                    $filename[$k] = '';
                }
                $k++;
            }
        }else{
            $filename[$k] = '';
        }

// return "a sdf dsa";

        $j = 0;
        while($j < $adultCount){
            if($request->main_traveller == (string)($j+1)){
                $mainTraveller = $flightReservation->mainTraveller()->create([
                    "group_id" => $random,
                    "user_id" => $userId,
                    "type" => 'flight',
                    "person_type" => 'adult',
                ]);

                $mainTraveller->profile()->create([
                    // "user_id" => $userId,
                    "group_id" => $random,
                    "title" => $request->adult_title[$j],
                    "fname" => $request->adult_fname[$j],
                    "mname" => $request->adult_mname[$j],
                    "lname" => $request->adult_lname[$j],
                        // "email" => $request->main_traveller_email,  //extra information for main traveller
                        // "phone_type" => $request->main_traveller_phonetype,  //extra information for main traveller
                        // "phone" => $request->main_traveller_phone,  //extra information for main traveller
                    // "dob_year" => $request->adult_dob_year[$i],
                    // "dob_month" => $request->adult_dob_month[$i],
                    // "dob_day" => $request->adult_dob_day[$i],
                    "document_type" => $request->adult_document_type[$j],
                    "document_no" => $request->adult_document_no[$j],
                    "document_img" => $filename[$j],
                    "nationality" => $request->adult_nationality[$j],  
                    "email" => $request->adult_email[$j],  
                    "phone_type" => $request->adult_phone_type[$j],  
                    "phone" => $request->adult_phone_no[$j],  
                    // "issue_year" => $request->adult_issue_year[$i],
                    // "issue_month" => $request->adult_issue_month[$i],
                    // "issue_day" => $request->adult_issue_day[$i],
                    // "issue_country" => $request->adult_issue_country[$i],
                        // "em_fname" => $request->em_fullname,  //extra information for main traveller
                        // "em_lname" => '',  //extra information for main traveller
                        // "em_country" => $request->em_country,  //extra information for main traveller
                        // "em_phone_type" => $request->em_phonetype,  //extra information for main traveller
                        // "em_phone" => $request->em_phone,  //extra information for main traveller
                        // "em_email" => $request->em_email,  //extra information for main traveller

                ]);
            }
            $j++;
        }

    $i = 0;
    while($i < $adultCount){

        // $files = $request->file('adult_document_image');
        // if(!empty($files)){

        //     $k = 0;
        //     while($k < $adultCount){
        //         if(!empty($files[$k])){
        //             $filename[$k] = $time. '-'.str_random(4).'-' . $files[$k]->getClientOriginalName();
        //             $files[$k]->move($destination_path, $filename[$k]);
        //         }else{
        //             $filename[$k] = '';
        //         }
        //         $k++;
        //     }
        // }else{
        //     $filename[$k] = '';
        // }

        


        // if($request->main_traveller == (string)($i+1)){
        //     $adultTravellers[$i] = $flightReservation->mainTraveller()->create([
        //         "group_id" => $random,
        //         "user_id" => $userId,
        //         // "person_type" => 'main',
        //         "type" => 'flight',
        //         // "title" => $request->adult_title[$i],
        //         // "fname" => $request->adult_fname[$i],
        //         // "mname" => $request->adult_mname[$i],
        //         // "lname" => $request->adult_lname[$i],
        //         //     "email" => $request->main_traveller_email,  //extra information for main traveller
        //         //     "phone_type" => $request->main_traveller_phonetype,  //extra information for main traveller
        //         //     "phone" => $request->main_traveller_phone,  //extra information for main traveller
        //         // "dob_year" => $request->adult_dob_year[$i],
        //         // "dob_month" => $request->adult_dob_month[$i],
        //         // "dob_day" => $request->adult_dob_day[$i],
        //         // "passport" => $request->adult_passport[$i],
        //         // "passport_img" => $filename,
        //         //     "nationality" => $request->main_traveller_country,  //extra information for main traveller
        //         // "issue_year" => $request->adult_issue_year[$i],
        //         // "issue_month" => $request->adult_issue_month[$i],
        //         // "issue_day" => $request->adult_issue_day[$i],
        //         // "issue_country" => $request->adult_issue_country[$i],
        //         //     "em_fname" => $request->em_fullname,  //extra information for main traveller
        //         //     "em_lname" => '',  //extra information for main traveller
        //         //     "em_country" => $request->em_country,  //extra information for main traveller
        //         //     "em_phone_type" => $request->em_phonetype,  //extra information for main traveller
        //         //     "em_phone" => $request->em_phone,  //extra information for main traveller
        //         //     "em_email" => $request->em_email,  //extra information for main traveller

        //     ]);
        // }

        if($request->main_traveller != (string)($i+1)){
            $adultOtherTravellers[$i] = $mainTraveller->otherTravellers()->create([
                "group_id" => $random,
                "person_type" => 'adult',
                // "type" => 'flight',
            ]);

            $adultOtherTravellers[$i]->profile()->create([
                // "user_id" => $userId,
                "group_id" => $random,
                "title" => $request->adult_title[$i],
                "fname" => $request->adult_fname[$i],
                "mname" => $request->adult_mname[$i],
                "lname" => $request->adult_lname[$i],
                    // "email" => $request->main_traveller_email,  //extra information for main traveller
                    // "phone_type" => $request->main_traveller_phonetype,  //extra information for main traveller
                    // "phone" => $request->main_traveller_phone,  //extra information for main traveller
                // "dob_year" => $request->adult_dob_year[$i],
                // "dob_month" => $request->adult_dob_month[$i],
                // "dob_day" => $request->adult_dob_day[$i],
                "document_type" => $request->adult_document_type[$i],
                "document_no" => $request->adult_document_no[$i],
                "document_img" => $filename[$i],
                "nationality" => $request->adult_nationality[$i],  
                "email" => $request->adult_email[$i],
                "phone_type" => $request->adult_phone_type[$i], 
                "phone" => $request->adult_phone_no[$i],  
                // "issue_year" => $request->adult_issue_year[$i],
                // "issue_month" => $request->adult_issue_month[$i],
                // "issue_day" => $request->adult_issue_day[$i],
                // "issue_country" => $request->adult_issue_country[$i],
                    // "em_fname" => $request->em_fullname,  //extra information for main traveller
                    // "em_lname" => '',  //extra information for main traveller
                    // "em_country" => $request->em_country,  //extra information for main traveller
                    // "em_phone_type" => $request->em_phonetype,  //extra information for main traveller
                    // "em_phone" => $request->em_phone,  //extra information for main traveller
                    // "em_email" => $request->em_email,  //extra information for main traveller

                ]);

        }
        $i++;
    }


// return "end of adult";

//storing child info

    $files = $request->file('child_document_image');
        $k = 0;
        if(!empty($files)){

            while($k < $childCount){
                if(!empty($files[$k])){
                    $filename2[$k] = $time. '-'.str_random(4).'-' . $files[$k]->getClientOriginalName();
                    $files[$k]->move($destination_path, $filename2[$k]);
                }else{
                    $filename2[$k] = '';
                }
                $k++;
            }
        }else{
            $filename2[$k] = '';
        }

// return "image";

    $j = 0;
    if(!empty($request->main_child_traveller)){
        while($j < $childCount){
            if($request->main_child_traveller == (string)($j+1)){
                $mainTraveller = $flightReservation->mainTraveller()->create([
                    "group_id" => $random,
                    "user_id" => $userId,
                    "type" => 'flight',
                    "person_type" => 'child',
                ]);

                $mainTraveller->profile()->create([
                    // "user_id" => $userId,
                    "group_id" => $random,
                    "title" => $request->child_title[$j],
                    "fname" => $request->child_fname[$j],
                    "mname" => $request->child_mname[$j],
                    "lname" => $request->child_lname[$j],
                    "document_type" => $request->child_document_type[$j],
                    "document_no" => $request->child_document_no[$j],
                    "document_img" => $filename2[$j],
                    "dob_year" => $request->child_dob_year[$j],
                    "dob_month" => $request->child_dob_month[$j],
                    "dob_day" => $request->child_dob_day[$j],
                    "nationality" => $request->child_nationality[$j],  
                    "email" => $request->child_email[$j],  
                    "phone_type" => $request->child_phone_type[$j],  
                    "phone" => $request->child_phone_no[$j],  
                ]);
            }
            $j++;
        }
    }

// return  "yuyuy";

    $i = 0;
    while($i < $childCount){

        // $files = $request->file('child_document_image');
        // if(!empty($files)){
        //     if(!empty($files[$i])){
        //         $filename = $time. '-'.str_random(4).'-'. $files[$i]->getClientOriginalName();
        //         $files[$i]->move($destination_path, $filename);
        //     }else{
        //         $filename = '';
        //     }
        // }else{
        //     $filename = '';
        // }

        if($request->main_child_traveller != (string)($i+1)){
            $childOtherTravellers[$i] = $mainTraveller->otherTravellers()->create([
                "group_id" => $random,
                "person_type" => 'child',
                // "type" => 'flight',
            ]);

            $childOtherTravellers[$i]->profile()->create([
                // "user_id" => $userId,
                "group_id" => $random,
                "title" => $request->child_title[$i],
                "fname" => $request->child_fname[$i],
                "mname" => $request->child_mname[$i],
                "lname" => $request->child_lname[$i],
                "document_type" => $request->child_document_type[$i],
                "document_no" => $request->child_document_no[$i],
                "document_img" => $filename2[$i],
                "nationality" => $request->child_nationality[$i],  
                "dob_year" => $request->child_dob_year[$i],
                "dob_month" => $request->child_dob_month[$i],
                "dob_day" => $request->child_dob_day[$i],
                "email" => $request->child_email[$i], 
                "phone_type" => $request->child_phone_type[$i],  
                "phone" => $request->child_phone_no[$i],  

                ]);
        }
            // $childTravellers[$i] = $flightReservation->travellers()->create([
            // "group_id" => $random,
            // "person_type" => "child",
            // "type" => "flight",
            // "title" => $request->child_title[$i],
            // "fname" => $request->child_fname[$i],
            // "mname" => $request->child_mname[$i],
            // "lname" => $request->child_lname[$i],
            // "dob_year" => $request->child_dob_year[$i],
            // "dob_month" => $request->child_dob_month[$i],
            // "dob_day" => $request->child_dob_day[$i],
            // "passport" => $request->child_passport[$i],
            // "passport_img" => $filename,
            // "issue_year" => $request->child_issue_year[$i],
            // "issue_month" => $request->child_issue_month[$i],
            // "issue_day" => $request->child_issue_day[$i],
            // "issue_country" => $request->child_issue_country[$i],
            // ]);
        $i++;
    }    

    // return "zzzz";   

    $menus = Menu::where('parent_id', 0)->orderby('order')->get();
    return view('frontend.flight.flightpayment', compact('menus'))
    ->with('class', 'home')
    ->with('countries', $this->countries)
    ->with('meta_title', 'Flight Payment | Upeverest')
    ->with('meta_keywords', 'Flight Payment, Upeverest')
    ->with('meta_desc', 'Flight Payment, Upeverest')
    ->with('flightDetail', json_decode($request->flightDetail))
    ->with('returnFlightDetail', json_decode($request->returnFlightDetail))
    ->with('trip_type', $request->trip_type)
    ->with('country', $request->country)
    ->with('departure', $request->departure)
    ->with('arrival', $request->arrival);
    
}


}