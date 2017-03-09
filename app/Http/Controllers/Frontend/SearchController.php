<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\User\UserContract;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Models\Access\User\User;
use DB;
use Carbon\Carbon;
use App\Models\Summitteers;
/**
 * Class SearchController
 * @package App\Http\Controllers
 */
class SearchController extends Controller {

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


	public function index(Request $request)
	{
           
        $sliders = '';
        //return view('frontend.index',['sliders'=>$sliders])->withClass('home')->with('page', $page)->with('menus', $menu);
		return view('frontend.searchResults',['sliders'=>$sliders])->withClass('home');
	}

        public function summitteers(Request $request){
            
            
                    
                    $name = $request->input('name');
                    $country = $request->input('country');
                    $year = $request->input('year');

                    $whereArray = array();

                   
                    
                    $whereLike = '';

                    $summitteers = Summitteers::select('*');
                    
                     if (!empty($name) && $name != '') {
                        $summitteers = $summitteers->where('name', 'like', '%' . $name . '%');
                    }

                    if (!empty($year) && $year != 'Year') {
                        $summitteers = $summitteers->where('date', 'like', '%' . $year . '%');
                    }
                    
                    if (!empty($country) && $country != 'Country') {
                        $summitteers = $summitteers->where('country', 'like', '%' . $country . '%');
                       
                    }

                    $summitteers = $summitteers->orderby('name', 'asc')->get();
                    
                    
                    
                    if($summitteers){
                        
                        return view('frontend.sumitterSearch')->with('summitteers', $summitteers);
                    }
                    else echo '';
                            
                   
            
            
        }
        
        

        public function autocompletesearch(Request $request,$value = ''){
        
           /* $row_set = array('akash','apeksha');
            echo json_encode($row_set);
            */
            
            
            $searchText = $request->input('searchText');
            if($searchText){
               
              $innerPages = DB::table('linksearch')
                          ->select('keyword','url')
                          ->where('keyword','like','%'.$searchText.'%')
                          ->orWhere('url','like','%'.$searchText.'%')
                          ->get();
                
            }else
            $innerPages = DB::table('linksearch')->select('keyword','url')->get();
            //{ label: "Choice1", value: "value1" }
            
            echo json_encode($innerPages);
            die;
            $innerPagesText = array();
            foreach($innerPages as $row){

            $innerPagesText['label'] = $row->keyword;
            $innerPagesText['value'] = $row->keyword;

            }

            echo json_encode($innerPagesText);

        /*    
        $keywords = Input::get('query');
        $suggestions['suggestions'] = '';

        $type = Input::get('type');
        if ($type == 'name') {
            $suggestions['suggestions'] = User::where('fname', 'LIKE', '%' . $keywords . '%')->lists('fname');
        }
        return response()->json($suggestions);
         * 
         * 
         */
    }
}