<?php

declare(strict_types=1);

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

// Index
Route::get('/', 'HomeController@integrasafeIndex')->name('integrasafe:index');

// Temporary Routes
Route::get('/signin', 'IntegrasafeController@temporary')->name('integrasafe:signin[get]');

// Frequently Asked Questions
Route::get('/faqs', function () {
    return view('integrasafe.faqs');
})->name('integrasafe:faqs[get]');

// Newsletter signup
Route::post('/newsletter', 'IntegrasafeController@newsletter')->name('integrasafe:newsletter[post]');

// Careers
Route::get('/careers', 'IntegrasafeController@careers')->name('integrasafe:careers[get]');

// Purchase Flow
Route::group(['prefix' => 'purchase'], function () {
    // Product Selection
    Route::get('/', 'IntegrasafeController@purchaseIndex')->name('integrasafe:purchase[get]');
    Route::post('/', 'IntegrasafeController@selectedProducts')->name('integrasafe:purchase[post]');
    // Payment and Shipping
    Route::get('/payment', 'IntegrasafeController@paymentIndex')->name('integrasafe:payment[get]');
    Route::post('/payment', 'PurchaseController@review')->name('integrasafe:payment[post]');
    // Review and Purchase
    Route::post('/review', 'PurchaseController@purchase')->name('integrasafe:review[post]');
});

// Customer's Cart
Route::group(['prefix' => 'cart'], function () {
    Route::post('/add', 'CartController@addToCart')->name('integrasafe:cart/add[post]');
    Route::post('/remove', 'CartController@removeFromCart')->name('integrasafe:cart/remove[post]');
    Route::post('/update', 'CartController@addToCart')->name('integrasafe:cart/update[post]');
    Route::get('/get', 'CartController@addToCart')->name('integrasafe:cart/get[get]');
});

// Create a Product for Stripe (For direct testing purposes only!)
Route::get('/create/product', 'SuperProductController@createIndex');
Route::post('/create/product', 'SuperProductController@createProduct');

//Added By Cong
Route::get('/product', 'ProductController@createIndex');

Route::get('/services', function () {
    return view('admin.services');
});

// Global contact route
Route::group(['prefix' => 'contact-us'], function () {
    Route::get('/', 'ContactController@showContact')->name('contact-us[get]');
    Route::post('/message', 'ContactController@submitContact')->name('contact-us[post]');
});

// Global social networks routes
Route::get('social-networks', 'ContactController@social')->name('social-networks');

/**
 * Global feedback routes
 */
Route::get('/feedback', 'MultiController@feedbackForm')->name('feedback[get]');
Route::post('/feedback', 'MultiController@feedback')->name('feedback[post]');

// Global policy documents routes
Route::get('privacy-policy', 'PolicyController@privacy')->name('privacy-policy');
Route::get('terms-of-service', 'PolicyController@termsOfService')->name('terms-of-service');

// Global web standards route
Route::get('sitemap.xml', 'SEOController@siteMapXML');
Route::get('atom.xml', 'SEOController@atomXML');
Route::get('rss.xml', 'SEOController@rssXML');

// Global logout route
Route::get('logout', 'Auth\Login@logout')->name('logout');

// Global login routes
Route::get('login', function () {
    return view('auth.login');
})->name('login[get]');
Route::post('login', 'Auth\Login@login')->name('login[post]');

// Global password reset routes
Route::get('password/reset', 'Auth\ResetPasswordController@show');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

// Global Register routes
Route::get('register', 'AccountController@register')->name('register[get]');
Route::post('register', 'AccountController@store')->name('register[post]');

/**
 * Global social providers
 */
Route::get('/social/redirect/{provider}', ['as' => 'social.' . 'redirect', 'uses' => 'Auth\SocialController@getSocialRedirect']);
Route::get('/social/handle/{provider}', ['as' => 'social.' . 'handle', 'uses' => 'Auth\SocialController@getSocialHandle']);

/*
 * Global subscription routes
 */
Route::post('subscribe', 'Email\MailingController@create')->name('subscribe[post]');
Route::get('subscribe', 'Email\MailingController@subscribe')->name('subscribe[get]');
Route::get('emails/custompcb/unsubscribe', 'Email\MailingController@unsubscribePCB')->name('unsubscribe');

// Stripe Webhook
Route::post(
    'stripe/webhook',
    '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook'
);
