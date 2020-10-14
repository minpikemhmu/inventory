<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Expense extends Model
{
	protected $fillable=[
        	'amount','expensetype_id','description'
        ];
}
