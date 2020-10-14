<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Item extends Model
{
	 protected $fillable=[
   'codeno','client_id','expired_date','deposit','amount','township_id','township_id','delivery_fees','receiver_name','receiver_address','receiver_phone_no','remark','received_date','paystatus'];
}
