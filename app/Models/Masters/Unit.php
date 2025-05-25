<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $primaryKey="id";
	protected $fillable=['id', 'unit_name', 'unit_status', 'updated_at', 'created_at'];
}
