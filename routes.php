<?php
$router -> get ('/public/', 'HomeController@index');
$router -> get ('/public/listings/', 'ListingController@index');
$router -> get ('/public/listings/create/', 'ListingController@create');
$router -> get ('/public/listings/{id}', 'ListingController@show');

$router -> post ('/public/listings/', 'ListingController@store');

$router -> delete ('/public/listings/{id}', 'ListingController@delete');