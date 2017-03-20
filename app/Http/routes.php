<?php

/**
 * Switch between the included languages
 */
require(__DIR__ . "/Routes/Global/Lang.php");
/**
 * Frontend Routes
 * Namespaces indicate folder structure
 */
$router->group(['namespace' => 'Frontend'], function () use ($router)
{
	require(__DIR__ . "/Routes/Frontend/Access.php");
	require(__DIR__ . "/Routes/Frontend/Frontend.php");
	// require(__DIR__ . "/Routes/Frontend/Guide/Frontend.php");
	require(__DIR__ . "/Routes/Frontend/Traveller/Frontend.php");
	// require(__DIR__ . "/Routes/Frontend/Payment.php");
});
/**
 * Backend Routes
 * Namespaces indicate folder structure
 */
$router->group(['namespace' => 'Backend'], function () use ($router)
{
	$router->group(['prefix' => 'admin', 'middleware' => 'auth'], function () use ($router)
	{
		/**
		 * These routes need view-backend permission (good if you want to allow more than one group in the backend, then limit the backend features by different roles or permissions)
		 *
		 * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
		 */
		 $router->group(['middleware' => 'access.routeNeedsPermission:view-backend'], function () use ($router)
		 {
			require(__DIR__ . "/Routes/Backend/Dashboard.php");
			require(__DIR__ . "/Routes/Backend/Pages.php");
			require(__DIR__ . "/Routes/Backend/InnerPages.php");
			require(__DIR__ . "/Routes/Backend/Access.php");
			require(__DIR__ . "/Routes/Backend/Settings.php");
			require(__DIR__ . "/Routes/Backend/Backend.php");
			require(__DIR__ . "/Routes/Backend/Slides.php");
			require(__DIR__ . "/Routes/Backend/Menus.php");
			require(__DIR__ . "/Routes/Backend/Packages.php");
			require(__DIR__ . "/Routes/Backend/Summitteers.php");
			require(__DIR__ . "/Routes/Backend/Video.php");
			require(__DIR__ . "/Routes/Backend/Customers.php");
			require(__DIR__ . "/Routes/Backend/Purchase.php");
                        require(__DIR__ . "/Routes/Backend/Ad.php");
                        require(__DIR__ . "/Routes/Backend/LinkSearch.php");
		 });
	});



	// API routes
	$router->group(['prefix' => 'api', 'namespace' => 'Api'], function() use ($router)
	{
	    // DataTables
	    get('table/users', ['as'=>'api.table.users', 'uses'=>'DataTableController@getUsers']);
	    get('table/users/deactivated', ['as'=>'api.table.users.deactivated', 'uses'=>'DataTableController@getDeactivatedUsers']);
	    
	    get('table/users/guides', ['as'=>'api.table.users.guides', 'uses'=>'DataTableController@getGuides']);

	    get('table/users/travellers', ['as'=>'api.table.users.travellers', 'uses'=>'DataTableController@getTravellers']);

	    get('table/page', ['as'=>'api.table.page', 'uses'=>'DataTableController@getPages']);
	    get('table/page/deactivated', ['as'=>'api.table.page.deactivated', 'uses'=>'DataTableController@getDeactivatedPages']);

	    get('table/innerpage', ['as'=>'api.table.innerpage', 'uses'=>'DataTableController@getInnerPages']);

	    get('table/reviews/unapproved', ['as' => 'api.table.reviews.unapproved', 'uses' => 'DataTableController@getUnapprovedReviews']);
	    get('table/reviews/approved', ['as' => 'api.table.reviews.approved', 'uses' => 'DataTableController@getApprovedReviews']);
	    get('table/reviews/all', ['as' => 'api.table.reviews.all', 'uses' => 'DataTableController@getAllReviews']);

	    get('table/guide/reviews', ['as'=>'api.table.guide.reviews', 'uses'=>'DataTableController@getGuideReviews']);

	    get('table/license', ['as' => 'api.table.license', 'uses' => 'DataTableController@getLicense']);

	    get('table/bookings/approved', ['as' => 'api.table.bookings.approved', 'uses' => 'DataTableController@getApprovedBookings']);
	    get('table/bookings/unapproved', ['as' => 'api.table.bookings.unapproved', 'uses' => 'DataTableController@getUnapprovedBookings']);
	    
	    get('table/slides', ['as' => 'api.table.slides', 'uses' => 'DataTableController@getAllSlides']);
	    get('table/misc', ['as' => 'api.table.misc', 'uses' => 'DataTableController@getAllGuideArea']);
	    get('table/misclang', ['as' => 'api.table.misclang', 'uses' => 'DataTableController@getAllLanguage']);

	   get('table/package', ['as'=>'api.table.package', 'uses'=>'DataTableController@getPackages']); 

	   get('table/videos', ['as' => 'api.table.videos', 'uses' => 'DataTableController@getAllVideos']);
           get('table/ads', ['as' => 'api.table.ads', 'uses' => 'DataTableController@getAllAds']);
           get('table/linksearch', ['as' => 'api.table.linksearch', 'uses' => 'DataTableController@getAllLinkSearch']);
	   get('table/sumitteer', ['as' => 'api.table.summitteer', 'uses' => 'DataTableController@getSummitteers']);
	
	// for package category
	   get('table/package/category', ['as'=>'api.table.package.category', 'uses'=>'DataTableController@getPackageCategory']); 
	//for package option
	   get('table/package/option', ['as'=>'api.table.package.option', 'uses'=> 'DataTableController@getPackageOption']);
	   
	   //for customer list in backend
	   get('table/customer', ['as'=>'api.table.customer', 'uses'=> 'DataTableController@getCustomers']);
 		//for registered customer list in backend
	   get('table/customer/registered', ['as'=>'api.table.customer.registered', 'uses'=> 'DataTableController@getRegisteredCustomers']);
		
		//for registered customer list in backend
	   get('table/purchase', ['as'=>'api.table.purchase', 'uses'=> 'DataTableController@getPurchases']);


	   

	});
});

//this is most general so is placed at last, otherwise will generate error
Route::get('/{part1}/{part2}','Frontend\FrontendController@page2');
//this is most general so is placed at last, otherwise will generate error
Route::get('/{part1}/{part2}','Frontend\FrontendController@page2');