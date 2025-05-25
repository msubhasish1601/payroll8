<?php

namespace App;

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Department;
use App\Models\Masters\Designation;
use App\Models\Masters\Role_authorization;
use Illuminate\Http\Request;
use Session;
use Validator;
use View;

class DesignationController extends Controller
{
    //
    public function addDesignation()
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $data['department'] = Department::where('department_status', '=', 'active')->get();
            return view('masters/designation', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewAddDesignation($id)
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            if ($id != '') {
                $data['designation'] = Designation::leftJoin('departments', 'designations.department_code', '=', 'departments.id')
                    ->where('designations.id', '=', $id)
                    ->select('designations.*', 'departments.department_name')
                    ->first();
                //print_r($data['designation']); exit;
                //$data['designation']=Designation::where('id','=',Input::get('id'))->get();
                $data['department'] = Department::where('department_status', '=', 'active')->get();
                return view('masters/edit-designation', $data);
            } else {
                $data['department'] = Department::where('department_status', '=', 'active')->get();
                return view('masters/designation', $data);
            }
        } else {
            return redirect('/');
        }
    }

    public function saveDesignation(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            //print_r($request->all()); exit;

            $dept_code = $request['department_code'];
            $designation_name = strtoupper(trim($request['designation_name']));

            if (is_numeric($designation_name) == 1) {
                Session::flash('error', 'Designation Should not be numeric.');
                return redirect('masters/vw-designation');
            }

            $check_designation = Designation::where('designation_name', $request->designation_name)->where('department_code', '=', $dept_code)->first();
            if (!empty($check_designation)) {
                Session::flash('message', 'Designation Alredy Exists.');

                return redirect('masters/vw-designation');
            }

            $validator = Validator::make(
                $request->all(),
                [
                    'department_code' => 'required',
                    // 'designation_code'=>'required|unique:designation,designation_code',
                    'designation_name' => 'required|max:255',
                ],
                [
                    'department_code.required' => 'Please Select Department',
                    //'designation_code.required'=>'Designation Code Required',
                    'designation_name.required' => 'Designation Name Required',
                    //'designation_code.unique'=>'Designation Code Already Exist'
                ]
            );

            if ($validator->fails()) {
                return redirect('masters/designation')->withErrors($validator)->withInput();
            } else {

                //$data=request()->except(['_token'])+['designation_status' => 'active'];
                $data = array(
                    'department_code' => $dept_code,
                    'designation_name' => $designation_name,
                    'created_at' => date('Y-m-d h:i:s'),
                    'designation_status' => 'active',
                );

                $designation = new Designation();
                $desigdb = Designation::where('designation_name', '=', $designation_name)->where('designation_status', '=', 'active')->where('department_code', '=', $dept_code)->first();

                if (empty($desigdb)) {
                    $designation->create($data);
                    Session::flash('message', 'Designation Information Successfully saved.');
                } else {
                    Session::flash('error', 'Designation Information Already Exist.');
                }
                return redirect('masters/vw-designation');
            }
        } else {
            return redirect('/');
        }
    }

    public function updateDesignation(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            //print_r($request->all()); exit;

            $dept_code = $request['department_code'];
            $designation_name = strtoupper(trim($request['designation_name']));

            if (is_numeric($designation_name) == 1) {
                Session::flash('error', 'Designation Should not be numeric.');
                return redirect('masters/vw-designation');
            }

            // $check_designation = Designation::where('designation_name', $request->designation_name)->first();
            // if (!empty($check_designation)) {
            //     Session::flash('message', 'Alredy Exists.');
            //     return redirect('masters/vw-designation');
            // }

            $validator = Validator::make(
                $request->all(),
                [
                    'department_code' => 'required',
                    // 'designation_code'=>'required|unique:designation,designation_code',
                    'designation_name' => 'required|max:255',
                ],
                [
                    'department_code.required' => 'Please Select Department',
                    //'designation_code.required'=>'Designation Code Required',
                    'designation_name.required' => 'Designation Name Required',
                    //'designation_code.unique'=>'Designation Code Already Exist'
                ]
            );

            if ($validator->fails()) {
                return redirect('masters/designation')->withErrors($validator)->withInput();
            } else {

                $data = array(
                    'department_code' => $dept_code,
                    'designation_name' => $designation_name,
                    'updated_at' => date('Y-m-d h:i:s'),
                    'designation_status' => $request['des_status'],
                );
                Designation::where('id', $request['id'])->update($data);
                Session::flash('message', 'Designation Information Successfully Updated.');
                return redirect('masters/vw-designation');
            }
        } else {
            return redirect('/');
        }
    }

    public function getDesignations()
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $data['designation_rs'] = Designation::leftJoin('departments', 'designations.department_code', '=', 'departments.id')
                ->where('designations.designation_status', '=', 'active')
                ->select('designations.*', 'departments.department_name')
                ->get();
            return view('masters/view-designation', $data);
        } else {
            return redirect('/');
        }
    }
}
