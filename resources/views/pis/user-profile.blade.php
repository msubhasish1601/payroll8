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
<style>
body{padding:0 !important;}
ul{list-style:none;}
.content{background:#fff;}.user-head {margin-top: 85px;}
.user-head {position:relative;margin-top: 85px;background-image: linear-gradient(#5F5661, #547591);color: #fff;padding: 19px 0;}
.prof-img {top:5px;z-index: 9;}.prof-img img{width: 199px;}.prof-name{padding-left:15%;}.prof-name p {color: #fff;margin:0;}.prof-name ul{list-style:none;}.prof-name h4 {margin-bottom: 11px;}.prof-name ul li{font-size:14px;}.prof-name ul li i {color: #8cdbf7;}.chng p {float: right;} .chng p a{color:#fff;}.chng p a i {color: #fff;background: #8cdbf7;height: 24px;width: 24px;padding: 3px 6px;border-radius: 50%;}.prof-name p i {color: #8adbf7;}.details {background: #e4e5e6;}.personal {margin-bottom:25px;background: #fff;position: absolute;top: -72px;padding: 8px 18px;border-radius: 3px;margin-left: 14%;}.per-head h4 {font-size: 18px;}.per-head h4 i {color: #F7AE61;padding-right: 10px;}.per-body {border-bottom: 1px solid #eaeaea;padding-bottom: 13px;margin-bottom:15px;margin-top: 15px; }.per-body p{margin:0;font-size: 13px;color: #444242;}.per-body p.ans{color:#0872bf;}.per-body:last-child{border-bottom::none;}.pay-details h4 {font-size: 18px;margin-bottom: 15px;}.pay-details {margin-top: -20px;background: #fff;padding: 13px;width: 199px;}.pay-details h4 i {color: #33bf08;}.pay-details ul li {font-size: 13px;line-height:25px;}.pay-details ul li span{color:#0872bf;padding-left:7px;}
</style>




<!-------------------user-profile----------------------->
<div class="user-head">
	<div class="container">
		@if(Session::has('message'))										
		<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
		@endif	
		<div class="row">
			<div class="col-md-12 chng"><p><a href="#" data-toggle="modal" data-target="#myModal"><i class="fa fa-unlock" aria-hidden="true"></i> Change Password</a></p></div>
		</div>
		<div class="row">
			<div class="col-md-8">
				<div class="prof-name">
					<h4><?php echo $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname;  ?></h4>
					<p><i class="fa fa-user-circle-o" aria-hidden="true"></i><?php echo $employee->emp_designation;  ?></p>
					<p><i class="fa fa-eye" aria-hidden="true"></i> <?php echo $employee->emp_department;  ?></p>
					
					<ul>
						<li><i class="fa fa-phone-square" aria-hidden="true"></i> <?php echo $employee->emp_pr_mobile;  ?></li>
						
					</ul>
				</div>
			</div>
			<div class="col-md-4">
				<div class="prof-img">
					<?php if(!empty($employee->emp_image)){ ?>
					<img src="{{ url('/') }}/storage/app/{{ $employee->emp_image }}" alt="">
				    <?php }else{ ?>
				    <img src="{{ asset('images/img/prof.png')}}" alt="">
				    <?php } ?>	
				</div>
			</div>
		</div>
	</div>
</div>
<!----------------------------------------------->


<!-----------------------details--------------------->
<div class="details" style="margin-top: 20px;">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="personal">
					<div class="per-head">
						<h4><i class="fa fa-male" aria-hidden="true"></i> Personal Details</h4>
					</div>
					
					<div class="row per-body">
						<div class="col-md-4"><p>Employee Code:</p></div>
						<div class="col-md-8"><p class="ans"><?php echo $employee->emp_code; ?></p></div>
						
						
						<div class="col-md-4"><p>Father's Name:</p></div>
						<div class="col-md-8"><p class="ans"><?php echo $employee->emp_father_name; ?></p></div>
						
						<div class="col-md-4"><p>Date of Birth:</p></div>
						<div class="col-md-8"><p class="ans"><?php echo date_format(date_create($employee->emp_dob),"d/m/Y"); ?></p></div>
					</div>
					
				<!----------------------service-details---------------------->	
					<div class="per-head">
						<h4><i class="fa fa-server" aria-hidden="true" style="color: #b161f7;"></i> Service Details</h4>
					</div>
					
					
					<div class="row per-body">
						<div class="col-md-4"><p>Date of Joining:</p></div>
						<div class="col-md-8"><p class="ans"><?php echo date_format(date_create($employee->emp_doj),"d/m/Y"); ?></p></div>
						
						<div class="col-md-4"><p>Next Increament Date:</p></div>
						<div class="col-md-8"><p class="ans"><?php echo date_format(date_create($employee->emp_next_increament_date),"d/m/Y"); ?></p></div>
						
						<div class="col-md-4"><p>Date of Retirement:</p></div>
						<div class="col-md-8"><p class="ans"><?php echo date_format(date_create($employee->emp_retirement_date),"d/m/Y"); ?></p></div>
						
						<div class="col-md-4"><p>Employee Type:</p></div>
						<div class="col-md-8"><p class="ans"><?php echo $employee->emp_status; ?></p></div>
					</div>
			<!------------------------------------------------->
				
				<!--------------------------permanent-address--------------->
				<div class="per-head">
						<h4><i class="fa fa-map-marker" aria-hidden="true" style="color: #e0b40a;"></i> Permanent Address</h4>
					</div>
				<div class="row per-body">
						<div class="col-md-4"><p>Street No. and Name:</p></div>
						<div class="col-md-8"><p class="ans"><?php echo $employee->emp_pr_street_no; ?></p></div>
						
						<div class="col-md-4"><p>Village:</p></div>
						<div class="col-md-8"><p class="ans"><?php echo $employee->emp_per_village; ?></p></div>
						
						<div class="col-md-4"><p>City:</p></div>
						<div class="col-md-8"><p class="ans"><?php echo $employee->emp_pr_city; ?></p></div>
						
						<div class="col-md-4"><p>Post Office:</p></div>
						<div class="col-md-8"><p class="ans"><?php echo $employee->emp_per_post_office; ?></p></div>
						
						<div class="col-md-4"><p>Police Station:</p></div>
						<div class="col-md-8"><p class="ans"><?php echo $employee->emp_per_policestation; ?></p></div>
						
						<div class="col-md-4"><p>Pin Code:</p></div>
						<div class="col-md-8"><p class="ans"><?php echo $employee->emp_pr_pincode; ?></p></div>
						
						<div class="col-md-4"><p>District:</p></div>
						<div class="col-md-8"><p class="ans"><?php echo $employee->emp_per_dist; ?></p></div>
						
						<div class="col-md-4"><p>State:</p></div>
						<div class="col-md-8"><p class="ans"><?php echo $employee->emp_pr_state; ?></p></div>
						
						<div class="col-md-4"><p>Country:</p></div>
						<div class="col-md-8"><p class="ans"><?php echo $employee->emp_pr_country; ?></p></div>
					</div>
				
				<!------------------------------------------>
				
				
				<!------------------------Present-address------------------>
				<div class="per-head">
						<h4><i class="fa fa-map-marker" aria-hidden="true" style="color: #d67b07;"></i> Present Address</h4>
					</div>
				<div class="row per-body" style="border-bottom:none;">
						<div class="col-md-4"><p>Street No. and Name:</p></div>
						<div class="col-md-8"><p class="ans"><?php echo $employee->emp_ps_street_no; ?></p></div>
						
						<div class="col-md-4"><p>Village:</p></div>
						<div class="col-md-8"><p class="ans"><?php echo $employee->emp_ps_village; ?></p></div>
						
						<div class="col-md-4"><p>City:</p></div>
						<div class="col-md-8"><p class="ans"><?php echo $employee->emp_ps_city; ?></p></div>
						
						<div class="col-md-4"><p>Post Office:</p></div>
						<div class="col-md-8"><p class="ans"><?php echo $employee->emp_ps_post_office; ?></p></div>
						
						<div class="col-md-4"><p>Police Station:</p></div>
						<div class="col-md-8"><p class="ans"><?php echo $employee->emp_ps_policestation; ?></p></div>
						
						<div class="col-md-4"><p>Pin Code:</p></div>
						<div class="col-md-8"><p class="ans"><?php echo $employee->emp_ps_pincode; ?></p></div>
						
						<div class="col-md-4"><p>District:</p></div>
						<div class="col-md-8"><p class="ans"><?php echo $employee->emp_ps_dist; ?></p></div>
						
						<div class="col-md-4"><p>State:</p></div>
						<div class="col-md-8"><p class="ans"><?php echo $employee->emp_ps_state; ?></p></div>
						
						<div class="col-md-4"><p>Country:</p></div>
						<div class="col-md-8"><p class="ans"><?php echo $employee->emp_ps_country; ?></p></div>
					</div>
				
				<!---------------------------------------------------->
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="pay-details">
				<h4><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Pay Details</h4>
				
				<ul>
					<li>Pay Level: <span><?php echo $employee->emp_pay_scale; ?></span></li>
					<li>Basic Pay: <span><?php echo $employee_pay_structure->basic_pay; ?></span></li>
					<li>PF Type: <span><?php echo strtoupper($employee->emp_pf_type); ?></span></li>
					<li>PF/PRAN No.: <span><?php echo $employee->emp_pf_no; ?></span></li>
					
				</ul>
			</div>
			
			<div class="pay-details" style="margin-top:15px;">
				<h4><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Authority Details</h4>
				
				<ul>
					<li>Reporting Authority: <span><?php 
					
					 $employee_re=DB::table('employees')->where('emp_code','=',$employee->emp_reporting_auth)->first();
					if(!empty($employee_re)){
					echo $employee_re->emp_fname.$employee_re->emp_mname.$employee_re->emp_lname;} ?></span></li>
					<li>Leave Sanctioning Authority: <span><?php $employee_sa=DB::table('employees')->where('emp_code','=',$employee->emp_lv_sanc_auth)->first();
					if(!empty($employee_sa)){
					echo $employee_sa->emp_fname.$employee_sa->emp_mname.$employee_sa->emp_lname;}  ?></span></li>
					
					
				</ul>
			</div>
			
			<div class="pay-details" style="margin-top:15px;">
				<h4><i class="fa fa-university" aria-hidden="true" style="color:#f35304;"></i> Bank Details</h4>
				<ul>
					<li>Bank Name: <span><?php echo $bank_name->master_bank_name; ?></span></li>
					<li>A/C No.: <span><?php echo $employee->emp_account_no; ?></span></li>
					<li>IFSC Code: <span><?php echo $employee->emp_ifsc_code; ?></span></li>
					
				</ul>
			</div>
			
			<div class="pay-details" style="margin-top:15px;">
				<h4><i class="fa fa-user" aria-hidden="true" style="color:#f35304;"></i> Role</h4>
				<?php if(!empty($module_name)){ ?>
				<p style="color: #000;font-size: 14px;"><?php echo $module_name; ?></p>
			    <?php } ?>
			</div>
		</div>
	</div>
</div>
</div>
<!----------------------------------->


<!------------------change-password-modal------------------>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="border:none;">
      <div class="modal-header" style=" background: #1093bd;color: #fff;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="font-size: 15px;">Change Password</h4>
      </div>
      <div class="modal-body" style="margin: 15px;">
        <form action="{{ url('pis/change-password') }}" method="post" enctype="">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="form-group">
				<label>Old Password</label>
				<input type="password" name="old_password" class="form-control">
			</div>
			<div class="form-group">
				<label>New Password</label>
				<input type="password" name="new_password" class="form-control">
			</div>
			<div class="form-group">
				<label>Confirm Password</label>
				<input type="password" name="confirm_password" class="form-control">
			</div>
			<div class="form-group">
			<button type="submit" class="btn btn-default" style="background: #d2580f;color: #fff;">Submit</button>

			</div>
		</form>
      </div>
    <!--<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>-->
    </div>

  </div>
</div>

<!------------------------------------------------>
@endsection


@section('scripts')
 @include('partials.scripts')
@endsection