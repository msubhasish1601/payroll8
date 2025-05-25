<?php

namespace App;

namespace App\Http\Controllers\Leave;

use App\Http\Controllers\Controller;
use App\Models\Leave\Upload_attendence;
use App\Models\Masters\Role_authorization;
use App\Models\Role\Employee;
use Illuminate\Http\Request;
use view;
use Validator;
use Session;
use DateTime;
use Auth;

class LoginLogutController extends Controller
{
	//
	public function viewLoginLogout()
	{
		if (!empty(Session::get('admin'))) {

			$employee_code = Session('admin')->employee_id;

			$data['result'] = '';

			if ($employee_code <> '') {
				$data['employee_rs'] = Employee::get();

				//->where('employee.employee_id','=',$employee_code)->get()->first();
			}
			$data['monthlist'] = Upload_attendence::select('month_yr')->distinct('month_yr')->get();
			$email = Session::get('adminusernmae');
			$data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
				->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
				->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
				->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
				->where('member_id', '=', $email)
				->get();
			return view('leave/view-login-logout-status', $data);
		} else {
			return redirect('/');
		}
	}

	public function searchLoginLogout(Request $request)
	{
		if (!empty(Session::get('admin'))) {

			$data['employee_rs'] = $attendance_rs = $result = '';
			$employee_code = Session('admin')->employee_id;

			//DB::enableQueryLog();
			$attendance_rs = Upload_attendence::where('employee_code', '=', $employee_code)
				->where('month_yr', '=', $request->month_yr)
				->get();

			foreach ($attendance_rs as $attendance) {
				$result .=	'<tr>
									<td>' . date_format(date_create($attendance->att_date), 'd-m-Y') . '</td>
									<td>' . $attendance->arrival_time . '</td>
									<td>' . $attendance->departure_time . '</td>
									<td>' . $attendance->duty_hrs . '</td>
								</tr>';
			}
			$data['result'] = $result;
			$email = Session::get('adminusernmae');
			$data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
				->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
				->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
				->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
				->where('member_id', '=', $email)
				->get();
			$data['monthlist'] = Upload_attendence::select('month_yr')->distinct('month_yr')->get();
			$data['month_yr_new'] =$request->month_yr;
			return view('leave/view-login-logout-status', $data);
			//return redirect('leave/login-logout-status')->with(['result'=>$result]);

		} else {
			return redirect('/');
		}
	}
}
