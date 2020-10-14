<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    protected $fillable=[
        	'user_id','contact_person','phone_no','address','codeno','township_id'
        ];
}
