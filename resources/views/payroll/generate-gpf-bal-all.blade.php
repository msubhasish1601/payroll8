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
		vertical-align: middle;
	}

	tr.spl td {
		font-weight: 600;
	}

	table#bootstrap-data-table tr td {
		font-size: 12px;
		padding: 8px 10px;
	}
</style>
<!-- Content -->
<div class="content">
	<!-- Animated -->
	<div class="animated fadeIn">
	<div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title">Opening Balance Generation for All Employee For GPF (@php print_r($month_yr) ;@endphp)</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Payroll Master</a></li>
                                <li>/</li>
                                <li class="active">Opening Balance Generation for All Employee For GPF (@php print_r($month_yr) ;@endphp)</li>
						
                            </ul>
                        </span>
</div>
</div>
		<!-- Widgets  -->
		<div class="row">
			<div class="main-card">


				<div class="card">
					<!----------------view----------------->
					<!-- <div class="card-header">
						<strong class="card-title">Opening Balance Generation for All Employee For GPF (@php print_r($month_yr) ;@endphp)</strong>
					</div> -->
					<div class="card-body card-block">
						<div class="payroll-table table-responsive" style="width:1190px;margin:0 auto;overflow-x:scroll;">
							<!-- @if(Session::has('message'))
								<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
								@endif -->
							@include('include.messages')
							<form action="{{url('post/vw-opening-bal-payroll-generation')}}" method="post">
								{{csrf_field()}}

								<input type="hidden" name="month_yr" value="@php print_r($month_yr) ;@endphp">
								<table id="bootstrap-data-table" class="table table-striped table-bordered">
									<thead style="text-align:center;vertical-align:middle;">
										<tr>

											<th rowspan="2">Employee Id</th>
											<th rowspan="2">Employee Name</th>
											<th rowspan="2">Designation</th>
											<th rowspan="2">Opening Balance</th>
										</tr>

									</thead>

									<tbody>

										@php $space=' ';

										@endphp
										@foreach ($employee_gpf as $val)

										<tr>
											<td>{{ $val['emp_code']}}<input type="hidden" class="form-control" name="emp_code[]" style="width:50px;" value="{{ $val['emp_code']}}">




											</td>
											<td>{{ $val['emp_name']}}<input type="hidden" class="form-control" name="emp_name[]" style="width:50px;" value="{{ $val['emp_name']}}"></td>
											<td>{{ $val['emp_designation']}}<input type="hidden" class="form-control" name="emp_designation[]" style="width:50px;" value="{{ $val['emp_designation']}}"></td>


											<td><input type="text" name="open_bal[]" value="{{$val['opening_balance']}}" /> </td>





										</tr>

										@endforeach
									</tbody>

									<tfoot>
										<tr>
											<td colspan="32" style="border:none;">

												<button type="submit" class="btn btn-danger btn-sm">Save</button>

											</td>
										</tr>
									</tfoot>


								</table>
							</form>
						</div>
					</div>
					<!------------------------------->

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
@include('payroll.partials.scripts')
<script>
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

	$('input[type=text]').on('blur', function() {
		var bid = this.id; // button ID 
		var trid = $(this).closest('tr').attr('id'); // table row ID 
		//alert(trid);
		var emp_gross_pay = $('#emp_total_gross_' + trid).val();
		var emp_ltc = $('#ltc_' + trid).val();
		var emp_cea = $('#cea_' + trid).val();
		var emp_travelling_allowance = $('#tra_' + trid).val();
		var emp_daily_allowance = $('#dla_' + trid).val();
		var emp_spcl_allowance = $('#spcl_allowance_' + trid).val();
		var emp_adv = $('#adv_' + trid).val();
		var emp_adjustment = $('#adjadv_' + trid).val();
		var emp_medical = $('#mr_' + trid).val();
		var other_addition = $('#other1_' + trid).val();

		var total_gross_on_blur = (parseInt(emp_gross_pay) + parseInt(emp_ltc) + parseInt(emp_cea) + parseInt(emp_travelling_allowance) + parseInt(emp_daily_allowance) + parseInt(emp_spcl_allowance) + parseInt(emp_adv) + parseInt(emp_adjustment) + parseInt(emp_medical) + parseInt(other_addition));
		var emp_gross_pay = $('#emp_total_gross_' + trid).val(total_gross_on_blur);
		var Tot_deduction = $('#emp_total_deduction_' + trid).val();
		var netsal = (parseInt(total_gross_on_blur) - parseInt(Tot_deduction));
		$('#emp_net_salary_' + trid).val(netsal);

	});


	$('input[type=text]').on('blur', function() {
		var bid = this.id;
		var trid = $(this).closest('tr').attr('id');
		var emp_nps = $('#nps_' + trid).val();
		var emp_gsli = $('#gsli_' + trid).val();
		var emp_income_tax = $('#income_tax_' + trid).val();
		var emp_tax = $('#tax_' + trid).val();
		var emp_other2 = $('#other2_' + trid).val();
		var emp_total_deduction = (parseInt(emp_nps) + parseInt(emp_gsli) + parseInt(emp_income_tax) + parseInt(emp_tax) + parseInt(emp_other2));
		$('#emp_total_deduction_' + trid).val(emp_total_deduction);
		var emp_gross_pay = $('#emp_total_gross_' + trid).val();
		var netsal = (parseInt(emp_gross_pay) - parseInt(emp_total_deduction));
		$('#emp_net_salary_' + trid).val(netsal);

	});
</script>
@endsection