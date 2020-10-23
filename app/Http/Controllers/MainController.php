<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pickup;
use App\Way;
use App\DeliveryMan;
use Auth;

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
    $delivery_men = DeliveryMan::all();
    return view('dashboard.addincomes',compact('delivery_men'));
  }

  // get the success ways by deliveryman
  public function successways($id)
  {
    $ways = Way::where('delivery_man_id',$id)->where('status_code',001)->get();
    return $ways;
  }

  // for add incomes method => store
  public function addincomes(Request $request)
  {
    
  }

  // for pickup page => delivery man view
  public function pickups($value='')
  {
    $role=Auth::user()->roles()->first();
    $rolename=$role->name;
    $pickups="";
    if($rolename="delivery_man"){
      $user=Auth::user();
      $id=$user->delivery_man->id;
      $pickups=Pickup::where('delivery_man_id',$id)->doesntHave('items')->get();
    }
    //dd($pickups);
    return view('dashboard.pickups',compact('pickups'));
  }


  public function pickupdone($id){
    //dd($id);
    $pickup=Pickup::find($id);
    $pickup->status=1;
    $pickup->save();
  return redirect()->route('pickups')->with("successMsg",'Pickup successfully');

  }

  // for way page => delivery man view
  public function ways($value='')
  {
    // ways assigned for that user (must delivery_date and refund_date equal NULL)
    $ways = Way::where('delivery_man_id',Auth::user()->delivery_man->id)->get(); 
    return view('dashboard.ways',compact('ways'));
  }

  public function makeDeliver(Request $request)
  {
    $ways = $request->ways;
    //dd($ways);
    foreach ($ways as $way) {
      $way = Way::where('id',$way)->first();
      //dd($way);
      $way->status_id = 1;
      $way->status_code = '001';
       $way->remark =Null;
      $way->delivery_date = date('Y-m-d');
      $way->save();
    }
    return 'success';
  }
   public function retuenDeliver(Request $request)
  {
    //dd($request);
    $ways = $request->ways;
   //dd($ways);
    foreach ($ways as $way) {
      $way = Way::where('id',$way)->first();
      //dd($way);
      $way->status_id = 2;
      $way->status_code = '002';
      $way->refund_date = date('Y-m-d');
      $way->remark = $request->remark;
      $way->save();
    }
    return redirect()->route('ways');
  }

  public function rejectDeliver(Request $request)
  {
    //dd($request);
    $ways = $request->ways;
   //dd($ways);
    foreach ($ways as $way) {
      $way = Way::where('id',$way)->first();
      //dd($way);
      $way->status_id = 3;
      $way->status_code = '003';
      $way->refund_date = date('Y-m-d');
      $way->remark = $request->remark;
      $way->save();
    }
    return redirect()->route('ways');
  }
}