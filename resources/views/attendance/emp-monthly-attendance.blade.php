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
            <h5 class="card-title">Monthly Attendence</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
							<li><a href="#">Attendence Management</a></li>
                                <li>/</li>
                                <!-- <li><a href="#">Employee Master</a></li>
                                <li>/</li> -->
                                <li class="active">Monthly Attendence</li>
						
                            </ul>
                        </span>
</div>
</div>
                <!-- Widgets  -->
                <div class="row">
                 
                    <div class="main-card" style="margin:0 auto;">
                        <div class="card">
						<!-- <div class="card-header"><strong class="card-title">Monthly Attendance</strong></div> -->
                           @include('include.messages')
                                                                <div class="card-body card-block">
                                
                                <form action="{{ url('attendance/monthly-attendance') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">                                   
                                    <div class="row form-group" style="width:60%;margin:0 auto;">

                                        <div class="col col-md-3" style="text-align: right;">
                                            <label for="text-input" class=" form-control-label" style="margin-top:4px;">Select Month <span>(*)</span></label>
                                        </div>
                                      
                                        <div class="col-md-5">                    
											<select data-placeholder="Choose an Employee..."  class="form-control" name="month_yr" id="month_yr" required>
													<option value="" selected disabled > Select </option>
													<?php foreach($monthlist as $month){?>
													<option value="<?php  echo $month->month_yr; ?>" @if(isset($month_yr_new) && $month_yr_new==$month->month_yr) selected @endif><?php echo $month->month_yr; ?></option>
													<?php } ?>
											</select>
                                        </div>
                                        
                                       
										@if ($errors->has('month_yr'))
											<div class="error" style="color:red;">{{ $errors->first('month_yr') }}</div>
										@endif	
										
									
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
								<form method="post" action="{{ url('attendance/save-Process-Attandance') }}">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<div class="srch-rslt" style="overflow-x:scroll;">
									<table id="bootstrap-data-table" class="table table-striped table-bordered">
										<thead>
											<tr>
												<th>Sl No.</th>
												<th>No. of Employee</th>
                                                <th>Attendance Month</th>
                                                <th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php if(($upload_record_rs)>0){ ?>
											<tr>
												<td>1</td>
												<td><?php echo $upload_record_rs; ?></td>
												<td><?php echo $month_yr_new; ?></td>
												<td><a href="{{url('attendance/delete-monthly-attandance')}}?month=<?php echo urlencode(base64_encode($month_yr_new)); ?>" onclick="return confirm('Are You Sure, Want to Delete');"><i class="ti-trash"></i></a></td>
											<?php } ?>
											</tr>	
										</tbody>   
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
@endsection

<script type="text/javascript">


</script>