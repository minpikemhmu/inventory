<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pickup;
use App\Way;
use App\DeliveryMan;
use App\PaymentType;
use Auth;
use Illuminate\Support\Facades\DB;
use Carbon;
use Response;
use App\Bank;
use App\Http\Resources\SuccesswayResource;
use App\Income;
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

    $paymenttypes=PaymentType::all();
    $banks=Bank::all();
    $ways =Way::doesntHave('income')->where('ways.delivery_man_id',$id)
            ->where('ways.status_code',001)
            ->get();;
    $ways =  SuccesswayResource::collection($ways);
    //dd($ways);
    return Response::json(array(
           'ways' => $ways,
           'paymenttypes' => $paymenttypes,
           'banks'=>$banks,
      ));
  }

  // for add incomes method => store
  public function addincomes(Request $request)
  {
    //dd($request);
    $income=new Income;
    $income->delivery_fees=$request->deliveryfee;
    $income->amount=$request->amount;
    $income->payment_type_id=$request->paymenttype;
    $income->way_id=$request->way_id;
    if($request->paymenttype!=2){
      if($request->bank!="null"){
        $income->bank_id=$request->bank;
        $income->bank_amount=$request->amount;
      } 
    }else if($request->paymenttype!=3){
      if($request->bank!="null"){
      $income->bank_id=$request->bank;
      $income->bank_amount=$request->bank_amount;
      $income->cash_amount=$request->cash_amount;
    }
    }
    $income->save();
    return redirect()->route('incomes.create')->with("successMsg",'Income added successfully');
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
    $ways = Way::where('delivery_man_id',Auth::user()->delivery_man->id)->where('status_code','!=',001)->get();
    $successways = Way::where('delivery_man_id',Auth::user()->delivery_man->id) ->where('status_code',001)->get(); 
    return view('dashboard.ways',compact('ways','successways'));
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
     $request->validate([
            'remark' => 'required',
        ]);
      $wayid = $request->wayid;
       $mytime = Carbon\Carbon::now();
   //dd($ways);
      $way = Way::where('id',$wayid)->first();
      //dd($way);
      $way->status_id = 2;
      $way->status_code = '002';
      $way->remark = $request->remark;
      $way->deleted_at=$mytime;
      $way->save();
    return response()->json(['success'=>'successfully!']);
  }

  public function rejectDeliver(Request $request)
  {
     $request->validate([
            'remark' => 'required',
        ]);
      $wayid = $request->wayid;
    
      $way = Way::where('id',$wayid)->first();
      //dd($way);
      $way->status_id = 3;
      $way->status_code = '003';
      $way->refund_date = date('Y-m-d');
      $way->remark = $request->remark;
      $way->deleted_at=Null;
      $way->save();
    
   return response()->json(['success'=>'successfully!']);
  }
}