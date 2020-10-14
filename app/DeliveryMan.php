<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DeliveryMan extends Model
{
    protected $fillable=[
        	'user_id','phone_no','address'
        ];
}
