@extends('attendance.layouts.master')

@section('title')
Attendance Information System
@endsection

@section('sidebar')
	@include('attendance.partials.sidebar')
@endsection

@section('header')
	@include('attendance.partials.header')
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
            <h5 class="card-title">Attendance Report</h5>
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Attendence Management</a></li>
                                <li>/</li>
                                <!-- <li><a href="#">View Monthly Co.Operative Deduction</a></li>
								<li>/</li> -->
                                <li class="active">Attendance Report</li>
                            </ul>
                        </span>
</div>
</div>
		<!-- Widgets  -->
		<div class="row">
			<div class="main-card">
				<div class="card">
                @include('include.messages')

					@if ($errors->has('month_yr.*'))
			<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em ><i class="fa fa-warning"></i> {{ $errors->first('month_yr.*') }}</em></div>
			@endif
					<!-- @include('include.messages') -->
					<div class="card-body card-block">
						<form action="{{url('attendance/report-monthly-attendance')}}" method="post" enctype="multipart/form-data" style="width:50%;margin:0 auto;padding: 18px 20px 1px;background: #ecebeb;">
							{{ csrf_field() }}
							<div class="row form-group">
								<div class="col-md-3">
									<label for="text-input" class=" form-control-label" style="text-align:right;">Select Month</label>
								</div>
								<div class="col-md-6">
                                <select data-placeholder="Choose an Month..." class="form-control" name="month_yr" id="month_yr" required>
										<option value="" selected disabled> Select </option>
										<?php foreach ($monthlist as $month) {?>
											@if($month->month_yr!='')
											<option value="<?php echo $month->month_yr; ?>" @if(isset($month_yr_new) && $month_yr_new==$month->month_yr) selected @endif ><?php echo $month->month_yr; ?></option>
											@endif
										<?php }?>
									</select>

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
                <div style="display:inline-flex;float:right;">
						<form  method="post" action="{{ url('attendance/xls-export-attendance-report') }}" enctype="multipart/form-data" >
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="month_yr" value="{{ $req_month }}">
                            <button data-toggle="tooltip" data-placement="bottom" title="Download Excel" class="btn btn-default" style="background:none !important;" type="submit"><img  style="width: 35px;" src="{{ asset('img/excel-dnld.png')}}"></button>
                        </form>
												
                    </div>
                    <div class="clearfix"></div>
				<div class="card">
                    
					<!----------------view----------------->
					<!-- <div class="card-header">
						<strong class="card-title">Payroll Generation for All Employee</strong>
					</div> -->
					<div class="card-body card-block">
						<div class="payroll-table table-responsive" style="margin:0 auto;overflow-x:scroll;">
                            <table id="bootstrap-data-table" class="table table-striped table-bordered" style="width:100%">
                                <thead style="text-align:center;vertical-align:middle;">
                                    <tr>
                                        <th style="width:6%;">Sl. No.</th>
                                        <th style="width:10%;">Employee Id</th>
                                        <th style="width:10%;">Employee Code</th>
                                        <th style="width:12%;">Employee Name</th>
                                        
                                        <th style="width:10%;">Month</th>
                                        <th >Days In Month</th>
                                        <th >No. of Present Days</th>
                                        <th >No. of Leave Taken</th>
                                        <th >No. of Absent Days</th>
                                        <th >No. of Salary Days</th>
                                        <th >No. of Salary Adjustment Days</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php print_r($result);?>
                                </tbody>

                                <!-- <tfoot>
                                    <tr>
                                        <td colspan="11" style="border:none;">
                                            <button type="button" class="btn btn-danger btn-sm checkall" style="margin-right:2%;">Check All</button>
                                            <button type="submit" name="btnSubmit" class="btn btn-danger btn-sm" onclick="map_controls();">Save</button>
                                            <button type="reset" class="btn btn-danger btn-sm"> Reset</button>
                                            <div style="float:right;">
                                            <button type="submit" name="btnDelete" class="btn btn-danger btn-sm" style="background-color:red" onclick="confirmDelete(event);">Delete All Records for the month</button></div>
                                        </td>

                                    </tr>
                                </tfoot> -->


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

</script>
@endsection