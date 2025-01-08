<?php
$router -> get ('/public/', 'HomeController@index');
$router -> get ('/public/listings/', 'ListingController@index');
$router -> get ('/public/listings/create/', 'ListingController@create');
$router -> get ('/public/listing/{id}', 'ListingController@show');

$router -> post ('/public/listings/', 'ListingController@store');