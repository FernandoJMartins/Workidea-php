<?php
$router -> get ('/public/', 'HomeController@index');
$router -> get ('/public/listings/', 'ListingController@index');
$router -> get ('/public/listings/create/', 'ListingController@create');
$router -> get ('/public/listings/edit/{id}', 'ListingController@edit');
$router -> get ('/public/listings/{id}', 'ListingController@show');

$router -> post ('/public/listings/', 'ListingController@store');
$router -> put ('/public/listings/{id}', 'ListingController@update');
$router -> delete ('/public/listings/{id}', 'ListingController@delete');

$router -> get('/public/auth/register/', 'UserController@create');
$router -> get('/public/auth/login/', 'UserController@login');

$router -> post('/public/auth/register/', 'UserController@store');
$router -> post('/public/auth/logout/', 'UserController@logout');
