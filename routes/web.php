<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

use Illuminate\Http\Request;

URL::forceScheme('https');
Auth::routes();

Route::get('/home', function () {
   // return redirect('login');
});

//Route::get('/start-tour', function () {
//    return view('start_tour');
//});
//Route::get('/appoint/test', 'AppointmentsController@test');
//Route::get('google', function () {
//    return view('googleAuth');
//});
Route::get('/', function () {
    return redirect('/home');
});
Route::get('/home', 'ScannerController@home');
Route::get('/logout', 'UsersController@logout');
Route::get('/scanner', 'ScannerController@scanner');


Route::get('/concept', 'ScannerController@concept');
Route::get('/about', 'ScannerController@about');
Route::get('/contact', 'ScannerController@contact');


Route::get('/user-registration/{qrcode}', 'ProductController@userRegister');

Route::get('checknumber/{number}', 'ProductController@checknumber');
Route::post('userRegisterSubmit','ProductController@userRegisterSubmit');

Route::get('loadQuantity/{proid}', 'ProductController@loadQuantity');
Route::get('quantityData/{id}', 'ProductController@quantityData');





Route::any('paymentSubmit','ProductController@paymentSubmit');

Route::post('sellSubmit','ProductController@sellSubmit');

Route::get('paymentdata/{id}', 'ProductController@paymentdata');

Route::post('contactSubmit','ProductController@contactSubmit');


Route::post('contactSubmit','ProductController@contactSubmit');


Route::any('statistics/','ProductController@statistics');

Route::any('terms-conditions/','ScannerController@termsConditions');

Route::any('privacy-policy/','ScannerController@privacyPolicy');

Route::group(['middleware' => 'web', 'middleware' => ['auth']], function () {
Route::get('sell', 'ProductController@sell');
Route::get('payment/{id}', 'ProductController@payment');
Route::get('final-status/{id}', 'ProductController@FinalSubmit');


Route::get('my-orders', 'ProductController@myorders');                                                                                                       
});