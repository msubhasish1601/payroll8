<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Account_master;
use App\Models\Masters\Category;
use App\Models\Masters\Sub_category;
use Validator;
use Session;
use DB;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!empty(Session::get('admin'))) {

            $subcategories = Sub_category::leftjoin('categories', 'sub_categories.cat_name', '=', 'categories.cat_code')
                ->select('sub_categories.*', 'categories.cat_name as cate_name')
                ->get();

            return view('masters/sub-categories', compact('subcategories'));
        } else {
            return redirect('/');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!empty(Session::get('admin'))) {

            $categories = Category::all();
            $accounts = Account_master::all();

            return view('masters/add-new-sub-category', compact('categories', 'accounts'));
        } else {
            return redirect('/');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            // dd($request);

            $validator = Validator::make(
                $request->all(),
                [
                    'sub_cat_code' => 'required',
                    'cat_name' => 'required',
                    'sub_cat_name' => 'required',
                    'coa_code' => 'required',
                ],
                [
                    'sub_cat_code.required' => 'Sub Category Code Required',
                    'cat_name.required' => 'Category Name Required',
                    'sub_cat_name.required' => 'Sub Category Name Required',
                    'coa_code.required' => 'Account Code Required',
                ]
            );

            if ($validator->fails()) {
                return redirect('masters/sub-category')->withErrors($validator)->withInput();
            }

            $category = new Sub_category();

            $data['sub_cat_code'] = $request->sub_cat_code;
            $data['cat_name'] = $request->cat_name;
            $data['sub_cat_name'] = $request->sub_cat_name;
            $data['coa_code'] = $request->coa_code;
            $category->create($data);
            // print_r($data);
            // die();
            Session::flash('message', 'Successfully created Sub-Category!');

            return redirect('masters/vw-sub-category');
        } else {
            return redirect('/');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!empty(Session::get('admin'))) {

            $subcategory = Sub_category::findOrFail($id);
            $categories = Category::all();
            $accounts = Account_master::all();

            return view('masters/edit-new-sub-category', compact('categories', 'subcategory', 'accounts'));
        } else {
            return redirect('/');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            if (!empty($request->id)) {
                $data2 = $request->all();
                // dd($data2);
                $data2 = request()->except(['_token']);

                $data2['sub_cat_code'] = $request->sub_cat_code;
                $data2['cat_name'] = $request->cat_name;
                $data2['sub_cat_name'] = $request->sub_cat_name;
                $data2['coa_code'] = $request->coa_code;

                Sub_category::where('id', $request->id)->update($data2);

                Session::flash('message', 'Sub-Category Successfully Updated.');
            } else {
            }
            return redirect('masters/vw-sub-category');
        } else {
            return redirect('/');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function subCategoryID($category_id)
    {
        if (!empty(Session::get('admin'))) {

            $subcategpories = Sub_category::where('cat_name', '=', $category_id)->get();
            return $subcategpories;
        } else {
            return redirect('/');
        }
    }
}
