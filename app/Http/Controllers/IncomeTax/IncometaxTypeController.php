<?php

namespace App\Http\Controllers\IncomeTax;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\IncomeTax\Itax_type_master;
use App\Models\Masters\Role_authorization;
use Validator;
use Session;
use View;
use Illuminate\Support\Facades\Input;
use Auth;

class IncometaxTypeController extends Controller
{

    public function getIncometaxType()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['income_tax'] =$income_tax = Itax_type_master::get();
            return view('incometax/income-tax-type', $data);
        } else {
            return redirect('/');
        }
    }

    public function addIncometaxType()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            return view('incometax/add-income-tax-type',$data);
        } else {
            return redirect('/');
        }
    }

    public function saveIncometaxType(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'financial_year' => 'required',
                    'tax_desc' => 'required',
                    'max_amount' => 'required'

                ],
                [
                    'financial_year.required' => 'Financial Year Required',
                    'tax_desc.required' => 'Income Tax Type Description Required',
                    'max_amount.required' => 'Max Amount Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('itax/add-income-tax-type')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'financial_year' => $request->input('financial_year'),
                'tax_desc' => $request->input('tax_desc'),
                'max_amount' => $request->input('max_amount'),
                'form_xvi_ref' => $request->input('form_xvi_ref'),
                'itax_form_ref' => $request->input('itax_form_ref')
            );

            // print_r($data);
            // die();
            $income_tax = new Itax_type_master();

            $income_tax->create($data);
            Session::flash('message', 'Income Tax Type Master Information Successfully Saved.');

            return redirect('itax/income-tax-type');
        } else {
            return redirect('/');
        }
    }
     
    public function editIncometaxType($id)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['income_tax'] = Itax_type_master::where('id', '=', $id)->first();
            return view('incometax/edit-income-tax-type', $data);
        } else {
            return redirect('/');
        }
    }

    public function updateIncometaxType(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'financial_year' => 'required',
                    'tax_desc' => 'required',
                    'max_amount' => 'required'

                ],
                [
                    'financial_year.required' => 'Financial Year Required',
                    'tax_desc.required' => 'Income Tax Type Description Required',
                    'max_amount.required' => 'Max Amount Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('itax/edit-income-tax-type')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'financial_year' => $request->input('financial_year'),
                'tax_desc' => $request->input('tax_desc'),
                'max_amount' => $request->input('max_amount'),
                'form_xvi_ref' => $request->input('form_xvi_ref'),
                'itax_form_ref' => $request->input('itax_form_ref')
            );

            // print_r($data);
            // die();
            Itax_type_master::where('id', $request['id'])->update($data);
            Session::flash('message', 'Income Tax Type Master Information Successfully Updated.');
            return redirect('itax/income-tax-type');
        } else {
            return redirect('/');
        }
    }

    public function deleteIncometaxType($id)
    {
        if (!empty(Session::get('admin'))) {
            $dataUpdate = Itax_type_master::where('id', $id)->delete();
            Session::flash('message', 'Income Tax Type Master Information Successfully Deleted.');
            return redirect('itax/income-tax-type');
        } else {
            return redirect('/');
        }
    }

    public function getItaxTypeByFiscalYear($fyear)
    {
        $fiscal_year=base64_decode($fyear);
        $income_tax = Itax_type_master::where('financial_year', '=', $fiscal_year)->get();
        return json_encode(['itypes'=>$income_tax,'status'=>1]);
    }

}
