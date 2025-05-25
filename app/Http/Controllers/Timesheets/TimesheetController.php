<?php

namespace App;

namespace App\Http\Controllers\Timesheets;

use App\Http\Controllers\Controller;
use App\Models\Project\Project_resource;
use App\Models\Project\Role_authorization;
use App\Models\Timesheet\Project;
use App\Models\Timesheet\Project_task;
use App\Models\Timesheet\Timesheet;
use App\Models\Timesheet\Timesheet_detail;
use DB;
use Illuminate\Http\Request;
use Session;
use View;

class TimesheetController extends Controller
{
    //

    public function getTimesheets()
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            // print_r(Session::get('admin')['employee_id']);
            // die();

            $loggedInEmpCode = Session::get('admin')['employee_id'];

            $myAssignedProjects = Project_resource::where('employee_id', '=', $loggedInEmpCode)->pluck('project_id');

            $data['project_name'] = $project_name = Project::select('projects.*')
                ->whereIn('projects.id', $myAssignedProjects)
                ->where('projects.status', '=', 1)
                ->get();

            $data['project_task'] = $project_task = Project_task::select('project_tasks.*')
                ->where('project_tasks.employee_id', Session::get('admin')['employee_id'])
                ->get();

            $timesheet_detail = Timesheet::where('timesheets.employee_id', $loggedInEmpCode)->get();

            $data['timesheet_detail'] = $timesheet_detail;

            return view('timesheets/view-time', $data);
        } else {
            return redirect('/');
        }
    }

    public function addTimesheet()
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $loggedInEmpCode = Session::get('admin')['employee_id'];
            $data['employee_id'] = $loggedInEmpCode;
            $myAssignedProjects = Project_resource::where('employee_id', '=', $loggedInEmpCode)->pluck('project_id');

            $data['projects'] = $project_name = Project::select('projects.*')
                ->whereIn('projects.id', $myAssignedProjects)
                ->where('projects.status', '=', 1)
                ->get();

            return view('timesheets/add-timesheet', $data);
        } else {
            return redirect('/');
        }
    }
    public function addToList(Request $request)
    {
        // dd($request->all());
        try {
            if (!empty(Session::get('admin'))) {

                $time_id = $request->time_id;
                $timesheet_date = $request->timesheet_date;
                $employee_id = $request->employee_id;
                $project_id = $request->atl_project_id;
                $task_type = $request->atl_task_type;
                $task_id = $request->atl_task;
                $description = $request->atl_jobdesc;
                $hours = $request->hour;
                $minutes = $request->minute;
                $task_time = $request->task_time;
                $task_status = $request->atl_task_status;

                $timesheet_check = Timesheet::where('timesheets.employee_id', $employee_id)->where('sheet_date', trim($request->timesheet_date))->first();

                // dd($timesheet_check);
                if (!empty($timesheet_check) && $time_id == '') {
                    $reponse = ['status' => 'false', 'statuscode' => '400', 'data' => '', 'error' => 'Timesheet already submitted for the date. If you have not done the final submission of the said date timesheet, please do edit from list.'];
                    $reponse = json_encode($reponse);
                    return response()->json($reponse, 400);
                } elseif (!empty($timesheet_check) && $timesheet_check->status != 'P' && $time_id != '') {
                    $reponse = ['status' => 'false', 'statuscode' => '400', 'data' => '', 'error' => 'Timesheet already submitted for the date.'];
                    $reponse = json_encode($reponse);
                    return response()->json($reponse, 400);
                } else {

                    //check task id already marked completed on other sheet date
                    $check_task = Timesheet::join('timesheet_details', 'timesheets.id', '=', 'timesheet_details.timesheet_id')->where('timesheet_details.task_id', '=', $task_id)->where('timesheets.sheet_date', '!=', trim($request->timesheet_date))->where('timesheet_details.task_status', '=', 'Complete')->first();

                    //check task id getting added multiple times
                    $check_task_dup = Timesheet::join('timesheet_details', 'timesheets.id', '=', 'timesheet_details.timesheet_id')->where('timesheet_details.task_id', '=', $task_id)->where('timesheets.sheet_date', '=', trim($request->timesheet_date))->first();

                    // dd($check_task_dup);

                    if (!empty($check_task) && $task_id != '') {
                        $reponse = ['status' => 'false', 'statuscode' => '400', 'data' => '', 'error' => 'You have already completed the task other day.'];
                        $reponse = json_encode($reponse);
                        return response()->json($reponse, 400);
                    } else if (!empty($check_task_dup) && $task_id != '') {
                        $reponse = ['status' => 'false', 'statuscode' => '400', 'data' => '', 'error' => 'You cannot add same planned task multiple times for same date.'];
                        $reponse = json_encode($reponse);
                        return response()->json($reponse, 400);
                    } else {
                        if (!empty($timesheet_check) && $timesheet_check->status == 'P') {
                            //Edit timesheet
                            $timesheet_id = $timesheet_check->id;
                            $insertData = [
                                'timesheet_id' => $timesheet_id,
                                'project_id' => $project_id,
                                'task_type' => $task_type,
                                'task_id' => $task_id,
                                'task_status' => $task_status,
                                'hours' => $hours,
                                'minutes' => $minutes,
                                'task_time' => $task_time,
                                'description' => $description,
                            ];
                            // dd($insertData);
                            $timesheet_detail = new Timesheet_detail();
                            $timesheet_detail->create($insertData);
                        } else {
                            //Add timesheet

                            $model = new Timesheet;
                            $model->employee_id = $employee_id;
                            $model->sheet_date = $timesheet_date;

                            $model->status = 'P';
                            $model->save();

                            $timesheet_id = $model->id;
                            $insertData = [
                                'timesheet_id' => $timesheet_id,
                                'project_id' => $project_id,
                                'task_type' => $task_type,
                                'task_id' => $task_id,
                                'task_status' => $task_status,
                                'hours' => $hours,
                                'minutes' => $minutes,
                                'task_time' => $task_time,
                                'description' => $description,
                            ];
                            // dd($insertData);
                            $timesheet_detail = new Timesheet_detail();
                            $timesheet_detail->create($insertData);

                        }
                    }

                    $allTimeSheetDetails = Timesheet_detail::join('projects', 'projects.id', '=', 'timesheet_details.project_id')->leftjoin('project_tasks', 'project_tasks.id', '=', 'timesheet_details.task_id')->select('timesheet_details.*', 'projects.name as project_name', 'project_tasks.task_description as task_name')->where('timesheet_id', '=', $timesheet_id)->get();

                    //calculate & update total hours in timesheet
                    $tsdHr = 0;
                    $tsdMin = 0;
                    foreach ($allTimeSheetDetails as $tsd) {
                        $tsdHr = $tsdHr + $tsd->hours;
                        $tsdMin = $tsdMin + $tsd->minutes;
                    }
                    $hrInMins = floor($tsdMin / 60);
                    $minInMins = $tsdMin % 60;
                    $tsdHr = $tsdHr + $hrInMins;
                    $total_hours = $tsdHr . '.' . $minInMins;
                    // dd($tsdHr . '----' . $tsdMin . '*****' . $hrInMins . '===' . $minInMins);

                    $total_hours_locked = $total_hours;
                    $model = Timesheet::find($timesheet_id);
                    $model->total_hours_locked = $total_hours_locked;
                    $model->save();

                    $reponse = ['status' => 'true', 'statuscode' => '200', 'data' => array('message' => 'Timesheet information successfully added.', 'timesheet_details' => $allTimeSheetDetails, 'timesheet' => $model), 'error' => ''];

                }
                $reponse = json_encode($reponse);
                return response()->json($reponse, 200);
            } else {
                $reponse = ['status' => 'false', 'statuscode' => '400', 'data' => '', 'error' => 'Your session has expired. Please login again.'];
                $reponse = json_encode($reponse);
                return response()->json($reponse, 400);
            }
        } catch (\Exception $e) {
            $reponse = ['status' => 'false', 'statuscode' => '500', 'data' => '', 'error' => $e->getMessage()];
            $reponse = json_encode($reponse);
            return response()->json($reponse, 500);
        }
    }

    public function removeFromList($tsd_id)
    {
        // dd($request->all());
        try {
            if (!empty(Session::get('admin'))) {

                $timesheet_details = Timesheet_detail::find($tsd_id);
                if (!empty($timesheet_details)) {
                    $timesheet_id = $timesheet_details->timesheet_id;
                    $timesheet_details->delete();
                }

                $allTimeSheetDetails = Timesheet_detail::join('projects', 'projects.id', '=', 'timesheet_details.project_id')->leftjoin('project_tasks', 'project_tasks.id', '=', 'timesheet_details.task_id')->select('timesheet_details.*', 'projects.name as project_name', 'project_tasks.task_description as task_name')->where('timesheet_id', '=', $timesheet_id)->get();

                //calculate & update total hours in timesheet
                $tsdHr = 0;
                $tsdMin = 0;
                foreach ($allTimeSheetDetails as $tsd) {
                    $tsdHr = $tsdHr + $tsd->hours;
                    $tsdMin = $tsdMin + $tsd->minutes;
                }
                $hrInMins = floor($tsdMin / 60);
                $minInMins = $tsdMin % 60;
                $tsdHr = $tsdHr + $hrInMins;
                $total_hours = $tsdHr . '.' . $minInMins;
                // dd($tsdHr . '----' . $tsdMin . '*****' . $hrInMins . '===' . $minInMins);

                $total_hours_locked = $total_hours;
                $model = Timesheet::find($timesheet_id);
                $model->total_hours_locked = $total_hours_locked;
                $model->save();

                $reponse = ['status' => 'true', 'statuscode' => '200', 'data' => array('message' => 'Timesheet information successfully added.', 'timesheet_details' => $allTimeSheetDetails, 'timesheet' => $model), 'error' => ''];

                $reponse = json_encode($reponse);
                return response()->json($reponse, 200);
            } else {
                $reponse = ['status' => 'false', 'statuscode' => '400', 'data' => '', 'error' => 'Your session has expired. Please login again.'];
                $reponse = json_encode($reponse);
                return response()->json($reponse, 400);
            }
        } catch (\Exception $e) {
            $reponse = ['status' => 'false', 'statuscode' => '500', 'data' => '', 'error' => $e->getMessage()];
            $reponse = json_encode($reponse);
            return response()->json($reponse, 500);
        }
    }
    public function saveTimesheet(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            // dd($request->all());
            $timesheet_date = $request->timesheet_date;
            $employee_id = $request->employee_id;

            $loggedInEmpCode = Session::get('admin')['employee_id'];

            if ($loggedInEmpCode == $employee_id) {
                $timesheet_check = Timesheet::where('timesheets.employee_id', $employee_id)->where('sheet_date', trim($timesheet_date))->first();
                if (!empty($timesheet_check)) {
                    $timesheet_id = $timesheet_check->id;
                    $allTimeSheetDetails = Timesheet_detail::where('timesheet_id', '=', $timesheet_id)->get();

                    //calculate & update total hours in timesheet
                    $tsdHr = 0;
                    $tsdMin = 0;
                    foreach ($allTimeSheetDetails as $tsd) {
                        $tsdHr = $tsdHr + $tsd->hours;
                        $tsdMin = $tsdMin + $tsd->minutes;
                    }
                    $hrInMins = floor($tsdMin / 60);
                    $minInMins = $tsdMin % 60;
                    $tsdHr = $tsdHr + $hrInMins;
                    $total_hours = $tsdHr . '.' . $minInMins;
                    // dd($tsdHr . '----' . $tsdMin . '*****' . $hrInMins . '===' . $minInMins);

                    $total_hours_locked = $total_hours;
                    $model = Timesheet::find($timesheet_id);
                    $model->total_hours_locked = $total_hours_locked;
                    $model->status = 'S';
                    $model->save();
                    Session::flash('message', 'Timesheet Information Successfully Submitted.');
                } else {
                    Session::flash('error', 'No timesheet found for submission.');
                }

            } else {
                Session::flash('error', 'You can\'t submit other users timesheet.');
            }

            return redirect('timesheets/view-sheets');

        } else {
            return redirect('/');
        }
    }

    public function addTimesheets()
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $loggedInEmpCode = Session::get('admin')['employee_id'];
            $myAssignedProjects = Project_resource::where('employee_id', '=', $loggedInEmpCode)->pluck('project_id');

            $data['project_name'] = $project_name = Project::select('projects.*')
                ->whereIn('projects.id', $myAssignedProjects)
                ->where('projects.status', '=', 1)
                ->get();

            $data['project_task'] = $project_task = Project_task::select('project_tasks.*')
                ->where('project_tasks.employee_id', Session::get('admin')['employee_id'])
                ->get();

            return view('timesheets/add-time', $data);
        } else {
            return redirect('/');
        }
    }

    public function editTimesheets($id)
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $loggedInEmpCode = Session::get('admin')['employee_id'];
            $data['employee_id'] = $loggedInEmpCode;
            $myAssignedProjects = Project_resource::where('employee_id', '=', $loggedInEmpCode)->pluck('project_id');

            $data['projects'] = $project_name = Project::select('projects.*')
                ->whereIn('projects.id', $myAssignedProjects)
                ->where('projects.status', '=', 1)
                ->get();

            $data['project_task'] = $project_task = Project_task::select('project_tasks.*')
                ->where('project_tasks.employee_id', Session::get('admin')['employee_id'])
                ->get();

            if ($id != '') {
                $data['Timesheet'] = Timesheet::where('id', '=', $id)->first();
                if (!$data['Timesheet']) {
                    Session::flash('error', 'No Record is selected');
                    return redirect('timesheets/view-sheets');
                }
                if ($data['Timesheet']->status != 'P') {
                    Session::flash('error', 'Invalid request');
                    return redirect('timesheets/view-sheets');
                }

                $data['timesheetDatails'] = Timesheet_detail::join('projects', 'projects.id', '=', 'timesheet_details.project_id')->leftjoin('project_tasks', 'project_tasks.id', '=', 'timesheet_details.task_id')->select('timesheet_details.*', 'projects.name as project_name', 'project_tasks.task_description as task_name')->where('timesheet_id', '=', $id)->get();

                return view('timesheets/edit-timesheet', $data);
            } else {
                Session::flash('error', 'No Record is selected');
                return redirect('timesheets/projects');
            }
        } else {
            return redirect('/');
        }
    }
    public function saveTimesheets(Request $request)
    {
        // dd(isset($_POST['draft']));
        if (!empty(Session::get('admin'))) {

            $loggedInEmpCode = Session::get('admin')['employee_id'];
            $timesheet_check = Timesheet::where('timesheets.employee_id', $loggedInEmpCode)->where('sheet_date', trim($request->sheet_date))->where('is_draft', '=', 0)->where('is_submit', '=', 1)->first();

            if (!empty($timesheet_check)) {
                Session::flash('error', 'Timesheet already submitted for the date.');
                return redirect('timesheets/view-sheets');
            } else {
                $totalhours = 0;
                $totalminutes = 0;
                if (!empty($request->hours)) {
                    foreach ($request->hours as $key => $hrs) {
                        $totalhours = $totalhours + $hrs;
                        $totalminutes = $totalminutes + $request->minutes[$key];
                    }
                }

                if ($totalminutes >= 1) {
                    $getminutes = $totalminutes / 60;
                } else {
                    $getminutes = 0;
                }

                $alltotalhours = $totalhours + $getminutes;
                // dd($alltotalhours);
                if (isset($request->timesheet_id) && $request->timesheet_id != '') {
                    //Edit timesheet
                    $model = Timesheet::find($request->timesheet_id);

                    if (!$model) {
                        throw new Exception("No result was found for id: $request->timesheet_id");
                    }
                    $model->employee_id = $loggedInEmpCode;
                    $model->sheet_date = $request->sheet_date;
                    $model->is_draft = (isset($_POST['draft']) ? '1' : '0');
                    $model->is_submit = (isset($_POST['submit']) ? '1' : '0');
                    $model->total_hours_locked = $alltotalhours;

                    // dd($model);
                    $model->save();

                    $timesheet_id = $request->timesheet_id;

                    if (!empty($request->project_id)) {
                        $oldTD = DB::table('timesheet_details')->where('timesheet_id', '=', $timesheet_id)->delete();

                        foreach ($request->project_id as $key => $project) {
                            $insertData = [
                                'timesheet_id' => $timesheet_id,
                                'project_id' => $project,
                                'task_status' => $request->task_status[$key],
                                'hours' => $request->hours[$key] ?? '0',
                                'minutes' => $request->minutes[$key] ?? '0',
                                'description' => $request->description[$key] ?? '0',
                            ];
                            $timesheet_detail = new Timesheet_detail();
                            $timesheet_detail->create($insertData);
                        }
                        Session::flash('message', 'Timesheet Information Successfully Updated.');

                    }
                } else {
                    //Add timesheet

                    $model = new Timesheet;
                    $model->employee_id = $loggedInEmpCode;
                    $model->sheet_date = $request->sheet_date;
                    $model->is_draft = (isset($_POST['draft']) ? '1' : '0');
                    $model->is_submit = (isset($_POST['submit']) ? '1' : '0');
                    $model->total_hours_locked = $alltotalhours;
                    $model->save();

                    $timesheet_id = $model->id;

                    if (!empty($request->project_id)) {
                        foreach ($request->project_id as $key => $project) {
                            $insertData = [
                                'timesheet_id' => $timesheet_id,
                                'project_id' => $project,
                                'task_status' => $request->task_status[$key],
                                'hours' => $request->hours[$key] ?? '0',
                                'minutes' => $request->minutes[$key] ?? '0',
                                'description' => $request->description[$key] ?? '0',
                            ];
                            $timesheet_detail = new Timesheet_detail();
                            $timesheet_detail->create($insertData);
                        }
                        Session::flash('message', 'Timesheet Information Successfully Saved.');

                    }
                }

            }

            return redirect('timesheets/view-sheets');
        } else {
            return redirect('/');
        }
    }

    public function viewTimesheets($id)
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            if ($id != '') {
                $data['TimesheetData'] = Timesheet_detail::join('projects', 'projects.id', '=', 'timesheet_details.project_id')
                    ->leftjoin('project_tasks', 'project_tasks.id', '=', 'timesheet_details.task_id')
                    ->select('timesheet_details.*', 'projects.name as project_name', 'project_tasks.task_description as task_name')
                    ->where('timesheet_id', '=', $id)
                    ->get();

                // dd($data['TimesheetData']);
                $data['Timesheet'] = Timesheet::where('id', '=', $id)->first();

                $data['employeename'] = Timesheet::select('timesheets.*', 'employees.emp_fname', 'employees.emp_lname')
                    ->leftJoin('employees', 'employees.emp_code', '=', 'timesheets.employee_id')
                    ->where('timesheets.employee_id', Session::get('admin')['employee_id'])
                    ->first();

                return view('timesheets/view-timesheet', $data);
            } else {
                return view('timesheets/view-timesheet', $data);
            }
        } else {
            return redirect('/');
        }
    }

    public function updateTimesheets(Request $request)
    {
        //  print_r($request->all());
        //  die();

        if (!empty(Session::get('admin'))) {

            // $filename = '';

            //$companies=$request->all();

            // $data = request()->except(['_token', 'c_id']);

            // $check_project_name = Timesheet::where('sheet_date', trim($request->sheet_date))->first();
            // if (!empty($check_project_name)) {
            //     Session::flash('error', 'Date Alredy Exists.');
            //     return redirect('timesheets/projects');
            // }

            $data = request()->except(['_token']);

            $totalhours = 0;
            $totalminutes = 0;

            $totalhours_2 = 0;
            $totalminutes_2 = 0;

            if (!empty($data['hours'])) {
                foreach ($data['hours'] as $key => $hrs) {
                    $totalhours = $totalhours + $hrs;
                    $totalminutes = $totalminutes + $data['minutes'][$key];
                }
            }

            if (isset($data['hours_update']) && !empty($data['hours_update'])) {
                foreach ($data['hours_update'] as $key => $hrs) {
                    $totalhours_2 = $totalhours_2 + $hrs;
                    $totalminutes_2 = $totalminutes_2 + $data['minutes_update'][$key];
                }
            }

            if ($totalminutes >= 1) {
                $getminutes = $totalminutes / 60;
            } else {
                $getminutes = 0;
            }

            if ($totalminutes_2 >= 1) {
                $getminutes_2 = $totalminutes_2 / 60;
            } else {
                $getminutes_2 = 0;
            }

            $alltotalhours = $totalhours + $getminutes;
            $alltotalhours_2 = $totalhours_2 + $getminutes_2;
            if (isset($data['hours_update']) && !empty($data['hours_update'])) {
                $sub_total = $alltotalhours + $alltotalhours_2;
            } else {
                $sub_total = $alltotalhours;
            }

            $updatetimesheet = [
                'sheet_date' => $request->sheet_date,
                'is_draft' => '0',
                'is_submit' => '1',
                'total_hours_locked' => $sub_total,
            ];

            Timesheet::where('id', $request->timesheet_id)->update($updatetimesheet);

            if (isset($data['project_id_update']) && !empty($data['project_id_update'])) {
                foreach ($data['project_id_update'] as $key => $emp) {
                    $insertData = [
                        'timesheet_id' => $request->timesheet_id,
                        'project_id' => $emp,
                        // 'task' => $data['task'][$key]?? '0',
                        'task_status' => $data['task_status_update'][$key],
                        'hours' => $data['hours_update'][$key] ?? '0',
                        'minutes' => $data['minutes_update'][$key] ?? '0',
                        'description' => $data['description_update'][$key] ?? '0',
                    ];
                    $timesheet_detail = new Timesheet_detail();
                    $timesheet_detail->create($insertData);
                }
            }

            if (!empty($data['project_id'])) {
                foreach ($data['project_id'] as $key => $emp_name) {
                    $updateDocData = [
                        // 'timesheet_id' => $timesheet->id,
                        'project_id' => $emp_name,
                        'task' => $data['task'][$key] ?? '0',
                        'task_status' => $data['task_status'][$key],
                        'hours' => $data['hours'][$key] ?? '0',
                        'minutes' => $data['minutes'][$key] ?? '0',
                        'description' => $data['description'][$key] ?? '0',
                    ];
                    Timesheet_detail::where('id', $request->details_id[$key])->update($updateDocData);
                }
                Session::flash('message', 'Timesheet Information Successfully Submit.');
                // return redirect('projects/edit-project/'.$data['project_id']);
                return redirect('timesheets/projects');
            }

            Session::flash('message', 'TimeSheet Information Successfully Submit.');
            return redirect('timesheets/projects');
        } else {
            return redirect('/');
        }
    }

    public function updatedraftTimesheets(Request $request)
    {
        //  print_r($request->all());
        //  die();

        if (!empty(Session::get('admin'))) {

            // $filename = '';

            //$companies=$request->all();

            // $data = request()->except(['_token', 'c_id']);

            // $check_project_name = Timesheet::where('sheet_date', trim($request->sheet_date))->first();
            // if (!empty($check_project_name)) {
            //     Session::flash('error', 'Date Alredy Exists.');
            //     return redirect('timesheets/projects');
            // }

            $data = request()->except(['_token']);

            $totalhours = 0;
            $totalminutes = 0;

            $totalhours_2 = 0;
            $totalminutes_2 = 0;

            if (!empty($data['hours'])) {
                foreach ($data['hours'] as $key => $hrs) {
                    $totalhours = $totalhours + $hrs;
                    $totalminutes = $totalminutes + $data['minutes'][$key];
                }
            }

            if (isset($data['hours_update']) && !empty($data['hours_update'])) {
                foreach ($data['hours_update'] as $key => $hrs) {
                    $totalhours_2 = $totalhours_2 + $hrs;
                    $totalminutes_2 = $totalminutes_2 + $data['minutes_update'][$key];
                }
            }

            if ($totalminutes >= 1) {
                $getminutes = $totalminutes / 60;
            } else {
                $getminutes = 0;
            }

            if ($totalminutes_2 >= 1) {
                $getminutes_2 = $totalminutes_2 / 60;
            } else {
                $getminutes_2 = 0;
            }

            $alltotalhours = $totalhours + $getminutes;
            $alltotalhours_2 = $totalhours_2 + $getminutes_2;
            if (isset($data['hours_update']) && !empty($data['hours_update'])) {
                $sub_total = $alltotalhours + $alltotalhours_2;
            } else {
                $sub_total = $alltotalhours;
            }

            $updatetimesheet = [
                'sheet_date' => $request->sheet_date,
                'is_draft' => '1',
                'is_submit' => '0',
                'total_hours_locked' => $sub_total,
            ];

            Timesheet::where('id', $request->timesheet_id)->update($updatetimesheet);

            if (isset($data['project_id_update']) && !empty($data['project_id_update'])) {
                foreach ($data['project_id_update'] as $key => $emp) {
                    $insertData = [
                        'timesheet_id' => $request->timesheet_id,
                        'project_id' => $emp,
                        // 'task' => $data['task'][$key]?? '0',
                        'task_status' => $data['task_status_update'][$key],
                        'hours' => $data['hours_update'][$key] ?? '0',
                        'minutes' => $data['minutes_update'][$key] ?? '0',
                        'description' => $data['description_update'][$key] ?? '0',
                    ];
                    $timesheet_detail = new Timesheet_detail();
                    $timesheet_detail->create($insertData);
                }
            }

            if (!empty($data['project_id'])) {
                foreach ($data['project_id'] as $key => $emp_name) {
                    $updateDocData = [
                        // 'timesheet_id' => $timesheet->id,
                        'project_id' => $emp_name,
                        'task' => $data['task'][$key] ?? '0',
                        'task_status' => $data['task_status'][$key],
                        'hours' => $data['hours'][$key] ?? '0',
                        'minutes' => $data['minutes'][$key] ?? '0',
                        'description' => $data['description'][$key] ?? '0',
                    ];
                    Timesheet_detail::where('id', $request->details_id[$key])->update($updateDocData);
                }
                Session::flash('message', 'Timesheet Information Successfully Draft.');
                // return redirect('projects/edit-project/'.$data['project_id']);
                return redirect('timesheets/projects');
            }

            Session::flash('message', 'TimeSheet Information Successfully Draft.');
            return redirect('timesheets/projects');
        } else {
            return redirect('/');
        }
    }

    public function save_draft(Request $request)
    {

        dd($request->all());
        if (!empty(Session::get('admin'))) {
            $loggedInEmpCode = Session::get('admin')['employee_id'];
            $timesheet_check = Timesheet::where('timesheets.employee_id', $loggedInEmpCode)->where('sheet_date', trim($request->sheet_date))->first();

            if (!empty($timesheet_check)) {
                Session::flash('error', 'Timesheet already added for the date. If you have not submitted yet, please feel free to edit.');
                return redirect('timesheets/projects');
            }

            $totalhours = 0;
            $totalminutes = 0;
            if (!empty($data['hours'])) {
                foreach ($data['hours'] as $key => $hrs) {
                    $totalhours = $totalhours + $hrs;
                    $totalminutes = $totalminutes + $data['minutes'][$key];
                }
            }

            if ($totalminutes >= 1) {
                $getminutes = $totalminutes / 60;
            } else {
                $getminutes = 0;
            }

            $alltotalhours = $totalhours + $getminutes;

            $model = new Timesheet;
            $model->employee_id = Session::get('admin')['employee_id'];
            $model->sheet_date = $request->sheet_date;
            $model->is_draft = '1';
            $model->is_submit = '0';
            $model->total_hours_locked = $alltotalhours;
            $model->save();

            // print_r($check_project_id->id);
            // die();''project_id' => $check_project_id->id,
            $timesheet = Timesheet::select('id')->orderBy('id', 'desc')->first();

            if (!empty($data['project_id'])) {
                foreach ($data['project_id'] as $key => $emp_name) {
                    $insertData = [
                        'timesheet_id' => $timesheet->id,
                        'project_id' => $emp_name,
                        // 'task' => $data['task'][$key]?? '0',
                        'task_status' => $data['task_status'][$key],
                        'hours' => $data['hours'][$key] ?? '0',
                        'minutes' => $data['minutes'][$key] ?? '0',
                        'description' => $data['description'][$key] ?? '0',
                    ];
                    $timesheet_detail = new Timesheet_detail();
                    $timesheet_detail->create($insertData);
                }
                Session::flash('message', 'Darft Timesheet Information Successfully save.');
                // return redirect('projects/edit-project/'.$data['project_id']);
                return redirect('timesheets/projects');
            }

            Session::flash('message', 'Darft Timesheet Information Successfully saved.');
            // return redirect('projects/edit-project/'.$data['project_id']);
            return redirect('timesheets/projects');
        } else {
            return redirect('/');
        }
    }

    public function save_submit(Request $request)
    {

        // print_r($request->all());
        // die();
        if (!empty(Session::get('admin'))) {

            $filename = '';

            $data = request()->except(['_token']);

            // $check_project_name = Timesheet::where('sheet_date', trim($request->sheet_date))->first();
            // if (!empty($check_project_name)) {
            //     Session::flash('error', 'Date Alredy Exists.');
            //     return redirect('timesheets/projects');
            // }

            $totalhours = 0;
            $totalminutes = 0;
            if (!empty($data['hours'])) {
                foreach ($data['hours'] as $key => $hrs) {
                    $totalhours = $totalhours + $hrs;
                    $totalminutes = $totalminutes + $data['minutes'][$key];
                }
            }

            if ($totalminutes >= 1) {
                $getminutes = $totalminutes / 60;
            } else {
                $getminutes = 0;
            }

            $alltotalhours = $totalhours + $getminutes;

            $model = new Timesheet;
            $model->employee_id = Session::get('admin')['employee_id'];
            $model->sheet_date = $request->sheet_date;
            $model->is_draft = '0';
            $model->is_submit = '1';
            $model->total_hours_locked = $alltotalhours;
            $model->save();

            // print_r($check_project_id->id);
            // die();''project_id' => $check_project_id->id,
            $timesheet = Timesheet::select('id')->orderBy('id', 'desc')->first();
            if (!empty($data['project_id'])) {
                foreach ($data['project_id'] as $key => $emp_name) {
                    $insertData = [
                        'timesheet_id' => $timesheet->id,
                        'project_id' => $emp_name,
                        // 'task' => $data['task'][$key]?? '0',
                        'task_status' => $data['task_status'][$key],
                        'hours' => $data['hours'][$key] ?? '0',
                        'minutes' => $data['minutes'][$key] ?? '0',
                        'description' => $data['description'][$key] ?? '0',
                    ];
                    $timesheet_detail = new Timesheet_detail();
                    $timesheet_detail->create($insertData);
                }
                Session::flash('message', 'Submit Timesheet Information Successfully save.');
                // return redirect('projects/edit-project/'.$data['project_id']);
                return redirect('timesheets/projects');
            }

            Session::flash('message', 'Submit Timesheet Information Successfully saved.');
            // return redirect('projects/edit-project/'.$data['project_id']);
            return redirect('timesheets/projects');
        } else {
            return redirect('/');
        }
    }
}
