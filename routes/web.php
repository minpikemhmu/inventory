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

  Route::prefix('settings')->group(function () {
    // Settings => (cities, townships, statuses, expense_types, payment_types, banks)
    Route::resource('cities','CityController');
    Route::resource('townships','TownshipController');
    Route::resource('statuses','StatusController');
    Route::resource('expense_types','ExpenseTypeController');
    Route::resource('payment_types','PaymentTypeController');
    Route::resource('banks','BankController');
  });

  // Success List
  Route::get('success_list','MainController@success_list')->name('success_list');

  // Reject List
  Route::get('reject_list','MainController@reject_list')->name('reject_list');

  // Return List
  Route::get('return_list','MainController@return_list')->name('return_list');

  // Delay List
  Route::get('delay_list','MainController@delay_list')->name('delay_list');

  // Financial Statement
  Route::get('statements','MainController@financial_statements')->name('statements');

  // Debt List
  Route::get('debt_list','MainController@debt_list')->name('debt_list');

  // staff
  Route::resource('staff','StaffController');

  //  For Staff
  Route::resource('schedules', 'ScheduleController');
  Route::post('uploadfile', 'ScheduleController@uploadfile')->name('uploadfile');
  Route::post('storeandassignschedule', 'ScheduleController@storeandassignschedule')->name('schedules.storeandassign');

  Route::resource('items', 'ItemController');
  Route::get('collectitem/{id}','ItemController@collectitem')->name('items.collect');

  Route::resource('clients', 'ClientController');
  Route::resource('delivery_men', 'DeliveryMenController');

  Route::get('incomes', 'MainController@incomes')->name('incomes');
  Route::get('addincomes', 'MainController@addincomeform')->name('incomes.create');
  Route::post('addincomes', 'MainController@addincomes')->name('incomes.store');

  Route::resource('expenses','ExpenseController');

  // For Client
  Route::get('pickups','MainController@pickups')->name('pickups');
  Route::get('ways','MainController@ways')->name('ways');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
