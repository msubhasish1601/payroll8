<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Cast;
use App\Models\Masters\Role_authorization;
use App\Models\Masters\Sub_cast;
use Illuminate\Http\Request;
use Session;
use Validator;
use view;

class CastController extends Controller
{
    //
    public function viewCast()
    {
        if (!empty(Session::get('admin'))) {

            // if (Input::get('del')) {
            //   Cast::where('id', Input::get('del'))
            //     ->update(['cast_status' => 'Trash']);
            //   Session::flash('message', 'Cast Successfully Deleted.');
            //   return back();
            // }
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $data['getCast'] = Cast::get();
            return view('masters/view-cast', $data);
        } else {
            return redirect('/');
        }
    }

    public function addCast()
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            return view('masters/add-new-cast', $data);
        } else {
            return redirect('/');
        }
    }

    public function editCast($id)
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            if ($id != '') {
                $data['getCast'] = Cast::where('id', $id)->where('cast_status', '=', 'active')->get();
                return view('masters/edit-new-cast', $data);
            } else {
                return view('masters/vw-cast', $data);
            }
        } else {
            return redirect('/');
        }
    }

    public function saveCast(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $cast_id = $request->cast_id;
            $cast_name = strtoupper($request->cast_name);

            if (is_numeric($cast_name) == 1) {
                Session::flash('error', 'Caste Should not be numeric.');
                return redirect('masters/vw-cast');
            }

            $validator = Validator::make(
                $request->all(),
                [
                    // 'cast_id'=>'required',
                    'cast_name' => 'required|max:255',
                ],
                [
                    //'cast_id.required'=>'Cast ID Required',
                    'cast_name.required' => 'Cast Name Required',
                ]
            );

            if ($validator->fails()) {
                return redirect('masters/add-new-cast')->withErrors($validator)->withInput();
            } else {

                $data = array(
                    'cast_id' => $cast_id,
                    'cast_name' => $cast_name,
                    'cast_status' => 'active',

                );

                $castemdb = Cast::where('cast_name', '=', trim($request->cast_name))->where('cast_status', '=', 'active')->first();

                if (empty($castemdb)) {
                    $dataInsert = Cast::insert($data);
                    Session::flash('message', 'Cast Successfully saved.');
                } else {
                    Session::flash('error', 'Cast Already Exits.');
                }
                return redirect('masters/vw-cast');
            }
        } else {
            return redirect('/');
        }
    }

    public function updateCast(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $cast_id = $request->cast_id;
            $cast_name = strtoupper($request->cast_name);

            if (is_numeric($cast_name) == 1) {
                Session::flash('error', 'Caste Should not be numeric.');
                return redirect('masters/vw-cast');
            }

            $validator = Validator::make(
                $request->all(),
                [
                    // 'cast_id'=>'required',
                    'cast_name' => 'required|max:255',
                ],
                [
                    //'cast_id.required'=>'Cast ID Required',
                    'cast_name.required' => 'Cast Name Required',
                ]
            );

            if ($validator->fails()) {
                return redirect('masters/edit-new-cast')->withErrors($validator)->withInput();
            } else {

                $data = array(
                    'cast_id' => $cast_id,
                    'cast_name' => $cast_name,
                    'cast_status' => $request->cast_status,
                );

                Cast::where('id', $request->id)
                    ->update($data);
                Session::flash('message', 'Cast Successfully Updated.');
                return redirect('masters/vw-cast');
            }
        } else {
            return redirect('/');
        }
    }

    public function viewSubCast()
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            // if (Input::get('del')) {
            //   Sub_cast::where('id', Input::get('del'))
            //     ->update(['sub_cast_status' => 'Trash']);
            //   Session::flash('message', 'Sub Cast Successfully Deleted.');
            //   return back();
            // }
            $data['getSubCast'] = Sub_cast::leftJoin('casts', 'sub_casts.cast_id', '=', 'casts.id')
            // ->where('sub_cast_status','=','active')
                ->select('sub_casts.*', 'casts.cast_name')
                ->get();

            // $data['getSubCast']=DB::table('sub_cast')->where('sub_cast_status','=','active')->get();
            return view('masters/view-sub-cast', $data);
        } else {
            return redirect('/');
        }
    }

    public function addSubCast()
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $data['getCast'] = Cast::where('cast_status', '=', 'active')->get();
            return view('masters/add-sub-cast', $data);
        } else {
            return redirect('/');
        }
    }

    public function editSubCast($id)
    {

        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            if ($id != ' ') {
                $data['getCast'] = Sub_cast::leftJoin('casts', 'sub_casts.cast_id', '=', 'casts.id')
                    ->where('sub_casts.id', '=', $id)
                    ->select('sub_casts.*', 'casts.cast_name')
                    ->get();
                //$data['getCast']=DB::table('cast')->where('cast_status','=','active')->get();
                return view('masters/edit-sub-cast', $data);
            } else {

                $data['getCast'] = Cast::where('cast_status', '=', 'active')->get();
                return view('masters/add-sub-cast', $data);
            }
        } else {
            return redirect('/');
        }
    }

    public function saveSubCast(Request $request)
    {

        if (!empty(Session::get('admin'))) {

            $sub_cast_name = strtoupper(trim($request->sub_cast_name));
            if (is_numeric($sub_cast_name) == 1) {
                Session::flash('error', 'Sub cast Should not be numeric.');
                return redirect('masters/vw-sub-cast');
            }

            $subcast_id = $request->sub_cast_id;
            $subcast_name = strtoupper($request->sub_cast_name);
            $cast_id = $request->cast_id;
            $validator = Validator::make(
                $request->all(),
                [
                    'cast_id' => 'required',
                    'sub_cast_name' => 'required|max:255',

                ],
                [
                    //'cast_id.required'=>'Cast ID Required',
                    'sub_cast_name.required' => 'Sub Cast Name Required',
                    'sub_cast_id.required' => 'Sub Cast ID Required',
                ]
            );

            if ($validator->fails()) {
                return redirect('masters/add-sub-cast')->withErrors($validator)->withInput();
            } else {

                $data = array(
                    'cast_id' => $cast_id,
                    'sub_cast_id' => $subcast_id,
                    'sub_cast_name' => $subcast_name,
                    'sub_cast_status' => 'active',

                );

                $subcastemdb = Sub_cast::where('sub_cast_name', '=', trim($request->sub_cast_name))->where('sub_cast_status', '=', 'active')->first();

                if (empty($subcastemdb)) {
                    $check_sub_cast = Sub_cast::where('sub_cast_name', $sub_cast_name)->first();
                    if (!empty($check_sub_cast)) {
                        Session::flash('message', 'Already Exists.');
                        return redirect('masters/vw-sub-cast');
                    }
                    $dataInsert = Sub_cast::insert($data);
                    Session::flash('message', 'Sub Cast Successfully saved.');
                } else {
                    Session::flash('error', 'Sub Cast Already Exits.');
                }
                return redirect('masters/vw-sub-cast');
            }
        } else {
            return redirect('/');
        }
    }

    public function updateSubCast(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $sub_cast_name = strtoupper(trim($request->sub_cast_name));
            if (is_numeric($sub_cast_name) == 1) {
                Session::flash('error', 'Sub cast Should not be numeric.');
                return redirect('masters/vw-sub-cast');
            }

            $subcast_id = $request->sub_cast_id;
            $subcast_name = strtoupper($request->sub_cast_name);
            $cast_id = $request->cast_id;
            $validator = Validator::make(
                $request->all(),
                [
                    'cast_id' => 'required',
                    'sub_cast_name' => 'required|max:255',

                ],
                [
                    //'cast_id.required'=>'Cast ID Required',
                    'sub_cast_name.required' => 'Sub Cast Name Required',
                    'sub_cast_id.required' => 'Sub Cast ID Required',
                ]
            );

            if ($validator->fails()) {
                return redirect('masters/add-sub-cast')->withErrors($validator)->withInput();
            } else {

                $data = array(
                    'id' => $cast_id,
                    'sub_cast_id' => $subcast_id,
                    'sub_cast_name' => $subcast_name,
                    'sub_cast_status' => $request->cast_status,

                );

                Sub_cast::where('id', $request->cast_id)
                    ->update($data);
                Session::flash('message', 'Sub Cast Successfully Updated.');
                return redirect('masters/vw-sub-cast');
            }
        } else {
            return redirect('/');
        }
    }
}
