<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Township extends Model
{
  protected $fillable=[
  	'name', 'delivery_fees', 'city_id'
  ];

  public function city()
  {
    return $this->belongsTo('App\City');
  }

  public function delivery_men()
  {
    return $this->belongsToMany('App\DeliveryMan');
  }

  public function clients()
  {
    return $this->hasMany('App\Client');
  }

  public function items()
  {
    return $this->hasMany('App\Item');
  }
}
