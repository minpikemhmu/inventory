<?php

namespace App\Http\Controllers;

use App\Schedule;
use Illuminate\Http\Request;
use Auth;
use App\DeliveryMan;
use App\Pickup;
use App\Client;
class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role=Auth::user()->roles()->first();
        $rolename=$role->name;
         
        $staffschedules=Schedule::doesntHave('pickups')->where('status',1)->get();
        $schedules="";
        if($rolename=="client"){
        $user=Auth::user();
        $client=$user->client->id;
        $schedules=Schedule::where('client_id',$client)->get();
        }
        $pickups=Pickup::all();
        $deliverymen=DeliveryMan::all();
        return view('schedule.index',compact('schedules','staffschedules','deliverymen','pickups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients=client::all();
        $deliverymen=DeliveryMan::all();
        return view('schedule.create',compact('deliverymen','clients'));
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
            'date'  => ['required','date'],
            'remark'=>['required','string'],
            'quantity'=>['required']
        ]);


        if($validator){
                if($request->hasfile('file'))
            {
            $profile=$request->file('file');
            $upload_path=public_path().'/images/';
            $name=$profile->getClientOriginalName();
            $profile->move($upload_path,$name);
            $path='/images/'.$name;
            }else
            {
                $path="";
            }
             $user=Auth::user();
             $client=$user->client->id;
             //dd($client);
            $schedule=new Schedule;
            $schedule->pickup_date=$request->date;
            $schedule->status=0;
            $schedule->client_id=$client;
            $schedule->file=$path;
            $schedule->remark=$request->remark;
            $schedule->quantity=$request->quantity;
            $schedule->save();
            return redirect()->route('schedules.index')->with("successMsg",'New Schedule is ADDED in your data');
        }
        else
        {
            return redirect::back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        $schedule=$schedule;
        return view('schedule.edit',compact('schedule'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
         $validator = $request->validate([
            'date'  => ['required','date'],
            'remark'=>['required','string'],
            'quantity'=>['required']
        ]);


        if($validator){
                if($request->hasfile('file'))
            {
            $profile=$request->file('file');
            $upload_path=public_path().'/images/';
            $name=$profile->getClientOriginalName();
            $profile->move($upload_path,$name);
            $path='/images/'.$name;
            }else
            {
                $path=$request->oldfile;
            }
             $user=Auth::user();
             $client=$user->client->id;
             //dd($client);
            $schedule=$schedule;
            $schedule->pickup_date=$request->date;
            $schedule->file=$path;
            $schedule->remark=$request->remark;
            $schedule->quantity=$request->quantity;
            $schedule->save();
            return redirect()->route('schedules.index')->with("successMsg",'Updated Successfully');
        }
        else
        {
            return redirect::back()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
         $schedule=$schedule;
        $schedule->delete();
       return redirect()->route('schedules.index')->with('successMsg','Existing Schedule is DELETED in your data');
    }
    
    public function storeandassignschedule(Request $request)
    {
       // dd($request);
        $schedule_id=$request->assignid;
        $deliveryman_id=$request->deliveryman;
        //dd($deliveryman_id);
        $user=Auth::user();
        $staff=$user->staff->id;

        $pickup=new Pickup;
        $pickup->status=0;
        if($request->client){
             if($request->hasfile('file'))
            {
            $profile=$request->file('file');
            $upload_path=public_path().'/images/';
            $name=$profile->getClientOriginalName();
            $profile->move($upload_path,$name);
            $path='/images/'.$name;
            }else
            {
                $path="";
            }
                $schedule=new Schedule;
                $schedule->pickup_date=$request->date;
                $schedule->status=1;
                $schedule->remark=$request->remark;
                $schedule->quantity=$request->quantity;
                $schedule->file=$path;
                $schedule->client_id=$request->client;
                $schedule->save();
                $pickup->schedule_id=$schedule->id;
        }else{
            $pickup->schedule_id=$schedule_id;
        }
        //dd($deliveryman_id);
        $pickup->delivery_men_id=$deliveryman_id;
        $pickup->staff_id=$staff;
        $pickup->save();
        return redirect()->route('schedules.index')->with('successMsg','Assign successfully');
    }

    public function uploadfile(Request $request){
        //dd($request);
        $id=$request->addid;
        if($request->hasfile('addfile'))
            {
            $profile=$request->file('addfile');
            $upload_path=public_path().'/images/';
            $name=$profile->getClientOriginalName();
            $profile->move($upload_path,$name);
            $path='/images/'.$name;
            }else{
                $path=$request->oldfile;
            }
            $schedule=Schedule::find($id);
            //dd($schedule);
            $schedule->status=1;
            $schedule->file=$path;
            $schedule->save();
           return redirect()->route('schedules.index')->with('successMsg','file upload successfully'); 
    }
}
