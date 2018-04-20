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

Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::group(['middleware' => 'guest'], function () {
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
});

Route::get('/', 'FHomeController@index')->name('front.index');
$all_langs = config('app.all_langs');
foreach($all_langs as $prefix){
    Route::group(['prefix' => $prefix, 'middleware' => 'configcookieslang'], function() use ($prefix) {
        Route::get('/', 'FIndexController@index');
        Route::get(\Lang::get('route.fasilitas',[], $prefix), 'FFasilitasController@index')->name('front.fasilitas.index');
        Route::get(\Lang::get('route.fasilitas',[], $prefix).'/{slug}', 'FFasilitasController@detail')->name('front.fasilitas.detail');
        Route::get(\Lang::get('route.about',[], $prefix), 'FAboutController@index')->name('front.about');
        Route::get(\Lang::get('route.aktivitas',[], $prefix), 'FAktivitasController@index')->name('front.aktivitas.index');
        Route::get(\Lang::get('route.contact',[], $prefix), 'FContactController@index')->name('front.contact.index');
        Route::post(\Lang::get('route.contact',[], $prefix), 'FContactController@store')->name('front.contact.store');
    });
}

Route::get('sitemap.xml', 'FSiteMapController@siteMapRobot');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    Route::get('/', ['as' => 'admin.index', 'uses' => 'HomeController@index']);
    Route::resource('email', 'BEmailController', ['except' => 'show']);
    Route::resource('social-link', 'BSocialController', ['except' => 'show']);
    Route::resource('user', 'BAdminController', ['only' => [
        'index', 'create', 'store','destroy'
    ]]);
    Route::post('contact-messages/confirm',['as' => 'contact-messages.confirm', 'uses' => 'BContactController@confirm']);
    Route::resource('contact-messages', 'BContactController', ['only' => [
        'index', 'destroy'
    ]]);
    Route::get('changepassword','BUserController@password');
    Route::post('changepassword','BUserController@updatepassword');
    Route::get('menu-utama',['as' => 'menu-utama.index', 'uses' => 'BMenuUtamaController@index']);
    Route::get('menu-utama/{id}/edit',['as' => 'menu-utama.edit', 'uses' => 'BMenuUtamaController@edit']);
    Route::patch('menu-utama/{id}',['as' => 'menu-utama.update', 'uses' => 'BMenuUtamaController@update']);

    Route::get('config/homeslider',['as' => 'config.homeslider.index', 'uses' => 'BHomeSliderController@index']);
    Route::get('config/homeslider/create',['as' => 'config.homeslider.create', 'uses' => 'BHomeSliderController@create']);
    Route::post('config/homeslider',['as' => 'config.homeslider.store', 'uses' => 'BHomeSliderController@store']);
    Route::get('config/homeslider/{id}/edit',['as' => 'config.homeslider.edit', 'uses' => 'BHomeSliderController@edit']);
    Route::patch('config/homeslider/{id}',['as' => 'config.homeslider.update', 'uses' => 'BHomeSliderController@update']);
    Route::delete('config/homeslider/{id}',['as' => 'config.homeslider.destroy', 'uses' => 'BHomeSliderController@destroy']);

    Route::get('config/fasilitas',['as' => 'config.fasilitas.index', 'uses' => 'BFasilitasController@index']);
    Route::get('config/fasilitas/create',['as' => 'config.fasilitas.create', 'uses' => 'BFasilitasController@create']);
    Route::post('config/fasilitas',['as' => 'config.fasilitas.store', 'uses' => 'BFasilitasController@store']);
    Route::get('config/fasilitas/{id}',['as' => 'config.fasilitas.edit', 'uses' => 'BFasilitasController@edit']);
    Route::patch('config/fasilitas/{id}',['as' => 'config.fasilitas.update', 'uses' => 'BFasilitasController@update']);
    Route::delete('config/fasilitas/{id}',['as' => 'config.fasilitas.destroy', 'uses' => 'BFasilitasController@destroy']);

    Route::get('config/aktivitas',['as' => 'config.aktivitas.index', 'uses' => 'BAktivitasController@index']);
    Route::get('config/aktivitas/create',['as' => 'config.aktivitas.create', 'uses' => 'BAktivitasController@create']);
    Route::post('config/aktivitas',['as' => 'config.aktivitas.store', 'uses' => 'BAktivitasController@store']);
    Route::get('config/aktivitas/{id}',['as' => 'config.aktivitas.edit', 'uses' => 'BAktivitasController@edit']);
    Route::patch('config/aktivitas/{id}',['as' => 'config.aktivitas.update', 'uses' => 'BAktivitasController@update']);
    Route::delete('config/aktivitas/{id}',['as' => 'config.aktivitas.destroy', 'uses' => 'BAktivitasController@destroy']);

    Route::get('config/aktivitas-category/create',['as' => 'config.cataktivitas.create', 'uses' => 'BAktivitasCatController@create']);
    Route::post('config/aktivitas-category',['as' => 'config.cataktivitas.store', 'uses' => 'BAktivitasCatController@store']);
    Route::get('config/aktivitas-category/{id}',['as' => 'config.cataktivitas.edit', 'uses' => 'BAktivitasCatController@edit']);
    Route::patch('config/aktivitas-category/{id}',['as' => 'config.cataktivitas.update', 'uses' => 'BAktivitasCatController@update']);
    Route::delete('config/aktivitas-category/{id}',['as' => 'config.cataktivitas.destroy', 'uses' => 'BAktivitasCatController@destroy']);

    Route::get('config/header-image/{parent_id}',['as' => 'config.headerimage.index', 'uses' => 'BHeaderImageController@index']);
    Route::get('config/header-image/{parent_id}/create',['as' => 'config.headerimage.create', 'uses' => 'BHeaderImageController@create']);
    Route::post('config/header-image/{parent_id}',['as' => 'config.headerimage.store', 'uses' => 'BHeaderImageController@store']);
    Route::get('config/header-image/{id}/edit',['as' => 'config.headerimage.edit', 'uses' => 'BHeaderImageController@edit']);
    Route::patch('config/header-image/{id}',['as' => 'config.headerimage.update', 'uses' => 'BHeaderImageController@update']);
    Route::delete('config/header-image/{id}',['as' => 'config.headerimage.destroy', 'uses' => 'BHeaderImageController@destroy']);

    Route::get('config/onpage-contact',['as' => 'config.onpage-contact.edit', 'uses' => 'BOnPageController@contact']);
    Route::patch('config/onpage-contact',['as' => 'config.onpage-contact.update', 'uses' => 'BOnPageController@updatecontact']);

    Route::get('web-config',['as' => 'web-config.index', 'uses' => 'BWebConfigController@index']);
    Route::patch('web-config',['as' => 'web-config.update', 'uses' => 'BWebConfigController@update']);

    Route::get('filemanager',['as' => 'filemanager.index', 'uses' => 'BWebConfigController@filemanager']);

    Route::post('data-registrasi/confirm',['as' => 'data-registrasi.confirm', 'uses' => 'BRegistrasiController@confirm']);
    Route::resource('data-registrasi', 'BRegistrasiController', ['only' => [
        'index', 'destroy'
    ]]);
});
Route::get('storage/{folder}/{filename}', 'StorageController@setstorage');
