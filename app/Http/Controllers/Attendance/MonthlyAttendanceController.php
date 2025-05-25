<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Models\Attendance\Process_attendance;
use App\Models\Attendance\Upload_attendence;
use App\Models\Masters\Role_authorization;
use Illuminate\Http\Request;
use Session;
use View;

class MonthlyAttendanceController extends Controller
{
    public function viewMonthlyAttendance()
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
            return view('attendance/emp-monthly-attendance', $data);
        } else {
            return redirect('/');
        }
    }

    public function getMonthlyAttandance(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $count = Upload_attendence::where('month_yr', '=', $request['month_yr'])->distinct()->get(['employee_code']);

            $data['upload_record_rs'] = $count->count();

            $data['monthlist'] = Upload_attendence::select('month_yr')->distinct('month_yr')->get();
            $data['month_yr_new'] = $request['month_yr'];
            return view('attendance/emp-monthly-attendance', $data);

        } else {
            return redirect('/');
        }
    }

    public function deleteMonthlyAttandance()
    {
        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            $month = request()->get('month');
            $month = urldecode(base64_decode($month));

            $check_process_table = Process_attendance::where('month_yr', '=', $month)->first();
            if (empty($check_process_table)) {
                $check_process_table = Upload_attendence::where('month_yr', '=', $month)->delete();
                Session::flash('message', 'Attendance Process Information Successfully Deleted.');

            } else {

                Session::flash('error', 'You Can Not process this operation.');
            }

            $month = request()->get('month');
            $processmonth = urldecode(base64_decode($month));

            $check_process_table = Process_attendance::where('month_yr', '=', $processmonth)->first();
            if (empty($check_process_table)) {
                $check_process_table = Upload_attendence::where('month_yr', '=', $processmonth)->delete();
                Session::flash('message', 'Attendance Process Information Successfully Deleted.');

            } else {

                Session::flash('error', 'You Can Not process this operation.');
            }

            return redirect('attendance/monthly-attendance');
        } else {
            return redirect('/');
        }

    }

}
