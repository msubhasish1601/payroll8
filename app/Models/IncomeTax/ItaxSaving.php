<?php

namespace App\Models\IncomeTax;

use Illuminate\Database\Eloquent\Model;

class ItaxSaving extends Model
{
    protected $fillable = ['id', 'emp_code', 'i_tax_type', 'saving_type_id', 'financial_year', 'amount', 'created_at', 'updated_at'];
    
}
