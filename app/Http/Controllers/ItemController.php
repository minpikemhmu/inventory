<?php

namespace App\Http\Controllers;

use App\Item;
use App\Client;
use App\Pickup;
use App\Township;
use App\DeliveryMan;
use App\Way;
use App\Expense;
use Carbon;
use Auth;
use App\SenderGate;
use App\SenderPostoffice;
use Session;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\DB;
use App\Bank;
use App\Transaction;
use Yajra\DataTables\Facades\DataTables;
use Response;
class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //$items=Item::doesntHave('way')->get();
  
      // dd($myitems);
      
      $deliverymen = DeliveryMan::with(['townships'=> function($q){
                     $q->orderBy('name','asc');
                      }])->get();

        //dd($deliverymen);
     

     // dd($ways);
    /*  $notifications=DB::table('notifications')->select('data')->where('notifiable_type','App\Way')->get();
      $data=[];
      foreach ($notifications as $noti) {
        $notiway=json_decode($noti->data);
        if($notiway->ways->status_code=="005"){
          array_push($data, $notiway->ways);
        }
      }*/
      // dd($data);
      return view('item.index',compact('deliverymen'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('item.create',compact('townships'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $qty=$request->qty;
      $myqty=$request->myqty;
      $damount=$request->depositamount;

      $validator = $request->validate([
        'receiver_name'  => ['required','string'],
        'receiver_phoneno'=>['required','string'],
        'receiver_address'=>['required','string'],
        'receiver_township'=>['required','not_in:null'],
        'expired_date'=>['required','date'],
        'delivery_fees'=>['required'],
        'amount'=>['required'],
      ]);

      $item = Item::where('codeno',$request->codeno)->first();
      
      if($validator && $item == null){
        $data = tounicode($request->receiver_address);

        $item=new Item;
        $item->codeno=$request->codeno;
        $item->expired_date=$request->expired_date;
        $item->deposit=$request->deposit;
        $item->amount =$request->amount;
        $item->delivery_fees=$request->delivery_fees;
        $item->receiver_name=$request->receiver_name;
        $item->receiver_address=$data;
        $item->receiver_phone_no=$request->receiver_phoneno;
        $item->remark=$request->remark;
        $item->paystatus=$request->amountstatus;
        $item->pickup_id=$request->pickup_id;
        $item->township_id=$request->receiver_township;

        if($request->mygate!=null){
          $item->sender_gate_id=$request->mygate;
        }
        if($request->myoffice!=null){
          $item->sender_postoffice_id=$request->myoffice;
        }

        $rolename=Auth::user()->roles()->first()->name;
        if($rolename=="staff"){
          $user=Auth::user();
          $staffid=$user->staff->id;
          $item->staff_id=$staffid;
        }

        $item->save();

        $pickup = Pickup::find($item->pickup_id);

        if($qty==1){
          
          if ($request->paystatus == 1 && $request->paidamount == 0) {
            $request->paidamount = $request->depositamount;
          }

          $checkitems = Item::where('pickup_id', $pickup->id)->get();
          if($checkitems->sum('deposit')!=$damount){
            $pickup->status = 2;
            $pickup->save();

            return redirect()->route('checkitem',$request->pickup_id); 
          }elseif($request->paidamount>0 && $request->paystatus == 1){
            $expense=new Expense;
            $expense->amount=$request->paidamount;
            $expense->pickup_id=$request->pickup_id;
            // $expense->client_id=$request->client_id;

            if($rolename=="staff"){
              $user=Auth::user();
              $staffid=$user->staff->id;
              $expense->staff_id=$staffid;
            }

            $expense->status=$request->paystatus;
            $expense->description="Client Deposit";
            $expense->city_id=1;
            $expense->expense_type_id=1;
            $expense->save();

            // insert into transaction and bank
            $transaction = new Transaction;
            $transaction->bank_id = $request->payment_method;
            $transaction->expense_id = $expense->id;
            if($request->paidamount!=null){
               $transaction->amount = $request->paidamount;
            }else{
              $transaction->amount = $request->depositamount;
            }
            
            $transaction->description = "Client Deposit";
            $transaction->save();

            $bank = Bank::find($request->payment_method);
             if($request->paidamount!=null){
              $bank->amount=$bank->amount-$request->paidamount;
             }else{
               $bank->amount = $bank->amount-$request->depositamount;
             }
            $bank->save();
          }
        }

        if (($pickup->schedule->quantity - count($pickup->items)) > 0) {
          return redirect()->back()->with("successMsg",'New Item is ADDED');
        }else{
          $pickup->status = 4;
          $pickup->save();
          
          return redirect()->route('items.index')->with("successMsg",'New Item is ADDED in your data');
        }
      }else{
        return redirect()->back()->withErrors($validator);
      }
            
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        $item=$item;
        return $item;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
      $townships=Township::orderBy('name','asc')->get();
      $sendergates=SenderGate::orderBy('name','asc')->get();
      $senderoffice=SenderPostoffice::orderBy('name','asc')->get();
      $deliverymen = DeliveryMan::all();
      return view('item.edit',compact('item','townships','sendergates','senderoffice','deliverymen'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
          $validator = $request->validate([
            'receiver_name'  => ['required','string'],
            'receiver_phoneno'=>['required','string'],
            'receiver_address'=>['required','string'],
            'receiver_township'=>['required'],
            'expired_date'=>['required','date'],
            'deposit'=>['required'],
            'delivery_fees'=>['required'],
            'amount'=>['required'],
        ]);

         if($validator){
            $data = tounicode($request->receiver_address);

            $item=$item;
            $item->codeno=$request->codeno;
            $item->expired_date=$request->expired_date;
            $item->deposit=$request->deposit;
            $item->amount =$request->amount;
            $item->delivery_fees=$request->delivery_fees;
            $item->receiver_name=$request->receiver_name;
            $item->receiver_address=$data;
            $item->receiver_phone_no=$request->receiver_phoneno;
            $item->remark=$request->remark;
            $item->paystatus=$request->amountstatus;
            $item->township_id=$request->receiver_township;
           if($request->mygate!=null){
              $item->sender_gate_id=$request->mygate;
            }
            if($request->myoffice!=null){
              $item->sender_postoffice_id=$request->myoffice;
            }
             $role=Auth::user()->roles()->first();
             $rolename=$role->name;
              if($rolename=="staff"){
                $user=Auth::user();
                 $staffid=$user->staff->id;
                $item->staff_id=$staffid;
            }
            $item->save();

            if ($request->deliveryman) {
              $way = $item->way;
              $way->delivery_man_id = $request->deliveryman;
              $way->save();
            }
           return redirect()->route('items.index')->with("successMsg",'Updatesuccessfully');
        }
        else
        {
            return redirect::back()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item=$item;
        $item->delete();
       return redirect()->route('items.index')->with('successMsg','Existing Item is DELETED in your data');
    }

    // here accept client id
    public function collectitem($cid, $pid)
    {
        $itemcode="";
        $client = Client::find($cid);
        //dd($client);
        $codeno=$client->codeno;
        // dd($codeno);
        $mytime = Carbon\Carbon::now();
        //dd($checktime);
        $array = explode('-', $mytime->toDateString());
        $datecode=$array[2]."001";
        
        // dd($datecode);
        // $items=Item::all();
        $item=Item::whereDate('created_at',Carbon\Carbon::today())->orderBy('id','desc')->first();
        //dd($item);
        if(!$item){
           $itemcode=$codeno.$datecode;
           // dd($itemcode);
        }else{
        $code=$item->codeno;
        $mycode=substr($code, 11,14);
        //dd($mycode);
        $itemcode=$codeno.$array[2].$mycode+1;
            
        }
        //dd($itemcode);
        //dd($datecode);
        $pickup = Pickup::find($pid);
        // $townships=Township::all();
        $townships = Township::orderBy('name','asc')->get();

        $sendergates=SenderGate::orderBy('name','asc')->get();
        $senderoffice=SenderPostoffice::orderBy('name','asc')->get();

        $pickupeditem = Item::where('pickup_id',$pickup->id)->orderBy('id','desc')->first();
        $banks = Bank::orderBy('name','asc')->get();
        return view('item.create',compact('banks','client','pickup','townships','itemcode','pickupeditem','sendergates','senderoffice'));
    }


    public function delichargebytown(Request $request){
       $id=$request->id;
       //dd($id);
       $township=Township::find($id);
       $deliverycharge=$township->delivery_fees;
       //dd($deliverycharge);
       return $deliverycharge;
    }

    public function itemdetail(Request $request){
        $id=$request->id;
        $item=Item::find($id);
        return $item;
    }

    public function assignWays(Request $request)
    {
        //dd($request);
        $myways=$request->ways;
        //dd($myways);
        foreach($myways as $myway){
            $way=new Way;
            $way->status_code="005";
            $way->item_id=$myway;
            $way->delivery_man_id=$request->delivery_man;
            $role=Auth::user()->roles()->first();
            $rolename=$role->name;
              if($rolename=="staff"){
                $user=Auth::user();
                $staffid=$user->staff->id;
                $way->staff_id=$staffid;
            }
            $way->status_id=5;
            $way->save();


        }
return redirect()->route('items.index')->with("successMsg",'way assign successfully');
    }


    public function updatewayassign(Request $request){
        $id=$request->wayid;

            $way=Way::find($id);
            $way->delivery_man_id=$request->delivery_man;
            $role=Auth::user()->roles()->first();
            $rolename=$role->name;
              if($rolename=="staff"){
                $user=Auth::user();
                $staffid=$user->staff->id;
                $way->staff_id=$staffid;
            }
            $way->save();
            return redirect()->route('items.index')->with("successMsg",'way assign update successfully');
    }

    public function deletewayassign($id){
        $way=Way::find($id);
        $way->delete();
        return redirect()->route('items.index')->with("successMsg",'way assign delete successfully');
    }

    public function townshipbystatus(Request $request){
        $id=$request->id;
        $township=Township::where('status',$id)->get();
        return $township;
    }

    public function checkitem($pickupid){
    
    $checkitems=Item::where('pickup_id',$pickupid)->get();
    $banks = Bank::all();
    return view('dashboard.checkitem',compact('checkitems','banks'))->with("successMsg",'items amount are wrong');
      //dd($pickupid);
    }

    public function updateamount(Request $request){
      $checkitemarray=$request->myarray;

      // update item amount
      foreach ($checkitemarray as $value) {
        $item=Item::find($value["id"]);
        $deliveryfee=$item->delivery_fees;
        $item->deposit=$value["amount"];
        $item->amount=$value["amount"]+$deliveryfee;
        $item->save();
      }

      // update status in pickup
      $item=Item::find($checkitemarray[0]["id"]);
      $pickup=Pickup::find($item->pickup_id);
      $pickup->status=4;
      $pickup->save();

      $rolename=Auth::user()->roles()->first()->name;

      // if prepaid deposit, insert into expense table
      if($request->totaldeposit>0 && $request->paystatus == 1){
        $expense=new Expense;
        $expense->amount=$request->totaldeposit;
        $expense->pickup_id=$request->pickup_id;
        // $expense->client_id=$request->client_id;

        if($rolename=="staff"){
          $user=Auth::user();
          $staffid=$user->staff->id;
          $expense->staff_id=$staffid;
        }

        $expense->status=$request->paystatus;
        $expense->description="Client Deposit";
        $expense->city_id=1;
        $expense->expense_type_id=1;
        $expense->save();

        // insert into transaction and bank
        $transaction = new Transaction;
        $transaction->bank_id = $request->payment_method;
        $transaction->expense_id = $expense->id;
        $transaction->amount = $request->totaldeposit;
        
        $transaction->description = "Client Deposit";
        $transaction->save();

        $bank = Bank::find($request->payment_method);
        $bank->amount = $bank->amount-$request->totaldeposit;
        $bank->save();
      }

      return "success";
    }

    public function newitem(){
       $items=Item::with("pickup.schedule.client.user")->with("township")->whereHas('pickup',function($query){
              $query->where(function ($q){
                $q->where('status',4)->orWhere('status',5);
              });
            })
            ->doesntHave('way')
            ->get();
      return Datatables::of($items)->addIndexColumn()->toJson();
    }

    public function onway(){
       $ways = Way::orderBy('id', 'desc')->with('item.township')->with('item.pickup.schedule.client.user')->with("delivery_man.user")->whereDate('created_at', Carbon\Carbon::today())->get();
       return Datatables::of($ways)->addIndexColumn()->toJson();
    }

}
