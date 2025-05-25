<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\I_tax_rate_slab_master;
use App\Models\Masters\Role_authorization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;
use Validator;
use View;

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

            return view('masters/itax-rate-slab', $data);
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

            return view('masters/add-itax-rate-slab', $data);
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
                    'financial_year' => 'required',

                ],
                [
                    'amount_from.required' => 'Amount From Required',
                    'amount_to.required' => 'Amount To Required',
                    'percentage.required' => 'Percentage Required',
                    'gender.required' => 'Gender Required',
                    'additional_amount.required' => 'Additional Amount Required',
                    'financial_year.required' => 'Financial Year Required',

                ]
            );

            if ($validator->fails()) {
                return redirect('masters/add-itax-rate-slab')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'amount_from' => $request->input('amount_from'),
                'amount_to' => $request->input('amount_to'),
                'percentage' => $request->input('percentage'),
                'gender' => $request->input('gender'),
                'additional_amount' => $request->input('additional_amount'),
                'financial_year' => $request->input('financial_year'),
            );

            // print_r($data);
            // die();
            $tax_rate = new I_tax_rate_slab_master();

            $tax_rate->create($data);
            Session::flash('message', 'Income Tax Rate Slab Master Information Successfully Saved.');

            return redirect('masters/itax-rate-slab');
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

            return view('masters/edit-itax-rate-slab', $data);
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
                    'financial_year' => 'required',

                ],
                [
                    'amount_from.required' => 'Amount From Required',
                    'amount_to.required' => 'Amount To Required',
                    'percentage.required' => 'Percentage Required',
                    'gender.required' => 'Gender Required',
                    'additional_amount.required' => 'Additional Amount Required',
                    'financial_year.required' => 'Financial Year Required',

                ]
            );

            if ($validator->fails()) {
                return redirect('masters/edit-itax-rate-slab')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'amount_from' => $request->input('amount_from'),
                'amount_to' => $request->input('amount_to'),
                'percentage' => $request->input('percentage'),
                'gender' => $request->input('gender'),
                'additional_amount' => $request->input('additional_amount'),
                'financial_year' => $request->input('financial_year'),
            );

            // print_r($data);
            // die();
            I_tax_rate_slab_master::where('id', $request['id'])->update($data);
            Session::flash('message', 'Income Tax Rate Slab Master Information Successfully Updated.');
            return redirect('masters/itax-rate-slab');
        } else {
            return redirect('/');
        }
    }

    public function deleteITaxRateSlab($id)
    {
        if (!empty(Session::get('admin'))) {
            $dataUpdate = I_tax_rate_slab_master::where('id', $id)->delete();
            Session::flash('message', 'Income Tax Rate Slab Master Information Successfully Deleted.');
            return redirect('masters/itax-rate-slab');
        } else {
            return redirect('/');
        }
    }
}
