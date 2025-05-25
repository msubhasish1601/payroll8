<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Loan_configuration;
use App\Models\Masters\Loan_master;
use Illuminate\Http\Request;
use App\Models\Masters\Role_authorization;
use View;
use Validator;
use Session;
use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;

class LoanController extends Controller
{


	public function loanListing()
	{
		if (!empty(Session::get('admin'))) {

			$email = Session::get('adminusernmae');
			$data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
				->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
				->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
				->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
				->where('member_id', '=', $email)
				->get();
			try {
				$data['loanlisting']  = Loan_master::all();
			} catch (Exception $e) {

				return $e->getMessage();
			}

			return view('masters/loanlist', $data);
		} else {
			return redirect('/');
		}
	}


	public function viewLoan()
	{
		if (!empty(Session::get('admin'))) {

			$loan_id = 0;
			$loan_rs = Loan_master::all()->last();

			//dd($branch_rs);
			if (!empty($loan_rs)) {
				$loan_id = $loan_rs->id;
				$k = $loan_id + 1;
				if ($k < 10) {
					$loan_code = 'L-' . date('Y') . '-0' . $k;
				}

				if ($k >= 10) {
					$loan_code = 'L-' . date('Y') . '-' . $k;
				}
			} else {
				$k = $loan_id + 1;

				if ($k < 10) {
					$loan_code = 'L-' . date('Y') . '-0' . $k;
				}
			}
			try {
				//$data['coalisting']  = Coa::all();

			} catch (Exception $e) {

				return $e->getMessage();
			}

			return view('masters/vw-loan', compact('loan_code'));
		} else {
			return redirect('/');
		}
	}


	public function saveLoan(Request $request)
	{
		if (!empty(Session::get('admin'))) {


			try {
				$loan = new Loan_master();
				$data['loan_id'] = $request->loan_id;
				$data['loan_type'] = $request->loan_type;
				$data['remarks'] = $request->remarks;
				$data['loan_status'] = $request->loan_status;
				$data['created_at'] = date('Y-m-d');

				if (empty($request['id'])) {

					$loan->create($data);
					$request->session()->flash('status', 'success');
					$request->session()->flash('message', 'Record successfully added!');
				}
			} catch (Exception $e) {

				$request->session()->flash('status', 'error');
				$request->session()->flash('message', 'Some error occured');
			}
			return redirect('masters/loanlisting');
		} else {
			return redirect('/');
		}
	}

	public function updateLoan(Request $request)
	{

		if (!empty(Session::get('admin'))) {

			try {
				$loan = new Loan_master();
				$data['loan_id'] = $request->loan_id;
				$data['loan_type'] = $request->loan_type;
				$data['remarks'] = $request->remarks;
				$data['loan_status'] = $request->loan_status;
				$data['created_at'] = date('Y-m-d');



				Loan_master::where('id', $request['id'])
					->update(['loan_type' => $data['loan_type'], 'remarks' => $data['remarks'], 'loan_status' => $data['loan_status']]);
				$request->session()->flash('status', 'success');
				$request->session()->flash('message', 'Record Update Successfully!');
			} catch (Exception $e) {

				$request->session()->flash('status', 'error');
				$request->session()->flash('message', 'Some error occured');
			}
			return redirect('masters/loanlisting');
		} else {
			return redirect('/');
		}
	}

	/*
	* update Department view
	* created on: 27-07-2016
	*/
	public function getLoanDtl($loan_id)
	{
		if (!empty(Session::get('admin'))) {


			try {

				$data['loan_details'] = Loan_master::find($loan_id);
			} catch (Exception $e) {
				return $e->getMessage();
			}

			return view('masters/edit-loan', $data);
		} else {
			return redirect('/');
		}
	}



	public function loanConListing()
	{
		if (!empty(Session::get('admin'))) {

			$email = Session::get('adminusernmae');

			$data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
				->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
				->join('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
				->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
				->where('member_id', '=', $email)
				->get();

			try {

				$data['loanlisting']  = Loan_configuration::get();
				$data['loanmasterlisting']  = Loan_master::get();
			} catch (Exception $e) {

				return $e->getMessage();
			}
			// print_r($data);
			// die();
			return view('masters/loanlistcon', $data);
		} else {
			return redirect('/');
		}
	}

	public function viewConLoan()
	{
		if (!empty(Session::get('admin'))) {

			$data['loan_rs'] = Loan_master::where('loan_status', '=', 'active')

				->get();
			return view('masters/vw-loancon', $data);
		} else {
			return redirect('/');
		}
	}

	public function saveConLoan(Request $request)
	{

		if (!empty(Session::get('admin'))) {

			try {

				$data['max_sanction_amt'] = $request->max_sanction_amt;
				$data['loan_type'] = $request->loan_type;
				$data['max_time'] = $request->max_time;
				$data['status'] = $request->status;
				$data['rate_of_interest'] = $request->rate_of_interest;
				$data['max_working_time'] = $request->max_working_time;
				if (empty($request['id'])) {
					Loan_configuration::insert($data);

					$request->session()->flash('status', 'success');
					$request->session()->flash('message', 'Record successfully added!');
				}
			} catch (Exception $e) {

				$request->session()->flash('status', 'error');
				$request->session()->flash('message', 'Some error occured');
			}
			return redirect('masters/vw-loan-conf');
		} else {
			return redirect('/');
		}
	}

	public function updateConLoan(Request $request)
	{

		if (!empty(Session::get('admin'))) {

			try {

				$data['max_sanction_amt'] = $request->max_sanction_amt;
				$data['loan_type'] = $request->loan_type;
				$data['max_time'] = $request->max_time;
				$data['status'] = $request->status;
				$data['rate_of_interest'] = $request->rate_of_interest;
				$data['max_working_time'] = $request->max_working_time;


				Loan_configuration::where('id', $request['id'])
					->update([
						'loan_type' => $data['loan_type'], 'max_sanction_amt' => $data['max_sanction_amt'], 'max_time' => $data['max_time'], 'status' => $data['status'], 'rate_of_interest' => $data['rate_of_interest'], 'max_working_time' => $data['max_working_time']



					]);
				$request->session()->flash('status', 'success');
				$request->session()->flash('message', 'Record Update Successfully!');
			} catch (Exception $e) {

				$request->session()->flash('status', 'error');
				$request->session()->flash('message', 'Some error occured');
			}
			return redirect('masters/vw-loan-conf');
		} else {
			return redirect('/');
		}
	}


	public function getConLoanDtl($loan_id)
	{

		if (!empty(Session::get('admin'))) {

			try {

				$data['loan_details'] = Loan_configuration::where('id', '=', $loan_id)
					->first();
				$data['loan_rs'] = Loan_master::where('loan_status', '=', 'active')

					->get();
			} catch (Exception $e) {
				return $e->getMessage();
			}

			return view('masters/edit-loancon', $data);
		} else {
			return redirect('/');
		}
	}
}
