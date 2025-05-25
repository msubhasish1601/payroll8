<?php

namespace App;

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Models\Project\Client;
use App\Models\Project\Employee;
use App\Models\Project\Project;
use App\Models\Project\Project_task;
use App\Models\Project\Role_authorization;
use Illuminate\Http\Request;
use Session;
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
                ->where('projects.id', $id)
                ->first();

            $data['project_id'] = $id;

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

            if ($id != '') {
                $data['TaskData'] = Project_task::where('id', '=', $id)->first();
                $data['project_id'] = $data['TaskData']->project_id;
                $data['project'] = Project::find($data['project_id']);
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
        // dd($request->all());
        if (!empty(Session::get('admin'))) {
            $data = $request->all();
            if (!empty($data['task_description'])) {
                foreach ($data['task_description'] as $key => $value) {
                    $task = new Project_task;
                    $task->project_id = $data['project_id'];
                    $task->employee_id = $data['employee_id'][$key];
                    $task->assigned_by = $data['assigned_by'][$key];
                    $task->task_description = $data['task_description'][$key];
                    $task->save();
                }
                Session::flash('message', 'Task Information Successfully save.');
                return redirect('projects/edit-project/' . $data['project_id']);
            } else {
                Session::flash('error', 'No task list provided.');
                // return redirect('projects/vw-project');
                return redirect('projects/edit-project/' . $data['project_id']);
            }

        } else {
            return redirect('/');
        }
    }

    public function updateTask(Request $request)
    {
        // dd($request->all());

        if (!empty(Session::get('admin'))) {

            $data = $request->all();
            $task = Project_task::find($data['task_id']);
            if (empty($task)) {
                Session::flash('error', 'No task list provided.');
                return redirect('projects/edit-project/' . $data['project_id']);
            }
            $task->project_id = $data['project_id'];
            $task->employee_id = $data['employee_id'];
            $task->assigned_by = $data['assigned_by'];
            $task->task_description = $data['task_description'];
            $task->save();

            Session::flash('message', 'Task Information Successfully updated.');
            return redirect('projects/edit-project/' . $data['project_id']);
        } else {
            return redirect('/');
        }
    }
}
