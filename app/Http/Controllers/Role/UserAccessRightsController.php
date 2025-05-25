<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\LeaveManagement\Leave_type;
use App\Models\Masters\Role_authorization;
use App\Models\Role\Employee;
use App\Models\Role\Module;
use App\Models\Role\Module_config;
use App\Models\Role\Sub_module;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use Validator;
use View;

class UserAccessRightsController extends Controller
{
    public function viewdashboard()
    {
        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            return View('role/dashboard', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewUserConfig()
    {
        if (!empty(Session::get('admin'))) {

            $data['users'] = User::where('user_type', '=', 'user')->get();
            return view('role/view-users', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewUserAccessRightsForm()
    {
        if (!empty(Session::get('admin'))) {

            $data['users'] = User::where('user_type', '=', 'user')->get();
            $data['module'] = Module::where('status', '=', 'Yes')->get();
            $data['menu'] = Module_config::get();
            // dd($data);
            return view('role/role', $data);
        } else {
            return redirect('/');
        }
    }

    public function userWiseAccessList($usermailid, $module_name, $sub_module_name, $menu_name, $rights)
    {

        if (!empty(Session::get('admin'))) {

            //echo $usermailid; echo "--"; echo $module_name; echo "=="; echo $sub_module_name; echo "++"; echo $menu_name; echo "@@"; echo $rights;

            $useraccessdtl = Role_authorization::select('role_authorizations.*')
                ->where('role_authorizations.member_id', '=', $usermailid)
                ->where('role_authorizations.module_name', '=', $module_name)
                ->where('role_authorizations.sub_module_name', '=', $sub_module_name)
                ->where('role_authorizations.menu', '=', $menu_name)
                ->where('role_authorizations.rights', '=', $rights)
                ->first();
            //->toSql();
            //echo $data['useraccessdtl'];
            //exit;
            return $useraccessdtl;
        } else {
            return redirect('/');
        }
    }

    public function UserAccessRightsFormAuth(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            // $user_access_data = DB::table('role_authorization')->get();

            //$check_user_access = $this->userWiseAccessList($request['member_id'][0]);

            foreach ($request['menu_name'] as $key => $value) {
                $ins_data['menu'] = $request['menu_name'][$key];
                $ins_data['member_id'] = $request['member_id'][0];
                $ins_data['module_name'] = $request['module_name'];
                $ins_data['sub_module_name'] = $request['sub_module_name'];

                foreach ($request['user_rights_name'] as $keyrights => $rights) {
                    $ins_data['rights'] = $rights;
                    $check_user_access = $this->userWiseAccessList($request['member_id'][0], $ins_data['module_name'], $ins_data['sub_module_name'], $ins_data['menu'], $ins_data['rights']);
                    //echo $request['member_id'][0]; echo "--"; echo $ins_data['module_name']; echo "=="; echo $ins_data['sub_module_name']; echo "++"; echo $ins_data['menu']; echo "@@"; echo $ins_data['rights'];
                    // var_dump($check_user_access); echo "=======";
                    // echo "<pre>";print_r($check_user_access); exit;

                    if (is_null($check_user_access)) {

                        Role_authorization::insert($ins_data);
                        Session::flash('message', 'Role Successfully Saved.');
                    } else {
                        Session::flash('error', 'User Permission already exist!!');
                    }
                }
            }

            return redirect('role/view-users-role');
            /*$ob_RoleAuthorization= new RoleAuthorization();

        $i=1;
        $member_id_counter=1;
        $sub_module_name_counter=1;
        $menu_name_counter=1;
        $user_rights_name_counter=1;
        $y='';
        foreach($request->module_name as $module_name)
        {

        $index=0;
        $lenSubModule=count($request->input('sub_module_name'.$i));
        $lenMemberID=count($request->input('member_id'.$i));
        $lenUserRightMenu=count($request->input('menu_name'.$i));
        $lenUserRightList=count($request->input('user_rights_name'.$i));

        for($j=0; $j<$lenMemberID;$j++)
        {
        $index_sub=0;

        $member_id_arr=$request->input('member_id'.$member_id_counter);
        $member_id=$member_id_arr[$j];
        $sub_module_idarr=$request->input('sub_module_name'.$sub_module_name_counter);

        for($m=0; $m<$lenUserRightMenu;$m++)
        {
        $menu_name_arr=$request->input('menu_name'.$menu_name_counter);
        $menu_name=$menu_name_arr[$m];

        for($n=0; $n<$lenUserRightList;$n++)
        {
        $user_rights_list_arr=$request->input('user_rights_name'.$user_rights_name_counter);
        $user_rights_name=$user_rights_list_arr[$n];
        $data_role_auth['member_id']=$member_id;
        $data_role_auth['module_name']=$module_name;
        $data_role_auth['member_id']=$member_id;
        $data_role_auth['sub_module_name']=$sub_module_idarr[0];
        $data_role_auth['menu']=$menu_name;
        $data_role_auth['rights']=$user_rights_name;
        $role_auth_inserted_id=$ob_RoleAuthorization->create($data_role_auth)->id;
        }
        }

        $index++;
        }

        $user_rights_name_counter++;
        $menu_name_counter++;
        $sub_module_name_counter++;
        $member_id_counter++;
        $i++;
        }*/
        } else {
            return redirect('/');
        }
    }

    public function saveUserAccessRightsForm(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $ob_RoleAuthorization = new Role_authorization();

            $i = 1;
            $member_id_counter = 1;
            $sub_module_name_counter = 1;
            $menu_name_counter = 1;
            $user_rights_name_counter = 1;

            // dd($request->all());
            $ac = 0;
            $re = 0;
            if (isset($request->menu_name) && count($request->menu_name) != 0) {
                foreach ($request['member_id'] as $valuemenm) {
                    foreach ($request['menu_name'] as $key => $value) {

                        foreach ($request['user_rights_name'] as $keyrights => $rights) {

                            $check_user_access = $this->userWiseAccessList($valuemenm, $request->module_name, $request->sub_module_name, $request['menu_name'][$key], $rights);

                            if (is_null($check_user_access)) {
                                $ob_RoleAuthorization = new Role_authorization;
                                $ob_RoleAuthorization->menu = $request['menu_name'][$key];
                                $ob_RoleAuthorization->module_name = $request->module_name;
                                $ob_RoleAuthorization->sub_module_name = $request->sub_module_name;
                                $ob_RoleAuthorization->member_id = $valuemenm;
                                $ob_RoleAuthorization->rights = $rights;

                                $ob_RoleAuthorization->save();
                                $ac++;
                            } else {
                                $re++;
                                Session::flash('error', 'User Permission already exist!!');
                            }
                        }
                    }
                }
            } else {
                Session::flash('error', 'Nothing to save!!');
            }

            if ($ac > 0) {
                Session::flash('message', 'Role Successfully Saved.');
            } else if ($re > 0) {
                Session::flash('error', 'User Permission already exist!!');
            }

            return redirect('role/view-users-role');
        } else {
            return redirect('/');
        }
    }

    public function viewUserConfigForm()
    {
        if (!empty(Session::get('admin'))) {

            $data['employeeslist'] = Employee::get();

            $data['users'] = User::where('user_type', '=', 'user')->get();
            $userlist = array();
            foreach ($data['users'] as $user) {
                $userlist[] = $user->employee_id;
            }

            $data['employees'] = array();
            foreach ($data['employeeslist'] as $key => $employee) {
                if (in_array($employee->emp_code, $userlist)) {
                } else {
                    $data['employees'][] = (object) array("emp_code" => $employee->emp_code, "emp_fname" => $employee->emp_fname, "emp_mname" => $employee->emp_mname, "emp_lname" => $employee->emp_lname);
                }
            }

            //echo "<pre>"; print_r($data['employees']); exit;
            return view('role/view-user-config', $data);
        } else {
            return redirect('/');
        }
    }

    public function GetUserConfigForm($user_id)
    {
        if (!empty(Session::get('admin'))) {

            $data['employeeslist'] = Employee::get();
            $data['users'] = User::where('user_type', '=', 'user')->get();
            $userlist = array();
            foreach ($data['users'] as $user) {
                $userlist[] = $user->employee_id;
            }

            $data['employees'] = array();
            foreach ($data['employeeslist'] as $key => $employee) {
                if (in_array($employee->emp_code, $userlist)) {
                } else {
                    $data['employees'][] = (object) array("emp_code" => $employee->emp_code, "emp_fname" => $employee->emp_fname, "emp_mname" => $employee->emp_mname, "emp_lname" => $employee->emp_lname);
                }
            }

            $data['user'] = User::where('id', '=', $user_id)->first();
            //return redirect('role/vw-user-config');
            return view('role/edit-user-config', $data);
        } else {
            return redirect('/');
        }
    }

    public function SaveUserConfigForm(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            //print_r($request->all()); exit;
            $password = Hash::make($request->user_pass);
            $validator = Validator::make(
                $request->all(),
                [
                    'emp_code' => 'required|unique:users,employee_id',
                    'user_email' => 'required|email|unique:users,email',
                    'user_pass' => 'required|max:20',
                    'name' => 'required',
                ],
                [
                    'emp_code.required' => 'Employee Code Required',
                    'emp_code.unique' => 'Employee Code Already Exist',
                    'user_email.required' => 'Email ID Required',
                    'user_email.unique' => 'Email ID Already Exist',
                    'user_pass.required' => 'Password Required',
                ]
            );

            if ($validator->fails()) {
                return redirect('role/vw-user-config')->withErrors($validator)->withInput();
            } else {
                // print_r('hello');
                // die();
                $user = new User();
                $user->employee_id = $request->emp_code;
                $user->name = $request->name;
                $user->email = $request->user_email;
                $user->user_type = 'user';
                $user->password = Hash::make($request->user_pass);
                $user->save();
                Session::flash('message', 'User info saved Successfully.');
                return redirect('role/vw-users');
            }
        } else {
            return redirect('/');
        }
    }

    public function UpdateUserConfigForm(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            //print_r($request->all()); exit;
            $password = Hash::make($request->user_pass);
            $validator = Validator::make(
                $request->all(),
                [
                    'emp_code' => 'required|unique:users,employee_id',
                    'user_email' => 'required|email|unique:users,email',
                    'user_pass' => 'required|max:20',
                    'name' => 'required',
                ],
                [
                    'emp_code.required' => 'Employee Code Required',
                    'emp_code.unique' => 'Employee Code Already Exist',
                    'user_email.required' => 'Email ID Required',
                    'user_email.unique' => 'Email ID Already Exist',
                    'user_pass.required' => 'Password Required',
                ]
            );

            if (!empty($request->employee_id)) {
                if (!empty($request->employee_id) && !empty($request->user_pass)) {
                    User::where('employee_id', '=', $request->employee_id)
                        ->update([
                            'password' => Hash::make($request->user_pass),
                            'status' => $request->status,
                        ]);
                    Session::flash('message', 'User info Successfully.');
                    return redirect('role/vw-users');
                } else {
                    User::where('employee_id', '=', $request->employee_id)
                        ->update(['status' => $request->status]);
                    Session::flash('message', 'User info updated Successfully.');
                    return redirect('role/vw-users');
                }
            }
        } else {
            return redirect('/');
        }
    }

    /*public function getUserAccessRights($role_authorization_id)
    {
    $data['users']=DB::table('users')->where('user_type','=','user')->get();
    $data['module']=DB::table('module')->get();
    $data['menu']=DB::table('module_config')->get();
    $data['role_authorization'] = DB::table('role_authorization')
    ->where('id', '=', $role_authorization_id)->first();
    return view('role/role',$data);
    }*/

    public function deleteUserAccess($role_authorization_id)
    {
        if (!empty(Session::get('admin'))) {

            // echo $role_authorization_id; exit;
            $result = Role_authorization::where('id', '=', $role_authorization_id)->delete();
            Session::flash('message', 'Access permission deleted Successfully.');
            return redirect('role/view-users-role');
        } else {
            return redirect('/');
        }
    }

    public function viewUserAccessRights()
    {
        if (!empty(Session::get('admin'))) {

            $data['roles'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->groupBy('role_authorizations.member_id')
                ->groupBy('role_authorizations.menu')
                ->groupBy('role_authorizations.rights')
                ->get();
            return view('role/view-users-role', $data);
        } else {
            return redirect('/');
        }
    }

    public function subModuleID($id_module)
    {
        if (!empty(Session::get('admin'))) {

            $sub_module_rs = Sub_module::where('module_id', '=', $id_module)->get();
            //dd($grade_rs);
            $result = '<option value="" selected disabled >Select</option>';

            foreach ($sub_module_rs as $sub_module) {
                $result .= '<option value="' . $sub_module->id . '">' . $sub_module->sub_module_name . '</option>';
            }
            echo $result;
        } else {
            return redirect('/');
        }
    }

    public function subMenuID($id_sub_module)
    {
        if (!empty(Session::get('admin'))) {

            //$sub_module_rs=SubModule::where('module_id','=',$id_module)->get();
            $rolemenus = Module_config::where('sub_module_id', '=', $id_sub_module)->get();
            //dd($grade_rs);
            $result = '<option value="" selected disabled >Select</option>';

            foreach ($rolemenus as $menu) {
                $result .= '<option value="' . $menu->id . '">' . $menu->menu_name . '</option>';
            }
            echo $result;
        } else {
            return redirect('/');
        }
    }
}