<?php

namespace App\Http\Controllers\Masters;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Employee_type;
use App\Models\Masters\Grade;
use App\Models\Masters\Hra_master;
use Validator;
use Session;
use View;
use Illuminate\Support\Facades\Input;
use Auth;

class HraController extends Controller
{
    public function getHraMaster()
    {
        if (!empty(Session::get('admin'))) {

            $data['hra_master'] = Hra_master::leftJoin('employee_types', 'employee_types.id', '=', 'hra_masters.emp_type')
                ->leftJoin('grades', 'grades.id', '=', 'hra_masters.grade_type')
                ->select('hra_masters.*', 'employee_types.employee_type_name', 'grades.grade_name')
                ->where('employee_types.employee_type_status', '=', 'Active')
                ->where('grades.grade_status', '=', 'active')
                ->get();
            return view('masters/hra-master', $data);
        } else {
            return redirect('/');
        }
    }

    public function addHraMaster()
    {
        if (!empty(Session::get('admin'))) {
            $data['hra_master'] = Hra_master::get();
            $data['emp_type'] = Employee_type::where('employee_type_status', '=', 'Active')->get();
            $data['grade_type'] = Grade::where('grade_status', '=', 'active')->get();
            return view('masters/add-hra-master', $data);
        } else {
            return redirect('/');
        }
    }


    public function saveHraMaster(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'hra_rate' => 'required',
                    'emp_type' => 'required',
                    'max_amount' => 'required',
                    'grade_type' => 'required'

                ],
                [
                    'hra_rate.required' => 'HRA Rate Required',
                    'emp_type.required' => 'Employee Type Required',
                    'max_amount.required' => 'Max Amount Required',
                    'grade_type.required' => 'Grade Type Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('masters/add-hra-master')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'hra_rate' => $request->input('hra_rate'),
                'emp_type' => $request->input('emp_type'),
                'max_amount' => $request->input('max_amount'),
                'grade_type' => $request->input('grade_type')
            );


            $hra_master = new Hra_master();
            $hra_master->create($data);
            Session::flash('message', 'HRA Master Information Successfully Saved.');

            return redirect('masters/hra-master');
        } else {
            return redirect('/');
        }
    }


    public function editHraMaster($id)
    {
        if (!empty(Session::get('admin'))) {

            $data['hra_master'] = Hra_master::leftJoin('employee_types', 'employee_types.id', '=', 'hra_masters.emp_type')
                ->leftJoin('grades', 'grades.id', '=', 'hra_masters.grade_type')
                ->select('hra_masters.*', 'employee_types.employee_type_name', 'grades.grade_name')
                ->where('employee_types.employee_type_status', '=', 'Active')
                ->where('hra_masters.id', '=', $id)
                ->where('grades.grade_status', '=', 'active')
                ->first();

            $data['emp_type'] = Employee_type::where('employee_type_status', '=', 'Active')->get();
            $data['grade_type'] = Grade::where('grade_status', '=', 'active')->get();

            return view('masters/edit-hra-master', $data);
        } else {
            return redirect('/');
        }
    }

    public function updateHraMaster(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'hra_rate' => 'required',
                    'emp_type' => 'required',
                    'max_amount' => 'required',
                    'grade_type' => 'required'

                ],
                [
                    'hra_rate.required' => 'HRA Rate Required',
                    'emp_type.required' => 'Employee Type Required',
                    'max_amount.required' => 'Max Amount Required',
                    'grade_type.required' => 'Grade Type Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('masters/add-hra-master')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'hra_rate' => $request->input('hra_rate'),
                'emp_type' => $request->input('emp_type'),
                'max_amount' => $request->input('max_amount'),
                'grade_type' => $request->input('grade_type')
            );

            Hra_master::where('id', $request['id'])->update($data);
            Session::flash('message', 'HRA Master Information Successfully Updated.');
            return redirect('masters/hra-master');
        } else {
            return redirect('/');
        }
    }

    public function deleteHraMaster($id)
    {
        if (!empty(Session::get('admin'))) {

            $dataUpdate = Hra_master::where('id', $id)->delete();
            Session::flash('message', 'HRA Master Information Successfully Deleted.');
            return redirect('masters/hra-master');
        } else {
            return redirect('/');
        }
    }
}
