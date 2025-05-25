<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Models\Attendance\Upload_attendence;
use App\Models\Masters\Role_authorization;
use Illuminate\Http\Request;
use League\Csv\Reader;
use Session;
use View;

class UploadAttendenceController extends Controller
{
    public function viewdashboard()
    {
        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            return View('attendance/dashboard', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewUploadAttendence()
    {
        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            return view('attendance/upload-data', $data);
        } else {
            return redirect('/');
        }
    }

    public function importExcel(Request $request)
    {

        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            $request->validate(
                [
                    'upload_csv' => 'required|mimes:csv,txt',
                ],
                ['upload_csv.required' => 'File Must Be required!',
                    'upload_csv.mimes' => 'File Must Be CSV format!']
            );

            $path = $request->file('upload_csv');
            $reader = Reader::createFromPath($path->getRealPath());

            //dd($reader);

            $month_entry = Upload_attendence::distinct()->get(['month_yr']);

            $entrymonth = array();

            foreach ($month_entry as $month) {
                $entrymonth[] = $month->month_yr;
            }

            foreach ($reader as $key => $value) {

                //if ($key > 0) {
                //dd($value);
                $datein = strtotime(date("Y-m-d " . $value[4]));
                // dd($datein);
                $dateout = strtotime(date("Y-m-d " . $value[5]));
                $difference = abs($dateout - $datein) / 60;
                $hours = floor($difference / 60);
                $minutes = ($difference % 60);
                $duty_hours = $hours . ":" . $minutes;

                $dutyhr = $duty_hours;

                $attdate = $value[6];
                $date = str_replace('/', '-', $attdate);
                $att_date = date("Y-m-d", strtotime($date));

                $data = array(
                    'employee_code' => $value[1],
                    'name' => $value[2],
                    'shift' => $value[3],
                    'arrival_time' => $value[4],
                    'departure_time' => $value[5],
                    'att_date' => $att_date,
                    'month_yr' => $value[7],
                    'attendence_status' => $value[8],
                    'duty_hrs' => $dutyhr,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s'),
                );
                // dd($data);
                if (in_array($value[7], $entrymonth)) {
                    Session::flash('error', 'Already process is completed for the month ' . $value[7] . '.');
                    return redirect('attendance/upload-data');
                } else {

                    if (empty($data['employee_code']) || empty($data['name']) || empty($data['att_date'])) {

                        Session::flash('error', 'Error in Attendance Sheet .');
                        return redirect('attendance/upload-data');
                    } else {
                        $upload_attendence = new Upload_attendence;
                        $upload_attendence->employee_code = $data['employee_code'];

                        $upload_attendence->name = $data['name'];
                        $upload_attendence->shift = $data['shift'];
                        $upload_attendence->arrival_time = $data['arrival_time'];
                        $upload_attendence->departure_time = $data['departure_time'];
                        $upload_attendence->att_date = $data['att_date'];
                        $upload_attendence->month_yr = $data['month_yr'];
                        $upload_attendence->attendence_status = $data['attendence_status'];
                        $upload_attendence->duty_hrs = $data['duty_hrs'];
                        $upload_attendence->updated_at = date('Y-m-d H:i:s');
                        $upload_attendence->created_at = date('Y-m-d H:i:s');

                        //dd($upload_attendence);
                        $upload_attendence->save();

                    }

                }

                //}

            }

            Session::flash('message', 'Attendance  Information Successfully saved.');
            return redirect('attendance/upload-data');
        } else {
            return redirect('/');
        }
    }
}
