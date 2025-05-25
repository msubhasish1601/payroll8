<?php

namespace App\Http\Controllers\Masters;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\P_tax_slab;
use Validator;
use Session;
use View;
use Illuminate\Support\Facades\Input;
use Auth;

class TaxSlabController extends Controller
{
    public function getTaxSlab()
    {
        if (!empty(Session::get('admin'))) {

            $tax_slab = P_tax_slab::get();
            return view('masters/tax-slab', compact('tax_slab'));
        } else {
            return redirect('/');
        }
    }

    public function addTaxSlab()
    {
        if (!empty(Session::get('admin'))) {

            return view('masters/add-tax-slab');
        } else {
            return redirect('/');
        }
    }

    public function saveTaxSlab(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'salary_from' => 'required',
                    'salary_to' => 'required',
                    'p_tax_amount' => 'required'

                ],
                [
                    'salary_from.required' => 'Salary From Required',
                    'salary_to.required' => 'Salary To Required',
                    'p_tax_amount.required' => 'P Tax Amount Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('masters/add-tax-slab')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'salary_from' => $request->input('salary_from'),
                'salary_to' => $request->input('salary_to'),
                'p_tax_amount' => $request->input('p_tax_amount')
            );


            $tax_slab = new P_tax_slab();
            $tax_slab->create($data);
            Session::flash('message', 'P Tax Slab Information Successfully Saved.');

            return redirect('masters/tax-slab');
        } else {
            return redirect('/');
        }
    }

    public function editTaxSlab($id)
    {
        if (!empty(Session::get('admin'))) {

            $data['tax_slab'] = P_tax_slab::where('id', '=', $id)->first();
            // print_r("<pre>");
            // print_r($data);
            // die();
            return view('masters/edit-tax-slab', $data);
        } else {
            return redirect('/');
        }
    }

    public function updateTaxSlab(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'salary_from' => 'required',
                    'salary_to' => 'required',
                    'p_tax_amount' => 'required'

                ],
                [
                    'salary_from.required' => 'Salary From Required',
                    'salary_to.required' => 'Salary To Required',
                    'p_tax_amount.required' => 'P Tax Amount Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('masters/add-tax-slab')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'salary_from' => $request->input('salary_from'),
                'salary_to' => $request->input('salary_to'),
                'p_tax_amount' => $request->input('p_tax_amount')
            );

            P_tax_slab::where('id', $request['id'])->update($data);
            Session::flash('message', 'P Tax Slab Information Successfully Updated.');
            return redirect('masters/tax-slab');
        } else {
            return redirect('/');
        }
    }

    public function deleteTaxSlab($id)
    {
        if (!empty(Session::get('admin'))) {

				$dataUpdate = P_tax_slab::where('id', $id)->delete();
                Session::flash('message', 'P Tax Slab Information Successfully Deleted.');
				return redirect('masters/tax-slab');
			
        } else {
            return redirect('/');
        }
    }


}
