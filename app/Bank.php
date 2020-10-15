<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Bank extends Model
{
  protected $fillable=[
  	'name'
  ];

  public function incomes()
  {
    return $this->hasMany('App\Income');
  }
}
