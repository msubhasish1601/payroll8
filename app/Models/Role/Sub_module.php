<?php

namespace App\Models\Role;

use Illuminate\Database\Eloquent\Model;

class Sub_module extends Model
{
    protected $primaryKey="id";
	protected $fillable=[ 'id', 'module_id', 'sub_module_name', 'created_at', 'updated_at'];
}
