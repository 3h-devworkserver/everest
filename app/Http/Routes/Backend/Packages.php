<?php

//new code

$router->group([
	'middleware' => 'access.routeNeedsPermission:view-packages-management'
], function() use ($router) {
	/**
	 * Package Management
	 */
	// get('packages/{id}/create/block', 'PackageController@getstaticblock');
	// post('packages/create/block', 'PackageController@poststaticblock');
	// get('packages/{id}', 'PackageController@destory')->name('admin.packages.destory');
    resource('packages', 'PackageController', ['except' => ['show']]);
    post('packages/deletemapimage','PackageController@deleteMapImage');

    //for package dates and prices
    get('packages/datesprices/create', 'PackageController@datesPricesCreate');
	get('packages/datesprices', 'PackageController@datesPricesView');
	post('packages/datesprices', 'PackageController@datesPricesStore');
	get('packages/datesprices/{id}/edit', 'PackageController@datesPricesEdit');
	patch('packages/datesprices/{id}', 'PackageController@datesPricesUpdate');
	delete('packages/datesprices/{id}', 'PackageController@datesPricesDestroy');
	get('packages/datesprices/checkPackage', 'PackageController@checkDatesPricesPackage');

    //for itinerary
    get('packages/itinerary/create', 'PackageController@itineraryCreate');
	get('packages/itinerary', 'PackageController@itineraryView');
	post('packages/itinerary', 'PackageController@itineraryStore');
	get('packages/itinerary/{id}/edit', 'PackageController@itineraryEdit')->name('admin.packages.itinerary.edit');
	patch('packages/itinerary/{id}', 'PackageController@itineraryUpdate');
	delete('packages/itinerary/{id}/delete', 'PackageController@itineraryDestroy')->name('admin.packages.itinerary.destroy');
	get('packages/itinerary/checkPackage', 'PackageController@checkItineraryPackage');

    //for package category
	get('packages/category/create', 'PackageController@categoryCreate');
	get('packages/category', 'PackageController@categoryView');
	post('packages/category', 'PackageController@categoryStore');
	get('packages/category/{id}/edit', 'PackageController@categoryEdit')->name('admin.packages.category.edit');
	patch('packages/category/{id}', 'PackageController@categoryUpdate');
	delete('packages/category/{id}/delete', 'PackageController@categoryDestroy')->name('admin.packages.category.destroy');

	// for package option
	get('packages/options/create', 'PackageController@optionCreate');
	post('packages/options', 'PackageController@optionStore');
	get('packages/options', 'PackageController@optionView');
	get('packages/options/{id}/edit', 'PackageController@optionEdit')->name('admin.packages.option.edit');
	patch('packages/options/{id}', 'PackageController@optionUpdate');
	delete('packages/options/{id}/delete', 'PackageController@optionDestroy')->name('admin.packages.option.destroy');


	//for package gallery
	get('packages/gallery/create', 'PackageController@galleryCreate');
	get('packages/gallery', 'PackageController@galleryView');
	post('packages/gallery', 'PackageController@galleryStore');
	get('packages/gallery/{id}/edit', 'PackageController@galleryEdit')->name('admin.packages.gallery.edit');
	patch('packages/gallery/{id}', 'PackageController@galleryUpdate');
	delete('packages/gallery/delete/{id}', 'PackageController@galleryDestroy')->name('admin.packages.gallery.destroy');
	get('packages/gallery/checkPackage', 'PackageController@checkGalleryPackage');

	//for deleting package gallery image in edit page
	get('packages/gallery/deleteImage', 'PackageController@deleteGalleryImage');


	//for package notifying email template
	get('email/travellerregister', 'EmailController@EmailTemplate');
	post('email/travellerregister', 'EmailController@EmailTemplateStore');






});






//previous code

// $router->group([
// 	'middleware' => 'access.routeNeedsPermission:view-packages-management'
// ], function() use ($router) {
// 	/**
// 	 * Package Management
// 	 */
// 	get('packages/{id}/create/block', 'PackageController@getstaticblock');
// 	post('packages/create/block', 'PackageController@poststaticblock');
// 	get('packages/{id}', 'PackageController@destory')->name('admin.packages.destory');

//     resource('packages', 'PackageController', ['except' => ['show']]);
// });