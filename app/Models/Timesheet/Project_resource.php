<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class Project_resource extends Model
{
    protected $primarykey='id';
	
	protected $fillable=['id', 'project_id', 'employee_id', 'is_billable','billable_percent'];
}