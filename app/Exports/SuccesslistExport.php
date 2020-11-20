<?php

namespace App\Exports;

use App\Deliveryman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon;

class SuccesslistExport implements FromView
{

protected $reportstdate,$reportenddate;

  public function __construct($reportstdate,$reportenddate){
  	$this->reportstdate=$reportstdate;
  	$this->reportenddate=$reportenddate;
  }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {

    $today = today(); 
    $dates = []; 

    for($i=1; $i < $today->daysInMonth + 1; ++$i) {
        $dates[] = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('d-m-y');
    }
    
    $now = Carbon\Carbon::now();
    $mymonth=$now->month;
    //dd($mymonth);
    $reportstdate=$this->reportstdate;
    $reportenddate=$this->reportenddate;
    //$deliverymen=Deliveryman::with('user')->get();
    //dd($Deliveryman);
    $ways=DeliveryMan::with('ways')->whereHas('ways',function($query) use($mymonth){
    $query->WhereMonth('created_at',$mymonth)->where('status_code','001');
  	})->orWhereDoesntHave('ways')->with('pickups')->whereHas('pickups',function($query) use($mymonth){
    $query->WhereMonth('created_at',$mymonth)->where('status','1');
 	 })->orWhereDoesntHave('pickups')->with('user')->get();
  	//dd($ways);
       return view('dashboard.successview',compact('ways','dates'));
    }
}