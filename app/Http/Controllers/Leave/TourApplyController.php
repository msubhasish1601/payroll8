<?php

namespace App\Http\Controllers\Leave;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LeaveApprover\Tour_apply;
use App\Models\LeaveApprover\Tour_dtl;
use App\Models\Masters\Role_authorization;
use App\Models\Role\Employee;
use Validator;
use Session;
use View;
use Auth;

class TourApplyController extends Controller
{
	//
	public function viewtourapplication()
	{
		if (!empty(Session::get('admin'))) {

			$tour_apply_rs = Tour_apply::all();
			return view('leave/tour-application', compact('tour_apply_rs'));
		} else {
			return redirect('/');
		}
	}


	public function tourapplicationListing()
	{
		if (!empty(Session::get('admin'))) {

			$emp_id = Session('admin')->employee_id;
			$data['tour_apply_rs'] = Tour_apply::where('employee_code', $emp_id)->orderBy('id', 'DESC')->get();

			$email = Session::get('adminusernmae');
			$data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
				->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
				->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
				->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
				->where('member_id', '=', $email)
				->get();
			return view('leave/userwise-tour-listing', $data);
		} else {
			return redirect('/');
		}
	}



	public function viewTourApplicationById($tour_id)
	{
		if (!empty(Session::get('admin'))) {

			$data['tour_apply'] = Tour_apply::find($tour_id);

			return view('leave/apply-for-tour', $data);
		} else {
			return redirect('/');
		}
	}

	public function viewApplytourapplication()
	{
		if (!empty(Session::get('admin'))) {

			$email = Session::get('adminusernmae');
			$data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
				->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
				->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
				->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
				->where('member_id', '=', $email)
				->get();
			return view('leave/apply-for-tour', $data);
		} else {
			return redirect('/');
		}
	}

	public function saveApplytourapplication(Request $request)
	{
		if (!empty(Session::get('admin'))) {

			//echo "<pre>"; print_r($request->all()); exit;

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
				return redirect('employee-corner/apply-for-tour')->withErrors($validator)->withInput();
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
				'tour_status' => $request->holiday_descripion,
				'advance_release' => $request->advance_release
			);
			$data['tour_status'] = "NOT APPROVED";
			$data['employee_code'] = $emp_id;


			if (!empty($request->id)) {

				Tour_apply::where('id', $request->id)
					->update($data);
			} else {
				$tour_apply = new Tour_apply();
				$tour_dtl = $tour_apply->create($data);

				$data_dtl = $request->all();
				foreach ($data_dtl['tour_date_dtl'] as $key => $value) {

					Tour_dtl::insert(
						['tour_apply_id' => $tour_dtl->id, 'tour_date_dtl' => $value, 'establishment_dtl' => $data_dtl['establishment_dtl'][$key], 'place_name' => $data_dtl['place_name'][$key], 'status' => $data_dtl['status'][$key]]
					);
				}
			}

			Session::flash('message', 'Tour Apply Successfully Saved.');
			return redirect('employee-corner/tourlisting');
		} else {
			return redirect('/');
		}
	}


	public function getTourdtlById($tour_id)
	{
		if (!empty(Session::get('admin'))) {


			$tour_apply =  Tour_apply::where('id', '=', $tour_id)->first();
			$emp_dtl = Employee::where('old_emp_code', '=', $tour_apply->employee_code)->first();
			$data['tour_dtl'] = Tour_dtl::where('tour_apply_id', '=', $tour_id)->get();
			$emp_name = $emp_dtl->emp_fname . " " . $emp_dtl->emp_mname . " " . $emp_dtl->emp_lname;
			$data['tour_apply'] = array('emp_name' => $emp_name, 'old_emp_code' => $tour_apply->employee_code, 'from_date' => $tour_apply->from_date, 'to_date' => $tour_apply->to_date, 'advanced' => $tour_apply->advance_release);
			//echo "<pre>";print_r($data['tour_apply']); exit;

			return view('leave/tour-leave-print-view', $data);
		} else {
			return redirect('/');
		}
	}
}
