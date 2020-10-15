<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
  protected $fillable=[
  	'name'
  ];

  public function townships()
  {
    return $this->hasMany('App\Township');
  }
}
