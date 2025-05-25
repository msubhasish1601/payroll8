<?php

namespace App;

namespace App\Http\Controllers\Leave;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Session\Store;
use App\Models\LeaveApprover\Loan_other;
use App\Models\Masters\Loan_configuration;
use App\Models\Masters\Loan_master;
use App\Models\Masters\Role_authorization;
use App\Models\Role\Employee;
use Validator;
use Session;
use View;
use Auth;

class LoanApplyuserController extends Controller
{
    //
    public function luserapplicationListing()
    {
        if (!empty(Session::get('admin'))) {

            $data['leave_apply_rs'] =   Loan_other::leftJoin('loan_masters', 'loan_others.loan_type', '=', 'loan_masters.id')
            ->select('loan_others.*', 'loan_masters.loan_type')
            ->where('loan_masters.loan_status', '=', 'active')
            ->get();
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            return view('leave/loanoherlisting', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewApplyluserapplication()
    {
        if (!empty(Session::get('admin'))) {


            $empid = Session('admin')->employee_id;

            $data['employee'] = Employee::where('emp_code', '=', $empid)->first();

            $data['loan_type_rs'] = Loan_master::get();
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $loan_rs = Loan_other::Orderby('id', 'DESC')->first();

            $loan_id = 0;

            if (!empty($loan_rs)) {
                $loan_id = $loan_rs->id;
                $k = $loan_id + 1;
                if ($k < 10) {
                    $data['loan_code'] = 'Loan-' . date('Y') . '-0' . $k;
                }

                if ($k >= 10) {
                    $data['loan_code'] = 'Loan-' . date('Y') . '-' . $k;
                }
            } else {
                $k = $loan_id + 1;

                if ($k < 10) {
                    $data['loan_code'] = 'Loan-' . date('Y') . '-0' . $k;
                }
            }


            return view('leave/apply-loanothers', $data);
        } else {
            return redirect('/');
        }
    }

    public function leavetypeAjax($id_leave_type)
    {
        if (!empty(Session::get('admin'))) {

            $empid = Session('admin')->employee_id;

            $leaveinhand = Loan_master::where('id', '=', $id_leave_type)

                ->first();
            $leaveincon = Loan_configuration::where('loan_type', '=', $leaveinhand->id)

                ->first();

            echo json_encode(array('amount' => $leaveincon->max_sanction_amt, 'shares' => $leaveincon->max_time));
        } else {
            return redirect('/');
        }
    }

    public function saveApplyluserapplication(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $emp_code = Session('admin')->employee_id;
            $report_auth_name = $request->emp_reporting_auth;

            $loan_type_rs = Loan_configuration::where('loan_type', '=', $request->loan_type)->first();

            if ($loan_type_rs->max_sanction_amt >= $request->loan_amount) {
                if ($loan_type_rs->max_time >= $request->no_of_shares) {

                    if ($loan_type_rs->max_working_time <= $request->no_of_working_years) {
                        $datapen = array(
                            'employee_code' => $emp_code,
                            'emp_reporting_auth' => $report_auth_name,

                            'loan_applied_no' => $request->loan_applied_no,
                            'apply_date' => $request->apply_date,
                            'loan_type' => $request->loan_type,
                            'purpose_of_loan' => $request->purpose_of_loan,
                            'loan_amount' => $request->loan_amount,
                            'nominee_one' => $request->nominee_one,
                            'nominee_two' => $request->nominee_two,
                            'nominee_three' => $request->nominee_three,
                            'no_of_shares' => $request->no_of_shares,
                            'loan_status' => 'NOT APPROVED',
                            'no_of_working_years' => $request->no_of_working_years,
                        );



                        Loan_other::insert($datapen);
						 Session::flash('message', 'Loan added Successfully');
                    } else {
                        Session::flash('error', 'You are not eligible ');
                        return redirect('employee-corner/loanlisting');
                    }
                } else {
                    Session::flash('error', 'Please check the No Of Shares ');
                    return redirect('employee-corner/loanlisting');
                }
            } else {
                Session::flash('error', 'Please check the apply amount ');
                return redirect('employee-corner/loanlisting');
            }

            $data['leave_apply_rs'] =   Loan_other::get();
           
            return redirect('employee-corner/loanlisting');
        } else {
            return redirect('/');
        }
    }
}
