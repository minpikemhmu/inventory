<?php

namespace App\Http\Controllers;

use App\Item;
use App\Client;
use App\Schedule;
use App\Township;
use Carbon;
use Auth;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items=Item::all();
        return view('item.index',compact('items'));
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

         $validator = $request->validate([
            'receiver_name'  => ['required','string'],
            'receiver_phoneno'=>['required','string'],
            'receiver_address'=>['required','string'],
            'receiver_township'=>['required'],
            'expired_date'=>['required','date'],
            'deposit'=>['required'],
            'delivery_fees'=>['required'],
            'amount'=>['required'],
            'remark'=>['required','string']
        ]);

         if($validator){
            $item=new Item;
            $item->codeno=$request->codeno;
            $item->expired_date=$request->expired_date;
            $item->deposit=$request->deposit;
            $item->amount =$request->amount;
            $item->delivery_fees=$request->delivery_fees;
            $item->receiver_name=$request->receiver_name;
            $item->receiver_address=$request->receiver_address;
            $item->receiver_phone_no=$request->receiver_phoneno;
            $item->remark=$request->remark;
            $item->paystatus=0;
            $item->client_id=$request->client_id;
            $item->township_id=$request->receiver_township;
             $role=Auth::user()->roles()->first();
             $rolename=$role->name;
              if($rolename=="staff"){
                $user=Auth::user();
                 $staffid=$user->staff->id;
                $item->staff_id=$staffid;
            }
            $item->save();
           return redirect()->route('items.index')->with("successMsg",'New Item is ADDED in your data');
        }
        else
        {
            return redirect::back()->withErrors($validator);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $item=$item;
        $townships=Township::all();
        return view('item.edit',compact('item','townships'));
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
            'remark'=>['required','string']
        ]);

         if($validator){
            $item=$item;
            $item->codeno=$request->codeno;
            $item->expired_date=$request->expired_date;
            $item->deposit=$request->deposit;
            $item->amount =$request->amount;
            $item->delivery_fees=$request->delivery_fees;
            $item->receiver_name=$request->receiver_name;
            $item->receiver_address=$request->receiver_address;
            $item->receiver_phone_no=$request->receiver_phoneno;
            $item->remark=$request->remark;
            $item->township_id=$request->receiver_township;
             $role=Auth::user()->roles()->first();
             $rolename=$role->name;
              if($rolename=="staff"){
                $user=Auth::user();
                 $staffid=$user->staff->id;
                $item->staff_id=$staffid;
            }
            $item->save();
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
    public function collectitem($cid, $sid)
    {
        $itemcode="";
        $client = Client::find($cid);
        $codeno=$client->codeno;
        //dd($codeno);
        $mytime = Carbon\Carbon::now();
        $array = explode('-', $mytime->toDateString());
        $datecode=$array[2]."001";
        
        //dd($itemcode);
        $items=Item::all();
        //dd($items);
        if($items->count()==0){
           $itemcode=$codeno.$datecode;
        }else{
        $latestitem=Item::latest()->first();
        $code=$latestitem->codeno;
        $mycode=substr($code, 11,14);
        //dd($mycode);
        $itemcode=$codeno.$array[2].$mycode+1;
            
        }

        
        //dd($itemcode);
        //dd($datecode);
        $schedule = Schedule::find($sid);
        $townships=Township::all();
      //  dd($townships);
        return view('item.create',compact('client','schedule','townships','itemcode'));
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
}
