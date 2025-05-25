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
    
    #bootstrap-data-table th{vertical-align:top;text-align: center;}
</style>

      <!-- Content -->
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
			<div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title">Process Attendence</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
							<li><a href="#">Attendence Management</a></li>
                                <li>/</li>
                                <!-- <li><a href="#">Employee Master</a></li>
                                <li>/</li> -->
                                <li class="active">Process Attendence</li>
						
                            </ul>
                        </span>
</div>
</div>
                <!-- Widgets  -->
                <div class="row">
                 
                    <div class="main-card" style="margin:0 auto;">
                        <div class="card">
						<!-- <div class="card-header"><strong class="card-title">Process Attendance</strong></div> -->
                             @include('include.messages')                                   <div class="card-body card-block">
                                
                                <form action="{{ url('attendance/process-attendance') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">                                   
                                    <div class="row form-group" style="width:60%;margin:0 auto;">
									
                                       
                                 
	                <div class="col col-md-3" style="text-align: right;">
	                    <label for="text-input" class=" form-control-label" style="margin-top:4px;">Select Month <span>(*)</span></label>
	                </div>
                    <div class="col-md-5">                                                
						<select data-placeholder="Choose an Employee..."  class="form-control" name="month_yr" id="month_yr" required>
								<option value="" selected disabled > Select </option>
											<?php 
											for($yy=2018;$yy<=2030;$yy++)
											{
												for($mm=1; $mm <= 12; $mm++)
												{ 												
													if($mm<10)
													{
														$month_yr='0'.$mm."/".$yy;
													}												
													else
													{
														$month_yr=$mm."/".$yy;														
													}
											?>
												<option value="<?php  echo $month_yr; ?>"  @if(isset($month_yr_new) && $month_yr_new==$month_yr) selected @endif><?php echo $month_yr; ?></option>
											<?php 
												
												}
											}
											?>
						</select>
						@if ($errors->has('month_yr'))
											<div class="error" style="color:red;">{{ $errors->first('month_yr') }}</div>
						@endif
                	</div>
				
                <div class="col-md-4">
					<button type="submit" class="btn btn-danger btn-sm">View</button>
				</div>
                                       
            </div>
								
                                   
                           
                                
                            
							</form>
							 
                        </div>
                       <div class="card-body">
					<div class="card-header">
									<strong class="card-title">Search Result</strong>
								</div>
								<br/>
								<form method="post" action="{{ url('attendance/save-Process-Attandance') }}" style="padding:0;">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<div class="srch-rslt" style="overflow-x:scroll;">
									<table id="bootstrap-data-table" class="table table-striped table-bordered">
										<thead>
											<tr>
												<th><div class="checkbox">
												<label><input type="checkbox"  name="all" id="all" width="30px;" height="30px;">
												Select</label>
												</div></th>
												<th>Employee Code</th>
												<th>Employee Name</th>
												<th>No. of Working Days</th>
                                                                                                <th>No. of Days Leave Taken</th>
                                                                                                <th>No. Of Tour Leave</th>
												<th>No. of Absent Days</th>
                                                                                                <th>No. of Present Days</th>
												<th>No. of Days Salary</th>
											</tr>
										</thead>
										<tbody>
										
										
											<?php print_r($result); ?>
											
										</tbody>
										@if($result!='')
									<tfoot>
										
										<tr>
											<td colspan="7" style="border:none;"><button type="submit" class="btn btn-danger btn-sm">Save</button></td>
											
										</tr>
									</tfoot> 
@endif									
									</table>
                                                                            
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
        <div class="clearfix"></div>
    @endsection

@section('scripts')
@include('attendance.partials.scripts')

	<script>
	// Listen for click on toggle checkbox for each Page
		$('#all').click(function(event) {  
		
			if(this.checked) {
				//alert("test");
				// Iterate each checkbox
				$(':checkbox').each(function() {
					this.checked = true;                        
				});
			} else {
				$(':checkbox').each(function() {
					this.checked = false;                       
				});
			}
		});
		
	</script>	
	
	<script>
	// Listen for click on toggle checkbox for each Page
		$('#all').click(function(event) {  
		
			if(this.checked) {
				//alert("test");
				// Iterate each checkbox
				$(':checkbox').each(function() {
					this.checked = true;                        
				});
			} else {
				$(':checkbox').each(function() {
					this.checked = false;                       
				});
			}
		});
		
	</script>	
	
@endsection