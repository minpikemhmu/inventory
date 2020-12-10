<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
  use SoftDeletes;

  protected $fillable = ['bank_id', 'income_id', 'expense_id', 'amount', 'description'];

  public function bank()
  {
    return $this->belongsTo('App\Bank');
  }

  public function income()
  {
    return $this->belongsTo('App\Income');
  }

  public function expense()
  {
    return $this->belongsTo('App\Expense');
  }
}
