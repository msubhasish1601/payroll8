<?php

namespace App\Http\Controllers\Masters;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Itax_extra_deduction;
use Validator;
use Session;
use View;
use Illuminate\Support\Facades\Input;
use Auth;

class ITaxExtraDeductionController extends Controller
{

    public function getITaxExtraDeduction()
    {
        if (!empty(Session::get('admin'))) {

            $tax_extra_deduction = Itax_extra_deduction::get();

            return view('masters/itax-extra-deduction', compact('tax_extra_deduction'));
        } else {
            return redirect('/');
        }
    }

    public function addITaxExtraDeduction()
    {
        if (!empty(Session::get('admin'))) {

            return view('masters/add-itax-extra-deduction');
        } else {
            return redirect('/');
        }
    }

    public function saveITaxExtraDeduction(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'financial_year' => 'required',
                    'percentage' => 'required',
                    'amount_greater' => 'required',
                    'extra_desc' => 'required',
                    'extra_type' => 'required'

                ],
                [
                    'financial_year.required' => 'Financial Year Required',
                    'percentage.required' => 'Percentage Required',
                    'amount_greater.required' => 'Amount Greater Required',
                    'extra_desc.required' => 'Extra Description Required',
                    'extra_type.required' => 'Extra Type Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('masters/add-itax-extra-deduction')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'financial_year' => $request->input('financial_year'),
                'percentage' => $request->input('percentage'),
                'amount_greater' => $request->input('amount_greater'),
                'extra_desc' => $request->input('extra_desc'),
                'extra_type' => $request->input('extra_type')
            );

            // print_r($data);
            // die();
            $tax_rate = new Itax_extra_deduction();

            $tax_rate->create($data);
            Session::flash('message', 'Income Tax Extra Deduction Information Successfully Saved.');

            return redirect('masters/itax-extra-deduction');
        } else {
            return redirect('/');
        }
    }

    public function editITaxExtraDeduction($id)
    {
        if (!empty(Session::get('admin'))) {

            $data['tax_extra'] = Itax_extra_deduction::where('id', '=', $id)->first();
            
            return view('masters/edit-itax-extra-deduction', $data);
        } else {
            return redirect('/');
        }
    }

    public function updateITaxExtraDeduction(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'financial_year' => 'required',
                    'percentage' => 'required',
                    'amount_greater' => 'required',
                    'extra_desc' => 'required',
                    'extra_type' => 'required'

                ],
                [
                    'financial_year.required' => 'Financial Year Required',
                    'percentage.required' => 'Percentage Required',
                    'amount_greater.required' => 'Amount Greater Required',
                    'extra_desc.required' => 'Extra Description Required',
                    'extra_type.required' => 'Extra Type Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('masters/edit-itax-extra-deduction')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'financial_year' => $request->input('financial_year'),
                'percentage' => $request->input('percentage'),
                'amount_greater' => $request->input('amount_greater'),
                'extra_desc' => $request->input('extra_desc'),
                'extra_type' => $request->input('extra_type')
            );

            // print_r($data);
            // die();
            Itax_extra_deduction::where('id', $request['id'])->update($data);
            Session::flash('message', 'Income Tax Extra Deduction Information Successfully Updated.');
            return redirect('masters/itax-extra-deduction');
        } else {
            return redirect('/');
        }
    }

    public function deleteITaxExtraDeduction($id)
    {
        if (!empty(Session::get('admin'))) {
            $dataUpdate = Itax_extra_deduction::where('id', $id)->delete();
            Session::flash('message', 'Income Tax Extra Deduction Information Successfully Deleted.');
            return redirect('masters/itax-extra-deduction');
        } else {
            return redirect('/');
        }
    }
}
