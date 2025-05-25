<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project_resource extends Model
{
    use SoftDeletes;
    protected $primarykey = 'id';

    protected $fillable = ['id', 'project_id', 'employee_id', 'is_billable', 'billable_percent'];
}
