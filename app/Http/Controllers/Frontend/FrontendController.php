<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Page;
use App\Models\Menu;
use App\Models\InnerPage;
use App\Models\StaticBlock;
use App\Models\Summitteers;
use App\Models\Packages;
use App\Models\PackageGallery;
use App\Models\Promocode;
use App\Repositories\Frontend\User\UserContract;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use DB;
use Input;
use Mail;
use Illuminate\Http\Request;
use Illuminate\View\Middleware\ShareErrorsFromSession;

/**
 * Class FrontendController
 * @package App\Http\Controllers
 */
class FrontendController extends Controller {
    /**
     * @return \Illuminate\View\View
     */

    /**
     * @var UserContract
     */
    protected $users;

    public function __construct(UserContract $users) {
        $this->users = $users;
    }

    public function index(Request $request) {
        $menu = Menu::where('parent_id', 0)->orderby('order')->get();
        $sliders = DB::table('gallerys')
                ->Where('type', 'slider')
                ->get();
        
        $page = InnerPage::where('id', 1)->get();
        
        foreach ($page as $pag) {
           $meta_title= $pag->meta_title;
           $meta_keywords =$pag->meta_key;
           $meta_desc =$pag->meta_desc;
           $title =$pag->title;
        }
        
        // dd(\Session::all());

        $searchText = $request->input('q');
        if ($searchText) {
            
        }


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
        // $res_xml = simplexml_load_string($result->return);
        $res_xml = simplexml_load_string($result->return);
        // echo "<pre>";
        // var_dump($result);
        // var_dump($result);
        // // echo "<pre>";
        // die();

        $sector = $res_xml->Sector;

        // $tmp = $sector->pluck('SectorCode', 'SectorCode');

        // var_dump($sector);
        // var_dump($sector[3]);
        // die();
        // foreach ($sector as $sect) {
        //     echo "<pre>";
        // // var_dump($result);
        // var_dump($sect->SectorCode);
        // echo "<pre>";
        // }
        // die();

        // // $sector = $res_xml->Sector->pluck('SectorName', 'SectorCode');
        // return $sector;

$countries = array
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
        
        return view('frontend.index', ['sliders' => $sliders])->withClass('home')
        ->with('page', $page)
        ->with('menus', $menu)
        ->with('meta_title', $meta_title)
        ->with('meta_keywords', $meta_keywords) 
        ->with('meta_desc', $meta_desc)
        ->with('title', $title)                                 
        ->with('sector', $sector)                                 
        ->with('countries', $countries)                                 
        ;
        
//        return view('frontend.index', ['sliders' => $sliders])->withClass('home')->with('page', $page)->with('menus', $menu);
    }

    public function page(Request $request, $slug) {
        $menus = Menu::where('parent_id', 0)->orderby('order')->get();
        $page = Page::where('slug', $slug)->first();
        
        $innerpage = InnerPage:: where('slug', $slug)->first();    
       // var_dump($innerpage); die();  
        
        // for global SEO detail
        if(!empty($innerpage)){
        $meta_title= $innerpage->meta_title;
        $meta_keywords= $innerpage->meta_key;
        $meta_desc= $innerpage->meta_desc; 
        $title= $innerpage->title;
    }


        if (!empty($page)) {
            $meta_title= $page->meta_title;
            $meta_keywords= $page->meta_key;
            $meta_desc= $page->meta_desc; 
            $title= $page->title;
            $static = \DB::table('static_blocks')->where('pid', $page->id)->get();           

//            return view('frontend.page', compact('page', 'menus', 'static'))->withClass($slug . '-page');
            return view('frontend.page', compact('page', 'menus', 'static', 'meta_title','meta_keywords','meta_title', 'title'))->withClass($slug . '-page')
            ->with('meta_title', $meta_title)
            ->with('meta_keywords', $meta_keywords)
            ->with('meta_desc', $meta_desc)
            ->with('title', $title);
        } else {

            $page = InnerPage::where('slug', $slug)->where('id', '!=', 1)->first();           

            if (!$page) {
                throw new NotFoundHttpException;
            } else {
// added code for slug trekking --yojan--

                if ($slug == 'trekking') {




                    // return $title;
                    $packages = Packages::where('status', 1)->where('pack_type', 'main')->get();
                     return view('frontend.new.trekking', compact('packages','page', 'menus'))->withClass($slug . '-page')
                     ->with('meta_title', $meta_title)
                    ->with('meta_keywords', $meta_keywords)
                    ->with('meta_desc', $meta_desc)
                    ->with('title', $title);
                }
//end of added code for slug trekking --yojan--

                if ($slug == 'summitteers') {

                    $name = $request->input('name');
                    $country = $request->input('country');
                    $year = $request->input('year');

                    $whereArray = array();

                    if (!empty($name) && $name != '') {
                        $whereArray['name'] = $name;
                    }

                    if (!empty($country) && $country != 'Country') {
                        $whereArray['country'] = $country;
                    }
                    $whereLike = '';

                    $summitteers = Summitteers::where($whereArray);

                    if (!empty($year) && $year != 'Year') {
                        $summitteers = $summitteers->where('date', 'like', '%' . $year . '%');
                    }

                    $summitteers = $summitteers->orderby('name', 'asc')->get();
                    /* $users = DB::table('users')->where([
                      ['status', '=', '1'],
                      ['subscribed', '<>', '1'],
                      ])->get();
                     */





//                    $static = \DB::table('static_blocks')->where('pid', $page->id)->get();
//                    return view('frontend.sumitter', compact('page', 'summitteers', 'static', 'menus'))->withClass($slug . '-page');
//                } elseif ($slug == 'classic-everest') {
//                    $static = \DB::table('static_blocks')->where('pid', $page->id)->get();
//                    return view('frontend.classic', compact('page', 'static', 'menus'))->withClass($slug . '-page');
//                }
//
//                $static = \DB::table('static_blocks')->where('pid', $page->id)->get();
//                return view('frontend.everest', compact('page', 'static', 'menus'))->withClass($slug . '-page');
                    
                // edited by Ishwar - 3hammers    
                    $static = \DB::table('static_blocks')->where('pid', $page->id)->get();
                    return view('frontend.sumitter', compact('page', 'summitteers', 'static', 'menus', 'meta_title', 'meta_keywords', 'meta_desc'))->withClass($slug . '-page')
                     ->with('meta_title', $meta_title)
                     ->with('meta_keywords', $meta_keywords)
                    ->with('meta_desc', $meta_desc)
                    ->with('title', $title);
                    
                } elseif ($slug == 'classic-everest') {                    
                    $static = \DB::table('static_blocks')->where('pid', $page->id)->get();
                    return view('frontend.classic', compact('page', 'static', 'menus', 'meta_title', 'meta_keywords', 'meta_desc'))->withClass($slug . '-page')
                     ->with('meta_title', $meta_title)
                    ->with('meta_keywords', $meta_keywords)
                    ->with('meta_desc', $meta_desc)
                    ->with('title', $title);
                }          


                $static = \DB::table('static_blocks')->where('pid', $page->id)->get();
                return view('frontend.everest', compact('page', 'static', 'menus', 'meta_title', 'meta_title'))->withClass($slug . '-page')
                 ->with('meta_title', $meta_title)
                 ->with('meta_keywords', $meta_keywords)
                 ->with('meta_desc', $meta_desc)
                ->with('title', $title);
            }
        }
    }


    public function page2(Request $request, $part1, $part2) {
        $menus = Menu::where('parent_id', 0)->orderby('order')->get();
        $slug = $part1.'/'.$part2;
        // return $slug;
        $page = Page::where('slug', $slug)->first();
        
        $innerpage = InnerPage:: where('slug', $slug)->first();    
       // var_dump($innerpage); die();  
        
        // for global SEO detail
        if(!empty($innerpage)){
        $meta_title= $innerpage->meta_title;
        $meta_keywords= $innerpage->meta_key;
        $meta_desc= $innerpage->meta_desc; 
        $title= $innerpage->title;
    }


        if (!empty($page)) {
            $meta_title= $page->meta_title;
            $meta_keywords= $page->meta_key;
            $meta_desc= $page->meta_desc; 
            $title= $page->title;
            $static = \DB::table('static_blocks')->where('pid', $page->id)->get();           

//            return view('frontend.page', compact('page', 'menus', 'static'))->withClass($slug . '-page');
            return view('frontend.page', compact('page', 'menus', 'static', 'meta_title','meta_keywords','meta_title', 'title'))->withClass($slug . '-page')
            ->with('meta_title', $meta_title)
            ->with('meta_keywords', $meta_keywords)
            ->with('meta_desc', $meta_desc)
            ->with('title', $title);
        } else {

            $page = InnerPage::where('slug', $slug)->where('id', '!=', 1)->first();           

            if (!$page) {
                throw new NotFoundHttpException;
            } else {

                $static = \DB::table('static_blocks')->where('pid', $page->id)->get();
                return view('frontend.everest', compact('page', 'static', 'menus', 'meta_title', 'meta_title'))->withClass($slug . '-page')
                 ->with('meta_title', $meta_title)
                 ->with('meta_keywords', $meta_keywords)
                 ->with('meta_desc', $meta_desc)
                ->with('title', $title);
            }
        }
    }

    public function page3(Request $request, $part1, $part2, $part3) {
        $menus = Menu::where('parent_id', 0)->orderby('order')->get();
        $slug = $part1.'/'.$part2.'/'.$part3;
        // return $slug;
        $page = Page::where('slug', $slug)->first();
        
        $innerpage = InnerPage:: where('slug', $slug)->first();    
       // var_dump($innerpage); die();  
        
        // for global SEO detail
        if(!empty($innerpage)){
        $meta_title= $innerpage->meta_title;
        $meta_keywords= $innerpage->meta_key;
        $meta_desc= $innerpage->meta_desc; 
        $title= $innerpage->title;
    }


        if (!empty($page)) {
            $meta_title= $page->meta_title;
            $meta_keywords= $page->meta_key;
            $meta_desc= $page->meta_desc; 
            $title= $page->title;
            $static = \DB::table('static_blocks')->where('pid', $page->id)->get();           

//            return view('frontend.page', compact('page', 'menus', 'static'))->withClass($slug . '-page');
            return view('frontend.page', compact('page', 'menus', 'static', 'meta_title','meta_keywords','meta_title', 'title'))->withClass($slug . '-page')
            ->with('meta_title', $meta_title)
            ->with('meta_keywords', $meta_keywords)
            ->with('meta_desc', $meta_desc)
            ->with('title', $title);
        } else {

            $page = InnerPage::where('slug', $slug)->where('id', '!=', 1)->first();           

            if (!$page) {
                throw new NotFoundHttpException;
            } else {

                $static = \DB::table('static_blocks')->where('pid', $page->id)->get();
                return view('frontend.everest', compact('page', 'static', 'menus', 'meta_title', 'meta_title'))->withClass($slug . '-page')
                 ->with('meta_title', $meta_title)
                 ->with('meta_keywords', $meta_keywords)
                 ->with('meta_desc', $meta_desc)
                ->with('title', $title);
            }
        }
    }



    /**
     * @return \Illuminate\View\View
     */
    public function macros() {
        return view('frontend.macros');
    }

    public function submitContact(Request $request) {

        $this->validate($request, array(
            'name' => 'required',
            'email' => 'email|required',
            'message' => 'required',
            'g-recaptcha-response' => 'required',
            ),
            array('g-recaptcha-response.required' => 'Captcha is required !')
        );
        $form_url = '<strong>' . $request->input('pageheading') . '</strong>';
        $contactno = '';
        if ($request->input('contactno'))
            $contactno = '<br />Phone : ' . $request->input('contactno') . '<br />';

        $nationality = '';

        if ($request->input('nationality'))
            $nationality = '<br />Nationality : ' . $request->input('nationality') . '<br />';

        $subject = 'Email alert for Upeverest from ' . $request->input('name');
        $short_message = $request->input('name') . ' Has Contacted You from ' .$form_url;
        $message = 'Hi Admin,<br /><br />' . $short_message .'<br />'.
                '<br />Name : ' . $request->input('name') .
                '<br />Email : ' . $request->input('email') .
                $nationality .
                $contactno . '<br/>Below is the message : <br/>' . $request->input('message')
                . '<br /><br /><br />Upeverest Mail Robot';

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: ' . $request->input('name') . '<' . $request->input('email') . '>' . "\r\n";

 
        mail('rupen@upeverest.com', $subject, $message, $headers);
        mail('sanjeev@upeverest.com', $subject, $message, $headers);
        //mail('dinesh@3hammers.com', $subject, $message, $headers);

        //$request->session()->flash('alert-success', 'User was successful added!');
        \Session::flash('message', 'Thank you for your enquire !');
        return redirect()->back()->withFlashSuccess('Successfully added.');
    }

public function generateRandomString($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

public function generatePromoCode(Request $request){
    // return $request->fullname;
if($request->ajax()){
    parse_str($_POST['data'], $user);
// $promocode = md5(uniqid(mt_rand(), true));
$promocode = $this->generateRandomString();
// return $promocode;
$user['promocode'] = $promocode;

//insert into db
$db = Promocode::create([
        'fullname'=> $user['fullname'],
        'valentine_fullname'=> $user['valentine_fullname'],
        'contact'=> $user['contact'],
        'email'=> $user['email'],
        'promocode'=> $promocode,
    ]);

$setting = Setting::first();
if(!empty($setting)){
$adminEmail = $setting->adminEmail;
// return $adminEmail;

// send email to user
Mail::send('frontend.promocode.email',['user' => $user], function($message) use ($user) {
         $message->from('noreply@upeverest.com', 'Up Everest')
            ->to($user['email'], $user['fullname'])
            ->subject('Your Promo Code to purchase package');
        });

// send email to admin
Mail::send('frontend.promocode.adminpromonotify',['user' => $user], function($message) use ($user, $adminEmail) {
         $message->from('noreply@upeverest.com', 'Up Everest')
            ->to('sanjeev@avdigitals.com', 'Admin')
            ->cc('rupen@appliedvalue.com.np', 'Admin')
            ->bcc('yankey@upeverest.com', 'Admin')
            ->subject('Promo Code is sent to user');
        });
return "success";
}

}
return "error";
}

}
