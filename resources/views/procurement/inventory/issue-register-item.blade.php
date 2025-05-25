@extends('procurement.inventory.layouts.master')

@section('title')
Inventory
@endsection

@section('sidebar')
	@include('procurement.inventory.partials.sidebar')
@endsection

@section('header')
	@include('procurement.inventory.partials.header')
@endsection



@section('scripts')
	@include('procurement.inventory.partials.scripts')
@endsection

<style>


    .card-title {
    font-size: 21px !important;
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
</style>

@section('content')

        <!-- Content -->
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
                <!-- Widgets  -->
                <div class="row">

                    <div class="main-card">

                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title" style="font-size:21px; font-weight: 100;"><img src="{{asset('images/issue-register.png')}}" alt="" style="width: 35px;">Issue Register</strong>
                            </div>
							@if(Session::has('message'))
								<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
							@endif
							<div class="aply-lv" style="padding-right: 36px;">
								<a href="{{ url('procurement/inventory/add-issue-register-item') }}" class="btn btn-default" style="background: #1c9ac5; color: #fff; padding: 6px 24px; font-size: 14px;">Add <i class="fa fa-plus"></i></a>
							</div>
                            <div class="card-body">

							<div class="srch-rslt" style="overflow-x:scroll;">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
											<th>Item Name</th>
											<th>Units</th>
											<th>Opening Stock</th>
											<th>Required Qty</th>
											<th>Issue Qty</th>
											<th>Issue Date</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									@foreach($issue_item_rs as $issue_item)
                                        <tr>
                                            <td>{{ $issue_item->item_name }}</td>
											<td>{{ $issue_item->unit_name }}</td>
											<td>{{ $issue_item->opening_stock }}</td>
											<td>{{ $issue_item->indent_required_qty }}</td>
											<td>{{ $issue_item->issue_qty }}</td>
											<td>{{ $issue_item->issue_date }}</td>
											<td><a class="btn btn-round btn-info" href='{{url("procurement/inventory/view-issue-register-item/$issue_item->indent_no")}}'><i class="ti-eye" style="color: #fff;" aria-hidden="true"></i></a></td>
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
