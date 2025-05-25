@extends('leave.layouts.master')

@section('title')
Payroll Information System-Company
@endsection

@section('sidebar')
	@include('leave.partials.sidebar')
@endsection

@section('header')
	@include('leave.partials.header')
@endsection

@section('content')
        <!-- Content -->


        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
                <!-- Widgets  -->
                <div class="row">

                    <div class="main-card">
                        <div class="card">
                            <!-- @if(Session::has('Leave_msg'))
								<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('Leave_msg') }}</em></div>
							@endif	 -->
                            @include('include.messages')

							<div class="card-header"><strong class="card-title">Leave application</strong>
								<span style="float: right;"><a style="color: #4e9d05;" href="{{ url('employee-corner/holiday-calendar') }}" target="_blank"><i class="fa fa-calendar" aria-hidden="true"></i>
                                Holiday Calender</a></span></div>

                            <div class="card-body card-block">
                            <form action="{{ url('employee-corner/save-apply-leave') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
							<input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                                <div class="emp-descp-main">
                                    
                                    <input type="hidden" name="employee_id" value="{{$employee->emp_code}}">
                                     <input type="hidden" name="employee_name" value="{{$employee->emp_fname}} {{$employee->emp_mname}} {{$employee->emp_lname}}">
                                      <input type="hidden" name="date_of_apply" value="<?php echo date('Y-m-d'); ?>">
								<div class="col-md-4 emp-desc">Employee Code: <span>{{$employee->old_emp_code}}</span></div>
								<input type="hidden" name="emp_code" value="{{ isset($employee_code) ? $employee_code : '' }}">

                                <div class="col-md-4 emp-desc">Employee Name: <span>{{$employee->emp_fname}} {{$employee->emp_mname}} {{$employee->emp_lname}}</span></div>

								<div class="col-md-4 emp-desc">Date of Application: <span><?php echo date('d-m-Y'); ?></span></div>
								</div>
											<div class="clearfix"></div>



                                    <div class="row form-group" style="margin-top:15px;">
									<div class="col-md-4">
                                        <label for="email-input" class=" form-control-label">Leave Type (*)</label>

											<select class="form-control" id="leave_type" name="leave_type" required onchange="getLeaveInHand(this.value);">
												<option value="" selected disabled>Select Leave Type</option>
												@foreach($leave_type_rs as $leave)
                                                <option value="{{$leave->id}}">{{$leave->leave_type_name}}</option>
											@endforeach
											</select>
											@if ($errors->has('leave_type'))
											<div class="error" style="color:red;">{{ $errors->first('leave_type') }}</div>
											@endif
										</div>
                                        <div class="col-md-4" id="half_cl" style="display:none">
                                        <label for="email-input" class="form-control-label">Apply for</label>

                                        <select name="half_cl" id="cl_type" class="form-control" >
                                            <option value="" selected="">Select</option>
                                            <option value="half">Half Day</option>
                                            <option value="full">Full Day</option>
                                        </select>
                                    </div>


                                    <div class="col-md-4">
                                        <label for="email-input" class=" form-control-label">Leave In Hand</label>
                                        <input type="text" readonly="" name="leave_inhand" class="form-control"  id="leave_inhand" required>
                                          @if ($errors->has('leave_inhand'))
                                        <div class="error" style="color:red;">{{ $errors->first('leave_inhand') }}</div>
                                    @endif
									</div>
									<div class="col-md-4">
                                        <label for="from-date" class=" form-control-label">From Date (*)</label>
                                        <input type="date" id="from_date" name="from_date" required value="{{ old('from_date') }}" placeholder="dd/mm/yyyy" class="form-control" required="">
										@if ($errors->has('from_date'))
											<div class="error" style="color:red;">{{ $errors->first('from_date') }}</div>
										@endif
                                   </div>
								   <div class="col-md-4">
                                        <label for="to-date" class=" form-control-label">To Date (*)</label>
                                        <input type="date" id="to_date" name="to_date" required placeholder="dd/mm/yyyy" value="{{ old('to_date') }}" class="form-control" onchange="get_duration()" required=""><span id="dif"></span>
										@if ($errors->has('to_date'))
											<div class="error" style="color:red;">{{ $errors->first('to_date') }}</div>
										@endif
									</div>
                                    <div class="col-md-4">
                                        <label for="email-input" class=" form-control-label">No. of Days</label>
                                        <input type="text" readonly="" name="days" required class="form-control" id="days" required>
                                        @if ($errors->has('days'))
                                            <div class="error" style="color:red;">{{ $errors->first('days') }}</div>
                                        @endif
                                    </div>
                                     <div class="col-md-4" id="doc_image" style="display:none">
                                        <label for="email-input" class=" form-control-label">Upload Document</label>
                                        <input type="file"  name="doc_image" class="form-control" >
                                    </div>



                                    <!-- -->
										<input type="hidden" name="no_of_leave" id="diff">
                                    </div>

                                <button type="submit" class="btn btn-danger btn-sm">Apply</button>
                                <button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Reset</button>

							</form>
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


<!----------------Modal------------------------>

<!-------------------------------->

@endsection

@section('scripts')
@include('leave.partials.scripts')
<script>


		function getLeaveInHand(leavetype_id)
		{
			if(leavetype_id==5){

                 $("#doc_image").show();
                 $("#half_cl").hide();
            }else if(leavetype_id==1){
                 $("#doc_image").hide();
                 $("#half_cl").show();

            }else {
                 $("#doc_image").hide();
                 $("#half_cl").hide();
            }
			$.ajax({
				type:'GET',
				url:'{{url('employee-corner/get-leave-in-hand')}}/'+leavetype_id,
				success: function(response){
				console.log(response);
    				if(response==0){

                          $('#leave_inhand').val(null);
                        $("#from_date").attr('readonly', true);
                        $("#to_date").attr('readonly', true);

                    }else{

                        $("#leave_inhand").val(response);
                        $("#from_date").attr('readonly', false);
                        $("#to_date").attr('readonly', false);
                        $('#days').val('');
                        $("#from_date").val('');
                        $("#to_date").val('');
                    }
				}
			});


            /*if(($("#leave_inhand").val()) == '0')
            {
                alert('hi');
                $('#days').attr('readonly', true);
                $("#from_date").attr('readonly', true);
                $("#to_date").attr('readonly', true);
            }*/
		}

function get_duration()
{
    // alert('hi');
    var from_date= $("#from_date").val();
    var to_date= $("#to_date").val();
    var leave_type = $("#leave_type option:selected").val();
    var lvinhand = $('#leave_inhand').val();
    var cl_type = $('#cl_type').val();

    // var holiday = {};
    var holiday = JSON.parse('{!! json_encode($holiday_array) !!}');


    //Copy date objects so don't modify originals
        var startDate = new Date(from_date);
        var endDate = new Date(to_date);

        if (endDate < startDate) {

            $("#from_date").val("");
            $("#to_date").val("");
            $('#days').val("");
            alert('Please provide valid date!');
        }
        else {
            if (leave_type == '1' && endDate > startDate && cl_type == 'half')
            {
                $("#from_date").val("");
                $("#to_date").val("");
                $('#days').val("");
                alert('Half CL is applicable for one day only!');
            }
            else{
                $.ajax({
                   type:'POST',
                   data: {"leave_type": leave_type, "from_date": from_date,"to_date": to_date,"holiday": holiday, "cl_type": cl_type, "_token": $('#token').val()},
                   datatype: 'JSON',
                   url:'{{url('/employee-corner/holiday-count')}}',
                   success:function(response){
                       //var obj=JSON.parse(responce);
                           // console.log(response);
                           $('#days').val(response);
                    }
                });
            }
        }

}

function parseDate(input) {
    // Transform date from text to date
  var parts = input.match(/(\d+)/g);
  // new Date(year, month [, date [, hours[, minutes[, seconds[, ms]]]]])
  return new Date(parts[0], parts[1]-1, parts[2]); // months are 0-based
}
</script>
@endsection