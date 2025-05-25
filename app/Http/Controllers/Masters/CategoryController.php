<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Category;
use Validator;
use Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function categoryList()
    {
        if (!empty(Session::get('admin'))) {

            $categories = Category::all();
            return view('masters/categories', compact('categories'));
        } else {
            return redirect('/');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addCategory()
    {
        if (!empty(Session::get('admin'))) {

            return view('masters/add-new-category');
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
    public function saveCategory(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            // dd($request);
            if (empty($request->id)) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'cat_name' => 'required',
                        'cat_code' => 'required',
                    ],
                    [
                        'cat_name.required' => 'Category Name Required',
                        'cat_code.required' => 'Category Code Required',
                    ]
                );

                if ($validator->fails()) {
                    return redirect('masters/category')->withErrors($validator)->withInput();
                }

                $category = new Category;

                $data['cat_name'] = $request->cat_name;
                $data['cat_code'] = $request->cat_code;
                $category->create($data);

                Session::flash('message', 'Successfully created Category!');
            }


            return redirect('masters/vw-category');
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
    public function editCategory($id)
    {
        if (!empty(Session::get('admin'))) {

            $category = Category::findOrFail($id);

            return view('masters/edit-new-category', compact('category'));
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
    public function updateCategory(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            // dd($request);
            if (!empty($request->id)) {
                $data2 = $request->all();
                // dd($data2);
                $data2 = request()->except(['_token']);

                $data2['cat_name'] = $request->cat_name;
                $data2['cat_code'] = $request->cat_code;

                Category::where('id', $request->id)->update($data2);

                Session::flash('message', 'Category Successfully Updated.');
            }


            return redirect('masters/vw-category');
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
}
