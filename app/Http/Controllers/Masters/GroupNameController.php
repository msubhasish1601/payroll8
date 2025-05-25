<?php

namespace App\Http\Controllers\Masters;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Group_name_detail;
use Validator;
use Session;
use View;
use Illuminate\Support\Facades\Input;
use Auth;

class GroupNameController extends Controller
{
    public function getGroupName()
    {
        if (!empty(Session::get('admin'))) {

            $group_name = Group_name_detail::get();
            return view('masters/view-group-name', compact('group_name'));
        } else {
            return redirect('/');
        }
    }

    public function addGroupName()
    {
        if (!empty(Session::get('admin'))) {

            return view('masters/add-group-name');
        } else {
            return redirect('/');
        }
    }

    public function saveGroupName(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'group_name' => 'required'

                ],
                [
                    'group_name.required' => 'Group Name Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('masters/add-group-name')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $exit=Group_name_detail::where('group_name','=',$request['group_name'])->first();
     if(empty($exit)){
            $data = array(

                'group_name' => $request->input('group_name'),
				'status' => $request->input('status')
            );


            $group_name = new Group_name_detail();
            $group_name->create($data);
            Session::flash('message', 'Class  Name Information Successfully Saved.');
}else{
      Session::flash('error', 'Class  Name Already Exits.');
}
            return redirect('masters/group-name');
        } else {
            return redirect('/');
        }
    }

    public function editGroupName($id)
    {
        if (!empty(Session::get('admin'))) {

            $data['group'] = Group_name_detail::where('id', '=', $id)->first();
           
            return view('masters/edit-group-name', $data);
        } else {
            return redirect('/');
        }
    }

    public function updateGroupName(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'group_name' => 'required'

                ],
                [
                    'group_name.required' => 'Group Name Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('masters/edit-group-name')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $exit=Group_name_detail::where('group_name','=',$request['group_name'])->where('id','!=',$request->id)->first();
     
     if(empty($exit)){
            $data = array(

                'group_name' => $request->input('group_name'),
				 'status' => $request->input('status')
				
            );

            Group_name_detail::where('id', $request['id'])->update($data);
              Session::flash('message', 'Class  Name Information Successfully Updated.');
     }
     else{
      Session::flash('error', 'Class  Name Already Exits.');
}
     
          
            return redirect('masters/group-name');
        } else {
            return redirect('/');
        }
    }

    public function deleteGroupName($id)
    {
        if (!empty(Session::get('admin'))) {

				$group = Group_name_detail::where('id', $id)->delete();
                Session::flash('message', 'Class  Name Information Successfully Deleted.');
				return redirect('masters/group-name');
			
        } else {
            return redirect('/');
        }
    }


}
