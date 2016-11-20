<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::get('/', [
    'uses' => 'ProductController@getIndex',
    'as' => 'product.index',
]);

Route::get('/add-to-cart/{id}', [
    'uses' => 'ProductController@getAddToCart',
    'as' => 'product.addToCart',
]);

Route::get('/shopping-cart', [
    'uses' => 'ProductController@getCart',
    'as' => 'product.shoppingCart',
]);

Route::get('/checkout', [
    'uses' => 'ProductController@getCheckout',
    'as' => 'checkout',
]);

Route::post('/checkout', [
    'uses' => 'ProductController@postCheckout',
    'as' => 'checkout',
]);

Route::group(['prefix' => 'user'], function () {
    Route::group(['middeleware' => 'guest'], function () {
        Route::get('/signup', [
            'uses' => 'UsersController@getSignup',
            'as' => 'user.signup',
        ]);

        Route::post('/signup', [
            'uses' => 'UsersController@postSignup',
            'as' => 'user.signup',
        ]);

        Route::get('/signin', [
            'uses' => 'UsersController@getSignin',
            'as' => 'user.signin',
        ]);

        Route::post('/signin', [
            'uses' => 'UsersController@postSignin',
            'as' => 'user.signin',
        ]);
    });

    Route::group(['middeleware' => 'auth'], function () {
        Route::get('/profile', [
            'uses' => 'UsersController@getProfile',
            'as' => 'user.profile',
        ]);

        Route::get('/logout',[
            'uses' => 'UsersController@getLogout',
            'as' => 'user.logout',
        ]);
    });
});
