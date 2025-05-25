<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'grade_name', 'created_at', 'updated_at', 'grade_status'];
}
