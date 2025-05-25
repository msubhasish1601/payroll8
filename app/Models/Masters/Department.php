<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $primarykey = 'id';
	protected $fillable = ['id', 'department_code', 'department_name', 'updated_at', 'created_at', 'department_status'];
}
