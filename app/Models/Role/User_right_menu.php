<?php

namespace App\Models\Role;

use Illuminate\Database\Eloquent\Model;

class User_right_menu extends Model
{
    protected $primaryKey="id";
	protected $fillable=[ 'id', 'role_auth_id', 'user_rights_sub_module_id', 'member_id', 'menu_name', 'updated_at', 'created_at'];
}
