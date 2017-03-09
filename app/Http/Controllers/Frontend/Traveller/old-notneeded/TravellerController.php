<?php namespace App\Http\Controllers\Frontend\Traveller;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\User\UserContract;
use App\Http\Requests\Frontend\User\BookingRequest;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Setting;
use App\Exceptions\GeneralException;
use URL;


/**
 * Class TravellerController
 * @package App\Http\Controllers\Frontend
 */


class TravellerController extends Controller {


	/**
	 * @param UserContract $user
	 */
	public function __construct(UserContract $user) {
		$this->user = $user;
	}

	/**
	 * @return mixed
     */
	public function getActivity()
	{
		$bookings = Booking::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
		return view('frontend.traveller.activity', compact('bookings'))->withClass('activity');
	}

	/**
	 * @return mixed
     */
	public function getPaymentProcess()
	{
		return view('frontend.payment-process')->withClass('paymentArea');
	}

	public function postBookingProcess(BookingRequest $request)
	{
		// dd($request['bookTo']);
		if ($request->ajax()) abort(403, 'Forbidden');
		$message['subject'] = 'Booking request from traveler.';
		$message['body'] = auth()->user()->email .' has booked a guide from '.$request->bookFrom.' to '.$request->bookTo. ' for '.$request->totalDays. ' days. Please login: ' .URL::to('admin'). ' to review this booking.';

		$user = $this->user->findOrThrowException($request->gid);
		$setting = Setting::find(1);
		$price = $user->guide->price  * $request->totalDays;
		$totalPrice = $price + ($price * ( $setting->charges / 100 ));
		if ($user->guide->certified) {
			$this->bookingProcess($request);
			$this->user->notifyAdmin($message);
			return redirect()->route('frontend.guide.payment');
		}
		else {
			$booking = Booking::create([
				'gid' => $request->gid,
				'user_id' => auth()->id(),
				'amount' => $totalPrice,
				'days' => $request->totalDays,
				'start_date' => $request->bookFrom,
				'end_date' => $request->bookTo
			]);

			if ($booking) {
				$this->user->notifyAdmin($message);
				return redirect()->route('frontend.traveller.activity')->withFlashSuccess(trans("alerts.booking.created"));
			}
		}

		 throw new GeneralException('There is an error occured during booking process.');

	}

	private function bookingProcess($request)
	{
		$message['subject'] = 'Booking request from traveler.';
		$message['body'] = auth()->user()->email .' has booked a guide from '.$request->bookFrom.' to '.$request->bookTo. ' for '.$request->totalDays. ' days. Please login: ' .URL::to('admin'). ' to review this booking.';
		$user = $this->user->findOrThrowException($request->gid);
		$price = $user->guide->price  * $request->totalDays;
		$setting = Setting::find(1);
		$totalPrice = $price + ($price * ( $setting->charges / 100 ));

		$booking = Booking::create([
				'gid' => $request->gid,
				'uid' => auth()->id(),
				'amount' => $totalPrice,
				'days' => $request->totalDays,
				'start_date' => $request->bookFrom,
				'end_date' => $request->bookTo
			]);

			if ($booking) {
				$this->user->notifyAdmin($message);
				return redirect()->route('frontend.traveller.activity')->withFlashSuccess(trans("alerts.booking.created"));
			}

	}

}