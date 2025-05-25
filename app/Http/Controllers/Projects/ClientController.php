<?php

namespace App;

namespace App\Http\Controllers\Projects;
use App\Http\Controllers\Controller;
use App\Models\Project\Client;
use App\Models\Project\Role_authorization;
use Illuminate\Http\Request;
use Session;
use Validator;
use View;

class ClientController extends Controller
{
    //

    public function getClients()
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $clients_rs = Client::all();
            $data['clients_rs'] = $clients_rs;
            // dd($data);
            return view('projects/view-client', $data);
        } else {
            return redirect('/');
        }
    }

    public function addClients()
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            return view('projects/add-clients', $data);
        } else {
            return redirect('/');
        }
    }

    public function editClients($id)
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            if ($id != '') {

                $data['ClientData'] = Client::where('id', '=', $id)->first();
                // print_r($data['ClientData']->name);
                // die();
                return view('projects/edit-clients', $data);
            } else {
                return view('projects/edit-clients', $data);
            }
        } else {
            return redirect('/');
        }
    }

    public function saveClients(Request $request)
    {

        if (!empty(Session::get('admin'))) {

            $filename = '';


            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:100',
                    'poc_phone_no' => 'required',
                   
                ],
                [
                    'name.required' => 'Client Name Required',
                    'poc_phone_no.required' => 'Client Phone Required',
                    
                ]
            );

            if ($validator->fails()) {
                return redirect('projects/clients')
                    ->withErrors($validator)
                    ->withInput();
            }


            $data = request()->except(['_token']);
           
            
            $check_client_name = Client::where('name', trim($request->name))->first();
            if (!empty($check_client_name)) {
                Session::flash('error', 'Client Alredy Exists.');
                return redirect('projects/clients');
            }

            $client = new Client();
            $client->create($data);

            Session::flash('message', 'Client Information Successfully saved.');
            return redirect('projects/clients');
        } else {
            return redirect('/');
        }
    }

    public function updateClient(Request $request)
    {
                

        if (!empty(Session::get('admin'))) {

            // $filename = '';

           

            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:100',
                    'poc_phone_no' => 'required',
                    'poc_email' => 'required',
                   
                ],
                [
                    'name.required' => 'Client Name Required',
                    'poc_phone_no.required' => 'Client Phone Required',
                    'poc_email.required' => 'Client Email Required',
                    
                ]
            );

            if ($validator->fails()) {
                return redirect('projects/clients')
                    ->withErrors($validator)
                    ->withInput();
            }

            //$companies=$request->all();

            // $data = request()->except(['_token', 'c_id']);

            $check_client_name = Client::where('poc_phone_no', trim($request->poc_phone_no))->where('id','!=',$request->id)->first();
            if (!empty($check_client_name)) {
                Session::flash('error', 'Client Alredy Exists.');
                return redirect('projects/clients');
            }

            $updatedata=[
                'name'=>$request->name,
                'poc_phone_no'=>$request->poc_phone_no,
                'poc_email'=>$request->poc_email,
                'type'=>$request->type,
                'status'=>$request->status,
                ];

            Client::where('id', $request->id)->update($updatedata);
            Session::flash('message', 'Client Information Successfully updated.');
            return redirect('projects/clients');
        } else {
            return redirect('/');
        }
    }
}