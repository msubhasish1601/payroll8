<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Company;
use App\Grade;
use App\Department;
use App\PayrollDetails;
use App\EmployeePayStructure;
use App\EmployeeGradeWiseAllowance;
use App\Models\Employee\Emp_actual_paystructure;
use App\Models\Masters\Role_authorization;
use App\Models\Role\Employee;
use Illuminate\Http\Request;
use View;
use Validator;
use Session;
use App\ProcessAttendance;
use Auth;



class PayStructureController extends Controller
{

    public function viewPayStructureDashboard()
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');

            $Roledata = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $pay_structures = Emp_actual_paystructure::select('*')->get();

            return view('employee/pay-structure-dashboard', compact('pay_structures', 'Roledata'));
        } else {
            return redirect('/');
        }
    }

    public function savePaystructure(Request $request)
    {

        if (!empty(Session::get('admin'))) {

            $data['emp_code'] = $request->emp_code;
            $data['emp_name'] = $request->emp_name;
            $data['emp_designation'] = $request->emp_designation;
            $data['emp_actual_basic_pay'] = $request->emp_basic_pay;
         $data['emp_actual_da'] = $request->emp_actual_da;
			$data['emp_actual_vda'] = $request->emp_actual_vda;
			$data['emp_actual_hra'] = $request->emp_actual_hra;
			$data['emp_actual_others_alw'] = $request->emp_actual_others_alw;
			$data['emp_actual_tiff_alw'] = $request->emp_actual_tiff_alw;
			$data['emp_actual_conv'] = $request->emp_actual_conv;
			$data['emp_actual_medical'] = $request->emp_actual_medical;
			$data['emp_actual_misc_alw'] = $request->emp_actual_misc_alw;
			$data['emp_actual_over_time'] = $request->emp_actual_over_time;
			$data['emp_actual_bouns'] = $request->emp_actual_bouns;
			$data['emp_actual_leave_inc'] = $request->emp_actual_leave_inc;
				$data['emp_actual_hta'] = $request->emp_actual_hta;
            $data['emp_actual_others_addition'] = $request->emp_actual_others_addition;
            $data['emp_actual_gross_salary'] = $request->emp_actual_gross_salary;
            $data['created_at'] = date("d-m-Y h:i:s");
            $checkDb = Emp_actual_paystructure::where('emp_code', '=', $request->emp_code)->first();
            if (empty($checkDb)) {
                Emp_actual_paystructure::insert($data);
                Session::flash('message', 'Payroll Information Successfully saved.');
            } else {
                Emp_actual_paystructure::where('emp_code', '=', $request->emp_code)->delete();
                Emp_actual_paystructure::insert($data);
                Session::flash('message', 'Payroll Information Successfully saved.');
            }

            return redirect('paystructure-dashboard');
        } else {
            return redirect('/');
        }
    }

    public function getPaystructure()
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();


            //$data['employee']=DB::table('employee')->where('status','=','active') ->orderBy('emp_fname', 'asc')->get();

            $data['employee'] = Employee::where('status', '=', 'active')
                ->where('emp_status', '!=', 'TEMPORARY')
                ->where('emp_status', '!=', 'EX-EMPLOYEE')
                ->orderBy('emp_fname', 'asc')
                ->get();

            //print_r($data['employee']); exit;
            return view('employee/single-paystructure', $data);
        } else {
            return redirect('/');
        }
    }


    public function deletePaystructure($paystructure_id)
    {
        if (!empty(Session::get('admin'))) {

            $result = Emp_actual_paystructure::where('id', $paystructure_id)->delete();
            Session::flash('message', 'Deleted Successfully.');
            return redirect('paystructure-dashboard');
        } else {
            return redirect('/');
        }
    }
}
