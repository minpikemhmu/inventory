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
use App\Http\Resources\IncomeResource;
use App\Http\Resources\ExpenseResource;
use App\Income;
use App\Notifications\RejectNotification;
use App\Notifications\SeenNotification;
use App\Expense;
use Yajra\DataTables\Facades\DataTables;
use Notification;
use App\User;
use App\Events\rejectitem;
use Illuminate\Notifications\DatabaseNotification;
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
    $rejectways=Way::where('refund_date','!=',null)->orderBy('id','desc')->get();
    return view('dashboard.reject_list',compact('rejectways'));
  }

  // for return list page
  public function return_list($value='')
  {
    $returnways=Way::where('deleted_at','!=',null)->orderBy('id','desc')->get();
    return view('dashboard.return_list',compact('returnways'));
  }

  public function rejectitem(Request $request){
    $id=$request->id;
   // dd($id);
    $returnitems=DB::table('items')
            ->join('pickups', 'pickups.id', '=', 'items.pickup_id')
            ->join('schedules', 'schedules.id', '=', 'pickups.schedule_id')
            ->join('clients', 'clients.id', '=', 'schedules.client_id')
            ->join('users', 'users.id', '=', 'clients.user_id')
            ->select('items.*', 'clients.contact_person as cperson', 'clients.phone_no as cphone','clients.address as caddress','users.name as uname')
            ->where('items.id',$id)
            ->get();
            return $returnitems;
  }

  public function returnitem(Request $request){
    $id=$request->id;
   // dd($id);
    $returnitems=DB::table('items')
            ->join('pickups', 'pickups.id', '=', 'items.pickup_id')
            ->join('schedules', 'schedules.id', '=', 'pickups.schedule_id')
            ->join('clients', 'clients.id', '=', 'schedules.client_id')
            ->join('users', 'users.id', '=', 'clients.user_id')
            ->select('items.*', 'clients.contact_person as cperson', 'clients.phone_no as cphone','clients.address as caddress','users.name as uname')
            ->where('items.id',$id)
            ->get();
            return $returnitems;
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
     $incomes=Income::whereDate('created_at', Carbon\Carbon::today())->where('amount','=',Null)->get();
     //dd($incomes);
    return view('dashboard.debt_list',compact('incomes'));
  }

  //update imcome
  public function updateincome(Request $request){
    $id=$request->id;
    $income=Income::find($id);
    $income->delivery_fees=$request->deliamount;
    $income->amount=$request->amount;
    $income->save();
    return "success";
  }

//search income by date
public function incomesearch(Request $request){
  $start_date=$request->start_date;
  $end_date=$request->end_date;
  $incomes=Income::whereBetween('created_at', [$start_date.' 00:00:00',$end_date.' 23:59:59'])->where('amount','!=',Null)->get();
   $myincomes =  IncomeResource::collection($incomes);
   //dd($myincomes);
  return Datatables::of($myincomes)->addIndexColumn()->toJson();
}

//expensesearch
public function expensesearch(Request $request){
  $start_date=$request->start_date;
  $end_date=$request->end_date;
  //dd($end_date);
  $expenses=Expense::whereBetween('created_at', [$start_date.' 00:00:00',$end_date.' 23:59:59'])->get();
  //dd($expenses);
   $myexpenses =  ExpenseResource::collection($expenses);

 // dd($myexpenses);
  return Datatables::of($myexpenses)->addIndexColumn()->toJson();
}

//profit
public function profit(Request $request){
  $start_date=$request->start_date;
  $end_date=$request->end_date;
  $allincomes=Income::whereBetween('created_at', [$start_date.' 00:00:00',$end_date.' 23:59:59'])->sum('amount');
  $allexpenses=Expense::whereBetween('created_at', [$start_date.' 00:00:00',$end_date.' 23:59:59'])->sum('amount');
  return Response::json(array(
           'income' => $allincomes,
           'expense' => $allexpenses,
      ));
}
  // for income list page
  public function incomes($value='')
  {
    $incomes=Income::whereDate('created_at', Carbon\Carbon::today())->where('amount','!=',Null)->get();
    return view('dashboard.incomes',compact('incomes'));
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
   
    if($request->paymenttype==1){
       $income->cash_amount=$request->amount;
    }
    else if($request->paymenttype==2){
      if($request->bank!="null"){
        $income->bank_id=$request->bank;
        $income->cash_amount=null;
        $income->bank_amount=$request->amount;
      } 
    }else if($request->paymenttype==3){
      if($request->bank!="null"){
      $income->bank_id=$request->bank;
      $income->bank_amount=$request->bank_amount;
      $income->cash_amount=$request->cash_amount;
      }
    }
    else if($request->paymenttype==4){
      $income->amount=null;
      $income->delivery_fees=null;
    }else{
      $income->amount=null;
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
    $seen="seen";
     Notification::send($ways,new SeenNotification($seen));
    //dd("ok");
    event(new rejectitem($ways));
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
      //$waynoti="reject";
      Notification::send($way,new RejectNotification($way));
    //dd("ok");
    event(new rejectitem($way));
      
   return response()->json(['success'=>'successfully!']);
  }

  public function rejectnoti(){
    //$notidata=array();
    $cs=array();
    if(Auth::check()){
      $rejectways=Way::where('refund_date','!=',null)->orderBy('id','desc')->get();
     foreach ($rejectways as $ways) {
        foreach ($ways->unreadNotifications as $notification) {
          
          array_push($cs, $notification->data);
        }
       # code...
     }
    }
    return $cs;

  /* for($i=0;$i<count($cs);$i++){
    array_push($notidata, $cs)
     
  }*/
   }

   public function clearrejectnoti($id){
   // dd($id);
    $mytime = Carbon\Carbon::now();
      $date=$mytime->toDateString();
      $userconfirm= DB::table('notifications')->where('id', $id)->update(array('read_at' => $date));
      return redirect()->route('reject_list');
   }

   public function seennoti(){
     $ways = Way::all();
     return $ways;
   }
}