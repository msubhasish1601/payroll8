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
            <h5 class="card-title">Monthly Pay Slips</h5>
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Report Module</a></li>
                                <li>/</li>
                                <li><a href="#">Monthly Pay Slips</a></li>

                            </ul>
                        </span>
</div>
</div>
      <!-- Widgets  -->
      <div class="row">
        <div class="main-card">
          <div class="card">
            <!-- <div class="card-header"> <strong>Monthly Salary Register</strong> </div> -->
			@include('include.messages')
            <div class="card-body card-block">
              <form action="{{ url('payroll/vw-all-payslips') }}" target="_blank" method="post">
			   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row form-group">

                <div class="col-md-4">
                    <label class=" form-control-label">Month</label>
                    <select data-placeholder="Choose Month..." name="month_yr" id="month_yr" class="form-control" required>
					<option value="" selected disabled > Select </option>
                            				<?php foreach ($monthlist as $month) {?>
								<option value="<?php echo $month->month_yr; ?>"><?php echo $month->month_yr; ?></option>
							<?php }?>
                        </select>

		</div>
    <!-- <div class="col-md-4">
	                    <label class=" form-control-label">Select Class</label>
	                    <select class="form-control" name="class_name_new" >
							<option value="">Select</option>
							@if(isset($class_name) && count($class_name)!=0)
							@foreach($class_name as $val)
								<option  value="{{$val->id}}"  @if(isset($class_name_new) && $class_name_new == $val->id ) selected="selected" @endif>{{$val->group_name}}</option>
							@endforeach
							@endif

						</select>
	                  </div> -->

                </div>
                <button type="submit" class="btn btn-danger btn-sm">View </button>
                <!-- <button type="reset" class="btn btn-danger btn-sm"> Download as Excel</button> -->

              </form>
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
	<script>
		function getGrades(company_id)
		{
			//alert(company_id);
			$.ajax({
				type:'GET',
				url:"{{url('pis/get-grades')}}/"+company_id,
				success: function(response){
				console.log(response);

				$("#grade_id").html(response);

				}

			});
		}
	</script>
@endsection