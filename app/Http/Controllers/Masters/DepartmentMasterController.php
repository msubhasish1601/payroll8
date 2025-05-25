<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Department;
use App\Models\Masters\Role_authorization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;
use Validator;
use View;

class DepartmentMasterController extends Controller
{

    public function getDepartment()
    {
        if (!empty(Session::get('admin'))) {

            // if (Input::get('del')) {
            //     $dataUpdate = Department::where('id', Input::get('del'))
            //         ->update(['department_status' => 'Trash']);
            //     return back()->with('delete', 'Department Information Successfully Deleted.');
            // } else {
            //     $department_rs = Department::where('department_status', '=', 'active')->get();
            //     return view('masters/department-master', compact('department_rs'));
            // }
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $department_rs = Department::where('department_status', '=', 'active')->get();
            $data['department_rs'] = $department_rs;
            return view('masters/department-master', $data);
        } else {
            return redirect('/');
        }
    }

    public function addNewDepartment()
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            return view('masters/add-new-department', $data);
        } else {
            return redirect('/');
        }
    }

    public function editNewDepartment($id)
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            if ($id != '') {
                $dt = Department::where('id', '=', $id)->where('department_status', '=', 'active')->get();
                if (count($dt) > 0) {
                    $data['departments'] = Department::where('id', '=', $id)->get();

                    return view('masters/edit-new-department', $data);
                } else {
                    return redirect('masters/add-new-department', $data);
                }
            } else {
                return view('masters/add-new-department', $data);
            }
        } else {
            return redirect('/');
        }
    }

    /*public function dept_name_exist($department_name){

    }*/

    public function saveDepartmentData(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $department_name = strtoupper(trim($request->department_name));

            if (is_numeric($department_name) == 1) {
                Session::flash('error', 'Department Should not be numeric.');
                return redirect('masters/vw-department');
            }

            $ckeck_dept = Department::where('department_name', $department_name)->first();
            if (!empty($ckeck_dept)) {
                Session::flash('error', 'Department Already Exists.');
                return redirect('masters/vw-department');
            }

            $validator = Validator::make(
                $request->all(),
                [
                    'department_name' => 'required',
                    //'department_code'=>'required|unique:department'
                ],
                [
                    'department_name.required' => 'Department Name Required',
                    //'department_code.required'=>'Department Code Required',
                    //'department_code.unique'=>'Department Code already exists'
                ]
            );

            if ($validator->fails()) {
                return redirect('masters/add-new-department')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(
                'department_name' => strtoupper($request->input('department_name')),
                'department_code' => $request->input('department_code'),
            );
            $department = new Department();

            $deptnmdb = Department::where('department_name', '=', trim($request->department_name))->where('department_status', '=', 'active')->first();

            if (empty($deptnmdb)) {
                $department->create($data);
                Session::flash('message', 'Department Information Successfully Saved.');
            } else {
                Session::flash('error', 'Department Name Already Exits.');
            }
            return redirect('masters/vw-department');
        } else {
            return redirect('/');
        }
    }

    public function updateDepartmentData(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $department_name = strtoupper(trim($request->department_name));

            if (is_numeric($department_name) == 1) {
                Session::flash('error', 'Department Should not be numeric.');
                return redirect('masters/vw-department');
            }

            $ckeck_dept = Department::where('department_name', $department_name)->where('id', '!=', $request->id)->first();
            if (!empty($ckeck_dept)) {
                Session::flash('error', 'Department Already Exists.');
                return redirect('masters/vw-department');
            }

            $validator = Validator::make(
                $request->all(),
                [
                    'department_name' => 'required',
                ],
                [
                    'department_name.required' => 'Department Name Required',
                    //'department_code.required'=>'Department Code Required',
                ]
            );

            if ($validator->fails()) {
                return redirect('masters/add-new-department')->withErrors($validator)->withInput();
            }

            $data = array(
                'department_name' => $department_name,
                'department_code' => strtoupper($request->input('department_code')),

            );
            //print_r($data); exit;

            $dataInsert = Department::where('id', $request->id)
                ->update($data);
            Session::flash('message', 'Department Information Successfully Updated.');
            return redirect('masters/vw-department');
        } else {
            return redirect('/');
        }
    }
}
