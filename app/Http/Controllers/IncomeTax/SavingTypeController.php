<?php

namespace App\Http\Controllers\IncomeTax;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Role_authorization;
use App\Models\IncomeTax\Itax_type_master;
use App\Models\IncomeTax\Saving_type_master;
use Validator;
use Session;
use View;
use Illuminate\Support\Facades\Input;
use Auth;

class SavingTypeController extends Controller
{

    public function getSavingType()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['saving_type'] =$saving_type = Saving_type_master::leftJoin('itax_type_masters', 'itax_type_masters.id', '=', 'saving_type_masters.i_tax_type')
                ->select('saving_type_masters.*', 'itax_type_masters.tax_desc')
                ->get();

            return view('incometax/saving-type', $data);
        } else {
            return redirect('/');
        }
    }

    public function addSavingType()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $curr_fiscal_yr=date('Y').'-'.(date('Y')+1);

            $data['income_tax'] =$income_tax = Itax_type_master::where('financial_year','=',$curr_fiscal_yr)->get();
            return view('incometax/add-saving-type', $data);
        } else {
            return redirect('/');
        }
    }

    public function saveSavingType(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'financial_year' => 'required',
                    'i_tax_type' => 'required',
                    'saving_type_desc' => 'required',
                    'max_amount' => 'required'

                ],
                [
                    'financial_year.required' => 'Financial Year Required',
                    'i_tax_type.required' => 'Income Tax Type Required',
                    'saving_type_desc.required' => 'Saving Type Description Required',
                    'max_amount.required' => 'Maximum Amount Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('itax/add-saving-type')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'financial_year' => $request->input('financial_year'),
                'i_tax_type' => $request->input('i_tax_type'),
                'saving_type_desc' => $request->input('saving_type_desc'),
                'income_tax_repo_ref' => $request->input('income_tax_repo_ref'),
                'form_xvi_ref' => $request->input('form_xvi_ref'),
                'max_amount' => $request->input('max_amount')
            );

            // print_r($data);
            // die();
            $saving_type = new Saving_type_master();

            $saving_type->create($data);
            Session::flash('message', 'Savings Type Master Information Successfully Saved.');

            return redirect('itax/saving-type');
        } else {
            return redirect('/');
        }
    }

    public function editSavingType($id)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['saving_type'] = Saving_type_master::leftJoin('itax_type_masters', 'itax_type_masters.id', '=', 'saving_type_masters.i_tax_type')
                ->select('saving_type_masters.*', 'itax_type_masters.tax_desc')
                ->where('saving_type_masters.id', '=', $id)->first();

                $curr_fiscal_yr=$data['saving_type']->financial_year;

                $data['income_tax'] =$income_tax = Itax_type_master::where('financial_year','=',$curr_fiscal_yr)->get();
            
            return view('incometax/edit-saving-type', $data);
        } else {
            return redirect('/');
        }
    }

    public function updateSavingType(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'financial_year' => 'required',
                    'i_tax_type' => 'required',
                    'saving_type_desc' => 'required',
                    'max_amount' => 'required'

                ],
                [
                    'financial_year.required' => 'Financial Year Required',
                    'i_tax_type.required' => 'Income Tax Type Required',
                    'saving_type_desc.required' => 'Saving Type Description Required',
                    'max_amount.required' => 'Maximum Amount Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('itax/edit-saving-type')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'financial_year' => $request->input('financial_year'),
                'i_tax_type' => $request->input('i_tax_type'),
                'saving_type_desc' => $request->input('saving_type_desc'),
                'income_tax_repo_ref' => $request->input('income_tax_repo_ref'),
                'form_xvi_ref' => $request->input('form_xvi_ref'),
                'max_amount' => $request->input('max_amount')
            );

            // print_r($data);
            // die();
            Saving_type_master::where('id', $request['id'])->update($data);
            Session::flash('message', 'Savings Type Master Information Successfully Updated.');
            return redirect('itax/saving-type');
        } else {
            return redirect('/');
        }
    }

    public function deleteSavingType($id)
    {
        if (!empty(Session::get('admin'))) {
            $dataUpdate = Saving_type_master::where('id', $id)->delete();
            Session::flash('message', 'Savings Type Master Information Successfully Deleted.');
            return redirect('itax/saving-type');
        } else {
            return redirect('/');
        }
    }

    public function getSavingsTypeByTaxType($taxtypeid)
    {
        $itax_type_id=base64_decode($taxtypeid);
        $income_tax = Saving_type_master::where('i_tax_type', '=', $itax_type_id)->get();
        return json_encode(['stypes'=>$income_tax,'status'=>1]);
    }


}
