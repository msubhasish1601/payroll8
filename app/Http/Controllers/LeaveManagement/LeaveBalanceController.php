<?php

namespace App\Http\Controllers\LeaveManagement;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Masters\Role_authorization;
use App\Models\Role\Employee;
use App\Models\LeaveManagement\Leave_rule;
use App\Models\LeaveManagement\Leave_type;
use App\Models\LeaveManagement\Leave_allocation;
use Illuminate\Support\Facades\DB;
use View;
use Validator;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LeaveBalanceController extends Controller
{
	public function getLeaveBalance()
	{
		if (!empty(Session::get('admin'))) {

				$data['Roledata']=  Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

				->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
				->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
				->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
				->where('member_id', '=', Session::get('adminusernmae'))
				->get();
		 $data['leave_balance_rs']=Leave_allocation::join('leave_types', 'leave_allocations.leave_type_id', '=', 'leave_types.id')
            ->join('employees', 'leave_allocations.employee_code', '=', 'employees.emp_code') 
            ->select('leave_allocations.*', 'leave_types.leave_type_name','employees.*')
			 ->orderBy('leave_allocations.id', 'asc')
            ->get();

		return view('leavemanagement/leave-balance', $data);
		} else {
			return redirect('/');
		}
	}

	
	
	 public function leaveBalanceView()
    {
if (!empty(Session::get('admin'))) {

				$data['Roledata']=  Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

				->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
				->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
				->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
				->where('member_id', '=', Session::get('adminusernmae'))
				->get();

        return view('leavemanagement/leave-balance-view', $data);
		} else {
			return redirect('/');
		}
    }

	
	public function leaveBalanceReport(Request $request)
    {
		if (!empty(Session::get('admin'))) {

				$data['Roledata']=  Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

				->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
				->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
				->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
				->where('member_id', '=', Session::get('adminusernmae'))
				->get();
        $employeelist=Employee::where('status','=','active')->get();
    
        $leave_rs=Leave_allocation::leftJoin('leave_types','leave_allocations.leave_type_id','=','leave_types.id')
        ->leftJoin('employees','leave_allocations.employee_code','=','employees.emp_code')
        ->whereYear('leave_allocations.created_at', '=', $request->year_value)
        ->select('leave_allocations.*','employees.emp_fname','employees.emp_mname','employees.emp_designation','employees.emp_lname','leave_types.leave_type_name','leave_types.id as leavetypeid')
        ->orderBy('leave_allocations.leave_type_id','ASC')
        ->get();
		 if(count($employeelist)!=0){
 if(count($leave_rs)!=0){
        foreach($employeelist as $employeers){
            $leave_count=array();
			
            foreach($leave_rs as $key=>$ls){
             
                if($ls->employee_code==$employeers->old_emp_code)
                {
                    
                    //$leave_count[$ls->leave_type_name]=$ls->leave_in_hand;  
                    $leave_count[]=$ls->leave_in_hand;
                }
            }
			//print_r($leave_count);
            $data['leave_rs'][]=array('old_emp_code'=>$employeers->old_emp_code,'emp_name'=>$employeers->emp_fname." ".$employeers->emp_mname." ".$employeers->emp_lname,'emp_designation'=>$employeers->emp_designation,'leave_type_id'=>$ls->leave_type_id,'leave_type_name'=>$ls->leave_type_name,'emp_leavein_hand'=>$leave_count);

        }
           
		}else{
			Session::flash('error','Leave Balance Report is not find');
		return redirect('leave-management/leave-balance-view'); 
		 }
		 }else{
			Session::flash('error','Leave Balance Report is not find');
		return redirect('leave-management/leave-balance-view'); 
		 }		
        $data['leave_type']=Leave_type::orderBy('id','ASC')->get();
        $data['year_value']=$request->year_value;
        //echo "<pre>"; print_r($data['leave_type']); print_r($data['leave_rs']); exit;
        return view('leavemanagement/leave-balance-report',$data);
        
		} else {
			return redirect('/');
		}
    }

}
