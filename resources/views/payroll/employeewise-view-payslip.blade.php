@extends('payroll.layouts.master')

@section('title')
Payroll Information System
@endsection

@section('sidebar')
	@include('payroll.partials.sidebar')
@endsection

@section('header')
	@include('payroll.partials.header')
@endsection



@section('content')
  <!-- Content -->
  <div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
    <div class="row" style="border:none;">
            <div class="col-md-6">
            <h5 class="card-title">Employee Wise Payslip</h5>
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Report Module</a></li>
                                <li>/</li>
                                <li class="active">Employee Wise Payslip</li>

                            </ul>
                        </span>
</div>
</div>

      <!-- Widgets  -->
      <div class="row">
        <div class="main-card">
          <div class="card">
            <!-- <div class="card-header"> <strong>Employeewise Payslip</strong> </div> -->
			@include('include.messages')
            <div class="card-body card-block">
              <form action="{{ url('payroll/vw-employeewise-view-payslip') }}" method="post">
			  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row form-group">
		<div class="col-md-5">
                     <label for="text-input" class=" form-control-label">Select Month <span>(*)</span></label>
						<select data-placeholder="Choose an Month..."  class="form-control" name="month_yr" id="month_yr" required>
								<option value="" selected disabled > Select </option>
											<?php foreach ($monthlist as $month) {?>
								<option value="<?php echo $month->month_yr; ?>"><?php echo $month->month_yr; ?></option>
							<?php }?>
										</select>
                     @if ($errors->has('month_yr'))
						<div class="error" style="color:red;">{{ $errors->first('month_yr') }}</div>
					@endif
                                        </div>
                  <div class="col-md-4">
                    <label class=" form-control-label">Enter Employee Id <span>(*)</span></label>
                    <select data-placeholder="Choose Employee..." name="emp_code" class="form-control select2_el" required>
							<option value="" selected disabled > Select </option>
							<?php foreach ($employeeslist as $employee) {?>
							<option value="<?php echo $employee->emp_code; ?>" @if(isset($emp_id_new) && $emp_id_new==$employee->emp_code) selected @endif><?php echo $employee->emp_fname . " " . $employee->emp_mname . " " . $employee->emp_lname . " (" . $employee->old_emp_code . ") "; ?></option>
							<?php }?>
                        </select>


					@if ($errors->has('emp_code'))
						<div class="error" style="color:red;">{{ $errors->first('emp_code') }}</div>
					@endif
                  </div>

                  <div class="col-md-4 btn-up">
                    <button type="submit" class="btn btn-danger btn-sm">View </button>
                  </div>
                </div>


              </form>
            </div>
          </div>

         <h5 class="card-title">View Payslip</h5>  <br>
          <div class="card">

            <br/>
            <div class="clear-fix">
      			<div class="card-body card-block">
      			<div class="table-responsive">
              <table id="bootstrap-data-table" class="table table-striped table-bordered">
                <thead style="text-align:center;vertical-align: middle;">
                  <tr style="font-size:11px;text-align:center">
          				  <th>Employee Code</th>
          				  <th>Employee Name</th>
          				  <th>Designation</th>
          				  <th>Month</th>
                    <th>Gross Salary</th>
                    <th>Total Deductions</th>
                    <th>Net Salary</th>
          				  <th>View</th>
                  </tr>
                </thead>
                <tbody>
        					<?php print_r($result);?>
        				</tbody>
              </table>
      			</div>
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
   @endsection
   @section('scripts')
	@include('payroll.partials.scripts')
	<script src="{{ asset('js/select2.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        initailizeSelect2();
    });
    // Initialize select2
    function initailizeSelect2() {

        $(".select2_el").select2();
    }
</script>


@endsection