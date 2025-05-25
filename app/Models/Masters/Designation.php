<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    
	protected $primaryKey='id';
	protected $fillable=['id', 'department_code','designation_code', 'designation_name', 'created_at', 'updated_at', 'designation_status'];
	
}
