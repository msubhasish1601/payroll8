<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $primarykey='id';
	
	protected $fillable=['id', 'emid', 'name', 'client_id','owner_id','project_code', 'start_date','end_date','actual_start_date','actual_end_date','contract_cost','status','closure_certificate','closure_date','description'];
}