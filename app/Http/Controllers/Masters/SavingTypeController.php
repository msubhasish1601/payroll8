<?php

namespace App\Http\Controllers\Masters;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Itax_type_master;
use App\Models\Masters\Saving_type_master;
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

            $saving_type = Saving_type_master::leftJoin('itax_type_masters', 'itax_type_masters.id', '=', 'saving_type_masters.i_tax_type')
                ->select('saving_type_masters.*', 'itax_type_masters.tax_type')
                ->get();

            return view('masters/saving-type', compact('saving_type'));
        } else {
            return redirect('/');
        }
    }

    public function addSavingType()
    {
        if (!empty(Session::get('admin'))) {
            $income_tax = Itax_type_master::get();
            return view('masters/add-saving-type', compact('income_tax'));
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
                return redirect('masters/add-saving-type')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'financial_year' => $request->input('financial_year'),
                'i_tax_type' => $request->input('i_tax_type'),
                'saving_type_desc' => $request->input('saving_type_desc'),
                'max_amount' => $request->input('max_amount')
            );

            // print_r($data);
            // die();
            $saving_type = new Saving_type_master();

            $saving_type->create($data);
            Session::flash('message', 'Savings Type Master Information Successfully Saved.');

            return redirect('masters/saving-type');
        } else {
            return redirect('/');
        }
    }

    public function editSavingType($id)
    {
        if (!empty(Session::get('admin'))) {

            $data['saving_type'] = Saving_type_master::leftJoin('itax_type_masters', 'itax_type_masters.id', '=', 'saving_type_masters.i_tax_type')
                ->select('saving_type_masters.*', 'itax_type_masters.tax_desc')
                ->where('saving_type_masters.id', '=', $id)->first();
            $data['tax_type'] = Itax_type_master::get();
            
            return view('masters/edit-saving-type', $data);
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
                return redirect('masters/edit-saving-type')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'financial_year' => $request->input('financial_year'),
                'i_tax_type' => $request->input('i_tax_type'),
                'saving_type_desc' => $request->input('saving_type_desc'),
                'max_amount' => $request->input('max_amount')
            );

            // print_r($data);
            // die();
            Saving_type_master::where('id', $request['id'])->update($data);
            Session::flash('message', 'Savings Type Master Information Successfully Updated.');
            return redirect('masters/saving-type');
        } else {
            return redirect('/');
        }
    }

    public function deleteSavingType($id)
    {
        if (!empty(Session::get('admin'))) {
            $dataUpdate = Saving_type_master::where('id', $id)->delete();
            Session::flash('message', 'Savings Type Master Information Successfully Deleted.');
            return redirect('masters/saving-type');
        } else {
            return redirect('/');
        }
    }
}
