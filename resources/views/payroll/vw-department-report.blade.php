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
            <h5 class="card-title">Monthly Department Summary Report</h5>
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Payroll Master</a></li>
                                <li>/</li>

                                <li class="active">Monthly Department Summary Report</li>
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
						<form action="{{url('payroll/vw-department-summary')}}" method="post" enctype="multipart/form-data" style="width:50%;margin:0 auto;padding: 18px 20px 1px;background: #ecebeb;">
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
					<div class="card-header" style="background:#fff;">
						<!-- <strong class="card-title">Department Summary</strong> -->
                        <div style="display:inline-flex;float:right;" class="card-icon">
                            <form  method="post" action="{{ url('payroll/xls-export-department-summary') }}" enctype="multipart/form-data" >
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="month_yr" value="{{ $req_month }}">
                                <button data-toggle="tooltip" data-placement="bottom" title="Download Excel" class="btn btn-default" style="background:none !important;" type="submit"><img  style="width: 35px;" src="{{ asset('img/excel-dnld.png')}}"></button>
                            </form>
                            <form  method="post" action="{{ url('payroll/prn-department-summary') }}" enctype="multipart/form-data" target="_blank">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="month" value="{{ $req_month }}">
                                <button data-toggle="tooltip" data-placement="bottom" title="Download Excel" class="btn btn-default" style="background:none !important;" type="submit"><img  style="width: 35px;" src="{{ asset('img/print-button.jpg')}}"></button>
                            </form>
                        </div>
										
					</div>
					<div class="card-body card-block">
						<div class="payroll-table table-responsive" style="width:1190px;margin:0 auto;overflow-x:scroll;">

								<table id="bootstrap-data-table" class="table table-striped table-bordered">
									<thead style="text-align:center;vertical-align:middle;">
										<tr>
										    <th style="width:5%;">Sl. No.</th>
											<th style="width:8%;">Department Name</th>
											<th style="width:12%;">Basic<br>OTH ALW<br>PF<br>PF INT</th>
											<th style="width:18%;">DA<br>MISC ALW<br>APF<br>ADV</th>
											<th style="width:15%;">VDA<br>OVER TIME<br>PROF. TAX<br>HRD</th>
											<th style="width:10%;">TIFF ALW<br>LEAVE ENC<br>INSU PREM<br>FURNITURE</th>
											<th >CONV<br>HTA<br>PF LOAN<br>MISC DED</th>
											<th >MEDICAL<br>TOT INC<br>ESI<br>TOT DED</th>
											<th >NET PAY</th>
										</tr>
									</thead>

									<tbody>
										<?php //print_r($result);?>
                                        @php
                                            $total_basic=0;
                                            $total_othalw=0;
                                            $total_pf=0;
                                            $total_pfint=0;
                                            $total_da=0;
                                            $total_miscalw=0;
                                            $total_apf=0;
                                            $total_adv=0;
                                            $total_vda=0;
                                            $total_ot=0;
                                            $total_ptax=0;
                                            $total_hrd=0;
                                            $total_tiffalw=0;
                                            $total_leave_enc=0;
                                            $total_insu_prem=0;
                                            $total_furniture=0;
                                            $total_conv=0;
                                            $total_hta=0;
                                            $total_pfloan=0;
                                            $total_misc_ded=0;
                                            $total_medical=0;
                                            $total_totinc=0;
                                            $total_esi=0;
                                            $total_ded=0;
                                            $total_netpay=0;
                                        @endphp
                                        @foreach ($result as $index=>$record)
                                        @php
                                            $total_basic=$total_basic+$record->emp_basic_pay;
                                            $total_othalw=$total_othalw+$record->emp_others_alw;
                                            $total_pf=$total_pf+$record->emp_pf;
                                            $total_pfint=$total_pfint+$record->emp_pf_int;
                                            $total_da=$total_da+$record->emp_da;
                                            $total_miscalw=$total_miscalw+$record->emp_misc_alw;
                                            $total_apf=$total_apf+$record->emp_apf;
                                            $total_adv=$total_adv+$record->emp_adv;
                                            $total_vda=$total_vda+$record->emp_vda;
                                            $total_ot=$total_ot+$record->emp_over_time;
                                            $total_ptax=$total_ptax+$record->emp_prof_tax;
                                            $total_hrd=$total_hrd+$record->emp_hrd;
                                            $total_tiffalw=$total_tiffalw+$record->emp_tiff_alw;
                                            $total_leave_enc=$total_leave_enc+$record->emp_leave_inc;
                                            $total_insu_prem=$total_insu_prem+$record->emp_insu_prem;
                                            $total_furniture=$total_furniture+$record->emp_furniture;
                                            $total_conv=$total_conv+$record->emp_conv;
                                            $total_hta=$total_hta+$record->emp_hta;
                                            $total_pfloan=$total_pfloan+$record->emp_pf_loan;
                                            $total_misc_ded=$total_misc_ded+$record->emp_misc_ded;
                                            $total_medical=$total_medical+$record->emp_medical;
                                            $total_totinc=$total_totinc+$record->emp_gross_salary;
                                            $total_esi=$total_esi+$record->emp_esi;
                                            $total_ded=$total_ded+$record->emp_total_deduction;
                                            $total_netpay=$total_netpay+$record->emp_net_salary;
                                        @endphp

                                        <tr>
                                            <td>{{$loop->iteration}}</td>
											<td>{{$record->emp_department}}</td>
											<td>{{$record->emp_basic_pay}}<br>{{$record->emp_others_alw}}<br>{{$record->emp_pf}}<br>{{$record->emp_pf_int}}</td>
											<td>{{$record->emp_da}}<br>{{$record->emp_misc_alw}}<br>{{$record->emp_apf}}<br>{{$record->emp_adv}}</td>
											<td>{{$record->emp_vda}}<br>{{$record->emp_over_time}}<br>{{$record->emp_prof_tax}}<br>{{$record->emp_hrd}}</td>
											<td>{{$record->emp_tiff_alw}}<br>{{$record->emp_leave_inc}}<br>{{$record->emp_insu_prem}}<br>{{$record->emp_furniture}}</td>
											<td>{{$record->emp_conv}}<br>{{$record->emp_hta}}<br>{{$record->emp_pf_loan}}<br>{{$record->emp_misc_ded}}</td>
											<td>{{$record->emp_medical}}<br>{{$record->emp_gross_salary}}<br>{{$record->emp_esi}}<br>{{$record->emp_total_deduction}}</td>
											<td>{{$record->emp_net_salary}}</td>
                                        </tr>
                                        @endforeach
									</tbody>
									<tfoot>
										<tr>
											<td colspan="2" style="border:none;font-weight:700;">
											Grand Total
											</td>
											<td>
                                                <div class="total_basic" style="font-weight:700;">{{$total_basic}}</div>
                                                <div class="total_othalw" style="font-weight:700;">{{$total_othalw}}</div>
                                                <div class="total_pf" style="font-weight:700;">{{$total_pf}}</div>
                                                <div class="total_pfint" style="font-weight:700;">{{$total_pfint}}</div>
                                            </td>
											<td>
                                                <div class="total_da" style="font-weight:700;">{{$total_da}}</div>
                                                <div class="total_miscalw" style="font-weight:700;">{{$total_miscalw}}</div>
                                                <div class="total_apf" style="font-weight:700;">{{$total_apf}}</div>
                                                <div class="total_adv" style="font-weight:700;">{{$total_adv}}</div>
                                            </td>
											<td>
                                                <div class="total_vda" style="font-weight:700;">{{$total_vda}}</div>
                                                <div class="total_ot" style="font-weight:700;">{{$total_ot}}</div>
                                                <div class="total_ptax" style="font-weight:700;">{{$total_ptax}}</div>
                                                <div class="total_hrd" style="font-weight:700;">{{$total_hrd}}</div>
                                            </td>
											<td>
                                                <div class="total_tiffalw" style="font-weight:700;">{{$total_tiffalw}}</div>
                                                <div class="total_leave_enc" style="font-weight:700;">{{$total_leave_enc}}</div>
                                                <div class="total_insu_prem" style="font-weight:700;">{{$total_insu_prem}}</div>
                                                <div class="total_furniture" style="font-weight:700;">{{$total_furniture}}</div>
                                            </td>
											<td>
                                                <div class="total_conv" style="font-weight:700;">{{$total_conv}}</div>
                                                <div class="total_hta" style="font-weight:700;">{{$total_hta}}</div>
                                                <div class="total_pfloan" style="font-weight:700;">{{$total_pfloan}}</div>
                                                <div class="total_misc_ded" style="font-weight:700;">{{$total_misc_ded}}</div>
                                            </td>
											<td>
                                                <div class="total_medical" style="font-weight:700;">{{$total_medical}}</div>
                                                <div class="total_totinc" style="font-weight:700;">{{$total_totinc}}</div>
                                                <div class="total_esi" style="font-weight:700;">{{$total_esi}}</div>
                                                <div class="total_ded" style="font-weight:700;">{{$total_ded}}</div>
                                            </td>
											<td>
                                                <div class="total_netpay" style="font-weight:700;">{{$total_netpay}}</div>
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