<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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

Route::get('/', 'IndexController@index')->name('home');
###  new change  ####
Route::post('/resetPassword', 'UsersController@resetPassword');
###  end change ####
// Admin Routes  resetPassword

Route::namespace("Admin")->prefix('admin')->group(function(){
  Route::get('/', 'HomeController@index')->name('admin.home');
    // user login
    Route::get('/userLogin','GeneralController@userLogin');
   //all Users
   Route::get('/allUsers','HomeController@allUsers');
   // add code 
   Route::get('/showAddCode','CodeController@showAddCode');
   Route::post('/addCode','CodeController@makeCode');
   Route::get('/userCodes','CodeController@userCodes');
   Route::get('/delete/{code_id}','CodeController@destroy');
   //animated ticker
  Route::get('/animatedTicker','AnimatedTickerController@index');
  Route::get('/animatedTicker/add','AnimatedTickerController@create');
  Route::post('/animatedTicker/store','AnimatedTickerController@store')->name('admin.animatedTicker.store');
  Route::delete('/animatedTicker/delete/{id}','AnimatedTickerController@delete');
  Route::get('/animatedTicker/edit/{id}','AnimatedTickerController@edit');
  Route::post('/animatedTicker/update/{id}','AnimatedTickerController@update')->name('admin.animatedTicker.update');

   // questions

  Route::get('/questions','QuestionController@question');
  Route::get('/question/add','QuestionController@create');
  Route::post('/question/store','QuestionController@store')->name('admin.question.store');
  Route::delete('/question/delete/{id}','QuestionController@delete');
  Route::get('/question/edit/{id}','QuestionController@edit');
  Route::post('/question/update/{id}','QuestionController@update')->name('admin.question.update');
  

  

  // generalPage
  Route::get('/appImage/add','GeneralController@appImage');
  Route::post('/appImage/store','GeneralController@storeImage')->name('admin.appImage.store');
  Route::get('/privacy','GeneralController@privacyPage');
  Route::post('/privacy/save','GeneralController@savePrivacyPage');
  Route::get('/term','GeneralController@termPage');
  Route::post('/term/save','GeneralController@saveTermPage');
  Route::get('/about-app','GeneralController@aboutAppPage');
  Route::post('/about-app/save','GeneralController@saveAboutAppPage');

  

   // Admin Slider
   Route::get('/slider','SliderController@admin');
   Route::get('/slider/add','SliderController@create');
   Route::post('/slider/store','SliderController@store')->name('admin.slider.store');
   Route::get('/slider/edit/{id}','SliderController@edit');
   Route::post('/slider/update/{id}','SliderController@update')->name('admin.slider.update');
   Route::delete('/slider/delete/{id}','SliderController@destroy');

   //Admin Category 
   Route::get('/categories','CategoryController@admin');
   Route::get('/category/add','CategoryController@create');
   Route::post('/category/store','CategoryController@store')->name('admin.category.store');
   Route::get('/category/edit/{id}','CategoryController@edit');
   Route::post('/category/update/{id}','CategoryController@update')->name('admin.category.update');
   Route::delete('/category/delete/{id}','CategoryController@destroy');

   //Admin Brand 
   Route::get('/brands','BrandController@admin');
   Route::get('/brand/add','BrandController@create');
   Route::post('/brand/store','BrandController@store')->name('admin.brand.store');
   Route::get('/brand/edit/{id}','BrandController@edit');
   Route::post('/brand/update/{id}','BrandController@update')->name('admin.brand.update');
   Route::delete('/brand/delete/{id}','BrandController@destroy');

 
   //Admin Item 
   Route::get('/items','ItemController@admin');
   Route::get('/item/add','ItemController@create');
   Route::post('/item/store','ItemController@store')->name('admin.item.store');
   Route::get('/item/edit/{id}','ItemController@edit');
   Route::get('/itemVendor/edit/{id}','ItemController@editVendorPlace');
   Route::post('/itemVendor/approveItem/{id}','ItemController@approveItem')->name('admin.item.update');
   Route::post('/item/update/{id}','ItemController@update');
   Route::delete('/item/img/delete/{id}','ItemController@imagedelete');
   Route::get('/category/item/{id}','ItemController@show');
   Route::delete('/item/delete/{id}','ItemController@destroy');
   Route::get('/item/requestitem','ItemController@requestitem');
   Route::get('/item/approve/{id}','ItemController@approve');
   Route::get('/item/updateItem','ItemController@updateItem');



   //admin add city
   Route::get('/cities','CityController@admin');
   Route::get('/city/add','CityController@create');
   Route::post('/city/store','CityController@store')->name('admin.city.store');
   Route::delete('/city/delete/{id}','CityController@destroy');
   Route::get('/city/edit/{id}','CityController@edit');
   Route::post('/city/update/{id}','CityController@update')->name('admin.city.update');
   Route::delete('/city/img/delete/{id}','CityController@imagedelete');
   Route::get('/city/items/{id}','CityController@cityItems');

   //accounts
   Route::get ('/user_accounts','AccountsController@userAccounts');
   Route::get ('/request_accounts','AccountsController@request_accounts');
   Route::get ('/cancel_accounts','AccountsController@cancelAccounts');
   Route::get ('/showUser/{id}','AccountsController@showUser');

   #####
   Route::get ('/approve/{id}','AccountsController@approve');
   Route::get ('/cancel/{id}','AccountsController@cancel_vendor');
   Route::get ('/active_vendor/{id}','AccountsController@active_vendor');
   
   // Admin About us
   Route::get('/about','AboutController@show');
   Route::post('/about/update','AboutController@update')->name('admin.about.update');

 Route::namespace('Auth')->group(function(){
   Route::get('/login', 'LoginController@showLoginForm')->name('admin.login');
   Route::post('/login', 'LoginController@login');
   Route::post('logout', 'LoginController@logout')->name('admin.logout');
 });
});


Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

  // vendor Routes
  
Route::group(['middeleware'=>['auth','isVendor']],function (){
    Route::get('/dashboard', 'VendorController@dashboard')->name('home');
    Route::get('/dashboard/MyProfile','VendorController@MyProfile');
    Route::get('/dashboard/MyPlace','VendorController@myplace');
    Route::get('/dashboard/editeplace/{id}','VendorController@editeplace');
    Route::post('/dashboard/updateprofile','VendorController@updateprofile')->name('vendor.updateprofile');
    Route::get('/dashboard/newplace','VendorController@newplace');
    Route::post('/dashboard/addnewplace','VendorController@addnewplace');
    Route::post('/dashboard/updateplace/{id}','VendorController@updateplace');
    Route::get('/dashboard/updateplace/{id}','VendorController@updateplace');
    Route::get('/dashboard/myClients','VendorController@myClients');
    Route::get('/dashboard/myClients/item/{id}','VendorController@myClientsItem');
    Route::post('/dashboard/offer/{user_id}/{item_id}','VendorController@offer');
    Route::post('/dashboard/multiOffers/{item_id}','VendorController@multiOffers');
    Route::get('/dashboard/myOffers','VendorController@myOffers');
    Route::get('/dashboard/favourite','FavouriteController@showFavourite');
    Route::post('/dashboard/addToFavourites','FavouriteController@addToFavourites')->name('addToFavourites');
    Route::get('/dashboard/vendorOffer','VendorController@vendorOffer');
    Route::get('/dashboard/workHoursPlaces','VendorController@workHoursPlaces');
    Route::get('/dashboard/workHours/{id}','VendorController@workHours');
    Route::post('/dashboard/workHours/save/{id}','VendorController@workHourSave');
    Route::get('/dashboard/myNotification','VendorController@myNotification');
    Route::get('/dashboard/BookingPlace','VendorController@bookingPlace');
    Route::get('/dashboard/BookingRequest/{item_id}','VendorController@bookingRequest');
    Route::get('/dashboard/ReservationAccepted/{id}','VendorController@ReservationAccepted');
    Route::get('/dashboard/ReservationCancel/{id}','VendorController@ReservationCancel');
    Route::post('/dashboard/suggestReservation/{id}','VendorController@suggestReservation');
    Route::get('/dashboard/previousReservation','VendorController@previousReservation');
    Route::get('/dashboard/userReservation','VendorController@userReservation');

});

#####@ search #######
Route::get('/search','IndexController@search');

######### front  #####
Route::get('/AllCities','IndexController@All_Cities');
Route::get('/city/{id}','IndexController@city_front');
Route::get('/Place_Details/{id}','IndexController@Place_Details');
Route::get('/editprofile','UserController@edit');
Route::get('/reserve/{id}','VendorController@reserve');
Route::post('/reserveSave/{id}','VendorController@reserveSave');
Route::get('/topRated','IndexController@topRated');
Route::post('/addToFavourite','FavouriteController@addToFavourites');
Route::post('/deletefromFavourite','FavouriteController@deletefromFavourite');
Route::get('/contact', 'IndexController@contact');
Route::post('/sendContact', 'IndexController@sendContact');
Route::get('/fcm','FCMController@index');
Route::post('/push-notificaiton','FCMController@index')->name('push-notificaiton');
Route::get('/store-token','FCMController@storeToken')->name('store.token');
Route::get('/send-web-notification','FCMController@sendWebNotification')->name('send.web-notification');


#####language
Route::get('/{locale}',function($locale){
  Session::put('locale',$locale);
  return redirect()->back();
});

Route::get('/send','FCMController@sendNotification');
Route::post('/save-token','FCMController@saveToken')->name('save-token');
Route::get('send', 'CookiesController@sendNotification');
Route::get('/categoryIcon','IndexController@categoryIcon');