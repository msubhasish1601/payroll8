<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Pay_head_master extends Model
{

    protected $fillable = ['id', 'pay_type', 'pay_deduction_name', 'pay_deduction_head', 'function_name', 'value_type', 'pay_value', 'calculation_order', 'print_order', 'i_order', 'pay_head_status', 'created_at', 'updated_at'];
}
