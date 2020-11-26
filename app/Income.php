<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Income extends Model
{
  use SoftDeletes;
	protected $fillable=[
    'delivery_fees', 'amount', 'bank_amount', 'cash_amount', 'way_id','payment_type_id', 'bank_id',
  ];

  public function way()
  {
    return $this->belongsTo('App\Way');
  }

  public function payment_type()
  {
    return $this->belongsTo('App\PaymentType');
  }

  public function bank()
  {
    return $this->belongsTo('App\Bank');
  }
}
