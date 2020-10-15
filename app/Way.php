<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Way extends Model
{
	protected $fillable=[
  	'status_code', 'delivery_date', 'refund_date', 'item_id', 'delivery_men_id', 'staff_id', 'status_id'
  ];

  public function item()
  {
    return $this->belongsTo('App\Item');
  }
  
  public function delivery_man()
  {
    return $this->belongsTo('App\DeliveryMan');
  }

  public function staff()
  {
    return $this->belongsTo('App\Staff');
  }

  public function status()
  {
    return $this->belongsTo('App\Status');
  }

  public function reback()
  {
    return $this->hasOne('App\Reback');
  }

  public function income()
  {
    return $this->hasOne('App\Income');
  }
}
