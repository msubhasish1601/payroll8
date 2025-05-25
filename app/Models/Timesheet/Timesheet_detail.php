<?php

namespace App\Models\Timesheet;

use Illuminate\Database\Eloquent\Model;

class Timesheet_detail extends Model
{
    protected $primarykey = 'id';

    protected $fillable = ['id', 'timesheet_id', 'project_id', 'task_type', 'task_id', 'description', 'task_status', 'hours', 'minutes', 'task_time'];
}
