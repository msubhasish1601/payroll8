<?php

namespace App\Http\Controllers\Attendance;

use App\Exports\ExcelFileExportAttendanceDaily;
use App\Http\Controllers\Controller;
use App\Models\Attendance\Attendence;
use App\Models\Attendance\Employee;
use App\Models\Masters\Role_authorization;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Validator;
use View;

class ReportController extends Controller
{
    public function viewDailyAttendance()
    {
        if (!empty(Session::get('admin'))) {

            // dd(Session::get('admin')->all());

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            // dd($data);
            $data['result'] = '';

            if (Session::get('admin')->user_type == 'user') {
                $data['emplist'] = $emplist = Employee::where('status', '=', 'active')
                // ->where('emp_status', '!=', 'TEMPORARY')
                    ->where('employees.emp_status', '!=', 'EX-EMPLOYEE')
                    ->where('employees.emp_status', '!=', 'EX- EMPLOYEE')
                    ->where(function ($query) {
                        $query->where('employees.emp_lv_sanc_auth', 'LIKE', Session::get('admin')->employee_id)
                            ->orWhere('employees.emp_code', 'LIKE', Session::get('admin')->employee_id)
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

            return View('attendance/daily-attendence-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function getDailyAttandance(Request $request)
    {

        if (!empty(Session::get('admin'))) {

            $Roledata = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $filename = $result = '';

            $validator = Validator::make($request->all(),
                [
                    'month_yr' => 'required',
                ],
                [
                    'month_yr.required' => 'Month, Year Field Required',
                ]);

            if ($validator->fails()) {
                return redirect('attendance/daily-attendance')->withErrors($validator)->withInput();
            }
            if (Session::get('admin')->user_type == 'user') {
                $data['emplist'] = $emplist = Employee::where('status', '=', 'active')
                // ->where('emp_status', '!=', 'TEMPORARY')
                    ->where('employees.emp_status', '!=', 'EX-EMPLOYEE')
                    ->where('employees.emp_status', '!=', 'EX- EMPLOYEE')
                    ->where(function ($query) {
                        $query->where('employees.emp_lv_sanc_auth', 'LIKE', Session::get('admin')->employee_id)
                            ->orWhere('employees.emp_code', 'LIKE', Session::get('admin')->employee_id)
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

            $employee_id = $request->employee_code;
            $month_yr = $request->month_yr;
            $req_month = $request['month_yr'];
            // $Users = Employee::where('emp_code', '=', $employee_id)->get();

            if ($employee_id == '') {

                $leave_allocation_rs = Attendence::where('month_yr', '=', $month_yr)
                    ->get();
            } else {
                $leave_allocation_rs = Attendence::where('month_yr', '=', $month_yr)
                    ->where('employee_code', '=', $employee_id)
                    ->get();
            }

            // dd($leave_allocation_rs);
            // if ($leave_allocation_rs) {
            //     foreach ($leave_allocation_rs as $leave_allocation) {
            //         $result .= '<tr>
            //                 <td></td>
            //                 <td>' . $leave_allocation->employee_code . '</td>

            //                 <td>' . $leave_allocation->employee_name . '</td>

            //                 <td>' . $leave_allocation->date . '</td>

            //                 <td><input type="text" class="form-control" name="arrival_time' . $leave_allocation->id . '" value="' . $leave_allocation->time_in . '"></td>
            //                 <td><input type="text" class="form-control" name="departure_time' . $leave_allocation->id . '" value="' . $leave_allocation->time_out . '"></td>
            //                 <td>' . $leave_allocation->duty_hours . '</td>
            //                 <!-- <td><a href="#" title="Edit"><i class="ti-pencil-alt"></i></a><a href="#" title="Delete"><i class="ti-trash"></i></a></td> -->
            //             </tr>';
            //     }
            // }
            $month_yr_new = $month_yr;
            return view('attendance/daily-attendence-report', compact('leave_allocation_rs', 'Roledata', 'employee_id', 'month_yr_new', 'emplist', 'req_month'));

        } else {
            return redirect('/');
        }
    }

    public function attandences_xlsexport(Request $request)
    {
        // dd($request->all());
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $employee_id = '';
            if (isset($request->employee_id)) {
                $employee_id = $request->employee_id;
            }
            $month_yr = '';
            if (isset($request->month_yr)) {
                $month_yr = $request->month_yr;
            }
            $month_yr_str = '';
            if ($month_yr != '') {
                $month_yr_str = explode('/', $month_yr);
                $month_yr_str = implode('-', $month_yr_str);
            }

            $data['emplist'] = $emplist = Employee::where('status', '=', 'active')
            // ->where('emp_status', '!=', 'TEMPORARY')
                ->where('employees.emp_status', '!=', 'EX-EMPLOYEE')
                ->where('employees.emp_status', '!=', 'EX- EMPLOYEE')
            // ->where('employees.emp_code', '=', '1831')
                ->orderBy('emp_fname', 'asc')
                ->get();

            return Excel::download(new ExcelFileExportAttendanceDaily($month_yr, $employee_id), 'DailyAttendanceReport-' . $month_yr_str . '.xlsx');
        } else {
            return redirect('/');
        }
    }
}
