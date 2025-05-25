<?php

namespace App\Models\Timesheet;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    protected $primarykey='id';
	
	protected $fillable=['id', 'employee_id', 'sheet_date', 'total_hours_locked'];
}