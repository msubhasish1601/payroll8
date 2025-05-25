@extends('procurement.indent.layouts.master')

@section('title')
Purchase Request
@endsection

@section('sidebar')
	@include('procurement.indent.partials.sidebar')
@endsection

@section('header')
	@include('procurement.indent.partials.header')
@endsection



@section('scripts')
	@include('procurement.indent.partials.scripts')
@endsection

<style>
.btn-round {
    border-radius: 50% !important;
    width: 35px !important;
    height: 35px !important;
    padding: 6px 10px !important;
}
.btn-danger {
	background: #d86a09 !important;
	border: none !important;
}
.btn-approve {
    background: #4ea006 !important;
    padding: 4px 7px !important;
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
                            <div class="card-header" style="font-weight: 100; font-size: 21px !important;">
                                <strong class="card-title"><img src="{{asset('images/requisition.png')}}" alt="" style="width:30px;">Purchase request </strong>
                            </div>
							@if(Session::has('message'))
								<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
							@endif
							<div class="aply-lv" style="padding-right: 36px;">
								<a href="{{ url('procurement/indent/add-new-requisition-item') }}" class="btn btn-default" style="background: #1c9ac5; color: #fff; padding: 6px 24px;font-size: 14px;">Add Purchase Request <i class="fa fa-plus"></i></a>
							</div>
                            <div class="card-body">

							<div class="srch-rslt" style="overflow-x:scroll;">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
											<th>Purchase Request No.</th>
											<th>Request Made by</th>
											<th>Required Date</th>
											<th>Status</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									@foreach($req_item_rs as $req_item)

                                        <tr>
                                            <td>{{ $req_item->requisition_no }}</td>
											<td>{{ $req_item->emp_fname }} {{ $req_item->emp_mname }} {{ $req_item->emp_lname }}</td>
											<td>{{ $req_item->required_date }}</td>
											<td>{{ $req_item->status }}</td>
											<td>
												@if($req_item->status == 'Not Approved')
												<a class="btn btn-round btn-info" title="Edit" href='{{url("procurement/indent/edit-request/$req_item->requisition_no")}}'><i class="fa fa-pencil-square-o" aria-hidden="true" style="color: #fff;"></i></a>
												<a class="btn btn-round btn-danger" title="Delete" href="#"><i class="fa fa-trash" aria-hidden="true" style="color: #fff;"></i></a>
												<a class="btn btn-round btn-approve" title="Approve" href="{{url('procurement/indent/edit-item-status')}}/{{ $req_item->requisition_no }}" title="Approve"><i class="fa fa-thumbs-up" aria-hidden="true" style="color: #fff;"></i></a>
                                                    <a href='{{url("procurement/indent/view-requisition-item/$req_item->requisition_no")}}' class="btn btn-round btn-info"><i class="fa fa-eye" style="color: #fff;" aria-hidden="true"></i></a>
												@else
												<i class="fa fa-pencil-square-o" aria-hidden="true" style="color: #7d7d5a;"></i></a>
												<i class="fa fa-trash" aria-hidden="true" style="color: #7d7d5a;"></i></a>
                                                    <a href='{{url("procurement/indent/view-requisition-item/$req_item->requisition_no")}}' class="btn btn-round btn-info"><i class="fa fa-eye" style="color: #fff;" aria-hidden="true"></i></a>
												@endif
											</td>
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
