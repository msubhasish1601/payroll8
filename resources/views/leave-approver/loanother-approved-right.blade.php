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
<style>
.table-stats.order-table.ov-h .table tbody tr td {
    font-size: 12px;
}
    .order-table::before {
        content: "";
        position: absolute;
        top: 0px;
        height: 35px;
        width: 10px;
        background: none;
    }

    .table-stats.order-table.ov-h table thead th {
        /*background: #e4dacb;*/
        color: #6b0202;
        font-weight: 600;
        width: 100%;
    }

</style>

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
							<div class="card-header"><strong class="card-title">Apply for Loan</strong></div>
                            <div class="card-body card-block">
                                <form action="" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">

								<div class="clearfix"></div>


					       <div class="emp-descp-main">
                                <input type="hidden" name="apply_id" value="{{ $loanotherApply->id }}">
								<input type="hidden" name="employee_id" value="{{ $loanotherApply->employee_code }}">
								 <input type="hidden" name="emp_retirement_date" value="{{ $loanotherApply->apply_date }}">




								<div class="col-md-4 emp-desc">Employee Code: <span>{{ $loanotherApply->employee_code }}</span></div>
								<div class="col-md-4 emp-desc">Employee Name: <span>{{ $loanotherApply->emp_fname.$loanotherApply->emp_lname }}</span></div>
                                <div class="col-md-4 emp-desc">Employee Apply date : <span>{{ $loanotherApply->apply_date }}</span></div>
							        <div class="col-md-4 emp-desc"> Status: <span>{{ $loanotherApply->loan_status }}</span><input type="hidden" id="current_status" value="{{ $loanotherApply->loan_status }}"></div>



								</div>
                                <div class="emp-descp-main">
                                    <div class="table-stats order-table ov-h">



                                    </div>
                                </div>


                                    <div class="row form-group" style="margin-top:15px;margin-top: 15px;width: 71%;MARGIN: 0 AUTO;background: #e2e2e2;PADDING: 10PX 5PX;">
                                        <div class="col-md-4" style="text-align:right;">
                                        <label for="email-input" class=" form-control-label">Loan Status (*)</label>
                                    </div>
                                    <div class="col-md-5">

										<select class="form-control" name="leave_check" id="leave_status" required>
												<option value="" selected disabled>Select</option>
                                                <option value="APPROVED" <?php  if($loanotherApply->loan_status!=''){  if($loanotherApply->loan_status=='APPROVED'){ echo 'selected';} } ?> >Approved</option>
                                                <option value="RECOMMENDED" <?php  if($loanotherApply->loan_status!=''){  if($loanotherApply->loan_status=='RECOMMENDED'){ echo 'selected';} } ?> >Recommended</option>
                                                <option  value="REJECTED" <?php  if($loanotherApply->loan_status!=''){  if($loanotherApply->loan_status=='REJECTED'){ echo 'selected';} } ?> >Rejected</option>
                                               
										</select>
											@if ($errors->has('leave_type'))
											<div class="error" style="color:red;">{{ $errors->first('leave_type') }}</div>
											@endif
									</div>

                                    <div class="row col-md-9" id="remark_status" style="padding-left: 102px;padding-right:0; display:none;">
                                    <div class="col-md-4" style="text-align: right;">
                                        <label>Remarks</label>
                                    </div>

                                   </div>
                                    <div class="col-md-3" style="padding-left: 20px;">
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
<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script type="text/javascript">

    $( document ).ready(function() {

        var current_status=$('#current_status').val();
        if(current_status=='APPROVED'){
            $("#leave_status option[value='REJECTED']").prop("disabled",true);

        }


    });


    function remarkStatus(){
        var selectedstatus = $('#leave_status option:selected').val();

        if(selectedstatus=='REJECTED' || selectedstatus=='CANCEL'){
             $("#remark_status").show();
        }else{
            $("#remark_status").hide();
        }
    }


</script>
@endsection
