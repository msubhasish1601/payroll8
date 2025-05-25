<?php

namespace App\Http\Controllers\Payroll;

use App\Exports\ExcelFileExportBankStatement;
use App\Http\Controllers\Controller;
use App\Models\Masters\Bank_master;
use App\Models\Masters\Company;
use App\Models\Masters\Group_name_detail;
use App\Models\Masters\Role_authorization;
use App\Models\Payroll\Payroll_detail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Validator;
use View;

class BankWisePayslipController extends Controller
{
    //
    public function getBankWisePayslip()
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
            $data['month_details'] = Payroll_detail::distinct()->get(['month_yr']);
            $data['bank_details'] = Bank_master::join('banks', 'bank_masters.id', '=', 'banks.bank_name')

                ->select('banks.*', 'bank_masters.*')
                ->groupBy('banks.bank_name')
                ->get();
            $data['bankname'] = $data['monthyr'] = '';
            $data['class_name'] = Group_name_detail::where('status', '=', 'active')

                ->get();
            $data['company_rs'] = Company::orderBy('id', 'desc')->first();
            //dd($data);
            $Payroll_details_rs = '';
            return view('payroll/bank-statement', $data);
        } else {
            return redirect('/');
        }
    }

    public function showBankWiseStatement(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['Payroll_details_rs'] = $data['result'] = '';
            $data['monthyr'] = $request['month_yr']; //dd($emp_id);
            $data['bankname'] = $request['bank'];
            $data['company_rs'] = Company::orderBy('id', 'desc')->first();
            //dd($request->all());
            $validator = Validator::make($request->all(), [
                'month_yr' => 'required',
                // 'bank'=>'required',
                [
                    'month_yr.required' => 'Month Year Required',
                    'bank.required' => 'Bank Required',
                ],
            ]);

            if ($validator->fails()) {
                return redirect('payroll/vw-bank-statement')->withErrors($validator)->withInput();
            }
            $data['class_name_new'] = $request->class_name_new;
            $request['bank'];

            if (is_null($request['class_name_new']) && is_null($request['bank'])) {
                $data['Payroll_details_rs'] = Payroll_detail::join('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
                    ->leftJoin('group_name_details', 'employees.emp_group_name', '=', 'group_name_details.id')
                    ->join('bank_masters', 'employees.emp_bank_name', '=', 'bank_masters.id')
                    ->where('payroll_details.month_yr', '=', $request['month_yr'])

                    ->select('payroll_details.*', 'employees.*', 'group_name_details.group_name', 'bank_masters.master_bank_name')
                    ->orderByRaw('CAST(employees.old_emp_code AS UNSIGNED)')
                    ->get();
            } else if (is_null($request['class_name_new']) && $request['bank'] != '') {
                $data['Payroll_details_rs'] = Payroll_detail::join('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
                    ->leftJoin('group_name_details', 'employees.emp_group_name', '=', 'group_name_details.id')
                    ->join('bank_masters', 'employees.emp_bank_name', '=', 'bank_masters.id')
                    ->where(['payroll_details.month_yr' => $request['month_yr'], 'employees.emp_bank_name' => $request['bank']])

                    ->select('payroll_details.*', 'employees.*', 'group_name_details.group_name', 'bank_masters.master_bank_name')
                    ->orderByRaw('CAST(employees.old_emp_code AS UNSIGNED)')
                    ->get();
            } else if ($request['class_name_new'] != '' && is_null($request['bank'])) {
                $data['Payroll_details_rs'] = Payroll_detail::join('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
                    ->leftJoin('group_name_details', 'employees.emp_group_name', '=', 'group_name_details.id')
                    ->join('bank_masters', 'employees.emp_bank_name', '=', 'bank_masters.id')
                    ->where(['payroll_details.month_yr' => $request['month_yr'], 'group_name_details.id' => $request['class_name_new']])

                    ->select('payroll_details.*', 'employees.*', 'group_name_details.group_name', 'bank_masters.master_bank_name')
                    ->orderByRaw('CAST(employees.old_emp_code AS UNSIGNED)')
                    ->get();
            } else {
                $data['Payroll_details_rs'] = Payroll_detail::join('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
                    ->leftJoin('group_name_details', 'employees.emp_group_name', '=', 'group_name_details.id')
                    ->join('bank_masters', 'employees.emp_bank_name', '=', 'bank_masters.id')
                    ->where('payroll_details.month_yr', '=', $request['month_yr'])
                    ->where('employees.emp_group_name', '=', $request['class_name_new'])
                    ->where('employees.emp_bank_name', '=', $request['bank'])
                    ->select('payroll_details.*', 'employees.*', 'group_name_details.group_name', 'bank_masters.master_bank_name')
                    ->orderByRaw('CAST(employees.old_emp_code AS UNSIGNED)')
                    ->get();
            }

            // dd($data['Payroll_details_rs']);
            if (count($data['Payroll_details_rs']) != 0) {

                foreach ($data['Payroll_details_rs'] as $payroll) {
                    // dd($payroll);

                    $data['result'] .= '<tr style="text-align:center;">
						<td>' . $payroll->employee_id . '</td>
						<td>' . $payroll->old_emp_code . '</td>
						<td>' . $payroll->emp_name . '</td>
						<td>' . $payroll->master_bank_name . '</td>
						<td>' . $payroll->emp_net_salary . '</td>
						<td>' . $payroll->month_yr . '</td>

					</tr>';
                    // $data['result'] .= '<tr style="text-align:center;">
                    //     <td>' . $payroll->employee_id . '</td>
                    //     <td>' . $payroll->old_emp_code . '</td>
                    //     <td>' . $payroll->emp_name . '</td>
                    //     <td>' . $payroll->group_name . '</td>
                    //     <td>' . $payroll->master_bank_name . '</td>
                    //     <td>' . $payroll->emp_net_salary . '</td>
                    //     <td>' . $payroll->month_yr . '</td>

                    // </tr>';
                    //dd($result);
                }

                $data['month_details'] = Payroll_detail::distinct()->get(['month_yr']);

                //print_r($data);die;
                $data['class_name'] = Group_name_detail::where('status', '=', 'active')->get();

                $data['bank_details'] = Bank_master::join('banks', 'bank_masters.id', '=', 'banks.bank_name')

                    ->select('banks.*', 'bank_masters.*')
                    ->groupBy('banks.bank_name')
                    ->get();
                return view('payroll/bank-statement', $data);
            } else {
                $data['class_name'] = Group_name_detail::where('status', '=', 'active')->get();

                $data['month_details'] = Payroll_detail::distinct()->get(['month_yr']);
                $data['bank_details'] = Bank_master::join('banks', 'bank_masters.id', '=', 'banks.bank_name')

                    ->select('banks.*', 'bank_masters.*')
                    ->groupBy('banks.bank_name')
                    ->get();

                Session::flash('error', 'Data not found');
                return view('payroll/bank-statement', $data);
            }
        } else {
            return redirect('/');
        }
    }

    public function xlsExportBankStatement(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            // dd($request->all());

            $monthyr = '';
            if (isset($request->monthyr)) {
                $monthyr = $request->monthyr;
            }
            $class_name_new = '';
            if (isset($request->class_name_new)) {
                $class_name_new = $request->class_name_new;
            }
            $bankname = '';
            if (isset($request->bankname)) {
                $bankname = $request->bankname;
            }
            $month_yr_str = '';
            if ($monthyr != '') {
                $month_yr_str = explode('/', $monthyr);
                $month_yr_str = implode('-', $month_yr_str);
            }

            return Excel::download(new ExcelFileExportBankStatement($monthyr, $bankname, $class_name_new), 'Bank Statement-' . $month_yr_str . '.xlsx');
        } else {
            return redirect('/');
        }
    }
    public function viewBankStatement(Request $request)
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
            $data['bankdeatils'] = Bank_master::join('banks', 'bank_masters.id', '=', 'banks.bank_name')
                ->where('bank_masters.id', '=', $request['bankname'])
                ->select('banks.*', 'bank_masters.*')
                ->first();

            if (is_null($request['class_name_new']) && is_null($request['bankname'])) {
                $data['Payroll_details_rs'] = Payroll_detail::join('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
                    ->join('group_name_details', 'employees.emp_group_name', '=', 'group_name_details.id','LEFT')
                    ->join('bank_masters', 'employees.emp_bank_name', '=', 'bank_masters.id','LEFT')
                    ->where('payroll_details.month_yr', '=', $request['monthyr'])

                    ->select('payroll_details.*', 'employees.*', 'group_name_details.group_name', 'bank_masters.master_bank_name')
                    ->orderByRaw('CAST(employees.old_emp_code AS UNSIGNED)')
                    ->get();
            } else if (is_null($request['class_name_new']) && $request['bankname'] != '') {
                $data['Payroll_details_rs'] = Payroll_detail::join('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
                    ->join('group_name_details', 'employees.emp_group_name', '=', 'group_name_details.id','LEFT')
                    ->join('bank_masters', 'employees.emp_bank_name', '=', 'bank_masters.id','LEFT')
                    ->where(['payroll_details.month_yr' => $request['monthyr'], 'employees.emp_bank_name' => $request['bankname']])

                    ->select('payroll_details.*', 'employees.*', 'group_name_details.group_name', 'bank_masters.master_bank_name')
                    ->orderByRaw('CAST(employees.old_emp_code AS UNSIGNED)')
                    ->get();
                //dd($data);
            } else if ($request['class_name_new'] != '' && is_null($request['bankname'])) {
                $data['Payroll_details_rs'] = Payroll_detail::join('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
                    ->join('group_name_details', 'employees.emp_group_name', '=', 'group_name_details.id','LEFT')
                    ->join('bank_masters', 'employees.emp_bank_name', '=', 'bank_masters.id','LEFT')
                    ->where(['payroll_details.month_yr' => $request['monthyr'], 'group_name_details.id' => $request['class_name_new']])

                    ->select('payroll_details.*', 'employees.*', 'group_name_details.group_name', 'bank_masters.master_bank_name')
                    ->orderByRaw('CAST(employees.old_emp_code AS UNSIGNED)')
                    ->get();
            } else {
                $data['Payroll_details_rs'] = Payroll_detail::join('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
                    ->join('group_name_details', 'employees.emp_group_name', '=', 'group_name_details.id','LEFT')
                    ->join('bank_masters', 'employees.emp_bank_name', '=', 'bank_masters.id','LEFT')
                    ->where(['payroll_details.month_yr' => $request['monthyr'], 'employees.emp_bank_name' => $request['bankname']])
                    ->where('group_name_details.id', '=', $request['class_name_new'])
                    ->select('payroll_details.*', 'employees.*', 'group_name_details.group_name', 'bank_masters.master_bank_name')
                    ->orderByRaw('CAST(employees.old_emp_code AS UNSIGNED)')
                    ->get();
            }

            $data['month'] = $request->monthyr;
            $data['company_rs'] = Company::orderBy('id', 'desc')->first();
            $data['class_name_new'] = $request->class_name_new;
            return view('payroll/bank-statement-report', $data);
        } else {
            return redirect('/');
        }
    }

}
