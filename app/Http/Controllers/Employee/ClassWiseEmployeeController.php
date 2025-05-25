<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Bank_master;
use App\Models\Masters\Group_name_detail;
use App\Models\Masters\Role_authorization;
use App\Models\Payroll\Payroll_detail;
use Validator;
use Session;
use View;
use NumberToWords\NumberToWords;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Crypt;
use Auth;

class ClassWiseEmployeeController extends Controller
{
    //
    public function getClassWiseEmployee()
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

            $data['class_name'] = Group_name_detail::where('status', '=', 'active')->get();
            $Payroll_details_rs = '';
            return view('employee/classwise-employee', $data);
        } else {
            return redirect('/');
        }
    }


    public function showClassWiseEmployee(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

                $data['class_name'] = Group_name_detail::where('status', '=', 'active')->get();

                $data['classwise_emp'] = Group_name_detail::leftJoin('employees', 'employees.emp_group_name', '=', 'group_name_details.id')
                ->select('employees.*', 'group_name_details.*')
                ->where('employees.emp_group_name', '=', $request->class_name_new)
                ->get();
                
                
            if (count($data['classwise_emp']) != 0) {
                return view('employee/classwise-emp-report', $data);
            } else {

                Session::flash('error', 'Data not found');
                return view('employee/classwise-employee', $data);
            }
        } else {
            return redirect('/');
        }
    }
}
