<?php

$router->group([
	'middleware' => 'access.routeNeedsPermission:view-linksearch-management'
], function() use ($router) {

	get('linksearch/create', 'LinkSearchController@getLinkSearch')->name('admin.linksearch.pages');

	post('linksearch/create', 'LinkSearchController@postLinkSearch')->name('admin.linksearch.upload');

	get('linksearch/management', 'LinkSearchController@getAllLinkSearch')-> name('admin.linksearch.all');

	get('linksearch/delete/{id}', 'LinkSearchController@deleteLinkSearch')->name('admin.linksearch.delete');
	get('linksearch/edit/{id}', 'LinkSearchController@editLinkSearch')->name('admin.linksearch.edit');
	patch('linksearch/update/{id}', 'LinkSearchController@updateLinkSearch')->name('admin.linksearch.update');
        
        
        #echo __LINE__;exit;
        
	
});