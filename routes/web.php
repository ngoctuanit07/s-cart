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
Auth::routes();
//============================
Route::get('/', 'Shop@index');
Route::get('index.html', 'Shop@index');
Route::get('/login.html', 'Shop@showLogin');
Route::get('/shop/{name}_{id}.html', 'Shop@productToCategory');
Route::get('/product/{name}_{id}.html', 'Shop@productDetail');
Route::get('/brand/{name}_{id}/{category?}', 'Shop@productBrand');
Route::get('/profile.html', [
    'middleware' => 'auth',
    'uses'       => 'Shop@profile',
]);
Route::get('/products.html', 'Shop@allProducts');
Route::get('/wishlist.html', 'Shop@wishlist');
Route::get('/compare.html', 'Shop@compare');
Route::get('/cart.html', 'Shop@getCart');
Route::post('/cart.html', 'Shop@postCart')->name('postCart');
Route::get('/search.html', 'Shop@search');
Route::get('/removeItem/{id}', 'Shop@removeItem');
Route::get('/removeItemWishlist/{id}', 'Shop@removeItemWishlist')->name('removeItemWishlist');
Route::get('/removeItemCompare/{id}', 'Shop@removeItemCompare')->name('removeItemCompare');
Route::get('/clearCart', 'Shop@clearCart')->name('clearCart');
Route::post('/addToCart', 'Shop@addToCart');
Route::post('/updateToCart', 'Shop@updateToCart');
Route::post('/storeOrder', 'Shop@storeOrder');
Route::get('/login.html', 'Shop@login');
Route::get('/forgot.html', 'Shop@forgot');
Route::post('/usePromotion', 'Shop@usePromotion');
Route::get('/contact.html', 'Shop@getContact');
Route::post('/contact.html', 'Shop@postContact');
//========end shop ================

//======cms==================
Route::post('/subscribe', 'Cms@emailSubscribe')->name('subscribe');
Route::get('/news.html', 'Cms@news');
Route::get('/news/{name}_{id}.html', 'Cms@newsDetail');
Route::get('/blogs.html', 'Cms@news');
Route::get('/blog/{name}_{id}.html', 'Cms@newsDetail');
Route::get('/{key}.html', 'Cms@pages');
//=====end cms =========

Route::prefix('payment')->group(function () {
    Route::get('paypal', 'PayPalController@index');
    Route::get('return/{order_id}', 'PayPalController@getReturn');
});

//===========auth==============
// Authentication Routes...
// Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('login', function () {
    return redirect('login.html');
})->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
// Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::get('register', function () {
    return redirect('login.html');
})->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
// Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::get('password/reset', function () {
    return redirect('forgot.html');
})->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
//================================
//Language
Route::get('locale/{code}', function ($code) {
    $strQuery  = explode('?', url()->previous());
    $arrParams = [];
    if (!empty($strQuery[1])) {
        parse_str($strQuery[1], $arrParams);
        unset($arrParams['lang']);
    }
    if ($arrParams) {
        $url = $strQuery[0] . '?' . http_build_query($arrParams);
    } else {
        $url = $strQuery[0];
    }
    session(['locale' => $code]);
    return redirect($url);
});
//Currency
Route::get('currency/{code}', function ($code) {
    session(['currency' => $code]);
    return back();
});
