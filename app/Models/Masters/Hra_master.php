<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Hra_master extends Model
{
    protected $fillable = ['id', 'hra_rate', 'max_amount', 'emp_type', 'grade_type', 'created_at', 'updated_at'];
    
}
