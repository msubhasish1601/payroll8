<?php

namespace App\Models\Role;

use Illuminate\Database\Eloquent\Model;

class User_rights_list extends Model
{
    protected $primaryKey="id";
	protected $fillable=[ 'id', 'role_authorization_id', 'user_rights_sub_module_id', 'user_right_menu_id', 'member_id', 'user_rights_name', 'updated_at', 'created_at'];
}
