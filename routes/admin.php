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

            Route::any('delete/{id}', 'MainCategoryController@destroy')
                ->name('main-cats.delete');
        });

//        Route::resource('main-cats', 'MainCategoryController');
        // End Main Categories Routes


// --------------------------------------------------------------------------- //





    });


Route::group(['middleware' => 'guest:admin'], function () {
    Route::get('login', 'LoginController@getLogin')->name('admin.getLogin');
    Route::post('login', 'LoginController@login')->name('admin.login');

});
