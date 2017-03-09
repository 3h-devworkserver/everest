<?php namespace App\Http\Controllers\Frontend\Guide;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\User\UserContract;
use Illuminate\Http\Request;
use App\Http\Requests\Frontend\User\ReviewRequest;
use App\Models\Review;
use Datatable;
use App\Models\Setting;
use App\Http\Requests\Frontend\User\EmailRequest;
use App\Http\Requests\Frontend\User\GuideSettingsRequest;
/**
 * Class GuideController
 * @package App\Http\Controllers\Frontend
 */
class GuideController extends Controller {

	/**
	 * @param UserContract $user
	 */
	public function __construct(UserContract $user) {
		$this->user = $user;
	}

	public function getSettings(){
		$user = access()->user();
		return view('frontend.guide.settings', compact('user'))->withClass('guide-settings');
	}

	public function postSettings(GuideSettingsRequest $request) {
		$this->user->changePassword($request->all());
		return redirect()->route('frontend.guide.settings')->withFlashSuccess(trans("strings.settings_successfully_updated"));
	}

	public function updateEmailSettings(Request $request)
	{
		$data['stat']='error';
		$this->validate($request, [
	        'email' => 'required|unique:users'
    	]);
		$email = $this->user->changeEmail($request->all());
		if($email){
			$data['stat']='ok';
			$data['value'] = $request['email'];
			return response()->json($data);
		}

		return response()->json($data);
	}
	
	/**
	 * @return mixed
	 */

	public function getProfile($username, Request $request) {
		 $guide = $this->user->getGuide($username);
		 $bookedDates = $this->user->getBookingDates();
		 javascript()->put([
            'guidePrice' => $guide->price,
            'serviceCharge' => Setting::first()->charges,
            'bookedDates' => $bookedDates
        ]);
		// Get all reviews that are not spam for the product and paginate them
		 $reviews = $guide->reviews()->approved()->notSpam()->orderBy('created_at', 'desc')->paginate(5);
		 if ($request->ajax()) {
            $html = view('frontend.guide.review-list')->with('reviews', $reviews)->render();
            return response()->json(array('success' => true, 'html' => $html));
        }
		 $recentreviews = $guide->reviews()->approved()->notSpam()->orderBy('created_at', 'desc')->take(config('access.recent_reviews_count'))->get();
		 return view('frontend.guide.profile',['reviews'=>$reviews,'recentreviews'=>$recentreviews])->withGuide($guide)->withClass('guide-profile');
		
	}


	public function postReview($username, ReviewRequest $request, Review $review) {
		$guide = $this->user->getGuide($username);
		$review->storeReviewForGuide($guide, $request->get('comment'), $request->get('rating'));
		return redirect()->to('#reviews-anchor')->withFlashSuccess('Your review is send for approval.');
	}

	public function getReviews(){
		$guide = $this->user->getGuide(auth()->user()->username);
		$table = $this->setDatatable();
		return view('frontend.guide.review-edit',compact('guide','table'))->withClass('reviews');
	}

	public function approveReview($id,$status){
		$review = Review::find($id);
		$review->approved= $status;
		if($review->save())
			return redirect()->back()->withFlashSuccess('Successfully review approved.');
		return redirect()->back()->withFlashDanger('Error during approve process');
	}

	public function deleteReview($id){
		$review = Review::find($id);
		if($review->delete())
			return redirect()->back()->withFlashSuccess('Successfully deleted reviews.');
	}

	     /**
     * Create DataTable HTML
     *
     * @return mixed
     * @throws \Exception
     */
    private function setDatatable()
    {
            $route = route('api.table.guide.reviews');

            return Datatable::table()
            ->addColumn('id','Reviews','Status','Created Date')
            ->addColumn(trans('crud.actions'))
            ->setUrl($route)
            ->setOptions(['oLanguage' => trans('crud.datatables')])
            ->render();
		}
}