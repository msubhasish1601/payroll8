@extends('rota.layouts.master')

@section('title')
{{ config('app.name', 'Laravel') }} Configuration - User
@endsection

@section('sidebar')
@include('rota.partials.sidebar')
@endsection

@section('header')
@include('rota.partials.header')
@endsection

@section('content')
<!-- Content -->
<div class="content">
	<!-- Animated -->
	<div class="animated fadeIn">
	<div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title">Shift Details</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Time Shift Management</a></li>
                                <li>/</li>
								<li><a href="#">Shift Management</a></li>
								<li>/</li>
                                <li class="active">Shift Details</li>
						
                            </ul>
                        </span>
</div>
</div>
		<!-- Widgets  -->
		<div class="row">
			<div class="main-card">
				<div class="card">
					<!-- <div class="card-header"><strong class="card-title">Shift Details</strong></div> -->
					<div class="card-body">

						@include('include.messages')
						<form action="{{ url('rota/save-shift-management') }}" method="post" enctype="multipart/form-data">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="clearfix"></div>
							<div class="lv-due" style="border:none;">

								<div class="row form-group lv-due-body">
									<div class="col-md-3">
										<label>Select Department</label>
										<select class="form-control" id="emp_code" required name="department" onchange="chngdepartment(this.value);">
											<option value="">Select</option>

											@foreach($departs as $dept)
											<option value='{{ $dept->id }}' <?php if (app('request')->input('id')) {
																				if ($shift_management->department == $dept->id) {
																					echo 'selected';
																				}
																			} ?>>{{ $dept->department_name }}</option>
											@endforeach
										</select>
									</div>

									<div class="col-md-3">
										<label>Select Designation</label>
										<select class="form-control" id="designation" required name="designation">
											
										</select>
									</div>

									<div class="col-md-3">
										<label>Work In Time</label>
										<input type="time" name="time_in" value="" class="form-control" required>
									</div>

									<div class="col-md-3">
										<label>Work Out Time</label>
										<input type="time" name="time_out" value="" class="form-control" required>
									</div>

									<div class="col-md-3">
										<label>Break Time From</label>
										<input type="time" name="rec_time_in" value="" class="form-control" required>
									</div>

									<div class="col-md-3">
										<label>Break Time To</label>
										<input type="time" name="rec_time_out" value="" class="form-control" required>
									</div>



								</div>
								<div class="row form-group lv-due-body">
									<div class="col-md-6">
										<label>Shift Description</label>
										<textarea rows="5" class="form-control" name="shift_des"></textarea>

									</div>
								</div>
								<div class="row form-group">
									<div class="col-md-4 btn-up">
										<button type="submit" class="btn btn-danger btn-sm">Submit</button>
										<button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Reset</button>

									</div>

									<div class="clearfix"></div>
								</div>

								<!--
					  <div id="rowid">
					  
					  </div>
					  -->


							</div>
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
<div class="clearfix"></div>

@endsection

@section('scripts')
@include('rota.partials.scripts')

<script>
	function del(i, head) {
		//alert(i);
		//alert(head);
		var classrow = head + '' + i;

		/*
		if (rowid != ''){
			//alert(rowid);
			//$('#add'+rowid).prop('disabled', false);
			//$('#add'+rowid).removeAttr('disabled');
			alert("DEL"+i);
			$('#addrow'+rowid).attr('disabled',false);
		}
		*/

		$(".row" + classrow).html('');
	}
</script>

<script>
	function chngdepartment(empid) {

		$.ajax({
			type: 'GET',
			url: '{{url('rota/getEmployeedesigByshiftId')}}/'+empid,
			cache: false,
			success: function(response) {


				document.getElementById("designation").innerHTML = response;
			}
		});
	}
</script>
@endsection