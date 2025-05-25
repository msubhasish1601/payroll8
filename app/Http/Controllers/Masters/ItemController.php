<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Sub_category;
use App\Models\Masters\Category;
use App\Models\Masters\Item;
use App\Models\Masters\Unit;
use Illuminate\Support\Facades\Validator;
use Session;

class ItemController extends Controller
{
	//
	public function getItem()
	{
		if (!empty(Session::get('admin'))) {

			$item_rs = Item::leftJoin('units', 'items.unit_id', '=', 'units.id')
				->leftJoin('categories', 'items.c_id', '=', 'categories.cat_code')
				->leftJoin('sub_categories', 'items.sc_id', '=', 'sub_categories.sub_cat_code')
				->select('items.*', 'units.name as unit_name', 'categories.cat_name', 'sub_categories.sub_cat_name')
				->get();

			// dd($item_rs);
			return view('masters/view-item', compact('item_rs'));
		} else {
			return redirect('/');
		}
	}

	public function viewItem()
	{
		if (!empty(Session::get('admin'))) {

			$unit_rs = Unit::where('status', '=', 'active')->get();

			$categories = Category::all();

			$subcategories = Sub_category::all();
			return view('masters/item', compact('unit_rs', 'categories', 'subcategories'));
		} else {
			return redirect('/');
		}
	}

	public function getItemById($id)
	{
		if (!empty(Session::get('admin'))) {

			$item = Item::findOrFail($id);
			// dd($item);
			$unit_rs = Unit::where('status', '=', 'active')->get();

			$categories = Category::all();
			$subcategories = Sub_category::all();

			return view('masters/edit-item', compact('unit_rs', 'item', 'categories', 'subcategories'));
		} else {
			return redirect('/');
		}
	}

	public function saveItem(Request $request)
	{
		if (!empty(Session::get('admin'))) {

			if (empty($request->id)) {

				// dd($request);
				$validator = Validator::make(
					$request->all(),
					[
						'item_code' => 'required|unique:items',
						'name' => 'required',
						'type' => 'required',
						'unit_id' => 'required',
						'status' => 'required',
						'min_stock' => 'required|numeric',
						'max_stock' => 'required|numeric',
						'stockable' => 'required'

					],
					[
						'item_code.required' => 'Item Code Required',
						'item_code.unique' => 'Item Code already exists',
						'name.required' => 'Item Name Required',
						'type.required' => 'Item Type Required',
						'unit_id.required' => 'Item Unit Required',
						'status.required' => 'Item Status Required',
						'stockable.required' => 'Stockable Required'

					]
				);

				if ($validator->fails()) {

					return redirect('masters/add-item')->withErrors($validator)->withInput();
				}

				$item = new Item();
				// //print_r($request->all()); exit;
				// $data['item_code'] = $request->item_code;
				// $data['name'] = $request->name;
				// $data['type'] = $request->type;
				// $data['c_id'] = $request->category_id;
				// $data['min_stock'] = $request->min_stock;
				// $data['unit_id'] = $request->unit_id;
				// $data['status'] = $request->status;

				//$item->create($data);
				Item::insert(
					['item_code' => $request->item_code, 'name' => $request->name, 'type' => $request->type, 'c_id' => $request->c_id, 'sc_id' => $request->sc_id, 'min_stock' => $request->min_stock, 'max_stock' => $request->max_stock, 'unit_id' => $request->unit_id, 'stockable' => $request->stockable, 'status' => $request->status, 'gst' => $request->gst, 'item_desc' => $request->item_desc, 'created_at' => date('Y-m-d'), 'updated_at' => date('Y-m-d')]
				);
				// DB::insert($data);

				Session::flash('message', 'Item Information Successfully Saved.');
			}

			return redirect('masters/vw-item');
		} else {
			return redirect('/');
		}
	}

	public function updateItem(Request $request)
	{
		if (!empty(Session::get('admin'))) {

			if (!empty($request->id)) {
				$data2 = $request->all();
				$data2 = request()->except(['_token']);

				// $data2['supplier_status'] = 'active';

				Item::where('id', $request->id)->update($data2);

				Session::flash('message', 'Item Information Successfully Updated.');
			}

			return redirect('masters/vw-item');
		} else {
			return redirect('/');
		}
	}
}
