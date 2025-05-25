<?php

namespace App;

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Models\Project\Client;
use App\Models\Project\Employee;
use App\Models\Project\Project;
use App\Models\Project\Project_document;
use App\Models\Project\Project_resource;
use App\Models\Project\Project_task;
use App\Models\Project\Role_authorization;
use App\Models\Timesheet\Timesheet;
use Illuminate\Http\Request;
use Session;
use Validator;
use View;

class ProjectController extends Controller
{

    public function getProjects()
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

            $data['projects_rs'] = $projects_rs;
            return view('projects/view-project', $data);
        } else {
            return redirect('/');
        }
    }

    public function addProjects()
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

            // print_r($data['clientlist']);
            // die();

            return view('projects/add-projects', $data);
        } else {
            return redirect('/');
        }
    }

    public function editProjects($id)
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

            $resource = Project_resource::select('project_resources.*', 'employees.emp_fname', 'employees.emp_lname', 'projects.name as project_name')
                ->leftJoin('employees', 'employees.emp_code', '=', 'project_resources.employee_id')
                ->leftJoin('projects', 'projects.id', '=', 'project_resources.project_id')
                ->where('project_resources.project_id', $id)
                ->get();
            // dd($resource);
            $task = Project_task::select('project_tasks.*', 'emp1.emp_fname', 'emp1.emp_lname', 'emp2.emp_fname as fname', 'emp2.emp_lname as lname', 'projects.name as project_name')
                ->leftJoin('employees as emp1', 'emp1.emp_code', '=', 'project_tasks.employee_id')
                ->leftJoin('employees as emp2', 'emp2.emp_code', '=', 'project_tasks.assigned_by')
                ->leftJoin('projects', 'projects.id', '=', 'project_tasks.project_id')
                ->where('project_tasks.project_id', $id)
                ->get();

            // print_r($task);
            // die();

            $data['resource'] = $resource;
            $data['task'] = $task;
            $data['project_id'] = $id;

            if ($id != '') {

                $data['ProjectData'] = Project::where('id', '=', $id)->first();
                $data['ProjectDocument'] = Project_document::where('project_id', '=', $id)->get();
                //dd($data['ProjectDocument']);

                return view('projects/edit-project', $data);
            } else {
                return redirect('/projects');
            }
        } else {
            return redirect('/');
        }
    }

    public function saveProjects(Request $request)
    {

        if (!empty(Session::get('admin'))) {

            $filename = '';

            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:100',
                    // 'poc_phone_no' => 'required',

                ],
                [
                    'name.required' => 'Project Name Required',
                    // 'poc_phone_no.required' => 'Client Phone Required',

                ]
            );

            if ($validator->fails()) {
                return redirect('projects/vw-project')
                    ->withErrors($validator)
                    ->withInput();
            }

            $data = request()->except(['_token', 'closure_certificate']);
            //exlode client id
            if (!empty($data['client_id'])) {
                $explodeClient = explode('~', $data['client_id']);
                $data['client_id'] = $explodeClient[1];
            }

            $check_project_name = Project::where('name', trim($request->name))->first();
            if (!empty($check_project_name)) {
                Session::flash('error', 'Project Alredy Exists.');
                return redirect('projects/vw-project');
            }

            if (!empty($request->hasFile('closure_certificate'))) {
                $files = $request->file('closure_certificate');
                $extension = $request->closure_certificate->extension();
                $filename = $request->closure_certificate->store('certificate', 'public');
                $data['closure_certificate'] = $filename;
            } else {

                $filename = "";
            }

            $project = new Project();
            $project->create($data);

            $check_project_id = Project::select('id')->orderBy('id', 'desc')->first();

            // print_r($check_project_id->id);
            // die();

            if (!empty($data['document_name'])) {
                foreach ($data['document_name'] as $key => $doc_name) {
                    $insertData = [
                        'project_id' => $check_project_id->id,
                        'document_name' => $doc_name,
                        'document_file' => $data['document_file'][$key],
                    ];
                    $project_document = new Project_document();
                    $project_document->create($insertData);
                }
            }

            Session::flash('message', 'Project Information Successfully saved.');
            return redirect('projects/vw-project');
        } else {
            return redirect('/');
        }
    }

    public function updateProjects(Request $request)
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
            'allotted_hours' => $request->allotted_hours,
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

            $data = request()->except(['_token', 'closure_certificate']);

            $check_project_id = Project::select('id')->orderBy('id', 'desc')->first();

            // print_r($check_project_id->id);
            // die();

            // dd($request->all());

            if (!empty($data['document_name'])) {
                foreach ($data['document_name'] as $key => $doc_name) {
                    // dd($request->document_file[$key]);
                    if (isset($request->document_file[$key])) {
                        if (isset($request->document_id[$key])) {
                            //existing
                            if (!empty($request->document_file[$key])) {
                                $files = $request->document_file[$key];
                                $extension = $request->document_file[$key]->extension();
                                $filename = $request->document_file[$key]->store('document', 'public');
                                $document_file = $filename;

                                $insertData = [
                                    // 'project_id' => $check_project_id->id,
                                    'project_id' => $data['project_id'],
                                    'document_name' => $doc_name,
                                    'document_file' => $document_file,
                                ];
                                $project_document = Project_document::find($request->document_id[$key]);
                                $project_document->update($insertData);
                            } else {
                                //only document name update
                                $insertData = [
                                    'document_name' => $doc_name,
                                ];
                                $project_document = Project_document::find($request->document_id[$key]);
                                $project_document->update($insertData);
                            }
                        } else {
                            //new
                            if (!empty($request->document_file[$key])) {
                                $files = $request->document_file[$key];
                                $extension = $request->document_file[$key]->extension();
                                $filename = $request->document_file[$key]->store('document', 'public');
                                $document_file = $filename;

                                $insertData = [
                                    // 'project_id' => $check_project_id->id,
                                    'project_id' => $data['project_id'],
                                    'document_name' => $doc_name,
                                    'document_file' => $document_file,
                                ];
                                $project_document = new Project_document();
                                $project_document->create($insertData);
                            }
                        }

                    } else {
                        if (isset($request->document_id[$key])) {
                            //existing

                            //only document name update
                            $insertData = [
                                'document_name' => $doc_name,
                            ];
                            $project_document = Project_document::find($request->document_id[$key]);
                            $project_document->update($insertData);

                        }
                    }

                }
                Session::flash('message', 'Project Documents Information Successfully save.');
                return redirect('projects/vw-project');
            }

            Session::flash('message', 'Project Information Successfully updated.');
            return redirect('projects/vw-project');
        } else {
            return redirect('/');
        }
    }

    public function getProjectTasks($employee_id, $project_id)
    {
        $completedTaskIds = Timesheet::join('timesheet_details', 'timesheets.id', '=', 'timesheet_details.timesheet_id')->whereNotNull('timesheet_details.task_id')->where('timesheet_details.task_status', '=', 'Complete')->pluck('timesheet_details.task_id')->toArray();

        // dd($completedTaskIds);

        $task = Project_task::select('project_tasks.*')
            ->where('project_tasks.employee_id', $employee_id)
            ->where('project_tasks.project_id', $project_id)
            ->whereNotIn('project_tasks.id', $completedTaskIds)
            ->get();

        // dd($task);

        return response()->json(json_encode($task));
    }
}
