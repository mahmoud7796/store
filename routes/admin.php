<?php
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){
Route::group(['namespace' => 'Dashboard', 'middleware'=>'guest:admin','prefix'=>'admin'], function(){
    Route::get('/login', 'LoginController@login')->name('admin.login');
    Route::post('/post-login', 'LoginController@postLogin')->name('admin.postLogin');
});


Route::group(['namespace' => 'Dashboard', 'middleware' => 'auth:admin','prefix'=>'admin'], function(){
    Route::get('/', 'dashboardController@index')->name('admin.dashboard');
    Route::get('/logout', 'LoginController@logout')->name('admin.logout');
    Route::group(['prefix'=> 'setting'], function(){
       Route::get('/shipping-method/{type}', 'SettingController@editShippingMethods')->name('edit.shipping.methods');
       Route::put('/shipping-method/{id}', 'SettingController@updateShippingMethods')->name('update.shipping.methods');
    });

    Route::group(['prefix' => 'profile'], function () {
        Route::get('edit', 'ProfileController@editProfile')->name('edit.profile');
        Route::put('update', 'ProfileController@updateprofile')->name('update.profile');
        Route::get('edit-password', 'ProfileController@editPass')->name('password.edit.profile');
        Route::post('update-password', 'ProfileController@updatepass')->name('password.update.profile');
    });

});

});
