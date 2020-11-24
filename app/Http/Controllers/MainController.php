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
use App\Client;
use Notification;
use App\User;
use App\Events\rejectitem;
use Illuminate\Notifications\DatabaseNotification;
use App\Item;
use App\Exports\SuccesslistExport;
use Excel;

class MainController extends Controller
{


  // for dashboard main page
  public function dashboard($value='')
  {
    return view('dashboard.index');
  }

  public function getways($value='')
  {
    $data = Way::selectRaw('COUNT(*) as count, YEAR(created_at) year, MONTH(created_at) month')
    ->groupBy('year', 'month')
    ->get();
    // dd($data);
    $ways = [100,150,50,115,20,55,64,17,20,35,49,0];

    $success_ways = 10;
    $reject_ways = 1;
    
    return Response::json(array(
      'ways' => $ways,
      'success_ways' => $success_ways,
      'reject_ways' => $reject_ways
    ));
  }

  // for success list page
  public function success_list($value='')
  {
    $delivery_men = DeliveryMan::all();
    $success_ways = Way::where('status_code','001')->get();
    return view('dashboard.success_list',compact('delivery_men','success_ways'));
  }

  // for reject list page
  public function reject_list($value='')
  {
    $rejectways=Way::where('refund_date',null)->where('status_code','003')->orderBy('id','desc')->get();
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

   // dd($delayitems);
       $deliverymen = DeliveryMan::all();
     $mytime = Carbon\Carbon::now();
    $delayitems=Item::doesntHave('way')->whereDate('created_at','!=', Carbon\Carbon::today())->get();
    return view('dashboard.delay_list',compact('delayitems','deliverymen'));
  }

  public function delaycount(){
    $mytime = Carbon\Carbon::now();
    $delayitems=Item::doesntHave('way')->whereDate('created_at','!=', Carbon\Carbon::today())->get();
    $delaycount=count($delayitems);
    return $delaycount;

  }
  // financial_statements
  public function financial_statements($value='')
  {
    return view('dashboard.financial_statements');
  }

  // for debt list page
  public function debt_list($value='')
  {
    // $incomes=Income::whereDate('created_at', Carbon\Carbon::today())->where('amount','=',Null)->get();
    //dd($incomes);
    $clients = Client::all();

    $role=Auth::user()->roles()->first();
    $rolename=$role->name;
    if($rolename == "client") {
      $client_id=Auth::user()->client->id;
      $expenses = Expense::where('client_id',$client_id)->where('status',2)->with('expense_type')->get();

      $incomes = Income::whereIn('payment_type_id',[4,5,6])->with('way.item.pickup.schedule')->whereHas('way.item.pickup.schedule',function ($query) use ($client_id){
        $query->where('client_id', $client_id);
      })->get();

      $rejects =  Way::with('item.pickup.schedule')
      ->whereHas('item.pickup.schedule', function($query) use ($client_id){
          $query->where('client_id', $client_id);
      })->where('status_code','003')->where('refund_date',null)->get();

      return view('dashboard.debt_list',compact('clients', 'expenses', 'incomes', 'rejects'));
    }

    return view('dashboard.debt_list',compact('clients'));
  }

  public function getdebitlistbyclient($id)
  {
    // $client = Client::find($id);
    $expenses = Expense::where('client_id',$id)->where('status',2)->with('expense_type')->get();

    $incomes = Income::whereIn('payment_type_id',[4,5,6])->with('way.item.pickup.schedule')->whereHas('way.item.pickup.schedule',function ($query) use ($id){
      $query->where('client_id', $id);
    })->get();

    // dd($incomes);

    $rejects =  Way::with('item.pickup.schedule')
    ->whereHas('item.pickup.schedule', function($query) use ($id){
        $query->where('client_id', $id);
    })->where('status_code','003')->where('refund_date',null)->get();

    $myarray=[];
    foreach ($rejects as $income) {
     foreach ($income->unreadNotifications as $notification) {
      //dd($notification->id);
       array_push($myarray, $notification->id);
     }
    }
    //dd($myarray);

    return Response::json(array(
            'rejectnoti'=>$myarray,
           'expenses' => $expenses,
           'rejects' => $rejects,
           'incomes' => $incomes
      ));
  }

  public function fix_debit(Request $request)
  {
    $request->validate([
      'client' => 'required'
    ]);

    $notiarray=explode(",", $request->noti);
    //dd($notiarray);
    $mytime = Carbon\Carbon::now();
    $date=$mytime->toDateString();

    foreach ($notiarray as $notiid) {
      $userconfirm= DB::table('notifications')->where('id', $notiid)->update(array('read_at' => $date));
    }
    
    $id = $request->client;
    $expenses = Expense::where('client_id',$id)->where('status',2)->with('expense_type')->get();

    foreach ($expenses as $expense) {
      $expense->status = 1;
      $expense->save();
    }

    $rejects =  Way::with('item.pickup.schedule')->whereHas('item.pickup.schedule', function($query) use ($id){
        $query->where('client_id', $id);
    })->where('status_code','003')->where('refund_date',null)->get();

    foreach ($rejects as $way) {
      $income = new Income;
      $income->delivery_fees = 0;
      $income->deposit = $way->item->deposit;
      $income->amount = $way->item->deposit;
      $income->cash_amount = $way->item->deposit;
      $income->way_id = $way->id;
      $income->payment_type_id = 1;
      $income->save();

      $way->refund_date = date('Y-m-d');
      $way->save();
    }

    $incomes = Income::whereIn('payment_type_id',[4,5,6])->with('way.item.pickup.schedule')->whereHas('way.item.pickup.schedule',function ($query) use ($id){
      $query->where('client_id', $id);
    })->get();
    foreach ($incomes as $income) {
      $income->delivery_fees = $income->way->item->delivery_fees;
      $income->deposit = $income->way->item->deposit;
      $income->amount = $income->way->item->amount;
      $income->cash_amount = $income->way->item->amount;
      $income->payment_type_id = 1;
      $income->save();
    }

    return back();
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
  $netincomes=Income::whereBetween('created_at', [$start_date.' 00:00:00',$end_date.' 23:59:59'])->sum('delivery_fees');
  $allexpenses=Expense::whereBetween('created_at', [$start_date.' 00:00:00',$end_date.' 23:59:59'])->where('expense_type_id','!=',1)->sum('amount');
  return Response::json(array(
           'allincomes' => $allincomes,
           'netincomes' => $netincomes,
           'expenses' => $allexpenses,
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
            ->get();
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
    // dd($request);

    //validation
    $request->validate([
      // "carryfees" => 'sometimes|required'
    ]);

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

    // if carry fees (carryfees)
    if($request->carryfees){
      $expense = new Expense;
      $expense->amount = $request->carryfees;
      $expense->description = 'Carry Fees';
      $expense->expense_type_id = 4;
      $expense->staff_id = Auth::user()->staff->id;
      $expense->city_id = 1;
      $expense->item_id = $income->way->item_id;
      $expense->status = 1;
      $expense->save();
    }

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
    $ways = Way::where('delivery_man_id',Auth::user()->delivery_man->id)->where('status_code','!=',001)->where('deleted_at',null)->get();
    
    $successways = Way::where('delivery_man_id',Auth::user()->delivery_man->id) ->where('status_code',001)->get(); 

    foreach ($ways as $way) {
      if(Carbon\Carbon::today()>$way->created_at && $way->status_code==005){
        $way->delete();
      }
     
      $notifications=DB::table('notifications')->select('data')->get();
        // dd($notifications);
         $data = [];
        if(count($notifications)>0){
            //dd("hi");
            foreach ($notifications as $noti) {
                $notiarray=json_decode($noti->data);
                $data[] = $notiarray->ways->id;
            }
        }

          if(Carbon\Carbon::today()->toDateString()==$way->created_at->toDateString() && $way->status_code==005 && !in_array($way->id, $data)){
            Notification::send($way,new SeenNotification($way));
    //dd("ok");
             event(new rejectitem($way));
          }
    }

    $ways = Way::where('delivery_man_id',Auth::user()->delivery_man->id)->where('status_code','!=',001)->where('deleted_at',null)->get();

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
            'date' => 'required'
        ]);
      $wayid = $request->wayid;
      $mytime = Carbon\Carbon::now();
      //dd($ways);
      $way = Way::where('id',$wayid)->first();
      //dd($way);
      // $way->status_id = 2;
      // $way->status_code = '002';
      // $way->remark = $request->remark;
      $way->delete();

      $way->item->expired_date = $request->date;
      $way->item->error_remark = $request->remark;
      $way->item->save();

    return response()->json(['success'=>'successfully!']);
  }

  public function rejectDeliver(Request $request)
  {
     $request->validate([
            'remark' => 'required',
        ]);
      $wayid = $request->wayid;
    
      $way = Way::where('id',$wayid)->first();
      if($way->status_id!=3){
      $way->status_id = 3;
      $way->status_code = '003';
      // $way->refund_date = date('Y-m-d');
      $way->remark = $request->remark;
      $way->deleted_at=Null;
      $way->save();
      //$waynoti="reject";
      Notification::send($way,new RejectNotification($way));
    //dd("ok");
    event(new rejectitem($way));
      }
      //dd($way);
     
      
   return response()->json(['success'=>'successfully!']);
  }

  // for cancel list => client side
  public function cancel($value='')
  {
    $client_id=Auth::user()->client->id;
    // $ways = Way::where('status_id',3)->get();

    $ways =  Way::with('item.pickup.schedule')->whereHas('item.pickup.schedule', function($query) use ($client_id){
        $query->where('client_id', $client_id);
    })->where('status_code','003')->get();

    return view('dashboard.cancel',compact('ways'));
  }

  public function rejectnoti(){
    //$notidata=array();
    $cs=array();
    if(Auth::check()){
      $rejectways=Way::where('status_code','003')->orderBy('id','desc')->get();
     // dd($rejectways);
     foreach ($rejectways as $ways) {
        foreach ($ways->unreadNotifications as $notification) {
          if($notification->data["ways"]["status_code"]=="003"){
            array_push($cs, $notification->data);
          }
        }
       # code...
     }
    }
   // dd($cs);
    return $cs;

  /* for($i=0;$i<count($cs);$i++){
    array_push($notidata, $cs)
     
  }*/
   }

   /*public function clearrejectnoti($id){
   // dd($id);
    $mytime = Carbon\Carbon::now();
      $date=$mytime->toDateString();
      $userconfirm= DB::table('notifications')->where('id', $id)->update(array('read_at' => $date));
      return redirect()->route('reject_list');
   }*/


  
  public function getitembyway(Request $request)
  {
    $wayid = $request->wayid;
    $way = Way::find($wayid);
    $item =$way->item;
    return $item;
  }

  public function waysreport(Request $request){
    //dd($request->deliveryman);

   $start_date=$request->start_date;
   $end_date=$request->end_date;
   //dd($start_date);
  $ways=DeliveryMan::with('ways')->whereHas('ways',function($query) use($start_date,$end_date){
    $query->whereBetween('created_at', [$start_date.' 00:00:00',$end_date.' 23:59:59'])->where('status_code','001');
  })->orWhereDoesntHave('ways')->with('pickups')->whereHas('pickups',function($query) use($start_date,$end_date){
    $query->whereBetween('created_at', [$start_date.' 00:00:00',$end_date.' 23:59:59'])->where('status','1');
  })->orWhereDoesntHave('pickups')->with('user')->get();
  
    return Datatables::of($ways)->addIndexColumn()->toJson();
  }



  public function successreport(Request $request){
    $start_date=$request->start_date;
    $end_date=$request->end_date;
    $success_export=new SuccesslistExport($start_date,$end_date);
    return Excel::download($success_export,'success.xlsx');

  }
}