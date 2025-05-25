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
                            <!-- @if(Session::has('Loan_msg'))
								<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('Leave_msg') }}</em></div>
							@endif -->
                            @include('include.messages')
							<div class="card-header"><strong class="card-title">Apply for Loan </strong>
								</div>
                                <?php
                                $date1 = strtotime($employee->emp_doj);
                                $date2 = strtotime($employee->emp_retirement_date);
                                $diff = abs($date2 - $date1);
                                 $years = floor($diff / (365*60*60*24));
                                ?>

                            <div class="card-body card-block">
                            <form action="{{ url('employee-corner/save-loan-apply') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
							<input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                                <div class="emp-descp-main">
                                    <input type="hidden" name="employee_id" value="{{$employee->emp_code}}">
                                     <input type="hidden" name="employee_name" value="{{$employee->emp_fname}} {{$employee->emp_mname}} {{$employee->emp_lname}}">
                                     <input type="hidden" name="emp_reporting_auth" value="{{$employee->emp_reporting_auth}}">
                                     <input type="hidden" name="no_of_working_years" value="{{$years}}">
                                <div class="col-md-4 emp-desc">Employee Code: <span>{{$employee->emp_code}}</span></div>
								<div class="col-md-4 emp-desc">Employee Name: <span>{{$employee->emp_fname}} {{$employee->emp_mname}} {{$employee->emp_lname}}</span></div>


								</div>
											<div class="clearfix"></div>



                                    <div class="row form-group" style="margin-top:15px;">
									<div class="col-md-4">
                                        <label for="email-input" class=" form-control-label">Loan Type (*)</label>

											<select class="form-control" id="loan_type" name="loan_type" onchange="getLeaveInHand(this.value);" required>
												<option value="" selected disabled>Select Loan Type</option>
												@foreach($loan_type_rs as $loan)
                                                <option value="{{$loan->id}}">{{$loan->loan_type}}</option>
											@endforeach
											</select>
											@if ($errors->has('loan_type'))
											<div class="error" style="color:red;">{{ $errors->first('loan_type') }}</div>
											@endif
										</div>


                                    <div class="col-md-4">
                                        <label for="email-input" class=" form-control-label">Loan Apply No.</label>
                                    <input type="text" readonly="" name="loan_applied_no" value="{{$loan_code}}" class="form-control"  id="loan_applied_no">
                                          @if ($errors->has('loan_applied_no'))
                                        <div class="error" style="color:red;">{{ $errors->first('loan_applied_no') }}</div>
                                    @endif
                                    </div>
                                    <div class="col-md-4">
                                        <label for="email-input" class=" form-control-label">Date of Application.</label>
                                    <input type="date" name="apply_date" class="form-control"  id="apply_date" required>
                                          @if ($errors->has('apply_date'))
                                        <div class="error" style="color:red;">{{ $errors->first('apply_date') }}</div>
                                    @endif
									</div>
                                    <div class="col-md-4">
                                        <label for="email-input" class=" form-control-label">Purpose of Loan.</label>
                                    <input type="text" name="purpose_of_loan" class="form-control"  id="purpose_of_loan" required>
                                          @if ($errors->has('purpose_of_loan'))
                                        <div class="error" style="color:red;">{{ $errors->first('purpose_of_loan') }}</div>
                                    @endif
									</div>


                                    <div class="col-md-4">
                                        <label for="email-input" class=" form-control-label">Loan Amount</label>
                                        <input type="text" name="loan_amount" class="form-control" id="loan_amount" required>
										 <div class="error"  id="err" style="color:red;"></div>
                                        @if ($errors->has('loan_amount'))
                                            <div class="error" style="color:red;">{{ $errors->first('loan_amount') }}</div>
                                        @endif
                                    </div>
     <div class="col-md-4">
                                        <label for="email-input" class=" form-control-label">No Of Shares </label>
                                        <input type="text" name="no_of_shares" class="form-control" id="no_of_shares" required>
										 <div class="error"  id="errsh" style="color:red;"></div>
                                        @if ($errors->has('no_of_shares'))
                                            <div class="error" style="color:red;">{{ $errors->first('no_of_shares') }}</div>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                    <label for="email-input" class=" form-control-label">Name Of Gurantor 1</label>
                                    <input type="text" name="nominee_one" class="form-control" id="nominee_one" required>
                                    @if ($errors->has('nominee_one'))
                                        <div class="error" style="color:red;">{{ $errors->first('nominee_one') }}</div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                <label for="email-input" class=" form-control-label">Name Of Gurantor 2</label>
                                <input type="text" name="nominee_two" class="form-control" id="nominee_two" required>
                                @if ($errors->has('nominee_two'))
                                    <div class="error" style="color:red;">{{ $errors->first('nominee_two') }}</div>
                                @endif
                            </div>
                         <!--   <div class="col-md-4">
                            <label for="email-input" class=" form-control-label">Name Of Gurantor 3</label>
                            <input type="text" name="nominee_three" class="form-control" id="nominee_three" required>
                            @if ($errors->has('nominee_three'))
                                <div class="error" style="color:red;">{{ $errors->first('nominee_three') }}</div>
                            @endif
                        </div>

                                     -->

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
			
			$.ajax({
				type:'GET',
				url:'{{url('employee-corner/get-loan-in-hand')}}/'+leavetype_id,
				success: function(response){
				console.log(response);
				 var obj = jQuery.parseJSON( response );
    			console.log(obj['amount']);	
				console.log(obj['shares']);	
				document.getElementById("errsh").innerHTML="Maximum No Of Shares : "+obj['shares'];
				document.getElementById("err").innerHTML="Maximum Amount Of Loan : "+obj['amount'];
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



function parseDate(input) {
    // Transform date from text to date
  var parts = input.match(/(\d+)/g);
  // new Date(year, month [, date [, hours[, minutes[, seconds[, ms]]]]])
  return new Date(parts[0], parts[1]-1, parts[2]); // months are 0-based
}
</script>
@endsection
