<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware('auth')->group(function () {
  Route::get('dashboard','MainController@dashboard')->name('dashboard');

  // Settings => (cities, townships, statuses, expense_types, payment_types, banks)

  Route::resource('cities','CityController');
  Route::resource('townships','TownshipController');
  Route::resource('statuses','StatusController');
  Route::resource('expense_types','ExpenseTypeController');
  Route::resource('payment_types','PaymentTypeController');
  Route::resource('banks','BankController');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
