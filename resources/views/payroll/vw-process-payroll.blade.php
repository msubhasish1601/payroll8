@extends('payroll.layouts.master')

@section('title')
Payroll Information System-Payroll Generation
@endsection

@section('sidebar')
@include('payroll.partials.sidebar')
@endsection

@section('header')
@include('payroll.partials.header')
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
            <h5 class="card-title">Process Employee Payroll</h5>
</div>
<div class="col-md-6">

<span class="right-brd" style="padding-right:15x;">
<ul class="">
	<li><a href="#">Payroll Master</a></li>
	<li>/</li>
	<li class="active">Process Employee Payroll</li>

</ul>
</span>
</div>
</div>
		<!-- Widgets  -->
		<div class="row">

			<div class="main-card" style="width:1200px;margin:0 auto;">
				<div class="card">
					<!-- <div class="card-header"><strong class="card-title">Process Employee Payroll</strong></div> -->
					<!-- @if(Session::has('message'))
					<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok"></span><em> {{ Session::get('message') }}</em></div>
					@endif -->
					@include('include.messages')
					@if ($errors->has('employee_code'))
					<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok"></span><em> {{ $errors->first('employee_code') }}</em></div>
					@endif
					<div class="card-body card-block">

						<form action="{{ url('payroll/vw-process-payroll') }}" method="post" enctype="multipart/form-data" class="form-horizontal" >
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="row form-group" style="width:60%;margin:0 auto;">

								<div class="col col-md-3" style="text-align: right;">
									<label for="text-input" class=" form-control-label">Select Month <span>(*)</span></label>
								</div>
								<div class="col-md-5">
									<select data-placeholder="Choose an Month..." class="form-control" name="month_yr" id="month_yr" required>
										<option value="" selected disabled> Select </option>
										<?php foreach ($monthlist as $month) {?>
											<option value="<?php echo $month->month_yr; ?>" @if(isset($month_yr) && $month->month_yr==$month_yr) selected @endif><?php echo $month->month_yr; ?></option>
										<?php }?>
									</select>
									@if ($errors->has('month_yr'))
									<div class="error" style="color:red;">{{ $errors->first('month_yr') }}</div>
									@endif
								</div>

								<div class="col-md-4">
									<button type="submit" class="btn btn-danger btn-sm">View</button>
								</div>

							</div>
						</form>

					</div>
				</div>
				@if (!empty($process_payroll))
				<div class="card">

					<div class="card-body">
						<div class="card-header">
							<strong class="card-title">Search Result</strong>
						</div>
						<br />
						<form method="post" action="{{ url('payroll/edit-process-payroll') }}"  id="myForm">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" id="deleteme" name="deleteme" class="deleteme" value="" />
                            <input type="hidden" id="deletemy" name="deletemy" class="deletemy" value="@if(isset($month_yr)){{$month_yr}} @endif" />
							<div class="srch-rslt" style="overflow-x:scroll;">
								<table id="bootstrap-data-table" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>
												<div class="checkbox">
													<label><input type="checkbox" name="all" id="all" width="30px;" height="30px;">
														Select</label>
												</div>
											</th>
											<td>Employee ID</td>
											<td>Employee Code</td>
											<td>Employee Name</td>
											<td>Month</td>
											<td>Basic Pay</td>
											  @if(count($rate_master)!=0)
												@foreach($rate_master as $rate)
											@if($rate->id <27)
													@if($rate->head_type=='earning')
												<td>{{$rate->head_name}}</td>
											@endif
												@endif
												@endforeach
												@endif
													<td>Others</td>
													@if(count($rate_master)!=0)
												@foreach($rate_master as $rate)
												@if($rate->id <27)
													@if($rate->head_type=='deduction')
												<td>{{$rate->head_name}}</td>
												@endif
												@endif
												@if($rate->id ==29)
													@if($rate->head_type=='deduction')
												<td>{{$rate->head_name}}</td>
												@endif
												@endif
												@if($rate->id ==31)
													@if($rate->head_type=='deduction')
												<td>{{$rate->head_name}}</td>
												@endif
												@endif
												@endforeach
												@endif


													<!-- <td>Inc. Tax.</td> -->
													<td>Others</td>
											<td>Gross Salary</td>
											<td>Deduction</td>
											<td>Net Salary</td>
											<td>Action</td>
										</tr>
									</thead>
									<tbody>

										<?php if (!empty($process_payroll)) {
    foreach ($process_payroll as $processpayroll) {?>
												<tr>
													<td>
														<div class="checkbox"><label><input type="checkbox" name="payroll_id[]" value="<?php echo $processpayroll->id; ?>"></label>

														</div>
													</td>

													<td>{{$processpayroll->employee_id}}</td>
													<td>{{$processpayroll->old_emp_code}}</td>
													<td>{{$processpayroll->emp_name}}</td>
													<td>{{$processpayroll->month_yr}}</td>
													<td>{{$processpayroll->emp_basic_pay}}</td>
													 <td>{{$processpayroll->emp_da}}</td>
													<td>{{$processpayroll->emp_vda}}</td>
													<td>{{$processpayroll->emp_hra}}</td>
													<td>{{$processpayroll->emp_others_alw}}</td>
													<td>{{$processpayroll->emp_tiff_alw}}</td>
													<td>{{$processpayroll->emp_conv}}</td>
													<td>{{$processpayroll->emp_medical}}</td>
													<td>{{$processpayroll->emp_misc_alw}}</td>
													<td>{{$processpayroll->emp_over_time}}</td>
													<td>{{$processpayroll->emp_bouns}}</td>
													<td>{{$processpayroll->emp_leave_inc}}</td>
													<td>{{$processpayroll->emp_hta}}</td>

													<td>{{$processpayroll->other_addition}}</td>
														<td>{{$processpayroll->emp_prof_tax}}</td>
													<td>{{$processpayroll->emp_pf}}</td>
													<td>{{$processpayroll->emp_pf_int}}</td>
													<td>{{$processpayroll->emp_apf}}</td>
													<td>{{$processpayroll->emp_i_tax}}</td>
													<td>{{$processpayroll->emp_insu_prem}}</td>
													<td>{{$processpayroll->emp_pf_loan}}</td>
													<td>{{$processpayroll->emp_esi}}</td>
													<td>{{$processpayroll->emp_adv}}</td>
														<td>{{$processpayroll->emp_hrd}}</td>
														<td>{{$processpayroll->emp_co_op}}</td>
															<td>{{$processpayroll->emp_furniture}}</td>
															<td>{{$processpayroll->emp_misc_ded}}</td>
															<td>@if($processpayroll->emp_pf_employer==null) 0 @else {{$processpayroll->emp_pf_employer}} @endif</td>
															<td>@if($processpayroll->emp_tds_ded==null) 0 @else {{$processpayroll->emp_tds_ded}} @endif</td>
													<!-- <td>{{$processpayroll->emp_income_tax}}</td> -->
													<td>{{$processpayroll->emp_others_deduction}}</td>
													<td>{{$processpayroll->emp_gross_salary}}</td>
													<td>{{$processpayroll->emp_total_deduction}}</td>
													<td>{{$processpayroll->emp_net_salary}}</td>
													<td>
														<a href='{{url("pis/payrolldelete/$processpayroll->id")}}'  onclick="return confirm('Are you sure you want to delete this?');"><i class="ti-trash"></i></a>
													</td>
												</tr>

										<?php }
}?>

									</tbody>
									<tfoot>

										<tr>
											<td colspan="7" style="border:none;"><button type="submit" class="btn btn-danger btn-sm">Save</button><button type="submit" name="btnDelete" class="btn btn-danger btn-sm" style="background-color:red;float:right;" onclick="confirmDelete(event);">Delete All Records for the month</button></td>

										</tr>
									</tfoot>
								</table>

							</div>

						</form>
					</div>
				</div>
				@endif
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

	function confirmDelete(e){
		e.preventDefault();
		if (confirm("Do you want to delete all the generated records for the month?") == true) {
		//text = "You pressed OK!";
			$('#deleteme').val('yes');
			$('#myForm').submit();
		}
	}
	/*function deleteProcessPayroll(clrt){

		alert(clrt);


	}*/
</script>

@endsection