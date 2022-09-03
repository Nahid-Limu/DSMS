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


// Route::get('/', function () {
//         return view('auth.login');
//     });
Route::view('/', 'auth.login');

Auth::routes();
Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/company', 'CompanyController@index')->name('company');
    Route::post('/addCompany', 'CompanyController@addCompany')->name('addCompany');
    // Route::get('/editTest/{id}', 'TestController@editTest')->name('editTest');
    // Route::post('/updateTest', 'TestController@updateTest')->name('updateTest');
    Route::get('/deleteCompany/{id}', 'CompanyController@deleteCompany')->name('deleteCompany');
    
});