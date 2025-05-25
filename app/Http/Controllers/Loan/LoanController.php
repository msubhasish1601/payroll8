<?php

namespace App\Http\Controllers\Loan;

use App\Exports\ExcelFileExportAdjustAmount;
use App\Exports\ExcelFileExportAdvanceSalary;
use App\Http\Controllers\Controller;

use App\Models\Loan\Loan;
use App\Models\Loan\LoanRecovery;
use App\Models\Role\Employee;
use App\Models\Masters\Role_authorization;
use App\Models\Payroll\Payroll_detail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExcelFileExportLoanRepo;
use App\Exports\ExcelFileExportLoanList;
use Illuminate\Support\Facades\DB;
use Session;
use View;

class LoanController extends Controller
{

    public function viewLoan()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['employee_rs'] = Loan::join('employees', 'employees.emp_code', '=', 'loans.emp_code')
                ->select('employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname', 'employees.emp_designation', 'employees.old_emp_code', 'loans.*',DB::raw('(SELECT  Sum(loan_recoveries.amount) FROM loan_recoveries WHERE loan_recoveries.loan_id =  loans.id) as balance'))
                //->where('loans.month_yr', $request->month)

                ->orderBy('loans.id', 'desc')
                ->get();

            return View('loan.index', $data);
        } else {
            return redirect('/');
        }
    }

    public function addLoan()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['Employee'] = Employee::where('status', '=', 'active')->orderBy('emp_fname', 'asc')->get();

            $maxid=Loan::max('id');
            if($maxid==null){
                $maxid=1;
            }else{
                $maxid=$maxid+1;
            }

            $data['loan_id']='L'.str_pad($maxid,'3','0',STR_PAD_LEFT);

            return View('loan.add', $data);

        } else {
            return redirect('/');
        }
    }

    public function saveLoan(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();


            $start_month=date('m/Y',strtotime($request->start_month));
            $employee_code=$request->emp_code;

            $payroll = Payroll_detail::where('employee_id', '=', $employee_code)->where('month_yr', '=', $start_month)->first();

            if (!empty($payroll)) {
                Session::flash('error', 'Payroll already generated for said period.');
                return redirect('/loans/add-loan')->withInput();
            }
            $prid=Payroll_detail::max('month_yr');
            if(!empty($prid)){
                $pridArr=explode('/',$prid);
                $prid_dt='01-'.$pridArr[0].'-'.$pridArr[1];
                if(strtotime($prid_dt)>strtotime($request->start_month)){
                    Session::flash('error', 'Payroll already generated for months after the said period.');
                    return redirect('/loans/add-loan')->withInput();
                }

            }
            //dd($request->all());

            $maxid=Loan::max('id');
            if($maxid==null){
                $maxid=1;
            }else{
                $maxid=$maxid+1;
            }

            $loan_id='L'.str_pad($maxid,'3','0',STR_PAD_LEFT);

            $loan = new Loan;
            $loan->loan_id = $loan_id;
            $loan->emp_code = $request->emp_code;
            $loan->loan_type = $request->loan_type;
            $loan->start_month = $request->start_month;
            $loan->loan_amount = $request->loan_amount;
            $loan->installment_amount = $request->installment_amount;
            $loan->deduction = $request->deduction;
            //dd($loan);
            $loan->save();
            Session::flash('message', 'Loan details saved successfully.');
            return redirect('/loans/view-loans');



        } else {
            return redirect('/');
        }
    }

    public function editLoan($id)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['Employee'] = Employee::where('status', '=', 'active')->orderBy('emp_fname', 'asc')->get();


            $data['id']=$id;
            $data['loan_details'] = Loan::where('id', '=', $id)->first();

            //dd($loan_id);

            return View('loan/edit', $data);

        } else {
            return redirect('/');
        }
    }

    public function updateLoan(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $loanInfo=Loan::find($request->id);

            //dd($loanInfo);
            $old_loan_start_month=date('m/Y',strtotime($loanInfo->start_month));

            $start_month=date('m/Y',strtotime($request->start_month));
            $employee_code=$request->emp_code;

            if($old_loan_start_month==$start_month){
                //No start date change

            }else{
                //start date changed
                $payroll = Payroll_detail::where('employee_id', '=', $employee_code)->where('month_yr', '=', $old_loan_start_month)->first();

                if (!empty($payroll)) {
                    Session::flash('error', 'As deduction against the loan already started. You cannot change the Loan Start Date.');
                    return redirect('/loans/edit-loan/'.$request->id)->withInput();
                }
                $payroll = Payroll_detail::where('employee_id', '=', $employee_code)->where('month_yr', '=', $start_month)->first();

                if (!empty($payroll)) {
                    Session::flash('error', 'Payroll already generated for said period.');
                    return redirect('/loans/edit-loan/'.$request->id)->withInput();
                }
                $prid=Payroll_detail::max('month_yr');
                if(!empty($prid)){
                    $pridArr=explode('/',$prid);
                    $prid_dt='01-'.$pridArr[0].'-'.$pridArr[1];
                    if(strtotime($prid_dt)>strtotime($request->start_month)){
                        Session::flash('error', 'Payroll already generated for months after the said period.');
                        return redirect('/loans/edit-loan/'.$request->id)->withInput();
                    }

                }
            }

            //dd($request->all());

            $loan = Loan::find($request->id);
            //$loan->loan_id = $loan_id;
            $loan->emp_code = $request->emp_code;
            $loan->loan_type = $request->loan_type;
            $loan->start_month = $request->start_month;
            $loan->loan_amount = $request->loan_amount;
            $loan->installment_amount = $request->installment_amount;
            $loan->deduction = $request->deduction;
            //dd($loan);
            $loan->save();
            Session::flash('message', 'Loan details updated successfully.');
            return redirect('/loans/view-loans');


        } else {
            return redirect('/');
        }
    }


    public function ViewLoanRepo()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $data['result'] ='';
            return view('loan.monthly-loan-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function checkAdvanceSalary()
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['monthlist'] = Loan::select(["start_month"])
            ->orderBy('start_month')
            ->groupBy(DB::raw('MONTH(start_month)'))
            ->get();

            $data['result'] ='';
            return view('loan.check-advance-salary', $data);
        } else {
            return redirect('/');
        }
    }


    public function loanAdjustmentReport(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

                $employee_rs = Loan::join('employees', 'employees.emp_code', '=', 'loans.emp_code')
                ->select('employees.salutation','employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname', 'employees.emp_designation', 'employees.old_emp_code','employees.emp_pf_no', 'loans.*')
                //->where(DB::raw('DATE_FORMAT(loans.start_month, "%m/%Y")'), '<=', $request->month)
                //->where('loan_type', '=', $request->loan_type)
                ->where('deduction', '=', 'Y')
                ->where('loans.loan_amount', '>', 0)
                ->where('loans.adjust_amount', '>', 0)
                ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
                ->get();


            $data['result'] = $employee_rs;

            return view('loan.adjustment-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function showCheckAdvanceSalary(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            //$data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $data['monthlist'] = Loan::select(["start_month"])
            ->orderBy('start_month')
            ->groupBy(DB::raw('MONTH(start_month)'))
            ->get();

            $data['req_month'] = $request->month;
            $data['req_type'] = $request->loan_type;

            if($request->month){

                //dd($request->month);

                //\DB::connection()->enableQueryLog();

                $employee_rs = Loan::join('employees', 'employees.emp_code', '=', 'loans.emp_code')
                    ->select('employees.salutation','employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname', 'employees.emp_designation', 'employees.old_emp_code','employees.emp_pf_no', 'loans.*' )
                    ->where(DB::raw('DATE_FORMAT(loans.start_month, "%m/%Y")'), '=', $request->month)
                    ->where('loans.loan_type', '=', $request->loan_type)
                    //->where('loans.deduction', '!=', 'Y')
                    ->where('loans.loan_amount', '>', 0)
                    //->where(DB::raw("(SELECT  Sum(loan_recoveries.amount) FROM loan_recoveries WHERE loan_recoveries.loan_id =  loans.id and loan_recoveries.payout_month = '".$request->month."')"), '>', 0)
                    ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
                    ->get();

                //$queries = DB::getQueryLog(); dd($queries);

            }else{
                //echo 0; die;
                $employee_rs = Loan::join('employees', 'employees.emp_code', '=', 'loans.emp_code')
                ->select('employees.salutation','employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname', 'employees.emp_designation', 'employees.old_emp_code','employees.emp_pf_no', 'loans.*')
                //->where(DB::raw('DATE_FORMAT(loans.start_month, "%m/%Y")'), '<=', $request->month)
                ->where('loan_type', '=', $request->loan_type)
                ->where('deduction', '=', 'Y')
                ->where('loans.loan_amount', '>', 0)
                ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
                ->get();
            }

            $data['result'] = $employee_rs;

            return view('loan.check-advance-salary', $data);
        } else {
            return redirect('/');
        }
    }

    public function showLoanRepo(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $data['req_month'] = $request->month;
            $data['req_type'] = $request->loan_type;

            $employee_rs = Loan::join('employees', 'employees.emp_code', '=', 'loans.emp_code')
                ->select('employees.salutation','employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname', 'employees.emp_designation', 'employees.old_emp_code','employees.emp_pf_no', 'loans.*', DB::raw("(SELECT  Sum(loan_recoveries.amount) FROM loan_recoveries WHERE loan_recoveries.loan_id =  loans.id and loan_recoveries.payout_month <= '".$request->month."') as recoveries"), DB::raw("(SELECT  Sum(loan_recoveries.amount) FROM loan_recoveries WHERE loan_recoveries.loan_id =  loans.id and loan_recoveries.payout_month = '".$request->month."') as payroll_deduction"), DB::raw("(SELECT  payroll_details.emp_pf_int FROM payroll_details WHERE payroll_details.employee_id =  employees.emp_code and payroll_details.month_yr = '".$request->month."') as pf_iterest"))
                ->where(DB::raw('DATE_FORMAT(loans.start_month, "%m/%Y")'), '<=', $request->month)
                ->where('loan_type', '=', $request->loan_type)
                ->where('deduction', '=', 'Y')
                ->where('loans.loan_amount', '>', 0)
                ->where(DB::raw("(SELECT  Sum(loan_recoveries.amount) FROM loan_recoveries WHERE loan_recoveries.loan_id =  loans.id and loan_recoveries.payout_month = '".$request->month."')"), '>', 0)
                //->where('employees.old_emp_code', '=', '0665')
                ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
                ->get();

            // dd($employee_rs[0]);

            $data['result'] = $employee_rs;


            return view('loan/monthly-loan-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function printLoanRepo(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $data['req_month'] = $request->month;
            $data['req_type'] = $request->loan_type;

            $employee_rs = Loan::join('employees', 'employees.emp_code', '=', 'loans.emp_code')
                ->select('employees.salutation','employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname', 'employees.emp_designation', 'employees.old_emp_code','employees.emp_pf_no', 'loans.*', DB::raw("(SELECT  Sum(loan_recoveries.amount) FROM loan_recoveries WHERE loan_recoveries.loan_id =  loans.id and loan_recoveries.payout_month <= '".$request->month."') as recoveries"),DB::raw("(SELECT  Sum(loan_recoveries.amount) FROM loan_recoveries WHERE loan_recoveries.loan_id =  loans.id and loan_recoveries.payout_month = '".$request->month."') as payroll_deduction"), DB::raw("(SELECT  payroll_details.emp_pf_int FROM payroll_details WHERE payroll_details.employee_id =  employees.emp_code and payroll_details.month_yr = '".$request->month."') as pf_iterest"))
                ->where(DB::raw('DATE_FORMAT(loans.start_month, "%m/%Y")'), '<=', $request->month)
                ->where('loan_type', '=', $request->loan_type)
                ->where('deduction', '=', 'Y')
                ->where('loans.loan_amount', '>', 0)
                ->where(DB::raw("(SELECT  Sum(loan_recoveries.amount) FROM loan_recoveries WHERE loan_recoveries.loan_id =  loans.id and loan_recoveries.payout_month = '".$request->month."')"), '>', 0)
                ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
                ->get();

            //dd($employee_rs);

            $data['result'] = $employee_rs;


            return view('loan/prn-loan-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function loan_repo_xlsexport(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $month_yr = '';
            if (isset($request->month_yr)) {
                $month_yr = $request->month_yr;
            }
            $loan_type = '';
            if (isset($request->loan_type)) {
                $loan_type = $request->loan_type;
            }
            $month_yr_str='';
            if($month_yr!=''){
                $month_yr_str=explode('/',$month_yr);
                $month_yr_str=implode('-',$month_yr_str);
            }

            return Excel::download(new ExcelFileExportLoanRepo($month_yr,$loan_type), 'LoanReport-'.$month_yr_str.'.xlsx');
        }
        else {
            return redirect('/');
        }
    }

    public function advance_salary_xlsexport(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $month_yr = '';
            if (isset($request->month_yr)) {
                $month_yr = $request->month_yr;
            }
            $loan_type = '';
            if (isset($request->loan_type)) {
                $loan_type = $request->loan_type;
            }
            $month_yr_str='';
            if($month_yr!=''){
                $month_yr_str=explode('/',$month_yr);
                $month_yr_str=implode('-',$month_yr_str);
            }

            return Excel::download(new ExcelFileExportAdvanceSalary($month_yr,$loan_type), 'Check-list-'.$month_yr_str.'.xlsx');
        }
        else {
            return redirect('/');
        }
    }

    public function adjustment_report_xlsexport(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $month_yr = '';
            if (isset($request->month_yr)) {
                $month_yr = $request->month_yr;
            }
            $loan_type = '';
            if (isset($request->loan_type)) {
                $loan_type = $request->loan_type;
            }
            $month_yr_str='';
            if($month_yr!=''){
                $month_yr_str=explode('/',$month_yr);
                $month_yr_str=implode('-',$month_yr_str);
            }

            return Excel::download(new ExcelFileExportAdjustAmount($month_yr,$loan_type), 'Adjustment-report.xlsx');
        }
        else {
            return redirect('/');
        }
    }

    public function adjustLoan($id)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['Employee'] = Employee::where('status', '=', 'active')->orderBy('emp_fname', 'asc')->get();


            $data['id']=$id;
            $data['loan_details'] = Loan::where('id', '=', $id)->first();
            $loanRecoveries=LoanRecovery::where('loan_id','=',$id)->sum('amount');
            $data['loan_balance']=$data['loan_details']->loan_amount-$loanRecoveries;
            //dd($loan_id);

            return View('loan/adjust', $data);

        } else {
            return redirect('/');
        }
    }

    public function updateLoanAdjustment(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            //dd($request->all());

            $loanDetails=Loan::where('id', '=', $request->id)->first();
            $loanRecoveries=LoanRecovery::where('loan_id','=',$request->id)->sum('amount');
            $loan_balance=$loanDetails->loan_amount-$loanRecoveries;
            $payroll_month=date('m/Y');

            if($loan_balance>0 && $loanDetails->adjust_date==null){
                $loan = Loan::find($request->id);
                $loan->adjust_amount = $loan_balance;
                $loan->adjust_date = date('Y-m-d');
               // $loan->deduction = 'N';
                $loan->adjust_remarks = $request->adjust_remarks;
                //dd($loan);
                $loan->save();

                $loanRecovery = new LoanRecovery;
                $loanRecovery->loan_id = $request->id;
                $loanRecovery->amount = $loan_balance;
                $loanRecovery->payout_month = $payroll_month;
                $loanRecovery->adjusted = 'Y';
                $loanRecovery->save();

                Session::flash('message', 'Loan details adjusted successfully.');
                return redirect('/loans/view-loans');

            }else{
                Session::flash('error', 'Nothing to adjust. Loan already settled.');
                return redirect('/loans/view-loans');
            }

        } else {
            return redirect('/');
        }
    }


    public function viewAdjustLoan($id)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['Employee'] = Employee::where('status', '=', 'active')->orderBy('emp_fname', 'asc')->get();


            $data['id']=$id;
            $data['loan_details'] = Loan::where('id', '=', $id)->first();
            $loanRecoveries=LoanRecovery::where('loan_id','=',$id)->sum('amount');
            $data['loan_balance']=$data['loan_details']->loan_amount-$loanRecoveries;
            //dd($loan_id);

            return View('loan/adjust-view', $data);

        } else {
            return redirect('/');
        }
    }


    public function loan_list_xlsexport(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            return Excel::download(new ExcelFileExportLoanList(), 'LoanList.xlsx');
        }
        else {
            return redirect('/');
        }
    }


}
