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
	// get('traveller/account', 'ProfileController@account')->name('frontend.traveller.account');
	get('traveller/history', 'ProfileController@history')->name('frontend.traveller.history');
	// get('traveller/image', 'ProfileController@image')->name('frontend.traveller.image');
	
	post('traveller/profile/info', 'ProfileController@updateProfile');
	patch('traveller/profile/image', 'ProfileController@updateProfileImage');
	post('traveller/profile/password', 'ProfileController@changepassword');
	patch('traveller/profile/passport', 'ProfileController@updatePassport');

	



});

});