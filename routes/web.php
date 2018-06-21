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


Route::resource('expense', 'ExpenseController');

Route::get('create', 'HomeController@create')->name('create');

Route::get('/expense', 'ExpenseController@index');
Route::get('/expense/create', 'ExpenseController@create');
Route::post('/expense/create', 'ExpenseController@store');
Route::get('/expense/{id}', 'ExpenseController@show');
Route::get('/expense/{id}/edit', 'ExpenseController@edit');
Route::post('/expense/{id}/edit', 'ExpenseController@update');
Route::post('/expense/{id}/delete', 'ExpenseController@destroy');



Route::get('/expenseitem', 'ExpenseController@itemIndex')->name('expenseitem.index');
Route::get('/expenseitem/create', 'ExpenseController@itemCreate')->name('expenseitem.create');
Route::post('/expenseitem', 'ExpenseController@itemStore')->name('expenseitem.store');
Route::get('/expenseitemadd/', 'ExpenseController@itemShow')->name('expenseitem.show');
Route::get('/expenseitem/{id}/edit', 'ExpenseController@itemEdit')->name('expenseitem.edit');
Route::post('/expenseitem/{id}/edit', 'ExpenseController@itemUpdate')->name('expenseitem.update');
Route::delete('/expenseitem/{id}/delete', 'ExpenseController@itemDestroy')->name('expenseitem.destroy');





