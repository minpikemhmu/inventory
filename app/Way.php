<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Way extends Model
{
	protected $fillable=[
        	'item_id','deliveryMen_id','status_id','status_code','delivery_date','refund_date','staff_id'
        ];
    
}
