<?php

namespace App\Http\Controllers\Leave;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LeaveApprover\Ltc_apply;
use App\Models\Masters\Role_authorization;
use App\Models\Role\Employee;
use Validator;
use Session;
use View;
use Auth;

class LtcApplyController extends Controller
{
	/*public function viewltcapplication()
	{
		$tour_apply_rs = LtcApplyModel::all();

		return view('leave/ltc-application', compact('tour_apply_rs'));
	}*/

	public function viewLtcApplicationById($tour_id)
	{
		if (!empty(Session::get('admin'))) {

			$data['tour_apply'] = LtcApplyModel::find($tour_id);

			return view('leave/apply-for-ltc', $data);
		} else {
			return redirect('/');
		}
	}

	public function viewApplyltcapplication()
	{
		if (!empty(Session::get('admin'))) {

			$email = Session::get('adminusernmae');
			$data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
				->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
				->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
				->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
				->where('member_id', '=', $email)
				->get();
			return view('leave/apply-for-ltc', $data);
		} else {
			return redirect('/');
		}
	}

	public function saveApplyltcapplication(Request $request)
	{
		if (!empty(Session::get('admin'))) {

			$emp_id = Session('admin')->employee_id;

			$report_auth = Employee::where('emp_code', $emp_id)->first();

			$report_auth_name = $report_auth->emp_reporting_auth;

			$lv_sanc_auth = $report_auth->emp_lv_sanc_auth;

			$validator = Validator::make(
				$request->all(),
				[
					'duration' => 'required',
					'from_date' => 'required',
					'to_date' => 'required',
					'purpose' => 'required'
				],
				[
					'duration.required' => 'Duration Of Leave Required',
					'from_date.required' => 'From Date Required',
					'to_date.required' => 'To Date Required',
					'purpose' => 'Purpose Of Leave Required'
				]
			);

			if ($validator->fails()) {
				return redirect('employee-corner/apply-for-ltc')->withErrors($validator)->withInput();
			}

			$data = array(
				'apply_date' => $request->apply_date,
				'employee_code' => $emp_id,
				'emp_reporting_auth' => $report_auth_name,
				'emp_sanctioning_auth' => '',
				'emp_lv_sanc_auth' => '',
				'from_date' => $request->from_date,
				'to_date' => $request->to_date,
				'duration' => $request->duration,
				'purpose' => $request->purpose,
				'ltc_status' => "NOT APPROVED"
			);

			$data['employee_code'] = $emp_id;


			if (!empty($request->id)) {

				Ltc_apply::where('id', $request->id)
					->update($data);
			} else {
				$tour_apply = new Ltc_apply();
				$tour_apply->create($data);
			}

			Session::flash('message', 'Ltc Apply Successfully Saved.');
			return redirect('employee-corner/dashboard');
		} else {
			return redirect('/');
		}
	}
}
