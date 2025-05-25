<?php

namespace App\Models\Role;

use Illuminate\Database\Eloquent\Model;

class Module_config extends Model
{
    protected $primaryKey="id";
	protected $fillable=['id', 'module_id', 'sub_module_id', 'menu_name', 'updated_at', 'created_at'];
}
