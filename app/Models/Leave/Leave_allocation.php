<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Model;

class Leave_allocation extends Model
{
    protected $fillable = [
        'leave_type', 'employee_name', 'employee_code', 'max_no_of_leave', 
        'opening_balance', 'leave_in_hand', 'month_year',
    ];
}
