<?php

namespace App\Http\Controllers\Masters;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Emp_type_da;
use App\Models\Masters\Employee_type;
use App\Models\Masters\Grade;
use App\Models\Masters\Pay_type;
use Validator;
use Session;
use View;
use Illuminate\Support\Facades\Input;
use Auth;

class EmpTypeDaController extends Controller
{

    public function getEmpTypeDA()
    {
        if (!empty(Session::get('admin'))) {

            
            $data['emp_type_da'] = Emp_type_da::leftJoin('employee_types','employee_types.id', '=', 'emp_type_da.emp_type')
            ->leftJoin('grades','grades.id', '=', 'emp_type_da.emp_grade')
            ->select('emp_type_da.*', 'employee_types.employee_type_name', 'grades.grade_name')
            ->get();
            return view('masters/emp-type-da', $data);
        } else {
            return redirect('/');
        }
    }

    public function addEmpTypeDA()
    {
        if (!empty(Session::get('admin'))) {

            $data['emp_type'] = Employee_type::where('employee_type_status', '=', 'active')->get();
            $data['grade_type'] = Grade::where('grade_status', '=', 'active')->get();
            return view('masters/add-emp-type-da', $data);
        } else {
            return redirect('/');
        }
    }

    public function saveEmpTypeDA(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'emp_type' => 'required',
                    'da_percent' => 'required',
                    'emp_grade' => 'required'

                ],
                [
                    'emp_type.required' => 'Employee Type Required',
                    'da_percent.required' => 'DA Percent Required',
                    'emp_grade.required' => 'Employee Grade Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('masters/add-emp-type-da')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'emp_type' => $request->input('emp_type'),
                'da_percent' => $request->input('da_percent'),
                'emp_grade' => $request->input('emp_grade')
            );

            $emp_type_da = new Emp_type_da();
            $emp_type_da->create($data);
            Session::flash('message', 'Employee Type DA Information Successfully Saved.');

            return redirect('masters/emp-type-da');
        } else {
            return redirect('/');
        }
    }

    public function editEmpTypeDA($id)
    {
        if (!empty(Session::get('admin'))) {

            $data['emp_type_da'] = Emp_type_da::leftJoin('employee_types', 'emp_type_da.emp_type', '=', 'employee_types.id')
            ->leftJoin('grades', 'grades.id', '=', 'emp_type_da.emp_grade')
                ->where('emp_type_da.id', '=', $id)
                ->select('emp_type_da.*', 'employee_types.employee_type_name', 'grades.grade_name')
                ->first();

            $data['emp_type'] = Employee_type::where('employee_type_status', '=', 'active')->get();
            $data['grade_type'] = Grade::where('grade_status', '=', 'active')->get();
            return view('masters/edit-emp-type-da', $data);
        } else {
            return redirect('/');
        }
    }

    public function updateEmpTypeDA(Request $request)
	{
		if (!empty(Session::get('admin'))) {

			$validator = Validator::make(
                $request->all(),
                [
                    'emp_type' => 'required',
                    'da_percent' => 'required',
                    'emp_grade' => 'required'

                ],
                [
                    'emp_type.required' => 'Employee Type Required',
                    'da_percent.required' => 'DA Percent Required',
                    'emp_grade.required' => 'Employee Grade Required'

                ]
            );

			if ($validator->fails()) {
                return redirect('masters/edit-emp-type-da')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'emp_type' => $request->input('emp_type'),
                'da_percent' => $request->input('da_percent'),
                'emp_grade' => $request->input('emp_grade')
            );

				Emp_type_da::where('id', $request['id'])->update($data);
				Session::flash('message', 'Employee Type DA Information Successfully Updated.');
				return redirect('masters/emp-type-da');
			
		} else {
			return redirect('/');
		}
	}

    public function deleteEmpTypeDA($id)
    {
        if (!empty(Session::get('admin'))) {

				$dataUpdate = Emp_type_da::where('id', $id)->delete();
                Session::flash('message', 'Employee Type DA Information Successfully Deleted.');
				return redirect('masters/emp-type-da');
			
        } else {
            return redirect('/');
        }
    }
}
