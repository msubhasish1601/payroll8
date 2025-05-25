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
                            <div class="card-header">
                                <strong><i class="fa fa-eye" aria-hidden="true"></i> Attendance In-time and Out-time Information</strong>
                            </div>
                            <div class="card-body card-block">
                                <form action="{{ url('employee-corner/login-logout-status') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
                                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    
                                    <div class="row">
										 
                                        <div class="col-md-7"> 
                                         <label for="text-input" class=" form-control-label">Select Month <span>(*)</span></label>                   
                                            <select data-placeholder="Choose an Employee..."  class="form-control" name="month_yr" id="month_yr" required>
                                                    <option value="" selected disabled > Select </option>
                                                    <?php foreach($monthlist as $month){?>
                                                    <option value="<?php  echo $month->month_yr; ?>" @if(isset($month_yr_new) && $month_yr_new==$month->month_yr) selected @endif><?php echo $month->month_yr; ?></option>
                                                    <?php } ?>
                                            </select>
                                        </div>
										
                                        <div class="col-md-5">
                                            <button type="submit" style="margin-top:30px;" class="btn btn-danger btn-sm">Search</button>
                                        </div>    

                                    </div>
						
									
									
								
								</form>
							
							
                        </div>
                        
                    </div>
                       
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Search Result</strong>
                            </div>
							<!--@if(Session::has('message'))										
								<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
							@endif	-->
							@include('include.messages')
                            <div class="card-body">
							
							<div class="srch-rslt" style="overflow-x:scroll;">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                           
                                            <th>In Time</th>
                                            <th>Out Time</th>
					<th>Duration</th>
					
                                        </tr>
                                    </thead>
                                    <tbody>
								
										<?php print_r($result); ?>
                                      
                                        
                                    </tbody>
                                </table>
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
@include('leave.partials.scripts')

@endsection

