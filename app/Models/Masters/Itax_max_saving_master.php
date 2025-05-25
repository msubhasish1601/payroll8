<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Itax_max_saving_master extends Model
{
    protected $fillable = ['id', 'financial_year', 'gender', 'amount', 'created_at', 'updated_at'];
    
}
