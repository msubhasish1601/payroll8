@extends('rota.layouts.master')

@section('title')
Payroll Information System-Payroll Generation
@endsection

@section('sidebar')
@include('rota.partials.sidebar')
@endsection

@section('header')
@include('rota.partials.header')
@endsection


@section('content')
<style>
	#bootstrap-data-table th {
		vertical-align: top;
		text-align: center;
	}
</style>

<!-- Content -->
<div class="content">
	<!-- Animated -->
	<div class="animated fadeIn">
	<div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title">Duty Roster</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Time Shift Management</a></li>
                                
								<li>/</li>
                                <li class="active">Duty Roster</li>
						
                            </ul>
                        </span>
</div>
</div>

		<!-- Widgets  -->
		<div class="row">

			<div class="main-card" style="width:100%;margin:0 auto;">
				<div class="card">
					<!-- <div class="card-header"><strong class="card-title">Duty Roster</strong></div> -->
					<!-- @if(Session::has('message'))
					<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok"></span><em> {{ Session::get('message') }}</em></div>
					@endif -->
					@include('include.messages')
					@if ($errors->has('employee_code'))
					<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok"></span><em> {{ $errors->first('employee_code') }}</em></div>
					@endif
					<div class="card-body card-block">

						<form action="{{ url('rota/add-duty-roster') }}" method="post" enctype="multipart/form-data" class="form-horizontal" >
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="row form-group">

								<!-- <div class="col col-md-3">
									<label for="text-input" class=" form-control-label">Select Month <span>(*)</span></label>
									<select data-placeholder="Choose an Month..." class="form-control" name="month_yr" id="month_yr" required>
										<option value="" selected disabled> Select </option>

									</select>
									@if ($errors->has('month_yr'))
									<div class="error" style="color:red;">{{ $errors->first('month_yr') }}</div>
									@endif
								</div> -->

								<div class="col-md-4">
									<label>Select Department</label>
									<select class="form-control" id="emp_code" required name="department" onchange="chngdepartment(this.value);">
										<option value="">Select</option>

										@foreach($departs as $dept)
										<option value='{{ $dept->id }}' <?php if (app('request')->input('id')) {
																			if ($shift_management->department == $dept->id) {
																				echo 'selected';
																			}
																		} ?>>{{ $dept->department_name }}</option>
										@endforeach
									</select>
								</div>

								<div class="col-md-4">
									<label>Select Designation</label>
									<select class="form-control" id="designation" required name="designation" onchange="chngdepartmentshift(this.value);">
										<option value="">Select</option>
									</select>
								</div>

								<div class="col-md-4">
									<label>Employee Code</label>
									<select class="form-control" id="employee_code" required name="employee_code">

									</select>
								</div>




							</div>
							<div class="row form-group">
								<div class="col-md-4">
									<label>From Date</label>
									<input type="date" name="start_date" value="" class="form-control" required>
								</div>

								<div class="col-md-4">
									<label>To Date</label>
									<input type="date" name="end_date" value="" class="form-control" required>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-4">
									<button type="submit" class="btn btn-danger btn-sm">View Schedule</button>
								</div>
							</div>
						</form>

					</div>


					<div class="card-body">
						<div class="card-header" style="background:none;">
							<strong class="card-title">Shift Schedule</strong>
				

						</div>
						<br />
						<div class="aply-lv" style="padding-right: 36px;">
							<a href="{{ url('rota/add-employee-duty') }}" class="btn btn-default">Add Duty Roster(Employee wise) <i class="fa fa-plus"></i></a>
							<a href="{{ url('rota/add-department-duty') }}" class="btn btn-default">Add Duty Roster(Department wise) <i class="fa fa-plus"></i></a>
						</div>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="srch-rslt" style="overflow-x:scroll;">
							<table id="bootstrap-data-table" class="table table-striped table-bordered">
								<thead>
									<tr>

										<td>Sl. No.</td>
										<th>Department</th>
										<th>Designation</th>
										<th>Employee Name</th>
										<th>Shift Code</th>
										<th>Work In Time</th>
										<th>Work Out Time</th>
										<th>Break Time From</th>
										<th>Break Time To</th>
										<th>From Date</th>
										<th>To Date</th>
									</tr>
								</thead>
								<tbody>
									<?php

									if (isset($result) && $result != '') {
										print_r($result);
									} ?>

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
<div class="clearfix"></div>
@endsection

@section('scripts')
@include('attendance.partials.scripts')

<script>
	// Listen for click on toggle checkbox for each Page
	$('#all').click(function(event) {

		if (this.checked) {
			//alert("test");
			// Iterate each checkbox
			$(':checkbox').each(function() {
				this.checked = true;
			});
		} else {
			$(':checkbox').each(function() {
				this.checked = false;
			});
		}
	});


	// Listen for click on toggle checkbox for each Page
	$('#all').click(function(event) {

		if (this.checked) {
			//alert("test");
			// Iterate each checkbox
			$(':checkbox').each(function() {
				this.checked = true;
			});
		} else {
			$(':checkbox').each(function() {
				this.checked = false;
			});
		}
	});


	/*function deleteProcessPayroll(clrt){

		alert(clrt);


	}*/
</script>
<script>
	function chngdepartment(empid) {

		$.ajax({
			type: 'GET',
			url: '{{url('rota/getEmployeedesigByshiftId')}}/'+empid,
			cache: false,
			success: function(response) {


				document.getElementById("designation").innerHTML = response;
			}
		});
	}

	function chngdepartmentshift(empid) {



		$.ajax({
			type: 'GET',
			url: '{{url('rota/getEmployeedailyattandeaneshightById')}}/'+empid,
			cache: false,
			success: function(response) {


				document.getElementById("employee_code").innerHTML = response;
			}
		});
	}
</script>
@endsection