<?php

/**
 * Frontend Controllers
 */


/**
 * These frontend controllers require the user to be logged in
 */

$router->group(['namespace' => 'Traveller'], function () use ($router)
{
$router->group(['middleware' => 'access.routeNeedsRole:Traveller'], function ()
{
	get('traveller/dashboard', 'ProfileController@dashboard')->name('frontend.traveller.dashboard');
	get('traveller/profile', 'ProfileController@profile')->name('frontend.traveller.profile');
	get('traveller/account', 'ProfileController@account')->name('frontend.traveller.account');
	get('traveller/history', 'ProfileController@history')->name('frontend.traveller.history');
	get('traveller/image', 'ProfileController@image')->name('frontend.traveller.image');
	
	



	// get('traveller/profile', 'ProfileController@index')->name('frontend.traveller.profile');
	// get('traveller/settings', 'ProfileController@settings')->name('frontend.traveller.settings');
	// post('traveller/settings', 'ProfileController@settingsUpdate')->name('frontend.traveller.settings.update');
	// post('traveller/settings/email', 'ProfileController@emailUpdate')->name('frontend.traveller.settings.emailupdate');
	// patch('traveller/profile/update', 'ProfileController@update')->name('frontend.traveller.profile.update');
	// post('traveller/profile/pic/upload', 'ProfileController@picUpload')->name('frontend.traveller.profile.pic.upload');
	// get('traveller/activity', 'TravellerController@getActivity')->name('frontend.traveller.activity');

	// get('traveller/payment-process', 'TravellerController@getPaymentProcess')->name('frontend.guide.payment');

	// post('traveller/booking/process', 'TravellerController@postBookingProcess')->name('frontend.guide.booking.process');

});

});