<?php

namespace App\Models\Role;

use Illuminate\Database\Eloquent\Model;

class User_rights_sub_module extends Model
{
    protected $primaryKey="id";
	protected $fillable=['id', 'role_auth_id', 'member_id', 'sub_module_name', 'menu_name', 'created_at', 'updated_at'];
}
