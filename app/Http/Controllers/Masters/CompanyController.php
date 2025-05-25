<?php

namespace App;

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Company;
use App\Models\Masters\Role_authorization;
use Illuminate\Http\Request;
use Session;
use Validator;
use View;

class CompanyController extends Controller
{
    //

    public function getCompanies()
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $companies_rs = Company::all();
            $data['companies_rs'] = $companies_rs;
            return view('masters/view-company', $data);
        } else {
            return redirect('/');
        }
    }

    public function addCompanies()
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            return view('masters/add-company', $data);
        } else {
            return redirect('/');
        }
    }

    public function editCompany($id)
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            if ($id != '') {

                $data['CompanyData'] = Company::where('id', '=', $id)->get();
                return view('masters/edit-company', $data);
            } else {
                return view('masters/edit-company', $data);
            }
        } else {
            return redirect('/');
        }
    }

    public function saveCompany(Request $request)
    {

        if (!empty(Session::get('admin'))) {

            $filename = '';

            if (is_numeric($request->company_name) == 1) {
                Session::flash('error', 'Company Name Should not be numeric.');
                return redirect('masters/vw-company');
            }

            $validator = Validator::make(
                $request->all(),
                [
                    'company_name' => 'required|max:100',
                    'company_address' => 'required|max:255',
                    'company_phone' => 'required',
                    'company_cin' => 'required',
                    'company_pan' => 'required|max:10',
                ],
                [
                    'company_name.required' => 'Company Name Required',
                    'company_address.required' => 'Company Address Required',
                    'company_phone.required' => 'Company Phone Required',
                    'company_cin.required' => 'CIN Required',
                    'company_pan.required' => 'Company Pan Required',
                ]
            );

            if ($validator->fails()) {
                return redirect('masters/company')
                    ->withErrors($validator)
                    ->withInput();
            }

            //$companies=$request->all();

            $data = request()->except(['_token', 'company_logo', 'c_id']);
            if ($request->hasFile('company_logo')) {
                $files = $request->file('company_logo');
                $extension = $request->company_logo->extension();
                $filename = $request->company_logo->store('company_logo', 'public');
                $data['company_logo'] = $filename;
            }

            //echo $request->company_name; exit;
            $check_company_name = Company::where('company_name', trim($request->company_name))->first();
            if (!empty($check_company_name)) {
                Session::flash('error', 'Company Alredy Exists.');
                return redirect('masters/vw-company');
            }
            $company = new Company();
            $company->create($data);
            Session::flash('message', 'Company Information Successfully saved.');
            return redirect('masters/vw-company');
        } else {
            return redirect('/');
        }
    }

    public function updateCompany(Request $request)
    {

        if (!empty(Session::get('admin'))) {

            $filename = '';

            if (is_numeric($request->company_name) == 1) {
                Session::flash('error', 'Company Name Should not be numeric.');
                return redirect('masters/vw-company');
            }

            $validator = Validator::make(
                $request->all(),
                [
                    'company_name' => 'required|max:100',
                    'company_address' => 'required|max:255',
                    'company_phone' => 'required',
                    'company_cin' => 'required',
                    'company_pan' => 'required|max:10',
                ],
                [
                    'company_name.required' => 'Company Name Required',
                    'company_address.required' => 'Company Address Required',
                    'company_phone.required' => 'Company Phone Required',
                    'company_cin.required' => 'CIN Required',
                    'company_pan.required' => 'Company Pan Required',
                ]
            );

            if ($validator->fails()) {
                return redirect('masters/vw-company')
                    ->withErrors($validator)
                    ->withInput();
            }

            //$companies=$request->all();

            $data = request()->except(['_token', 'company_logo', 'c_id']);

            if ($request->hasFile('company_logo')) {
                $files = $request->file('company_logo');
                $extension = $request->company_logo->extension();
                $filename = $request->company_logo->store('company_logo', 'public');
                $data['company_logo'] = $filename;
            }

            Company::where('id', $request->id)->update($data);
            Session::flash('message', 'Company Information Successfully updated.');
            return redirect('masters/vw-company');
        } else {
            return redirect('/');
        }
    }
}
