<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Schedule extends Model
{
	protected $fillable=[
        	'client_id','pickup_date','status','remark','file'
        ];

}
