<?php

namespace App\Http\Controllers\Masters;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Itax_max_saving_master;
use Validator;
use Session;
use View;
use Illuminate\Support\Facades\Input;
use Auth;

class ITaxMaxSavingController extends Controller
{

    public function getITaxMaxSaving()
    {
        if (!empty(Session::get('admin'))) {

            $tax_max_saving = Itax_max_saving_master::get();

            return view('masters/itax-max-saving', compact('tax_max_saving'));
        } else {
            return redirect('/');
        }
    }

    public function addITaxMaxSaving()
    {
        if (!empty(Session::get('admin'))) {

            return view('masters/add-itax-max-saving');
        } else {
            return redirect('/');
        }
    }

    public function saveITaxMaxSaving(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'financial_year' => 'required',
                    'gender' => 'required',
                    'amount' => 'required'

                ],
                [
                    'financial_year.required' => 'Financial Year Required',
                    'gender.required' => 'Gender Required',
                    'amount.required' => 'Amount Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('masters/add-itax-max-saving')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'financial_year' => $request->input('financial_year'),
                'gender' => $request->input('gender'),
                'amount' => $request->input('amount')
            );

            // print_r($data);
            // die();
            $tax_rate = new Itax_max_saving_master();

            $tax_rate->create($data);
            Session::flash('message', 'Income Tax Max Saving Master Information Successfully Saved.');

            return redirect('masters/itax-max-saving');
        } else {
            return redirect('/');
        }
    }

    public function editITaxMaxSaving($id)
    {
        if (!empty(Session::get('admin'))) {

            $data['tax_max'] = Itax_max_saving_master::where('id', '=', $id)->first();
            
            return view('masters/edit-itax-max-saving', $data);
        } else {
            return redirect('/');
        }
    }

    public function updateITaxMaxSaving(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'financial_year' => 'required',
                    'gender' => 'required',
                    'amount' => 'required'

                ],
                [
                    'financial_year.required' => 'Financial Year Required',
                    'gender.required' => 'Gender Required',
                    'amount.required' => 'Amount Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('masters/add-itax-max-saving')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'financial_year' => $request->input('financial_year'),
                'gender' => $request->input('gender'),
                'amount' => $request->input('amount')
            );

            // print_r($data);
            // die();
            Itax_max_saving_master::where('id', $request['id'])->update($data);
            Session::flash('message', 'Income Tax Max Saving Master Information Successfully Updated.');
            return redirect('masters/itax-max-saving');
        } else {
            return redirect('/');
        }
    }

    public function deleteITaxMaxSaving($id)
    {
        if (!empty(Session::get('admin'))) {
            $dataUpdate = Itax_max_saving_master::where('id', $id)->delete();
            Session::flash('message', 'Income Tax Max Saving Master Information Successfully Deleted.');
            return redirect('masters/itax-max-saving');
        } else {
            return redirect('/');
        }
    }
}
