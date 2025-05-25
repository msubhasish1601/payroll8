<?php

namespace App\Http\Controllers\Rota;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Department;
use App\Models\Masters\Designation;
use App\Models\Masters\Employee_type;
use App\Models\Masters\Role_authorization;
use App\Models\Role\Employee;
use App\Models\Rota\Duty_roster;
use App\Models\Rota\Grace_period;
use App\Models\Rota\Late_policy;
use App\Models\Rota\Offday;
use App\Models\Rota\Registration;
use App\Models\Rota\Shift_management;
use DB;
use View;
use Validator;
use Session;

class RotaController extends Controller
{

    public function RotaDashboard()
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            return View('rota/dashboard', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewshift()
    {

        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['employee_type_rs'] =  Shift_management::get();
            return view('rota/shift-list', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewAddNewShift()
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['departs'] = Department::get();

            return view('rota/add-new-shift', $data);
        } else {
            return redirect('/');
        }
    }

    public function ajaxEmpShift($empid)
    {
        $email = Session::get('admin');
        $Roledata = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
            ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
            ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
            ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
            ->where('member_id', '=', $email)
            ->get();

        $desig_rs = Department::where('id', '=',  $empid)->first();

        $employee_rs = Designation::where('department_code', '=',  $desig_rs->id)
            ->get();
        $result = '';
        $result_status1 = "<option value='' selected disabled>Select</option>";
        foreach ($employee_rs as $bank) {
            $result_status1 .= '<option value="' . $bank->id . '">' . $bank->designation_name . '</option>';
        }

        echo $result_status1;
    }

    public function saveShiftData(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $department_name = strtoupper(trim($request->shift_code));
            $email = Session::get('adminusernmae');
            $Roledata = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $ckeck_dept = Shift_management::orderBy('id', 'DESC')->first();
            if (empty($ckeck_dept)) {
                $pid = 'SHIFT-001';
            } else {

                $whatIWant = substr($ckeck_dept->shift_code, strpos($ckeck_dept->shift_code, "-") + 1);
                $pid = 'SHIFT-00' . ($whatIWant + 1);
            }

            $data = array(
                'department' => $request->department,
                'shift_code' => $pid,
                'shift_des' => $request->shift_des,
                'time_in' => $request->time_in,
                'time_out' => $request->time_out,
                'rec_time_in' => $request->rec_time_in,
                'rec_time_out' => $request->rec_time_out,
                'designation' => $request->designation

            );

            Shift_management::insert($data);
            Session::flash('message', 'Shift Information Successfully Saved.');

            return redirect('rota/shift-management');
        } else {
            return redirect('/');
        }
    }

    public function editShift($id)
    {

        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['departs'] = Department::get();

            $dt = Shift_management::where('id', '=', $id)->first();
            if (!empty($dt)) {
                $data['shift_management'] = Shift_management::where('id', '=', $id)->first();
                $data['desig'] = Designation::where('id', '=', $data['shift_management']->designation)->get();
                return view('rota/edit-shift', $data);
            } else {
                return redirect('rota/shift-management');
            }
        } else {
            return redirect('/');
        }
    }

    public function updateShiftData(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $department_name = strtoupper(trim($request->shift_code));
            $email = Session::get('adminusernmae');
            $Roledata = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data = array(
                'department' => $request->department,
                'shift_des' => $request->shift_des,
                'time_in' => $request->time_in,
                'time_out' => $request->time_out,
                'rec_time_in' => $request->rec_time_in,
                'rec_time_out' => $request->rec_time_out,
                'designation' => $request->designation,
            );
            // print_r($request->id);
            // die();
            $dataInsert = Shift_management::where('id', $request->id)
                ->update($data);
            Session::flash('message', 'Shift Information Successfully Updated.');
            return redirect('rota/shift-management');
        } else {
            return redirect('/');
        }
    }

    public function viewlate()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['employee_type_rs'] =  Late_policy::leftJoin('designations', 'late_policies.designation', '=', 'designations.id')
                ->leftJoin('departments', 'late_policies.department', '=', 'departments.id')
                ->leftJoin('shift_managements', 'late_policies.shift_code', '=', 'shift_managements.id')
                ->select('late_policies.*', 'designations.designation_name', 'departments.department_name', 'shift_managements.shift_code')
                ->get();

            return view('rota/late-list', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewAddNewlate()
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['departs'] = Department::get();

            return view('rota/add-new-late', $data);
        } else {
            return redirect('/');
        }
    }

    public function ajaxEmpShiftLate($empid)
    {
        $email = Session::get('adminusernmae');
        $Roledata = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
            ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
            ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
            ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
            ->where('member_id', '=', $email)
            ->get();



        $employee_rs = Shift_management::where('designation', '=',  $empid)->get();

        $result = '';
        $result_status1 = "<option value='' selected disabled> Select</option>";
        foreach ($employee_rs as $bank) {
            $result_status1 .= '<option value="' . $bank->id . '">' . $bank->shift_code . '</option>';
        }

        echo $result_status1;
    }

    public function savelateData(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $Roledata = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data = array(
                'department' => $request->department,
                'shift_code' => $request->shift_code,
                'max_grace' => $request->max_grace,
                'no_allow' => $request->no_allow,
                'no_day_red' => $request->no_day_red,
                'designation' => $request->designation

            );


            Late_policy::insert($data);
            Session::flash('message', 'Late Policy Information Successfully Saved.');

            return redirect('rota/late-policy');
        } else {
            return redirect('/');
        }
    }

    public function editlate($id)
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['departs'] = Department::get();

            $dt = Late_policy::where('id', '=', $id)->first();
            if (!empty($dt)) {
                $data['shift_management'] = Late_policy::where('id', '=', $id)->first();
                $data['desig'] = Designation::where('id', '=', $data['shift_management']->designation)->get();
                $data['shiftc'] = Shift_management::where('id', '=', $data['shift_management']->shift_code)->get();
                return view('rota/edit-late', $data);
            } else {
                return redirect('rota/late-policy');
            }
        } else {
            return redirect('/');
        }
    }

    public function updatelateData(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $Roledata = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();


            $data = array(
                'department' => $request->department,
                'shift_code' => $request->shift_code,
                'max_grace' => $request->max_grace,
                'no_allow' => $request->no_allow,
                'no_day_red' => $request->no_day_red,
                'designation' => $request->designation
            );

            $dataInsert = Late_policy::where('id', $request->id)
                ->update($data);

            Session::flash('message', 'Late Policy Information Successfully Updated.');
            return redirect('rota/late-policy');
        } else {
            return redirect('/');
        }
    }


    public function viewoffday()
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();


            // $data['employee_type_rs'] =  Offday::get();

            $data['employee_type_rs'] =  Offday::leftJoin('designations', 'offdays.designation', '=', 'designations.id')
                ->leftJoin('departments', 'offdays.department', '=', 'departments.id')
                ->select('offdays.*', 'designations.designation_name', 'departments.department_name')
                ->get();

            return view('rota/offday-list', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewAddNewoffday()
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['departs'] = Department::get();


            return view('rota/add-new-offday', $data);
        } else {
            return redirect('/');
        }
    }

    public function editoffday($id)
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['departs'] = Department::get();

            $dt = Offday::where('id', '=', $id)->first();
            if (!empty($dt)) {
                $data['shift_management'] = Offday::where('id', '=', $id)->first();
                $data['desig'] = Designation::where('id', '=', $data['shift_management']->designation)->get();
                $data['shiftc'] = Shift_management::where('id', '=', $data['shift_management']->shift_code)->get();
                return view('rota/edit-offday', $data);
            } else {
                return redirect('rota/offday');
            }
        } else {
            return redirect('/');
        }
    }

    public function saveoffdayData(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $Roledata = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();


            $data = array(
                'department' => $request->department,
                'shift_code' => $request->shift_code,
                'sun' => $request->sun,
                'mon' => $request->mon,
                'tue' => $request->tue,
                'wed' => $request->wed,
                'thu' => $request->thu,
                'fri' => $request->fri,
                'sat' => $request->sat,
                'designation' => $request->designation

            );
            // print_r($data);
            // die();
            $offday = Offday::insert($data);
            Session::flash('message', 'Offday Information Successfully Saved.');

            return redirect('rota/offday');
        } else {
            return redirect('/');
        }
    }

    public function updateoffdayData(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $Roledata = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();


            $data = array(
                'department' => $request->department,
                'shift_code' => $request->shift_code,
                'sun' => $request->sun,
                'mon' => $request->mon,
                'tue' => $request->tue,
                'wed' => $request->wed,
                'thu' => $request->thu,
                'fri' => $request->fri,
                'sat' => $request->sat,
                'designation' => $request->designation
            );

            $dataInsert = Offday::where('id', $request->id)
                ->update($data);
            Session::flash('message', 'Offday Information Successfully Updated.');
            return redirect('rota/offday');
        } else {
            return redirect('/');
        }
    }

    public function viewgrace()
    {

        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            // $data['employee_type_rs'] =  Grace_period::get();

            $data['employee_type_rs'] =  Grace_period::leftJoin('designations', 'grace_periods.designation', '=', 'designations.id')
                ->leftJoin('departments', 'grace_periods.department', '=', 'departments.id')
                ->leftJoin('shift_managements', 'grace_periods.shift_code', '=', 'shift_managements.id')
                ->select('grace_periods.*', 'designations.designation_name', 'departments.department_name', 'shift_managements.shift_code')
                ->get();

            return view('rota/grace-period-list', $data);
        } else {
            return redirect('/');
        }
    }


    public function viewAddNewgrace()
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();


            $data['departs'] = Department::get();


            return view('rota/add-new-grace-period', $data);
        } else {
            return redirect('/');
        }
    }

    public function editGrace($id)
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();


            $data['departs'] = Department::get();
            $dt = Grace_period::where('id', '=', $id)->first();
            if (!empty($dt)) {
                $data['shift_management'] = Grace_period::where('id', '=', $id)->first();
                $data['desig'] = Designation::where('id', '=', $data['shift_management']->designation)->get();
                $data['shiftc'] = Shift_management::where('id', '=', $data['shift_management']->shift_code)->get();
                return view('rota/edit-grace-period', $data);
            } else {
                return redirect('rota/grace-period');
            }
        } else {
            return redirect('/');
        }
    }


    public function savegraceData(Request $request)
    {
        if (!empty(Session::get('admin'))) {


            $email = Session::get('adminusernmae');
            $Roledata = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();


            $data = array(
                'department' => $request->department,
                'shift_code' => $request->shift_code,
                'time_in' => $request->time_in,
                'grace_time' => $request->grace_time,
                'designation' => $request->designation

            );

            $grace = Grace_period::insert($data);
            Session::flash('message', 'Grace Period Information Successfully Saved.');

            return redirect('rota/grace-period');
        } else {
            return redirect('/');
        }
    }

    public function updategraceData(Request $request)
    {
        if (!empty(Session::get('admin'))) {


            $email = Session::get('adminusernmae');
            $Roledata = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();


            $data = array(
                'department' => $request->department,
                'shift_code' => $request->shift_code,
                'time_in' => $request->time_in,
                'grace_time' => $request->grace_time,
                'designation' => $request->designation
            );

            $dataInsert = Grace_period::where('id', $request->id)
                ->update($data);
            Session::flash('message', 'Grace Period Information Successfully Updated.');
            return redirect('rota/grace-period');
        } else {
            return redirect('/');
        }
    }



    public function viewroster()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['departs'] = Department::get();

            return view('rota/roster-list', $data);
        } else {
            return redirect('/');
        }
    }

    public function ajaxEmpCode($empid)
    {

        $email = Session::get('adminusernmae');
        $Roledata = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
            ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
            ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
            ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
            ->where('member_id', '=', $email)
            ->get();

        $employee_desigrs = Designation::where('id', '=',  $empid)
            ->first();
        $employee_depers = Department::where('id', '=',  $employee_desigrs->department_code)
            ->first();
        $employee_rs = Employee::where('emp_designation', '=',  $employee_desigrs->designation_name)
            ->where('emp_department', '=',  $employee_depers->department_name)
            ->get();
        $result = '';
        $result_status1 = "  <option value=''>Select</option>
       <option value=''>All</option>";
        foreach ($employee_rs as $bank) {
            $result_status1 .= '<option value="' . $bank->emp_code . '"';
            if (isset($employee_code) && $employee_code == $bank->emp_code) {
                $result_status1 .= 'selected';
            }
            $result_status1 .= '> ' . $bank->emp_fname . ' ' . $bank->emp_mname . ' ' . $bank->emp_lname . ' (' . $bank->emp_code . ')</option>';
        }

        echo $result_status1;
    }

    public function saverosterData(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();


            $employee_code = $request->employee_code;
            $department = $request->department;
            $designation = $request->designation;

            $employee_desigrs = Designation::where('id', '=',  $designation)
                ->first();
            $employee_depers = Department::where('id', '=',  $department)
                ->first();
            $date = date('Y-m-d', strtotime($request->date));

            $data['result'] = '';
            if ($employee_code != '') {



                $leave_allocation_rs = Duty_roster::leftJoin('employees', 'duty_rosters.employee_id', '=', 'employees.emp_code')
                    ->where('duty_rosters.employee_id', '=', $employee_code)
                    ->where('employees.emp_code', '=', $employee_code)
                    ->where('employees.emp_designation', '=', $employee_desigrs->designation_name)
                    ->where('employees.emp_department', '=', $employee_depers->department_name)
                    ->where('duty_rosters.start_date', '>=', date('Y-m-d', strtotime($request->start_date)))
                    ->where('duty_rosters.end_date', '<=', date('Y-m-d', strtotime($request->end_date)))
                    ->select('duty_rosters.*')
                    ->get();
            } else {
                $leave_allocation_rs = Duty_roster::leftJoin('employees', 'duty_rosters.employee_id', '=', 'employees.emp_code')
                    ->where('employees.emp_designation', '=', $employee_desigrs->designation_name)
                    ->where('employees.emp_department', '=', $employee_depers->department_name)
                    ->where('duty_rosters.start_date', '>=', date('Y-m-d', strtotime($request->start_date)))
                    ->where('duty_rosters.end_date', '<=', date('Y-m-d', strtotime($request->end_date)))
                    ->select('duty_rosters.*')
                    ->get();
            }
            //dd($leave_allocation_rs);
            if ($leave_allocation_rs) {
                $f = 1;
                foreach ($leave_allocation_rs as $leave_allocation) {

                    $employee_shift = Shift_management::where('id', '=',  $leave_allocation->shift_code)

                        ->first();
                    $employee_shift_emp = Employee::where('emp_code', '=',  $leave_allocation->employee_id)
                        ->first();
                    $data['result'] .= '<tr>
				<td>' . $f . '</td>
				<td>' . $employee_depers->department_name . '</td>
				<td>' . $employee_desigrs->designation_name . '</td>
													<td>' . $employee_shift_emp->emp_fname . '  ' . $employee_shift_emp->emp_mname . '  ' . $employee_shift_emp->emp_lname . ' (' . $leave_allocation->employee_id . ')</td>
														<td>' . $employee_shift->shift_code . '</td>
													
													
													<td>' . date('h:i a', strtotime($employee_shift->time_in)) . '</td>
													<td>' . date('h:i a', strtotime($employee_shift->time_out)) . '</td>
													<td>' . date('h:i a', strtotime($employee_shift->rec_time_in)) . '</td>
													<td>' . date('h:i a', strtotime($employee_shift->rec_time_out)) . '</td>
														<td>' . date('d/m/Y', strtotime($leave_allocation->start_date)) . '</td>
															<td>' . date('d/m/Y', strtotime($leave_allocation->end_date)) . '</td>
													
													
							
						</tr>';
                    $f++;
                }
            }
            $data['employee_type_rs'] =  Employee_type::where('employee_type_status', '=', 'Active')->get();
            $data['departs'] = Department::get();

            $data['employee_code'] = $request->employee_code;
            $data['department'] = $request->department;
            $data['designation'] = $request->designation;
            $data['designation'] = $request->designation;
            $data['start_date'] = date('Y-m-d', strtotime($request->start_date));

            $data['end_date'] = date('Y-m-d', strtotime($request->end_date));
            // print_r($data['result']);
            // die();
            return view('rota/roster-list', $data);
        } else {
            return redirect('/');
        }
    }


    public function viewAddNewemployeeduty()


    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['departs'] = Department::get();

            return view('rota/add-new-employee-roster', $data);
        } else {
            return redirect('/');
        }
    }


    public function saveemployeedutyData(Request $request)
    {
        if (!empty(Session::get('admin'))) {


            $email = Session::get('adminusernmae');
            $Roledata = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $department = $request->department;
            $designation = $request->designation;

            $employee_desigrs = Designation::where('id', '=',  $designation)
                ->first();
            $employee_depers = Department::where('id', '=',  $department)
                ->first();
            $employee_duty_ros = Duty_roster::where('department', '=',  $department)
                ->where('designation', '=',  $designation)
                ->where('employee_id', '=',  $request->employee_id)
                ->where('end_date', '>=', date('Y-m-d', strtotime($request->start_date)))
                ->first();
 
            if (!empty($employee_duty_ros)) {
                Session::flash('message', 'Employee Id  Already Exists For This time Period .');
                return redirect('rota/duty-roster');
            } else {
                $data = array(
                    'department' => $request->department,
                    'shift_code' => $request->shift_code,
                    'employee_id' => $request->employee_id,
                    'start_date' => date('Y-m-d', strtotime($request->start_date)),
                    'end_date' => date('Y-m-d', strtotime($request->end_date)),
                    'designation' => $request->designation

                );


                Duty_roster::insert($data);
                Session::flash('message', 'Duty Roster Of Employee Information Successfully Saved.');
                return redirect('rota/duty-roster');
            }
        } else {
            return redirect('/');
        }
    }

    public function viewAddNewdepartmentduty()
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['departs'] = Department::get();

            return view('rota/add-new-department-roster', $data);
        } else {
            return redirect('/');
        }
    }

    public function savedepartmentdutyData(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $Roledata = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $department = $request->department;
            $designation = $request->designation;

            $employee_desigrs = Designation::where('id', '=',  $designation)
                ->first();
            $employee_depers = Department::where('id', '=',  $department)
                ->first();
            $employee_duty_ros = Duty_roster::where('department', '=',  $department)
                ->where('designation', '=',  $designation)
                ->where('end_date', '>=', date('Y-m-d', strtotime($request->start_date)))
                ->get();
            $emp_dury = array();
            if ($employee_duty_ros) {
                foreach ($employee_duty_ros as $employee_duty) {
                    $emp_dury[] = $employee_duty->employee_id;
                }
            }


            $leave_allocation_rs = Employee::where('employees.emp_designation', '=', $employee_desigrs->designation_name)
                ->where('employees.emp_department', '=', $employee_depers->department_name)
                ->get();
            // print_r($leave_allocation_rs);
            // die();
            if (empty($leave_allocation_rs)) {
                $newid = 1;
                $newnid = 1;

                foreach ($leave_allocation_rs as $leave_allocation) {

                    if (in_array($leave_allocation->emp_code, $emp_dury)) {

                        $newid++;
                    } else {

                        $newnid++;
                        $data = array(
                            'department' => $request->department,
                            'shift_code' => $request->shift_code,
                            'employee_id' => $leave_allocation->emp_code,
                            'start_date' => date('Y-m-d', strtotime($request->start_date)),
                            'end_date' => date('Y-m-d', strtotime($request->end_date)),
                            'designation' => $request->designation

                        );

                        $ckeck_dept = Duty_roster::where('department', $request->department)->where('designation', $request->designation)->where('employee_id', $leave_allocation->emp_code)
                            ->where('end_date', '>=', date('Y-m-d', strtotime($request->start_date)))
                            ->first();
                        if (!empty($ckeck_dept)) {
                        } else {

                            Duty_roster::insert($data);
                        }
                    }
                }
            } else {
                Session::flash('message', 'No Employee Found.');
                return redirect('rota/duty-roster');
            }

            if ($newnid > 1) {
                Session::flash('message', 'Duty Roster Information Successfully Saved.');
                return redirect('rota/duty-roster');
            }
            if ($newid > 1) {
                Session::flash('message', 'Department  Already Exists.  For This time Period .');
                return redirect('rota/duty-roster');
            }
        } else {
            return redirect('/');
        }
    }

    public function ajaxEmpShiftCode($empid)
    {
        $email = Session::get('admin');
        $email = Session::get('adminusernmae');
        $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
            ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
            ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
            ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
            ->where('member_id', '=', $email)
            ->get();



        $employee_rs = Shift_management::where('designation', '=',  $empid)
            ->get();



            $result = '';
        $result_status1 = "  <option value=''>Select</option>
       ";
        foreach ($employee_rs as $bank) {
            $result_status1 .= '<option value="'.$bank->id.'"';
            if (isset($shift_code) && $shift_code == $bank->shift_code) {
                $result_status1 .= 'selected';
            }
            $result_status1 .= '> '.$bank->shift_code.' </option>';
        }


        // $result = '';
        // $result_status1 = "";
        // $du = 1;
        // foreach ($employee_rs as $bank) {
        //     if ($du == '1') {
        //         $chedu = 'checked';
        //     } else {
        //         $chedu = '';
        //     }
        //     $result_status1 .= '
            
		// 			<option value="">Select</option>
		// 			<option value="' . $bank->id . '">' . $chedu . '</option>
			
        //     ';
        //     $du++;
        // }

        echo $result_status1;
    }


    public function ajaxRotaEmp($empid)
    {
        $email = Session::get('adminusernmae');
        $Roledata = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
            ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
            ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
            ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
            ->where('member_id', '=', $email)
            ->get();

        $employee_desigrs = Designation::where('id', '=',  $empid)
            ->first();
        $employee_depers = Department::where('id', '=',  $employee_desigrs->department_code)
            ->first();
        $employee_rs = Employee::where('emp_designation', '=',  $employee_desigrs->designation_name)
            ->where('emp_department', '=',  $employee_depers->department_name)
            ->get();
        $result = '';
        $result_status1 = "  <option value=''>Select</option>
       ";
        foreach ($employee_rs as $bank) {
            $result_status1 .= '<option value="' . $bank->emp_code . '"';
            if (isset($employee_code) && $employee_code == $bank->emp_code) {
                $result_status1 .= 'selected';
            }
            $result_status1 .= '> ' . $bank->emp_fname . ' ' . $bank->emp_mname . ' ' . $bank->emp_lname . ' (' . $bank->emp_code . ')</option>';
        }

        echo $result_status1;
    }
}
