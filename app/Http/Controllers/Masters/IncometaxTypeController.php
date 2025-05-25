<?php

namespace App\Http\Controllers\Masters;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Itax_type_master;
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

            $income_tax = Itax_type_master::get();
            return view('masters/income-tax-type', compact('income_tax'));
        } else {
            return redirect('/');
        }
    }

    public function addIncometaxType()
    {
        if (!empty(Session::get('admin'))) {

            return view('masters/add-income-tax-type');
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
                    'max_amount' => 'required',
                    'tax_type' => 'required'

                ],
                [
                    'financial_year.required' => 'Financial Year Required',
                    'tax_desc.required' => 'Income Tax Type Description Required',
                    'max_amount.required' => 'Max Amount Required',
                    'tax_type.required' => 'Tax Type Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('masters/add-income-tax-type')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'financial_year' => $request->input('financial_year'),
                'tax_desc' => $request->input('tax_desc'),
                'max_amount' => $request->input('max_amount'),
                'tax_type' => $request->input('tax_type')
            );

            // print_r($data);
            // die();
            $income_tax = new Itax_type_master();

            $income_tax->create($data);
            Session::flash('message', 'Income Tax Type Master Information Successfully Saved.');

            return redirect('masters/income-tax-type');
        } else {
            return redirect('/');
        }
    }
     
    public function editIncometaxType($id)
    {
        if (!empty(Session::get('admin'))) {

            $data['income_tax'] = Itax_type_master::where('id', '=', $id)->first();
            return view('masters/edit-income-tax-type', $data);
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
                    'max_amount' => 'required',
                    'tax_type' => 'required'

                ],
                [
                    'financial_year.required' => 'Financial Year Required',
                    'tax_desc.required' => 'Income Tax Type Description Required',
                    'max_amount.required' => 'Max Amount Required',
                    'tax_type.required' => 'Tax Type Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('masters/edit-income-tax-type')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'financial_year' => $request->input('financial_year'),
                'tax_desc' => $request->input('tax_desc'),
                'max_amount' => $request->input('max_amount'),
                'tax_type' => $request->input('tax_type')
            );

            // print_r($data);
            // die();
            Itax_type_master::where('id', $request['id'])->update($data);
            Session::flash('message', 'Income Tax Type Master Information Successfully Updated.');
            return redirect('masters/income-tax-type');
        } else {
            return redirect('/');
        }
    }

    public function deleteIncometaxType($id)
    {
        if (!empty(Session::get('admin'))) {
            $dataUpdate = Itax_type_master::where('id', $id)->delete();
            Session::flash('message', 'Income Tax Type Master Information Successfully Deleted.');
            return redirect('masters/income-tax-type');
        } else {
            return redirect('/');
        }
    }
}
