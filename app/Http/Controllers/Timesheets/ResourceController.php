<?php

namespace App;

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Models\Project\Client;
use App\Models\Project\Employee;
use App\Models\Project\Project;
use App\Models\Project\Project_document;
use App\Models\Project\Project_resource;
use App\Models\Project\Role_authorization;
use Illuminate\Http\Request;
use Session;
use View;

class ResourceController extends Controller
{

    public function getResource()
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $data['emplist'] = $emplist = Employee::where('status', '=', 'active')
            // ->where('emp_status', '!=', 'TEMPORARY')
                ->where('employees.emp_status', '!=', 'EX-EMPLOYEE')
                ->where('employees.emp_status', '!=', 'EX- EMPLOYEE')
            // ->where('employees.emp_code', '=', '1831')
                ->orderBy('emp_fname', 'asc')
                ->get();

            $data['clientlist'] = $clientlist = Client::where('type', '=', 'Public')
                ->orWhere('type', '=', 'Private')
                ->orderBy('name', 'asc')
                ->get();

            $projects_rs = Project::select('projects.*', 'employees.emp_fname', 'employees.emp_lname', 'clients.name as client_name')
                ->leftJoin('employees', 'employees.emp_code', '=', 'projects.owner_id')
                ->leftJoin('clients', 'clients.id', '=', 'projects.client_id')
                ->get();

            $resource = Project_resource::select('project_resources.*', 'employees.emp_fname', 'employees.emp_lname', 'project.name as project_name')
                ->leftJoin('employees', 'employees.emp_code', '=', 'project_resources.employee_id')
                ->leftJoin('projects', 'projects.id', '=', 'project_resources.project_id')
                ->get();

            //    print_r($resource );
            //    die();
            // $projects_document = Project_document::all();

            // $data['projects_document'] = $projects_document;

            // $data['projects_rs'] = $projects_rs;
            $data['resource'] = $resource;
            return view('projects/edit-project', $data);
        } else {
            return redirect('/');
        }
    }

    public function addResource($id)
    {
        // print_r($id);
        // die();
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $data['emplist'] = $emplist = Employee::where('status', '=', 'active')
            // ->where('emp_status', '!=', 'TEMPORARY')
                ->where('employees.emp_status', '!=', 'EX-EMPLOYEE')
                ->where('employees.emp_status', '!=', 'EX- EMPLOYEE')
            // ->where('employees.emp_code', '=', '1831')
                ->orderBy('emp_fname', 'asc')
                ->get();

            $data['clientlist'] = $clientlist = Client::where('type', '=', 'Public')
                ->orWhere('type', '=', 'Private')
                ->orderBy('name', 'asc')
                ->get();

            $data['resource'] = Project::select('projects.*', 'employees.emp_fname', 'employees.emp_lname', 'clients.name as client_name')
                ->leftJoin('employees', 'employees.emp_code', '=', 'projects.owner_id')
                ->leftJoin('clients', 'clients.id', '=', 'projects.client_id')
                ->where('projects.id',$id)
                ->first(); 

            $data['project_id'] = $id;
            // print_r($data['resource']->id);
            //  print_r($data['resource']);
            // die();

            return view('projects/add-resource', $data);
        } else {
            return redirect('/');
        }
    }

    public function editResource($id)
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

                $data['emplist'] = $emplist = Employee::where('status', '=', 'active')
                // ->where('emp_status', '!=', 'TEMPORARY')
                    ->where('employees.emp_status', '!=', 'EX-EMPLOYEE')
                    ->where('employees.emp_status', '!=', 'EX- EMPLOYEE')
                // ->where('employees.emp_code', '=', '1831')
                    ->orderBy('emp_fname', 'asc')
                    ->get();
    
                $data['clientlist'] = $clientlist = Client::where('type', '=', 'Public')
                    ->orWhere('type', '=', 'Private')
                    ->orderBy('name', 'asc')
                    ->get();
    
                $data['resource'] = Project::select('projects.*', 'employees.emp_fname', 'employees.emp_lname', 'clients.name as client_name')
                    ->leftJoin('employees', 'employees.emp_code', '=', 'projects.owner_id')
                    ->leftJoin('clients', 'clients.id', '=', 'projects.client_id')
                    ->where('projects.id',$id)
                    ->first(); 
                
            $resource = Project_resource::select('project_resources.*', 'employees.emp_fname', 'employees.emp_lname', 'projects.name as project_name')
            ->leftJoin('employees', 'employees.emp_code', '=', 'project_resources.employee_id')
            ->leftJoin('projects', 'projects.id', '=', 'project_resources.project_id')
            ->where('project_resources.project_id', $id)
            ->get();

            $data['project_id'] = $id;
            $data['resource'] = $resource;

            if ($id != '') {

                $data['ProjectData'] = Project_resource::where('id', '=', $id)->get();
                
                return view('projects/edit-resource', $data);
            } else {
                return view('projects/edit-resource', $data);
            }
        } else {
            return redirect('/');
        }
    }

    public function deleteResource($id)
    {
        
        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $result = Project_resource::where('id', $id)->delete();
            Session::flash('message', 'Resource Deleted Successfully.');
            return redirect('projects/vw-project');
        } else {
            return redirect('/');
        }
    }

    public function saveResource(Request $request)
    {
        // print_r($request->all());
        // die();
        if (!empty(Session::get('admin'))) {

            $filename = '';

            $data = request()->except(['_token']);

            $check_project_id = Project::select('id')->orderBy('id', 'desc')->first();

            if (!empty($data['employee_id'])) {
                foreach ($data['employee_id'] as $key => $emp_name) {
                    $insertData = [
                        'project_id' => $data['project_id'],
                        'employee_id' => $emp_name,
                        'is_billable' => $data['is_billable'][$key],
                        'billable_percent' => $data['billable_percent'][$key],
                    ];
                    $resource = new Project_resource();
                    $resource->create($insertData);
                }
                Session::flash('message', 'Resource  Information Successfully save.');
                // return redirect('projects/edit-project/' . $data['project_id']);
                return redirect('projects/vw-project');
            }

            Session::flash('message', 'Resource Information Successfully saved.');
            // return redirect('projects/edit-project/' . $data['project_id']);
            return redirect('projects/vw-project');
        } else {
            return redirect('/');
        }
    }

    public function updateResource(Request $request)
    {

        if (!empty(Session::get('admin'))) {

            $filename = '';

            $data = request()->except(['_token']);

            Session::flash('message', 'Resource Information Successfully updated.');
            return redirect('projects/vw-resource');
        } else {
            return redirect('/');
        }
    }
}