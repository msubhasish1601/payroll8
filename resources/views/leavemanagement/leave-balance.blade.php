
@extends('leavemanagement.layouts.master')

@section('title')
Leave Balance System-Company
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
            <h5 class="card-title"> Leave Balance</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
							<li><a href="#">Leave Managemnt</a></li>
                                <li>/</li>
                                <!-- <li><a href="#">Leave Allocation</a></li>
                                <li>/</li> -->
                                <li class="active">Leave Balance</li>
						
                            </ul>
                        </span>
</div>
</div>
                <!-- Widgets  -->
                <div class="row">
                  
                    <div class="main-card">
                        <div class="card">
						<!-- <div class="card-header"><strong class="card-title">Leave Balance</strong></div> -->
                          
                        <div class="card-body">
					
								
							<div class="srch-rslt" style="overflow-x:scroll;">	
							<table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
									
                                            <th>Employee Code</th>
                                            <th>Employee Name</th>
                                            <th>Leave Type</th>
											<th>Leave in Hand</th>
											<th>Year</th>
                                        </tr>
                                    </thead>
                                    <tbody>
					@foreach($leave_balance_rs as $leave_balance)
                                        <tr>	
                                                <td>{{ $leave_balance->old_emp_code }}</td>
                                                <td>{{ $leave_balance->emp_fname.' '.$leave_balance->emp_mname.' '.$leave_balance->emp_lname }}</td>
                                                <td>{{ $leave_balance->leave_type_name }}</td>
                                                <td>{{ $leave_balance->leave_in_hand }}</td>
												 <td><?php $bal=explode('/',$leave_balance->month_yr);?>
												 {{ $bal[1] }}</td>
								
                                        </tr>
                                        @endforeach
                                       
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
       @endsection

@section('scripts')
	@include('leavemanagement.partials.scripts')
 @endsection
