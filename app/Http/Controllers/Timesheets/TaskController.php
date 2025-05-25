<?php

namespace App;

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Models\Project\Client;
use App\Models\Project\Employee;
use App\Models\Project\Project_task;
use App\Models\Project\Project;
use App\Models\Project\Project_document;
use App\Models\Project\Project_resource;
use App\Models\Project\Role_authorization;
use Illuminate\Http\Request;
use Session;
use Validator;
use View;

class TaskController extends Controller
{

    public function getTask()
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

            // $projects_document = Project_document::all();

            // $data['projects_document'] = $projects_document;

            $data['projects_rs'] = $projects_rs;
            return view('projects/edit-task', $data);
        } else {
            return redirect('/');
        }
    }

    public function addTask($id)
    {
        //  print_r($id);
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

                $data['task'] = Project::select('projects.*', 'employees.emp_fname', 'employees.emp_lname', 'clients.name as client_name')
                ->leftJoin('employees', 'employees.emp_code', '=', 'projects.owner_id')
                ->leftJoin('clients', 'clients.id', '=', 'projects.client_id')
                ->where('projects.id',$id)
                ->first(); 
                

            $data['project_id'] = $id;
            // print_r($data['project_id']);
            // die();

            
            return view('projects/add-task', $data);
        } else {
            return redirect('/');
        }
    }

    public function editTask($id)
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

            if ($id != '') {

                $data['ProjectData'] = Project::where('id', '=', $id)->first();
                $data['ProjectDocument'] = Project_document::where('project_id', '=', $id)->get();
                // print_r($data['ProjectDocument']);
                // die();

                return view('projects/edit-task', $data);
            } else {
                return view('projects/edit-task', $data);
            }
        } else {
            return redirect('/');
        }
    }

    public function saveTask(Request $request)
    {
        // print_r($request->all());
        // die();
        if (!empty(Session::get('admin'))) {

            $filename = '';

            $data = request()->except(['_token']);


            $task = Project::select('id')->orderBy('id', 'desc')->first();

        //  print_r($task);
        //  die();

            if (!empty($data['employee_id'])) {
                foreach ($data['employee_id'] as $key => $emp_name) {
                    $insertData = [
                        'project_id' => $data['project_id'],
                        'employee_id' => $emp_name,
                        'assigned_by' => $data['assigned_by'][$key]?? '0',
                        'task_json' =>json_encode($data['task_json'][$key]) ?? '0'
                    ];
                    $task = new Project_task();
                    $task->create($insertData);
                }
                Session::flash('message', 'Task  Information Successfully save.');
                // return redirect('projects/edit-project/'.$data['project_id']);
                return redirect('projects/vw-project');
            }

            Session::flash('message', 'Task Information Successfully saved.');
            // return redirect('projects/edit-project/'.$data['project_id']);
            return redirect('projects/vw-project');
        } else {
            return redirect('/');
        }
    }


    public function updateTask(Request $request)
    {
        if (!empty($request->client_id)) {
            $explodeClient = explode('~', $request->client_id);
            $request->client_id = $explodeClient[1];
        }
        $updatedata = [
            'name' => $request->name,
            'client_id' => $request->client_id,
            'owner_id' => $request->owner_id,
            'project_code' => $request->project_code,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'actual_start_date' => $request->actual_start_date,
            'actual_end_date' => $request->actual_end_date,
            'contract_cost' => $request->contract_cost,
            // 'closure_certificate'=>$request->closure_certificate,
            'closure_date' => $request->closure_date,
            'status' => $request->status,
            'description' => $request->description,
        ];

        if (!empty(Session::get('admin'))) {

            $filename = '';

            if (!empty($request->hasFile('closure_certificate'))) {
                $files = $request->file('closure_certificate');
                $extension = $request->closure_certificate->extension();
                $filename = $request->closure_certificate->store('certificate', 'public');
                $updatedata['closure_certificate'] = $filename;
            } else {

                $filename = "";
            }

            Project::where('id', $request->id)->update($updatedata);

            // if(!empty($request->document_name)){
            //     foreach($request->document_name as $key => $doc_name){
            //         if(!empty($request->document_file[$key])){
            //             $updateDocData = [
            //                 'document_name' => $doc_name,
            //                 'document_file' => $request->document_file[$key]
            //             ];
            //         }else{
            //             $updateDocData = [
            //                 'document_name' => $doc_name
            //             ];
            //         }

            //         Project_document::where('id', $request->document_id[$key])->update($updateDocData);
            //     }
            // }
            $data = request()->except(['_token', 'closure_certificate']);

            $check_project_id = Project::select('id')->orderBy('id', 'desc')->first();

            // print_r($check_project_id->id);
            // die();

            if (!empty($data['document_name'])) {
                foreach ($data['document_name'] as $key => $doc_name) {
                    if (isset($request->document_file[$key])) {
                        if (!empty($request->hasFile('document_file'))) {
                            $files = $request->file('document_file');
                            $extension = $request->document_file[$key]->extension();
                            $filename = $request->document_file[$key]->store('document', 'public');
                            $document_file = $filename;
                        }
                    }
                    $insertData = [
                        'project_id' => $check_project_id->id,
                        'document_name' => $doc_name,
                        'document_file' => $document_file,
                    ];
                    $project_document = new Project_document();
                    $project_document->create($insertData);
                }
                Session::flash('message', 'Project Documents Information Successfully save.');
                return redirect('projects/vw-resource');
            }
            // else{
            //     if(!empty($request->document_file[$key])){
            //         $updateDocData = [
            //             'document_name' => $doc_name,
            //             'document_file' => $request->document_file[$key]
            //         ];
            //     }else{
            //         $updateDocData = [
            //             'document_name' => $doc_name
            //         ];
            //     }

            //     Project_document::where('id', $request->document_id[$key])->update($updateDocData);

            // }

            Session::flash('message', 'Resource Information Successfully updated.');
            return redirect('projects/vw-task');
        } else {
            return redirect('/');
        }
    }
}
