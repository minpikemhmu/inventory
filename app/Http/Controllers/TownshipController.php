<?php

namespace App\Http\Controllers;

use App\Township;
use App\City;
use Illuminate\Http\Request;

class TownshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $townships=Township::all();
        return view('township.index',compact('townships'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities=City::all();
        return view('township.create',compact('cities'));
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
            'name'  => ['required', 'string', 'max:255'],
            'delifee'=>['required'],
            'city'=>['required']
        ]);

        if($validator){
            $township=new Township;
            $township->name=$request->name;
            $township->delivery_fees=$request->delifee;
            $township->city_id=$request->city;
            $township->save();
            return redirect()->route('townships.index')->with("successMsg",'New Township is ADDED in your data');
        }
        else
        {
            return redirect::back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Township  $township
     * @return \Illuminate\Http\Response
     */
    public function show(Township $township)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Township  $township
     * @return \Illuminate\Http\Response
     */
    public function edit(Township $township)
    {
        $cities=City::all();
        $township=$township;
        return view('township.edit',compact('cities','township'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Township  $township
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Township $township)
    {
        $validator = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'delifee'=>['required'],
            'city'=>['required']
        ]);

        if($validator){
            $township=$township;
            $township->name=$request->name;
            $township->delivery_fees=$request->delifee;
            $township->city_id=$request->city;
            $township->save();
            return redirect()->route('townships.index')->with("successMsg",'Update successfully');
        }
        else
        {
            return redirect::back()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Township  $township
     * @return \Illuminate\Http\Response
     */
    public function destroy(Township $township)
    {
         $township=$township;
        $township->delete();
       return redirect()->route('townships.index')->with('successMsg','Existing Township is DELETED in your data');
    }
}