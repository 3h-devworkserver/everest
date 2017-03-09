<?php

$router->group([
	'middleware' => 'access.routeNeedsPermission:view-ad-management'
], function() use ($router) {

	get('ads/create', 'AdController@getAds')->name('admin.ads.pages');

	post('ads/create', 'AdController@postAds')->name('admin.ads.upload');

	get('ads/management', 'AdController@getAllAds')-> name('admin.ads.all');

	get('ads/delete/{id}', 'AdController@deleteAds')->name('admin.ads.delete');
	get('ads/edit/{id}', 'AdController@editAds')->name('admin.ads.edit');
	patch('ads/update/{id}', 'AdController@updateAds')->name('admin.ads.update');
        
        
        #echo __LINE__;exit;
        
	
});