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

Auth::routes();

Route::get('/home', function () {
    return redirect('login');
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

Route::get('/logout', 'UsersController@logout');
Route::get('/scanner', 'ScannerController@scanner');

Route::group(['middleware' => 'web', 'middleware' => ['auth']], function () {

                                                                                                                 
});