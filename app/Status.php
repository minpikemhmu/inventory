<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Status extends Model
{
    protected $fillable=[
        	'codeno','description'
        ];
}
