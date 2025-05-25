<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Pay_head_link_master extends Model
{

    protected $fillable = ['id', 'pay_deduct_id', 'emp_name', 'pay_deduct_head', 'pay_value', 'pay_type', 'value_type', 'min_limit', 'max_limit', 'deduct_order', 'created_at', 'updated_at'];
}
