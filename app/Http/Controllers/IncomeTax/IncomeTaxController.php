<?php

namespace App\Http\Controllers\IncomeTax;


use App\Http\Controllers\Controller;


use App\Models\Role\Employee;
use App\Models\Masters\Role_authorization;
use App\Models\IncomeTax\ItaxSaving;
use App\Models\IncomeTax\Itax_type_master;
use App\Models\IncomeTax\Saving_type_master;
use App\Models\IncomeTax\ItaxDeposit;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Validator;
use Session;
use View;


class IncomeTaxController extends Controller
{

    public function dashboard()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            return View('incometax/dashboard', $data);
        } else {
            return redirect('/');
        }
    }

    public function getEmployeeSavings(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            
            $data['employeeslist'] = Employee::get();

            $fyear = '';
            if(isset($request->p)){
                $fyear = base64_decode($request->p);
            }
            $data['fyear'] = $fyear;
            $empcode = '';
            if(isset($request->f)){
                $empcode = base64_decode($request->f);
            }
            $data['empcode'] = $empcode;
            if($fyear !='' && $empcode!=''){
                $data['itax_records']  = ItaxSaving::select('itax_savings.*',
                            DB::raw("(SELECT tax_desc FROM itax_type_masters WHERE itax_type_masters.id=itax_savings.i_tax_type) as tax_desc"),
                            DB::raw("(SELECT saving_type_desc FROM saving_type_masters WHERE saving_type_masters.id=itax_savings.saving_type_id) as saving_type_desc")
                        )
                        ->where('financial_year','=',$fyear)
                        ->where('emp_code','=',$empcode)
                        ->get();
            }
            //dd($request->all());
            
            return view('incometax/itax-employee-savings', $data);
        } else {
            return redirect('/');
        }
    }

    public function addEmployeeSavings(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $fyear = '';
            if(isset($request->p)){
                $fyear = base64_decode($request->p);
            }
            $data['fyear'] = $fyear;
            $empcode = '';
            if(isset($request->f)){
                $empcode = base64_decode($request->f);
            }
            $data['empcode'] = $empcode;    

            $data['empInfo']=Employee::where('emp_code','=',$empcode)->first();
            $data['income_tax'] =$income_tax = Itax_type_master::where('financial_year','=',$fyear)->get();

            return view('incometax/add-itax-savings',$data);
        } else {
            return redirect('/');
        }
    }

    public function saveEmployeeSavings(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'financial_year' => 'required',
                    'emp_code' => 'required',
                    'i_tax_type' => 'required',
                    'saving_type_id' => 'required',
                    'amount' => 'required'

                ],
                [
                    'financial_year.required' => 'Financial Year Required',
                    'emp_code.required' => 'Employee Required',
                    'i_tax_type.required' => 'Itax Type Required',
                    'saving_type_id.required' => 'Saving Type Required',
                    'amount.required' => 'Savings Amount Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('itax/employee-savings')->withErrors($validator)->withInput();
            }
            //$data = $request->all();

            //dd($request->all());

            $empsavings=ItaxSaving::where('financial_year','=',$request->input('financial_year'))
                                    ->where('emp_code','=',$request->input('emp_code'))
                                    ->where('i_tax_type','=',$request->input('i_tax_type'))
                                    ->where('saving_type_id','=',$request->input('saving_type_id'))
                                    ->get();

            if(count($empsavings)>0){
                Session::flash('error', 'Income tax saving for this employee already exist. Please edit the existing values.');
            
            }else{
                $data = array(
    
                    'financial_year' => $request->input('financial_year'),
                    'emp_code' => $request->input('emp_code'),
                    'i_tax_type' => $request->input('i_tax_type'),
                    'saving_type_id' => $request->input('saving_type_id'),
                    'amount' => $request->input('amount')
                );
    
                // print_r($data);
                // die();
                $itaxSaving = new ItaxSaving();
    
                $itaxSaving->create($data);
                Session::flash('message', 'Income Tax Savings Information Successfully Saved.');
            }


            return redirect('itax/employee-savings?p='.base64_encode($request->input('financial_year')).'&f='.base64_encode($request->input('emp_code')));
        } else {
            return redirect('/');
        }
    }

    public function editEmployeeSavings(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $fyear = '';
            if(isset($request->p)){
                $fyear = base64_decode($request->p);
            }
            $data['fyear'] = $fyear;
            $empcode = '';
            if(isset($request->f)){
                $empcode = base64_decode($request->f);
            }
            $data['empcode'] = $empcode;    
            $id = '';
            if(isset($request->i)){
                $id = base64_decode($request->i);
            }
            $data['id'] = $id;    

            $data['empInfo']=Employee::where('emp_code','=',$empcode)->first();
            $data['itaxsave']=ItaxSaving::where('id','=',$id)->first();
            $data['income_tax'] =$income_tax = Itax_type_master::where('financial_year','=',$fyear)->get();
            $data['stypes'] = Saving_type_master::where('i_tax_type', '=', $data['itaxsave']->i_tax_type)->get();

            //dd($data);
            return view('incometax/edit-itax-savings',$data);
        } else {
            return redirect('/');
        }
    }

    public function updateEmployeeSavings(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'financial_year' => 'required',
                    'emp_code' => 'required',
                    'i_tax_type' => 'required',
                    'saving_type_id' => 'required',
                    'amount' => 'required'

                ],
                [
                    'financial_year.required' => 'Financial Year Required',
                    'emp_code.required' => 'Employee Required',
                    'i_tax_type.required' => 'Itax Type Required',
                    'saving_type_id.required' => 'Saving Type Required',
                    'amount.required' => 'Savings Amount Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('itax/employee-savings')->withErrors($validator)->withInput();
            }
            //$data = $request->all();

            //dd($request->all());

            $empsavings=ItaxSaving::where('financial_year','=',$request->input('financial_year'))
                                    ->where('emp_code','=',$request->input('emp_code'))
                                    ->where('i_tax_type','=',$request->input('i_tax_type'))
                                    ->where('saving_type_id','=',$request->input('saving_type_id'))
                                    ->first();

            if(!empty($empsavings) && $empsavings->id !=$request->id){
                Session::flash('error', 'Income tax saving for this employee already exist. Please edit the existing values.');
            
            }else{
                $data = array(
    
                    'financial_year' => $request->input('financial_year'),
                    'emp_code' => $request->input('emp_code'),
                    'i_tax_type' => $request->input('i_tax_type'),
                    'saving_type_id' => $request->input('saving_type_id'),
                    'amount' => $request->input('amount')
                );
    
                // print_r($data);
                // die();
                ItaxSaving::where('id', $request['id'])->update($data);
                Session::flash('message', 'Income Tax Savings Information Successfully Updated.');
            }


            return redirect('itax/employee-savings?p='.base64_encode($request->input('financial_year')).'&f='.base64_encode($request->input('emp_code')));
        } else {
            return redirect('/');
        }
    }

    public function deleteEmployeeSavings(Request $request)
    {
        if (!empty(Session::get('admin'))) {


            $fyear = '';
            if(isset($request->p)){
                $fyear = base64_decode($request->p);
            }
            $data['fyear'] = $fyear;
            $empcode = '';
            if(isset($request->f)){
                $empcode = base64_decode($request->f);
            }
            $data['empcode'] = $empcode;    
            $id = '';
            if(isset($request->i)){
                $id = base64_decode($request->i);
            }
            $data['id'] = $id;    

            $dataUpdate = ItaxSaving::where('id', $id)->delete();
            Session::flash('message', 'Income Tax Savings Information Successfully Deleted.');
            return redirect('itax/employee-savings?p='.base64_encode($fyear).'&f='.base64_encode($empcode));
        } else {
            return redirect('/');
        }
    }

    public function getEmployeeSavingsReport(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            
            $data['employeeslist'] = Employee::get();

            $fyear = '';
            if(isset($request->p)){
                $fyear = base64_decode($request->p);
            }
            $data['fyear'] = $fyear;
            $empcode = '';
            if(isset($request->f)){
                $empcode = base64_decode($request->f);
            }
            $data['empcode'] = $empcode;
            if($fyear !='' && $empcode!=''){
                $data['itax_records']  = ItaxSaving::select('itax_savings.*',
                            DB::raw("(SELECT tax_desc FROM itax_type_masters WHERE itax_type_masters.id=itax_savings.i_tax_type) as tax_desc"),
                            DB::raw("(SELECT saving_type_desc FROM saving_type_masters WHERE saving_type_masters.id=itax_savings.saving_type_id) as saving_type_desc")
                        )
                        ->where('financial_year','=',$fyear)
                        ->where('emp_code','=',$empcode)
                        ->get();

                $data['empInfo']=$empInfo=Employee::where('emp_code','=',$empcode)->first();                        

                return view('incometax/itax-savings-report', $data);
            }else{
                return view('incometax/itax-emp-savings-report', $data);
            }
            //dd($request->all());
            
            
        } else {
            return redirect('/');
        }
    }

    public function getEmployeeFormSixteen(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            
            $data['employeeslist'] = Employee::get();

            $fyear = '';
            if(isset($request->p)){
                $fyear = base64_decode($request->p);
            }
            $data['fyear'] = $fyear;

            if($fyear!=''){
                $financial_year=explode('-',$fyear);
                $from_year=$financial_year[0];
                $to_year=$financial_year[1];
    
                $assesment_year=($from_year+1).'-'.($to_year+1);
                $start_date='01.04.'.$from_year;
                $end_date='31.03.'.$to_year;
                $data['assesment_year'] = $assesment_year;
                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;
            }


            $empcode = '';
            if(isset($request->f)){
                $empcode = base64_decode($request->f);
            }
            $data['empcode'] = $empcode;
            if($fyear !='' && $empcode!=''){
                $data['itax_records']  = ItaxSaving::select('itax_savings.*',
                            DB::raw("(SELECT tax_desc FROM itax_type_masters WHERE itax_type_masters.id=itax_savings.i_tax_type) as tax_desc"),
                            DB::raw("(SELECT saving_type_desc FROM saving_type_masters WHERE saving_type_masters.id=itax_savings.saving_type_id) as saving_type_desc")
                        )
                        ->where('financial_year','=',$fyear)
                        ->where('emp_code','=',$empcode)
                        ->get();

                $data['deposit_records']  = ItaxDeposit::whereBetween('payment_date',[$start_date,$end_date])->get();

                $data['empInfo']=$empInfo=Employee::where('emp_code','=',$empcode)->first();                        

                return view('incometax/form-sixteen', $data);
            }else{
                return view('incometax/view-form-sixteen', $data);
            }
            //dd($request->all());
            
            
        } else {
            return redirect('/');
        }
    }

}
