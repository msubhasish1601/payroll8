
@extends('leavemanagement.layouts.master')

@section('title')
Leave Type System-Company
@endsection

@section('sidebar')
	@include('leavemanagement.partials.sidebar')
@endsection

@section('header')
	@include('leavemanagement.partials.header')
@endsection

@section('scripts')
	@include('leavemanagement.partials.scripts')
@endsection

@section('content')

 <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
            <div class="row" style="border:none; margin-top:80px;">
            <div class="col-md-6">
            <h5 class="card-title">New Leave Type</h5>
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
							<li><a href="#">Leave Management</a></li>
                                <li>/</li>
                                <!-- <li><a href="#">Employee Master</a></li>
                                <li>/</li> -->
                                <li class="active">New Leave Type</li>

                            </ul>
                        </span>
</div>
</div>
                <!-- Widgets  -->
                <div class="row">

                    <div class="main-card" >
                        <div class="card">

                            <!-- Displaying success message -->

							<div class="card-body">
								<div class="card-header">
                                <div class="aply-lv" style="">
								<a href="{{url('leave-management/new-leave-type')}}" class="btn btn-default" style="margin-top: 10px;">Manage New Leave Type <i class="fa fa-plus"></i></a>
							</div>
								</div>
								   @include('include.messages')


							<div class="srch-rslt" style="overflow-x:scroll;margin-top: 20px;">
							<table id="bootstrap-data-table" class="table table-striped table-bordered" style="">
                                    <thead>
                                        <tr>
                                            <th>Sl. No.</th>
                                            <th>Leave Type</th>
											<th>Alias Name</th>
											<th>Remarks</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($leave_type_rs as $l)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$l->leave_type_name}}</td>
											<td>{{$l->alies}}</td>
											<td>{{$l->remarks}}</td>
											<td style="text-align:center;">
                                            <a href="{{url('leave-management/leave-type-listing/'.$l->id)}}"><i class="fa fa-edit"></i></a>
                                            <!-- <a href="{{url('attendance/leave/del/'.$l->id)}}"><i class="fa fa-trash"></i></a> -->
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
