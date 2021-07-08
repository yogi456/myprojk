<?php

//use Illuminate\Http\Request;
//
///*
//|--------------------------------------------------------------------------
//| API Routes
//|--------------------------------------------------------------------------
//|
//| Here is where you can register API routes for your application. These
//| routes are loaded by the RouteServiceProvider within a group which
//| is assigned the "api" middleware group. Enjoy building your API!
//|
//*/
//
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::resource('products', 'ProductsController', [
    'except' => ['create', 'edit', 'show']
]);


Route::get('paymentdata/', 'ProductController@paymentdata_api');
Route::post('update_status', 'ProductController@update_status');


Route::any('verifytoken','FacebookController\FacebookWebhookHandler@veryfy_token');
Route::get("/test", function() {
    echo "Hello";exit;
});
