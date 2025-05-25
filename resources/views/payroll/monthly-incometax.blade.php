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
            <h5 class="card-title">Monthly Income Tax Deduction</h5>
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Payroll Master</a></li>
                                <li>/</li>

                                <li class="active">Monthly Income Tax Deduction</li>
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
                            <a href="{{url('payroll/add-montly-itax-all')}}" class="btn btn-default">Generate Monthly Income Tax Deduction <i class="fa fa-plus"></i></a>
                        </div>
                        @include('include.messages')
                    </div>

					<div class="card-body card-block">
						<form action="{{url('payroll/vw-montly-itax')}}" method="post" enctype="multipart/form-data" style="width:50%;margin:0 auto;padding: 18px 20px 1px;background: #ecebeb;">
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
						<div class="payroll-table table-responsive" style="width:1190px;margin:0 auto;overflow-x:scroll;">
							<form action="{{url('payroll/update-itax-all')}}" method="post" id="myForm">
                            {{csrf_field()}}
                            <input type="hidden" id="cboxes" name="cboxes" class="cboxes" value="" />
							<input type="hidden" id="statusme" name="statusme" class="statusme" value="" />
                            <input type="hidden" id="deleteme" name="deleteme" class="deleteme" value="" />
                            <input type="hidden" id="deletemy" name="deletemy" class="deletemy" value="@if(isset($req_month)){{$req_month}} @endif" />
                            <input type="hidden" id="sm_emp_code_ctrl" name="sm_emp_code_ctrl" class="sm_emp_code_ctrl" value="" />
                            <input type="hidden" id="sm_emp_name_ctrl" name="sm_emp_name_ctrl" class="sm_emp_name_ctrl" value="" />
                            <input type="hidden" id="sm_emp_designation_ctrl" name="sm_emp_designation_ctrl" class="sm_emp_designation_ctrl" value="" />
                            <input type="hidden" id="sm_month_yr_ctrl" name="sm_month_yr_ctrl" class="sm_month_yr_ctrl" value="" />

                            <input type="hidden" id="sm_d_itax_ctrl" name="sm_d_itax_ctrl" class="sm_d_itax_ctrl" value="" />
								<table id="bootstrap-data-table" class="table table-striped table-bordered">
									<thead style="text-align:center;vertical-align:middle;">
										<tr>
											<th style="width:8%;">Sl. No.</th>
											<th style="width:12%;">Employee Id</th>
											<th style="width:12%;">Employee Code</th>
											<th style="width:20%;">Employee Name</th>
											<th style="width:20%;">Designation</th>
											<th style="width:10%;">Month</th>
											<th >Income Tax Deduction</th>
										</tr>
									</thead>

									<tbody>
										<?php print_r($result);?>
									</tbody>

									<tfoot>
										<tr>
											<td colspan="6" style="border:none;">
											<div class="row">
												<div class="col-md-4">
													<button type="button" class="btn btn-danger btn-sm checkall" style="margin-right:2%;">Check All</button>
													<button type="submit" class="btn btn-danger btn-sm" onclick="map_controls();">Save</button>
													<button type="reset" class="btn btn-danger btn-sm"> Reset</button>
												</div>
												<div class="col-md-4">
													<select class="form-control" name="status" id="status" >
														<option value="">Select Status</option>
														<option value="process" selected>Pending</option>
														<option value="approved">Approved</option>
													</select>

												</div>
												<div class="col-md-4">
													<button type="submit" name="btnDelete" class="btn btn-danger btn-sm" style="background-color:red;float:right;" onclick="confirmDelete(event);">Delete All Records for the month</button>
												</div>
											</div>
												

                                            
											</td>
											<td><div class="total_itax" style="font-weight:700;"></div></td>
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



    var cb44 = $('.sm_d_itax').map(function() {return this.value;}).get().join(',');
    $('#sm_d_itax_ctrl').val(cb44);
	
	$('#statusme').val($('#status').val());


}

function confirmDelete(e){
    e.preventDefault();
    if (confirm("Do you want to delete all the generated records for the month?") == true) {
    //text = "You pressed OK!";
        $('#deleteme').val('yes');
        $('#myForm').submit();
    }
}

$(document).on("keyup", ".sm_d_itax", function() {
	doSumITax();
			
});

$(document).ready(function(){
	$("#bootstrap-data-table").dataTable().fnDestroy();
	$('#bootstrap-data-table').DataTable({
		lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
		initComplete: function(settings, json) {
			doSumITax();
		}
	});
});
function doSumITax() {
    var table = $('#bootstrap-data-table').DataTable();
    var nodes = table.column(6).nodes();
    var total = table.column(6 ).nodes()
      .reduce( function ( sum, node ) {
        return sum + parseFloat($( node ).find( 'input' ).val());
      }, 0 );
   	$(".total_itax").html(total);
}

</script>
@endsection