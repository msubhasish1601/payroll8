<?php

namespace App;

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Models\Project\Employee;
use App\Models\Project\Role_authorization;
use App\Models\Timesheet\Timesheet_detail;
use Illuminate\Http\Request;
use Session;
use Validator;
use View;

class TimesheetsController extends Controller
{

    public function view_Timesheet()
    {

        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $data['result'] = '';

            if (Session::get('admin')->user_type == 'user') {
                $data['emplist'] = $emplist = Employee::where('status', '=', 'active')
                // ->where('emp_status', '!=', 'TEMPORARY')
                    ->where('employees.emp_status', '!=', 'EX-EMPLOYEE')
                    ->where('employees.emp_status', '!=', 'EX- EMPLOYEE')
                    ->where(function ($query) {
                        $query->where('employees.emp_lv_sanc_auth', 'LIKE', Session::get('admin')->employee_id)
                            ->orWhere('employees.emp_reporting_auth', 'LIKE', Session::get('admin')->employee_id);
                    })
                    ->orderBy('emp_fname', 'asc')
                    ->get();

            } else {
                $data['emplist'] = $emplist = Employee::where('status', '=', 'active')
                // ->where('emp_status', '!=', 'TEMPORARY')
                    ->where('employees.emp_status', '!=', 'EX-EMPLOYEE')
                    ->where('employees.emp_status', '!=', 'EX- EMPLOYEE')
                // ->where('employees.emp_code', '=', '1831')
                    ->orderBy('emp_fname', 'asc')
                    ->get();

            }

            return View('projects/times-view', $data);
        } else {
            return redirect('/');
        }
    }

    public function get_Timesheet(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $Roledata = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $filename = $result = '';
            // dd($request->all());
            $validator = Validator::make($request->all(),
                [
                    'sheet_date' => 'required',
                    'employee_id' => 'required',
                ],
                [
                    'sheet_date.required' => 'Sheet Date, Field Required',
                    'employee_id.required' => 'Employee Id, Field Required',
                ]);

            if ($validator->fails()) {
                return redirect('timesheets/timesheet-view')->withErrors($validator)->withInput();
            }
            if (Session::get('admin')->user_type == 'user') {
                $data['emplist'] = $emplist = Employee::where('status', '=', 'active')
                // ->where('emp_status', '!=', 'TEMPORARY')
                    ->where('employees.emp_status', '!=', 'EX-EMPLOYEE')
                    ->where('employees.emp_status', '!=', 'EX- EMPLOYEE')
                    ->where(function ($query) {
                        $query->where('employees.emp_lv_sanc_auth', 'LIKE', Session::get('admin')->employee_id)
                            ->orWhere('employees.emp_reporting_auth', 'LIKE', Session::get('admin')->employee_id);
                    })
                    ->orderBy('emp_fname', 'asc')
                    ->get();

            } else {
                $data['emplist'] = $emplist = Employee::where('status', '=', 'active')
                // ->where('emp_status', '!=', 'TEMPORARY')
                    ->where('employees.emp_status', '!=', 'EX-EMPLOYEE')
                    ->where('employees.emp_status', '!=', 'EX- EMPLOYEE')
                // ->where('employees.emp_code', '=', '1831')
                    ->orderBy('emp_fname', 'asc')
                    ->get();

            }

            $employee_id = $request->employee_id;
            $sheet_date = $request->sheet_date;

            if ($employee_id == '') {

                // $timesheet_detail = Timesheet_detail::select('timesheet_details.*', 'projects.name')
                //     ->leftJoin('projects', 'projects.id', '=', 'timesheet_details.project_id')
                //     ->where('timesheets.employee_id', Session::get('admin')['employee_id'])
                //     ->orWhere('sheet_date', '=', $sheet_date)
                //     ->get();

                $timesheet_detail = Timesheet_detail::join('projects', 'projects.id', '=', 'timesheet_details.project_id')
                    ->join('timesheets', 'timesheets.id', '=', 'timesheet_details.timesheet_id')
                    ->leftjoin('project_tasks', 'project_tasks.id', '=', 'timesheet_details.task_id')
                    ->select('timesheet_details.*', 'projects.name as project_name', 'project_tasks.task_description as task_name')
                    ->where('timesheets.employee_id', Session::get('admin')['employee_id'])
                    ->where('timesheets.status', '!=', 'P')
                    ->orWhere('timesheets.sheet_date', '=', $sheet_date)
                    ->get();
            } else {

                // $timesheet_detail = Timesheet_detail::select('timesheet_details.*', 'timesheets.sheet_date', 'timesheets.total_hours_locked', 'timesheets.is_draft', 'timesheets.is_submit', 'projects.name')
                //     ->leftJoin('timesheets', 'timesheets.id', '=', 'timesheet_details.timesheet_id')
                //     ->leftJoin('projects', 'projects.id', '=', 'timesheet_details.project_id')
                // // ->where('timesheets.employee_id',Session::get('admin')['employee_id'])
                //     ->where('timesheets.sheet_date', '=', $sheet_date)
                //     ->where('timesheets.employee_id', '=', $employee_id)
                // // ->groupBy('timesheets.sheet_date')
                //     ->get();

                $timesheet_detail = Timesheet_detail::join('projects', 'projects.id', '=', 'timesheet_details.project_id')
                    ->join('timesheets', 'timesheets.id', '=', 'timesheet_details.timesheet_id')
                    ->leftjoin('project_tasks', 'project_tasks.id', '=', 'timesheet_details.task_id')
                    ->select('timesheet_details.*', 'projects.name as project_name', 'project_tasks.task_description as task_name')
                    ->where('timesheets.sheet_date', '=', $sheet_date)
                    ->where('timesheets.status', '!=', 'P')
                    ->where('timesheets.employee_id', '=', $employee_id)
                    ->get();

            }
            // dd($timesheet_detail);
            return view('projects/times-view', compact('timesheet_detail', 'Roledata', 'employee_id', 'emplist', 'sheet_date'));

        } else {
            return redirect('/');
        }
    }

}
