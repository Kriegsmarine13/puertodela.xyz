<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/main', 'MainController@index');

Route::auth();

Route::get('/home', 'HomeController@index');

//Admin Routes
Route::controller('/admin','AdminController',['middleware'=>'auth']);

//Test
Route::controller('/meme','MemeController');


//Debug routes
Route::get('/debug/gd', 'MainController@getGDInfo');

