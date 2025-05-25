<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Employee_type extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'employee_type_name', 'created_at', 'updated_at', 'employee_type_status'];
}
