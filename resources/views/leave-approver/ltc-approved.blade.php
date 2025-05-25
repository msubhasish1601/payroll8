@extends('leave-approver.layouts.master')

@section('title')
Payroll Information System-Company
@endsection

@section('sidebar')
	@include('leave-approver.partials.sidebar')
@endsection

@section('header')
	@include('leave-approver.partials.header')
@endsection



@section('content')

  <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
            <div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title">Request LTC</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
							<li><a href="#">Leave & Tour Approver</a></li>
                                <li>/</li>
                                <!-- <li><a href="#">Employee Master</a></li>
                                <li>/</li> -->
                                <li class="active">Request LTC</li>
						
                            </ul>
                        </span>
</div>
</div>
         
                <!-- Widgets  -->
                <div class="row">
                  
                    <div class="main-card">
                        <div class="card">
                            <!--<div class="text-center new-crd-hd">
								<img src="images/logo.png" alt="logo">
								<h3>Leave Application Form</h3>
							</div>-->
							<!-- <div class="card-header"><strong class="card-title">Request Ltc</strong></div> -->
                            <div class="card-body card-block">
                                <form action="{{ url('leave-approver/ltc-approved') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
                               
											<div class="clearfix"></div>
										
									
					<div class="emp-descp-main">   
                                            <input type="hidden" name="apply_id" value="{{ $ltcapply[0]->id }}">
								<input type="hidden" name="employee_id" value="{{ $ltcapply[0]->employee_code }}">
								
							
								
								<div class="col-md-4 emp-desc">Employee Id: <span>{{ $ltcapply[0]->employee_code }}</span></div>
								
							        <div class="col-md-4 emp-desc">Leave Status: <span>{{ $ltcapply[0]->ltc_status }}</span></div>
                                                                <div class="col-md-4 emp-desc">Total Duration: <span>{{ $ltcapply[0]->duration }}</span> Days</div>
                                                                <div class="col-md-4 emp-desc">From Date: <span>{{ $ltcapply[0]->from_date }}</span></div>
                                                                  <div class="col-md-4 emp-desc">To Date: <span>{{ $ltcapply[0]->to_date }}</span></div>
								
								</div>						
	
                                    
                                    <div class="row form-group" style="margin-top:15px;margin-top: 15px;width: 71%;MARGIN: 0 AUTO;background: #e2e2e2;PADDING: 10PX 5PX;">
                                        <div class="col-md-3" style="text-align:right;">
                                        <label for="email-input" class=" form-control-label">Leave Status (*)</label>
                                                                        </div>
                                                                            <div class="col-md-6">
                                        
											<select class="form-control" name="leave_check" required>
												<option value="" selected >Select</option>
												
                                                
													<option value="APPROVED" <?php  if($ltcapply[0]->ltc_status!=''){  if($ltcapply[0]->ltc_status=='APPROVED'){ echo 'selected';} } ?> >Approved</option>
                                                <option value="RECOMMENDED" <?php  if($ltcapply[0]->ltc_status!=''){  if($ltcapply[0]->ltc_status=='RECOMMENDED'){ echo 'selected';} } ?> >Recommended</option>
                                                <option  value="REJECTED" <?php  if($ltcapply[0]->ltc_status!=''){  if($ltcapply[0]->ltc_status=='REJECTED'){ echo 'selected';} } ?> >Rejected</option>
                                              
											</select>
											@if ($errors->has('leave_type'))
											<div class="error" style="color:red;">{{ $errors->first('leave_type') }}</div>
											@endif
										</div>
                                    
                                        <div class="col-md-3">
                                            
                                            <button type="submit" class="btn btn-danger btn-sm">Apply</button>
                               
                                        </div>
                                       
                                    </div>
							
                                
                            	
                                   
                           
							
                            
							
							</form>
							 </div>
                        </div>
                        
                    </div>
                       
                    </div>

                    
                    
                </div>
                <!-- /Widgets -->
               
                
                
            </div>
        @endsection

@section('scripts')
@include('leave-approver.partials.scripts')

     @endsection