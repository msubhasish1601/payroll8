<?php

namespace App\Models\LeaveApprover;

use Illuminate\Database\Eloquent\Model;

class Ltc_apply extends Model
{
    protected $fillable = ['id', 'employee_code', 'emp_reporting_auth', 'emp_sanctioning_auth', 'apply_date', 'from_date', 'to_date', 'duration', 'purpose','ltc_status', 'updated_at', 'created_at'];
}
