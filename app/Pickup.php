<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Pickup extends Model
{
     protected $fillable=[
        	'delivery_men_id','schedule_id','status','staff_id'
        ];
}
