<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Bank;
use App\Models\Masters\Company_bank;
use App\Models\Masters\Role_authorization;
use Illuminate\Http\Request;
use Session;
use view;

class CompanyBankController extends Controller
{

    public function getCompanyBankListing()
    {
        if (!empty(Session::get('admin'))) {
            try {
                //$data['company_bank_listing']  = CompanyBank::all();
                $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                    ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                    ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                    ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                    ->where('member_id', '=', Session::get('adminusernmae'))
                    ->get();

                $data['company_bank_listing'] = Company_bank::orderBy('id', 'desc')->get();
                //->leftJoin('bank_masters', 'company_bank.bank_name', '=', 'bank_masters.master_bank_name')

            } catch (Exception $e) {

                return $e->getMessage();
            }
            return view('masters/view-company-banks', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewCompanyAddBank()
    {
        if (!empty(Session::get('admin'))) {

            try {
            } catch (Exception $e) {

                return $e->getMessage();
            }
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $data['MastersbankName'] = Bank::getMastersBank();
            return view('masters/add-company-bank', $data);
        } else {
            return redirect('/');
        }
    }

    public function saveCompanyBank(Request $request)
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

                $companybank = new Company_bank();
                $data['bank_name'] = $request->bank_id;
                $data['branch_name'] = $request->branch_name;
                $data['ifsc_code'] = $request->ifsc_code;
                $data['micr_code'] = $request->micr_code;
                $data['opening_balance'] = $request->opening_balance;
                $data['financial_year'] = $request->financial_year;
                $data['bank_status'] = "active";
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['account_code'] = $request->account_code;

                $companybank->create($data);
                $request->session()->flash('status', 'success');
                $request->session()->flash('message', 'Record successfully added!');
            } catch (Exception $e) {

                $request->session()->flash('status', 'error');
                $request->session()->flash('error', 'Some error occured');
            }
            return redirect('masters/company_banklisting');
        } else {
            return redirect('/');
        }
    }

    public function updateCompanyBank(Request $request)
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

                $companybank = new Company_bank();
                $data['bank_name'] = $request->bank_id;
                $data['branch_name'] = $request->branch_name;
                $data['ifsc_code'] = $request->ifsc_code;
                $data['micr_code'] = $request->micr_code;
                $data['opening_balance'] = $request->opening_balance;
                $data['financial_year'] = $request->financial_year;
                $data['bank_status'] = "active";
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['account_code'] = $request->account_code;

                Company_bank::where('id', $request->bankid)
                    ->update(['bank_status' => $request->bank_status]);
                $request->session()->flash('status', 'success');
                $request->session()->flash('message', 'Record Update Successfully!');
            } catch (Exception $e) {

                $request->session()->flash('status', 'error');
                $request->session()->flash('error', 'Some error occured');
            }
            return redirect('masters/company_banklisting');
        } else {
            return redirect('/');
        }
    }

    public function getCompanyBankDtl($bank_id)
    {
        if (!empty(Session::get('admin'))) {

            try {

                $data['bankdetails'] = Company_bank::find($bank_id);
            } catch (Exception $e) {
                return $e->getMessage();
            }
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $data['MastersbankName'] = Bank::getMastersBank();

            return view('masters/edit-company-bank', $data);
        } else {
            return redirect('/');
        }
    }
}
