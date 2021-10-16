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
#######################main categories##############################
    Route::group(['prefix' => 'main-categories'], function () {
        Route::get('/', 'MaincategoriesController@index')->name('admin.maincategories');
        Route::get('create', 'MaincategoriesController@create')->name('admin.maincategories.create');
        Route::post('store', 'MaincategoriesController@store')->name('admin.maincategories.store');
        Route::get('edit/{id}', 'MaincategoriesController@edit')->name('admin.maincategories.edit');
        Route::post('update/{id}', 'MaincategoriesController@update')->name('admin.maincategories.update');
        Route::get('delete/{id}', 'MaincategoriesController@delete')->name('admin.maincategories.delete');
    });
#######################end main categories##############################

    #######################Sub categories##############################
    Route::group(['prefix' => 'sub-categories'], function () {
        Route::get('/', 'SubCategoriesController@index')->name('admin.subcategories');
        Route::get('create', 'SubCategoriesController@create')->name('admin.subcategories.create');
        Route::post('store', 'SubCategoriesController@store')->name('admin.subcategories.store');
        Route::get('edit/{id}', 'SubCategoriesController@edit')->name('admin.subcategories.edit');
        Route::post('update/{id}', 'SubCategoriesController@update')->name('admin.subcategories.update');
        Route::get('delete/{id}', 'SubCategoriesController@delete')->name('admin.subcategories.delete');
    });
#######################end main categories##############################

});

});
