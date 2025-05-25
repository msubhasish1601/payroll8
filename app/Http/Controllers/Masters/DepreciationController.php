<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Masters\Gpfrate;
use App\Models\Masters\Assets_mapping;
use App\Models\Masters\Depreciation_rate;
use View;
use Validator;
use Session;
use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;

class DepreciationController extends Controller
{


    public function viewDepreciationRateData()
    {
        if (!empty(Session::get('admin'))) {

            if (!empty(Session::get('admin'))) {
                return view('masters/get-asset-rate-list');
            } else {
                return redirect('/');
            }
        } else {
            return redirect('/');
        }
    }


    public function populateDepreciationRateData(Request $request)
    {

        if (!empty(Session::get('admin'))) {
            $getyear_range = explode("-", $request->financial_year);

            $asset_lists = Assets_mapping::where('type', '=', $request->type)->get();
            //print_r($asset_lists);
            foreach ($asset_lists as $key => $asset_list) {
                $total = 0;
                $addition = Depreciation_rate::where('item', 'like', '%' . $asset_lists[$key]->item . '%')
                    ->where('financial_year', '=', $request->financial_year)
                    ->orderBy('id', 'DESC')
                    ->first();
                //	print_r($addition);
                if (empty($addition->rate)) {
                    $total = 0;
                } else {
                    $total = $addition->rate;
                }

                //$gross_closing_balance= 0+$total;

                $data['result'][] = array('item' => $asset_lists[$key]->item, 'code' => $asset_lists[$key]->code,  'financial_year' => $request->financial_year,  'rate' => $total);
            }
            //print_r($data['result']);
            //exit;
            $data['financial_year'] = $request->financial_year;
            $data['type'] = $request->type;
            return view('masters/get-asset-rate-list', $data);
        } else {
            return redirect('/');
        }
    }
    public function saveDepreciationRateData(Request $request)
    {

        if (!empty(Session::get('admin'))) {

            if ($request->has('savedata')) {
                //echo "<pre>"; print_r($request->all()); exit;
                foreach ($request->item as $key => $value) {

                    $addition = Depreciation_rate::where('item', 'like', '%' . $value . '%')
                        ->where('financial_year', '=', $request->financial_year[$key])
                        ->orderBy('id', 'DESC')
                        ->first();

                    if (empty($addition->rate)) {
                        Depreciation_rate::insert(
                            ['item' => $value, 'code' => $request->code[$key], 'financial_year' => $request->financial_year[$key], 'rate' =>  $request->rate[$key]]
                        );
                    } else {
                        $payupdate = array(
                            'item' => $value, 'code' => $request->code[$key], 'financial_year' => $request->financial_year[$key], 'rate' =>  $request->rate[$key],
                        );

                        Depreciation_rate::where('item', 'like', '%' . $value . '%')
                            ->where('financial_year', '=', $request->financial_year[$key])
                            ->update($payupdate);
                    }
                    //  print_r($addition);exit;
                }
            }
            Session::flash('message', 'Record has been successfully updated');
            return redirect('depreciation/rate');
        } else {
            return redirect('/');
        }
    }
}
