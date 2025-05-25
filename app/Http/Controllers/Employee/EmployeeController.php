<?php

namespace App;

namespace App\Http\Controllers\Employee;

use App\Exports\ExcelEmpClassReport;
use App\Exports\ExcelEmpDepReport;
use App\Exports\ExcelEmpExReport;
use App\Exports\ExcelFileExportEmployees;
use App\Exports\ExcelFileExportEmployeesOnly;
use App\Http\Controllers\Controller;
use App\Models\Employee\Education_details;
use App\Models\Employee\Employee_pay_structure;
use App\Models\Employee\Emp_pay_structure;
use App\Models\Employee\Increment_history;
use App\Models\Employee\Leave_apply;
use App\Models\Employee\Macp_history;
use App\Models\Employee\Pay_scale_basic_master;
use App\Models\Employee\Process_attendance;
use App\Models\Employee\Promotion_history;
use App\Models\Employee\Salutation;
use App\Models\LeaveApprover\Pension;
use App\Models\Leave\Gpf_details;
use App\Models\Masters\Bank;
use App\Models\Masters\Bank_master;
use App\Models\Masters\Cast;
use App\Models\Masters\Department;
use App\Models\Masters\Designation;
use App\Models\Masters\Education_master;
use App\Models\Masters\Employee_type;
use App\Models\Masters\Grade;
use App\Models\Masters\Group_name_detail;
use App\Models\Masters\Pay_head_master;
use App\Models\Masters\Pay_scale_master;
use App\Models\Masters\Pay_type;
use App\Models\Masters\Rate_details;
use App\Models\Masters\Rate_master;
//use Illuminate\Contracts\Validation\Rule;
use App\Models\Masters\Religion;
use App\Models\Masters\Role_authorization;
use App\Models\Masters\State_master;
use App\Models\Masters\Sub_cast;
use App\Models\Role\Employee;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use view;

class EmployeeController extends Controller
{
    //

    public function viewdashboard()
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['employeesincrement'] = Employee::whereMonth('emp_next_increament_date', '=', date('m'))
                ->whereYear('emp_next_increament_date', '=', date('Y'))
                ->where('status', '=', 'active')
                ->where('emp_status', '!=', 'TEMPORARY')
                ->where('emp_status', '!=', 'EX-EMPLOYEE')
                ->where('emp_status', '!=', 'EX- EMPLOYEE')
                ->orderBy('emp_next_increament_date', 'asc')
                ->get();

            $data['employeesdob'] = Employee::whereDay('emp_dob', '>=', date('d'))
                ->whereMonth('emp_dob', '=', date('m'))
                ->where('status', '=', 'active')
                ->where('emp_status', '!=', 'TEMPORARY')
                ->where('emp_status', '!=', 'EX-EMPLOYEE')
                ->where('emp_status', '!=', 'EX- EMPLOYEE')
                ->orderBy('emp_dob', 'desc')
                ->get();

            $data['employeeretirement'] = Employee::where('emp_retirement_date', '>=', date('Y-m-d'))
                ->whereYear('emp_retirement_date', '=', date('Y'))
                ->where('status', '=', 'active')
                ->where('emp_status', '!=', 'TEMPORARY')
                ->where('emp_status', '!=', 'EX-EMPLOYEE')
                ->where('emp_status', '!=', 'EX- EMPLOYEE')
                ->orderBy('emp_retirement_date', 'asc')
                ->get();

            return View('employee/dashboard', $data);
        } else {
            return redirect('/');
        }
    }

    public function getEmployees()
    {

        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['employee_rs'] = Employee::where('employees.emp_status', '!=', 'EX-EMPLOYEE')
                ->where('employees.emp_status', '!=', 'EX- EMPLOYEE')->get();

            // dd($data['employee_rs']);
            return view('employee.view-employee', $data);
        } else {
            return redirect('/');
        }
    }

    public function employeesByClass()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['monthlist'] = Group_name_detail::select('id', 'group_name')->distinct('group_name')
                ->get();

            //dd($data['monthlist']);

            $data['result'] = '';
            return view('employee.EmployeeListClassWiseReport', $data);
        } else {
            return redirect('/');
        }
    }

    public function employeesByDepartment()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['monthlist'] = Employee::orderBy('emp_department')->select('emp_department')->distinct('emp_department')->get();
            $data['result'] = '';
            return view('employee.EmployeeListDepWiseReport', $data);
        } else {
            return redirect('/');
        }
    }

    public function emp_class_xlsexport(Request $request)
    {
        //dd($request->all());
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $emp_class_data = '';
            if (isset($request->emp_class)) {
                $emp_class_data = $request->emp_class;
            }

            return Excel::download(new ExcelEmpClassReport($emp_class_data), 'EmpClassReport.xlsx');
        } else {
            return redirect('/');
        }
    }

    public function emp_ex_report(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $empex = 'EX- EMPLOYEE';

            $emp_ex_data = '';
            if (isset($empex)) {
                $emp_ex_data = $empex;
            }

            return Excel::download(new ExcelEmpExReport($emp_ex_data), 'EmpExReport.xlsx');
        } else {
            return redirect('/');
        }
    }

    public function emp_dep_xlsexport(Request $request)
    {
        //dd($request->all());
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $department_data = '';
            if (isset($request->department)) {
                $department_data = $request->department;
            }

            return Excel::download(new ExcelEmpDepReport($department_data), 'EmpDepartmentReport.xlsx');
        } else {
            return redirect('/');
        }
    }

    public function employees_xlsexport(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name')
                ->where('member_id', '=', $email)
                ->get();

            return Excel::download(new ExcelFileExportEmployees(), 'Employees.xlsx');
        } else {
            return redirect('/');
        }
    }
    public function employees_xlsexportonly(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name')
                ->where('member_id', '=', $email)
                ->get();

            return Excel::download(new ExcelFileExportEmployeesOnly(), 'EmployeesOnly.xlsx');
        } else {
            return redirect('/');
        }
    }

    public function viewAddEmployee()
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['employee_code'] = rand(1000, 10000);

            $data['department'] = Department::where('department_status', '=', 'active')->get();
            $data['salutations'] = Salutation::pluck('name'); //dd($data['salutations']);
            $data['designation'] = Designation::where('designation_status', '=', 'active')->get();
            $data['cast'] = Cast::where('cast_status', '=', 'active')->get();
            $data['sub_cast'] = Sub_cast::where('sub_cast_status', '=', 'active')->get();
            $data['religion'] = Religion::get();
            $data['employee_type'] = Employee_type::where('employee_type_status', '=', 'active')->get();
            $data['grade'] = Grade::where('grade_status', '=', 'active')->get();
            $data['bank'] = Bank_master::get();
            $data['payscale_master'] = Pay_scale_master::get();
            $data['states'] = State_master::get();
            $data['employeelists'] = Employee::where('emp_status', '!=', 'TEMPORARY')
                ->where('emp_status', '!=', 'EX-EMPLOYEE')->where('emp_status', '!=', 'EX- EMPLOYEE')->get();

            $data['pay_head'] = Pay_head_master::get();
            $data['group_name'] = Group_name_detail::where('status', '=', 'active')->get();

            $data['pay_type'] = Pay_type::get();
            $data['education'] = Education_master::get();
            $data['rate_details'] = Rate_details::leftJoin('rate_masters', 'rate_masters.id', '=', 'rate_details.rate_id')
                ->select('rate_details.*', 'rate_masters.head_name', 'rate_masters.head_type')
                ->where('rate_details.from_date', '>=', date('Y-01-01'))
                ->where('rate_details.to_date', '<=', date('Y-12-31'))
                ->groupBy('rate_details.rate_id')
                ->get();
            $data['rate_master'] = Rate_master::get();

            $data['pay_master'] = Pay_head_master::leftJoin('pay_types', 'pay_types.id', '=', 'pay_head_masters.pay_type')
                ->select('pay_head_masters.*', 'pay_types.pay_type_name')
                ->get();

            //echo "<pre>";print_r($data['states']);exit;
            return view('employee/employee-master', $data);
        } else {
            return redirect('/');
        }

        //return view('pis/employee-master')->with(['company'=>$company,'employee'=>$employee_type]);
    }

    public function saveEmployee(Request $request)
    {
        $request->validate([
            'emp_code' => 'required|unique:employees,emp_code','This field is required.'
        ]);
        if (!empty(Session::get('admin'))) {

            // dd($request->all());

            date_default_timezone_set('Asia/Kolkata');

            if (strtotime($request->emp_dob) > strtotime(date('Y-m-d'))) {
                Session::flash('error', 'Please select Date Of Birth less than or equal to today.');

                return redirect('employees');
            }

            function my_simple_crypt($string, $action = 'encrypt')
            {
                // you may change these values to your own
                $secret_key = 'bopt_saltlake_kolkata_secret_key';
                $secret_iv = 'bopt_saltlake_kolkata_secret_iv';

                $output = false;
                $encrypt_method = "AES-256-CBC";
                $key = hash('sha256', $secret_key);
                $iv = substr(hash('sha256', $secret_iv), 0, 16);

                if ($action == 'encrypt') {
                    $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
                } else if ($action == 'decrypt') {
                    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
                }

                return $output;
            }

            //print_r($request->hasFile('emp_image')); print_r($request->edit_emp_image); exit;

            if ($request->hasFile('emp_image')) {
                $files = $request->file('emp_image');
                $extension = $request->emp_image->extension();
                $filename = $request->emp_image->store('emp_pic', 'public');
            } else {

                $filename = "";
            }

            $id = $request->input('q');
            if ($id) {
                $decrypted_empid = my_simple_crypt($id, 'decrypt');
                $retiredate = $request->emp_retirement_date;
                $date = str_replace('/', '-', $retiredate);
                $retirementdate = date_create($date);
                $retire_date = date_format($retirementdate, 'Y-m-d');

                $payupdate = array(
                    'employee_code' => $request->old_emp_code,
                    'basic_pay' => $request->emp_basic_pay,
                    'apf_percent' => $request->emp_apf_percent,
                    'da' => $request->da,
                    'vda' => $request->vda,
                    'hra' => $request->hra,
                    'prof_tax' => $request->prof_tax,
                    'others_alw' => $request->others_alw,
                    'tiff_alw' => $request->tiff_alw,
                    'conv' => $request->conv,
                    'medical' => $request->medical,
                    'misc_alw' => $request->misc_alw,
                    'over_time' => $request->over_time,
                    'bouns' => $request->bouns,
                    'tot_inc' => $request->tot_inc,
                    'pf' => $request->pf,
                    'pf_int' => $request->pf_int,
                    'apf' => $request->apf,
                    'i_tax' => $request->i_tax,
                    'insu_prem' => $request->insu_prem,
                    'pf_loan' => $request->pf_loan,
                    'esi' => $request->esi,
                    'adv' => $request->adv,
                    'hrd' => $request->hrd,
                    'co_op' => $request->co_op,
                    'furniture' => $request->furniture,
                    'misc_ded' => $request->misc_ded,
                    'tot_ded' => $request->tot_ded,
                    'leave_inc' => $request->leave_inc,
                    'hta' => $request->hta,

                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                );

                $dataupdate = array(
                    'emp_code' => $request->old_emp_code,
                    'old_emp_code' => $request->old_emp_code,
                    'salutation' => $request->salutations,
                    'emp_fname' => strtoupper($request->emp_fname),
                    'emp_mname' => strtoupper($request->emp_mid_name),
                    'emp_lname' => strtoupper($request->emp_lname),
                    'emp_father_name' => strtoupper($request->emp_father_name),
                    'marital_status' => $request->marital_status,
                    'marital_date' => date('Y-m-d', strtotime($request->marital_date)),
                    'emp_aadhar_no' => $request->emp_aadhar_no,
                    'emp_present_city_class' => $request->emp_present_city,
                    'emp_residential_distance' => $request->emp_resdential_distance,
                    'emp_home_town' => $request->emp_home_town,
                    'emp_nearest_railway' => $request->emp_nearest_railway,
                    'emp_caste' => $request->emp_caste,
                    'emp_sub_caste' => $request->emp_sub_caste,
                    'emp_religion' => $request->emp_religion,
                    'emp_spouse_working_status' => $request->emp_spouse_working,
                    'emp_image' => $filename,
                    'emp_government' => $request->emp_government,
                    'emp_spouse_quarter' => $request->emp_spouse_quarter,
                    'emp_branch' => $request->emp_branch,
                    'emp_department' => $request->emp_department,
                    'emp_designation' => $request->emp_designation,
                    'emp_reporting_auth' => $request->emp_reporting_auth,
                    'emp_lv_sanc_auth' => $request->emp_lv_sanc_auth,
                    'emp_eligible_promotion' => $request->emp_eligible_promotion,
                    'emp_dob' => $request->emp_dob,
                    'emp_doj' => $request->emp_doj,
                    'emp_retirement_date' => $retire_date,
                    'emp_next_increament_date' => date("Y-m-d", strtotime($request->emp_next_increment_date)),
                    'emp_status' => $request->emp_status,
                    'emp_shift_group' => $request->emp_sift_grp,
                    'emp_from_date' => $request->emp_from_date,
                    'emp_till_date' => $request->emp_till_date,
                    'emp_x_qualification' => $request->emp_x_qualification,
                    'emp_x_dicipline' => $request->emp_x_dicipline,
                    'emp_x_institute_name' => $request->emp_x_inst_name,
                    'emp_x_board_name' => $request->emp_x_board_name,
                    'emp_x_pass_year' => $request->emp_x_pass_year,
                    'emp_x_percentage' => $request->emp_x_percentage,
                    'emp_x_rank' => $request->emp_x_rank,
                    'emp_xii_qualification' => $request->emp_xii_qualification,
                    'emp_xii_dicipline' => $request->emp_xii_dicipline,
                    'emp_xii_institute_name' => $request->emp_xii_inst_name,
                    'emp_xii_board_name' => $request->emp_xii_board_name,
                    'emp_xii_pass_year' => $request->emp_xii_pass_year,
                    'emp_xii_percentage' => $request->emp_xii_percentage,
                    'emp_xii_rank' => $request->emp_xii_rank,
                    'emp_graduate_qualification' => $request->emp_graduate_qualification,
                    'emp_graduate_dicipline' => $request->emp_graduate_dicipline,
                    'emp_graduate_institute_name' => $request->emp_graduate_inst_name,
                    'emp_graduate_board_name' => $request->emp_graduate_board_name,
                    'emp_graduate_pass_year' => $request->emp_graduate_pass_year,
                    'emp_graduate_percentage' => $request->emp_graduate_percentage,
                    'emp_graduate_rank' => $request->emp_graduate_rank,
                    'emp_pgraduate_qualification' => $request->emp_pgraduate_qualification,
                    'emp_pgraduate_dicipline' => $request->emp_pgraduate_dicipline,
                    'emp_pgraduate_institute_name' => $request->emp_pgraduate_inst_name,
                    'emp_pgraduate_board_name' => $request->emp_pgraduate_board_name,
                    'emp_pgraduate_pass_year' => $request->emp_pgraduate_pass_year,
                    'emp_pgraduate_percentage' => $request->emp_pgraduate_percentage,
                    'emp_pgraduate_rank' => $request->emp_pgraduate_rank,
                    'nominee_name_one' => $request->emp_nomination_name_one,
                    'nominee_relationship_one' => $request->emp_nomination_relation_one,
                    'nominee_dob_one' => $request->emp_nomination_dob_one,
                    'nominee_name_two' => $request->emp_nomination_name_two,
                    'emp_nomination_name_three' => $request->emp_nomination_name_three,
                    'emp_nomination_name_four' => $request->emp_nomination_name_four,
                    'nominee_dob_two' => $request->emp_nomination_dob_two,
                    'emp_nomination_dob_three' => $request->emp_nomination_dob_three,
                    'emp_nomination_dob_four' => $request->emp_nomination_dob_four,
                    'emp_nomination_relation_three' => $request->emp_nomination_relation_three,
                    'emp_nomination_relation_four' => $request->emp_nomination_relation_four,
                    'emp_nomination_share_one' => $request->emp_nomination_share_one,
                    'emp_nomination_share_two' => $request->emp_nomination_share_two,
                    'emp_nomination_share_three' => $request->emp_nomination_share_three,
                    'emp_nomination_share_four' => $request->emp_nomination_share_four,
                    'emp_blood_group' => $request->emp_blood_grp,
                    'emp_eye_sight_left' => $request->emp_eye_sight_left,
                    'emp_eye_sight_right' => $request->emp_eye_sight_right,
                    'emp_family_plan_status' => $request->emp_family_plan_status,
                    'emp_family_plan_date' => $request->emp_family_plan_date,
                    'emp_height' => $request->emp_height,
                    'emp_weight' => $request->emp_weight,
                    'emp_identification_mark_one' => $request->emp_identification_mark_one,
                    'emp_identification_mark_two' => $request->emp_identification_mark_two,
                    'emp_physical_status' => $request->emp_physical_status,

                    'emp_per_village' => $request->emp_per_village,
                    'emp_per_post_office' => $request->emp_per_post_office,
                    'emp_per_policestation' => $request->emp_per_policestation,
                    'emp_per_dist' => $request->emp_per_dist,
                    'emp_pr_street_no' => $request->emp_pr_street_no,
                    'emp_pr_city' => $request->emp_pr_city,
                    'emp_pr_state' => $request->emp_pr_state,
                    'emp_pr_country' => $request->emp_pr_country,
                    'emp_pr_pincode' => $request->emp_pr_pincode,
                    'emp_pr_mobile' => $request->emp_pr_mobile,
                    'emp_ps_street_no' => $request->emp_ps_street_no,
                    'emp_ps_village' => $request->emp_ps_village,
                    'emp_ps_post_office' => $request->emp_ps_post_office,
                    'emp_ps_policestation' => $request->emp_ps_policestation,
                    'emp_ps_dist' => $request->emp_ps_dist,
                    'emp_ps_city' => $request->emp_ps_city,
                    'emp_ps_state' => $request->emp_ps_state,
                    'emp_ps_country' => $request->emp_ps_country,
                    'emp_ps_pincode' => $request->emp_ps_pincode,
                    'emp_ps_phone' => $request->emp_ps_phone,
                    'emp_ps_mobile' => $request->emp_ps_mobile,
                    'emp_ps_email' => $request->emp_ps_email,
                    'emp_grade' => $request->emp_grade,
                    'emp_group_name' => $request->emp_group,
                    'emp_pay_scale' => $request->emp_payscale,
                    'emp_pension_no' => $request->emp_pension_no,
                    'emp_pf_type' => $request->emp_pf_type,
                    'emp_passport_no' => $request->emp_passport_no,
                    'emp_time_office_code' => $request->emp_time_office_code,
                    'emp_pf_no' => $request->emp_pf_no,
                    'emp_uan_no' => $request->emp_uan_no,
                    'emp_pan_no' => $request->emp_pan_no,
                    'emp_payment_type' => $request->emp_payment_type,
                    'emp_bank_name' => $request->emp_bank_name,
                    'bank_branch_id' => $request->bank_branch_id,
                    'emp_ifsc_code' => $request->emp_ifsc_code,
                    'emp_account_no' => $request->emp_account_no,
                    'emp_pension' => $request->emp_pension,
                    'emp_pf_inactuals' => $request->emp_pf_inactuals,
                    'emp_bonus' => $request->emp_bonus,
                );

                Employee::where('old_emp_code', $decrypted_empid)
                    ->update($dataupdate);
                Employee_pay_structure::where('employee_code', $decrypted_empid)
                    ->update($payupdate);
                Session::flash('message', 'Record has been successfully updated');
                return redirect('employees');
            } else {

                $retiredate = $request->emp_retirement_date;
                $date = str_replace('/', '-', $retiredate);
                $retirementdate = date_create($date);
                $retire_date = date_format($retirementdate, 'Y-m-d');

                if (isset($request->pay)) {

                    $countper = count($request->pay);

                    for ($i = 0; $i < $countper; $i++) {
                        $emp_pay[$i] = array(
                            'emp_code' => $request->old_emp_code,
                            'emp_pay' => $request->pay[$i],
                        );
                    }
                }

                if (isset($request->discipline)) {
                    for ($i = 0; $i < count($request->discipline); $i++) {
                        if ($request->qualification[$i] != '') {
                            $education[$i] = array(
                                'employee_code' => $request->old_emp_code,
                                'qualification' => $request->qualification[$i],
                                'discipline' => $request->discipline[$i],
                                'institute_name' => $request->institute_name[$i],
                                'university' => $request->university[$i],
                                'year_of_passing' => $request->year_of_passing[$i],
                                'percentage' => $request->percentage[$i],
                                'grade' => $request->grade[$i],
                            );
                        }
                    }
                }

                // print_r($education);
                // die();
                $pay = array();
                $pay['employee_code'] = $request->old_emp_code;
                $pay['basic_pay'] = $request->emp_basic_pay;
                $pay['apf_percent'] = $request->emp_apf_percent;
                $pay['created_at'] = date('Y-m-d h:i:s');
                $pay['updated_at'] = date('Y-m-d h:i:s');
                //dd($request->name_earn);
                if ($request->name_earn && count($request->name_earn) != 0) {
                    $arr_un = count(array_unique($request->name_earn));
                    if (count($request->name_earn) != $arr_un) {
                        Session::flash('error', 'Pay Structure Earning Head Must be unique');

                        return redirect('employees');
                    }
                    for ($i = 0; $i < count($request->name_earn); $i++) {

                        if ($request->name_earn[$i] != '') {
                            $pay[$request->name_earn[$i]] = $request->value[$i];
                            $pay[$request->name_earn[$i] . '_type'] = $request->head_type[$i];

                        }

                    }
                }

                if ($request->name_deduct && count($request->name_deduct) != 0) {
                    $arr_un = count(array_unique($request->name_deduct));
                    if (count($request->name_deduct) != $arr_un) {
                        Session::flash('error', 'Pay Structure Deduction Head Must be unique');

                        return redirect('employees');
                    }
                    for ($i = 0; $i < count($request->name_deduct); $i++) {

                        if ($request->name_deduct[$i] != '') {

                            $pay[$request->name_deduct[$i]] = $request->valuededuct[$i];
                            $pay[$request->name_deduct[$i] . '_type'] = $request->head_typededuct[$i];
                        }

                    }
                }

                $data = array(
                    'emp_code' => $request->old_emp_code,
                    'old_emp_code' => $request->old_emp_code,
                    'salutation' => $request->salutations,
                    'emp_fname' => strtoupper($request->emp_fname),
                    'emp_mname' => strtoupper($request->emp_mid_name),
                    'emp_lname' => strtoupper($request->emp_lname),
                    'emp_father_name' => strtoupper($request->emp_father_name),
                    'emp_aadhar_no' => $request->emp_aadhar_no,
                    'emp_present_city_class' => $request->emp_present_city,
                    'emp_residential_distance' => $request->emp_resdential_distance,
                    'emp_home_town' => $request->emp_home_town,
                    'emp_nearest_railway' => $request->emp_nearest_railway,
                    'emp_caste' => $request->emp_caste,
                    'emp_sub_caste' => $request->emp_sub_caste,
                    'emp_religion' => $request->emp_religion,
                    'emp_image' => $filename,
                    'emp_spouse_working_status' => $request->emp_spouse_working,
                    'emp_government' => $request->emp_government,
                    'emp_spouse_quarter' => $request->emp_spouse_quarter,
                    'emp_branch' => $request->emp_branch,
                    'emp_department' => $request->emp_department,
                    'emp_designation' => $request->emp_designation,
                    'emp_reporting_auth' => $request->emp_reporting_auth,
                    'emp_lv_sanc_auth' => $request->emp_lv_sanc_auth,
                    'emp_eligible_promotion' => $request->emp_eligible_promotion,
                    'emp_dob' => $request->emp_dob,
                    'marital_status' => $request->marital_status,
                    'marital_date' => date('Y-m-d', strtotime($request->marital_date)),
                    'emp_doj' => $request->emp_doj,
                    'emp_retirement_date' => $retire_date,
                    'emp_next_increament_date' => date("Y-m-d", strtotime($request->emp_next_increment_date)),
                    'emp_status' => $request->emp_status,
                    'emp_shift_group' => $request->emp_sift_grp,
                    'emp_from_date' => $request->emp_from_date,
                    'emp_till_date' => $request->emp_till_date,
                    'emp_x_qualification' => $request->emp_x_qualification,
                    'emp_x_dicipline' => $request->emp_x_dicipline,
                    'emp_x_institute_name' => $request->emp_x_inst_name,
                    'emp_x_board_name' => $request->emp_x_board_name,
                    'emp_x_pass_year' => $request->emp_x_pass_year,
                    'emp_x_percentage' => $request->emp_x_percentage,
                    'emp_x_rank' => $request->emp_x_rank,
                    'emp_xii_qualification' => $request->emp_xii_qualification,
                    'emp_xii_dicipline' => $request->emp_xii_dicipline,
                    'emp_xii_institute_name' => $request->emp_xii_inst_name,
                    'emp_xii_board_name' => $request->emp_xii_board_name,
                    'emp_xii_pass_year' => $request->emp_xii_pass_year,
                    'emp_xii_percentage' => $request->emp_xii_percentage,
                    'emp_xii_rank' => $request->emp_xii_rank,
                    'emp_graduate_qualification' => $request->emp_graduate_qualification,
                    'emp_graduate_dicipline' => $request->emp_graduate_dicipline,
                    'emp_graduate_institute_name' => $request->emp_graduate_inst_name,
                    'emp_graduate_board_name' => $request->emp_graduate_board_name,
                    'emp_graduate_pass_year' => $request->emp_graduate_pass_year,
                    'emp_graduate_percentage' => $request->emp_graduate_percentage,
                    'emp_graduate_rank' => $request->emp_graduate_rank,
                    'emp_pgraduate_qualification' => $request->emp_pgraduate_qualification,
                    'emp_pgraduate_dicipline' => $request->emp_pgraduate_dicipline,
                    'emp_pgraduate_institute_name' => $request->emp_pgraduate_inst_name,
                    'emp_pgraduate_board_name' => $request->emp_pgraduate_board_name,
                    'emp_pgraduate_pass_year' => $request->emp_pgraduate_pass_year,
                    'emp_pgraduate_percentage' => $request->emp_pgraduate_percentage,
                    'emp_pgraduate_rank' => $request->emp_pgraduate_rank,
                    'nominee_name_one' => $request->emp_nomination_name_one,
                    'nominee_relationship_one' => $request->emp_nomination_relation_one,
                    'nominee_dob_one' => $request->emp_nomination_dob_one,
                    'nominee_name_two' => $request->emp_nomination_name_two,
                    'emp_nomination_name_three' => $request->emp_nomination_name_three,
                    'emp_nomination_name_four' => $request->emp_nomination_name_four,
                    'nominee_relationship_two' => $request->emp_nomination_relation_two,
                    'emp_nomination_relation_three' => $request->emp_nomination_relation_three,
                    'emp_nomination_relation_four' => $request->emp_nomination_relation_four,
                    'nominee_dob_two' => $request->emp_nomination_dob_two,
                    'emp_nomination_dob_three' => $request->emp_nomination_dob_three,
                    'emp_nomination_dob_four' => $request->emp_nomination_dob_four,
                    'emp_nomination_share_one' => $request->emp_nomination_share_one,
                    'emp_nomination_share_two' => $request->emp_nomination_share_two,
                    'emp_nomination_share_three' => $request->emp_nomination_share_three,
                    'emp_nomination_share_four' => $request->emp_nomination_share_four,
                    'emp_blood_group' => $request->emp_blood_grp,
                    'emp_eye_sight_left' => $request->emp_eye_sight_left,
                    'emp_eye_sight_right' => $request->emp_eye_sight_right,
                    'emp_family_plan_status' => $request->emp_family_plan_status,
                    'emp_family_plan_date' => $request->emp_family_plan_date,
                    'emp_height' => $request->emp_height,
                    'emp_weight' => $request->emp_weight,
                    'emp_identification_mark_one' => $request->emp_identification_mark_one,
                    'emp_identification_mark_two' => $request->emp_identification_mark_two,
                    'emp_physical_status' => $request->emp_physical_status,

                    'emp_per_village' => $request->emp_per_village,
                    'emp_per_post_office' => $request->emp_per_post_office,
                    'emp_per_policestation' => $request->emp_per_policestation,
                    'emp_per_dist' => $request->emp_per_dist,
                    'emp_pr_street_no' => $request->emp_pr_street_no,
                    'emp_pr_city' => $request->emp_pr_city,
                    'emp_pr_state' => $request->emp_pr_state,
                    'emp_pr_country' => $request->emp_pr_country,
                    'emp_pr_pincode' => $request->emp_pr_pincode,
                    'emp_pr_mobile' => $request->emp_pr_mobile,
                    'emp_ps_street_no' => $request->emp_ps_street_no,
                    'emp_ps_village' => $request->emp_ps_village,
                    'emp_ps_post_office' => $request->emp_ps_post_office,
                    'emp_ps_policestation' => $request->emp_ps_policestation,
                    'emp_ps_dist' => $request->emp_ps_dist,

                    'emp_ps_city' => $request->emp_ps_city,
                    'emp_ps_state' => $request->emp_ps_state,
                    'emp_ps_country' => $request->emp_ps_country,
                    'emp_ps_pincode' => $request->emp_ps_pincode,
                    'emp_ps_phone' => $request->emp_ps_phone,
                    'emp_ps_mobile' => $request->emp_ps_mobile,
                    'emp_ps_email' => $request->emp_ps_email,
                    'emp_grade' => $request->emp_grade,
                    'emp_group_name' => $request->emp_group,
                    'emp_pay_scale' => $request->emp_payscale,
                    'emp_pension_no' => $request->emp_pension_no,
                    'emp_pf_type' => $request->emp_pf_type,
                    'emp_passport_no' => $request->emp_passport_no,
                    'emp_time_office_code' => $request->emp_time_office_code,
                    'emp_pf_no' => $request->emp_pf_no,
                    'emp_pan_no' => $request->emp_pan_no,
                    'emp_payment_type' => $request->emp_payment_type,
                    'emp_bank_name' => $request->emp_bank_name,
                    'bank_branch_id' => $request->bank_branch_id,
                    'emp_ifsc_code' => $request->emp_ifsc_code,
                    'emp_account_no' => $request->emp_account_no,
                    'emp_pension' => $request->emp_pension,
                    'emp_pf_inactuals' => $request->emp_pf_inactuals,
                    'emp_bonus' => $request->emp_bonus,
                );
                //dd($pay);
                Employee_pay_structure::insert($pay);

                if (isset($education)) {
                    Education_details::insert($education);
                }
                Employee::insert($data);

                //Education_master::insert($education);
                Session::flash('message', 'Record has been successfully saved');
                return redirect('employees');
                // return redirect('pis/employee');
            }
        } else {
            return redirect('/');
        }
    }

    public function editEmployee()
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name')
                ->where('member_id', '=', $email)
                ->get();

            $id = request()->get('q');

            function my_simple_crypt($string, $action = 'encrypt')
            {

                // you may change these values to your own
                $secret_key = 'bopt_saltlake_kolkata_secret_key';
                $secret_iv = 'bopt_saltlake_kolkata_secret_iv';

                $output = false;
                $encrypt_method = "AES-256-CBC";
                $key = hash('sha256', $secret_key);
                $iv = substr(hash('sha256', $secret_iv), 0, 16);

                if ($action == 'encrypt') {
                    $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
                } else if ($action == 'decrypt') {
                    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
                }

                return $output;
            }
            ///
            //$encrypted = my_simple_crypt( 'Hello World!', 'encrypt' );
            $decrypted_id = my_simple_crypt($id, 'decrypt');
            $data['salutations'] = Salutation::pluck('name');
            $data['employee_rs'] = Employee::leftJoin('employee_pay_structures', 'employees.emp_code', '=', 'employee_pay_structures.employee_code')

                ->leftJoin('education_details', 'employees.emp_code', '=', 'education_details.employee_code')
                ->leftJoin('group_name_details', 'employees.emp_group_name', '=', 'group_name_details.id')
                ->where('employees.emp_code', '=', $decrypted_id)
                ->select('employees.*', 'employee_pay_structures.*', 'employee_pay_structures.*', 'education_details.*', 'group_name_details.group_name')
                ->get();

            $data['emp_pay_st'] = Employee_pay_structure::where('employee_code', '=', $decrypted_id)->first();

            //dd($data['emp_pay_st']);

            $data['emp_edu'] = Education_details::where('employee_code', '=', $decrypted_id)->get();

            $data['department'] = Department::where('department_status', '=', 'active')->get();
            $data['designation'] = Designation::leftJoin('departments', 'designations.department_code', '=', 'departments.id')
                ->where('designations.designation_status', '=', 'active')
                ->where('departments.department_name', '=', $data['employee_rs'][0]->emp_department)->get();
            $data['cast'] = Cast::where('cast_status', '=', 'active')->get();
            $data['sub_cast'] = Sub_cast::where('sub_cast_status', '=', 'active')->get();
            $data['religion'] = Religion::get();
            $data['employee_type'] = Employee_type::where('employee_type_status', '=', 'active')->get();
            $data['grade'] = Grade::where('grade_status', '=', 'active')->get();
            $data['bank'] = Bank_master::get();
            $data['payscale_master'] = Pay_scale_master::get();
            $data['states'] = State_master::get();
            $data['pay_master'] = Pay_head_master::leftJoin('pay_types', 'pay_types.id', '=', 'pay_head_masters.pay_type')
                ->select('pay_head_masters.*', 'pay_types.pay_type_name')
                ->get();
            $data['pay_head'] = Pay_head_master::get();
            $data['pay_type'] = Pay_type::get();
            $data['rate_details'] = Rate_details::leftJoin('rate_masters', 'rate_masters.id', '=', 'rate_details.rate_id')
                ->select('rate_details.*', 'rate_masters.head_name', 'rate_masters.head_type')
                ->where('rate_details.from_date', '>=', date('Y-01-01'))
                ->where('rate_details.to_date', '<=', date('Y-12-31'))
                ->groupBy('rate_details.rate_id')
                ->get();
            $data['rate_master'] = Rate_master::get();

            $data['education'] = Education_master::get();
            $data['group_name'] = Group_name_detail::where('status', '=', 'active')->get();

            $data['education_details'] = Education_details::get();
            $data['pay_structure'] = Emp_pay_structure::get();
            $data['employeelists'] = Employee::where('emp_status', '!=', 'TEMPORARY')
                ->where('emp_status', '!=', 'EX-EMPLOYEE')->where('emp_status', '!=', 'EX- EMPLOYEE')->get();
            //echo "<pre>";print_r($data['states']);exit;

            return view('employee/edit-employee-master', $data);
        } else {
            return redirect('/');
        }

        //return view('pis/employee-master')->with(['company'=>$company,'employee'=>$employee_type]);
    }

    public function updateEmployee(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            date_default_timezone_set('Asia/Kolkata');

            if (strtotime($request->emp_dob) > strtotime(date('Y-m-d'))) {
                Session::flash('error', 'Please select Date Of Birth less than or equal to today.');

                return redirect('employees');
            }

            function my_simple_crypt($string, $action = 'encrypt')
            {
                // you may change these values to your own
                $secret_key = 'bopt_saltlake_kolkata_secret_key';
                $secret_iv = 'bopt_saltlake_kolkata_secret_iv';

                $output = false;
                $encrypt_method = "AES-256-CBC";
                $key = hash('sha256', $secret_key);
                $iv = substr(hash('sha256', $secret_iv), 0, 16);

                if ($action == 'encrypt') {
                    $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
                } else if ($action == 'decrypt') {
                    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
                }

                return $output;
            }

            //print_r($request->hasFile('emp_image')); print_r($request->edit_emp_image); exit;

            if ($request->hasFile('emp_image')) {
                $files = $request->file('emp_image');
                $extension = $request->emp_image->extension();
                $filename = $request->emp_image->store('emp_pic', 'public');
            } else {

                $filename = $request->old_image;
            }

            $decrypted_empid = $request->emp_code;
            $retiredate = $request->emp_retirement_date;
            $date = str_replace('/', '-', $retiredate);
            $retirementdate = date_create($date);
            $retire_date = date_format($retirementdate, 'Y-m-d');

            if (isset($request->pay)) {

                $countper = count($request->pay);

                for ($i = 0; $i < $countper; $i++) {
                    $emp_pay[$i] = array(
                        'emply_code' => $request->emp_code,
                        'emp_pay' => $request->pay[$i],
                    );
                }
            }

            if (isset($request->discipline)) {
                for ($i = 0; $i < count($request->discipline); $i++) {
                    if ($request->qualification[$i] != '') {
                        $education[$i] = array(
                            'employee_code' => $request->emp_code,
                            'qualification' => $request->qualification[$i],
                            'discipline' => $request->discipline[$i],
                            'institute_name' => $request->institute_name[$i],
                            'university' => $request->university[$i],
                            'year_of_passing' => $request->year_of_passing[$i],
                            'percentage' => $request->percentage[$i],
                            'grade' => $request->grade[$i],
                        );
                    }
                }
            }
            // print_r($education);
            // die();

            // if(!empty($request->educations)){
            //     $edu_count=count($request->educations);

            //     foreach($request->educations  as $value){

            //         if($request->input('discipline_'.$value)!=''){
            //             $dataquli_edit=array(
            //                 'employee_code' => $request->emp_code,
            //                 'qualification' => $request->input('qualification_'.$value),
            //                 'discipline' => $request->input('discipline_'.$value),
            //                 'institute_name' => $request->input('institute_name_'.$value),
            //                 'university' => $request->input('university_'.$value),
            //                 'year_of_passing' => $request->input('year_of_passing_'.$value),
            //                 'percentage' => $request->input('percentage_'.$value),
            //                 'grade' => $request->input('grade_'.$value)

            //               );
            //             print_r($request->input('qualification_'.$value));
            //             die();
            //               Education_details::where('id', $value)
            //               ->update($dataquli_edit);
            //         }

            //     }

            // }
            $payupdate = array();
            $payupdate['employee_code'] = $request->emp_code;
            $payupdate['basic_pay'] = $request->emp_basic_pay;
            $payupdate['apf_percent'] = $request->emp_apf_percent;

            $payupdate['updated_at'] = date('Y-m-d h:i:s');
            if ($request->name_earn && count($request->name_earn) != 0) {

                $arr_un = count(array_unique($request->name_earn));
                if (count($request->name_earn) != $arr_un) {
                    Session::flash('error', 'Pay Structure Earning Head Must be unique');

                    return redirect('employees');
                }
                for ($i = 0; $i < count($request->name_earn); $i++) {

                    $payupdate[$request->name_earn[$i]] = $request->value[$i];
                    $payupdate[$request->name_earn[$i] . '_type'] = $request->head_type[$i];

                }
            }

            if ($request->name_deduct && count($request->name_deduct) != 0) {
                $arr_un = count(array_unique($request->name_deduct));
                if (count($request->name_deduct) != $arr_un) {
                    Session::flash('error', 'Pay Structure Deduction Head Must be unique');

                    return redirect('employees');
                }
                for ($i = 0; $i < count($request->name_deduct); $i++) {

                    $payupdate[$request->name_deduct[$i]] = $request->valuededuct[$i];
                    $payupdate[$request->name_deduct[$i] . '_type'] = $request->head_typededuct[$i];

                }
            }

            //dd($payupdate);
            $dataupdate = array(
                'emp_code' => $request->emp_code,
                'old_emp_code' => $request->old_emp_code,
                'salutation' => $request->salutations,
                'emp_fname' => strtoupper($request->emp_fname),
                'emp_mname' => strtoupper($request->emp_mid_name),
                'emp_lname' => strtoupper($request->emp_lname),
                'emp_father_name' => strtoupper($request->emp_father_name),
                'marital_status' => $request->marital_status,
                'marital_date' => date('Y-m-d', strtotime($request->marital_date)),
                'emp_aadhar_no' => $request->emp_aadhar_no,
                'emp_present_city_class' => $request->emp_present_city,
                'emp_residential_distance' => $request->emp_resdential_distance,
                'emp_home_town' => $request->emp_home_town,
                'emp_nearest_railway' => $request->emp_nearest_railway,
                'emp_caste' => $request->emp_caste,
                'emp_sub_caste' => $request->emp_sub_caste,
                'emp_religion' => $request->emp_religion,
                'emp_spouse_working_status' => $request->emp_spouse_working,
                'emp_image' => $filename,
                'emp_government' => $request->emp_government,
                'emp_spouse_quarter' => $request->emp_spouse_quarter,
                'emp_branch' => $request->emp_branch,
                'emp_department' => $request->emp_department,
                'emp_designation' => $request->emp_designation,
                'emp_reporting_auth' => $request->emp_reporting_auth,
                'emp_lv_sanc_auth' => $request->emp_lv_sanc_auth,
                'emp_eligible_promotion' => $request->emp_eligible_promotion,
                'emp_dob' => $request->emp_dob,
                'emp_doj' => $request->emp_doj,
                'emp_retirement_date' => $retire_date,
                'emp_next_increament_date' => date("Y-m-d", strtotime($request->emp_next_increment_date)),
                'emp_status' => $request->emp_status,
                'emp_shift_group' => $request->emp_sift_grp,
                'emp_from_date' => $request->emp_from_date,
                'emp_till_date' => $request->emp_till_date,
                'emp_x_qualification' => $request->emp_x_qualification,
                'emp_x_dicipline' => $request->emp_x_dicipline,
                'emp_x_institute_name' => $request->emp_x_inst_name,
                'emp_x_board_name' => $request->emp_x_board_name,
                'emp_x_pass_year' => $request->emp_x_pass_year,
                'emp_x_percentage' => $request->emp_x_percentage,
                'emp_x_rank' => $request->emp_x_rank,
                'emp_xii_qualification' => $request->emp_xii_qualification,
                'emp_xii_dicipline' => $request->emp_xii_dicipline,
                'emp_xii_institute_name' => $request->emp_xii_inst_name,
                'emp_xii_board_name' => $request->emp_xii_board_name,
                'emp_xii_pass_year' => $request->emp_xii_pass_year,
                'emp_xii_percentage' => $request->emp_xii_percentage,
                'emp_xii_rank' => $request->emp_xii_rank,
                'emp_graduate_qualification' => $request->emp_graduate_qualification,
                'emp_graduate_dicipline' => $request->emp_graduate_dicipline,
                'emp_graduate_institute_name' => $request->emp_graduate_inst_name,
                'emp_graduate_board_name' => $request->emp_graduate_board_name,
                'emp_graduate_pass_year' => $request->emp_graduate_pass_year,
                'emp_graduate_percentage' => $request->emp_graduate_percentage,
                'emp_graduate_rank' => $request->emp_graduate_rank,
                'emp_pgraduate_qualification' => $request->emp_pgraduate_qualification,
                'emp_pgraduate_dicipline' => $request->emp_pgraduate_dicipline,
                'emp_pgraduate_institute_name' => $request->emp_pgraduate_inst_name,
                'emp_pgraduate_board_name' => $request->emp_pgraduate_board_name,
                'emp_pgraduate_pass_year' => $request->emp_pgraduate_pass_year,
                'emp_pgraduate_percentage' => $request->emp_pgraduate_percentage,
                'emp_pgraduate_rank' => $request->emp_pgraduate_rank,
                'nominee_name_one' => $request->emp_nomination_name_one,
                'nominee_relationship_one' => $request->emp_nomination_relation_one,
                'nominee_dob_one' => $request->emp_nomination_dob_one,
                'nominee_name_two' => $request->emp_nomination_name_two,
                'emp_nomination_name_three' => $request->emp_nomination_name_three,
                'emp_nomination_name_four' => $request->emp_nomination_name_four,
                'nominee_dob_two' => $request->emp_nomination_dob_two,
                'emp_nomination_dob_three' => $request->emp_nomination_dob_three,
                'emp_nomination_dob_four' => $request->emp_nomination_dob_four,
                'emp_nomination_relation_three' => $request->emp_nomination_relation_three,
                'emp_nomination_relation_four' => $request->emp_nomination_relation_four,
                'emp_nomination_share_one' => $request->emp_nomination_share_one,
                'emp_nomination_share_two' => $request->emp_nomination_share_two,
                'emp_nomination_share_three' => $request->emp_nomination_share_three,
                'emp_nomination_share_four' => $request->emp_nomination_share_four,
                'emp_blood_group' => $request->emp_blood_grp,
                'emp_eye_sight_left' => $request->emp_eye_sight_left,
                'emp_eye_sight_right' => $request->emp_eye_sight_right,
                'emp_family_plan_status' => $request->emp_family_plan_status,
                'emp_family_plan_date' => $request->emp_family_plan_date,
                'emp_height' => $request->emp_height,
                'emp_weight' => $request->emp_weight,
                'emp_identification_mark_one' => $request->emp_identification_mark_one,
                'emp_identification_mark_two' => $request->emp_identification_mark_two,
                'emp_physical_status' => $request->emp_physical_status,

                'emp_per_village' => $request->emp_per_village,
                'emp_per_post_office' => $request->emp_per_post_office,
                'emp_per_policestation' => $request->emp_per_policestation,
                'emp_per_dist' => $request->emp_per_dist,
                'emp_pr_street_no' => $request->emp_pr_street_no,
                'emp_pr_city' => $request->emp_pr_city,
                'emp_pr_state' => $request->emp_pr_state,
                'emp_pr_country' => $request->emp_pr_country,
                'emp_pr_pincode' => $request->emp_pr_pincode,
                'emp_pr_mobile' => $request->emp_pr_mobile,
                'emp_ps_street_no' => $request->emp_ps_street_no,
                'emp_ps_village' => $request->emp_ps_village,
                'emp_ps_post_office' => $request->emp_ps_post_office,
                'emp_ps_policestation' => $request->emp_ps_policestation,
                'emp_ps_dist' => $request->emp_ps_dist,
                'emp_ps_city' => $request->emp_ps_city,
                'emp_ps_state' => $request->emp_ps_state,
                'emp_ps_country' => $request->emp_ps_country,
                'emp_ps_pincode' => $request->emp_ps_pincode,
                'emp_ps_phone' => $request->emp_ps_phone,
                'emp_ps_mobile' => $request->emp_ps_mobile,
                'emp_ps_email' => $request->emp_ps_email,
                'emp_grade' => $request->emp_grade,
                'emp_group_name' => $request->emp_group,
                'emp_pay_scale' => $request->emp_payscale,
                'emp_pension_no' => $request->emp_pension_no,
                'emp_pf_type' => $request->emp_pf_type,
                'emp_passport_no' => $request->emp_passport_no,
                'emp_time_office_code' => $request->emp_time_office_code,
                'emp_pf_no' => $request->emp_pf_no,
                'emp_uan_no' => $request->emp_uan_no,
                'emp_pan_no' => $request->emp_pan_no,
                'emp_payment_type' => $request->emp_payment_type,
                'emp_bank_name' => $request->emp_bank_name,
                'bank_branch_id' => $request->bank_branch_id,
                'emp_ifsc_code' => $request->emp_ifsc_code,
                'emp_account_no' => $request->emp_account_no,
                'emp_pension' => $request->emp_pension,
                'emp_pf_inactuals' => $request->emp_pf_inactuals,
                'emp_bonus' => $request->emp_bonus,
            );

            Employee::where('emp_code', $decrypted_empid)
                ->update($dataupdate);

            Employee_pay_structure::where('employee_code', $decrypted_empid)
                ->update($payupdate);

            if (isset($emp_pay)) {
                Emp_pay_structure::where('emply_code', $decrypted_empid)
                    ->forceDelete();
                Emp_pay_structure::insert($emp_pay);
            }
            if (isset($education)) {
                Education_details::where('employee_code', $decrypted_empid)
                    ->forceDelete();
                Education_details::insert($education);
            }
            Session::flash('message', 'Record has been successfully updated');

            return redirect('employees');
        } else {
            return redirect('/');
        }
    }

    public function savecahngepass(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $users = DB::table('users')->where('email', '=', $email)->first();
            $current_password = Session::get('adminpassword');
            //dd($current_password);
            $user_id = '';
            if (!empty($users)) {
                $user_id = $users->id;
            } else {
                Session::flash('error', 'User information not found. Try again later..');
                return redirect('employee-corner/employee-profile');
            }

            if ($request->old_password != $current_password) {
                Session::flash('error', 'Old Password Is Incorrect.');
                return redirect('employee-corner/employee-profile');
            } else {
                if ($request->new_password != $request->confirm_password) {

                    Session::flash('error', 'New Password and Cormfirm Password Are Not Same');
                    return redirect('employee-corner/employee-profile');

                } else {
                    if ($user_id != '') {

                        $password = Hash::make($request->new_password);
                        $dataimgperpa = array(
                            'password' => $password,
                        );
                        DB::table('users')
                            ->where('id', '=', $user_id)
                            ->update($dataimgperpa);
                        Session::flash('message', ' Password Changed Successfully.');
                        return redirect('employee-corner/employee-profile');
                    } else {
                        Session::flash('error', 'User information not found. Try again later..');
                        return redirect('employee-corner/employee-profile');
                    }
                }

            }
        } else {
            return redirect('/');
        }

    }

    public function empBankID($emp_bank_id)
    {
        if (!empty(Session::get('admin'))) {
            $employee_branch_name = Bank::where('bank_name', '=', $emp_bank_id)->get();
            return $employee_branch_name;
        } else {
            return redirect('/');
        }
    }

    // public function empBranchID($emp_branch_id)
    // {
    //     if (!empty(Session::get('admin'))) {

    //         $user_id = Session('admin')->employee_id;
    //         $data['employee'] = Employee::where('emp_code', '=', $user_id)->first();
    //         $data['employee_pay_structure'] = Employee_pay_structure::where('employee_code', '=', $user_id)->first();
    //         $data['bank_name'] = Bank_master::where('id', '=', $data['employee']->emp_bank_name)->first();

    //         $email = Session('admin')->email;
    //         $roledata = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

    //             ->select('role_authorizations.*', 'modules.module_name')
    //             ->where('member_id', '=', $email)
    //             ->get();

    //         $module_name = array();
    //         if (!empty($rdata)) {
    //             foreach ($roledata as $rdata) {
    //                 if (!in_array($rdata->module_name, $module_name)) {
    //                     $module_name[] = $rdata->module_name;
    //                 }
    //             }
    //             $result = "" . implode(", ", $module_name) . "";
    //         } else {
    //             $result = '';
    //         }

    //         $data['module_name'] = $result;
    //         return view('employee/user-profile', $data);
    //         $employee_ifsc_code = Bank::where('id', '=', $emp_branch_id)->first();
    //         echo json_encode($employee_ifsc_code);
    //     } else {
    //         return redirect('/');
    //     }
    // }

    public function empBranchID($emp_branch_id)
    {
        if (!empty(Session::get('admin'))) {
            $employee_ifsc_code = Bank::where('id', '=', $emp_branch_id)->first();
            echo json_encode($employee_ifsc_code);
        } else {
            return redirect('/');
        }
    }

    public function empPayID($emp_payscale_id)
    {
        if (!empty(Session::get('admin'))) {

            $employee_payscale = Pay_scale_basic_master::where('pay_scale_master_id', '=', $emp_payscale_id)->get();
            return $employee_payscale;
        } else {
            return redirect('/');
        }
    }

    public function companyID($companyid)
    {
        if (!empty(Session::get('admin'))) {

            $grade_rs = Grade::where('company_id', '=', $companyid)->get();
            //dd($grade_rs);
            $result = '<option value="" selected disabled >Select</option>';

            foreach ($grade_rs as $grade) {
                $result .= '<option value="' . $grade->id . '" >' . $grade->grade_name . '</option>';
            }
            echo $result;
        } else {
            return redirect('/');
        }
    }

    public function empTypecompanyID($companyid)
    {
        if (!empty(Session::get('admin'))) {

            $employee_type_rs = Employee_type::where('company_id', '=', $companyid)->get();
            //dd($grade_rs);
            $result = '<option value="" selected disabled >Select</option>';

            foreach ($employee_type_rs as $employee_type) {
                $result .= '<option value="' . $employee_type->id . '">' . $employee_type->employee_type_name . '</option>';
            }
            echo $result;
        } else {
            return redirect('/');
        }
    }

    public function promotionView()
    {

        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['employees'] = Employee::where('status', '=', 'active')->orderBy('emp_fname', 'asc')->get();
            $data['departments'] = Department::where('department_status', '=', 'active')->orderBy('department_name', 'asc')->get();

            $data['designations'] = Designation::where('designation_status', '=', 'active')->orderBy('designation_name', 'asc')->get();

            $data['payscale_master'] = Pay_scale_master::get();
            return view('employee/vw-promotion', $data);
        } else {
            return redirect('/');
        }
    }

    public function empDetails($empid, $month, $year)
    {
        if (!empty(Session::get('admin'))) {

            $mnth_yr = $month . '/' . $year;
            //$tomonthyr=date("Y-m-t");
            //$formatmonthyr=date("Y-m-01");
            $tomonthyr = $year . "-" . $month . "-31";
            $formatmonthyr = $year . "-" . $month . "-01";

            $employee_rs = Employee::leftJoin('employee_pay_structures', 'employee_pay_structures.employee_code', '=', 'employees.emp_code')
                ->where('employees.emp_code', '=', $empid)
                ->select('employees.*', 'employee_pay_structures.*')->first();

            $leave_rs = Leave_apply::leftJoin('leave_types', 'leave_types.id', '=', 'leave_applies.leave_type')
                ->where('leave_applies.employee_id', '=', $empid)
                ->where('leave_applies.status', '=', 'APPROVED')
                ->where('leave_applies.from_date', '>=', $formatmonthyr)
                ->where('leave_applies.to_date', '<=', $tomonthyr)
                ->select('leave_applies.*', 'leave_types.leave_type_name')
                ->get();

            $process_attendance = Process_attendance::where('process_attendances.employee_code', '=', $empid)
                ->where('process_attendances.month_yr', '=', $mnth_yr)
                ->first();
            //->toSql();

            $rate_rs = Rate_master::leftJoin('rate_details', 'rate_details.rate_id', '=', 'rate_masters.id')
                ->select('rate_details.*', 'rate_masters.head_name')
                ->get();
            echo json_encode(array($employee_rs, $leave_rs, $process_attendance, $rate_rs));
        } else {
            return redirect('/');
        }
    }

    public function savePromotion(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            // echo "<pre>";print_r($request->all()); exit;
            if (empty($request->emp_code)) {
                // The passwords matches
                Session::flash('message', 'Please Select a Employee 1st');
                return redirect()->back();
            }

            // DB::beginTransaction();
            Promotion_history::insert(
                array('emp_code' => $request->emp_code, 'emp_name' => $request->emp_name, 'current_emp_dept' => $request->current_emp_dept, 'current_emp_designation' => $request->current_emp_designation, 'current_emp_basic_pay' => $request->current_emp_basic_pay, 'present_emp_dept' => $request->present_emp_dept, 'present_emp_designation' => $request->present_emp_designation, 'present_emp_basic_pay' => $request->present_emp_basic_pay, 'date_of_promotion' => $request->date_of_promotion, 'created_at' => date('Y-m-d H:i:s'))
            );

            Employee::where('emp_code', '=', $request->emp_code)->update(['emp_department' => $request->present_emp_dept, 'emp_designation' => $request->present_emp_designation, 'emp_pay_scale' => $request->present_emp_payscale]);

            Employee_pay_structure::where('employee_code', '=', $request->emp_code)->update(['basic_pay' => $request->present_emp_basic_pay]);
            // DB::commit();
            Session::flash('message', 'Promotion Save Successfully');
            return redirect('promotion');
        } else {
            return redirect('/');
        }
    }

    public function viewPromotionReport()
    {

        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name')
                ->where('member_id', '=', $email)
                ->get();
            return view('employee/vw-promotion-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function reportPromotionReport(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $data['promotionreport'] = Promotion_history::where('date_of_promotion', '>=', $request->from_date)
                ->where('date_of_promotion', '<=', $request->to_date)
                ->get();
            //echo "<pre>";print_r($data['promotionreport']); exit;
            return view('employee/promotion-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function macpView()
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['employees'] = Employee::where('status', '=', 'active')->orderBy('emp_fname', 'asc')->get();
            $data['departments'] = Department::where('department_status', '=', 'active')->orderBy('department_name', 'asc')->get();

            $data['payscale_master'] = Pay_scale_master::get();
            return view('employee/vw-mcap', $data);
        } else {
            return redirect('/');
        }
    }

    public function saveMacp(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            //echo "<pre>";print_r($request->all()); exit;
            if (empty($request->emp_code)) {
                // The passwords matches
                Session::flash('message', 'Please Select a Employee 1st');
                return redirect()->back();
            }

            // DB::beginTransaction();
            Macp_history::insert(
                array('emp_code' => $request->emp_code, 'emp_name' => $request->emp_name, 'current_emp_dept' => $request->current_emp_dept, 'current_emp_designation' => $request->current_emp_designation, 'current_emp_basic_pay' => $request->current_emp_basic_pay, 'present_emp_basic_pay' => $request->present_emp_basic_pay, 'date_of_promotion' => $request->date_of_promotion, 'created_at' => date('Y-m-d H:i:s'))
            );

            Employee::where('emp_code', '=', $request->emp_code)->update(['emp_pay_scale' => $request->present_emp_payscale]);

            Employee_pay_structure::where('employee_code', '=', $request->emp_code)->update(['basic_pay' => $request->present_emp_basic_pay]);
            // DB::commit();
            Session::flash('message', 'Promotion Save Successfully');
            return redirect('macp');
        } else {
            return redirect('/');
        }
    }

    public function viewMcapReport()
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name')
                ->where('member_id', '=', $email)
                ->get();
            return view('employee/vw-macp-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function reportMcapReport(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $data['macpreport'] = Macp_history::where('date_of_promotion', '>=', $request->from_date)
                ->where('date_of_promotion', '<=', $request->to_date)
                ->orderByDesc('id')
                ->groupBy('emp_code')
                ->get();

            // if (!empty($data['macpreport'])) {

            //     foreach ($data['macpreport'] as $macp) {

            //         $data['designationpay'][] = Macp_history::where('emp_code', '=', $macp->emp_code)->orderBy('id', 'desc')->first();
            //     }
            // }
            // print_r($data['macpreport']);
            // die();

            // echo "<pre>";print_r($data['macpreport']); exit;
            return view('employee/macp-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewIncrement()
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name')
                ->where('member_id', '=', $email)
                ->get();
            return view('employee/vw-increment', $data);
        } else {
            return redirect('/');
        }
    }

    public function reportIncrement(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $data['allincrements'] = Increment_history::leftJoin('employees', 'increment_histories.emp_code', '=', 'employees.emp_code')
                ->select('increment_histories.*', 'employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname', 'employees.emp_designation', 'employees.emp_next_increament_date')
            //->where('DATE_FORMAT(increment_history.approve_date, "%d-%M-%Y")','=',$request->month_yr)
                ->where(Increment_history::raw("(DATE_FORMAT(increment_histories.approve_date,'%Y'))"), $request->month_yr)
                ->get();
            // print_r($data['allincrements']); exit;
            return view('employee/increment-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function getEmployeeById()
    {
        if (!empty(Session::get('admin'))) {

            $user_id = Session('admin')->employee_id;
            $data['employee'] = Employee::where('emp_code', '=', $user_id)->first();

            if (!empty($data['employee'])) {
                $data['employee_re'] = Employee::where('emp_code', '=', $data['employee']->emp_reporting_auth)->first();
                $data['employee_sa'] = Employee::where('emp_code', '=', $data['employee']->emp_lv_sanc_auth)->first();
                $data['employee_pay_structure'] = Employee_pay_structure::where('employee_code', '=', $user_id)->first();
                $data['bank_name'] = Bank_master::where('id', '=', $data['employee']->emp_bank_name)->first();
            }

            $email = Session('admin')->email;
            $roledata = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->select('role_authorizations.*', 'modules.module_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            $module_name = array();
            if (!empty($roledata)) {
                foreach ($roledata as $rdata) {
                    if (!in_array($rdata->module_name, $module_name)) {
                        $module_name[] = $rdata->module_name;
                    }
                }
                $result = "" . implode(", ", $module_name) . "";
            } else {
                $result = '';
            }
            $data['module_name'] = $result;
            // print_r(Session('admin')->user_type);
            // die();
            return view('employee/user-profile', $data);
        } else {
            return redirect('/');
        }
    }

    public function getPfDetails()
    {
        if (!empty(Session::get('admin'))) {

            $email = Session('admin')->email;
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $empid = Session('admin')->employee_id;

            $data['gpf_details'] = Gpf_details::leftjoin('employees', 'gpf_details.emp_code', '=', 'employees.emp_code')
                ->where('gpf_details.emp_code', '=', $empid)
                ->select('gpf_details.*', 'employees.emp_pf_no')
                ->orderByDesc('gpf_details.id')
                ->get();

            // dd($data['gpf_details']);

            return view('leave/vw-gpf-details', $data);
        } else {
            return redirect('/');
        }
    }

    public function getPensionDetails()
    {
        if (!empty(Session::get('admin'))) {

            $email = Session('admin')->email;
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $empid = Session('admin')->employee_id;

            $employee_details = Employee::where('emp_code', '=', $empid)

                ->first();

            $employee_pension = Pension::where('emp_code', '=', $empid)

                ->first();
            $nextdate = date('Y-m-d', strtotime("-3 months", strtotime($employee_details->emp_retirement_date)));

            if ($nextdate <= date('Y-m-d') && $employee_details->emp_retirement_date >= date('Y-m-d')) {

                if (empty($employee_pension)) {
                    $data['employee_rs'] = Employee::leftJoin('employee_pay_structures', 'employees.emp_code', '=', 'employee_pay_structures.employee_code')
                        ->where('employees.emp_code', '=', $empid)
                        ->select('employees.*', 'employee_pay_structures.*')
                        ->get();
                } else {
                    Session::flash('error', 'Your data is alreday saved');

                    return redirect('employee-corner/dashboard');
                    // $data['employee_rs'] = DB::table('pension')
                    // ->join('employee_pay_structure', 'pension.emp_code', '=', 'employee_pay_structure.employee_code')
                    // ->where('pension.emp_code','=',$empid)
                    // ->select('pension.*', 'employee_pay_structure.*')
                    // ->get();
                }

                $data['department'] = Department::where('department_status', '=', 'active')->get();
                $data['designation'] = Designation::where('designation_status', '=', 'active')->get();
                $data['cast'] = Cast::where('cast_status', '=', 'active')->get();
                $data['sub_cast'] = Sub_cast::where('sub_cast_status', '=', 'active')->get();
                $data['religion'] = Religion::get();
                $data['employee_type'] = Employee_type::where('employee_type_status', '=', 'active')->get();
                $data['grade'] = Grade::where('grade_status', '=', 'active')->get();
                $data['bank'] = Bank_master::get();
                $data['payscale_master'] = Pay_scale_master::get();
                $data['states'] = State_master::get();
                $data['employeelists'] = Employee::where('emp_status', '!=', 'TEMPORARY')
                    ->where('emp_status', '!=', 'EX-EMPLOYEE')->where('emp_status', '!=', 'EX- EMPLOYEE')->get();
                return view('leave/vw-pension-details', $data);
            } else {

                Session::flash('error', 'You are not applicable for pension right now');

                return redirect('employee-corner/dashboard');
            }
        } else {
            return redirect('/');
        }
    }

    public function savePension(Request $request)
    {

        if (!empty(Session::get('admin'))) {

            $email = Session('admin')->email;
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            if ($request->hasFile('emp_image')) {
                $files = $request->file('emp_image');
                $extension = $request->emp_image->extension();
                $filename = $request->emp_image->store('emp_pic', 'public');
            } else {

                $filename = $request->old_image;
            }

            $id = Session('admin')->employee_id;
            $employee_pension = Pension::where('emp_code', '=', $id)

                ->first();
            $employee_details = Employee::where('emp_code', '=', $id)

                ->first();

            $employee_pid = Pension::orderBy('id', 'DESC')

                ->first();
            if (empty($employee_pid)) {
                $pid = 'P1';
            } else {
                $pid = 'P' . ($employee_pid->id + 1);
            }

            if (!empty($employee_pension->id)) {
                $decrypted_empid = $id;
                $retiredate = $request->emp_retirement_date;
                $date = str_replace('/', '-', $retiredate);
                $retirementdate = date_create($date);
                $retire_date = date_format($retirementdate, 'Y-m-d');

                $dataupdate = array(
                    'emp_code' => $request->emp_code,
                    'emp_fname' => strtoupper($request->emp_fname),
                    'emp_mname' => strtoupper($request->emp_mid_name),
                    'emp_lname' => strtoupper($request->emp_lname),
                    'emp_father_name' => strtoupper($request->emp_father_name),
                    'emp_aadhar_no' => $request->emp_aadhar_no,
                    'emp_present_city_class' => $request->emp_present_city,
                    'emp_residential_distance' => $request->emp_resdential_distance,
                    'emp_home_town' => $request->emp_home_town,
                    'emp_nearest_railway' => $request->emp_nearest_railway,
                    'emp_caste' => $request->emp_caste,
                    'emp_sub_caste' => $request->emp_sub_caste,
                    'emp_religion' => $request->emp_religion,
                    'emp_spouse_working_status' => $request->emp_spouse_working,
                    'emp_image' => $filename,
                    'emp_government' => $request->emp_government,
                    'emp_spouse_quarter' => $request->emp_spouse_quarter,
                    'emp_branch' => $request->emp_branch,
                    'emp_department' => $request->emp_department,
                    'emp_designation' => $request->emp_designation,
                    'emp_reporting_auth' => $employee_details->emp_reporting_auth,
                    'emp_lv_sanc_auth' => $request->emp_lv_sanc_auth,
                    'emp_eligible_promotion' => $request->emp_eligible_promotion,
                    'emp_dob' => $request->emp_dob,
                    'emp_doj' => $request->emp_doj,
                    'emp_retirement_date' => $retire_date,
                    'emp_next_increament_date' => date("Y-m-d", strtotime($request->emp_next_increment_date)),
                    'emp_status' => $request->emp_status,
                    'emp_shift_group' => $request->emp_sift_grp,
                    'emp_from_date' => $request->emp_from_date,
                    'emp_till_date' => $request->emp_till_date,
                    'emp_x_qualification' => $request->emp_x_qualification,
                    'emp_x_dicipline' => $request->emp_x_dicipline,
                    'emp_x_institute_name' => $request->emp_x_inst_name,
                    'emp_x_board_name' => $request->emp_x_board_name,
                    'emp_x_pass_year' => $request->emp_x_pass_year,
                    'emp_x_percentage' => $request->emp_x_percentage,
                    'emp_x_rank' => $request->emp_x_rank,
                    'emp_xii_qualification' => $request->emp_xii_qualification,
                    'emp_xii_dicipline' => $request->emp_xii_dicipline,
                    'emp_xii_institute_name' => $request->emp_xii_inst_name,
                    'emp_xii_board_name' => $request->emp_xii_board_name,
                    'emp_xii_pass_year' => $request->emp_xii_pass_year,
                    'emp_xii_percentage' => $request->emp_xii_percentage,
                    'emp_xii_rank' => $request->emp_xii_rank,
                    'emp_graduate_qualification' => $request->emp_graduate_qualification,
                    'emp_graduate_dicipline' => $request->emp_graduate_dicipline,
                    'emp_graduate_institute_name' => $request->emp_graduate_inst_name,
                    'emp_graduate_board_name' => $request->emp_graduate_board_name,
                    'emp_graduate_pass_year' => $request->emp_graduate_pass_year,
                    'emp_graduate_percentage' => $request->emp_graduate_percentage,
                    'emp_graduate_rank' => $request->emp_graduate_rank,
                    'emp_pgraduate_qualification' => $request->emp_pgraduate_qualification,
                    'emp_pgraduate_dicipline' => $request->emp_pgraduate_dicipline,
                    'emp_pgraduate_institute_name' => $request->emp_pgraduate_inst_name,
                    'emp_pgraduate_board_name' => $request->emp_pgraduate_board_name,
                    'emp_pgraduate_pass_year' => $request->emp_pgraduate_pass_year,
                    'emp_pgraduate_percentage' => $request->emp_pgraduate_percentage,
                    'emp_pgraduate_rank' => $request->emp_pgraduate_rank,
                    'nominee_name_one' => $request->emp_nomination_name_one,
                    'nominee_relationship_one' => $request->emp_nomination_relation_one,
                    'nominee_dob_one' => $request->emp_nomination_dob_one,
                    'nominee_name_two' => $request->emp_nomination_name_two,
                    'emp_nomination_name_three' => $request->emp_nomination_name_three,
                    'emp_nomination_name_four' => $request->emp_nomination_name_four,
                    'nominee_dob_two' => $request->emp_nomination_dob_two,
                    'emp_nomination_dob_three' => $request->emp_nomination_dob_three,
                    'emp_nomination_dob_four' => $request->emp_nomination_dob_four,
                    'emp_nomination_relation_three' => $request->emp_nomination_relation_three,
                    'emp_nomination_relation_four' => $request->emp_nomination_relation_four,
                    'emp_nomination_share_one' => $request->emp_nomination_share_one,
                    'emp_nomination_share_two' => $request->emp_nomination_share_two,
                    'emp_nomination_share_three' => $request->emp_nomination_share_three,
                    'emp_nomination_share_four' => $request->emp_nomination_share_four,
                    'emp_blood_group' => $request->emp_blood_grp,
                    'emp_eye_sight_left' => $request->emp_eye_sight_left,
                    'emp_eye_sight_right' => $request->emp_eye_sight_right,
                    'emp_family_plan_status' => $request->emp_family_plan_status,
                    'emp_family_plan_date' => $request->emp_family_plan_date,
                    'emp_height' => $request->emp_height,
                    'emp_weight' => $request->emp_weight,
                    'emp_identification_mark_one' => $request->emp_identification_mark_one,
                    'emp_identification_mark_two' => $request->emp_identification_mark_two,
                    'emp_physical_status' => $request->emp_physical_status,
                    'emp_pr_street_no' => $request->emp_pr_street_no,
                    'emp_pr_city' => $request->emp_pr_city,
                    'emp_pr_state' => $request->emp_pr_state,
                    'emp_pr_country' => $request->emp_pr_country,
                    'emp_pr_pincode' => $request->emp_pr_pincode,
                    'emp_pr_mobile' => $request->emp_pr_mobile,
                    'emp_ps_street_no' => $request->emp_ps_street_no,
                    'emp_ps_city' => $request->emp_ps_city,
                    'emp_ps_state' => $request->emp_ps_state,
                    'emp_ps_country' => $request->emp_ps_country,
                    'emp_ps_pincode' => $request->emp_ps_pincode,
                    'emp_ps_phone' => $request->emp_ps_phone,
                    'emp_ps_mobile' => $request->emp_ps_mobile,
                    'emp_ps_email' => $request->emp_ps_email,
                    'emp_grade' => $request->emp_grade,
                    'emp_group_name' => $request->emp_group,
                    'emp_pay_scale' => $request->emp_payscale,
                    'emp_pension_no' => $request->emp_pension_no,
                    'emp_pf_type' => $request->emp_pf_type,
                    'emp_passport_no' => $request->emp_passport_no,
                    'emp_time_office_code' => $request->emp_time_office_code,
                    'emp_pf_no' => $request->emp_pf_no,
                    'emp_pan_no' => $request->emp_pan_no,
                    'emp_payment_type' => $request->emp_payment_type,
                    'emp_bank_name' => $request->emp_bank_name,
                    'bank_branch_id' => $request->bank_branch_id,
                    'emp_ifsc_code' => $request->emp_ifsc_code,
                    'emp_account_no' => $request->emp_account_no,
                    'nominee_relationship_address' => $request->nominee_relationship_address,
                    'nominee_relationship_address_two' => $request->nominee_relationship_address_two,
                    'commuted_status' => $request->commuted_status,
                    'commuted_value' => $request->commuted_value,

                    'emp_per_village' => $request->emp_per_village,
                    'emp_per_post_office' => $request->emp_per_post_office,
                    'emp_per_policestation' => $request->emp_per_policestation,
                    'emp_per_dist' => $request->emp_per_dist,
                    'emp_ps_village' => $request->emp_ps_village,
                    'emp_ps_post_office' => $request->emp_ps_post_office,
                    'emp_ps_policestation' => $request->emp_ps_policestation,
                    'emp_ps_dist' => $request->emp_ps_dist,
                    'emp_ps_dist' => $request->emp_ps_dist,
                    'emp_basic_pay' => $request->emp_basic_pay,

                );

                DB::table('pension')
                    ->where('emp_code', $decrypted_empid)
                    ->update($dataupdate);

                Session::flash('message', 'Record has been successfully updated');
                return redirect('pis/pension');
            } else {

                $retiredate = $request->emp_retirement_date;
                $date = str_replace('/', '-', $retiredate);
                $retirementdate = date_create($date);
                $retire_date = date_format($retirementdate, 'Y-m-d');

                $data = array(
                    'emp_code' => $request->emp_code,
                    'emp_fname' => strtoupper($request->emp_fname),
                    'emp_mname' => strtoupper($request->emp_mid_name),
                    'emp_lname' => strtoupper($request->emp_lname),
                    'emp_father_name' => strtoupper($request->emp_father_name),
                    'emp_aadhar_no' => $request->emp_aadhar_no,
                    'emp_present_city_class' => $request->emp_present_city,
                    'emp_residential_distance' => $request->emp_resdential_distance,
                    'emp_home_town' => $request->emp_home_town,
                    'emp_nearest_railway' => $request->emp_nearest_railway,
                    'emp_caste' => $request->emp_caste,
                    'emp_sub_caste' => $request->emp_sub_caste,
                    'emp_religion' => $request->emp_religion,
                    'emp_image' => $filename,
                    'emp_spouse_working_status' => $request->emp_spouse_working,
                    'emp_government' => $request->emp_government,
                    'emp_spouse_quarter' => $request->emp_spouse_quarter,
                    'emp_branch' => $request->emp_branch,
                    'emp_department' => $request->emp_department,
                    'emp_designation' => $request->emp_designation,
                    'emp_reporting_auth' => $employee_details->emp_reporting_auth,
                    'emp_lv_sanc_auth' => $request->emp_lv_sanc_auth,
                    'emp_eligible_promotion' => $request->emp_eligible_promotion,
                    'emp_dob' => $request->emp_dob,
                    'emp_doj' => $request->emp_doj,
                    'emp_retirement_date' => $retire_date,
                    'emp_next_increament_date' => date("Y-m-d", strtotime($request->emp_next_increment_date)),
                    'emp_status' => $request->emp_status,
                    'emp_shift_group' => $request->emp_sift_grp,
                    'emp_from_date' => $request->emp_from_date,
                    'emp_till_date' => $request->emp_till_date,
                    'emp_x_qualification' => $request->emp_x_qualification,
                    'emp_x_dicipline' => $request->emp_x_dicipline,
                    'emp_x_institute_name' => $request->emp_x_inst_name,
                    'emp_x_board_name' => $request->emp_x_board_name,
                    'emp_x_pass_year' => $request->emp_x_pass_year,
                    'emp_x_percentage' => $request->emp_x_percentage,
                    'emp_x_rank' => $request->emp_x_rank,
                    'emp_xii_qualification' => $request->emp_xii_qualification,
                    'emp_xii_dicipline' => $request->emp_xii_dicipline,
                    'emp_xii_institute_name' => $request->emp_xii_inst_name,
                    'emp_xii_board_name' => $request->emp_xii_board_name,
                    'emp_xii_pass_year' => $request->emp_xii_pass_year,
                    'emp_xii_percentage' => $request->emp_xii_percentage,
                    'emp_xii_rank' => $request->emp_xii_rank,
                    'emp_graduate_qualification' => $request->emp_graduate_qualification,
                    'emp_graduate_dicipline' => $request->emp_graduate_dicipline,
                    'emp_graduate_institute_name' => $request->emp_graduate_inst_name,
                    'emp_graduate_board_name' => $request->emp_graduate_board_name,
                    'emp_graduate_pass_year' => $request->emp_graduate_pass_year,
                    'emp_graduate_percentage' => $request->emp_graduate_percentage,
                    'emp_graduate_rank' => $request->emp_graduate_rank,
                    'emp_pgraduate_qualification' => $request->emp_pgraduate_qualification,
                    'emp_pgraduate_dicipline' => $request->emp_pgraduate_dicipline,
                    'emp_pgraduate_institute_name' => $request->emp_pgraduate_inst_name,
                    'emp_pgraduate_board_name' => $request->emp_pgraduate_board_name,
                    'emp_pgraduate_pass_year' => $request->emp_pgraduate_pass_year,
                    'emp_pgraduate_percentage' => $request->emp_pgraduate_percentage,
                    'emp_pgraduate_rank' => $request->emp_pgraduate_rank,
                    'nominee_name_one' => $request->emp_nomination_name_one,
                    'nominee_relationship_one' => $request->emp_nomination_relation_one,
                    'nominee_dob_one' => $request->emp_nomination_dob_one,
                    'nominee_name_two' => $request->emp_nomination_name_two,
                    'emp_nomination_name_three' => $request->emp_nomination_name_three,
                    'emp_nomination_name_four' => $request->emp_nomination_name_four,
                    'nominee_relationship_two' => $request->emp_nomination_relation_two,
                    'emp_nomination_relation_three' => $request->emp_nomination_relation_three,
                    'emp_nomination_relation_four' => $request->emp_nomination_relation_four,
                    'nominee_dob_two' => $request->emp_nomination_dob_two,
                    'emp_nomination_dob_three' => $request->emp_nomination_dob_three,
                    'emp_nomination_dob_four' => $request->emp_nomination_dob_four,
                    'emp_nomination_share_one' => $request->emp_nomination_share_one,
                    'emp_nomination_share_two' => $request->emp_nomination_share_two,
                    'emp_nomination_share_three' => $request->emp_nomination_share_three,
                    'emp_nomination_share_four' => $request->emp_nomination_share_four,
                    'emp_blood_group' => $request->emp_blood_grp,
                    'emp_eye_sight_left' => $request->emp_eye_sight_left,
                    'emp_eye_sight_right' => $request->emp_eye_sight_right,
                    'emp_family_plan_status' => $request->emp_family_plan_status,
                    'emp_family_plan_date' => $request->emp_family_plan_date,
                    'emp_height' => $request->emp_height,
                    'emp_weight' => $request->emp_weight,
                    'emp_identification_mark_one' => $request->emp_identification_mark_one,
                    'emp_identification_mark_two' => $request->emp_identification_mark_two,
                    'emp_physical_status' => $request->emp_physical_status,
                    'emp_pr_street_no' => $request->emp_pr_street_no,
                    'emp_pr_city' => $request->emp_pr_city,
                    'emp_pr_state' => $request->emp_pr_state,
                    'emp_pr_country' => $request->emp_pr_country,
                    'emp_pr_pincode' => $request->emp_pr_pincode,
                    'emp_pr_mobile' => $request->emp_pr_mobile,
                    'emp_ps_street_no' => $request->emp_ps_street_no,
                    'emp_ps_city' => $request->emp_ps_city,
                    'emp_ps_state' => $request->emp_ps_state,
                    'emp_ps_country' => $request->emp_ps_country,
                    'emp_ps_pincode' => $request->emp_ps_pincode,
                    'emp_ps_phone' => $request->emp_ps_phone,
                    'emp_ps_mobile' => $request->emp_ps_mobile,
                    'emp_ps_email' => $request->emp_ps_email,
                    'emp_grade' => $request->emp_grade,
                    'emp_group_name' => $request->emp_group,
                    'emp_pay_scale' => $request->emp_payscale,
                    'emp_pension_no' => $request->emp_pension_no,
                    'emp_pf_type' => $request->emp_pf_type,
                    'emp_passport_no' => $request->emp_passport_no,
                    'emp_time_office_code' => $request->emp_time_office_code,
                    'emp_pf_no' => $request->emp_pf_no,
                    'emp_pan_no' => $request->emp_pan_no,
                    'emp_payment_type' => $request->emp_payment_type,
                    'emp_bank_name' => $request->emp_bank_name,
                    'bank_branch_id' => $request->bank_branch_id,
                    'emp_ifsc_code' => $request->emp_ifsc_code,
                    'emp_account_no' => $request->emp_account_no,
                    'nominee_relationship_address' => $request->nominee_relationship_address,
                    'nominee_relationship_address_two' => $request->nominee_relationship_address_two,
                    'commuted_status' => $request->commuted_status,
                    'commuted_value' => $request->commuted_value,
                    'emp_per_village' => $request->emp_per_village,
                    'emp_per_post_office' => $request->emp_per_post_office,
                    'emp_per_policestation' => $request->emp_per_policestation,
                    'emp_per_dist' => $request->emp_per_dist,
                    'emp_ps_village' => $request->emp_ps_village,
                    'emp_ps_post_office' => $request->emp_ps_post_office,
                    'emp_ps_policestation' => $request->emp_ps_policestation,
                    'emp_ps_dist' => $request->emp_ps_dist,
                    'pid' => $pid,
                    'emp_basic_pay' => $request->emp_basic_pay,
                );

                Pension::insert($data);
                Session::flash('message', 'Pension has been successfully saved');
                return redirect('employee-corner/dashboard');
                // return redirect('pis/employee');
            }
        } else {
            return redirect('/');
        }
    }

    public function ajaxAddRow($row)
    {

        $data['education'] = Education_master::get();
        // $data['education'] = Education_master::get();
        $row = $row + 1;

        $result = ' <tr class="itemslot" id="' . $row . '" >
					    <td>' . $row . '</td>
                        <td>

                        <select class="form-control" name="qualification[]" id="qualification' . $row . '">

                        <option value="" selected>Select</option>';

        foreach ($data['education'] as $educ) {

            $result .= '<option value="' . $educ->id . '">' . $educ->education . '</option>';
        }

        $result .= '</select>

        </td>
        <td><input type="text" name="discipline[]" value="" class="form-control"></td>
        <td><input type="text" name="institute_name[]" value="" class="form-control"></td>
        <td><input type="text" name="university[]" value="" class="form-control"></td>
        <td><input type="text" name="year_of_passing[]" value="" class="form-control"></td>
        <td><input type="text" name="percentage[]" value="" class="form-control"></td>
        <td><input type="text" name="grade[]" value="" class="form-control"></td>


          <td><button class="btn-success" style="margin-bottom: 5px;" type="button" id="add' . $row . '" onClick="addnewrow(' . $row . ')" data-id="' . $row . '"> <i class="ti-plus"></i> </button>
         <button class="btn-danger deleteButton" style="background-color:#E70B0E; border-color:#E70B0E;" type="button" id="del' . $row . '"  onClick="delRow(' . $row . ')"> <i class="ti-minus"></i> </button></td>
      </tr>';

        echo $result;
    }

    public function EmpDepartment($emp_department)
    {
        $department = Department::where('department_name', '=', $emp_department)
            ->where('department_status', '=', 'active')

            ->first();
        $designation = Designation::where('department_code', '=', $department->id)
            ->where('designation_status', '=', 'active')

            ->get();
        $result = '';

        $result_status1 = " <option value='' selected disabled >Select</option> ";
        foreach ($designation as $val) {
            $result_status1 .= '<option value="' . $val->designation_name . '"> ' . $val->designation_name . '</option>';
        }

        echo $result_status1;
    }

    public function ajaxAddRowearn($row)
    {

        $data['rate_master'] = Rate_master::get();

        $rownew = $row + 1;

        $result = ' <tr class="itemslotpayearn" id="' . $row . '" >
					    <td>' . $rownew . '</td>
                        <td>

                       <select class="form-control earninigcls" name="name_earn[]" id="name_earn' . $row . '" onchange="checkearntype(this.value,' . $row . ');">

									<option value="" selected>Select</option>';

        foreach ($data['rate_master'] as $value) {
            if ($value->id == '1') {
                $name = 'da';
            } else if ($value->id == '2') {
                $name = 'vda';
            } else if ($value->id == '3') {
                $name = 'hra';
            } else if ($value->id == '4') {
                $name = 'prof_tax';
            } else if ($value->id == '5') {
                $name = 'others_alw';
            } else if ($value->id == '6') {
                $name = 'tiff_alw';
            } else if ($value->id == '7') {
                $name = 'conv';
            } else if ($value->id == '8') {
                $name = 'medical';
            } else if ($value->id == '9') {
                $name = 'misc_alw';
            } else if ($value->id == '10') {
                $name = 'over_time';
            } else if ($value->id == '11') {
                $name = 'bouns';
            } else if ($value->id == '12') {
                $name = 'leave_inc';
            } else if ($value->id == '13') {
                $name = 'hta';
            } else if ($value->id == '14') {
                $name = 'tot_inc';
            } else if ($value->id == '15') {
                $name = 'pf';
            } else if ($value->id == '16') {
                $name = 'pf_int';
            } else if ($value->id == '17') {
                $name = 'apf';
            } else if ($value->id == '18') {
                $name = 'i_tax';
            } else if ($value->id == '19') {
                $name = 'insu_prem';
            } else if ($value->id == '20') {
                $name = 'pf_loan';
            } else if ($value->id == '21') {
                $name = 'esi';
            } else if ($value->id == '22') {
                $name = 'adv';
            } else if ($value->id == '23') {
                $name = 'hrd';
            } else if ($value->id == '24') {
                $name = 'co_op';
            } else if ($value->id == '25') {
                $name = 'furniture';
            } else if ($value->id == '26') {
                $name = 'misc_ded';
            } else if ($value->id == '27') {
                $name = 'tot_ded';
            }
            if ($value->head_type == 'earning') {

                $result .= '<option value="' . $name . '">' . $value->head_name . '</option>';
            }
        }

        $result .= '</select>

        </td>
        <td><select class="form-control" name="head_type[]" id="head_type' . $row . '" onchange="checkearnvalue(this.value,' . $row . ');">

									<option value="" selected>Select</option>
									<option value="F">Fixed</option>
									<option value="V">Variable</option>
									</select></td>
        <td><input type="text" name="value[]"  id="value' . $row . '" class="form-control"></td>



         <td><button class="btn-success" style="" type="button" id="addearn' . $rownew . '" onClick="addnewrowearn(' . $rownew . ')" data-id="earn' . $rownew . '"> <i class="ti-plus"></i> </button>
         <button class="btn-danger deleteButtonearn" style="background-color:#E70B0E; border-color:#E70B0E;" type="button" id="delearn' . $row . '"  onClick="delRowearn(' . $row . ')"> <i class="ti-minus"></i> </button></td>
      </tr>';

        echo $result;
    }

    public function ajaxAddRowdeduct($row)
    {

        $data['rate_master'] = Rate_master::get();

        $rownew = $row + 1;

        $result = ' <tr class="itemslotpaydeduct" id="' . $row . '" >
					    <td>' . $rownew . '</td>
                        <td>

                       <select class="form-control deductcls" name="name_deduct[]" id="name_deduct' . $row . '" onchange="checkdeducttype(this.value,' . $row . ');">

									<option value="" selected>Select</option>';

        foreach ($data['rate_master'] as $value) {
            if ($value->id == '1') {
                $name = 'da';
            } else if ($value->id == '2') {
                $name = 'vda';
            } else if ($value->id == '3') {
                $name = 'hra';
            } else if ($value->id == '4') {
                $name = 'prof_tax';
            } else if ($value->id == '5') {
                $name = 'others_alw';
            } else if ($value->id == '6') {
                $name = 'tiff_alw';
            } else if ($value->id == '7') {
                $name = 'conv';
            } else if ($value->id == '8') {
                $name = 'medical';
            } else if ($value->id == '9') {
                $name = 'misc_alw';
            } else if ($value->id == '10') {
                $name = 'over_time';
            } else if ($value->id == '11') {
                $name = 'bouns';
            } else if ($value->id == '12') {
                $name = 'leave_inc';
            } else if ($value->id == '13') {
                $name = 'hta';
            } else if ($value->id == '14') {
                $name = 'tot_inc';
            } else if ($value->id == '15') {
                $name = 'pf';
            } else if ($value->id == '16') {
                $name = 'pf_int';
            } else if ($value->id == '17') {
                $name = 'apf';
            } else if ($value->id == '18') {
                $name = 'i_tax';
            } else if ($value->id == '19') {
                $name = 'insu_prem';
            } else if ($value->id == '20') {
                $name = 'pf_loan';
            } else if ($value->id == '21') {
                $name = 'esi';
            } else if ($value->id == '22') {
                $name = 'adv';
            } else if ($value->id == '23') {
                $name = 'hrd';
            } else if ($value->id == '24') {
                $name = 'co_op';
            } else if ($value->id == '25') {
                $name = 'furniture';
            } else if ($value->id == '26') {
                $name = 'misc_ded';
            } else if ($value->id == '27') {
                $name = 'tot_ded';
            } else if ($value->id == '29') {
                $name = 'pf_employerc';

            } else if ($value->id == '31') {
                $name = 'tds';
            }
            if ($value->head_type == 'deduction') {

                $result .= '<option value="' . $name . '">' . $value->head_name . '</option>';
            }
        }

        $result .= '</select>

        </td>
        <td><select class="form-control" name="head_typededuct[]" id="head_typededuct' . $row . '" onchange="checkdeductvalue(this.value,' . $row . ');">

									<option value="" selected>Select</option>
									<option value="F">Fixed</option>
									<option value="V">Variable</option>
									</select></td>
        <td><input type="text" name="valuededuct[]"  id="valuededuct' . $row . '" class="form-control"></td>



          <td><button class="btn-success" style="" type="button" id="adddeduct' . $rownew . '" onClick="addnewrowdeduct(' . $rownew . ')" data-id="deduct' . $row . '"> <i class="ti-plus"></i> </button>
         <button class="btn-danger deleteButtondeduct" style="background-color:#E70B0E; border-color:#E70B0E;" type="button" id="deldeduct' . $row . '"  onClick="delRowdeduct(' . $row . ')"> <i class="ti-minus"></i> </button></td>
      </tr>';

        echo $result;
    }

    public function ajaxAddvalue($headname, $val, $emp_basic_pay)
    {

        if ($headname == 'da') {
            $id = '1';
        } else if ($headname == 'vda') {
            $id = '2';
        } else if ($headname == 'hra') {
            $id = '3';

        } else if ($headname == 'prof_tax') {
            $id = '4';

        } else if ($headname == 'others_alw') {
            $id = '5';
        } else if ($headname == 'tiff_alw') {
            $id = '6';
        } else if ($headname == 'conv') {
            $id = '7';
        } else if ($headname == 'medical') {
            $id = '8';
        } else if ($headname == 'misc_alw') {
            $id = '9';
        } else if ($headname == 'over_time') {
            $id = '10';
        } else if ($headname == 'bouns') {
            $id = '11';
        } else if ($headname == 'leave_inc') {
            $id = '12';

        } else if ($headname == 'hta') {
            $id = '13';

        } else if ($headname == 'tot_inc') {
            $id = '14';

        } else if ($headname == 'pf') {
            $id = '15';

        } else if ($headname == 'pf_int') {
            $id = '16';
        } else if ($headname == 'apf') {
            $id = '17';
        } else if ($headname == 'i_tax') {
            $id = '18';
        } else if ($headname == 'insu_prem') {
            $id = '19';
        } else if ($headname == 'pf_loan') {
            $id = '20';
        } else if ($headname == 'esi') {
            $id = '21';
        } else if ($headname == 'adv') {
            $id = '22';
        } else if ($headname == 'hrd') {
            $id = '23';
        } else if ($headname == 'co_op') {
            $id = '24';
        } else if ($headname == 'furniture') {
            $id = '25';
        } else if ($headname == 'misc_ded') {
            $id = '26';
        } else if ($headname == 'tot_ded') {
            $id = '27';
        } else if ($headname == 'pf_employerc') {
            $id = '29';

        } else if ($headname == 'tds') {
            $id = '31';
        }

        if ($id == '4') {
            $rate_details = Rate_details::leftJoin('rate_masters', 'rate_masters.id', '=', 'rate_details.rate_id')
                ->select('rate_details.*', 'rate_masters.head_name', 'rate_masters.head_type')
                ->where('rate_details.from_date', '>=', date('Y-01-01'))
                ->where('rate_details.to_date', '<=', date('Y-12-31'))
                ->where('rate_details.rate_id', '=', $id)

                ->get();
            $result = "0";
            //dd($emp_basic_pay);
            foreach ($rate_details as $val) {
                if ($val->inpercentage != '0') {
                    $result = ($emp_basic_pay * $val->inpercentage / 100);
                } else {

                    if (($emp_basic_pay <= $val->max_basic) && ($emp_basic_pay >= $val->min_basic)) {
                        $result = $val->inrupees;

                    }
                    if (($emp_basic_pay >= $val->max_basic) && ($emp_basic_pay <= $val->min_basic)) {
                        $result = $val->inrupees;
                    }

                }

            }

        } else {
            $rate_details = Rate_details::leftJoin('rate_masters', 'rate_masters.id', '=', 'rate_details.rate_id')
                ->select('rate_details.*', 'rate_masters.head_name', 'rate_masters.head_type')
                ->where('rate_details.from_date', '>=', date('Y-01-01'))
                ->where('rate_details.to_date', '<=', date('Y-12-31'))
                ->where('rate_details.rate_id', '=', $id)

                ->first();

            if ($id == '15') {
                if ($emp_basic_pay > 15000) {
                    $result = 1800;
                } else {
                    $result = ($emp_basic_pay * $rate_details->inpercentage / 100);
                }

            } else {
                $result = ($emp_basic_pay * $rate_details->inpercentage / 100);
            }
        }
        echo $result;
    }

}