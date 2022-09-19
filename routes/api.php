<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Support\Facades\Route;

/*  dokter - ruangan - pasien */

$router->post('login', 'AuthController@login');
$router->post('register', 'AuthController@register');

 $router->get('/dokter', 'DokterController@index');
Route::group(['middleware' => 'auth:api',], function ($router) {

    $router->post('logout', 'AuthController@logout');
    $router->get('me', 'AuthController@me');

   
    $router->get('/dokter/{id}', 'DokterController@show');
    $router->post('/dokter/post', 'DokterController@store');
    $router->put('/dokter/update/{id}', 'DokterController@update');
    $router->delete('/dokter/delete/{id}', 'DokterController@destroy');

    $router->get('/ruangan', 'RuanganController@index');
    $router->get('/ruangan/{id}', 'RuanganController@show');
    $router->post('/ruangan/post', 'RuanganController@store');
    $router->put('/ruangan/update/{id}', 'RuanganController@update');
    $router->delete('/ruangan/delete/{id}', 'RuanganController@destroy');


    $router->get('/pasien', 'PasienController@index');
    $router->get('/pasien/{id}', 'PasienController@show');
    $router->post('/pasien/post', 'PasienController@store');
    $router->put('/pasien/update/{id}', 'PasienController@update');
    $router->delete('/pasien/delete/{id}', 'PasienController@destroy');
});
