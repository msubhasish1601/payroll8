<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee\Emp_servicebook_personalinfo;
use App\Models\Masters\Role_authorization;
use App\Models\Role\Employee;
use Illuminate\Http\Request;
use View;
use Validator;
use Session;
use Auth;
use Illuminate\Validation\Rule;

class EmployeeServicebookController extends Controller
{
	public function servicebook()
	{

		if (!empty(Session::get('admin'))) {

			$email = Session::get('adminusernmae');
			$data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
				->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
				->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
				->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
				->where('member_id', '=', $email)
				->get();
			return view('employee/service-book', $data);
		} else {
			return redirect('/');
		}
	}

}
