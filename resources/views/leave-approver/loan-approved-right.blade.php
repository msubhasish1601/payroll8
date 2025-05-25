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
                <!-- Widgets  -->
                <div class="row">

                    <div class="main-card">
                        <div class="card">
                            <!--<div class="text-center new-crd-hd">
								<img src="images/logo.png" alt="logo">
								<h3>Leave Application Form</h3>
							</div>-->
							<div class="card-header"><strong class="card-title">Apply for GPF Withdrawal</strong></div>
                            <div class="card-body card-block">
                                <form action="" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">

											<div class="clearfix"></div>


					<div class="emp-descp-main">
                                            <input type="hidden" name="apply_id" value="{{ $LoanApply[0]->id }}">
								<input type="hidden" name="employee_id" value="{{ $LoanApply[0]->employee_code }}">



								<div class="col-md-3 emp-desc">Employee Id: <span>{{ $LoanApply[0]->employee_code }}</span></div>
 <div class="col-md-3 emp-desc">GPF Withdrawal Purpose: <span>{{ $LoanApply[0]->purpose }}</span></div>
							        <div class="col-md-3 emp-desc">GPF Withdrawal Status: <span>{{ $LoanApply[0]->loan_status }}</span></div>
                                                                <div class="col-md-3 emp-desc">Applied Date: <span>{{ $LoanApply[0]->apply_date }}</span></div>


								</div>


                                    <div class="row form-group" style="margin-top:15px;margin-top: 15px;width: 71%;MARGIN: 0 AUTO;background: #e2e2e2;PADDING: 10PX 5PX;">
                                        <div class="col-md-3" style="text-align:right;">
                                        <label for="email-input" class=" form-control-label">GPF Withdrawal Status (*)</label>
                                                                        </div>
                                                                            <div class="col-md-6">

											<select class="form-control" name="leave_check" required>
												<option value="" selected disabled>Select</option>

                                               <option value="APPROVED" <?php  if($LoanApply[0]->loan_status!=''){  if($LoanApply[0]->loan_status=='APPROVED'){ echo 'selected';} } ?> >Approved</option>
                                                <option value="RECOMMENDED" <?php  if($LoanApply[0]->loan_status!=''){  if($LoanApply[0]->loan_status=='RECOMMENDED'){ echo 'selected';} } ?> >Recommended</option>
                                                <option  value="REJECTED" <?php  if($LoanApply[0]->loan_status!=''){  if($LoanApply[0]->loan_status=='REJECTED'){ echo 'selected';} } ?> >Rejected</option>
                                               
											</select>
											@if ($errors->has('leave_type'))
											<div class="error" style="color:red;">{{ $errors->first('leave_type') }}</div>
											@endif
										</div>

                                        <div class="col-md-3">

                                            <button type="submit" class="btn btn-danger btn-sm">Apply</button>
                                {{-- <button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Reset</button> --}}
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
