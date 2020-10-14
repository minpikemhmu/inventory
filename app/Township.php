<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Township extends Model
{
    protected $fillable=[
        	'name','city_id','delivery_fees'
        ];
}
