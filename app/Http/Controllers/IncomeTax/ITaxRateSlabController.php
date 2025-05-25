<?php

namespace App\Http\Controllers\IncomeTax;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Masters\Role_authorization;
use App\Models\IncomeTax\I_tax_rate_slab_master;

use Validator;
use Session;
use View;
use Illuminate\Support\Facades\Input;
use Auth;

class ITaxRateSlabController extends Controller
{

    public function getITaxRateSlab()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['tax_rate_slab'] = I_tax_rate_slab_master::get();

            return view('incometax/itax-rate-slab', $data);
        } else {
            return redirect('/');
        }
    }

    public function addITaxRateSlab()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            return view('incometax/add-itax-rate-slab',$data);
        } else {
            return redirect('/');
        }
    }

    public function saveITaxRateSlab(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'amount_from' => 'required',
                    'amount_to' => 'required',
                    'percentage' => 'required',
                    'gender' => 'required',
                    'additional_amount' => 'required',
                    'financial_year' => 'required'

                ],
                [
                    'amount_from.required' => 'Amount From Required',
                    'amount_to.required' => 'Amount To Required',
                    'percentage.required' => 'Percentage Required',
                    'gender.required' => 'Gender Required',
                    'additional_amount.required' => 'Additional Amount Required',
                    'financial_year.required' => 'Financial Year Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('itax/add-itax-rate-slab')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            //dd( $request->all());
            $data = array(

                'amount_from' => $request->input('amount_from'),
                'amount_to' => $request->input('amount_to'),
                'percentage' => $request->input('percentage'),
                'gender' => $request->input('gender'),
                'additional_amount' => $request->input('additional_amount'),
                'financial_year' => $request->input('financial_year'),
                'no_upper_limit' => $request->input('no_upper_limit')=='-1'?'Y':'N'
            );

            //dd($data);
            
            $tax_rate = new I_tax_rate_slab_master();

            $tax_rate->create($data);
            Session::flash('message', 'Income Tax Rate Slab Master Information Successfully Saved.');

            return redirect('itax/itax-rate-slab');
        } else {
            return redirect('/');
        }
    }

    public function editITaxRateSlab($id)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['tax_rate'] = I_tax_rate_slab_master::where('id', '=', $id)->first();
            
            return view('incometax/edit-itax-rate-slab', $data);
        } else {
            return redirect('/');
        }
    }

    public function updateITaxRateSlab(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'amount_from' => 'required',
                    'amount_to' => 'required',
                    'percentage' => 'required',
                    'gender' => 'required',
                    'additional_amount' => 'required',
                    'financial_year' => 'required'

                ],
                [
                    'amount_from.required' => 'Amount From Required',
                    'amount_to.required' => 'Amount To Required',
                    'percentage.required' => 'Percentage Required',
                    'gender.required' => 'Gender Required',
                    'additional_amount.required' => 'Additional Amount Required',
                    'financial_year.required' => 'Financial Year Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('itax/edit-itax-rate-slab')->withErrors($validator)->withInput();
            }
            // dd($request->all());
            $model = I_tax_rate_slab_master::find($request->id);
            
            $model->amount_from = $request->amount_from;
            $model->amount_to = $request->amount_to;
            $model->percentage = $request->percentage;
            $model->gender = $request->gender;
            $model->additional_amount = $request->additional_amount;
            $model->financial_year = $request->financial_year;
            $model->no_upper_limit = $request->no_upper_limit=='-1'?'Y':'N';
            $model->save();

            Session::flash('message', 'Income Tax Rate Slab Master Information Successfully Updated.');
            return redirect('itax/itax-rate-slab');
        } else {
            return redirect('/');
        }
    }

    public function deleteITaxRateSlab($id)
    {
        if (!empty(Session::get('admin'))) {
            $dataUpdate = I_tax_rate_slab_master::where('id', $id)->delete();
            Session::flash('message', 'Income Tax Rate Slab Master Information Successfully Deleted.');
            return redirect('itax/itax-rate-slab');
        } else {
            return redirect('/');
        }
    }
}
