<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
	protected $fillable=[
    'way_id','delivery_fees','amount','payment_type_id','bank_amount','cash_amount'];
}
