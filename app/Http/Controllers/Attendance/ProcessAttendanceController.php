<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Models\Attendance\Process_attendance;
use App\Models\Attendance\Upload_attendence;
use App\Models\Holiday\Holiday;
use App\Models\LeaveApprover\Leave_apply;
use App\Models\LeaveApprover\Tour_apply;
use App\Models\Masters\Role_authorization;
use App\Models\Role\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExcelFileExportAttendanceEntry;
use Session;
use Validator;
use View;

class ProcessAttendanceController extends Controller
{
    public function viewProcessAttendance()
    {
        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            $data['result'] = '';
            $data['monthlist'] = Upload_attendence::select('month_yr')->distinct('month_yr')->get();
            $data['upload_record_rs'] = 0;
            return view('attendance/emp-process-attendance', $data);
        } else {
            return redirect('/');
        }
    }
    public function getProcessAttandance(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            $filename = $result = '';
            $per_day_salary = $late_salary_deducted = $no_of_days_salary_deducted = $no_of_days_salary = 0;

            $working_day = 30;

            $validator = Validator::make($request->all(),
                [

                    'month_yr' => 'required',
                ],
                [

                    'month_yr.required' => 'Month, Year Field Required',
                ]);

            if ($validator->fails()) {
                return redirect('attendance/process-attendance')->withErrors($validator)->withInput();
            }

            $month_yr = $request->month_yr;

            //dd($month_yr);

            $montharr = explode('/', $month_yr);

            function countDays($year, $month, $ignore)
            {
                $count = 0;
                $counter = mktime(0, 0, 0, $month, 1, $year);
                while (date("n", $counter) == $month) {
                    if (in_array(date("w", $counter), $ignore) == false) {
                        $count++;
                    }
                    $counter = strtotime("+1 day", $counter);
                }
                return $count;
            }

            $daycount = countDays($montharr[1], $montharr[0], array(0, 6)); // 23
            $monthvar = '';

            if ($montharr[0] == '1') {
                $monthvar = 'Jan';
            }
            if ($montharr[0] == '2') {
                $monthvar = 'Feb';
            }
            if ($montharr[0] == '3') {
                $monthvar = 'Mar';
            }
            if ($montharr[0] == '4') {
                $monthvar = 'Apr';
            }
            if ($montharr[0] == '5') {
                $monthvar = 'May';
            }
            if ($montharr[0] == '6') {
                $monthvar = 'Jun';
            }
            if ($montharr[0] == '7') {
                $monthvar = 'Jul';
            }
            if ($montharr[0] == '8') {
                $monthvar = 'Aug';
            }
            if ($montharr[0] == '9') {
                $monthvar = 'Sep';
            }
            if ($montharr[0] == '10') {
                $monthvar = 'Oct';
            }
            if ($montharr[0] == '11') {
                $monthvar = 'Nov';
            }
            if ($montharr[0] == '12') {
                $monthvar = 'Dec';
            }

            $holidays = Holiday::where('month', '=', $monthvar)
                ->where('years', '=', $montharr[1])->get();
            $totday = 0;
            foreach ($holidays as $holiday) {
                $totday = $totday + $holiday->day;
            }
            $total_wk_days = 0;
            $total_wk_days = $daycount - $totday;

            $employee_rs = Employee::join('upload_attendences', 'employees.emp_code', '=', 'upload_attendences.employee_code')
                ->where('upload_attendences.month_yr', '=', $month_yr)
                ->select('employees.*')
                ->distinct()
                ->get();

            // dd($employee_rs);
            $increment = 0;

            foreach ($employee_rs as $emp) {
                $tour_leave_count = 0;
                $number_of_days_leave = 0;

                $leave_apply_rs = Leave_apply::select(DB::raw('sum(no_of_leave) as number_of_days'), DB::raw('sum(status) as status'), DB::raw('sum(to_date) as to_date'))
                    ->where('employee_id', '=', $emp->emp_code)
                    ->where('to_date', 'like', $montharr[1] . '-' . $montharr[0] . '-' . '%')
                    ->where('status', '=', 'APPROVED')
                    ->get();

                $tour_leave = Tour_apply::select(DB::raw('sum(duration) as duration'))
                    ->where('employee_code', '=', $emp->emp_code)
                    ->where('to_date', 'like', $montharr[1] . '-' . $montharr[0] . '-' . '%')
                    ->where('tour_status', '=', 'APPROVED')
                    ->get();

                if ($tour_leave[0]->duration_sum != null) {
                    $tour_leave_count = $tour_leave[0]->duration_sum;
                } else { $tour_leave_count = 0;}

                $number_of_days_leave = $leave_apply_rs[0]->number_of_days;

                if ($number_of_days_leave == null) {
                    $number_of_days_leave = 0;
                }

                $no_of_present = 0;

                $upload_attendence = Upload_attendence::where('month_yr', '=', $month_yr)
                    ->where('employee_code', '=', $emp->emp_code)
                    ->groupBy('employee_code', 'month_yr')
                    ->count();

                $process_attendence = Process_attendance::where('month_yr', '=', $month_yr)
                    ->where('employee_code', '=', $emp->emp_code)
                    ->first();

                if (empty($process_attendence)) {
                    $no_of_present = ($upload_attendence);

                    $absent_days = 0;
                    $totleave_present = $no_of_present + $number_of_days_leave + $tour_leave_count;
                    $absent_days = $total_wk_days - $totleave_present;

                    $totsal = $no_of_present + $number_of_days_leave + $tour_leave_count;
                    $total_salary_deduction = $total_wk_days - $totsal;

                    $no_of_days_salary = $no_of_present + $number_of_days_leave;

                    $result .= '<tr>

								<input type="hidden" class="form-control" readonly="" name="month_yr" value="' . $month_yr . '">
								<input type="hidden" class="form-control" readonly="" name="no_of_working_days' . $emp->emp_code . '" value="' . $total_wk_days . '">

                                                                <input type="hidden" class="form-control" readonly="" name="no_of_days_absent' . $emp->emp_code . '" value="' . $absent_days . '">
                                                                <input type="hidden" class="form-control" readonly="" name="no_of_days_leave_taken' . $emp->emp_code . '" value="' . $number_of_days_leave . '">
                                                                <input type="hidden" class="form-control" readonly="" name="no_of_present' . $emp->emp_code . '" value="' . $no_of_present . '">
                                                                <input type="hidden" class="form-control" readonly="" name="total_sal' . $emp->emp_code . '" value="' . $totsal . '">
                                                                <input type="hidden" class="form-control" readonly="" name="tour_leave' . $emp->emp_code . '" value="' . $tour_leave_count . '">
<input type="hidden" class="form-control" readonly="" name="no_of_days_salary' . $emp->emp_code . '" value="' . $totsal . '">

								<td><div class="checkbox"><label><input type="checkbox" name="employee_code[]" value="' . $emp->emp_code . '"></label></div></td>
								<td>' . $emp->emp_code . '</td>
								<td>' . $emp->emp_fname . ' ' . $emp->emp_mname . ' ' . $emp->emp_lname . '</td>
								<td>' . $total_wk_days . '</td>
								<td>' . $number_of_days_leave . '</td>
								<td>' . $tour_leave_count . '</td>
								<td>' . $absent_days . '</td>
								<td>' . $no_of_present . '</td>
								<td>' . $totsal . '</td>
							</tr>';
                    $increment++;
                }
            }
            $month_yr_new = $request['month_yr'];
            return view('attendance/emp-process-attendance', compact('result', 'month_yr_new'));
        } else {
            return redirect('/');
        }
    }

    public function saveProcessAttandance(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $i = 0;
            $enteremployee = array();
            $checkattendence = Process_attendance::where('month_yr', '=', $request->month_yr)->get();
            foreach ($checkattendence as $chckatt) {
                $enteremployee[] = $chckatt->employee_code;
            }
            if (isset($request->employee_code) && count($request->employee_code) != 0) {
                foreach ($request->employee_code as $checked) {
                    $data['month_yr'] = $request->month_yr;
                    $data['employee_code'] = $checked;
                    $data['no_of_working_days'] = $request['no_of_working_days' . $checked];
                    $data['no_of_tour_leave'] = $request['tour_leave' . $checked];
                    $data['no_of_days_leave_taken'] = $request['no_of_days_leave_taken' . $checked];
                    $data['no_of_present'] = $request['no_of_present' . $checked];
                    $data['no_of_days_absent'] = $request['no_of_days_absent' . $checked];
                    $data['no_of_days_salary'] = $request['no_of_days_salary' . $checked];

                    if (in_array($checked, $enteremployee)) {
                        Session::flash('error', 'Alraedy Attendance Processed for the month of ' . $request->month_yr . '.');
                        return redirect('attendance/process-attendance');
                    } else {
                        if (($request['no_of_working_days' . $checked] < $request['no_of_days_salary' . $checked]) || ($request['no_of_present' . $checked] < 0)) {
                            Session::flash('error', 'There was a problem in your monthly attandance sheet  upload attandance.');
                            return redirect('attendance/process-attendance');

                        } else {
                            $process_attendance = new Process_attendance;
                            $process_attendance->month_yr = $request->month_yr;
                            $process_attendance->employee_code = $checked;
                            $process_attendance->no_of_working_days = $request['no_of_working_days' . $checked];
                            $process_attendance->no_of_tour_leave = $request['tour_leave' . $checked];
                            $process_attendance->no_of_days_leave_taken = $request['no_of_days_leave_taken' . $checked];
                            $process_attendance->no_of_present = $request['no_of_present' . $checked];
                            $process_attendance->no_of_days_absent = $request['no_of_days_absent' . $checked];
                            $process_attendance->no_of_days_salary = $request['no_of_days_salary' . $checked];
                            $process_attendance->updated_at = date('Y-m-d H:i:s');
                            $process_attendance->created_at = date('Y-m-d H:i:s');
                            $process_attendance->save();
                        }

                    }

                    $i++;
                }
                Session::flash('message', 'Attendance Process Information Successfully Saved.');
                return redirect('attendance/process-attendance');

            } else {
                Session::flash('error', 'Please select before process!!.');
                return redirect('attendance/process-attendance');
            }
        } else {
            return redirect('/');
        }
    }

    public function addMonthlyAttendancePAAllemployee()
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['result'] = '';

            return view('attendance/add-monthly-process-attandance-all', $data);
        } else {
            return redirect('/');
        }
    }
    public function listAttendanceAllemployee(Request $request)
    {

        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $Roledata = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $payrolldate = explode('/', $request['month_yr']);
            $payroll_date = "0" . ($payrolldate[0] - 2);
            $origDate = $payroll_date . "/" . $payrolldate[1];

            //$current_month_days = cal_days_in_month(CAL_GREGORIAN, $payrolldate[0], $payrolldate[1]);
            //dd($current_month_days);
            $datestring = $payrolldate[1] . '-' . $payrolldate[0] . '-01';
            // Converting string to date
            $date = strtotime($datestring);
            $current_month_days = date("t", strtotime(date("Y-m-t", $date)));

            $tomonthyr = $payrolldate[1] . "-" . $payroll_date . "-" . $current_month_days;
            $formatmonthyr = $payrolldate[1] . "-" . $payroll_date . "-01";

            $month_yr_new = $request['month_yr'];

            // $rate_rs = Rate_master::leftJoin('rate_details', 'rate_details.rate_id', '=', 'rate_masters.id')
            //     ->select('rate_details.*', 'rate_masters.head_name')
            //     ->get();

            $result = '';

            $emplist = Employee::where('status', '=', 'active')
               // ->where('emp_status', '!=', 'TEMPORARY')
                ->where('employees.emp_status', '!=', 'EX-EMPLOYEE')
                ->where('employees.emp_status', '!=', 'EX- EMPLOYEE')
            // ->where('employees.emp_code', '=', '1831')
                ->orderBy('emp_fname', 'asc')
                ->get();

            foreach ($emplist as $mainkey => $emcode) {

                $result .= '<tr id="' . $emcode->emp_code . '">
								<td><div class="checkbox"><label><input type="checkbox" name="empcode_check[]" id="chk_' . $emcode->emp_code . '" value="' . $emcode->emp_code . '" class="checkhour"></label></div></td>
								<td><input type="text" readonly class="form-control sm_emp_code" name="emp_code' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->emp_code . '"></td>
                                <td>' . $emcode->old_emp_code . '</td>
								<td><input type="text" readonly class="form-control sm_emp_name" name="emp_name' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->emp_fname . ' ' . $emcode->emp_mname . ' ' . $emcode->emp_lname . '"><input type="hidden" readonly class="form-control sm_emp_designation" name="emp_designation' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->emp_designation . '"></td>
								<td><input type="text" readonly class="form-control sm_month_yr" name="month_yr' . $emcode->emp_code . '" style="width:100%;" value="' . $request['month_yr'] . '"></td>
								<td><input type="number" class="form-control sm_n_workingd" name="n_workingd' . $emcode->emp_code . '" style="width:100%;" value="' . $current_month_days . '" id="n_workingd_' . $emcode->emp_code . '" readonly></td><td><input type="number" class="form-control sm_n_presentd" name="n_presentd' . $emcode->emp_code . '" style="width:100%;" value="' . $current_month_days . '" id="n_presentd_' . $emcode->emp_code . '" onkeyup="calculate_days(' . $emcode->emp_code . ');"></td><td><input type="number" class="form-control sm_n_leaved" name="n_leaved' . $emcode->emp_code . '" style="width:100%;" value="0" id="n_leaved_' . $emcode->emp_code . '" onkeyup="calculate_days(' . $emcode->emp_code . ');"></td><td><input type="number" class="form-control sm_n_absentd" name="n_absentd' . $emcode->emp_code . '" style="width:100%;" value="0" id="n_absentd_' . $emcode->emp_code . '" readonly></td><td><input type="number" class="form-control sm_n_salaryd" name="n_salaryd' . $emcode->emp_code . '" style="width:100%;" value="' . $current_month_days . '" id="n_salaryd_' . $emcode->emp_code . '" readonly ></td><td><input type="number" class="form-control sm_n_salaryadjd" name="n_salaryadjd' . $emcode->emp_code . '" style="width:100%;" value="0" id="n_salaryadjd_' . $emcode->emp_code . '"  ></td>';

            }

            return view('attendance/add-monthly-process-attandance-all', compact('result', 'Roledata', 'month_yr_new'));
        } else {
            return redirect('/');
        }
    }

    public function SaveAttendanceAllemployee(Request $request)
    {

        if (!empty(Session::get('admin'))) {

            //dd($request->cboxes);
            $request->empcode_check = explode(',', $request->cboxes);

            if (isset($request->empcode_check) && count($request->empcode_check) != 0) {

                $sm_emp_code_ctrl = explode(',', $request->sm_emp_code_ctrl);
                $sm_emp_name_ctrl = explode(',', $request->sm_emp_name_ctrl);
                $sm_emp_designation_ctrl = explode(',', $request->sm_emp_designation_ctrl);
                $sm_month_yr_ctrl = explode(',', $request->sm_month_yr_ctrl);

                $sm_n_workingd_ctrl = explode(',', $request->sm_n_workingd_ctrl);
                $sm_n_absentd_ctrl = explode(',', $request->sm_n_absentd_ctrl);
                $sm_n_leaved_ctrl = explode(',', $request->sm_n_leaved_ctrl);
                $sm_n_presentd_ctrl = explode(',', $request->sm_n_presentd_ctrl);
                $sm_n_salaryd_ctrl = explode(',', $request->sm_n_salaryd_ctrl);
                $sm_n_salaryadjd_ctrl = explode(',', $request->sm_n_salaryadjd_ctrl);

                foreach ($request->empcode_check as $key => $value) {

                    $index = array_search($value, $sm_emp_code_ctrl);

                    if($value!=""){

                        $data['employee_code'] = $value;
                        //$data['emp_name'] = $request['emp_name' . $value];
                        // $data['emp_name'] = $sm_emp_name_ctrl[$index];
    
                        //$data['emp_designation'] = $request['emp_designation' . $value];
                        //$data['emp_designation'] = $sm_emp_designation_ctrl[$index];
    
                        // $data['month_yr'] = $request['month_yr' . $value];
                        $data['month_yr'] = $sm_month_yr_ctrl[$index];
    
                        $data['no_of_working_days'] = $sm_n_workingd_ctrl[$index];
                        $data['no_of_days_absent'] = $sm_n_absentd_ctrl[$index];
                        $data['no_of_days_leave_taken'] = $sm_n_leaved_ctrl[$index];
                        $data['no_of_present'] = $sm_n_presentd_ctrl[$index];
                        $data['no_of_tour_leave'] = '0';
                        $data['no_of_days_salary'] = $sm_n_salaryd_ctrl[$index];
                        $data['no_sal_adjust_days'] = $sm_n_salaryadjd_ctrl[$index];
    
                        // $data['status'] = 'process';
                        $data['created_at'] = date('Y-m-d H:i:s');
    
                        // dd($data);
                        $process_attendance = Process_attendance::where('employee_code', '=', $value)
                            ->where('month_yr', '=', $data['month_yr'])
                            ->first();
    
                        if (!empty($process_attendance)) {
                            Session::flash('error', 'Attendance already generated for said period');
                        } else {
                            Process_attendance::insert($data);
    
                            Session::flash('message', 'Record Successfully Saved.');
    
                        }

                    }    

                }
            } else {
                Session::flash('error', 'No Record is selected');
            }

            return redirect('attendance/add-montly-attendance-data-all');
        } else {
            return redirect('/');
        }
    }

    public function viewMonthlyAttendanceAllemployee()
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['result'] = '';
            $data['monthlist'] = Process_attendance::select('month_yr')->distinct('month_yr')->get();

            return view('attendance/set-monthly-process-attandance-all', $data);
        } else {
            return redirect('/');
        }
    }

    public function listMonthlyAttendanceAllemployee(Request $request)
    {

        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $Roledata = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $payrolldate = explode('/', $request['month_yr']);
            $payroll_date = "0" . ($payrolldate[0] - 2);
            $origDate = $payroll_date . "/" . $payrolldate[1];

            //$current_month_days = cal_days_in_month(CAL_GREGORIAN, $payrolldate[0], $payrolldate[1]);
            //dd($current_month_days);
            $datestring = $payrolldate[1] . '-' . $payrolldate[0] . '-01';
            // Converting string to date
            $date = strtotime($datestring);
            $current_month_days = date("t", strtotime(date("Y-m-t", $date)));

            $tomonthyr = $payrolldate[1] . "-" . $payroll_date . "-" . $current_month_days;
            $formatmonthyr = $payrolldate[1] . "-" . $payroll_date . "-01";

            $month_yr_new = $request['month_yr'];

            $monthlist = Process_attendance::select('month_yr')->distinct('month_yr')->get();

            // $rate_rs = Rate_master::leftJoin('rate_details', 'rate_details.rate_id', '=', 'rate_masters.id')
            //     ->select('rate_details.*', 'rate_masters.head_name')
            //     ->get();

            $result = '';

            $emplist = Process_attendance::join('employees', 'employees.emp_code', '=', 'process_attendances.employee_code')
                ->where('process_attendances.month_yr', '=', $month_yr_new)
                ->where('process_attendances.status', '=', 'P')
                ->where('employees.emp_status', '!=', 'TEMPORARY')
                ->where('employees.emp_status', '!=', 'EX-EMPLOYEE')
                ->where('employees.emp_status', '!=', 'EX- EMPLOYEE')
            // ->where('employees.emp_code', '=', '1831')
                ->orderBy('employees.emp_fname', 'asc')
                ->get();

            if (count($emplist) == 0) {
                Session::flash('error', 'Attendance for the month ' . $month_yr_new . ' already processed.');
                return redirect('attendance/view-montly-attendance-data-all');
            }

            foreach ($emplist as $mainkey => $emcode) {

                $result .= '<tr id="' . $emcode->emp_code . '">
								<td><div class="checkbox"><label><input type="checkbox" name="empcode_check[]" id="chk_' . $emcode->emp_code . '" value="' . $emcode->emp_code . '" class="checkhour"></label></div></td>
								<td><input type="text" readonly class="form-control sm_emp_code" name="emp_code' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->emp_code . '"></td>
                                <td>' . $emcode->old_emp_code . '</td>
								<td><input type="text" readonly class="form-control sm_emp_name" name="emp_name' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->emp_fname . ' ' . $emcode->emp_mname . ' ' . $emcode->emp_lname . '"><input type="hidden" readonly class="form-control sm_emp_designation" name="emp_designation' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->emp_designation . '"></td>
								<td><input type="text" readonly class="form-control sm_month_yr" name="month_yr' . $emcode->emp_code . '" style="width:100%;" value="' . $request['month_yr'] . '"></td>
								<td><input type="number" class="form-control sm_n_workingd" name="n_workingd' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->no_of_working_days . '" id="n_workingd_' . $emcode->emp_code . '" readonly></td><td><input type="number" class="form-control sm_n_presentd" name="n_presentd' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->no_of_present . '" id="n_presentd_' . $emcode->emp_code . '" onkeyup="calculate_days(' . $emcode->emp_code . ');"></td><td><input type="number" class="form-control sm_n_leaved" name="n_leaved' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->no_of_days_leave_taken . '" id="n_leaved_' . $emcode->emp_code . '" onkeyup="calculate_days(' . $emcode->emp_code . ');"></td><td><input type="number" class="form-control sm_n_absentd" name="n_absentd' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->no_of_days_absent . '" id="n_absentd_' . $emcode->emp_code . '" readonly></td><td><input type="number" class="form-control sm_n_salaryd" name="n_salaryd' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->no_of_days_salary . '" id="n_salaryd_' . $emcode->emp_code . '" readonly ></td><td><input type="number" class="form-control sm_n_salaryadjd" name="n_salaryadjd' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->no_sal_adjust_days . '" id="n_salaryadjd_' . $emcode->emp_code . '"  ></td>';

            }

            return view('attendance/set-monthly-process-attandance-all', compact('result', 'Roledata', 'month_yr_new', 'monthlist'));
        } else {
            return redirect('/');
        }
    }

    public function UpdateAttendanceAllemployee(Request $request)
    {

        if (!empty(Session::get('admin'))) {

            //dd($request->deleteme);

            if (isset($request->deleteme) && $request->deleteme == 'yes') {
                Process_attendance::where('month_yr', $request->deletemy)->delete();
                Session::flash('message', 'All generated attendance records deleted successfully.');
                return redirect('attendance/view-montly-attendance-data-all');
            }

            $request->empcode_check = explode(',', $request->cboxes);

            if (isset($request->empcode_check) && count($request->empcode_check) != 0) {

                $sm_emp_code_ctrl = explode(',', $request->sm_emp_code_ctrl);
                $sm_emp_name_ctrl = explode(',', $request->sm_emp_name_ctrl);
                $sm_emp_designation_ctrl = explode(',', $request->sm_emp_designation_ctrl);
                $sm_month_yr_ctrl = explode(',', $request->sm_month_yr_ctrl);

                $sm_n_workingd_ctrl = explode(',', $request->sm_n_workingd_ctrl);
                $sm_n_absentd_ctrl = explode(',', $request->sm_n_absentd_ctrl);
                $sm_n_leaved_ctrl = explode(',', $request->sm_n_leaved_ctrl);
                $sm_n_presentd_ctrl = explode(',', $request->sm_n_presentd_ctrl);
                $sm_n_salaryd_ctrl = explode(',', $request->sm_n_salaryd_ctrl);
                $sm_n_salaryadjd_ctrl = explode(',', $request->sm_n_salaryadjd_ctrl);

                foreach ($request->empcode_check as $key => $value) {

                    $index = array_search($value, $sm_emp_code_ctrl);

                    if($value !=""){

                        $data['employee_code'] = $value;
                        //$data['emp_name'] = $request['emp_name' . $value];
                        // $data['emp_name'] = $sm_emp_name_ctrl[$index];
    
                        //$data['emp_designation'] = $request['emp_designation' . $value];
                        //$data['emp_designation'] = $sm_emp_designation_ctrl[$index];
    
                        // $data['month_yr'] = $request['month_yr' . $value];
                        $data['month_yr'] = $sm_month_yr_ctrl[$index];
    
                        // $attendancelist = Process_attendance::where('month_yr', '=', $data['month_yr'])
                        //     ->where('employee_code', '=', $value)
                        //     ->get();
    
                        // if (count($attendancelist) > 0) {
                        //     Session::flash('error', 'Attendance Already Generated for the month.');
    
                        //     return redirect('attendance/add-montly-attendance-data-all');
                        // }
    
                        $data['no_of_working_days'] = $sm_n_workingd_ctrl[$index];
                        $data['no_of_days_absent'] = $sm_n_absentd_ctrl[$index];
                        $data['no_of_days_leave_taken'] = $sm_n_leaved_ctrl[$index];
                        $data['no_of_present'] = $sm_n_presentd_ctrl[$index];
                        $data['no_of_tour_leave'] = '0';
                        $data['no_of_days_salary'] = $sm_n_salaryd_ctrl[$index];
                        $data['no_sal_adjust_days'] = $sm_n_salaryadjd_ctrl[$index];
                        $data['status'] = 'A';
                        // $data['status'] = 'process';
                        $data['updated_at'] = date('Y-m-d H:i:s');
    
                        //dd($data);
                        //Process_attendance::update($data);
                        Process_attendance::where('month_yr', $sm_month_yr_ctrl[$index])->where('employee_code', $value)->update($data);
    
                        Session::flash('message', 'Record Successfully updated.');
                    }


                }
            } else {
                Session::flash('error', 'No Record is selected');
            }

            return redirect('attendance/view-montly-attendance-data-all');
        } else {
            return redirect('/');
        }
    }


    public function reportMonthlyAttendanceAllemployee()
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['result'] = '';
            $data['monthlist'] = Process_attendance::select('month_yr')->distinct('month_yr')->get();

            return view('attendance/report-monthly-attandance', $data);
        } else {
            return redirect('/');
        }
    }

    public function getMonthlyAttendanceReport(Request $request)
    {

        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $Roledata = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $req_month=$request['month_yr'];

            $payrolldate = explode('/', $request['month_yr']);
            $payroll_date = "0" . ($payrolldate[0] - 2);
            $origDate = $payroll_date . "/" . $payrolldate[1];

            //$current_month_days = cal_days_in_month(CAL_GREGORIAN, $payrolldate[0], $payrolldate[1]);
            //dd($current_month_days);
            $datestring = $payrolldate[1] . '-' . $payrolldate[0] . '-01';
            // Converting string to date
            $date = strtotime($datestring);
            $current_month_days = date("t", strtotime(date("Y-m-t", $date)));

            $tomonthyr = $payrolldate[1] . "-" . $payroll_date . "-" . $current_month_days;
            $formatmonthyr = $payrolldate[1] . "-" . $payroll_date . "-01";

            $month_yr_new = $request['month_yr'];

            $monthlist = Process_attendance::select('month_yr')->distinct('month_yr')->get();

            // $rate_rs = Rate_master::leftJoin('rate_details', 'rate_details.rate_id', '=', 'rate_masters.id')
            //     ->select('rate_details.*', 'rate_masters.head_name')
            //     ->get();

            $result = '';

            $emplist = Process_attendance::join('employees', 'employees.emp_code', '=', 'process_attendances.employee_code')
                ->where('process_attendances.month_yr', '=', $month_yr_new)
                ->where('process_attendances.status', '=', 'A')
                ->where('employees.emp_status', '!=', 'TEMPORARY')
                ->where('employees.emp_status', '!=', 'EX-EMPLOYEE')
                ->where('employees.emp_status', '!=', 'EX- EMPLOYEE')
            // ->where('employees.emp_code', '=', '1831')
                ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
                ->get();

            // if (count($emplist) == 0) {
            //     Session::flash('error', 'Attendance for the month ' . $month_yr_new . ' already processed.');
            //     return redirect('attendance/view-montly-attendance-data-all');
            // }
            $cnt=0;
            foreach ($emplist as $mainkey => $emcode) {

                $cnt=$cnt+1;

                $result .= '<tr>
								<td>'.$cnt.'</td>
								<td>' . $emcode->emp_code . '</td>
                                <td>' . $emcode->old_emp_code . '</td>
								<td>' . $emcode->emp_fname . ' ' . $emcode->emp_mname . ' ' . $emcode->emp_lname . '</td>
								<td>' . $request['month_yr'] . '</td>
								<td>' . $emcode->no_of_working_days . '</td>
                                <td>' . $emcode->no_of_present . '</td>
                                <td>' . $emcode->no_of_days_leave_taken . '</td>
                                <td>' . $emcode->no_of_days_absent . '</td>
                                <td>' . $emcode->no_of_days_salary . '</td>
                                <td>' . $emcode->no_sal_adjust_days . '</td>';

            }

            return view('attendance/report-monthly-attandance', compact('result', 'Roledata', 'month_yr_new', 'monthlist','req_month'));
        } else {
            return redirect('/');
        }
    }

    public function attandence_xlsexport(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $month_yr = '';
            if (isset($request->month_yr)) {
                $month_yr = $request->month_yr;
            }
            $month_yr_str='';
            if($month_yr!=''){
                $month_yr_str=explode('/',$month_yr);
                $month_yr_str=implode('-',$month_yr_str);
            }

            return Excel::download(new ExcelFileExportAttendanceEntry($month_yr), 'AttendanceReport-'.$month_yr_str.'.xlsx');
        }
        else {
            return redirect('/');
        }
    }


}
