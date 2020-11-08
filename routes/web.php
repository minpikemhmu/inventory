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
  Route::post('rejectitem','MainController@rejectitem')->name('rejectitem');


  // Return List
  Route::get('return_list','MainController@return_list')->name('return_list');
  Route::post('returnitem','MainController@returnitem')->name('returnitem');


  // Delay List
  Route::get('delay_list','MainController@delay_list')->name('delay_list');

  // Financial Statement
  Route::get('statements','MainController@financial_statements')->name('statements');

  // Debt List
  Route::get('debt_list','MainController@debt_list')->name('debt_list');
  Route::post('updateincome','MainController@updateincome')->name('updateincome');
  Route::post('incomesearch','MainController@incomesearch')->name('incomesearch');
 Route::post('expensesearch','MainController@expensesearch')->name('expensesearch');
  Route::post('profit','MainController@profit')->name('profit');
  //pickupdone by delivery man
  Route::get('pickupdone/{id}','MainController@pickupdone')->name('pickupdone');

  // staff
  Route::resource('staff','StaffController');

  //  For Staff
  Route::resource('schedules', 'ScheduleController');
  Route::post('uploadfile', 'ScheduleController@uploadfile')->name('uploadfile');
  Route::post('storeandassignschedule', 'ScheduleController@storeandassignschedule')->name('schedules.storeandassign');

  Route::resource('items', 'ItemController');
  Route::get('items/collectitem/{cid}/{pid}','ItemController@collectitem')->name('items.collect');
  Route::post('itemdetail','ItemController@itemdetail')->name('itemdetail');
  Route::post('wayassign','ItemController@assignWays')->name('wayassign');

  Route::post('updatewayassign','ItemController@updatewayassign')->name('updatewayassign');

  Route::get('deletewayassign/{id}','ItemController@deletewayassign')->name('deletewayassign');
  

  Route::resource('clients', 'ClientController');
  Route::resource('delivery_men', 'DeliveryMenController');

  Route::get('incomes', 'MainController@incomes')->name('incomes');
  Route::get('incomes/addincomes', 'MainController@addincomeform')->name('incomes.create');
  Route::get('incomes/getsuccesswaysbydeliveryman/{id}', 'MainController@successways')->name('incomes.successways');
  Route::post('incomes/addincomes', 'MainController@addincomes')->name('incomes.store');

  Route::resource('expenses','ExpenseController');

  // For Client
  Route::get('pickups','MainController@pickups')->name('pickups');
  Route::post('pickups','MainController@donepickups')->name('donepickups');
  Route::post('delichargebytown','ItemController@delichargebytown')->name('delichargebytown');
  Route::get('ways','MainController@ways')->name('ways');
  Route::post('makeDelivered','MainController@makeDeliver')->name('makeDeliver');
  Route::post('retuenDeliver','MainController@retuenDeliver')->name('retuenDeliver');
  Route::post('rejectDeliver','MainController@rejectDeliver')->name('rejectDeliver');
});

Route::resource('profiles','ProfileController');

Auth::routes(['register'=>false]);

Route::get('/home', 'HomeController@index')->name('home');
