<?php

namespace App\Http\Controllers;

use App\Schedule;
use Illuminate\Http\Request;
use Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules=Schedule::all();
        return view('schedule.index',compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('schedule.create');
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
            'remark'=>['required','string']
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
            'remark'=>['required','string']
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
}
