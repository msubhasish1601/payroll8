<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Vda_detail extends Model
{

    protected $fillable = ['id', 'pay_month_year', 'emp_type', 'vda_current', 'vda_previous', 'vda_previous_previous', 'ot_vda', 'created_at', 'updated_at'];
}
