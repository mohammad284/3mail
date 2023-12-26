<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/cities','API\InfoController@cities');
Route::get('/city/{id}','API\InfoController@cityid');
Route::get('/categories','API\InfoController@categories');
Route::get('/category/{id}','API\InfoController@categoryId');
Route::get('/item/{id}/{cat_id}','API\InfoController@itemId');
Route::get('/items','API\InfoController@items');
Route::post('/search/{name}','API\InfoController@search');


            ### QR code ###
Route::post('/QRcodeClient','API\InfoController@QRcodeClient');
###
Route::post('/register', 'API\AuthApiController@register');
Route::post('/login', 'API\AuthApiController@login');
Route::post('/logout', 'API\AuthApiController@logout');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/addItem','API\InfoController@addItem');
Route::get('/editItem/{id}','API\InfoController@editItem');
Route::post('/updateItem/{id}','API\InfoController@updateItem');
Route::get('/vendorItem/{id}','API\InfoController@vendorItem');
Route::get('/profileUser/{id}', 'API\InfoController@MyProfile');
Route::post('/updateProfile/{id}', 'API\InfoController@updateprofile');
Route::post('/client','API\InfoController@client');
Route::post('/AddWorkTime','API\InfoController@AddWorkTime');
Route::post('/updateWorkTime','API\InfoController@updateWorkTime');
Route::get('/myOffers/{id}','API\InfoController@myOffers');
Route::get('/typeUser/{id}','API\InfoController@typeUser');
Route::get('/clientEvaluation/{id}','API\InfoController@clientEvaluation');
Route::get('/topRated','API\InfoController@topRated');
Route::delete('/deleteItem/{id}','API\InfoController@deleteItem');
Route::get('/review/{id}','API\InfoController@review');
Route::get('/ratingCount/{id}','API\InfoController@ratingCount');
Route::get('/animatedTicker','API\InfoController@animatedTicker');
Route::post('/offer/{user_id}/{item_id}','API\InfoController@offer');
Route::post('/multiOffers/{item_id}','API\InfoController@multiOffers');
Route::get('/myPlaces/{id}','API\InfoController@myPlaces');
Route::get('/myClientsItem/{id}','API\InfoController@myClientsItem');
Route::get('/textOffer/{id}','API\InfoController@textOffer');
Route::get('/showFavourite/{id}','API\InfoController@showFavourite');
Route::post('/addToFavourites','API\InfoController@addToFavourites');
Route::post('/deletefromFavourite','API\InfoController@deletefromFavourite');
Route::get('/myNotification/{id}','API\InfoController@myNotification');
Route::post('/vendorOffer','API\InfoController@vendorOffer');
Route::get('/latestPlaces','API\InfoController@latestPlaces');
Route::post('/reserveSave/{id}','API\InfoController@reserveSave');
Route::post('/reserveByOffer/{id}/{offer_id}','API\InfoController@reserveByOffer');
Route::post('/workHours/save/{id}','API\InfoController@workHourSave');
Route::get('/ReservationAccepted/{id}','API\InfoController@ReservationAccepted');
Route::get('/BookingRequest/{item_id}/{vendor_id}','API\InfoController@bookingRequest');
Route::get('/ReservationCancel/{id}','API\InfoController@ReservationCancel');
Route::post('/suggestReservation/{id}','API\InfoController@suggestReservation');
Route::get('/previousReservation/{id}','API\InfoController@previousReservation');//id = vendor id
Route::get('/userReservation/{id}','API\InfoController@userReservation');//id = user id
Route::get('/food_menu/{id}','API\InfoController@food_menu');
Route::get('/questions','API\InfoController@questions');
Route::get('/generalPage','API\InfoController@generalPage');
Route::post('/email','API\InfoController@email');
Route::get('/latestCityPlce/{id}','API\InfoController@latestCityPlce');
Route::get('/appImage','API\InfoController@appImage');
Route::post('/sendContact' ,'API\InfoController@sendContact');
Route::post('/forgetPassword','API\InfoController@forgot');
Route::get('/birthday/{item_id}','API\InfoController@birthday');
Route::get('/clientVisits/{item_id}/{user_id}','API\InfoController@clientVisits');
Route::post('/AddEvent/{user_id}','API\InfoController@AddEvent');
Route::post('/updateEvent/{event_id}','API\InfoController@updateEvent');
Route::get('/myEvent/{user_id}','API\InfoController@myEvent');
Route::get('/itemEvent/{item_id}','API\InfoController@itemEvent');
Route::get('/allEvent/{item_id}','API\InfoController@allEvent');
Route::get('/destroyEvent/{event_id}','API\InfoController@destroyEvent');
Route::get('/workTimeId/{item_id}','API\InfoController@workTimeId');
Route::post('/AddComplaint/{item_id}/{user_id}','API\InfoController@AddComplaint');
Route::get('/itemComplaint/{item_id}','API\InfoController@itemComplaint');
Route::get('/userComplaint/{user_id}','API\InfoController@userComplaint');
Route::post('/reply/{comp_id}','API\InfoController@reply');