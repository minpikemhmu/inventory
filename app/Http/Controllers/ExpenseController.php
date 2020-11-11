<?php

namespace App\Http\Controllers;

use App\Expense;
use App\ExpenseType;
use Illuminate\Http\Request;
use Auth;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses=Expense::all();
        return view('expense.index',compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $expensetypes=ExpenseType::all();
        return view('expense.create',compact('expensetypes'));
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
            'description'  => ['required', 'string', 'max:255'],
            'expensetype'=>['required'],
            'amount'=>['required']
        ]);

        if($validator){
            $expense=new Expense;
            $expense->description=$request->description;
            $expense->amount=$request->amount;
            $expense->expense_type_id=$request->expensetype;
            $expense->staff_id = Auth::user()->staff->id;
            $expense->city_id = 1; // default yangon
            $expense->status = 2;
            $expense->save();
            return redirect()->route('expenses.index')->with("successMsg",'New Expense is ADDED in your data');
        }
        else
        {
            return redirect::back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        $expensetypes=ExpenseType::all();
        $expense=$expense;
        return view('expense.edit',compact('expense','expensetypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        $validator = $request->validate([
            'description'  => ['required', 'string', 'max:255'],
            'expensetype'=>['required'],
            'amount'=>['required']
        ]);

        if($validator){
            $expense=$expense;
            $expense->description=$request->description;
            $expense->amount=$request->amount;
            $expense->expense_type_id=$request->expensetype;
            $expense->save();
            return redirect()->route('expenses.index')->with("successMsg",'New Expense updated successfully');
        }
        else
        {
            return redirect::back()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        
         $expense=$expense;
        $expense->delete();
       return redirect()->route('expenses.index')->with('successMsg','Existing Expense is DELETED in your data');
    }
}
