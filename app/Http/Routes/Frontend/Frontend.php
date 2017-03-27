<?php

/**
 * Frontend Controllers
 */
get('/', 'FrontendController@index')->name('home');

//checking for unique email in package bookingstep1
get('/emailcheck', 'FrontendController@checkEmail');

//booking success msg page
get('/success', function(){
	return "success";
});

get('/{page}','FrontendController@page')->name('page');

get('/search/results', 'SearchController@index')->name('search.index');
get('/autocomplete/search', 'SearchController@autocompletesearch');
post('/autocomplete/search', 'SearchController@autocompletesearch');

get('macros', 'FrontendController@macros');

post('/search/summitteers', 'SearchController@summitteers');

post('/submitContact', 'FrontendController@submitContact');


// for package --yojan
get('/package/morelist', 'PackageController@generateMoreLists');
get('/package/{slug}','PackageController@packageDetail');



//for generating promo-code
post('/promocode','FrontendController@generatePromoCode');

//for adding extension package in db
post('/package/addextpackage','PackageController@addExtPackage');

//valentines package ipn
post('/esewa-ipn', 'PackageController@esewaIpn');

//valentines special
get('/package/{slug}/{datePrice}/valentines-booking','PackageController@valentinesBooking');
get('/package/{slug}/{datePrice}/booking-success/{promoid}','PackageController@valentinesBookingSuccess');
post('package/checkpromocode', 'PackageController@checkPromoCode');
post('package/updatecoupleinfo','PackageController@UpdatePromoCodeInfo');

// for package booking
get('/package/{slug}/{datePrice}/booking-step1','PackageController@bookingStep1');
get('/package/{slug}/{datePrice}/booking-step1/edit','PackageController@bookingStep1EditGET');
post('/package/{slug}/{datePrice}/booking-step2','PackageController@bookingStep2');

post('/package/{slug}/{datePrice}/booking-step3','PackageController@bookingStep3');
post('/package/{slug}/{datePrice}/booking-step3-payment','PackageController@bookingStep3Payment');

post('package/contactpackage', 'PackageController@contactPackage');

//flight search
get('/flight/search', 'FlightController@returnHome'); 
post('/flight/search', 'FlightController@searchFlight'); 
get('/flight/review', 'FlightController@returnHome'); 
post('/flight/review', 'FlightController@reviewFlight'); 
get('/flight/passengers', 'FlightController@returnHome'); 
post('/flight/passengers', 'FlightController@passengersFlight'); 
get('/flight/passengerdetail', 'FlightController@returnHome'); 
post('/flight/payment', 'FlightController@passengersDetail'); 
get('/flight/flightsearch', 'FlightController@searchFormFlight'); 
// get('/flight/locations', 'FlightController@flightLocation'); 

get('/flight/booking-success/esewa/{token}', 'PaymentController@flightBookingSuccess');
get('/package/booking-success/esewa/{token}', 'PaymentController@packageBookingSuccess');


