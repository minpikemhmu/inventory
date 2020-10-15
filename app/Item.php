<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Item extends Model
{
	protected $fillable=[
    'codeno', 'expired_date', 'deposit', 'amount', 'delivery_fees', 'receiver_name', 'receiver_address', 'receiver_phone_no', 'remark', 'received_date', 'paystatus', 'client_id', 'township_id'
  ];

  public function client()
  {
    return $this->belongsTo('App\Client');
  }

  public function township()
  {
    return $this->belongsTo('App\Township');
  }

  public function way()
  {
    return $this->hasOne('App\Way');
  }
}
