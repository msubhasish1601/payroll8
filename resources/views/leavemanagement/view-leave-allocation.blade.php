
@extends('leavemanagement.layouts.master')

@section('title')
Leave Allocation System-Company
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

   <!-- Content -->
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
            <div class="row" style="border:none;">
            <div class="col-md-6">
            <h5 class="card-title"> Leave Allocation</h5>
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
							<li><a href="#">Leave Managemnt</a></li>
                                <li>/</li>
                                <!-- <li><a href="#">Leave Allocation</a></li> -->
                                <!-- <li>/</li> -->
                                <li class="active">Add Leave Allocation</li>

                            </ul>
                        </span>
</div>
</div>
                <!-- Widgets  -->
                <div class="row">

                    <div class="main-card" >
                        <div class="card">

							<div class="card-body">
								<div class="card-header">
                                <div class="aply-lv" style="padding-right: 18px;">
								<a href="{{ url('leave-management/save-leave-allocation') }}" class="btn btn-default" style="margin-top:10px;">Add New Leave Allocation <i class="fa fa-plus"></i></a>
							</div>
									<!-- <strong class="card-title">Leave Allocation</strong> -->
								</div>
							  @include('include.messages')
								<!-- <div class="aply-lv" style="padding-right: 18px;margin-bottom:15px;">
                                <a href="{{ url('leave-management/save-leave-allocation') }}" class="btn btn-default">Add New Leave Allocation <i class="fa fa-plus"></i></a>
							</div> -->

							<div class="srch-rslt" style="overflow-x:scroll; margin-top:10px;">
							<table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sl. No.</th>
                                            <th>Leave Type</th>
                                            <th>Employee Name & Code</th>
                                            <th>Max No. Of Leave</th>
                                            <th>Opening Balance</th>
                                            <th>Leave in Hand</th>
                                            <th>Month/Year</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    @foreach($leave_allocation as $leave_allo)
    @php
        $empname = '';
        if(isset($leave_allo->salutation) && $leave_allo->salutation != '') {
            $empname = $leave_allo->salutation . ' ';
        }
        if(isset($leave_allo->emp_fname) && $leave_allo->emp_fname != '') {
            $empname .= $leave_allo->emp_fname . ' ';
        }
        if(isset($leave_allo->emp_mname) && $leave_allo->emp_mname != '') {
            $empname .= $leave_allo->emp_mname . ' ';
        }
        if(isset($leave_allo->emp_lname) && $leave_allo->emp_lname != '') {
            $empname .= $leave_allo->emp_lname . ' ';
        }
        $empname = ucwords($empname);
    @endphp
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $leave_allo->leave_type_name }}</td>
        <td>{{ $empname }} ({{ $leave_allo->old_emp_code }})</td>
        <td>{{ $leave_allo->max_no }}</td>
        <td>{{ $leave_allo->opening_bal }}</td>
        <td>{{ $leave_allo->leave_in_hand }}</td>
        <td>{{ $leave_allo->month_yr }}</td>
        <td>
            @if($leave_allo->leave_type_name == 'EARNED LEAVE' || $leave_allo->leave_type_name == 'HALF PAY LEAVE')
                <a href="{{ url('leave-management/leave-allocation-dtl/' . $leave_allo->id) }}">
                    <i class="ti-pencil-alt"></i>
                </a>
            @endif
        </td>
    </tr>
@endforeach

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
