<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyawnaingtun\Tounicode\TounicodeTrait;
class Item extends Model
{
  use SoftDeletes,TounicodeTrait;
  protected $convertable = ['receiver_address'];

	protected $fillable=[
    'codeno', 'expired_date', 'deposit', 'amount', 'delivery_fees', 'receiver_name', 'receiver_address', 'receiver_phone_no', 'remark', 'paystatus', 'status', 'client_id', 'township_id','staff_id','error_remark','sender_gate_id','sender_postoffice_id','pickup_id'
  ];

  public function pickup()
  {
    return $this->belongsTo('App\Pickup');
  }

  public function township()
  {
    return $this->belongsTo('App\Township');
  }

  public function way()
  {
    return $this->hasOne('App\Way');
  }

  public function staff()
  {
    return $this->belongsTo('App\Staff');
  }

  public function SenderGate(){
    return $this->belongsTo('App\SenderGate');
  }

  public function SenderPostoffice(){
    return $this->belongsTo('App\SenderPostoffice');
  }
}
