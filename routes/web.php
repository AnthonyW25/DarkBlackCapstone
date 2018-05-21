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

Route::get('dashboard', 'HomeController@dashboard')->name('dashboard');

Route::get('create', 'HomeController@create')->name('create');

// BE EXPLICIT ABOUT YOUR ROUTING, IT MAKES IT EASIER FOR OTHERS TO READ
Route::resource('expenseitem', 'ExpenseItemController');
Route::resource('expense', 'ExpenseController');

//new routes boiii
Route::get('expense/create', 'ExpenseController@create');
Route::post('expense/create', 'ExpenseController@store');
Route::get('expense/{id}/edit', 'ExpenseController@edit');
Route::post('expense/{id}/edit', 'ExpenseController@update');

Route::get('expenseitem/create', 'ExpenseItemController@create');
Route::post('expenseitem/create', 'ExpenseItemController@store');
//new routes boiii

Route::get('/expense', 'ExpenseController@index');
Route::get('/expense/{id}', 'ExpenseController@show');