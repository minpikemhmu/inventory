<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Expense extends Model
{
	protected $fillable=[
  	'amount', 'description', 'expense_type_id'
  ];

  public function expense_type()
  {
    return $this->belongsTo('App\ExpenseType');
  }
}
