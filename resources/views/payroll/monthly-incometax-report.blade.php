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
            <h5 class="card-title">Monthly Income Tax Entry Report</h5>
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Payroll Master</a></li>
                                <li>/</li>

                                <li class="active">Monthly Income Tax Entry Report</li>
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
						<form action="{{url('payroll/monthly-incometax-entry-report')}}" method="post" enctype="multipart/form-data" style="width:50%;margin:0 auto;padding: 18px 20px 1px;background: #ecebeb;">
							{{ csrf_field() }}
							<div class="row form-group">
								<div class="col-md-3">
									<label for="text-input" class=" form-control-label" style="text-align:right;">Select Month</label>
								</div>
								<div class="col-md-6">
                                    <select data-placeholder="Choose Month..." name="month" id="month" class="form-control" required>
                                        <option value="" selected disabled > Select </option>
                                        @foreach ($monthlist as $month)
                                        <option value="<?php echo $month->month_yr; ?>" @if(isset($req_month) && $req_month==$month->month_yr) selected @endif><?php echo $month->month_yr; ?></option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('month'))
                                    <div class="error" style="color:red;">{{ $errors->first('month') }}</div>
                                    @endif
								</div>

								<div class="col-md-3">
									<button type="submit" class="btn btn-success" style="color: #fff;background-color: #0884af;border-color: #0884af;padding: 0px 8px;
					height: 32px;">Go</button>
								</div>
							</div>
						</form>
					</div>
				</div>
                @if($result!='')
				<div class="card">
					<!----------------view----------------->
					<div class="card-header">
						<!-- <strong class="card-title">Department Summary</strong> -->
                       
										<form  method="post" action="{{ url('payroll/xls-export-monthly-incometax-entry-report') }}" enctype="multipart/form-data" >
											<input type="hidden" name="_token" value="{{ csrf_token() }}">
											<input type="hidden" name="month_yr" value="{{ $req_month }}">
											<button data-toggle="tooltip" data-placement="bottom" title="Download Excel" class="btn btn-default" style="background:none !important;padding: 10px 15px;margin-top: -30px;float:right;margin-right: 15px;" type="submit"><img  style="width: 35px;" src="{{ asset('img/excel-dnld.png')}}"></button>
												</form>

										
					</div>
					<div class="card-body card-block">
						<div class="payroll-table table-responsive" style="width:100%;margin:0 auto;">

								<table id="bootstrap-data-table" class="table table-striped table-bordered">
									<thead style="text-align:center;vertical-align:middle;">
										<tr>
										    <th style="width:8%;">Sl. No.</th>
											<th style="width:12%;">Employee Code</th>
											<th>Employee Name</th>
											
											<th style="width:10%;">Status</th>
											<th style="width:15%;">Income Tax Deduction</th>
											
											
											
										</tr>
									</thead>

									<tbody>
										<?php //print_r($result);?>
                                        @php
                                            
                                            $total_itax_amount=0;
                                           
                                           
                                        @endphp
                                        @foreach ($result as $index=>$record)
                                        @php
                                            
                                            
                                            $total_itax_amount=$total_itax_amount+$record->itax_amount;
                                            
                                            

                                        @endphp

                                        <tr>
                                            <td>{{$loop->iteration}}</td>
											<td>{{$record->old_emp_code}}</td>
											<td>{{$record->salutation}} {{$record->emp_fname}} {{$record->emp_mname}} {{$record->emp_lname}}</td>
											<td>{{ucwords($record->status)}}</td>
											<td>{{$record->itax_amount}}</td>
											
											
											
											
                                        </tr>
                                        @endforeach
									</tbody>
									<tfoot>
										<tr>
											<td colspan="4" style="font-weight:700;">
											Grand Total
											</td>
											
											<td>
                                                <div class="total_insu_prem" style="font-weight:700;">{{$total_itax_amount}}</div>
                                            </td>
											
											
                                            
										</tr>
									</tfoot>


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
@include('payroll.partials.scripts')
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