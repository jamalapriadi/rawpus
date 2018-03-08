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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::group(['prefix'=>'home'],function(){
    Route::get('/','HomeController@index')->name('home');
    Route::get('role','HomeController@role');
    Route::get('role/{id}/permission','HomeController@permission');
    Route::get('user','HomeController@user');
    Route::get('user/{id}/role','HomeController@user_role');

    Route::get('status-ketenangaan','HomeController@rawpus_status_ketenagaan');
    Route::get('jabatan','HomeController@rawpus_jabatan');
    Route::get('diagnosa','HomeController@rawpus_diagnosa');
    Route::get('tenaga-medis','HomeController@rawpus_tenaga_medis');
    Route::get('pasien','HomeController@rawpus_pasien');

    Route::group(['prefix'=>'data'],function(){
        Route::resource('users','User\UserController');
        Route::resource('roles','User\RoleController');
        Route::resource('permissions','User\PermissionController');
        Route::get('list-role-with-permission/{id}','User\RoleController@list_role_with_permission');
        Route::get('list-role-user','User\UserController@list_role');
        Route::post('save-role-user','User\UserController@save_role_user');
        Route::post('hapus-role-user','User\UserController@hapus_role_user');

        Route::resource('status-ketenagaan','Rawpus\StatusketenagaanController');
        Route::get('list-status-ketenagaan','Rawpus\StatusketenagaanController@list_ketenagaan');

        Route::resource('jabatan','Rawpus\JabatanController');
        Route::resource('diagnosa','Rawpus\DiagnosaController');
        Route::resource('tenaga-medis','Rawpus\TenagamedisController');
        Route::get('list-jabatan','Rawpus\TenagamedisController@list_jabatan');
        Route::resource('pasien','Rawpus\PasienController');
    });
});
