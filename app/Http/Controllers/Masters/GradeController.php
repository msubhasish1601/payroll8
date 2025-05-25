<?php

namespace App;

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Company;
use App\Models\Masters\Grade;
use Illuminate\Http\Request;
use view;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class GradeController extends Controller
{
  //
  public function viewAddGrade()
  {
    if (!empty(Session::get('admin'))) {


      //$company_rs=Company::where('company_status','=','active')->get();
      return view('masters/grade');
    } else {
      return redirect('/');
    }
  }

  public function editGrade($id)
  {
    if (!empty(Session::get('admin'))) {

      if ($id != '') {
        $data['getGrade'] = Grade::where('id', '=', $id)->get();
        return view('masters/edit-grade', $data);
      } else {
        //$company_rs=Company::where('company_status','=','active')->get();
        return view('masters/grade');
      }
    } else {
      return redirect('/');
    }
  }

  public function saveGrade(Request $request)
  {
    if (!empty(Session::get('admin'))) {

      $grade_name = strtoupper(trim($request->grade_name));


      if (is_numeric($grade_name) == 1) {
        Session::flash('error', 'Pay level Should not be numeric.');
        return redirect('masters/vw-grade');
      }

      $check_grade = Grade::where('grade_name', $grade_name)->first();
      if (!empty($check_grade)) {
        Session::flash('error', 'Grade Alredy Exists.');
        return redirect('masters/vw-grade');
      }

      $filename = '';

      $validator = Validator::make(
        $request->all(),
        [
          'grade_name' => 'required|max:255'
        ],
        [
          'grade_name.required' => 'Grade Name Required'
        ]
      );

      if ($validator->fails()) {
        return redirect('masters/grade')
          ->withErrors($validator)
          ->withInput();
      } else {


        //$data = request()->except(['_token']);
        $data = array(
          'grade_name' => strtoupper($request->grade_name),
          'created_at' => date('Y-m-d h:i:s')
        );

        $grade = new Grade();
        $grade->create($data);
        //$company->save($data);  //time stamps false in model
        Session::flash('message', 'Grade Information Successfully saved.');
        return redirect('masters/vw-grade');
      }
    } else {
      return redirect('/');
    }
  }

  public function updateGrade(Request $request)
  {

    if (!empty(Session::get('admin'))) {

      $grade_name = strtoupper(trim($request->grade_name));


      if (is_numeric($grade_name) == 1) {
        Session::flash('error', 'Pay level Should not be numeric.');
        return redirect('masters/vw-grade');
      }

      // $check_grade = Grade::where('grade_name', $grade_name)->first();
      // if (!empty($check_grade)) {
      //   Session::flash('message', 'Grade Alredy Exists.');
      //   return redirect('masters/vw-grade');
      // }

      $filename = '';

      $validator = Validator::make(
        $request->all(),
        [
          'grade_name' => 'required|max:255'
        ],
        [
          'grade_name.required' => 'Grade Name Required'
        ]
      );

      if ($validator->fails()) {
        return redirect('masters/grade')
          ->withErrors($validator)
          ->withInput();
      } else {

        $data = array(
          'grade_name' => strtoupper($request->grade_name),
          'created_at' => date('Y-m-d h:i:s'),
          'updated_at' => date('Y-m-d h:i:s'),
          'grade_status' => $request->status,
        );
        Grade::where('id', $request->id)->update($data);
        Session::flash('message', 'Grade Information Successfully Updated.');
        return redirect('masters/vw-grade');
      }
    } else {
      return redirect('/');
    }
  }


  public function getGrades()
  {

    if (!empty(Session::get('admin'))) {

      //  if(Input::get('del'))
      //  {
      //       DB::table('grade')
      // ->where('id', Input::get('del'))
      // ->update(['grade_status' => 'Trash']);
      //        Session::flash('message','Grade Successfully Deleted.');
      //       return back();
      //  }

      $grade_rs = Grade::where('grade_status', '=', 'active')
        ->get();

      return view('masters/view-grade', compact('grade_rs'));
    } else {
      return redirect('/');
    }
  }
}
