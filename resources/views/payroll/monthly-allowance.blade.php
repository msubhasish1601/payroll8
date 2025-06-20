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
            <h5 class="card-title">Monthly Allowances</h5>
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Payroll Master</a></li>
                                <li>/</li>

                                <li class="active">Monthly Allowances</li>
                            </ul>
                        </span>
</div>
</div>
		<!-- Widgets  -->
		<div class="row">
			<div class="main-card">
				<div class="card">
                <div class="card-header">
                        <div class="aply-lv">
                            <a href="{{url('payroll/add-montly-allowances')}}" class="btn btn-default">Generate Monthly Allowances <i class="fa fa-plus"></i></a>
                        </div>
                        @include('include.messages')
                    </div>

					<div class="card-body card-block">
						<form action="{{url('payroll/vw-montly-allowances')}}" method="post" enctype="multipart/form-data" style="width:50%;margin:0 auto;padding: 18px 20px 1px;background: #ecebeb;">
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

					<div class="card-body card-block">
						<div class="payroll-table table-responsive" style="width:100%;margin:0 auto;overflow-x:scroll;">
							<form action="{{url('payroll/update-allowances-all')}}" method="post" id="myForm">
                            {{csrf_field()}}
							<input type="hidden" id="cboxes" name="cboxes" class="cboxes" value="" />
							<input type="hidden" id="deleteme" name="deleteme" class="deleteme" value="" />
							<input type="hidden" id="statusme" name="statusme" class="statusme" value="" />
                            <input type="hidden" id="deletemy" name="deletemy" class="deletemy" value="@if(isset($req_month)){{$req_month}} @endif" />
                                <input type="hidden" id="sm_emp_code_ctrl" name="sm_emp_code_ctrl" class="sm_emp_code_ctrl" value="" />
                                <input type="hidden" id="sm_emp_name_ctrl" name="sm_emp_name_ctrl" class="sm_emp_name_ctrl" value="" />
                                <input type="hidden" id="sm_emp_designation_ctrl" name="sm_emp_designation_ctrl" class="sm_emp_designation_ctrl" value="" />
                                <input type="hidden" id="sm_month_yr_ctrl" name="sm_month_yr_ctrl" class="sm_month_yr_ctrl" value="" />

                                <input type="hidden" id="sm_tot_wdays_ctrl" name="sm_tot_wdays_ctrl" class="sm_tot_wdays_ctrl" value="" />
                                <input type="hidden" id="sm_no_d_tiff_ctrl" name="sm_no_d_tiff_ctrl" class="sm_no_d_tiff_ctrl" value="" />
                                <input type="hidden" id="sm_no_d_conv_ctrl" name="sm_no_d_conv_ctrl" class="sm_no_d_conv_ctrl" value="" />
                                <input type="hidden" id="sm_no_d_misc_ctrl" name="sm_no_d_misc_ctrl" class="sm_no_d_misc_ctrl" value="" />

                                <input type="hidden" id="sm_et_tiffalw_ctrl" name="sm_et_tiffalw_ctrl" class="sm_et_tiffalw_ctrl" value="" />
                                <input type="hidden" id="sm_e_tiffalw_ctrl" name="sm_e_tiffalw_ctrl" class="sm_e_tiffalw_ctrl" value="" />

                                <input type="hidden" id="sm_et_convalw_ctrl" name="sm_et_convalw_ctrl" class="sm_et_convalw_ctrl" value="" />
								<input type="hidden" id="sm_e_conv_ctrl" name="sm_e_conv_ctrl" class="sm_e_conv_ctrl" value="" />

                                <input type="hidden" id="sm_et_miscalw_ctrl" name="sm_et_miscalw_ctrl" class="sm_et_miscalw_ctrl" value="" />
								<input type="hidden" id="sm_e_miscalw_ctrl" name="sm_e_miscalw_ctrl" class="sm_e_miscalw_ctrl" value="" />

								<input type="hidden" id="sm_e_extra_misc_alw_ctrl" name="sm_e_extra_misc_alw_ctrl" class="sm_e_extra_misc_alw_ctrl" value="" />

								<table id="bootstrap-data-table" class="table table-striped table-bordered">
									<thead style="text-align:center;vertical-align:middle;">
										<tr>
											<th style="width:5%;">Sl. No.</th>
											<th style="width:10%;">Employee Id</th>
											<th style="width:10%;">Employee Code</th>
											<th style="width:20%;">Employee Name</th>
											<th style="width:10%;">Month</th>
											<th style="width:18%;">No. of Days Present</th>
											<th >No. of Tiffin Alw. Days</th>
											<th style="width:5%;">Ent. Tiffin Allowance</th>
											<th style="width:5%;">Tiffin Allowance</th>
											<th >No. of Conv. Alw. Days</th>
											<th style="width:5%;">Ent. Conv. Allowance</th>
											<th style="width:5%;">Conv. Allowance</th>
											<th >No. of Mics. Alw. Days</th>
											<th style="width:5%;">Ent. Mics. Allowance</th>
											<th style="width:5%;">Mics. Allowance</th>
											<th style="width:5%;">Extra Mics. Allowance</th>
										</tr>
									</thead>

									<tbody>
										<?php print_r($result);?>
									</tbody>

									<tfoot>
										<tr>
											<td colspan="6" style="border:none;">
											<div class="row">
												<div class="col-md-5">
													<button type="button" class="btn btn-danger btn-sm checkall" style="margin-right:2%;font-size:11.5px;">Check All</button>
													<button type="submit" class="btn btn-danger btn-sm" style="font-size:11.5px;" onclick="map_controls();">Save</button>
													<button type="reset" class="btn btn-danger btn-sm" style="font-size:11.5px;"> Reset</button>
													
												</div>
												<div class="col-md-3">
													<select class="form-control" name="status" id="status" >
														<option value="">Select Status</option>
														<option value="process" selected>Pending</option>
														<option value="approved">Approved</option>
													</select>

												</div>
												<div class="col-md-4">
													<button type="submit" name="btnDelete" class="btn btn-danger btn-sm" style="background-color:red;float:right;font-size:11px;" onclick="confirmDelete(event);">Delete All Records for the month</button>
												</div>
											</div>

                                            
											</td>
											<td><div class="total_tiff_days" style="font-weight:700;"></div></td>
											<td><div class="total_ent_tiff" style="font-weight:700;"></div></td>
                                            <td><div class="total_tiff" style="font-weight:700;"></div></td>
											<td><div class="total_conv_days" style="font-weight:700;"></div></td>
											<td><div class="total_ent_conv" style="font-weight:700;"></div></td>
											<td><div class="total_conv" style="font-weight:700;"></div></td>
											<td><div class="total_mics_days" style="font-weight:700;"></div></td>
											<td><div class="total_ent_mics" style="font-weight:700;"></div></td>
											<td><div class="total_mics" style="font-weight:700;"></div></td>
											<td><div class="total_extramics" style="font-weight:700;"></div></td>
										</tr>
									</tfoot>


								</table>
							</form>
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
	var clicked = false;
    $(".checkall").on("click", function() {
    // $(".checkhour").prop("checked", !clicked);
    // clicked = !clicked;

    var ele=document.getElementsByName('empcode_check[]');
   // alert(ele.length);
    for(var i=0; i<ele.length; i++){
        if(ele[i].type=='checkbox')
            ele[i].checked=true;
    }
    map_controls();
});

function map_controls(){

var cb = $('.checkhour:checked').map(function() {return this.value;}).get().join(',');
$('#cboxes').val(cb);

var cb1 = $('.sm_emp_code').map(function() {return this.value;}).get().join(',');
$('#sm_emp_code_ctrl').val(cb1);

var cb2 = $('.sm_emp_name').map(function() {return this.value;}).get().join(',');
$('#sm_emp_name_ctrl').val(cb2);

var cb3 = $('.sm_emp_designation').map(function() {return this.value;}).get().join(',');
$('#sm_emp_designation_ctrl').val(cb3);

var cb4 = $('.sm_month_yr').map(function() {return this.value;}).get().join(',');
$('#sm_month_yr_ctrl').val(cb4);

var cb5 = $('.sm_tot_wdays').map(function() {return this.value;}).get().join(',');
$('#sm_tot_wdays_ctrl').val(cb5);

var cb6 = $('.sm_no_d_tiff').map(function() {return this.value;}).get().join(',');
$('#sm_no_d_tiff_ctrl').val(cb6);

var cb7 = $('.sm_no_d_conv').map(function() {return this.value;}).get().join(',');
$('#sm_no_d_conv_ctrl').val(cb7);

var cb8 = $('.sm_no_d_misc').map(function() {return this.value;}).get().join(',');
$('#sm_no_d_misc_ctrl').val(cb8);

var cb9 = $('.sm_et_tiffalw').map(function() {return this.value;}).get().join(',');
$('#sm_et_tiffalw_ctrl').val(cb9);

var cb10 = $('.sm_e_tiffalw').map(function() {return this.value;}).get().join(',');
$('#sm_e_tiffalw_ctrl').val(cb10);

var cb11 = $('.sm_et_convalw').map(function() {return this.value;}).get().join(',');
$('#sm_et_convalw_ctrl').val(cb11);

var cb12 = $('.sm_e_conv').map(function() {return this.value;}).get().join(',');
$('#sm_e_conv_ctrl').val(cb12);

var cb13 = $('.sm_et_miscalw').map(function() {return this.value;}).get().join(',');
$('#sm_et_miscalw_ctrl').val(cb13);

var cb14 = $('.sm_e_miscalw').map(function() {return this.value;}).get().join(',');
$('#sm_e_miscalw_ctrl').val(cb14);

var cb15 = $('.sm_e_extra_misc_alw').map(function() {return this.value;}).get().join(',');
$('#sm_e_extra_misc_alw_ctrl').val(cb15);


$('#statusme').val($('#status').val());

}

function calculate_days(empcode){

var total_wday=$('#tot_wdays_'+empcode).val();
if(total_wday=='') 
	total_wday=0;

var no_tiffin_days=$('#no_d_tiff_'+empcode).val();
if(no_tiffin_days=='') 
	no_tiffin_days=0;

var no_conv_days=$('#no_d_conv_'+empcode).val();
if(no_conv_days=='') 
	no_conv_days=0;

var no_misc_days=$('#no_d_misc_'+empcode).val();
if(no_misc_days=='') 
	no_misc_days=0;

var et_tiffin_alw=$('#et_tiffalw_'+empcode).val();
if(et_tiffin_alw=='') 
	et_tiffin_alw=0;

var et_conv_alw=$('#et_convalw_'+empcode).val();
if(et_conv_alw=='') 
	et_conv_alw=0;

var et_misc_alw=$('#et_miscalw_'+empcode).val();
if(et_misc_alw=='') 
	et_misc_alw=0;

var e_tiffalw=0;
if(total_wday>0){
	e_tiffalw = eval(et_tiffin_alw)/eval(total_wday);
	e_tiffalw = eval(e_tiffalw)*no_tiffin_days;
	e_tiffalw = Math.round(e_tiffalw * 100)/100;
}

var e_conv=0;
if(total_wday>0){
	e_conv = eval(et_conv_alw)/eval(total_wday);
	e_conv = eval(e_conv)*no_conv_days;
	e_conv = Math.round(e_conv * 100)/100;
}

var e_miscalw=0;
if(total_wday>0){
	e_miscalw = eval(et_misc_alw)/eval(total_wday);
	e_miscalw = eval(e_miscalw)*no_misc_days;
	e_miscalw = Math.round(e_miscalw * 100)/100;
}

$('#e_tiffalw_'+empcode).val(e_tiffalw);		
$('#e_conv_'+empcode).val(e_conv);		
$('#e_miscalw_'+empcode).val(e_miscalw);		




}


function confirmDelete(e){
    e.preventDefault();
    if (confirm("Do you want to delete all the generated records for the month?") == true) {
    //text = "You pressed OK!";
        $('#deleteme').val('yes');
        $('#myForm').submit();
    }
}

$(document).on("keyup", ".sm_no_d_tiff", function() {
	doSumTiffDays();
	doSumEntTiff();
	doSumTiff();
});

$(document).on("keyup", ".sm_no_d_conv", function() {
	doSumConvDays();
	doSumEntConv();
	doSumConv();
});

$(document).on("keyup", ".sm_no_d_misc", function() {
	doSumMicsDays();
	doSumEntMics();
	doSumMics();
});

$(document).on("keyup", ".sm_e_extra_misc_alw", function() {
	doSumMicsExtra();
});


$(document).ready(function(){
	$("#bootstrap-data-table").dataTable().fnDestroy();
	$('#bootstrap-data-table').DataTable({
		lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
		initComplete: function(settings, json) {
			doSumTiffDays();
			doSumEntTiff();
            doSumTiff();
            doSumConvDays();
            doSumEntConv();
            doSumConv();
            doSumMicsDays();
            doSumEntMics();
            doSumMics();
			doSumMicsExtra();
		}
	});
});

function doSumTiffDays() {
    var table = $('#bootstrap-data-table').DataTable();
    var nodes = table.column(6).nodes();
    var total = table.column(6).nodes()
      .reduce( function ( sum, node ) {
        return sum + parseFloat($( node ).find( 'input' ).val());
      }, 0 );

	  total = Math.round(total * 100)/100;
   	$(".total_tiff_days").html(total);
}

function doSumEntTiff() {
    var table = $('#bootstrap-data-table').DataTable();
    var nodes = table.column(7).nodes();
    var total = table.column(7).nodes()
      .reduce( function ( sum, node ) {
        return sum + parseFloat($( node ).find( 'input' ).val());
      }, 0 );

	  total = Math.round(total * 100)/100;
	$(".total_ent_tiff").html(total);
}

function doSumTiff() {
    var table = $('#bootstrap-data-table').DataTable();
    var nodes = table.column(8).nodes();
    var total = table.column(8).nodes()
      .reduce( function ( sum, node ) {
        return sum + parseFloat($( node ).find( 'input' ).val());
      }, 0 );

	  total = Math.round(total * 100)/100;
   	$(".total_tiff").html(total);
}

function doSumConvDays() {
    var table = $('#bootstrap-data-table').DataTable();
    var nodes = table.column(9).nodes();
    var total = table.column(9).nodes()
      .reduce( function ( sum, node ) {
        return sum + parseFloat($( node ).find( 'input' ).val());
      }, 0 );

	  total = Math.round(total * 100)/100;
	$(".total_conv_days").html(total);
}

function doSumEntConv() {
    var table = $('#bootstrap-data-table').DataTable();
    var nodes = table.column(10).nodes();
    var total = table.column(10).nodes()
      .reduce( function ( sum, node ) {
        return sum + parseFloat($( node ).find( 'input' ).val());
      }, 0 );
    
      total = Math.round(total * 100)/100;
	$(".total_ent_conv").html(total);
}

function doSumConv() {
    var table = $('#bootstrap-data-table').DataTable();
    var nodes = table.column(11).nodes();
    var total = table.column(11).nodes()
      .reduce( function ( sum, node ) {
        return sum + parseFloat($( node ).find( 'input' ).val());
      }, 0 );
    
      total = Math.round(total * 100)/100;
	$(".total_conv").html(total);
}

function doSumMicsDays() {
    var table = $('#bootstrap-data-table').DataTable();
    var nodes = table.column(12).nodes();
    var total = table.column(12).nodes()
      .reduce( function ( sum, node ) {
        return sum + parseFloat($( node ).find( 'input' ).val());
      }, 0 );
	  total = Math.round(total * 100)/100;
	$(".total_mics_days").html(total);
}

function doSumEntMics() {
    var table = $('#bootstrap-data-table').DataTable();
    var nodes = table.column(13).nodes();
    var total = table.column(13).nodes()
      .reduce( function ( sum, node ) {
        return sum + parseFloat($( node ).find( 'input' ).val());
      }, 0 );
    
      total = Math.round(total * 100)/100;
	$(".total_ent_mics").html(total);
}

function doSumMics() {
    var table = $('#bootstrap-data-table').DataTable();
    var nodes = table.column(14).nodes();
    var total = table.column(14).nodes()
      .reduce( function ( sum, node ) {
        return sum + parseFloat($( node ).find( 'input' ).val());
      }, 0 );
    
      total = Math.round(total * 100)/100;
	 // alert(total);
	$(".total_mics").html(total);
}

function doSumMicsExtra() {
    var table = $('#bootstrap-data-table').DataTable();
    var nodes = table.column(15).nodes();
    var total = table.column(15).nodes()
      .reduce( function ( sum, node ) {
        return sum + parseFloat($( node ).find( 'input' ).val());
      }, 0 );
    
      total = Math.round(total * 100)/100;
	 //alert(total);
	$(".total_extramics").html(total);
}


</script>
@endsection