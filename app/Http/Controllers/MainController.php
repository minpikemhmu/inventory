<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
  // for dashboard main page
  public function dashboard($value='')
  {
    return view('dashboard.index');
  }

  // for success list page
  public function success_list($value='')
  {
    return view('dashboard.success_list');
  }

  // for reject list page
  public function reject_list($value='')
  {
    return view('dashboard.reject_list');
  }

  // for return list page
  public function return_list($value='')
  {
    return view('dashboard.return_list');
  }

  // for delay list page
  public function delay_list($value='')
  {
    return view('dashboard.delay_list');
  }

  // financial_statements
  public function financial_statements($value='')
  {
    return view('dashboard.financial_statements');
  }

  // for debt list page
  public function debt_list($value='')
  {
    return view('dashboard.debt_list');
  }

  // for income list page
  public function incomes($value='')
  {
    return view('dashboard.incomes');
  }

  // for add incomes form page
  public function addincomeform($value='')
  {
    return view('dashboard.addincomes');
  }

  // for add incomes method => store
  public function addincomes(Request $request)
  {
    
  }

  // for pickup page => delivery man view
  public function pickups($value='')
  {
    return view('dashboard.pickups');
  }

  // for way page => delivery man view
  public function ways($value='')
  {
    return view('dashboard.ways');
  }
}