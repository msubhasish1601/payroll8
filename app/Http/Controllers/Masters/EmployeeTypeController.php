<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Company;
use App\Models\Masters\Employee_type;
use App\Models\Masters\Role_authorization;
use Illuminate\Http\Request;
use Session;
use Validator;
use View;

class EmployeeTypeController extends Controller
{
    //
    public function addEmployeeType()
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $company_rs = Company::where('company_status', '=', 'active')->select('id', 'company_name')->get();

            $data['company_rs'] = $company_rs;
            return view('masters/employee-type', $data);
        } else {
            return redirect('/');
        }
    }

    public function saveEmployeeType(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $employee_type_name = strtoupper(trim($request->employee_type_name));

            if (is_numeric($employee_type_name) == 1) {
                Session::flash('error', 'Employee Type Should not be numeric.');
                return redirect('masters/vw-employee-type');
            }
            $employee_type = Employee_type::where('employee_type_name', $request->employee_type_name)->first();
            if (!empty($employee_type)) {
                Session::flash('error', 'Employee Type Alredy Exists.');
                return redirect('masters/vw-employee-type');
            }

            $validator = Validator::make(
                $request->all(),
                [
                    'employee_type_name' => 'required|max:255',
                ],
                ['employee_type_name.required' => 'Employee Type Name required']
            );

            if ($validator->fails()) {
                return redirect('masters/employee-type')->withErrors($validator)->withInput();
            }

            //$data=request()->except(['_token']);

            $employee_type = new Employee_type();

            Employee_type::insert(
                ['employee_type_name' => $employee_type_name, 'employee_type_status' => 'Active', 'created_at' => date("Y-m-d H:i:s")]
            );

            Session::flash('message', 'Employee Type Information Successfully saved.');

            return redirect('masters/vw-employee-type');
        } else {
            return redirect('/');
        }
    }

    public function updateEmployeeType(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $employee_type_name = strtoupper(trim($request->employee_type_name));

            if (is_numeric($employee_type_name) == 1) {
                Session::flash('error', 'Employee Type Should not be numeric.');
                return redirect('masters/vw-employee-type');
            }
            $employee_type = Employee_type::where('employee_type_name', $request->employee_type_name)->where('id', '!=', $request->id)->first();
            if (!empty($employee_type)) {
                Session::flash('error', 'Employee Type Alredy Exists.');
                return redirect('masters/vw-employee-type');
            }

            $validator = Validator::make(
                $request->all(),
                [
                    'employee_type_name' => 'required|max:255',
                ],
                ['employee_type_name.required' => 'Employee Type Name required']
            );

            if ($validator->fails()) {
                return redirect('masters/employee-type')->withErrors($validator)->withInput();
            }

            //$data=request()->except(['_token']);

            $employee_type = new Employee_type();

            Employee_type::where('id', $request->id)
                ->update(['employee_type_name' => $employee_type_name]);
            Session::flash('message', 'Employee Type Information Successfully Saved.');
            return redirect('masters/vw-employee-type');
        } else {
            return redirect('/');
        }
    }

    public function getEmployeeTypes()
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $data['employee_type_rs'] = Employee_type::get();

            return view('masters/view-employee-type', $data);
        } else {
            return redirect('/');
        }
    }

    public function getTypeById($id)
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $data['employee_type'] = Employee_type::where('id', $id)->first();
            return view('masters/edit-employee-type', $data);
        } else {
            return redirect('/');
        }
    }
}
