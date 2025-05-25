<?php

namespace App\Http\Controllers\Masters;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Cooperative_master;
use Validator;
use Session;
use View;
use Illuminate\Support\Facades\Input;
use Auth;

class CooperativeController extends Controller
{
    public function getCoopMaster()
    {
        if (!empty(Session::get('admin'))) {

            $coop_master = Cooperative_master::get();
            return view('masters/cooperative-master', compact('coop_master'));
        } else {
            return redirect('/');
        }
    }

    public function addCoopMaster()
    {
        if (!empty(Session::get('admin'))) {

            return view('masters/add-cooperative-master');
        } else {
            return redirect('/');
        }
    }


    public function saveCoopMaster(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'cooperative_name' => 'required'

                ],
                [
                    'cooperative_name.required' => 'Co-Operative Name Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('masters/add-cooperative-master')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'cooperative_name' => $request->input('cooperative_name')
            );


            $coop_master = new Cooperative_master();
            $coop_master->create($data);
            Session::flash('message', 'Co-Operative Master Information Successfully Saved.');

            return redirect('masters/cooperative-master');
        } else {
            return redirect('/');
        }
    }


    public function editCoopMaster($id)
    {
        if (!empty(Session::get('admin'))) {

            $data['coop_master'] = Cooperative_master::where('id', '=', $id)->first();
            return view('masters/edit-cooperative-master', $data);
        } else {
            return redirect('/');
        }
    }

    public function updateCoopMaster(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'cooperative_name' => 'required'

                ],
                [
                    'cooperative_name.required' => 'Co-Operative Name Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('masters/add-cooperative-master')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'cooperative_name' => $request->input('cooperative_name')
            );

            Cooperative_master::where('id', $request['id'])->update($data);
            Session::flash('message', 'Co-Operative Master Information Successfully Updated.');
            return redirect('masters/cooperative-master');
        } else {
            return redirect('/');
        }
    }

    public function deleteCoopMaster($id)
    {
        if (!empty(Session::get('admin'))) {

				$dataUpdate = Cooperative_master::where('id', $id)->delete();
                Session::flash('message', 'Co-Operative Master Information Successfully Deleted.');
				return redirect('masters/cooperative-master');
			
        } else {
            return redirect('/');
        }
    }
}
