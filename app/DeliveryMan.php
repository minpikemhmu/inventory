<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DeliveryMan extends Model
{
  protected $fillable=[
  	'phone_no', 'address', 'user_id'
  ];

  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function townships()
  {
    return $this->belongsToMany('App\Township');
  }

  public function pickups()
  {
    return $this->hasMany('App\Pickup');
  }

  public function ways()
  {
    return $this->hasMany('App\Way');
  }
}
