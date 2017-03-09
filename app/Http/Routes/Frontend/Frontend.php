<?php

/**
 * Frontend Controllers
 */
get('/', 'FrontendController@index')->name('home');



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

// for package booking

//valentines special
get('/package/{slug}/{datePrice}/valentines-booking','PackageController@valentinesBooking');
get('/package/{slug}/{datePrice}/booking-success/{promoid}','PackageController@valentinesBookingSuccess');
post('package/checkpromocode', 'PackageController@checkPromoCode');
post('package/updatecoupleinfo','PackageController@UpdatePromoCodeInfo');

get('/package/{slug}/{datePrice}/booking-step1','PackageController@bookingStep1');
get('/package/{slug}/{datePrice}/{groupId}/booking-step1','PackageController@bookingStep1Edit');
patch('/package/{slug}/{datePrice}/booking-step2/{groupId}','PackageController@bookingStep2Edit');
post('/package/{slug}/{datePrice}/booking-step2/{groupId}','PackageController@bookingStep2Edit');
post('/package/{slug}/{datePrice}/booking-step2','PackageController@bookingStep2');
get('/package/{slug}/{datePrice}/{groupId}/booking-step2','PackageController@bookingStep2Summary');
// get('/package/{slug}/{datePrice}/booking-step2','PackageController@bookingStep2'); // only for testing
post('/package/{slug}/{datePrice}/booking-step3','PackageController@bookingStep3');
post('/package/{slug}/{datePrice}/booking-step3-payment','PackageController@bookingStep3Payment');

post('package/contactpackage', 'PackageController@contactPackage');

//flight search
get('/flight/search', 'FlightController@searchFlightGet'); 
post('/flight/search', 'FlightController@searchFlight'); 
post('/flight/review', 'FlightController@reviewFlight'); 
post('/flight/passengers', 'FlightController@passengersFlight'); 
post('/flight/passengerdetail', 'FlightController@passengersDetail'); 
get('/flight/flightsearch', 'FlightController@searchFormFlight'); 
// get('/flight/locations', 'FlightController@flightLocation'); 



