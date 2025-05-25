<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Hr_pay_parameter extends Model
{
    protected $fillable = ['id', 'pf_percentage', 'pf_bar_amount', 'apf_percentage', 'hra_default_percentage', 'pf_loan_interest', 'created_at', 'updated_at'];
    
}
