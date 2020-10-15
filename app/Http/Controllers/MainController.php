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
}
