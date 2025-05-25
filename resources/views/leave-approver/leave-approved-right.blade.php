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
							<div class="card-header"><strong class="card-title">Apply for Leave</strong></div>
                            <div class="card-body card-block">
                                <form action="" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
                               
								<div class="clearfix"></div>

									
					       <div class="emp-descp-main">   
                                <input type="hidden" name="apply_id" value="{{ $LeaveApply[0]->id }}">
								<input type="hidden" name="employee_id" value="{{ $LeaveApply[0]->employee_id }}">
								 <input type="hidden" name="no_of_leave" value="{{ $LeaveApply[0]->no_of_leave }}">
								<input type="hidden" name="leave_type" value="{{ $LeaveApply[0]->leave_type}}">
							
                                <input type="hidden" name="month_yr" value="{{ date("Y", strtotime($LeaveApply[0]->from_date))}}">
								
								<div class="col-md-4 emp-desc">Employee Code: <span>{{ $LeaveApply[0]->employee_id }}</span></div>
								<div class="col-md-4 emp-desc">Employee Name: <span>{{ $LeaveApply[0]->employee_name }}</span></div>
                                <div class="col-md-4 emp-desc">Leave Type: <span>{{ $LeaveApply[0]->leave_type_name }}</span></div>
							        <div class="col-md-4 emp-desc">Leave Status: <span>{{ $LeaveApply[0]->status }}</span><input type="hidden" id="current_status" value="{{ $LeaveApply[0]->status }}"></div>
                                        <div class="col-md-4 emp-desc">No. of Leave: <span>{{ $LeaveApply[0]->no_of_leave }}</span>
                                        </div>
                                        <div class="col-md-4 emp-desc">From Date: <span>{{ $leaveapplyfromDate = date("d-m-Y", strtotime($LeaveApply[0]->from_date)) }}</span>
                                        </div>
                                        <div class="col-md-4 emp-desc">To Date: <span>{{ $leaveapplytoDate = date("d-m-Y", strtotime($LeaveApply[0]->to_date)) }}</span>
                                        </div>
										 <div class="col-md-4 emp-desc">Total Number Of  <?php echo ucfirst(strtolower($LeaveApply[0]->leave_type_name)); ?> Taken : <span><?php if(!empty($totleave->no_of_leave)){ echo $totleave->no_of_leave;}else{ echo '0';} ?></span>
                                        </div>
                                        @if($LeaveApply[0]->leave_type_name == 'MEDICAL LEAVE')
                                        <div class="col-md-4 emp-desc">Uploaded Document: <span><iframe src="{{ url('/') }}/storage/app/{{ $LeaveApply[0]->doc_image }}" alt="No Certificate Available" width="50%" height="20%"></iframe> </span>
                                        </div>
                                        @elseif($LeaveApply[0]->leave_type_name == 'CASUAL LEAVE')
                                        <div class="col-md-4 emp-desc">CL Type: <span>{{ ucfirst($LeaveApply[0]->half_cl) }}</span>
                                            <input type="hidden" name="half_cl" value="{{ $LeaveApply[0]->half_cl }}">
                                        </div>
                                        @endif
								
								</div>
                                <div class="emp-descp-main">
                                    <div class="table-stats order-table ov-h">

                                        <table class="table table-responsive">
                                            <thead style="width: 100%">
                                                <tr>
                                                    <th colspan="8" style="text-align:center;">LIST OF LAST FOUR APPROVED LEAVE
                                                </tr>
                                                <tr>
                                                    <th class="serial" style="text-align:center; width: 20% !important;">SL. No.</th>
                                                    <th style="text-align:center; width: 20% !important;">FROM DATE</th>
                                                    <th style="text-align:center; width: 20% !important;">TO DATE</th>
													  <th style="text-align:center; width: 20% !important;">Date of Application</th>
                                                    <th style="text-align:center; width: 20% !important;">No. of Leave</th>
                                                    <th style="text-align:center; width: 20% !important;">Approved Date</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                @foreach($Prev_leave as $lvapply)
                                                
                                                <tr>
                                                    <td class="serial" style="text-align:center;">{{$loop->iteration}}</td>
                                                    <td style="text-align:center;"><span class="product">{{\Carbon\Carbon::parse($lvapply->from_date)->format('d/m/Y')}}</span></td>
                                                    <td style="text-align:center;"><span class="product">{{\Carbon\Carbon::parse($lvapply->to_date)->format('d/m/Y')}}</span></td>
                                                    <td style="text-align:center;"><span class="date">{{\Carbon\Carbon::parse($lvapply->date_of_apply)->format('d/m/Y')}}</span></td>
													 <td style="text-align:center;"><span class="date">{{ $lvapply->no_of_leave }}</span></td>
                                                    <td style="text-align:center;"><span class="name">{{\Carbon\Carbon::parse($lvapply->updated_at)->format('d/m/Y')}}</span></td>
                                                    
                                                </tr>
                                             @endforeach
                                            </tbody>
                                        </table>
                                    
                                    </div> 
                                </div>						
	
                                    
                                    <div class="row form-group" style="margin-top:15px;margin-top: 15px;width: 71%;MARGIN: 0 AUTO;background: #e2e2e2;PADDING: 10PX 5PX;">
                                        <div class="col-md-4" style="text-align:right;">
                                        <label for="email-input" class=" form-control-label">Leave Status (*)</label>
                                    </div>
                                    <div class="col-md-5">
                                        
										<select class="form-control" name="leave_check" id="leave_status" onchange="remarkStatus();" required>
												<option value="" selected disabled>Select</option>
                                                <option value="APPROVED" <?php  if($LeaveApply[0]->status!=''){  if($LeaveApply[0]->status=='APPROVED'){ echo 'selected';} } ?> >Approved</option>
                                                <option value="RECOMMENDED" <?php  if($LeaveApply[0]->status!=''){  if($LeaveApply[0]->status=='RECOMMENDED'){ echo 'selected';} } ?> >Recommended</option>
                                                <option  value="REJECTED" <?php  if($LeaveApply[0]->status!=''){  if($LeaveApply[0]->status=='REJECTED'){ echo 'selected';} } ?> >Rejected</option>
                                                <option  value="CANCEL" <?php  if($LeaveApply[0]->status!=''){  if($LeaveApply[0]->status=='CANCEL'){ echo 'selected';} } ?> >Cancel</option>
										</select>
											@if ($errors->has('leave_type'))
											<div class="error" style="color:red;">{{ $errors->first('leave_type') }}</div>
											@endif
									</div>                                       
                                   
                                    <div class="row col-md-9" id="remark_status" style="padding-left: 102px;padding-right:0; display:none;">
                                        <div class="col-md-4" style="text-align: right;">
                                            <label>Remarks</label>
                                        </div>
                                            <div class="col-md-8" style="padding-right: 0;">                                      
                                                <textarea rows="4" class="form-control" name="status_remarks" ><?php if(!empty($LeaveApply[0]->status_remarks)){ echo $LeaveApply[0]->status_remarks;} ?></textarea>   
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