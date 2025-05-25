@extends('leave.layouts.master')

@section('title')
Payroll Information System-Apply For Tour
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
                  <?php //echo "<pre>" ; print_r($tour_apply->duration); exit; ?>
                    <div class="main-card">
                        <div class="card">
                            <div class="card-header"><strong class="card-title">Apply for Ltc</strong></div>
                            <div class="card-body card-block">
                                <form action="{{ url('employee-corner/apply-for-ltc') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
                               
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="id" value="<?php if(!empty($tour_apply->id)){ echo $tour_apply->id;} ?>">
								<input type="hidden" name="apply_date" value="<?php if(!empty($tour_apply->apply_date)){ echo $tour_apply->apply_date;}else{ echo date('Y-m-d'); } ?>">
											<div class="clearfix"></div>
									<div class="lv-due" style="border:none;">
										
										<div class="row form-group lv-due-body">
										<div class="col-md-4">
										<label for="text-input" class=" form-control-label">From Date</label>
										<input type="date" class="form-control" name="from_date" id="from_date" value="<?php if(!empty($tour_apply->from_date)){ echo $tour_apply->from_date;} ?>" onblur="get_duration();" required>
										@if ($errors->has('from_date'))
											<div class="error" style="color:red;">{{ $errors->first('from_date') }}</div>
										@endif
										</div>
										<div class="col-md-4">
										<label for="text-input" class=" form-control-label">To Date</label>
										<input type="date" class="form-control" name="to_date" id="to_date" value="<?php if(!empty($tour_apply->to_date)){ echo $tour_apply->to_date;} ?>" onblur="get_duration();" required>
										@if ($errors->has('to_date'))
											<div class="error" style="color:red;">{{ $errors->first('to_date') }}</div>
										@endif
										</div>
										<div class="col-md-4">
										<label for="text-input" class=" form-control-label">Duration in Days</label>
										<input type="text" class="form-control" id="duration" name="duration" value="<?php if(!empty($tour_apply->duration)){ echo $tour_apply->duration;} ?>" readonly required>
										@if ($errors->has('duration'))
											<div class="error" style="color:red;">{{ $errors->first('duration') }}</div>
										@endif
										</div>
										
										</div>
									</div>	
									

                                <div class="row form-group" style="margin-top:15px;">
									<div class="col-md-4">
                                        <label for="email-input" class="form-control-label">Purpose of Ltc <span>(*)</span></label>
                                        <input type="text" class="form-control" id="purpose" name="purpose"  required value="<?php if(!empty($tour_apply->purpose)){ echo $tour_apply->purpose;} ?>">
										@if ($errors->has('purpose'))
											<div class="error" style="color:red;">{{ $errors->first('purpose') }}</div>
										@endif	
									</div>
                                   
								   	<div class="col-md-4 btn-up">
                                        <button type="submit" class="btn btn-danger btn-sm">Apply</button>
									</div>
                                </div>  
                            </div>
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
@include('leave.partials.scripts')
<script>
function get_duration()
{
	var from_date= $("#from_date").val();
	var to_date= $("#to_date").val();

	var fromdate = new Date(from_date);
	var todate = new Date(to_date);
	
	if(todate < fromdate){
		$("#from_date").val("");
		$("#to_date").val("");
		$("#duration").val("");
		alert('Please provide valid date!');
	}

	const diffTime = Math.abs(todate.getTime() - fromdate.getTime());
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; 
    	// alert(diffDays);
	$('#duration').val(diffDays);
}



</script>
@endsection