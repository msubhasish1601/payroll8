
@extends('leavemanagement.layouts.master')

@section('title')
Leave Allocation System-Company
@endsection

@section('sidebar')
	@include('leavemanagement.partials.sidebar')
@endsection

@section('header')
	@include('leavemanagement.partials.header')
@endsection

@section('scripts')
	@include('leavemanagement.partials.scripts')
@endsection

@section('content'))
  <!-- Content -->
    <div class="content">
        <!-- Animated -->
        <div class="animated fadeIn">
		<div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title"> Edit Leave Allocation</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
							<li><a href="#">Leave Managemnt</a></li>
                                <li>/</li>
                                <li><a href="#">Leave Allocation</a></li>
                                <li>/</li>
                                <li class="active">Edit Leave Allocation</li>
						
                            </ul>
                        </span>
</div>
</div>
                <!-- Widgets  -->
            <div class="row">
                <div class="main-card">
                    <div class="card">
                        <div class="card-header">
							<!-- <strong class="card-title">Edit Leave Allocation</strong> -->
						</div>
                        <div class="card-body card-block">
                            <form action="{{ url('leave-management/save-edit-leave-allocation') }}" method="post" enctype="multipart/form-data" class="form-horizontal" style="padding:5% 12%;">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="<?php echo $leave_allocation->id;  ?>">
                            <input type="hidden" name="leave_type_id" value="<?php echo $leave_allocation->leave_type_id; ?>">
                             <input type="hidden" name="leave_rule_id" value="<?php echo $leave_allocation->leave_rule_id; ?>">
                             <div class="row form-group">
                            <div class="col-md-4">
								<label for="email-input" class=" form-control-label">Leave Type <span></span></label>
								<input type="text" class="form-control" value="<?php  if(!empty($leave_type->leave_type_name)){echo $leave_type->leave_type_name;} ?>" readonly>
							</div>

							<div class="col-md-4">
								<label for="email-input" class=" form-control-label">Employee Code <span></span></label>
								<input type="text" name="employee_code" class="form-control" value="<?php  if(!empty($leave_allocation->employee_code)){echo $leave_allocation->employee_code;} ?>" readonly>
							</div>

							<div class="col-md-4">
								<label for="email-input" class=" form-control-label">Max No. Of Leave <span></span></label>
								<input type="text" name="max_no" id="max_no" class="form-control" value="<?php  if(!empty($leave_allocation->max_no)){echo $leave_allocation->max_no;} ?>" readonly>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-4">
								<label for="email-input" class=" form-control-label">Opening Balance. <span></span></label>
								<input type="text" id="opening_bal" name="opening_bal" class="form-control" value="<?php  if(!empty($leave_allocation->leave_in_hand)){echo $leave_allocation->leave_in_hand;} ?>" readonly />

								@if ($errors->has('opening_bal'))
								<div class="error" style="color:red;">{{ $errors->first('opening_bal') }}</div>
								@endif
							</div>

							<div class="col-md-4">
								<label for="email-input" class=" form-control-label">Leave in Hand. <span>(*)</span></label>
								<input type="text" id="leave_in_hand"  name="leave_in_hand" class="form-control" value="<?php  if(!empty($leave_allocation->leave_in_hand)){echo $leave_allocation->leave_in_hand;} ?>">
								
							</div>

							<div class="col-md-4">
								<label for="email-input" class=" form-control-label">Month/Year <span>(*)</span></label>

								<input type="text" id="month_yr"  name="month_yr" class="form-control" value="<?php  echo date('m').'/'.date('Y'); ?>" readonly />
								
							</div>
							</div>
								
                            <button type="submit" class="btn btn-danger btn-sm">Submit</button>
                          
							<p>(*) marked fields are mandatory</p>
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
		@include('leavemanagement.partials.scripts')
	<script>

		function calculateleaveInHand(opening_bal)
		{			
			//var leave_in_hand = $('#opening_bal').val();
			var max_no = $('#max_no').val();
			var leave_in_hand = parseInt(max_no) - parseInt(opening_bal);
			$('#leave_in_hand').val(leave_in_hand);
		}
	</script>
	
@endsection

