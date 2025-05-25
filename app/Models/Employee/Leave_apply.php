<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class Leave_apply extends Model
{
    protected $fillable = ['id', 'old_emp_code','employee_id', 'employee_name', 'emp_reporting_auth', 'emp_sanctioning_auth', 'emp_lv_sanc_auth', 'date_of_apply', 'leave_type', 'half_cl', 'no_of_leave', 'status', 'from_date', 'to_date', 'doc_image','updated_at', 'created_at' ];
    
    

}

