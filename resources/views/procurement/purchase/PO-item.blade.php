@extends('procurement.purchase.layouts.master')

@section('title')
Purchase Order For Item
@endsection

@section('sidebar')
	@include('procurement.purchase.partials.sidebar')
@endsection

@section('header')
	@include('procurement.purchase.partials.header')
@endsection



@section('scripts')
	@include('procurement.purchase.partials.scripts')
@endsection

@section('content')
<style>
    .card-title img {
        width: 35px;
    }

    .aply-lv a {
        background: #1c9ac5;
        color: #fff;
        padding: 6px 24px;
        font-size: 14px;
    }

    .btn-info {
        color: #fff;
        background-color: #17a2b8;
        border-color: #17a2b8;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        padding: 6px 10px;
    }

    .btn-danger {
        background: #d86a09 !important;
        border: none;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        padding: 6px 10px;
    }

</style>
       <!-- Content -->
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
                <!-- Widgets  -->
                <div class="row">

                    <div class="main-card">


                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title" style="font-size:21px; font-weight: 100;"><img src="{{asset('images/issue-register.png')}}" alt=""> Purchase Order</strong>
                            </div>
							@if(Session::has('message'))
								<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
							@endif
{{--							<div class="aply-lv" style="padding-right: 36px;">--}}
{{--								<a href="{{ url('procurement/purchase/add-po-item') }}" class="btn btn-default">Add Purchase Order <i class="fa fa-plus"></i></a>--}}
{{--							</div>--}}
                            <div class="card-body">

							<div class="srch-rslt" style="overflow-x:scroll;">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
											<th>PO No.</th>
											<th>Purchase Request Number</th>
											<th>Total</th>
											<!--<th>Shiping Name</th>-->
											<th>Shipping Company</th>
											<th>Shipping State</th>
											<th>Shipping City</th>
											<th width="100">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									@foreach($po_item_rs as $po_item)
                                        <tr>
                                            <td>{{ $po_item->purchase_order_no }}</td>
											<td>{{ $po_item->requisition_no }}</td>
											<td>{{ $po_item->total }}</td>
											<!--<td>{{ $po_item->shipping_name }}</td>-->
											<td>{{ $po_item->shipping_company }}</td>
											<td>{{ $po_item->shipping_state }}</td>
											<td>{{ $po_item->shipping_city }}</td>
											<td><a href='{{url("procurement/purchase/edit-po-item/$po_item->requisition_no")}}' class="btn btn-round btn-info"><i class="fa fa-pencil-square-o" style="color: #fff;" aria-hidden="true"></i></a>
												<!-- <a href="" class="btn btn-round btn-danger"><i class="fa fa-trash" style="color: #fff;" aria-hidden="true"></i></a> -->
                                                <a href='{{url("procurement/purchase/view-po-item/$po_item->purchase_order_no")}}' class="btn btn-round btn-info"><i class="fa fa-eye" style="color: #fff;" aria-hidden="true"></i></a></td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div>



                </div>
                <!-- /Widgets -->



            </div>
            <!-- .animated -->
        </div>
        <!-- /.content -->
@endsection
