@extends('employee.layouts.master')

@section('title')
Employee List Class Wise
@endsection

@section('sidebar')
@include('employee.partials.sidebar')
@endsection

@section('header')
@include('employee.partials.header')
@endsection

@section('scripts')
@include('employee.partials.scripts')
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
    .card-icon form {
    padding: 10px 0;

}
</style>
<!-- Content -->
<div class="content">
	<!-- Animated -->
	<div class="animated fadeIn">
	<div class="row" style="border:none;">
            <div class="col-md-6">
            <h5 class="card-title">Employee Class Report</h5>
</div>
<div class="col-md-6">

                        <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Employee</a></li>
                                <li>/</li>

                                <li class="active">Class Report</li>
                            </ul>
                        </span>
</div>
</div>
		<!-- Widgets  -->
		<div class="row">
			<div class="main-card">
				<div class="card">
                    <div class="card-header">

                        @include('include.messages')
                    </div>

					<div class="card-body card-block">
						<form action="{{url('employees/class-export-report')}}" method="post" enctype="multipart/form-data" style="width:98%;margin:0 auto;padding: 18px 20px 1px;background: #ecebeb;">
							{{ csrf_field() }}
							<div class="row form-group">
								<div class="col-md-10">
									<label for="text-input" class=" form-control-label" style="text-align:right;">Select Employee Class</label>
                                    <div>
                                    <select data-placeholder="Choose Employee Class..." name="emp_class" id="emp_class" class="form-control select2_el" required>
                                        <option value="" > Select </option>
                                        @foreach ($monthlist as $month)
                                        <option value="<?php echo $month->id; ?>">
                                            <?php echo $month->group_name; ?>
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('month'))
                                    <div class="error" style="color:red;">{{ $errors->first('month') }}</div>
                                    @endif
                                    </div>
								</div>


								<div class="col-md-2">
                                    <br>
									<button type="submit" class="btn btn-success" style="color: #fff;background-color: #0884af;border-color: #0884af;padding: 0px 8px;height: 32px; margin:5px;">Go</button>
								</div>
							</div>
						</form>
					</div>
				</div>
                @if($result!='')
				<div class="card">
					<!----------------view----------------->
                    <div class="card-header" style="background:#fff;">
					    <div style="display:inline-flex;float:right;" class="card-icon">
                            <form  method="post" action="{{ url('loans/xls-export-loan-report') }}" enctype="multipart/form-data" >
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="month_yr" value="{{ $req_month }}">
                                <input type="hidden" name="loan_type" value="{{ $req_type }}">
                                <button data-toggle="tooltip" data-placement="bottom" title="Download Excel" class="btn btn-default" style="background:none !important;" type="submit"><img  style="width: 35px;" src="{{ asset('img/excel-dnld.png')}}"></button>
                            </form>
                            <form  method="post" action="{{ url('loans/prn-loan-report') }}" enctype="multipart/form-data" target="_blank">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="month" value="{{ $req_month }}">
                                <input type="hidden" name="loan_type" value="{{ $req_type }}">
                                <button data-toggle="tooltip" data-placement="bottom" title="Download " class="btn btn-default" style="background:none !important;" type="submit"><img  style="width: 35px;" src="{{ asset('img/print-button.jpg')}}"></button>
                            </form>
                        </div>
                    </div>
					<div class="card-body card-block">
						<div class="payroll-table table-responsive" style="width:100%;margin:0 auto;">
							@if($req_type=='PF')
								<table id="bootstrap-data-table" class="table table-striped table-bordered">
									<thead style="text-align:center;vertical-align:middle;">
										<tr>
										    <th style="width:8%;">Sl. No.</th>
											<th style="width:5%;">Employee Code</th>
											<th>Employee Name</th>
											<th style="width:5%;">Loan ID</th>
											<th style="width:5%;">PF Number</th>

											<th style="width:5%;">PF Loan Outstanding </th>
											<th style="width:5%;">PF Loan Deduction </th>
											<th style="width:5%;">PF Interest </th>
											<th style="width:5%;">Total Deduction </th>
											<th style="width:5%;">PF Loan Balance</th>
											<th style="width:5%;">Loan Adjust</th>
											<th style="width:5%;">Final PF Loan Balance</th>
										</tr>
									</thead>

									<tbody>
										<?php //print_r($result);?>
                                        @php

                                            $total_loan_amount=0;

                                            $total_balance=0;
                                            $total_installment=0;
                                            $total_pf_interest=0;
                                            $total_deduction=0;
                                            $total_loanadjust=0;

                                        @endphp

                                        @foreach ($result as $index=>$record)
                                        @php

                                            $balance=0;
                                            if($record->recoveries==null){
                                                $balance = $record->loan_amount;
                                            }else{
                                                $balance = $record->loan_amount-$record->recoveries;
                                            }

                                            $total_loan_amount=$total_loan_amount+$record->loan_amount;
                                            $total_installment=$total_installment+$record->payroll_deduction;
                                            $total_pf_interest=$total_pf_interest+$record->pf_iterest;
                                            $total_deduction=$total_deduction+$record->payroll_deduction+$record->pf_iterest;

                                            $total_balance=$total_balance+$balance;
                                            $total_loanadjust=$total_loanadjust+$record->adjust_amount;

											$pf_interest=$record->pf_iterest;

                                        @endphp

                                        <tr>
                                            <td>{{$loop->iteration}}</td>

											<td>{{$record->old_emp_code}}</td>
											<td>{{$record->salutation}} {{$record->emp_fname}} {{$record->emp_mname}} {{$record->emp_lname}}</td>
											<td>{{ucwords($record->loan_id)}}</td>
											<td>{{ucwords($record->emp_pf_no)}}</td>
											<td>{{$record->loan_amount}}</td>

											<td>{{$record->payroll_deduction}}</td>

											<td>{{$pf_interest}}</td>
											<td>{{ number_format($record->payroll_deduction+$pf_interest,2) }}</td>
											<td>{{ number_format($balance,2) }}</td>
											<td>{{ number_format($record->adjust_amount,2) }}</td>
											<td>{{ number_format($balance-$record->adjust_amount,2) }}</td>

                                        </tr>
                                        @endforeach
									</tbody>
									<tfoot>
										<tr>
											<td colspan="5" style="font-weight:700;">
											Grand Total
											</td>

											<td>
                                                <div class="total_loan_amount" style="font-weight:700;">{{number_format($total_loan_amount,2)}}</div>
                                            </td>

											<td>
                                                <div class="total_balance" style="font-weight:700;">{{number_format($total_installment,2)}}</div>
                                            </td>
											<td>
                                                <div class="total_balance" style="font-weight:700;">{{number_format($total_pf_interest,2)}}</div>
                                            </td>
											<td>
                                                <div class="total_balance" style="font-weight:700;">{{number_format($total_deduction,2)}}</div>
                                            </td>
											<td>
                                                <div class="total_balance" style="font-weight:700;">{{number_format($total_balance,2)}}</div>
                                            </td>
											<td>
                                                <div class="total_balance" style="font-weight:700;">{{number_format($total_loanadjust,2)}}</div>
                                            </td>
											<td>
                                                <div class="total_balance" style="font-weight:700;">{{number_format(($total_balance-$total_loanadjust),2)}}</div>
                                            </td>



										</tr>
									</tfoot>


								</table>
							@endif
							@if($req_type=='SA')
								<table id="bootstrap-data-table" class="table table-striped table-bordered">
									<thead style="text-align:center;vertical-align:middle;">
										<tr>
										    <th style="width:8%;">Sl. No.</th>
											<th style="width:12%;">Employee Code</th>
											<th>Employee Name</th>
											<th style="width:10%;">Loan ID</th>
											<!-- <th>Deduction</th> -->
											<th style="width:5%;">Outstanding Amount</th>
                                            <th >Deducted Amount</th>
											<th style="width:5%;">Balance Amount</th>
											<th style="width:5%;">Adjust Amount</th>
											<th style="width:5%;">Final Balance Amount</th>
										</tr>
									</thead>

									<tbody>

                                        @php

                                            $total_loan_amount=0;

                                            $total_balance=0;
                                            $total_loanadjust=0;
											$total_installment=0;

                                        @endphp

                                        @foreach ($result as $index=>$record)
                                        @php
                                            $balance=0;
                                            if($record->recoveries==null){
                                                $balance = $record->loan_amount;
                                            }else{
                                                $balance = $record->loan_amount-$record->recoveries;
                                            }

                                            $total_loan_amount=$total_loan_amount+$record->loan_amount;

                                            $total_balance=$total_balance+$balance;
											$total_installment=$total_installment+$record->payroll_deduction;
											$total_loanadjust=$total_loanadjust+$record->adjust_amount;

                                        @endphp

                                        <tr>
                                            <td>{{$loop->iteration}}</td>
											<td>{{$record->old_emp_code}}</td>
											<td>{{$record->salutation}} {{$record->emp_fname}} {{$record->emp_mname}} {{$record->emp_lname}}</td>
											<td>{{ucwords($record->loan_id)}}</td>

											<td>{{$record->loan_amount}}</td>
											<td>{{$record->payroll_deduction}}</td>
											<td>{{ number_format($balance,2) }}</td>
											<td>{{ number_format($record->adjust_amount,2) }}</td>
											<td>{{ number_format($balance-$record->adjust_amount,2) }}</td>

                                        </tr>
                                        @endforeach
									</tbody>
									<tfoot>
										<tr>
											<td colspan="4" style="font-weight:700;">
											Grand Total
											</td>

											<td>
                                                <div class="total_loan_amount" style="font-weight:700;">{{number_format($total_loan_amount,2)}}</div>
                                            </td>

											<td>
                                                <div class="total_balance" style="font-weight:700;">{{number_format($total_installment,2)}}</div>
                                            </td>
											<td>
                                                <div class="total_balance" style="font-weight:700;">{{number_format($total_balance,2)}}</div>
                                            </td>
											<td>
                                                <div class="total_balance" style="font-weight:700;">{{number_format($total_loanadjust,2)}}</div>
                                            </td>
											<td>
                                                <div class="total_balance" style="font-weight:700;">{{number_format(($total_balance-$total_loanadjust),2)}}</div>
                                            </td>



										</tr>
									</tfoot>


								</table>
							@endif
						</div>
					</div>
					<!------------------------------->

				</div>
                @endif
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
@include('loan.partials.scripts')
<script>


$(document).ready(function(){
	$("#bootstrap-data-table").dataTable().fnDestroy();
	$('#bootstrap-data-table').DataTable({
		lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
		initComplete: function(settings, json) {
			//doSumCoop();
			//doSumInsu();
			//doSumMisc();
			//cal_sum();
		}
	});
	//cal_sum();
});
function doSumCoop() {
    var table = $('#bootstrap-data-table').DataTable();
    var nodes = table.column(6).nodes();
    var total = table.column(6 ).nodes()
      .reduce( function ( sum, node ) {
        return sum + parseFloat($( node ).find( 'input' ).val());
      }, 0 );
   	$(".total_coop").html(total);
}
function doSumInsu() {
    var table = $('#bootstrap-data-table').DataTable();
    var nodes = table.column(7).nodes();
    var total = table.column(7).nodes()
      .reduce( function ( sum, node ) {
        return sum + parseFloat($( node ).find( 'input' ).val());
      }, 0 );
	$(".total_insu").html(total);
}
function doSumMisc() {
    var table = $('#bootstrap-data-table').DataTable();
    var nodes = table.column(8).nodes();
    var total = table.column(8).nodes()
      .reduce( function ( sum, node ) {
        return sum + parseFloat($( node ).find( 'input' ).val());
      }, 0 );
	$(".total_misc").html(total);
}


// function cal_sum(){
//     var sum = 0;
//     var sum_in = 0;
//     $(".sm_d_coop").each(function(){
//         sum += +$(this).val();
//     });
//     $(".total_coop").html(sum);

//     $(".sm_d_insup").each(function(){
//         sum_in += +$(this).val();
//     });
//     $(".total_insu").html(sum_in);

// }


</script>
@endsection
