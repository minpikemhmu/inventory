<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Staff extends Model
{
	protected $fillable=[
    'user_id','phone_no','address','joined_date','designation'];
}
