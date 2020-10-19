<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Pickup extends Model
{
  protected $fillable=[
  	'status', 'schedule_id', 'delivery_men_id', 'staff_id'
  ];

  public function schedule()
  {
    return $this->belongsTo('App\Schedule');
  }

  public function delivery_man()
  {
    return $this->belongsTo('App\DeliveryMan');
  }
  
  public function staff()
  {
    return $this->belongsTo('App\Staff');
  }

  public function rebacks()
  {
    return $this->hasMany('App\Reback');
  }
}