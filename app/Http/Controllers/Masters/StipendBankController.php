<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Stipend_bank;
use view;
use Validator;
use Session;
use Illuminate\Support\Facades\Input;

class StipendBankController extends Controller
{

	public function getStipendBank()
	{
		if (!empty(Session::get('admin'))) {

			$bank_rs = Stipend_bank::getMasterAndBank();
			//print_r($bank_rs); exit;
			return view('masters/view-stipend-banks', compact('bank_rs'));
		} else {
			return redirect('/');
		}
	}

	public function AddStipendBank()
	{

		if (!empty(Session::get('admin'))) {

			$data['MastersbankName'] = Stipend_bank::getMastersBank();
			//print_r($data['master_bank_name']); exit;
			return view('masters/add-stipend-bank', $data);
		} else {
			return redirect('/');
		}
	}

	public function editAddStipendBank($id)
	{

		if (!empty(Session::get('admin'))) {

			$data['bankdetails'] = Stipend_bank::where('id', $id)->get()->toArray();
			$data['MastersbankName'] = Stipend_bank::getMastersBank();
			//print_r($data['MastersbankName']);die;
			return view('masters/edit-stipend-bank', $data);
		} else {
			return redirect('/');
		}
	}

	public function saveStipendBank(Request $request)
	{

		if (!empty(Session::get('admin'))) {

			if (is_numeric($request->branch_name) == 1) {
				Session::flash('error', 'Branch Name Should not be numeric.');
				return redirect('masters/vw-stipend-bank');
			}


			$validator = Validator::make(
				$request->all(),
				[
					'bank_name' => 'required|max:255',
					'branch_name' => 'required|max:255',
					'ifsc_code' => 'required|unique:stipend_banks|max:255',
					'swift_code' => 'required|unique:stipend_banks|max:255'
				],
				[
					'bank_name.required' => 'Bank Name Required.',
					'branch_name.required' => 'Branch name Required',
					'branch_name.unique' => 'Branch name already exsits',
					'ifsc_code.required' => 'IFSC name Required',
					'ifsc_code.unique' => 'IFSC name already exsits',
					'swift_code.required' => 'Swift code Name Required',
					'swift_code.unique' => 'Swift code Name already exsits',
					'opening_balance.required' => 'Opening Balance  Required',
					'financial_year.required' => 'Financial Year Required'
				]
			);

			if ($validator->fails()) {
				return redirect('masters/vw-stipend-bank')
					->withErrors($validator)
					->withInput();
			} else {

				$data = request()->all();
				$bank = new Stipend_bank();
				//print_r($data); exit;
				$bank->create($data);
				Session::flash('message', 'Stipend Bank Information Successfully saved.');
				return redirect('masters/vw-stipend-bank');
			}
		} else {
			return redirect('/');
		}
	}


	public function updateStipendBank(Request $request)
	{

		if (!empty(Session::get('admin'))) {

			if (is_numeric($request->branch_name) == 1) {
				Session::flash('error', 'Branch Name Should not be numeric.');
				return redirect('masters/vw-stipend-bank');
			}

			if ($request->bankid) {

				$data = array(
					'bank_name' => $request->bank_name,
					'branch_name' => $request->branch_name,
					'ifsc_code' => $request->ifsc_code,
					'swift_code' => $request->swift_code,
					'created_at' => date('Y-m-d h:i:s'),
					'updated_at' => date('Y-m-d h:i:s'),
					// 'bank_status' => $request->des_status,
					'opening_balance' => $request->opening_balance,
					'financial_year' => $request->financial_year,
				);
				Stipend_bank::where('id', $request->bankid)->update($data);
				Session::flash('message', 'Stipend Bank Information Successfully Updated.');
				return redirect('masters/vw-stipend-bank');
			} else {
				$validator = Validator::make(
					$request->all(),
					[
						'bank_name' => 'required|max:255',
						'branch_name' => 'required|max:255',
						'ifsc_code' => 'required|unique:stipend_bank|max:255',
						'swift_code' => 'required|unique:stipend_bank|max:255'
					],
					[
						'bank_name.required' => 'Bank Name Required.',
						'branch_name.required' => 'Branch name Required',
						'branch_name.unique' => 'Branch name already exsits',
						'ifsc_code.required' => 'IFSC name Required',
						'ifsc_code.unique' => 'IFSC name already exsits',
						'swift_code.required' => 'Swift code Name Required',
						'swift_code.unique' => 'Swift code Name already exsits',
						'opening_balance.required' => 'Opening Balance  Required',
						'financial_year.required' => 'Financial Year Required'
					]
				);

				if ($validator->fails()) {
					return redirect('masters/stipendbank')
						->withErrors($validator)
						->withInput();
				} else {

					$data = request()->all();
					$bank = new Stipend_bank();
					//print_r($data); exit;
					$bank->create($data);
					Session::flash('message', 'Stipend Bank Information Successfully saved.');
					return redirect('masters/vw-stipend-bank');
				}
			}
		} else {
			return redirect('/');
		}
	}
}
