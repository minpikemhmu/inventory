<?php

namespace App\Http\Controllers;

use App\Expense;
use App\ExpenseType;
use Illuminate\Http\Request;
use Auth;
use App\Bank;
use App\Transaction;

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
         $banks=Bank::all();
        return view('expense.create',compact('expensetypes','banks'));
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
            'amount'=>['required'],
            'bank'=>['required']
        ]);

        if($validator){
            

            $bank= Bank::find($request->bank);
            if($request->amount <= $bank->amount){
            $expense=new Expense;
            $expense->description=$request->description;
            $expense->amount=$request->amount;
            $expense->expense_type_id=$request->expensetype;
            $expense->staff_id = Auth::user()->staff->id;
            $expense->city_id = 1; // default yangon
            $expense->status = 2;
            $expense->save();
            $bank->amount=$bank->amount-$request->amount;
            $bank->save();
            $transaction=new Transaction;
            $transaction->bank_id=$request->bank;
            $transaction->expense_id=$expense->id;
            $transaction->amount=$request->amount;
            $transaction->description=$request->description;
            $transaction->save();
             return redirect()->route('expenses.index')->with("successMsg",'New Expense is ADDED in your data');
            }else{
                return redirect()->route('expenses.index')->with("successMsg",'New Expense added is not successfully.Try again!');
            }
           
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
         $banks=Bank::all();
        return view('expense.edit',compact('expense','expensetypes','banks'));
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
            $bank= Bank::find($request->bank);
            if($request->amount <= $bank->amount){
            $expense=$expense;
            $expense->description=$request->description;
            $expense->amount=$request->amount;
            $expense->expense_type_id=$request->expensetype;
            $expense->save();
            $bank->amount=$bank->amount-$request->amount;
            $bank->save();
            $transaction=Transaction::where('expense_id',$expense->id)->first();
            $transaction->bank_id=$request->bank;
            $transaction->expense_id=$expense->id;
            $transaction->amount=$request->amount;
            $transaction->description=$request->description;
            $transaction->save();
            return redirect()->route('expenses.index')->with("successMsg",'New Expense updated successfully');
            }
           
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
