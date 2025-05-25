<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
	 protected $fillable = ['id', 'emp_financial_year','from_month','to_month','interest','interest_employer', 'created_at', 'updated_at','status'];
   
}
