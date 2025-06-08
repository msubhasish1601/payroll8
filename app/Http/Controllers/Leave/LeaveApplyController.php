<?php
namespace App;

namespace App\Http\Controllers\Leave;

use App\Http\Controllers\Controller;
use App\Models\Employee\Leave_apply;
use App\Models\LeaveManagement\Leave_type;
use App\Models\Leave\Holiday;
use App\Models\Leave\Leave_allocation;
use App\Models\Masters\Role_authorization;
use App\Models\Role\Employee;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Mail;
use Session;
use Validator;
use View;

class LeaveApplyController extends Controller
{
    //
    public function viewleaveapplication()
    {
        if (! empty(Session::get('admin'))) {

            $leave_apply_rs = Leave_apply::all();
            return view('leave/leave-application', compact('leave_apply_rs'));
        } else {
            return redirect('/');
        }
    }

    public function viewapplyleaveapplication()
    {
        if (! empty(Session::get('admin'))) {

            $empid = Session('admin')->employee_id;

            $data['employee'] = Employee::where('emp_code', '=', $empid)->first();
            // $data['leave_type_rs'] = Leave_type::where('id', '!=', 3)->get();
            $data['leave_type_rs'] = Leave_type::get();

            $holiday_rs = Holiday::select('from_date', 'to_date', 'day', 'holiday_type')->get();
            // dd($holiday_rs);
            $email            = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $holidays     = [];
            $holiday_type = [];

            foreach ($holiday_rs as $holiday) {

                if ($holiday->day > '1') {
                    $from_date = \Carbon\Carbon::parse($holiday->from_date);
                    $to_date   = \Carbon\Carbon::parse($holiday->to_date);

                    $date1 = date_format($from_date, "d-m-Y");
                    $date2 = date_format($to_date, "d-m-Y");
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

                        $holidays[]     = $Store;
                        $holiday_type[] = $holiday->holiday_type;
                    }

                    // Display the dates in array format

                } elseif ($holiday->day == '1') {
                    $Store          = $holiday->from_date;
                    $holidays[]     = $Store;
                    $holiday_type[] = $holiday->holiday_type;
                }

                $data['holiday_array'] = ["holidays" => $holidays, "holiday_type" => $holiday_type];
            }

            // dd($holiday_array);
            return view('leave/apply-leave', $data);
        } else {
            return redirect('/');
        }
    }

    public function holidayLeaveApplyAjax(Request $request)
    {
        if (! empty(Session::get('admin'))) {

            // dd($request->all());
            $holidays = $request['holiday']['holidays'];

            $endDate   = strtotime($request['to_date']);
            $startDate = strtotime($request['from_date']);

            if ($request['leave_type'] == 1) {
                $days              = ($endDate - $startDate) / 86400 + 1;
                $no_full_weeks     = floor($days / 7);
                $no_remaining_days = fmod($days, 7);

                $the_first_day_of_week = date("N", $startDate);
                $the_last_day_of_week  = date("N", $endDate);

                if ($the_first_day_of_week <= $the_last_day_of_week) {
                    if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) {
                        $no_remaining_days--;
                    }

                    if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) {
                        $no_remaining_days--;
                    }

                } else {

                    if ($the_first_day_of_week == 7) {

                        $no_remaining_days--;
                        if ($the_last_day_of_week == 6) {

                            $no_remaining_days--;
                        }
                    } else {

                        $no_remaining_days -= 2;
                    }
                }

                $workingDays = $no_full_weeks * 5;
                if ($no_remaining_days > 0) {
                    $workingDays += $no_remaining_days;
                }
                //We subtract the holidays
                foreach ($holidays as $key => $holiday) {
                    $time_stamp = strtotime($holiday);
                    $hol_type   = $request['holiday']['holiday_type'][$key];
                    //If the holiday doesn't fall in weekend
                    if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N", $time_stamp) != 6 && date("N", $time_stamp) != 7 && $hol_type == 'closed') {
                        $workingDays--;
                    }

                }

                if ($request['cl_type'] == 'half') {
                    $workingDays = $workingDays / 2;
                }
            } else {

                $diff = $endDate - $startDate;

                $workingDays = abs(round($diff / 86400)) + 1;

                foreach ($holidays as $key => $holiday) {
                    $time_stamp = strtotime($holiday);
                    $hol_type   = $request['holiday']['holiday_type'][$key];
                    //If the holiday doesn't fall in weekend
                    if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N", $time_stamp) != 6 && date("N", $time_stamp) != 7 && $hol_type == 'closed') {
                        $workingDays--;
                    }

                }
            }
            echo json_encode($workingDays);
        } else {
            return redirect('/');
        }
    }

    public function saveApplyLeaveData(Request $request)
    {
        if (! empty(Session::get('admin'))) {

            // dd($request);
            $emp_code = Session('admin')->employee_id;

            $report_auth = Employee::where('emp_code', $emp_code)->first();

            $report_auth_name = $report_auth->emp_reporting_auth;

            $report_auth_email = '';

            if ($report_auth_name != '') {
                $sanc_auth = Employee::join('users', 'users.employee_id', '=', 'employees.emp_code')
                    ->select('employees.*', 'users.email')
                    ->where('emp_code', $report_auth_name)
                    ->first();

                $report_auth_email = $sanc_auth->email;
            }
            // dd($report_auth_name);
            // $lv_sanc_auth = $report_auth->emp_lv_sanc_auth;
            // $sanc_auth = Employee::where('emp_code', $report_auth_name)->first();

            // $sanc_auth_name = $sanc_auth->emp_reporting_auth;

            //dd($report_auth_name);

            $validator = Validator::make(
                $request->all(),
                [
                    'leave_type'   => 'required',
                    'from_date'    => 'required',
                    'to_date'      => 'required',
                    'leave_inhand' => 'required',
                    'days'         => 'required',
                ],
                [
                    'leave_type.required'   => 'Leave Type Required',
                    'from_date.required'    => 'From Date Required',
                    'to_date.required'      => 'To Date Required',
                    'leave_inhand.required' => 'Leave In Hand required',
                    'days.required'         => 'No. of Days Required',
                ]
            );

            if ($validator->fails()) {
                return redirect('employee-corner/apply-leave')->withErrors($validator)->withInput();
            }

            $diff   = abs(strtotime($request->to_date) - strtotime($request->from_date));
            $years  = floor($diff / (365 * 60 * 60 * 24));
            $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
            $days   = (floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24))) + 1;

            if ($request->no_of_leave > $days) {

                Session::flash('error', 'Apply leave More than leave in hand');
                return redirect('leave/apply-leave');
            }

            if ($request->leave_type != '') {
                $leave_type = Leave_type::where('id', '=', $request->leave_type)->first();
            }

            if (! empty($request->doc_image)) {
                $files    = $request->file('doc_image');
                $filename = $files->store('emp_doc_folder');
            } else {

                $filename = "";
            }
            //  $request->leave_inhand;

            if ($request->leave_inhand >= $request->no_of_leave) {
                $data['employee_id']        = $request->employee_id;
                $data['employee_name']      = $request->employee_name;
                $data['emp_reporting_auth'] = $report_auth_name;
                $data['emp_lv_sanc_auth']   = '';
                $data['date_of_apply']      = $request->date_of_apply;
                $data['leave_type']         = $request->leave_type;
                $data['half_cl']            = $request->half_cl;
                $data['from_date']          = $request->from_date;
                $data['to_date']            = $request->to_date;
                $data['no_of_leave']        = $request->days;
                $data['status']             = "NOT APPROVED";
                $data['doc_image']          = $filename;
                //dd($data);
                //print_r($data);
                $leave_apply = new Leave_apply();
                $leave_apply->create($data);

                //Mail to reporting officer
                if ($report_auth_email != '') {

                    $message = $request->employee_name . " (" . $report_auth->old_emp_code . ") has applied for " . $leave_type->leave_type_name . " on dated " . date('d/m/Y', strtotime($request->date_of_apply)) . " for the period of " . date('d/m/Y', strtotime($request->from_date)) . " to " . date('d/m/Y', strtotime($request->to_date)) . ". Please take necessary action";

                    $subject = "Leave Application for approval";

                    $data = [
                        'to_salutation' => 'Dear Sir/Madam',
                        'body_content'  => $message,
                    ];

                    $toemail = $report_auth_email;
                    Mail::send('mailcommon', $data, function ($message) use ($toemail, $subject) {
                        $message->to($toemail, 'Qolaris Data')->subject
                            ($subject);
                        $message->from('info@qolarisdata.com', 'Qolaris Data');
                    });

                    // Always set content-type when sending HTML email
                    // $headers = "MIME-Version: 1.0" . "\r\n";
                    // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                    // // More headers
                    // $headers .= 'From: <info@qolarisdata.com>' . "\r\n";

                    // $to = $report_auth_email;
                    // $subject = "Leave Application for approval";
                    // $message = $request->employee_name . " (" . $report_auth->old_emp_code . ") has applied for " . $request->leave_type . " on dated " . $request->date_of_apply . " for the period of " . $request->from_date . " to " . $request->to_date . ". Please take necessary action";

                    // mail($to, $subject, $message, $headers);

                }

                Session::flash('message', 'Leave Apply Successfully..!.');
                return redirect('employee-corner/dashboard');
            } else {
                Session::flash('error', 'Sorry, No Leave Available');
                return redirect('employee-corner/apply-leave');
            }
        } else {
            return redirect('/');
        }
    }

    public function leaveTypeID($id_leave_type)
    {
        if (! empty(Session::get('admin'))) {

            $empid       = Session('admin')->employee_id;
            $leaveinhand = Leave_allocation::where('leave_type_id', '=', $id_leave_type)
                ->where('employee_code', '=', $empid)
                ->where('month_yr', 'like', '%' . date('Y') . '%')
                ->orderBy('id', 'DESC')
                ->first();

            if (! empty($leaveinhand)) {
                if ($leaveinhand->leave_in_hand > 0) {

                    echo $leaveinhand->leave_in_hand;
                } else {
                    echo '0';
                }
            } else {
                echo '0';
            }
            // if ($id_leave_type != '5') {
            //     $leaveinhand = Leave_allocation::where('leave_type_id', '=', $id_leave_type)
            //         ->where('employee_code', '=', $empid)
            //         ->where('month_yr', 'like', '%' . date('Y') . '%')
            //         ->orderBy('id', 'DESC')
            //         ->first();

            //     if (!empty($leaveinhand)) {
            //         if ($leaveinhand->leave_in_hand > 0) {

            //             echo $leaveinhand->leave_in_hand;
            //         } else {
            //             echo '0';
            //         }
            //     } else {
            //         echo '0';
            //     }
            // } else {
            //     $leaveinhand = Leave_allocation::where('leave_type_id', '=', '3')
            //         ->where('employee_code', '=', $empid)
            //         ->where('month_yr', 'like', '%' . date('Y') . '%')
            //         ->orderBy('id', 'DESC')
            //         ->first();

            //     if (!empty($leaveinhand)) {
            //         if ($leaveinhand->leave_in_hand > 0) {

            //             echo $leaveinhand->leave_in_hand;
            //         } else {
            //             echo '0';
            //         }
            //     } else {
            //         echo '0';
            //     }
            // }
        } else {
            return redirect('/');
        }
    }
}
