<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Masters\GpfBank;
use App\Models\Masters\Bank;
use App\Models\Masters\Gpf_bank;
use view;
use Validator;
use Session;
use Illuminate\Support\Facades\Input;

class GpfBankController extends Controller
{

	public function getGpfBankListing()
	{
		if (!empty(Session::get('admin'))) {

			try {
				//$data['company_bank_listing']  = CompanyBank::all();

				$data['company_bank_listing'] = Gpf_bank::orderBy('id', 'desc')->get();
				//->leftJoin('bank_masters', 'company_bank.bank_name', '=', 'bank_masters.master_bank_name') 


			} catch (Exception $e) {

				return $e->getMessage();
			}
			return view('masters/view-gpf-banks', $data);
		} else {
			return redirect('/');
		}
	}


	public function viewGpfAddBank()
	{
		if (!empty(Session::get('admin'))) {

			try {
			} catch (Exception $e) {

				return $e->getMessage();
			}
			$data['MastersbankName'] = Bank::getMastersBank();
			return view('masters/add-gpf-bank', $data);
		} else {
			return redirect('/');
		}
	}



	public function saveGpfBank(Request $request)
	{
		if (!empty(Session::get('admin'))) {

			//print_r($request->all()); exit;
			try {

				if (strlen($request->ifsc_code) < 11 || strlen($request->ifsc_code) > 11) {

					$request->session()->flash('status', 'success');
					$request->session()->flash('error', 'Invalid IFSC Code');
					return redirect('masters/company_banklisting');
				}


				if (!is_numeric($request->opening_balance)) {

					$request->session()->flash('status', 'success');
					$request->session()->flash('error', 'Wrong format for Opening Balance !');
					return redirect('masters/company_banklisting');
				}

				$gpfbank = new Gpf_bank();
				$data['bank_name'] = $request->bank_id;
				$data['branch_name'] = $request->branch_name;
				$data['ifsc_code'] = $request->ifsc_code;
				$data['micr_code'] = $request->micr_code;
				$data['opening_balance'] = $request->opening_balance;
				$data['financial_year'] = $request->financial_year;
				$data['bank_status'] = "active";
				$data['created_at'] = date('Y-m-d H:i:s');

				$gpfbank->create($data);
				$request->session()->flash('status', 'success');
				$request->session()->flash('message', 'Record successfully added!');
			} catch (Exception $e) {

				$request->session()->flash('status', 'error');
				$request->session()->flash('error', 'Some error occured');
			}
			return redirect('masters/gpf_banklisting');
		} else {
			return redirect('/');
		}
	}



	public function getGpfBankDtl($bank_id)
	{

		if (!empty(Session::get('admin'))) {

			try {

				$data['bankdetails'] = Gpf_bank::find($bank_id);
			} catch (Exception $e) {
				return $e->getMessage();
			}
			$data['MastersbankName'] = Bank::getMastersBank();
			return view('masters/edit-gpf-bank', $data);
		} else {
			return redirect('/');
		}
	}

	public function updateGpfBank(Request $request)
	{
		if (!empty(Session::get('admin'))) {

			//print_r($request->all()); exit;
			try {

				if (strlen($request->ifsc_code) < 11 || strlen($request->ifsc_code) > 11) {

					$request->session()->flash('status', 'success');
					$request->session()->flash('error', 'Invalid IFSC Code');
					return redirect('masters/company_banklisting');
				}


				if (!is_numeric($request->opening_balance)) {

					$request->session()->flash('status', 'success');
					$request->session()->flash('error', 'Wrong format for Opening Balance !');
					return redirect('masters/company_banklisting');
				}

				$gpfbank = new Gpf_bank();
				$data['bank_name'] = $request->bank_id;
				$data['branch_name'] = $request->branch_name;
				$data['ifsc_code'] = $request->ifsc_code;
				$data['micr_code'] = $request->micr_code;
				$data['opening_balance'] = $request->opening_balance;
				$data['financial_year'] = $request->financial_year;
				$data['bank_status'] = "active";
				$data['created_at'] = date('Y-m-d H:i:s');

				if (empty($request->bankid)) {
					$gpfbank->create($data);
					$request->session()->flash('status', 'success');
					$request->session()->flash('message', 'Record successfully added!');
				} else {

					Gpf_bank::where('id', $request->bankid)
						->update(['bank_status' => $request->bank_status]);
					$request->session()->flash('status', 'success');
					$request->session()->flash('message', 'Record Update Successfully!');
				}
			} catch (Exception $e) {

				$request->session()->flash('status', 'error');
				$request->session()->flash('error', 'Some error occured');
			}
			return redirect('masters/gpf_banklisting');
		} else {
			return redirect('/');
		}
	}
}
