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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//New route for getting the dashboard

Auth::routes();

Route::get('dashboard', 'HomeController@dashboard')->name('dashboard');

Auth::routes();

Route::get('create', 'HomeController@create')->name('create');

Route::resource('expenseitem', 'ExpenseItemController');
Route::resource('expense', 'ExpenseController');