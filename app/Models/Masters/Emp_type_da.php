<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Emp_type_da extends Model
{
    protected $table = 'emp_type_da';
    protected $fillable = ['id', 'emp_type', 'da_percent', 'emp_grade', 'created_at', 'updated_at'];
}
