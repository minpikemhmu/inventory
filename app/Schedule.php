<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Schedule extends Model
{
	protected $fillable=[
  	'pickup_date', 'status', 'remark', 'file', 'client_id','quantity'
  ];

  public function client()
  {
    return $this->belongsTo('App\Client');
  }

  public function pickup()
  {
    return $this->hasOne('App\Pickup');
  }
}
