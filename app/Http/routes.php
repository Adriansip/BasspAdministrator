<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::post('/login', 'UserController@login');

Route::resource('/users', 'UserController');

//Licencias
Route::resource('/services', 'ServiceSecurityController');

//Funciones
Route::resource('/functions', 'CatStepProcController');

//tbl_admin_support
Route::resource('/adminsupports', 'AdminSupportController');

//tbl_notificaciones
Route::resource('/notifications', 'NotificationsController');

//cat_plataform
Route::resource('/plataforms', 'PlataformController');
