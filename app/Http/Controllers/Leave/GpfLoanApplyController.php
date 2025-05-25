<?php

namespace App\Http\Controllers\Leave;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LeaveApprover\Gpf_loan_apply;
use App\Models\LeaveApprover\Gpf_loan_apply_dtl;
use App\Models\Leave\Gpf_details;
use App\Models\Masters\Role_authorization;
use App\Models\Role\Employee;
use Validator;
use Session;
use View;
use Auth;

class GpfLoanApplyController extends Controller
{
	//
	public function viewLoanApply()
	{
		if (!empty(Session::get('admin'))) {

			  $emp_id=Session('admin')->employee_id;

        $fund_check = Gpf_details::where('emp_code', $emp_id)->orderByDesc('id')->first();
		$email = Session::get('adminusernmae');
			$Roledata = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
				->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
				->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
				->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
				->where('member_id', '=', $email)
				->get();

        return view('leave/apply-for-gpf-loan', compact('fund_check','Roledata'));
		} else {
			return redirect('/');
		}
	}


	  public function saveLoanApply(Request $request)
	{
		if (!empty(Session::get('admin'))) {
        $loan_rs=Gpf_loan_apply::orderBy('id', 'ASC')->first();
        // dd($loan_rs);

        if(!empty($loan_rs))
		{
            $loan_id=($loan_rs->id) + 1;

            $loan_apply_no = 'L-'.date('Y'). '-' .$loan_id;
        }
        else{
            $loan_apply_no = 'L-'.date('Y').'-1';
        }

		$emp_id=Session('admin')->employee_id;

		$report_auth = Employee::where('emp_code', $emp_id)->first();

		$report_auth_name = $report_auth->emp_reporting_auth;
		

		$lv_sanc_auth = $report_auth->emp_lv_sanc_auth;

		
		$data = array(
          'apply_date'=>$request->from_date,
          'employee_code'=>$emp_id,
          'emp_reporting_auth'=> $report_auth_name,
		  'emp_sanctioning_auth'=> '',
          'emp_lv_sanc_auth' => '',
          'loan_applied_no' => $loan_apply_no,
          'loan_amount' => $request->loan_amt,
          'loan_type' => 'GPF',
          'purpose'=>$request->purpose,
          'loan_status'=> 'NOT APPROVED',
		  'created_at' => date('Y-m-d H:i:s'),
		  'updated_at' => date('Y-m-d H:i:s'),
        );
		


      
		$loan_apply=new Gpf_loan_apply;
			$loan_apply->apply_date=$request->from_date;
			
$loan_apply->employee_code=$emp_id;
$loan_apply->emp_reporting_auth=$report_auth_name;
$loan_apply->emp_sanctioning_auth='';
$loan_apply->emp_lv_sanc_auth='';
$loan_apply->loan_applied_no=$loan_apply_no;
$loan_apply->loan_amount=$request->loan_amt;
$loan_apply->loan_type='GPF';
$loan_apply->purpose=$request->purpose;
$loan_apply->loan_status= 'NOT APPROVED';
$loan_apply->updated_at=date('Y-m-d H:i:s');
$loan_apply->created_at=date('Y-m-d H:i:s');
			$loan_apply->save();

		Session::flash('message','PF Loan Applied Successfully.');
		return redirect('employee-corner/dashboard');
		
			} else {
			return redirect('/');
		}
    }

}
