@extends('procurement.indent.layouts.master')

@section('title')
Payroll Information System-Company
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

@section('content')
<style>
    .aply-lv a {
    background: #1c9ac5;
    color: #fff;
    padding: 6px 24px;
    font-size: 14px;
    }

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
        <!-- Content -->
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
                <!-- Widgets  -->
                <div class="row">

                    <div class="main-card">

                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title" style="font-size:21px; font-weight: 100;"><img src="{{asset('images/product.png')}}" alt="">Indent</strong>
                            </div>
							<div class="aply-lv" style="padding-right: 36px;">
								<a href="{{ url('procurement/indent/add-new-indent-item') }}" class="btn btn-default">Add Indent<i class="fa fa-plus"></i></a>
							</div>
                            <div class="card-body">

							<div class="srch-rslt" style="overflow-x:scroll;">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
											<th>Sl. No.</th>
                                            <th>Indent No.</th>
											<th>Department</th>
											<th>Indent Made by</th>
											<th>Indent Date</th>
                                            <th>Required Date</th>
                                            <th>Status</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									@foreach($indent_item_rs as $indent_item)

                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $indent_item->indent_no }}</td>
											<td>{{ $indent_item->department_name }}</td>
											<td>{{ $indent_item->emp_fname }} {{ $indent_item->emp_mname }} {{ $indent_item->emp_lname }}</td>
											<td>{{ \Carbon\Carbon::parse($indent_item->indent_date)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($indent_item->required_date)->format('d/m/Y') }}</td>
                                            <td>{{ ucfirst($indent_item->status) }}</td>
											<td>
                                                @if($indent_item->status == 'approved')
                                                <a class="btn btn-round btn-info" href='{{url("procurement/indent/view-indent-item-report/$indent_item->indent_no")}}'><i class="ti-eye" style="color: #fff;" aria-hidden="true"></i></a>
                                                @elseif($indent_item->status == 'rejected' || $indent_item->status == 'close')
                                                <i class="fa fa-pencil-square-o" style="color: #7d7d5a;"></i>
                                                @else
                                                <a class="btn btn-round btn-info" href='{{url("procurement/indent/add-new-indent-item/$indent_item->indent_no")}}'><i class="fa fa-pencil-square-o" style="color: #fff;" aria-hidden="true"></i></a>
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
