@extends('loan.layouts.master')

@section('title')
Adjustment - Loan Report
@endsection

@section('sidebar')
@include('loan.partials.sidebar')
@endsection

@section('header')
@include('loan.partials.header')
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
            <h5 class="card-title">Adjustment Report</h5>
</div>
<div class="col-md-6">

    <span class="right-brd" style="padding-right:15x;">
        <ul class="">
            <li><a href="#">Loans</a></li>
            <li>/</li>

            <li class="active">Adjustment Report</li>
        </ul>
    </span>
</div>
</div>
		<!-- Widgets  -->
		<div class="row">
			<div class="main-card">


                        @include('include.messages')

                @if($result!='')
				<div class="card">
					<!----------------view----------------->
                    <div class="card-header" style="background:#fff;">
					    <div style="display:inline-flex;float:right;" class="card-icon">
                            <form  method="post" action="{{ url('loans/xls-export-adjustment-report') }}" enctype="multipart/form-data" >
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button data-toggle="tooltip" data-placement="bottom" title="Download Excel" class="btn btn-default" style="background:none !important;" type="submit">
                                    <img  style="width: 35px;" src="{{ asset('img/excel-dnld.png')}}"></button>
                            </form>

                        </div>
                    </div>
					<div class="card-body card-block">
						<div class="payroll-table table-responsive" style="width:100%;margin:0 auto;">

								<table id="bootstrap-data-table" class="table table-striped table-bordered">
									<thead style="text-align:center;vertical-align:middle;">
										<tr>
										    <th style="width:8%;">Sl. No.</th>
											<th style="width:200.4px;">Employee ID</th>
                                            <th style="width:200.4px;">Employee Code</th>
											<th>Employee Name</th>
											<th style="width:5%;">Designation</th>
                                            <th>Loan type</th>
											<th style="width:5%;"> Loan start month </th>
											<th style="width:5%;"> Loan Amount </th>
                                            <th style="width:5%;"> Adjustment Amount </th>
											<th style="width:5%;"> Installment </th>
											<th style="width:5%;"> Deduction </th>
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

											<td>{{$record->emp_code}}</td>
                                            <td>{{$record->old_emp_code}}</td>
											<td>{{$record->salutation}} {{$record->emp_fname}} {{$record->emp_mname}} {{$record->emp_lname}}</td>

											<td>{{ucwords($record->emp_designation??'N/A')}}</td>
                                            <td>{{$record->loan_type}}</td>
											<td>{{ date('m/Y',strtotime($record->start_month??'N/A')) }}</td>

											<td>{{$record->loan_amount??'N/A'}}</td>
                                            <td>{{$record->adjust_amount??'N/A'}}</td>

											<td>{{$record->installment_amount??'N/A'}}</td>
											<td>
                                                @if ($record->deduction == 'Y')
                                                    Yes
                                                @else
                                                   No
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
									</tbody>

								</table>


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
