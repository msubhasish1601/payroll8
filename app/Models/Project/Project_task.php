<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class Project_task extends Model
{
    protected $primarykey='id';
	
	protected $fillable=['id', 'project_id', 'employee_id', 'assigned_by','task_json'];
}