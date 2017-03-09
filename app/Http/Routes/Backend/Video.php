<?php

$router->group([
	'middleware' => 'access.routeNeedsPermission:view-video-management'
], function() use ($router) {

	get('videos/create', 'VideoController@getVideos')->name('admin.videos.pages');

	post('videos/create', 'VideoController@postVideos')->name('admin.videos.upload');

	get('videos/management', 'VideoController@getAllVideos')-> name('admin.videos.all');

	get('videos/delete/{id}', 'VideoController@deleteVideos')->name('admin.videos.delete');
	get('videos/edit/{id}', 'VideoController@editVideos')->name('admin.videos.edit');
	patch('videos/update/{id}', 'VideoController@updateVideos')->name('admin.videos.update');
        
        
        
        
	
});