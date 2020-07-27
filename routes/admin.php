<?php

use Illuminate\Support\Facades\Route;


// The prefix I Made It In The RouteServiceProvider File


define('PAGINATE_COUNT', 10);  // TO Use It In Paginate Results And Will be 10 Results

//  Route Admin
Route::group(['middleware' => 'auth:admin'],
    function () {

        Route::get('/', 'DashboardController@getDashboard')
            ->name('admin.dashboard');
        Route::any('/logout', 'LoginController@logout')
            ->name('admin.logout');

//    Start Site languages Routes
        Route::group(['prefix' => 'languages'], function () {
            Route::get('/', 'LanguageController@index')
                ->name('site.languages.index');
            Route::get('create', 'LanguageController@create')
                ->name('site.languages.create');
            Route::post('store', 'LanguageController@store')
                ->name('site.languages.store');
            Route::get('edit/{id}', 'LanguageController@edit')
                ->name('site.languages.edit');
            Route::post('update/{id}', 'LanguageController@update')
                ->name('site.languages.update');
            Route::any('delete/{id}', 'LanguageController@destroy')
                ->name('site.languages.delete');
        });
//    End languages Routes


// --------------------------------------------------------------------------- //
        // Start Main Categories Routes
        Route::group(['prefix' => 'main-cats'], function () {
            Route::get('/', 'MainCategoryController@index')
                ->name('main-cats.index');
            Route::get('create', 'MainCategoryController@create')
                ->name('main-cats.create');
            Route::post('store', 'MainCategoryController@store')
                ->name('main-cats.store');
            Route::get('edit/{id}', 'MainCategoryController@edit')
                ->name('main-cats.edit');
            Route::post('update/{id}', 'MainCategoryController@update')
                ->name('main-cats.update');
            Route::get('delete/{id}', 'MainCategoryController@destroy')
                ->name('main-cats.delete');
            Route::get('status/{id}', 'MainCategoryController@status')
                ->name('main-cats.status');
        });
        // End Main Categories Routes


// --------------------------------------------------------------------------- //


        // Start Sub Categories Routes
        Route::group(['prefix' => 'sub-categories'], function () {
            Route::get('/', 'SubCategoryController@index')
                ->name('sub-categories.index');
            Route::get('create', 'SubCategoryController@create')
                ->name('sub-categories.create');
            Route::post('store', 'SubCategoryController@store')
                ->name('sub-categories.store');
            Route::get('edit/{id}', 'SubCategoryController@edit')
                ->name('sub-categories.edit');
            Route::post('update/{id}', 'SubCategoryController@update')
                ->name('sub-categories.update');
            Route::any('delete/{id}', 'SubCategoryController@destroy')
                ->name('sub-categories.delete');
            Route::get('status/{id}', 'SubCategoryController@status')
                ->name('sub-categories.status');
        });

        // End Sub Categories Routes


// --------------------------------------------------------------------------- //

        // Start Vendors Routes
        Route::group(['prefix' => 'vendors'], function () {
            Route::get('/', 'VendorController@index')
                ->name('vendors.index');
            Route::get('create', 'VendorController@create')
                ->name('vendors.create');
            Route::post('store', 'VendorController@store')
                ->name('vendors.store');
            Route::get('edit/{id}', 'VendorController@edit')
                ->name('vendors.edit');
            Route::post('update/{id}', 'VendorController@update')
                ->name('vendors.update');
            Route::any('delete/{id}', 'VendorController@destroy')
                ->name('vendors.delete');
            Route::get('status/{id}', 'VendorController@status')
                ->name('vendors.status');
        });
        // End Vendors Routes


// --------------------------------------------------------------------------- //


    });


Route::group(['middleware' => 'guest:admin'], function () {
    Route::get('login', 'LoginController@getLogin')->name('admin.getLogin');
    Route::post('login', 'LoginController@login')->name('admin.login');

});
