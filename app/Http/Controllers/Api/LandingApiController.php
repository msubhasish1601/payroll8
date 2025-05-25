<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LandingApiController extends Controller
{

    public function getlogin(Request $request)
    {

        $Employee1 = DB::table('users')->where('email', '=', $request->email)->where('status', '=', 'active')->first();
        // print_r($Employee1);
        // die();

        if (!empty($Employee1)) {
            if (Hash::check($request->psw, $Employee1->password)) {
                // print_r($Employee1);
                // die();
                if ($Employee1->user_type == 'user') {

                    $Employee = DB::table('employees')->where('emp_code', '=', $Employee1->employee_id)->first();

                    if (!empty($Employee)) {

                        $Roles_auth = DB::table('role_authorizations')
                        // ->where('emid', '=', $Employee->emid)
                            ->where('member_id', '=', $request->email)
                            ->get()->toArray();
                        $arrrole = array();
                        foreach ($Roles_auth as $valrol) {
                            $arrrole[] = $valrol->menu;
                        }
                        $laeve_ap = '';

                        if (in_array('50', $arrrole)) {
                            $laeve_ap = 'yes';
                        } else {
                            $laeve_ap = 'No';
                        }
                        $contact = '';

                        if ($Employee->emp_status == 'CONTRACTUAL' || $Employee->emp_status == 'FULL TIME' || $Employee->emp_status == 'PART TIME') {
                            $contact = 'yes';
                        } else {
                            $contact = 'No';
                        }

                        return response()->json(['msg' => 'Login successfully', 'status' => 'true', 'user_type' => 'employee', $Employee, 'user_id' => $Employee1->id, 'Leave_approver' => $laeve_ap, 'Contract_agrrement' => $contact]);

                    } else {
                        return response()->json(['msg' => 'You are not active!', 'status' => 'false']);
                    }

                } else if ($Employee1->user_type == 'admin') {
                    // $Employee = DB::table('registration')->where('email', '=', $request->email)->where('pass', '=', $request->psw)->first();

                    $employee_active = DB::table('users')->join('employees', 'users.employee_id', '=', 'employees.emp_code')

                    // ->where('employee.emid', '=', $Employee->reg)
                    // ->where('users.emid', '=', $Employee->reg)
                        ->where('users.status', '=', 'active')
                        ->where('users.user_type', '=', 'admin')
                        ->select('users.*')->get();

                    $employee_migarnt = DB::table('users')->join('employees', 'users.employee_id', '=', 'employees.emp_code')

                    // ->where('employee.emid', '=', $Employee->reg)
                    // ->where('users.emid', '=', $Employee->reg)
                        ->where('users.status', '=', 'active')
                        ->where('users.user_type', '=', 'admin')
                        ->select('employees.*')->get();

                    $t = 0;
                    if (count($employee_migarnt) != 0) {

                        foreach ($employee_migarnt as $mirga) {

                            if ($mirga->visa_exp_date != '1970-01-01') {

                                if ($mirga->visa_exp_date != 'null') {
                                    if ($mirga->visa_exp_date != '') {
                                        $t++;
                                    }
                                }

                            }

                        }
                    }

                    return response()->json(['status' => 'true', $Employee1, 'user_type' => 'employer', 'employer_user_id' => $Employee1->id]);

                } else {

                    return response()->json(['msg' => 'Your email or password was wrong!', 'status' => 'false']);
                }
            } else {

                return response()->json(['msg' => 'Your email or password was wrong!', 'status' => 'false']);
            }
        } else {

            return response()->json(['msg' => 'Your email or password was wrong!', 'status' => 'false']);
        }

        //  @if(auth()->check())
        //auth()->user()->name
    }

    public function aleavemployee(Request $request)
    {

        $users = DB::table('users')->where('id', '=', $request->employee_id)->where('status', '=', 'active')->first();

        if ($users->user_type == 'user') {

            $employee = DB::table('employees')->where('emp_code', '=', $users->employee_id)->first();
            $leave_type_rs =
            DB::table('leave_types')
                ->join('leave_allocations', 'leave_types.id', '=', 'leave_allocations.leave_type_id')
                ->select('leave_types.*')
                ->where('leave_allocations.employee_code', '=', $users->employee_id)
                ->where('leave_allocations.month_yr', 'like', '%' . date('Y') . '%')
                ->where('leave_allocations.leave_in_hand', '!=', 0)
                ->get();

            $holiday_rs = DB::Table('holidays')->select('from_date', 'to_date', 'day', 'holiday_type')->get();
            // dd($holiday_rs);

            $holidays = array();
            $holiday_type = array();

            foreach ($holiday_rs as $holiday) {

                if ($holiday->day > '1') {
                    $from_date = $holiday->from_date;
                    $to_date = $holiday->to_date;

                    $date1 = date("d-m-Y", strtotime($from_date));
                    $date2 = date("d-m-Y", strtotime($to_date));
                    // dd($date1);
                    // Declare an empty array
                    // $holiday_array = array();

                    // Use strtotime function
                    $variable1 = strtotime($date1);
                    $variable2 = strtotime($date2);

                    // Use for loop to store dates into array
                    // 86400 sec = 24 hrs = 60*60*24 = 1 day
                    for ($currentDate = $variable1; $currentDate <= $variable2; $currentDate += (86400)) {

                        $Store = date('Y-m-d', $currentDate);

                        $holidays[] = $Store;
                        $holiday_type[] = $holiday->holiday_type;

                    }

                    // Display the dates in array format

                } elseif ($holiday->day == '1') {
                    $Store = $holiday->from_date;
                    $holidays[] = $Store;
                    $holiday_type[] = $holiday->holiday_type;
                }

                $holiday_array = array("holidays" => $holidays, "holiday_type" => $holiday_type);

            }

            return response()->json(['msg' => 'data  found!', 'status' => 'true', $leave_type_rs, $employee]);
        } else {

            return response()->json(['msg' => 'No rule  found!', 'status' => 'false']);
        }

        //  @if(auth()->check())
        //auth()->user()->name
    }

    public function aleaveget(Request $request)
    {
        $users = DB::table('users')->where('id', '=', $request->employee_id)->where('status', '=', 'active')->first();
        if ($users->user_type == 'user') {
            $leaveinhand = DB::table('leave_allocations')
                ->where('leave_type_id', '=', $request->leave_type)
                ->where('employee_code', '=', $users->employee_id)
                ->where('month_yr', 'like', '%' . date('Y') . '%')
                ->orderBy('id', 'DESC')
                ->first();

            if (!empty($leaveinhand)) {
                if ($leaveinhand->leave_in_hand > 0) {

                    $leave_type_rs = $leaveinhand->leave_in_hand;

                } else {
                    $leave_type_rs = '0';
                }
            } else {
                $leave_type_rs = '0';

            }
            return response()->json(['msg' => 'data  found!', 'status' => 'true', 'leave_inhand' => $leave_type_rs]);
        } else {

            return response()->json(['msg' => 'No rule  found!', 'status' => 'false']);
        }

    }

    public function saveleaveget(Request $request)
    {

        $users = DB::table('users')->where('id', '=', $request->employee_id)->where('status', '=', 'active')->first();

        $report_auth = DB::table('employees')->where('emp_code', '=', $users->employee_id)->first();
        if (!empty($report_auth)) {
            $report_auth_name = $report_auth->emp_reporting_auth;

        } else {
            $report_auth_name = '';

        }

        $diff = abs(strtotime($request->to_date) - strtotime($request->from_date));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = (floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24))) + 1;

        if ($request->days != 0) {
            if ($request->leave_inhand >= $request->days) {
                $data['employee_id'] = $users->employee_id;
                $data['employee_name'] = $request->employee_name;
                $data['emp_reporting_auth'] = $report_auth_name;
                $data['emp_lv_sanc_auth'] = '';
                $data['date_of_apply'] = $request->date_of_apply;
                $data['leave_type'] = $request->leave_type;

                $data['from_date'] = date('Y-m-d', strtotime($request->from_date));
                $data['to_date'] = date('Y-m-d', strtotime($request->to_date));
                $data['no_of_leave'] = $request->days;
                $data['status'] = "NOT APPROVED";
                $leave_apply = DB::table('leave_applies')->insert($data);

                $firebaseToken = DB::table('users')->where('employee_id', $users->employee_id)->whereNotNull('remember_token')->pluck('remember_token')->all();

                $userdata = DB::table('users')->where('employee_id', $users->employee_id)
                    ->first();
                if ($userdata->remember_token != '') {

                    $notification_details[] = array("user_id" => $userdata->id);
                }
                $notification_approver = array();

                if (count($firebaseToken) != 0) {
                    $LeaveApply = DB::table('leave_types')

                        ->where('id', $request->leave_type)

                        ->orderBy('id', 'DESC')
                        ->first();
                    $content = $request->employee_name . ' applied ' . $LeaveApply->leave_type_name . ' from ' . date('d/m/Y', strtotime($request->from_date)) . ' to ' . date('d/m/Y', strtotime($request->to_date));

                    if (!empty($report_auth)) {

                        $firebaseToken_report = DB::table('users')
                            ->where('employee_id', $report_auth->emp_reporting_auth)
                            ->where('emid', $users->emid)->first();

                        if (!empty($firebaseToken_report) && $firebaseToken_report->device_token != '') {

                            $notification_approver[] = array("user_id" => $firebaseToken_report->id);

                            $bodyapprove = '{
                            "from":"employee",
                            "to":"approver",
                            "navigate":"leave",
                            "message":"' . $content . '"
                            }';
                            $data = array('notification_details' => $notification_approver, 'body' => $bodyapprove, 'title' => 'Leave Applied');

                            $server_output = '';
                            $ch = curl_init();

                            curl_setopt($ch, CURLOPT_URL, env("BASE_URL") . "api/send-notification");
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

                            $server_output = curl_exec($ch);

                            $outputFrom = json_decode($server_output);

                        }

                    }

                    $body = '{
                    "from":"employee",
                    "to":"employer",
                    "navigate":"leave",
                    "message":"' . $content . '"
                    }';
                    $data = array('notification_details' => $notification_details, 'body' => $body, 'title' => 'Leave Applied');

                    $server_output = '';
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, env("BASE_URL") . "api/send-notification");
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

                    $server_output = curl_exec($ch);

                    $outputFrom = json_decode($server_output);

                }

                return response()->json(['msg' => 'Leave Applied Successfully', 'status' => 'true']);
            } else {

                return response()->json(['msg' => 'Sorry, No Leave Available', 'status' => 'false']);
            }

        } else {

            return response()->json(['msg' => 'Sorry, No of days does not have any  zero', 'status' => 'false']);
        }
        //  $request->leave_inhand;

    }

    public function holidayemployee(Request $request)
    {

        $Employee1 = DB::table('users')->where('id', '=', $request->employee_id)->where('status', '=', 'active')->first();
        if (!empty($Employee1)) {
            if ($Employee1->user_type == 'user') {
                $Employee = DB::table('employees')->where('emp_code', '=', $Employee1->employee_id)->first();

                // $Employer = DB::table('registration')->where('reg', '=', $Employee->emid)->first();
                $holidayEmployer = DB::table('holidays')
                    ->where('from_date', '>=', date('Y-m-d'))
                // ->orderBy('date(from_date)', 'ASC')
                    ->orderByRaw('cast(holidays.from_date as date)', 'asc')
                    ->limit(2)
                    ->get();

                // dd($holidayEmployer);

                $first_day_this_year = date('Y-01-01');
                $last_day_this_year = date('Y-12-31');

                $LeaveAllocation = DB::table('leave_allocations')
                    ->join('leave_types', 'leave_allocations.leave_type_id', '=', 'leave_types.id')
                    ->where('leave_allocations.employee_code', '=', $Employee1->employee_id)
                    ->whereBetween('leave_allocations.created_at', [$first_day_this_year, $last_day_this_year])
                //->whereDate('leave_allocation.created_at','>=',$first_day_this_year)
                    ->select('leave_allocations.*', 'leave_types.leave_type_name', 'leave_types.alies')
                    ->get();

                $leaveApply = DB::table('leave_applies')
                    ->join('leave_types', 'leave_applies.leave_type', '=', 'leave_types.id')
                    ->select('leave_applies.*', 'leave_types.leave_type_name', 'leave_types.alies')
                    ->where('leave_applies.employee_id', '=', $Employee1->employee_id)
                    ->whereDate('leave_applies.from_date', '>=', $first_day_this_year)
                    ->whereDate('leave_applies.to_date', '<=', $last_day_this_year)
                    ->orderBy('leave_applies.id', 'DESC')
                    ->limit(5)
                    ->get();

                $Roles_auth = DB::table('role_authorizations')
                    ->where('member_id', '=', $Employee1->email)
                    ->get()->toArray();
                $arrrole = array();
                foreach ($Roles_auth as $valrol) {
                    $arrrole[] = $valrol->menu;
                }
                $laeve_ap = '';

                if (in_array('50', $arrrole)) {
                    $laeve_ap = 'yes';
                } else {
                    $laeve_ap = 'No';
                }

                return response()->json(['status' => 'true', $holidayEmployer, $LeaveAllocation, $leaveApply, 'Leave_approver' => $laeve_ap, 'img' => $Employee->emp_image, $Employee]);

            }
            if ($Employee1->user_type == 'admin') {

                // $Employer = DB::table('registration')->where('reg', '=', $Employee1->employee_id)->first();

                $employee_active = DB::table('users')->join('employees', 'users.employee_id', '=', 'employees.emp_code')

                    ->where(function ($query) {

                        $query->whereNull('employees.emp_status')
                            ->orWhere('employees.emp_status', '!=', 'LEFT');
                    })

                    ->where('users.status', '=', 'active')
                    ->where('users.user_type', '=', 'employee')
                    ->select('users.*')->get();
                $employee_migarnt = DB::table('users')->join('employees', 'users.employee_id', '=', 'employees.emp_code')

                // ->where(function ($query) {
                //     $query->orWhereNotNull('employees.visa_doc_no')
                //     // ->orWhereNotNull('employee.visa_exp_date')
                //     // ->orWhereNotNull('employee.euss_exp_date')

                //         ->orWhereNotNull('employees.euss_ref_no')
                //     ;
                // })
                    ->where(function ($query) {

                        $query->whereNull('employees.emp_status')
                            ->orWhere('employees.emp_status', '!=', 'LEFT');
                    })
                    ->where('users.status', '=', 'active')
                    ->where('users.user_type', '=', 'user')
                    ->select('employees.*')->get();
                $employees = array();
                $t = 0;
                if (count($employee_migarnt) != 0) {

                    foreach ($employee_migarnt as $mirga) {

                        $dob = '';
                        $address_emp = '';

                        if ($mirga->emp_dob != '1970-01-01') {
                            if ($mirga->emp_dob != '') {
                                $dob = date('d/m/Y', strtotime($mirga->emp_dob));
                            }
                        }

                        $address_emp .= $mirga->emp_pr_street_no;
                        if ($mirga->emp_per_village) {$address_emp .= ', ' . $mirga->emp_per_village;}
                        if ($mirga->emp_pr_state) {$address_emp .= ', ' . $mirga->emp_pr_state;}if ($mirga->emp_pr_city) {$address_emp .= ', ' . $mirga->emp_pr_city;}
                        if ($mirga->emp_pr_pincode) {$address_emp .= ', ' . $mirga->emp_pr_pincode;}if ($mirga->emp_pr_country) {$address_emp .= ', ' . $mirga->emp_pr_country;}

                        $employees[] = array("emp_code" => $mirga->emp_code, "emp_fname" => $mirga->emp_fname, "emp_mname" => $mirga->emp_mname, "emp_lname" => $mirga->emp_lname
                            , 'emp_dob' => $dob, 'emp_ps_phone' => $mirga->emp_ps_phone, 'address' => $address_emp);

                        $t++;

                    }
                } else {
                    $employees[] = (object) array();
                }

                return response()->json(['status' => 'true', 'user_type' => 'employer', 'total_employee' => count($employee_active), 'total_migrant' => count($employee_migarnt), 'monitoring' => $employees, 'img' => $Employee->logo ?? '']);

            }

        } else {

            return response()->json(['msg' => 'Your email and password was wrong!', 'status' => 'false']);
        }

        //  @if(auth()->check())
        //auth()->user()->name
    }

    public function allholdaymployee(Request $request)
    {

        $Employee1 = DB::table('users')->where('id', '=', $request->employee_id)->where('status', '=', 'active')->first();

        if ($Employee1->user_type == 'user') {
            $Employee = DB::table('employees')->where('emp_code', '=', $Employee1->employee_id)->first();

            $holidayEmployer = DB::table('holidays')->where('from_date', '>=', date('Y-01-01'))->where('from_date', '<=', date('Y-12-31'))->orderBy('from_date', 'ASC')
                ->get();

            if (!empty($holidayEmployer)) {
                return response()->json(['status' => 'true', $holidayEmployer]);
            } else {
                return response()->json(['msg' => 'No holiday found!', 'status' => 'false']);
            }

        } else {

            return response()->json(['msg' => 'No holiday found!', 'status' => 'false']);
        }

        //  @if(auth()->check())
        //auth()->user()->name
    }

    public function leaveapprivere(Request $request)
    {

        $users = DB::table('users')->where('id', '=', $request->employee_id)->where('status', '=', 'active')->first();

        // dd($users->employee_id);

        $emp_code = $users->employee_id;

        $LeaveApply = DB::table('leave_applies')
            ->join('leave_types', 'leave_applies.leave_type', '=', 'leave_types.id')
            ->join('employees', 'leave_applies.employee_id', '=', 'employees.emp_code')
            ->select('leave_applies.*', 'leave_types.leave_type_name', 'leave_types.alies', 'employees.emp_status')

            ->where(function ($result) use ($emp_code) {
                if ($emp_code) {
                    $result->where('leave_applies.emp_reporting_auth', $emp_code)
                        ->orWhere('leave_applies.emp_lv_sanc_auth', $emp_code);
                }
            })

            ->orderBy('date_of_apply', 'DESC')
            ->get();

        // dd($LeaveApply);

        if (!empty($LeaveApply)) {

            return response()->json(['msg' => 'Leave data found', 'status' => 'true', $LeaveApply]);
        } else {

            return response()->json(['msg' => 'Sorry, No Leave Available', 'status' => 'false']);
        }

    }

    public function leaveapprivereedit(Request $request)
    {

        $users = DB::table('users')->where('id', '=', $request->employee_id)->where('status', '=', 'active')->first();

        // $id = $request->employee_id;
        $id = $request->id;

        $LeaveApply = DB::table('leave_applies')
            ->join('leave_types', 'leave_applies.leave_type', '=', 'leave_types.id')
            ->join('employees', 'leave_applies.employee_id', '=', 'employees.emp_code')
            ->select('leave_applies.*', 'leave_types.leave_type_name', 'leave_types.alies', 'employees.emp_status')
            ->where('leave_applies.id', '=', $id)
        // ->where('leave_applies.employee_id', '=', $id)
            ->first();
        // print_r($LeaveApply);
        // die();
        // dd($data['LeaveApply']);

        $lv_aply = DB::table('leave_applies')
        // ->where('employee_id', '=', $id)
            ->where('id', '=', $id)
            ->pluck('employee_id');
        // dd($lv_aply);
        $lv_type = DB::table('leave_applies')
            ->where('id', '=', $id)
        // ->where('employee_id', '=', $id)
            ->first();

        $Prev_leave = DB::table('leave_applies')
            ->join('leave_types', 'leave_applies.leave_type', '=', 'leave_types.id')

            ->join('employees', 'leave_applies.employee_id', '=', 'employees.emp_code')

            ->select('leave_applies.*', 'leave_types.leave_type_name', 'leave_types.alies', 'employees.emp_status')
            ->where('leave_applies.leave_type', '=', $lv_type->leave_type)
            ->where('leave_applies.employee_id', '=', $lv_aply)
            ->where('leave_applies.status', '=', 'APPROVED')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
        $from = date('Y-01-01');
        $to = date('Y-12-31');
        $totleave = DB::table('leave_applies')

            ->where('status', '=', 'APPROVED')
            ->select(DB::raw('SUM(no_of_leave) AS totleave'))

            ->where('leave_type', '=', $lv_type->leave_type)
            ->where('employee_id', '=', $lv_type->employee_id)
            ->whereBetween('from_date', [$from, $to])
            ->whereBetween('to_date', [$from, $to])
            ->orderBy('date_of_apply', 'desc')
            ->first();

        if (!empty($LeaveApply)) {

            return response()->json(['msg' => 'Leave data found', 'status' => 'true', $LeaveApply, $Prev_leave, $totleave]);
        } else {

            return response()->json(['msg' => 'Sorry, No Leave Available', 'status' => 'false']);
        }

    }

    public function dailytimeemployee(Request $request)
    {

        $Employeeus = DB::table('users')->where('employee_id', '=', $request->employee_id)->where('status', '=', 'active')->first();
        $employee_code = '';
        $time_out = '';
        $fetch_date = '';
        if ($Employeeus->user_type == 'user') {

            $daliyEmployee = DB::table('attandence')->select(DB::raw('DISTINCT date'))->distinct('date')->where('employee_code', '=', $Employeeus->employee_id)->where('month', '=', $request->month)->orderBy('id', 'asc')->get();
            // print_r($daliyEmployee);
            // die();
            if (count($daliyEmployee) != 0) {

                foreach ($daliyEmployee as $value) {

                    $attndetails = array('date' => $value->date, 'month' => $request->month);
                    $daliyEmployeedate = DB::table('attandence')->where('employee_code', '=', $Employeeus->employee_id)->where('month', '=', $request->month)->where('date', '=', $value->date)->orderBy('id', 'asc')->get();
                    foreach ($daliyEmployeedate as $valuedate) {

                        $attndetails['log'][] = array('timein' => $valuedate->time_in, 'timeout' => $valuedate->time_out,
                            'time_in_location' => $valuedate->time_in_location, 'time_out_location' => $valuedate->time_out_location,
                            'duty_hours' => $valuedate->duty_hours);
                    }
                    $dvalue[] = array_merge($attndetails);
                }
                return response()->json(['msg' => 'Data is found ', 'resultstatus' => 'true', 'status' => 'active', $dvalue]);
            } else {
                return response()->json(['msg' => 'Data is  not found', 'resultstatus' => 'false', 'status' => 'active']);
            }

        } else {
            return response()->json(['msg' => 'Employer Does not exits', 'resultstatus' => 'false', 'status' => 'inactive']);
        }

    }

    public function timeinemployee(Request $request)
    {

        $Employeeus = DB::table('users')
            ->where('id', '=', $request->employee_id)
            ->where('status', '=', 'active')
            ->first();

        $employee_code = '';
        $time_out = '';
        $fetch_date = '';
        $add = '';
        if ($Employeeus->user_type == 'user') {

            $daliyEmployee = DB::table('attandence')
                ->where('employee_code', '=', $Employeeus->employee_id)
            // ->where('date', '=', $request->date)
                ->orderBy('id', 'desc')->first();

            //dd($Employeeus);

            if (!empty($daliyEmployee)) {
                $time_out = $daliyEmployee->time_out;
                $employee_code = $daliyEmployee->employee_code;
                $fetch_date = $daliyEmployee->date;

                $add = 'yes';

                // $Roledata = DB::table('duty_rosters')
                //     ->whereDate('start_date', '<=', $request->date)
                //     ->whereDate('end_date', '>=', $request->date)
                //     ->where('duty_rosters.employee_id', '=', $Employeeus->employee_id)
                //     ->first();

                // if (!empty($Roledata)) {
                //     $add = 'yes';
                // } else {
                //     $add = '';
                // }

            } else {
                // $time_out = $daliyEmployee->time_out;
                // $employee_code = $daliyEmployee->employee_code;
                // $fetch_date = $daliyEmployee->date;

                $add = 'yes';

                // $Roledata = DB::table('duty_rosters')
                //     ->whereDate('start_date', '<=', $request->date)
                //     ->whereDate('end_date', '>=', $request->date)
                //     ->where('duty_rosters.employee_id', '=', $Employeeus->employee_id)
                //     ->first();

                // if (!empty($Roledata)) {
                //     $add = 'yes';
                // } else {
                //     $add = '';
                // }
                //dd($Roledata);

            }

            //Restrict to single clock in
            // $attnForTheDate = DB::table('attandence')
            //     ->where('employee_code', '=', $Employeeus->employee_id)
            //     ->where('date', '=', $request->date)
            //     ->orderBy('id', 'desc')->first();

            // if (!empty($attnForTheDate)) {
            //     $add = '';
            // }

            if ($employee_code != '' && $time_out != '' && !empty($add)) {
                $Employee = DB::table('employees')
                    ->where('emp_code', '=', $Employeeus->employee_id)
                    ->first();

                $employee_name = $Employee->emp_fname . $Employee->emp_mname . $Employee->emp_lname;

                // $Employer = DB::table('registration')->where('reg', '=', $Employee->emid)->first();

                $data = array(
                    'employee_code' => $Employee->emp_code,
                    'employee_name' => $employee_name,
                    'date' => $request->date,
                    'time_in' => $request->time_in,
                    'month' => $request->month,
                    'time_in_location' => $request->time_in_location,
                );

                DB::table('attandence')->insert($data);

                return response()->json(['msg' => 'data is saved', 'resultstatus' => 'true', 'status' => 'active']);

            } else if ($employee_code == '' && $time_out == '' && !empty($add)) {
                $Employee = DB::table('employees')
                    ->where('emp_code', '=', $Employeeus->employee_id)
                    ->first();

                $employee_name = $Employee->emp_fname . $Employee->emp_mname . $Employee->emp_lname;

                // $Employer = DB::table('registration')->where('reg', '=', $Employee->emid)->first();

                $data = array(
                    'employee_code' => $Employee->emp_code,
                    'employee_name' => $employee_name,

                    'date' => $request->date,
                    'time_in' => $request->time_in,
                    'month' => $request->month,
                    'time_in_location' => $request->time_in_location,

                );

                DB::table('attandence')->insert($data);
                return response()->json(['msg' => 'Attendance Time In Saved', 'resultstatus' => 'true', 'status' => 'active']);
            } else if (!empty($attnForTheDate)) {
                return response()->json(['msg' => 'Attendance submitted for today ', 'resultstatus' => 'false', 'status' => 'active']);

            } else if (empty($add)) {
                return response()->json(['msg' => 'Duty Roster is not found for today ', 'resultstatus' => 'false', 'status' => 'active']);

            } else {
                return response()->json(['msg' => 'You have not Clocked Out last time. Clock Out first', 'resultstatus' => 'false', 'status' => 'active']);

            }

        } else {
            return response()->json(['msg' => 'Employer Does not exits', 'resultstatus' => 'false', 'status' => 'inactive']);
        }

    }

    public function timeoutemployee(Request $request)
    {

        $Employeeus = DB::table('users')->where('id', '=', $request->employee_id)->where('status', '=', 'active')->first();
        $employee_code = '';
        $time_in = '';
        $fetch_time_out = '';
        $last_attendence_id = '';
        $date_arr1 = '';
        $d2 = '';
        $m2 = '';
        $y2 = '';
        $new_date2 = '';
        $datein = '';
        $dateout = '';
        $difference = '';
        $hours = '';
        $minutes = '';
        $duty_hours = '';
        $add = 'yes';
        // $add = '';
        // $Roledata = DB::table('duty_rosters')

        //     ->whereDate('start_date', '<=', $request->date)
        //     ->whereDate('end_date', '>=', $request->date)

        //     ->where('duty_rosters.employee_id', '=', $Employeeus->employee_id)
        //     ->first();
        // if (!empty($Roledata)) {
        //     $add = 'yes';
        // } else {
        //     $add = '';
        // }
        if ($Employeeus->user_type == 'user' && !empty($add)) {
            $date_arr = explode('-', $request->date);
            $d1 = $date_arr[0];
            $m1 = $date_arr[1];
            $y1 = $date_arr[2];
            $new_date1 = $y1 . '-' . $m1 . '-' . $d1;
            $daliyEmployee = DB::table('attandence')->where('employee_code', '=', $Employeeus->employee_id)->orderBy('id', 'desc')->first();

            if (!empty($daliyEmployee) && !empty($add)) {
                if ($request->time_out != '' && !empty($add)) {

                    if (!empty($daliyEmployee)) {

                        $employee_code = $daliyEmployee->employee_code;

                        $dt = $daliyEmployee->date;
                        $time_in = $daliyEmployee->time_in;
                        $fetch_time_out = $daliyEmployee->time_out;
                        $last_attendence_id = $daliyEmployee->id;
                        $date_arr1 = explode('-', $dt);
                        $d2 = $date_arr1[0];
                        $m2 = $date_arr1[1];
                        $y2 = $date_arr1[2];
                        $new_date2 = $y2 . '-' . $m2 . '-' . $d2;
                        $datein = strtotime(date("Y-m-d " . $time_in));
                        $dateout = strtotime(date("Y-m-d " . $request->time_out));
                        $difference = abs($dateout - $datein) / 60;
                        $hours = floor($difference / 60);
                        $minutes = ($difference % 60);
                        $duty_hours = $hours . ":" . $minutes;
                        $days = $d1 - $d2;
                    }

                    if ($fetch_time_out == "" && !empty($add)) {
                        $Employee = DB::table('employees')->where('emp_code', '=', $Employeeus->employee_id)->first();
                        $employee_name = $Employee->emp_fname . $Employee->emp_mname . $Employee->emp_lname;
                        // $Employer = DB::table('registration')->where('reg', '=', $Employee->emid)->first();
                        $data = array(
                            'duty_hours' => $duty_hours,

                            'date' => $dt,
                            'time_out' => $request->time_out,
                            'month' => $request->month,
                            'time_out_location' => $request->time_out_location,

                        );
                        DB::table('attandence')->where('employee_code', $Employee->emp_code)->where('id', $last_attendence_id)->update($data);

                        return response()->json(['msg' => 'Attendance Time Out Saved', 'resultstatus' => 'true', 'status' => 'active']);
                    } else if (empty($add)) {
                        return response()->json(['msg' => 'Duty Roster is not found for today ', 'resultstatus' => 'false', 'status' => 'active']);

                    } else {
                        return response()->json(['msg' => 'You have not Clocked In last time. Clock In first', 'resultstatus' => 'false', 'status' => 'active']);

                    }} else if (empty($add)) {
                    return response()->json(['msg' => 'Duty Roster is not found for today ', 'resultstatus' => 'false', 'status' => 'active']);

                } else {
                    return response()->json(['msg' => 'Time In not completed', 'resultstatus' => 'false', 'status' => 'active']);

                }
            } else if (empty($add)) {
                return response()->json(['msg' => 'Duty Roster is not found for today ', 'resultstatus' => 'false', 'status' => 'active']);

            } else {
                return response()->json(['msg' => 'You have not Clocked In last time. Clock In first', 'resultstatus' => 'false', 'status' => 'active']);

            }
        } else if (empty($add)) {
            return response()->json(['msg' => 'Duty Roster is not found for today ', 'resultstatus' => 'false', 'status' => 'active']);

        } else {
            return response()->json(['msg' => 'Employer Does not exits', 'resultstatus' => 'false', 'status' => 'inactive']);
        }

    }

    public function employerleaveapprivere($employer_id)
    {

        // dd($employer_id);

        if ($employer_id == "employer") {
            $LeaveApply = DB::table('leave_applies')
                ->join('leave_types', 'leave_applies.leave_type', '=', 'leave_types.id')
                ->join('employees', 'leave_applies.employee_id', '=', 'employees.emp_code')
                ->select('leave_applies.*', 'leave_types.leave_type_name', 'leave_types.alies', 'employees.emp_status')

            // ->where('employees.emp_code', '=', $employer_id)
            // ->where('leave_applies.employee_id', '=', $employer_id)

                ->orderBy('date_of_apply', 'DESC')
                ->get();

        } else {
            $LeaveApply = DB::table('leave_applies')
                ->join('leave_types', 'leave_applies.leave_type', '=', 'leave_types.id')
                ->join('employees', 'leave_applies.employee_id', '=', 'employees.emp_code')
                ->select('leave_applies.*', 'leave_types.leave_type_name', 'leave_types.alies', 'employees.emp_status')

                ->where('employees.emp_code', '=', $employer_id)
                ->where('leave_applies.employee_id', '=', $employer_id)

                ->orderBy('date_of_apply', 'DESC')
                ->get();

        }

        if (count($LeaveApply) != 0) {
            return response()->json(['msg' => 'data found', 'resultstatus' => 'true', 'laevelist' => $LeaveApply]);

        } else {
            return response()->json(['msg' => 'data not found', 'resultstatus' => 'false', 'laevelist' => $LeaveApply]);

        }

    }

    public function dailyattandanceshow($employer_id)
    {

        $date = date('Y-m-d');
        $daliyEmployee = DB::table('attandence')->select(DB::raw('DISTINCT employee_code'))->distinct('employee_code')->where('employee_code', '=', $employer_id)
            ->where('date', '=', $date)->orderBy('employee_name', 'asc')->get();
        $attndetails = array();
        $dvalue = array();

        if (count($daliyEmployee) != 0) {
            foreach ($daliyEmployee as $value) {

                $Roledata = DB::table('employees')->join('users', 'employees.emp_code', '=', 'users.employee_id')

                    ->where('employees.emp_code', '=', $value->employee_code)
                    ->where('employees.emp_code', '=', $employer_id)
                    ->where('users.employee_id', '=', $employer_id)
                    ->where('users.status', '=', 'active')
                    ->where('users.user_type', '=', 'user')
                    ->select('employees.emp_code', 'employees.emp_fname', DB::raw('ifnull(employees.emp_mname,"") as emp_mname'), 'employees.emp_lname', 'employees.emp_ps_email', DB::raw('ifnull(employees.emp_ps_phone,"") as emp_ps_phone'))
                    ->first();
                // print_r($Roledata);
                // die();
                // $attndetails = array('date' => $date, 'employee_code' => $value->employee_code);

                $attndetails = array('date' => $date, 'employee_code' => $value->employee_code
                    , 'emp_fname' => $Roledata->emp_fname, 'emp_mname' => $Roledata->emp_mname, 'emp_lname' => $Roledata->emp_lname);

                $daliyEmployeedate = DB::table('attandence')->where('employee_code', '=', $value->employee_code)
                    ->where('date', '=', $date)->where('employee_code', '=', $employer_id)->orderBy('id', 'asc')->get();

                foreach ($daliyEmployeedate as $valuedate) {

                    $attndetails['log'][] = array('timein' => $valuedate->time_in, 'timeout' => $valuedate->time_out,
                        'time_in_location' => $valuedate->time_in_location, 'time_out_location' => $valuedate->time_out_location,
                        'duty_hours' => $valuedate->duty_hours);
                }
                $dvalue[] = array_merge($attndetails);

            }

            return response()->json(['msg' => 'data found', 'resultstatus' => 'true', 'attandence' => $dvalue]);

        } else {
            return response()->json(['msg' => 'data not found', 'resultstatus' => 'false', 'attandence' => $dvalue]);

        }

    }

    public function LeaveCountdate($employee_id, $from_date, $to_date, $leave_type)
    {
        $users = DB::table('users')->where('id', '=', $employee_id)->first();
        $satnew = 'Saturday';
        $sunnew = 'Sunday';
        $total_wk_days = 0;
        $date1_ts = strtotime($from_date);
        $date2_ts = strtotime($to_date);
        $diff = $date2_ts - $date1_ts;
        $leave_tyepenew = DB::table('leave_types')->where('id', '=', $leave_type)->first();

        $Date1 = date('d-m-Y', strtotime($from_date));
        $Date2 = date('d-m-Y', strtotime($to_date));

        //dd($leave_tyepenew);

        // Declare an empty arraya
        $array = array();

        // Use strtotime function
        $Variable1 = strtotime($Date1);
        $Variable2 = strtotime($Date2);

        // Use for loop to store dates into array
        // 86400 sec = 24 hrs = 60*60*24 = 1 day
        for ($currentDate = $Variable1; $currentDate <= $Variable2;
            $currentDate += (86400)) {

            $Store = date('Y-m-d', $currentDate);
            $array[] = $Store;
        }

        if (trim($leave_tyepenew->alies) == 'HOLIDAY' || trim($leave_tyepenew->alies) == 'H') {
            $total_wk_days = (round($diff / 86400) + 1);

            //dd($total_wk_days);

            $daysnew = 0;
            if (date('d', strtotime($from_date)) > $total_wk_days) {
                $total_wk_days = date('d', strtotime($from_date)) + ($total_wk_days - 1);
            } else if (date('d', strtotime($from_date)) != 1) {
                $total_wk_days = date('d', strtotime($from_date)) + ($total_wk_days - 1);
            } else {
                $total_wk_days = $total_wk_days;
            }
            if (date('d', strtotime($from_date)) == date('d', strtotime($to_date))) {
                $total_wk_days = date('d', strtotime($from_date));
            }
            foreach ($array as $valueogf) {

                $new_f = $valueogf;
                $duty_auth = DB::table('duty_rosters')

                    ->where('employee_id', '=', $users->employee_id)
                    ->where('emid', '=', $users->emid)

                    ->orderBy('id', 'DESC')
                    ->first();

                $holidays = DB::table('holidays')
                    ->whereDate('from_date', '<=', $new_f)
                    ->whereDate('to_date', '>=', $new_f)

                    ->where('emid', '=', $users->emid)
                    ->first();

                $offg = array();
                if (!empty($duty_auth)) {

                    $shift_auth = DB::table('shift_managements')

                        ->where('id', '=', $duty_auth->shift_code)

                        ->where('emid', '=', $users->emid)
                        ->orderBy('id', 'DESC')
                        ->first();
                    $off_auth = DB::table('offdays')

                        ->where('shift_code', '=', $duty_auth->shift_code)

                        ->where('emid', '=', $users->emid)
                        ->orderBy('id', 'DESC')
                        ->first();

                    $off_day = 0;
                    if (!empty($off_auth)) {
                        if ($off_auth->sun == '1') {

                            $off_day = $off_day + 1;
                            $offg[] = 'Sunday';
                        }
                        if ($off_auth->mon == '1') {
                            $off_day = $off_day + 1;
                            $offg[] = 'Monday';
                        }

                        if ($off_auth->tue == '1') {
                            $off_day = $off_day + 1;
                            $offg[] = 'Tuesday';
                        }

                        if ($off_auth->wed == '1') {
                            $off_day = $off_day + 1;
                            $offg[] = 'Wednesday';
                        }

                        if ($off_auth->thu == '1') {
                            $off_day = $off_day + 1;
                            $offg[] = 'Thursday';
                        }

                        if ($off_auth->fri == '1') {
                            $off_day = $off_day + 1;
                            $offg[] = 'Friday';
                        }
                        if ($off_auth->sat == '1') {
                            $off_day = $off_day + 1;
                            $offg[] = 'Saturday';
                        }

                    }
                }
                if (in_array(date('l', strtotime($new_f)), $offg)) {

                } else {
                    $daysnew++;
                }

            }

        } else {
            $diff = abs(strtotime($to_date) - strtotime($from_date));
            $years = floor($diff / (365 * 60 * 60 * 24));
            $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
            $days = (floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24))) + 1;
            $daysnew = $days;
        }

        //echo $daysnew;

        return response()->json(['msg' => 'data  found!', 'status' => 'true', 'days' => $daysnew]);

    }

    public function employerleaveapprivereedit(Request $request)
    {

        $id = $request->id;

        $LeaveApply = DB::table('leave_applies')
            ->join('leave_types', 'leave_applies.leave_type', '=', 'leave_types.id')
            ->join('employees', 'leave_applies.employee_id', '=', 'employees.emp_code')

            ->select('leave_applies.*', 'leave_types.leave_type_name', 'leave_types.alies', 'employees.emp_status')
            ->where('leave_applies.id', '=', $id)
            ->first();

        // dd($data['LeaveApply']);

        $lv_aply = DB::table('leave_applies')
            ->where('id', '=', $id)
            ->pluck('employee_id');
        $lv_type = DB::table('leave_applies')
            ->where('id', '=', $id) // dd($lv_aply);
            ->first();
        $Prev_leave = DB::table('leave_applies')
            ->join('leave_types', 'leave_applies.leave_type', '=', 'leave_types.id')

            ->join('employees', 'leave_applies.employee_id', '=', 'employees.emp_code')

            ->select('leave_applies.*', 'leave_types.leave_type_name', 'leave_types.alies', 'employees.emp_status')
            ->where('leave_applies.leave_type', '=', $lv_type->leave_type)
            ->where('leave_applies.employee_id', '=', $lv_aply)
            ->where('leave_applies.status', '=', 'APPROVED')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
        $from = date('Y-01-01');
        $to = date('Y-12-31');

        $totleave = DB::table('leave_applies')

            ->where('status', '=', 'APPROVED')
            ->select(DB::raw('SUM(no_of_leave) AS totleave'))

            ->where('leave_type', '=', $lv_type->leave_type)
            ->where('employee_id', '=', $lv_type->employee_id)
            ->whereBetween('from_date', [$from, $to])
            ->whereBetween('to_date', [$from, $to])
            ->orderBy('date_of_apply', 'desc')
            ->first();

        if (!empty($LeaveApply)) {

            return response()->json(['msg' => 'Leave data found', 'status' => 'true', $LeaveApply, $Prev_leave, $totleave]);
        } else {

            return response()->json(['msg' => 'Sorry, No Leave Available', 'status' => 'false']);
        }

    }

    public function employerSaveLeavePermission(Request $request)
    {

        $leaveApply = DB::table('leave_applies')

            ->where('id', '=', $request->apply_id)

            ->first();

        // dd($leaveApply);

        $Allocation = DB::table('leave_allocations')
            ->where('employee_code', '=', $request->employee_id)
            ->where('leave_type_id', '=', $request->leave_type)
        // ->where('emid', '=', $request->employer_id)

            ->where('month_yr', 'like', '%' . date('Y', strtotime($leaveApply->from_date)) . '%')
            ->get();

        // dd($Allocation);

        $inhand = $Allocation[0]->leave_in_hand;

        $lv_sanc_auth = DB::table('employees')
            ->where('emp_code', '=', $request->employee_id)
        // ->where('emid', '=', $request->employer_id)

            ->first();

        if (!empty($lv_sanc_auth)) {
            $lv_sanc_auth_name = $lv_sanc_auth->emp_lv_sanc_auth;
        } else {
            $lv_sanc_auth_name = '';
        }
        $laevetay = DB::table('leave_applies')->where('id', '=', $request->apply_id)->first();

        if ($request->leave_check == 'APPROVED') {

            $lv_inhand = $inhand - ($request->no_of_leave);

            if ($lv_inhand < 0) {
                return response()->json(['msg' => 'Insufficient Leave Balance ', 'status' => 'false']);

            } else {

                DB::table('leave_applies')
                    ->where('id', $request->apply_id)
                    ->where('employee_id', $request->employee_id)
                    ->update(['status' => $request->leave_check, 'status_remarks' => $request->status_remarks]);

                DB::table('leave_allocations')
                    ->where('leave_type_id', '=', $request->leave_type)
                    ->where('employee_code', '=', $request->employee_id)
                    ->where('month_yr', 'like', '%' . $request['month_yr'] . '%')
                    ->update(['leave_in_hand' => $lv_inhand]);

                $LeaveApply = DB::table('leave_types')
                    ->where('id', $request->leave_type)
                    ->orderBy('id', 'DESC')
                    ->first();

                $content = 'Your leave from ' . date('d/m/Y', strtotime($laevetay->from_date)) . ' to ' . date('d/m/Y', strtotime($laevetay->to_date)) . ' has been ' . strtolower($request->leave_check);

                $firebaseToken_report = DB::table('users')
                    ->where('employee_id', $request->employee_id)
                // ->where('emid', $request->employer_id)
                    ->first();

                if (!isset($firebaseToken_report) && $firebaseToken_report->device_token != '') {

                    $notification_approver[] = array("user_id" => $firebaseToken_report->id);

                    $bodyapprove = '{
                    "from":"employer",
                    "to":"employee",
                    "navigate":"dashboard",
                    "message":"' . $content . '"
                    }';
                    $data = array('notification_details' => $notification_approver, 'body' => $bodyapprove, 'title' => 'Leave  ' . strtolower($request->leave_check));

                    $server_output = '';
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, env("BASE_URL") . "api/send-notification");
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

                    $server_output = curl_exec($ch);

                    $outputFrom = json_decode($server_output);

                }

                return response()->json(['msg' => 'Leave  APPROVED successfully. ', 'status' => 'true']);
            }
        } else if ($request->leave_check == 'REJECTED') {
            DB::table('leave_applies')
                ->where('id', $request->apply_id)
                ->where('employee_id', $request->employee_id)
            // ->where('emid', '=', $request->employer_id)
                ->update(['status' => $request->leave_check, 'status_remarks' => $request->status_remarks]);

            $LeaveApply = DB::table('leave_types')

                ->where('id', $request->leave_type)

                ->orderBy('id', 'DESC')
                ->first();
            $content = 'Your leave from ' . date('d/m/Y', strtotime($laevetay->from_date)) . ' to ' . date('d/m/Y', strtotime($laevetay->to_date)) . ' has been ' . strtolower($request->leave_check);

            $firebaseToken_report = DB::table('users')
                ->where('employee_id', $request->employee_id)
            // ->where('emid', $request->employer_id)
                ->first();

            if (!isset($firebaseToken_report) && $firebaseToken_report->device_token != '') {

                $notification_approver[] = array("user_id" => $firebaseToken_report->id);

                $bodyapprove = '{
                "from":"employer",
                "to":"employee",
                "navigate":"dashboard",
                "message":"' . $content . '"
                }';
                $data = array('notification_details' => $notification_approver, 'body' => $bodyapprove, 'title' => 'Leave  ' . strtolower($request->leave_check));

                $server_output = '';
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, env("BASE_URL") . "api/send-notification");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

                $server_output = curl_exec($ch);

                $outputFrom = json_decode($server_output);

            }

            return response()->json(['msg' => 'Leave Rejected Successfully ', 'status' => 'true']);

        } else if ($request->leave_check == 'RECOMMENDED') {

            $lv_inhand = $inhand - $request->no_of_leave;
            // dd($lv_inhand);
            if ($lv_inhand < 0) {

                return response()->json(['msg' => 'Insufficient Leave Balance ', 'status' => 'false']);

            } else {

                $emp_code = $request->employee_id;

                $sanc_auth = DB::table('employees')
                    ->where('emp_code', $request->employee_id)
                // ->where('emid', '=', $request->employer_id)
                    ->first();

                $sanc_auth_name = $sanc_auth->emp_lv_sanc_auth;

                DB::table('leave_applies')
                    ->where('id', $request->apply_id)
                    ->where('employee_id', $request->employee_id)
                // ->where('emid', '=', $request->employer_id)
                    ->update(['status' => $request->leave_check, 'status_remarks' => $request->status_remarks, 'emp_lv_sanc_auth' => $lv_sanc_auth_name]);

                $LeaveApply = DB::table('leave_types')

                    ->where('id', $request->leave_type)

                    ->orderBy('id', 'DESC')
                    ->first();
                $content = 'Your leave from ' . date('d/m/Y', strtotime($laevetay->from_date)) . ' to ' . date('d/m/Y', strtotime($laevetay->to_date)) . ' has been ' . strtolower($request->leave_check);

                $firebaseToken_report = DB::table('users')
                    ->where('employee_id', $request->employee_id)
                // ->where('emid', $request->employer_id)
                    ->first();

                if (!isset($firebaseToken_report) && $firebaseToken_report->device_token != '') {

                    $notification_approver[] = array("user_id" => $firebaseToken_report->id);

                    $bodyapprove = '{
                    "from":"employer",
                    "to":"employee",
                    "navigate":"dashboard",
                    "message":"' . $content . '"
                    }';
                    $data = array('notification_details' => $notification_approver, 'body' => $bodyapprove, 'title' => 'Leave  ' . strtolower($request->leave_check));

                    $server_output = '';
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, env("BASE_URL") . "api/send-notification");
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

                    $server_output = curl_exec($ch);

                    $outputFrom = json_decode($server_output);

                }

                return response()->json(['msg' => 'Leave Recommended Successfully! ', 'status' => 'true']);

            }

        } else {

            $current_status = DB::table('leave_applies')
                ->where('id', $request->apply_id)
                ->first();
            if ($current_status->status == 'APPROVED' && $request->leave_check == 'CANCEL') {

                $lv_inhand = $inhand + $request->no_of_leave;
                DB::table('leave_applies')
                    ->where('id', $request->apply_id)
                    ->where('employee_id', $request->employee_id)
                // ->where('emid', '=', $request->employer_id)
                    ->update(['status' => $request->leave_check, 'status_remarks' => $request->status_remarks]);

                DB::table('leave_allocations')
                    ->where('leave_type_id', $request->leave_type)
                // ->where('emid', '=', $request->employer_id)
                    ->where('employee_code', $request->employee_id)
                    ->update(['leave_in_hand' => $lv_inhand]);

            } else {
                DB::table('leave_applies')
                    ->where('id', $request->apply_id)
                    ->where('employee_id', $request->employee_id)
                // ->where('emid', '=', $request->employer_id)
                    ->update(['status' => $request->leave_check, 'status_remarks' => $request->status_remarks]);
            }

            $LeaveApply = DB::table('leave_types')

                ->where('id', $request->leave_type)

                ->orderBy('id', 'DESC')
                ->first();
            $content = 'Your leave from ' . date('d/m/Y', strtotime($laevetay->from_date)) . ' to ' . date('d/m/Y', strtotime($laevetay->to_date)) . ' has been ' . strtolower($request->leave_check);

            $firebaseToken_report = DB::table('users')
                ->where('employee_id', $request->employee_id)
            // ->where('emid', $request->employer_id)
                ->first();

            if (!isset($firebaseToken_report) && $firebaseToken_report->device_token != '') {

                $notification_approver[] = array("user_id" => $firebaseToken_report->id);

                $bodyapprove = '{
                "from":"employer",
                "to":"employee",
                "navigate":"dashboard",
                "message":"' . $content . '"
                }';
                $data = array('notification_details' => $notification_approver, 'body' => $bodyapprove, 'title' => 'Leave  ' . strtolower($request->leave_check));

                $server_output = '';
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, env("BASE_URL") . "api/send-notification");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

                $server_output = curl_exec($ch);

                $outputFrom = json_decode($server_output);

            }

            return response()->json(['msg' => 'Leave Cancel Successfully! ', 'status' => 'true']);

        }

    }

    public function SaveLeavePermission(Request $request)
    {
        // dd($request);
        $users = DB::table('users')->where('id', '=', $request->user_id)->where('status', '=', 'active')->first();

        $leaveApply = DB::table('leave_applies')

            ->where('id', '=', $request->apply_id)

            ->first();

        $Allocation = DB::table('leave_allocations')
            ->where('employee_code', '=', $request->employee_id)
            ->where('leave_type_id', '=', $request->leave_type)
        // ->where('emid', '=', $users->emid)

            ->where('month_yr', 'like', '%' . date('Y', strtotime($leaveApply->from_date)) . '%')
            ->get();

        $inhand = $Allocation[0]->leave_in_hand;

        $lv_sanc_auth = DB::table('employees')
            ->where('emp_code', '=', $request->employee_id)
        // ->where('emid', '=', $users->emid)

            ->first();

        if (!empty($lv_sanc_auth)) {
            $lv_sanc_auth_name = $lv_sanc_auth->emp_lv_sanc_auth;
        } else {
            $lv_sanc_auth_name = '';
        }
        $laevetay = DB::table('leave_applies')->where('id', '=', $request->apply_id)->first();

        if ($request->leave_check == 'APPROVED') {

            $lv_inhand = $inhand - ($request->no_of_leave);

            if ($lv_inhand < 0) {
                return response()->json(['msg' => 'Insufficient Leave Balance ', 'status' => 'false']);

            } else {

                DB::table('leave_applies')
                    ->where('id', $request->apply_id)
                    ->where('employee_id', $request->employee_id)
                    ->update(['status' => $request->leave_check, 'status_remarks' => $request->status_remarks]);

                DB::table('leave_allocations')
                    ->where('leave_type_id', '=', $request->leave_type)
                    ->where('employee_code', '=', $request->employee_id)
                    ->where('month_yr', 'like', '%' . $request['month_yr'] . '%')
                    ->update(['leave_in_hand' => $lv_inhand]);

                $LeaveApply = DB::table('leave_types')

                    ->where('id', $request->leave_type)

                    ->orderBy('id', 'DESC')
                    ->first();
                $content = 'Your leave from ' . date('d/m/Y', strtotime($laevetay->from_date)) . ' to ' . date('d/m/Y', strtotime($laevetay->to_date)) . ' has been ' . strtolower($request->leave_check);

                $firebaseToken_report = DB::table('users')
                    ->where('employee_id', $request->employee_id)
                // ->where('emid', $users->emid)
                    ->first();

                if (!isset($firebaseToken_report) && $firebaseToken_report->device_token != '') {

                    $notification_approver[] = array("user_id" => $firebaseToken_report->id);

                    $bodyapprove = '{
                    "from":"approver",
                    "to":"employee",
                    "navigate":"dashboard",
                    "message":"' . $content . '"
                    }';
                    $data = array('notification_details' => $notification_approver, 'body' => $bodyapprove, 'title' => 'Leave  ' . strtolower($request->leave_check));

                    $server_output = '';
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, env("BASE_URL") . "api/send-notification");
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

                    $server_output = curl_exec($ch);

                    $outputFrom = json_decode($server_output);

                }

                return response()->json(['msg' => 'Leave  APPROVED successfully. ', 'status' => 'true']);

            }
        } else if ($request->leave_check == 'REJECTED') {
            DB::table('leave_applies')
                ->where('id', $request->apply_id)
                ->where('employee_id', $request->employee_id)
            // ->where('emid', '=', $users->emid)
                ->update(['status' => $request->leave_check, 'status_remarks' => $request->status_remarks]);

            $LeaveApply = DB::table('leave_types')

                ->where('id', $request->leave_type)

                ->orderBy('id', 'DESC')
                ->first();
            $content = 'Your leave from ' . date('d/m/Y', strtotime($laevetay->from_date)) . ' to ' . date('d/m/Y', strtotime($laevetay->to_date)) . ' has been ' . strtolower($request->leave_check);

            $firebaseToken_report = DB::table('users')
                ->where('employee_id', $request->employee_id)
            // ->where('emid', $users->emid)
                ->first();

            if (!isset($firebaseToken_report) && $firebaseToken_report->device_token != '') {

                $notification_approver[] = array("user_id" => $firebaseToken_report->id);

                $bodyapprove = '{
                "from":"approver",
                "to":"employee",
                "navigate":"dashboard",
                "message":"' . $content . '"
                }';
                $data = array('notification_details' => $notification_approver, 'body' => $bodyapprove, 'title' => 'Leave  ' . strtolower($request->leave_check));

                $server_output = '';
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, env("BASE_URL") . "api/send-notification");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

                $server_output = curl_exec($ch);

                $outputFrom = json_decode($server_output);

            }

            return response()->json(['msg' => 'Leave Rejected Successfully ', 'status' => 'true']);

        } else if ($request->leave_check == 'RECOMMENDED') {

            $lv_inhand = $inhand - $request->no_of_leave;
            // dd($lv_inhand);
            if ($lv_inhand < 0) {

                return response()->json(['msg' => 'Insufficient Leave Balance ', 'status' => 'false']);

            } else {

                $emp_code = $request->employee_id;

                $sanc_auth = DB::table('employees')
                    ->where('emp_code', $request->employee_id)
                // ->where('emid', '=', $users->emid)
                    ->first();

                $sanc_auth_name = $sanc_auth->emp_lv_sanc_auth;

                DB::table('leave_applies')
                    ->where('id', $request->apply_id)
                    ->where('employee_id', $request->employee_id)
                // ->where('emid', '=', $users->emid)
                    ->update(['status' => $request->leave_check, 'status_remarks' => $request->status_remarks, 'emp_lv_sanc_auth' => $lv_sanc_auth_name]);

                $LeaveApply = DB::table('leave_types')

                    ->where('id', $request->leave_type)

                    ->orderBy('id', 'DESC')
                    ->first();
                $content = 'Your leave from ' . date('d/m/Y', strtotime($laevetay->from_date)) . ' to ' . date('d/m/Y', strtotime($laevetay->to_date)) . ' has been ' . strtolower($request->leave_check);

                $firebaseToken_report = DB::table('users')
                    ->where('employee_id', $request->employee_id)
                // ->where('emid', $users->emid)
                    ->first();

                if (!isset($firebaseToken_report) && $firebaseToken_report->device_token != '') {

                    $notification_approver[] = array("user_id" => $firebaseToken_report->id);

                    $bodyapprove = '{
                    "from":"approver",
                    "to":"employee",
                    "navigate":"dashboard",
                    "message":"' . $content . '"
                    }';
                    $data = array('notification_details' => $notification_approver, 'body' => $bodyapprove, 'title' => 'Leave  ' . strtolower($request->leave_check));

                    $server_output = '';
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, env("BASE_URL") . "api/send-notification");
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

                    $server_output = curl_exec($ch);

                    $outputFrom = json_decode($server_output);

                }

                return response()->json(['msg' => 'Leave Recommended Successfully! ', 'status' => 'true']);

            }

        } else {

            $current_status = DB::table('leave_applies')->where('id', $request->apply_id)->first();
            if ($current_status->status == 'APPROVED' && $request->leave_check == 'CANCEL') {

                $lv_inhand = $inhand + $request->no_of_leave;
                DB::table('leave_applies')
                    ->where('id', $request->apply_id)
                    ->where('employee_id', $request->employee_id)
                // ->where('emid', '=', $users->emid)
                    ->update(['status' => $request->leave_check, 'status_remarks' => $request->status_remarks]);

                DB::table('leave_allocations')
                    ->where('leave_type_id', $request->leave_type)
                // ->where('emid', '=', $users->emid)
                    ->where('employee_code', $request->employee_id)
                    ->update(['leave_in_hand' => $lv_inhand]);

            } else {
                DB::table('leave_applies')
                    ->where('id', $request->apply_id)
                    ->where('employee_id', $request->employee_id)
                // ->where('emid', '=', $users->emid)
                    ->update(['status' => $request->leave_check, 'status_remarks' => $request->status_remarks]);
            }

            $LeaveApply = DB::table('leave_types')

                ->where('id', $request->leave_type)

                ->orderBy('id', 'DESC')
                ->first();
            $content = 'Your leave from ' . date('d/m/Y', strtotime($laevetay->from_date)) . ' to ' . date('d/m/Y', strtotime($laevetay->to_date)) . ' has been ' . strtolower($request->leave_check);

            $firebaseToken_report = DB::table('users')
                ->where('employee_id', $request->employee_id)
            // ->where('emid', $users->emid)
                ->first();

            if (!isset($firebaseToken_report) && $firebaseToken_report->device_token != '') {

                $notification_approver[] = array("user_id" => $firebaseToken_report->id);

                $bodyapprove = '{
                "from":"approver",
                "to":"employee",
                "navigate":"dashboard",
                "message":"' . $content . '"
                }';
                $data = array('notification_details' => $notification_approver, 'body' => $bodyapprove, 'title' => 'Leave  ' . strtolower($request->leave_check));

                $server_output = '';
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, env("BASE_URL") . "api/send-notification");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

                $server_output = curl_exec($ch);

                $outputFrom = json_decode($server_output);

            }

            return response()->json(['msg' => 'Leave Cancel Successfully! ', 'status' => 'true']);

        }

    }
}
