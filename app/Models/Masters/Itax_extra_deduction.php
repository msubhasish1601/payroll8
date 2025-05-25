<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Itax_extra_deduction extends Model
{
    protected $fillable = ['id', 'financial_year', 'percentage', 'amount_greater', 'extra_desc', 'extra_type', 'created_at', 'updated_at'];
    
}
