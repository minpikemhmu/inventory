<?php

namespace App\Http\Controllers;

use App\Schedule;
use Illuminate\Http\Request;
use Auth;
use App\DeliveryMan;
use App\Pickup;
use App\Client;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\DB;
use Carbon;
use Yajra\DataTables\Facades\DataTables;
use Response;
class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // For Client Side
    public function index(){
      $rolename=Auth::user()->roles()->first()->name;
      $schedules=Schedule::doesntHave('pickup')->get();
      $deliverymen=DeliveryMan::all();
      return view('schedule.index',compact('schedules','deliverymen','rolename'));
    }

    // For Staff Side
    public function allpickup(){
      $rolename=Auth::user()->roles()->first()->name;
      $pickups=Pickup::orderBy('id','desc')->with('schedule.client.user')->with('delivery_man.user')->with('items')->get();
      return Datatables::of($pickups)->addIndexColumn()->toJson();           
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
      $clients=DB::table('clients')
              ->join('users', 'users.id', '=', 'clients.user_id')
              ->select('clients.*', 'users.name as clientname')
              ->orderBy('users.name')
              ->get();
      $deliverymen=DB::table('delivery_men')
              ->join('users', 'users.id', '=', 'delivery_men.user_id')
              ->select('delivery_men.*', 'users.name as deliveryname')
              ->orderBy('users.name')
              ->get();

      return view('schedule.create',compact('deliverymen','clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // Save Only Schedule
    public function store(Request $request){
      $validator = $request->validate([
          'date'  => ['required','date'],
          'client'=>['required'],
      ]);

      if($validator){
        if($request->hasfile('file')){
          $name= time().'_'.$request->file->getClientOriginalName();
          $filePath = $request->file('file')->storeAs('images', $name, 'public');
          $path='/storage/'.$filePath;
        }else{
          $path="";
        }

        $schedule=new Schedule;
        $schedule->pickup_date=$request->date;
        $schedule->status=0;
        $schedule->client_id=$request->client;
        $schedule->file=$path;
        $schedule->remark=$request->remark;

        if($request->quantity!=null && $request->amount!=null){
          $schedule->quantity=$request->quantity;
          $schedule->amount=$request->amount;
        }

        if($request->hasfile('file')){
            $schedule->status=1;
        }else{
          $schedule->status=0;  
        }
        $schedule->save();

        return redirect()->route('schedules.index')->with("successMsg",'New Schedule is ADDED in your data');
      }else{
        return redirect::back()->withErrors($validator);
      }
    }

    // Direct Pickup Schedule Assign By Staff
    public function storeandassignschedule(Request $request){
      $schedule_id=$request->assignid;
      $deliveryman_id=$request->deliveryman;
      $user=Auth::user();
      $staff=$user->staff->id;

      $pickup=new Pickup;
      $pickup->status=0;

      if($request->client){
        if($request->hasfile('file')){
          $name= time().'_'.$request->file->getClientOriginalName();
          $filePath = $request->file('file')->storeAs('images', $name, 'public');
          $path='/storage/'.$filePath;
        }else{
          $path="";
        }

        $schedule=new Schedule;
        $schedule->pickup_date=$request->date;

        if($request->hasfile('file')){
            $schedule->status=1;
        }else{
          $schedule->status=0;  
        }

        $schedule->remark=$request->remark;
        $schedule->file=$path;
        $schedule->client_id=$request->client;

        if($request->quantity!=null && $request->amount!=null){
          $schedule->quantity=$request->quantity;
          $schedule->amount=$request->amount;
        }
        $schedule->save();
        $pickup->schedule_id=$schedule->id;
      }else{
        $pickup->schedule_id=$schedule_id;
      }

      $pickup->delivery_man_id=$deliveryman_id;
      $pickup->staff_id=$staff;
      $pickup->save();
      return redirect()->route('schedules.index')->with('successMsg','Assign successfully');
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
      $clients=DB::table('clients')
              ->join('users', 'users.id', '=', 'clients.user_id')
              ->select('clients.*', 'users.name as clientname')
              ->orderBy('users.name')
              ->get();
      $deliverymen=DB::table('delivery_men')
              ->join('users', 'users.id', '=', 'delivery_men.user_id')
              ->select('delivery_men.*', 'users.name as deliveryname')
              ->orderBy('users.name')
              ->get();
      return view('schedule.edit',compact('schedule','clients','deliverymen'));
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
          'client'=>['required'],
      ]);

      if($validator){
        if($request->hasfile('file')){
          $name= time().'_'.$request->file->getClientOriginalName();
          $filePath = $request->file('file')->storeAs('images', $name, 'public');
          $path='/storage/'.$filePath;
        }else{
          $path=$request->oldfile;
        }

        if($request->client){
            $schedule->client_id=$request->client;
        }else{
          $user=Auth::user();
          $client=$user->client->id;
          $schedule->client_id=$client;
        }

        $schedule->pickup_date=$request->date;
        $schedule->file=$path;
        $schedule->remark=$request->remark;
        
        if($request->quantity!=null && $request->amount!=null){
          $schedule->quantity=$request->quantity;
          $schedule->amount=$request->amount;
        }

        if($request->hasfile('file')){
            $schedule->status=1;
        }else{
          $schedule->status=0;  
        }
        
        $schedule->save();

        if($request->deliveryman){
          $pickup=Pickup::where('schedule_id',$schedule->id)->first();
          $pickup->delivery_man_id=$request->deliveryman;
          $user=Auth::user();
          $staff=$user->staff->id;
          $pickup->staff_id=$staff;
          $pickup->save();
        }
        
        return redirect()->route('schedules.index')->with("successMsg",'Updated Successfully');
      }else{
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
      $pickup=Pickup::where('schedule_id',$schedule->id)->first();
      $pickup->delete();
      $schedule->delete();
      return redirect()->route('schedules.index')->with('successMsg','Existing Schedule is DELETED in your data');
    }

    public function uploadfile(Request $request){
        //dd($request);
        $id=$request->addid;

        //dd($request->addfile);
        if($request->hasfile('addfile'))
            {
            $name= time().'_'.$request->addfile->getClientOriginalName();
            $filePath = $request->file('addfile')->storeAs('images', $name, 'public');
            $path='/storage/'.$filePath;
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

    

    public function getnoti(){
        $notifications=DB::table('notifications')->select('data')->where('notifiable_type','App\Pickup')->get();
        //dd($notifications);
        $data=[];

        foreach ($notifications as $noti) {
         $notipickup=json_decode($noti->data);
       // dd($notipickup->pickup);
            array_push($data, $notipickup->pickup);
          
        }
        return $data;
    }
}
