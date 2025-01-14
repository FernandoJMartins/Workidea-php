<?php
$router -> get ('/public/', 'HomeController@index');
$router -> get ('/public/listings/', 'ListingController@index');
$router -> get ('/public/listings/create/', 'ListingController@create', ['auth']);
$router -> get ('/public/listings/edit/{id}', 'ListingController@edit', ['auth']);
$router -> get ('/public/listings/{id}', 'ListingController@show');

$router -> post ('/public/listings/', 'ListingController@store', ['auth']);
$router -> put ('/public/listings/{id}', 'ListingController@update', ['auth']);
$router -> delete ('/public/listings/{id}', 'ListingController@delete', ['auth']);

$router -> get('/public/auth/register/', 'UserController@create', ['guest']);
$router -> get('/public/auth/login/', 'UserController@login', ['guest']);

$router -> post('/public/auth/register/', 'UserController@store', ['guest']);
$router -> post('/public/auth/logout/', 'UserController@logout', ['auth']);
$router -> post('/public/auth/login/', 'UserController@authenticate', ['guest']);
