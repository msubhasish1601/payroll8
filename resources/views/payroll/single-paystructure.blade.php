@extends('employee.layouts.master')

@section('title')
Employee Information System-Employees
@endsection

@section('sidebar')
	@include('employee.partials.sidebar')
@endsection

@section('header')
	@include('employee.partials.header')
@endsection


@section('content')
<!-- <style>
	.left select {
	    width: 100px;
	}
	.right{float:right;}
	.right select {
	    width: 100px;

	}
	.card-body.card-block span{color:#000;}
	.main-card legend {
	    color: #fff;
	    background: #1c9ac5;
	    padding: 0 15px;
	}
	.demo {
	    width: 75%;
	    margin: 15px auto;
	    background: #e2e1e1;
	    padding: 15px;
	}
	.demo .form-control{/*width:170px;*/}
	.pd-0{padding:0;}
	.sal {
	    background: #e0e0e0;
	    padding: 7px 15px 1px;
	    margin-bottom: 15px;
	}
</style> -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
	<div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title">Employee Pay Structure Generation</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
							<li><a href="#">Employee</a></li>
                                <li>/</li>
                                <li><a href="#">Pay Structure</a></li>
                                <li>/</li>
                                <li class="active">Add Employee Pay Structure</li>
						
                            </ul>
                        </span>
</div>
</div>

      <!-- Widgets  -->
      <div class="row">
        <div class="main-card">
          <div class="card">
            <!-- <div class="card-header"> <strong>Employee Pay Structure Generation</strong> </div> -->
            	<!-- @if(Session::has('message'))
				<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em ><i class="fa fa-check"></i> {{ Session::get('message') }}</em></div>
				@endif -->
				@include('include.messages')
            <div class="card-body card-block">
              <form action="{{ url('save-paystructure') }}"  method="post">
                  {{ csrf_field() }}

				<div class="row form-group demo">
				  	<div class="col-sm-12">
						<label>Employee Name</label>
						<div class="empnamediv">
		                    <select id="emp_code" name="emp_code" onchange="getEmpId(this.value);" class="form-control employee"  required>
		                        <option selected disabled value="">Select</option>
		                        @foreach($employee as $emp)
		                        	<option value="{{$emp->emp_code}}">{{($emp->emp_fname . ' '. $emp->emp_mname.' '.$emp->emp_lname)}} - {{$emp->emp_code}}</option>
		                        @endforeach
							</select>
						</div>
					</div>
				</div>


				<div class="row form-group">
	<input class="demo-1" id="month_yr" type="hidden" value="<?php $dt = date('Y-m-d');
																							$yrdata = strtotime($dt);
																							echo date('M Y', $yrdata); ?>" name="month_yr" placeholder="<?php $dt = date('Y-m-d');
																																																			$yrdata = strtotime($dt);
																																																			echo date('M Y', $yrdata); ?>" readonly="1" />

				  <div class="col-md-4">
				  	<label for="text-input" class=" form-control-label">Employee Name</span></label>
                    <input type="text" id="emp_name" readonly="" name="emp_name" class="form-control" required>
				  </div>
                  <div class="col-md-4">
                    <label class=" form-control-label">Designation</label>
                    <input type="text" id="emp_designation" readonly="" name="emp_designation" class="form-control" required>
                  </div>
                   <div class="col-md-4">
						<label>Basic Pay</label>
                        <input type="text"  readonly id="emp_basic_pay" name="emp_basic_pay" class="form-control" required>
					</div>
                </div>

				<div class="row form-group">
				<div class="col-md-12">
					<legend>Calculate Earning Part</legend>
				</div>
					<div class="col-md-3">
									<label>DA</label>
									<input readonly="1" type="text" id="emp_actual_da" name="emp_actual_da" class="form-control" onblur="OnblurCalculateAddition();">
								</div>
								<div class="col-md-3">
									<label>VDA</label>
									<input readonly="1" type="text" id="emp_actual_vda" name="emp_actual_vda" class="form-control" onblur="OnblurCalculateAddition();">
								</div>
								<div class="col-md-3">
									<label>HRA</label>
									<input readonly="1" type="text" id="emp_actual_hra" name="emp_actual_hra" class="form-control" onblur="OnblurCalculateAddition();">
								</div>
								<div class="col-md-3">
									<label>TIFF ALW.</label>
									<input readonly="1" type="text" id="emp_actual_tiff_alw" name="emp_actual_tiff_alw" class="form-control" onblur="OnblurCalculateAddition();">
								</div>
				</div>

				<div class="row form-group">

					<div class="col-md-3">
									<label>OTH ALW</label>
									<input  type="text" id="emp_actual_others_alw" name="emp_actual_others_alw" class="form-control" readonly="1" onblur="OnblurCalculateAddition();">
								</div>
								<div class="col-md-3">
									<label>CONV</label>
									<input  type="text" id="emp_actual_conv" name="emp_actual_conv" class="form-control" readonly="1" onblur="OnblurCalculateAddition();" >
								</div>
								<div class="col-md-3">
									<label>MEDICAL</label>
									<input  type="text" id="emp_actual_medical" name="emp_actual_medical" class="form-control" readonly="1" onblur="OnblurCalculateAddition();" >
								</div>
								<div class="col-md-3">
									<label>	MISC ALW</label>
									<input  type="text" id="emp_actual_misc_alw" name="emp_actual_misc_alw" class="form-control" readonly="1" onblur="OnblurCalculateAddition();" >
								</div>
				</div>

				<div class="row form-group">

					<div class="col-md-3">
									<label>	OVER TIME</label>
									<input  type="text" id="emp_actual_over_time" name="emp_actual_over_time" class="form-control" readonly="1"  onblur="OnblurCalculateAddition();">
								</div>
	<div class="col-md-3">
									<label>BONUS</label>
									<input readonly="1"   type="text" name="emp_actual_bouns" id="emp_actual_bouns" class="form-control" onblur="OnblurCalculateAddition();">
								</div>
								<div class="col-md-3">
									<label>LEAVE ENC</label>
									<input type="text" id="emp_actual_leave_inc" name="emp_actual_leave_inc" class="form-control" readonly="1"  onblur="OnblurCalculateAddition();">
								</div>
								<div class="col-md-3">
									<label>HTA</label>
									<input  type="text" id="emp_actual_hta" name="emp_actual_hta" class="form-control" readonly="1" onblur="OnblurCalculateAddition();" > 
								</div>
								
								<div class="col-md-3">
									<label>Others</label>
									<input onblur="OnblurCalculateAddition();"  name="emp_actual_others_addition" id="emp_actual_others_addition" type="text" class="form-control">
								</div>
                  </div>




				<div class="sal">
				<div class="row form-group">
					<div class="col-md-4">
						<label>Gross Salary</label>
                        <input type="text" id="emp_actual_gross_salary" name="emp_actual_gross_salary" class="form-control" readonly="1">
					</div>

				</div>
				</div>
                <button type="submit" class="btn btn-danger btn-sm">Save</button>

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
@include('employee.partials.scripts')
@endsection




  <script type="text/javascript">

var transport_allowance=0;
var cess=0;


function getEmpId(empid){

        var month_yr=$("#month_yr").val();
        var d = new Date(month_yr);
        var currentMonth=(d.getMonth()-1);
        var monthCount = currentMonth.toString().length;

        var current_month_days= new Date(d.getFullYear(), (d.getMonth()+1), 0).getDate();

        if(monthCount=1){
        	var monthYR='0'+(d.getMonth()-1)+'/'+d.getFullYear();

        }else{

        	var monthYR=(d.getMonth()-1)+'/'+d.getFullYear();
        }


		$.ajax({
		type:'GET',
	url:'{{url('payroll/getEmployeePayrollById')}}/'+empid+'/'+monthYR,
        cache: false,
		success: function(response){

	        var obj = jQuery.parseJSON( response );
	        //console.log(obj[0].emp_physical_status);
		    var basicpay=obj[0].basic_pay;

		    var calculate_basic_salary=0;

			var emp_da=0;
			var emp_vda=0;
			var emp_hra=0;
			var emp_prof_tax=0;
			var emp_others_alw=0;
			var emp_tiff_alw=0;
			var emp_conv =0;
			var emp_medical=0;
			var emp_misc_alw=0;
			var emp_over_time=0;
			var emp_bouns=0;
			var emp_co_op=0;
			var emp_pf=0;
			var emp_pf_int=0;
			var emp_apf=0;
			var emp_i_tax=0;
			var emp_insu_prem=0;
			var emp_pf_loan=0;
			var emp_esi = 0;
			var emp_adv = 0;
             var emp_hrd = 0;
			  var emp_furniture = 0;
			   var emp_misc_ded = 0;
			    var emp_hta = 0;



	        $("#emp_code option:selected").val(empid);
			$("#emp_name").val(obj[0].emp_fname+' '+obj[0].emp_mname+' '+obj[0].emp_lname);
			$("#emp_designation").val(obj[0].emp_designation);

			
			$("#emp_basic_pay").val(basicpay);

			var basic = $('#emp_basic_pay').val();

			
			for (var j = 0; j < obj[3].length; j++)
			{

			      if(obj[3][j].rate_id=='1'){
    if(obj[0].da=='1')
			      {
				  if(obj[3][j].inpercentage!='0'){
				   emp_da=Math.round(basic*obj[3][j].inpercentage/100);
			        $("#emp_actual_da").val(emp_da);
					
				  }else{
				  
				  
				       		if((basic<=obj[3][j].max_basic) && (basic>=obj[3][j].min_basic)){

					          $("#emp_actual_da").val(obj[3][j].inrupees);

					        }
				  }
				  
				   $("#emp_actual_da").prop("readonly", true);
				  
				  }else if(obj[0].da!=null){
					  
				    $("#emp_actual_da").val(obj[0].da);
					 $("#emp_actual_da").prop("readonly", false);
				  
				  }else{
				  emp_da=0;
				
				  $("#emp_actual_da").val(emp_da);
				   $("#emp_actual_da").prop("readonly", true);
				  }
				 
			}else if(obj[3][j].rate_id=='2'){
				 if(obj[0].vda=='1')
			      {
				  if(obj[3][j].inpercentage!='0'){
				   emp_vda=Math.round(basic*obj[3][j].inpercentage/100);
			        $("#emp_actual_vda").val(emp_vda);
				  }else{
				  
				  
				       		if((basic<=obj[3][j].max_basic) && (basic>=obj[3][j].min_basic)){

					          $("#emp_actual_vda").val(obj[3][j].inrupees);

					        }
				  }
				  
				   $("#emp_actual_vda").prop("readonly", true);
				  
				  }else if(obj[0].vda!=null){
				    $("#emp_actual_vda").val(obj[0].vda);
				   $("#emp_actual_vda").prop("readonly", false);
				  }else{
				  emp_vda=0;
				  $("#emp_actual_vda").val(emp_vda);
				   $("#emp_actual_vda").prop("readonly", true);
				  }
				
			}else if(obj[3][j].rate_id=='3'){
				
				 if(obj[0].hra=='1')
			      {
					 
				  if(obj[3][j].inpercentage!='0'){
					   
				   emp_hra=Math.round(basic*obj[3][j].inpercentage/100);
			        $("#emp_actual_hra").val(emp_hra);
				  }else{
				  
				  
				       		if((basic<=obj[3][j].max_basic) && (basic>=obj[3][j].min_basic)){

					          $("#emp_actual_hra").val(obj[3][j].inrupees);

					        }
				  }
				  
				   $("#emp_actual_hra").prop("readonly", true);
				  
				  }else if(obj[0].hra!=null){
				    $("#emp_actual_hra").val(obj[0].hra);
				   $("#emp_actual_hra").prop("readonly", false);
				  }else{
				  emp_hra=0;
				  $("#emp_actual_hra").val(emp_hra);
				   $("#emp_actual_hra").prop("readonly", true);
				  }
				 
			}else if(obj[3][j].rate_id=='5'){
				 if(obj[0].others_alw=='1')
			      {
				  if(obj[3][j].inpercentage!='0'){
				   emp_others_alw=Math.round(basic*obj[3][j].inpercentage/100);
			        $("#emp_actual_others_alw").val(emp_others_alw);
				  }else{
				  
				  
				       		if((basic<=obj[3][j].max_basic) && (basic>=obj[3][j].min_basic)){

					          $("#emp_actual_others_alw").val(obj[3][j].inrupees);

					        }
				  }
				  
				  
				   $("#emp_actual_others_alw").prop("readonly", true);
				  }else if(obj[0].others_alw!=null){
				    $("#emp_actual_others_alw").val(obj[0].others_alw);
				   $("#emp_actual_others_alw").prop("readonly", false);
				  }else{
				  emp_others_alw=0;
				  $("#emp_actual_others_alw").val(emp_others_alw);
				   $("#emp_actual_others_alw").prop("readonly", true);
				  }
				 
			}else if(obj[3][j].rate_id=='6'){
				 if(obj[0].tiff_alw=='1')
			      {
				  if(obj[3][j].inpercentage!='0'){
				   emp_tiff_alw=Math.round(basic*obj[3][j].inpercentage/100);
			        $("#emp_actual_tiff_alw").val(emp_tiff_alw);
				  }else{
				  
				  
				       		if((basic<=obj[3][j].max_basic) && (basic>=obj[3][j].min_basic)){

					          $("#emp_actual_tiff_alw").val(obj[3][j].inrupees);

					        }
				  }
				   $("#emp_actual_tiff_alw").prop("readonly", true);
				  
				  
				  }else if(obj[0].tiff_alw!=null){
				    $("#emp_actual_tiff_alw").val(obj[0].tiff_alw);
				   $("#emp_actual_tiff_alw").prop("readonly", false);
				  }else{
				  emp_tiff_alw=0;
				  $("#emp_actual_tiff_alw").val(emp_tiff_alw);
				   $("#emp_actual_tiff_alw").prop("readonly", true);
				  }
				 
			}else if(obj[3][j].rate_id=='7'){
				 if(obj[0].conv=='1')
			      {
				  if(obj[3][j].inpercentage!='0'){
				   emp_conv=Math.round(basic*obj[3][j].inpercentage/100);
			        $("#emp_actual_conv").val(emp_conv);
				  }else{
				  
				  
				       		if((basic<=obj[3][j].max_basic) && (basic>=obj[3][j].min_basic)){

					          $("#emp_actual_conv").val(obj[3][j].inrupees);

					        }
				  }
				  
				   $("#emp_actual_conv").prop("readonly", true);
				  
				  }else if(obj[0].conv!=null){
				    $("#emp_actual_conv").val(obj[0].conv);
				   $("#emp_actual_conv").prop("readonly", false);
				  }else{
				  emp_conv=0;
				  $("#emp_actual_conv").val(emp_conv);
				   $("#emp_actual_conv").prop("readonly", true);
				  }
				 
			}else if(obj[3][j].rate_id=='8'){
				 if(obj[0].medical=='1')
			      {
				  if(obj[3][j].inpercentage!='0'){
				   emp_medical=Math.round(basic*obj[3][j].inpercentage/100);
			        $("#emp_actual_medical").val(emp_medical);
				  }else{
				  
				  
				       		if((basic<=obj[3][j].max_basic) && (basic>=obj[3][j].min_basic)){

					          $("#emp_actual_medical").val(obj[3][j].inrupees);

					        }
				  }
				  
				   $("#emp_actual_medical").prop("readonly", true);
				  
				  }else if(obj[0].medical!=null){
				    $("#emp_actual_medical").val(obj[0].medical);
				   $("#emp_actual_medical").prop("readonly", false);
				  }else{
				  emp_medical=0;
				  $("#emp_actual_medical").val(emp_medical);
				   $("#emp_actual_medical").prop("readonly", true);
				  }
				 
			}else if(obj[3][j].rate_id=='9'){
				 if(obj[0].misc_alw=='1')
			      {
				  if(obj[3][j].inpercentage!='0'){
				   emp_misc_alw=Math.round(basic*obj[3][j].inpercentage/100);
			        $("#emp_actual_misc_alw").val(emp_misc_alw);
				  }else{
				  
				  
				       		if((basic<=obj[3][j].max_basic) && (basic>=obj[3][j].min_basic)){

					          $("#emp_actual_misc_alw").val(obj[3][j].inrupees);

					        }
				  }
				  
				   $("#emp_actual_misc_alw").prop("readonly", true);
				  
				  }else if(obj[0].misc_alw!=null){
				    $("#emp_actual_misc_alw").val(obj[0].misc_alw);
				   $("#emp_actual_misc_alw").prop("readonly", false);
				  }else{
				  emp_misc_alw=0;
				  $("#emp_actual_misc_alw").val(emp_misc_alw);
				   $("#emp_actual_misc_alw").prop("readonly", true);
				  }
				 
			}else if(obj[3][j].rate_id=='10'){
				 if(obj[0].over_time=='1')
			      {
				  if(obj[3][j].inpercentage!='0'){
				   emp_over_time=Math.round(basic*obj[3][j].inpercentage/100);
			        $("#emp_actual_over_time").val(emp_over_time);
				  }else{
				  
				  
				       		if((basic<=obj[3][j].max_basic) && (basic>=obj[3][j].min_basic)){

					          $("#emp_actual_over_time").val(obj[3][j].inrupees);

					        }
				  }
				  
				   $("#emp_actual_over_time").prop("readonly", true);
				  
				  }else if(obj[0].over_time!=null){
				    $("#emp_actual_over_time").val(obj[0].over_time);
				   $("#emp_actual_over_time").prop("readonly", false);
				  }else{
				  emp_over_time=0;
				  $("#emp_actual_over_time").val(emp_over_time);
				   $("#emp_actual_over_time").prop("readonly", true);
				  }
				 
			}else if(obj[3][j].rate_id=='11'){
				 if(obj[0].bouns=='1')
			      {
				  if(obj[3][j].inpercentage!='0'){
				   emp_bouns=Math.round(basic*obj[3][j].inpercentage/100);
			        $("#emp_actual_bouns").val(emp_bouns);
				  }else{
				  
				  
				       		if((basic<=obj[3][j].max_basic) && (basic>=obj[3][j].min_basic)){

					          $("#emp_actual_bouns").val(obj[3][j].inrupees);

					        }
				  }
				  
				  
				    $("#emp_actual_bouns").prop("readonly", true);
				  }else if(obj[0].bouns!=null){
				    $("#emp_actual_bouns").val(obj[0].bouns);
				  $("#emp_actual_bouns").prop("readonly", false);
				  }else{
				  emp_bouns=0;
				  $("#emp_actual_bouns").val(emp_bouns);
				    $("#emp_actual_bouns").prop("readonly", true);
				  }
				 
			}else if(obj[3][j].rate_id=='12'){
				 if(obj[0].leave_inc=='1')
			      {
				  if(obj[3][j].inpercentage!='0'){
				   emp_leave_inc=Math.round(basic*obj[3][j].inpercentage/100);
			        $("#emp_actual_leave_inc").val(emp_leave_inc);
				  }else{
				  
				  
				       		if((basic<=obj[3][j].max_basic) && (basic>=obj[3][j].min_basic)){

					          $("#emp_actual_leave_inc").val(obj[3][j].inrupees);

					        }
				  }
				  
				  
				    $("#emp_actual_leave_inc").prop("readonly", true);
				  }else if(obj[0].leave_inc!=null){
				    $("#emp_actual_leave_inc").val(obj[0].leave_inc);
				    $("#emp_actual_leave_inc").prop("readonly", false);
				  }else{
				  emp_leave_inc=0;
				  $("#emp_actual_leave_inc").val(emp_leave_inc);
				    $("#emp_actual_leave_inc").prop("readonly", true);
				  }
				 
			}else if(obj[3][j].rate_id=='13'){
			 if(obj[0].hta=='1')
			      {
				  if(obj[3][j].inpercentage!='0'){
				   emp_hta=Math.round(basic*obj[3][j].inpercentage/100);
			        $("#emp_actual_hta").val(emp_hta);
				  }else{
				  
				  
				       		if((basic<=obj[3][j].max_basic) && (basic>=obj[3][j].min_basic)){

					          $("#emp_actual_hta").val(obj[3][j].inrupees);

					        }
				  }
				  
				    $("#emp_actual_hta").prop("readonly", true);
				  
				  }else if(obj[0].hta!=null){
				    $("#emp_actual_hta").val(obj[0].hta);
					  $("#emp_actual_hta").prop("readonly", false);
				  
				  }else{
				  emp_hta=0;
				  $("#emp_actual_hta").val(emp_hta);
				    $("#emp_actual_hta").prop("readonly", true);
				  }
				 
			}else if(obj[3][j].rate_id=='15'){
				 if(obj[0].pf=='1')
			      {
				  if(obj[3][j].inpercentage!='0'){
				   emp_pf=Math.round(basic*obj[3][j].inpercentage/100);
			        $("#emp_actual_pf").val(emp_pf);
				  }else{
				  
				  
				       		if((basic<=obj[3][j].max_basic) && (basic>=obj[3][j].min_basic)){

					          $("#emp_actual_pf").val(obj[3][j].inrupees);

					        }
				  }
				  
				    $("#emp_actual_pf").prop("readonly", true);
				  
				  }else if(obj[0].pf!=null){
				    $("#emp_actual_pf").val(obj[0].pf);
				   $("#emp_actual_pf").prop("readonly", false);
				  
				  }else{
				  emp_pf=0;
				  $("#emp_actual_pf").val(emp_pf);
				   $("#emp_actual_pf").prop("readonly", true);
				  }
				 
			}else if(obj[3][j].rate_id=='16'){
				 if(obj[0].pf_int=='1')
			      {
				  if(obj[3][j].inpercentage!='0'){
				   emp_pf_int=Math.round(basic*obj[3][j].inpercentage/100);
			        $("#emp_actual_pf_int").val(emp_pf_int);
				  }else{
				  
				  
				       		if((basic<=obj[3][j].max_basic) && (basic>=obj[3][j].min_basic)){

					          $("#emp_actual_pf_int").val(obj[3][j].inrupees);

					        }
				  }
				  
				    $("#emp_actual_pf_int").prop("readonly", true);
				  
				  }else if(obj[0].pf_int!=null){
				    $("#emp_actual_pf_int").val(obj[0].pf_int);
				   $("#emp_actual_pf_int").prop("readonly", false);
				  }else{
				  emp_pf_int=0;
				  $("#emp_actual_pf_int").val(emp_pf_int);
				   $("#emp_actual_pf_int").prop("readonly", true);
				  }
				 
			}else if(obj[3][j].rate_id=='17'){
				 if(obj[0].apf=='1')
			      {
				  if(obj[3][j].inpercentage!='0'){
				   emp_apf=Math.round(basic*obj[3][j].inpercentage/100);
			        $("#emp_actual_apf").val(emp_apf);
				  }else{
				  
				  
				       		if((basic<=obj[3][j].max_basic) && (basic>=obj[3][j].min_basic)){

					          $("#emp_actual_apf").val(obj[3][j].inrupees);

					        }
				  }
				  
				   $("#emp_actual_apf").prop("readonly", true);
				  
				  }else if(obj[0].apf!=null){
				    $("#emp_actual_apf").val(obj[0].apf);
					 $("#emp_actual_apf").prop("readonly", false);
				  
				  
				  }else{
				  emp_apf=0;
				  $("#emp_actual_apf").val(emp_apf);
				  $("#emp_actual_apf").prop("readonly", true);
				  
				  }
				  
				 
			}else if(obj[3][j].rate_id=='18'){
				 if(obj[0].i_tax=='1')
			      {
				  if(obj[3][j].inpercentage!='0'){
				   emp_i_tax=Math.round(basic*obj[3][j].inpercentage/100);
			        $("#emp_actual_i_tax").val(emp_i_tax);
				  }else{
				  
				  
				       		if((basic<=obj[3][j].max_basic) && (basic>=obj[3][j].min_basic)){

					          $("#emp_actual_i_tax").val(obj[3][j].inrupees);

					        }
				  }
				  
				    $("#emp_actual_i_tax").prop("readonly", true);
				  
				  
				  }else if(obj[0].i_tax!=null){
				    $("#emp_actual_i_tax").val(obj[0].i_tax);
					  $("#emp_actual_i_tax").prop("readonly", false);
				  
				  
				  
				  }else{
				  emp_i_tax=0;
				  $("#emp_actual_i_tax").val(emp_i_tax);
				   $("#emp_actual_i_tax").prop("readonly", true);
				  
				  }
				 
			}else if(obj[3][j].rate_id=='19'){
				 if(obj[0].insu_prem=='1')
			      {
				  if(obj[3][j].inpercentage!='0'){
				   emp_insu_prem=Math.round(basic*obj[3][j].inpercentage/100);
			        $("#emp_actual_insu_prem").val(emp_insu_prem);
				  }else{
				  
				  
				       		if((basic<=obj[3][j].max_basic) && (basic>=obj[3][j].min_basic)){

					          $("#emp_actual_insu_prem").val(obj[3][j].inrupees);

					        }
				  }
				  
				   $("#emp_actual_insu_prem").prop("readonly", true);
				  
				  
				  }else if(obj[0].insu_prem!=null){
				    $("#emp_actual_insu_prem").val(obj[0].insu_prem);
				   $("#emp_actual_insu_prem").prop("readonly", false);
				  
				  }else{
				  emp_insu_prem=0;
				  $("#emp_actual_insu_prem").val(emp_insu_prem);
				  $("#emp_actual_insu_prem").prop("readonly", true);
				  
				  }
				 
			}else if(obj[3][j].rate_id=='20'){
				 if(obj[0].pf_loan=='1')
			      {
				  if(obj[3][j].inpercentage!='0'){
				   emp_pf_loan=Math.round(basic*obj[3][j].inpercentage/100);
			        $("#emp_actual_pf_loan").val(emp_pf_loan);
				  }else{
				  
				  
				       		if((basic<=obj[3][j].max_basic) && (basic>=obj[3][j].min_basic)){

					          $("#emp_actual_pf_loan").val(obj[3][j].inrupees);

					        }
				  }
				  
				  $("#emp_actual_pf_loan").prop("readonly", true);
				  
				  
				  }else if(obj[0].pf_loan!=null){
				    $("#emp_actual_pf_loan").val(obj[0].pf_loan);
					 $("#emp_actual_pf_loan").prop("readonly", false);
				  
				  
				  
				  }else{
				  emp_pf_loan=0;
				  $("#emp_actual_pf_loan").val(emp_pf_loan);
				   $("#emp_actual_pf_loan").prop("readonly", true);
				  
				  }
				 
			}else if(obj[3][j].rate_id=='21'){
				 if(obj[0].esi=='1')
			      {
				  if(obj[3][j].inpercentage!='0'){
				   emp_esi=Math.round(basic*obj[3][j].inpercentage/100);
			        $("#emp_actual_esi").val(emp_esi);
				  }else{
				  
				  
				       		if((basic<=obj[3][j].max_basic) && (basic>=obj[3][j].min_basic)){

					          $("#emp_actual_esi").val(obj[3][j].inrupees);

					        }
				  }
				   $("#emp_actual_esi").prop("readonly", true);
				  
				  
				  
				  }else if(obj[0].esi!=null){
				    $("#emp_actual_esi").val(obj[0].esi);
					$("#emp_actual_esi").prop("readonly", false);
				  
				  
				  
				  }else{
				  emp_esi=0;
				  $("#emp_actual_esi").val(emp_esi);
				  $("#emp_actual_esi").prop("readonly", true);
				  
				  }
				 
			}else if(obj[3][j].rate_id=='22'){
				 if(obj[0].adv=='1')
			      {
				  if(obj[3][j].inpercentage!='0'){
				   emp_adv=Math.round(basic*obj[3][j].inpercentage/100);
			        $("#emp_actual_adv").val(emp_adv);
				  }else{
				  
				  
				       		if((basic<=obj[3][j].max_basic) && (basic>=obj[3][j].min_basic)){

					          $("#emp_actual_adv").val(obj[3][j].inrupees);

					        }
				  }
				  
				  $("#emp_actual_adv").prop("readonly", true);
				  
				  
				  }else if(obj[0].adv!=null){
				    $("#emp_actual_adv").val(obj[0].adv);
				  $("#emp_actual_adv").prop("readonly", false);
				  
				  }else{
				  emp_adv=0;
				  $("#emp_actual_adv").val(emp_adv);
				    $("#emp_actual_adv").prop("readonly", true);
				 
				  }
				 
			}else if(obj[3][j].rate_id=='23'){
				 if(obj[0].hrd=='1')
			      {
				  if(obj[3][j].inpercentage!='0'){
				   emp_hrd=Math.round(basic*obj[3][j].inpercentage/100);
			        $("#emp_actual_hrd").val(emp_hrd);
				  }else{
				  
				  
				       		if((basic<=obj[3][j].max_basic) && (basic>=obj[3][j].min_basic)){

					          $("#emp_actual_hrd").val(obj[3][j].inrupees);

					        }
				  }
				  
				   $("#emp_actual_hrd").prop("readonly", true);
				 
				  
				  }else if(obj[0].hrd!=null){
				    $("#emp_actual_hrd").val(obj[0].hrd);
				   $("#emp_actual_hrd").prop("readonly", false);
				 
				  }else{
				  emp_hrd=0;
				  $("#emp_actual_hrd").val(emp_hrd);
				   $("#emp_actual_hrd").prop("readonly", true);
				 
				  }
				 
			}else if(obj[3][j].rate_id=='24'){
				 if(obj[0].co_op=='1')
			      {
				  if(obj[3][j].inpercentage!='0'){
				   emp_co_op=Math.round(basic*obj[3][j].inpercentage/100);
			        $("#emp_actual_co_op").val(emp_co_op);
				  }else{
				  
				  
				       		if((basic<=obj[3][j].max_basic) && (basic>=obj[3][j].min_basic)){

					          $("#emp_actual_co_op").val(obj[3][j].inrupees);

					        }
				  }
				  
				  
				   $("#emp_actual_co_op").prop("readonly", true);
				 
				  }else if(obj[0].co_op!=null){
				    $("#emp_actual_co_op").val(obj[0].co_op);
					 $("#emp_actual_co_op").prop("readonly", false);
				 
				  
				  }else{
				  emp_co_op=0;
				  $("#emp_actual_co_op").val(emp_co_op);
				  $("#emp_actual_co_op").prop("readonly", true);
				 
				  }
				 
			}else if(obj[3][j].rate_id=='25'){
				 if(obj[0].furniture=='1')
			      {
				  if(obj[3][j].inpercentage!='0'){
				   emp_furniture=Math.round(basic*obj[3][j].inpercentage/100);
			        $("#emp_actual_furniture").val(emp_furniture);
				  }else{
				  
				  
				       		if((basic<=obj[3][j].max_basic) && (basic>=obj[3][j].min_basic)){

					          $("#emp_actual_furniture").val(obj[3][j].inrupees);

					        }
				  }
				  
				  
				    $("#emp_actual_furniture").prop("readonly", true);
				 
				  }else if(obj[0].furniture!=null){
				    $("#emp_actual_furniture").val(obj[0].furniture);
				    $("#emp_actual_furniture").prop("readonly", false);
				 
				  }else{
				  emp_furniture=0;
				  $("#emp_actual_furniture").val(emp_furniture);
				    $("#emp_actual_furniture").prop("readonly", true);
				 
				  }
				 
			}else if(obj[3][j].rate_id=='26'){
				 if(obj[0].misc_ded=='1')
			      {
				  if(obj[3][j].inpercentage!='0'){
				   emp_misc_ded=Math.round(basic*obj[3][j].inpercentage/100);
			        $("#emp_actual_misc_ded").val(emp_misc_ded);
				  }else{
				  
				  
				       		if((basic<=obj[3][j].max_basic) && (basic>=obj[3][j].min_basic)){

					          $("#emp_actual_misc_ded").val(obj[3][j].inrupees);

					        }
				  }
				    $("#emp_actual_misc_ded").prop("readonly", true);
				 
				  
				  
				  }else if(obj[0].misc_ded!=null){
				    $("#emp_actual_misc_ded").val(obj[0].misc_ded);
					  $("#emp_actual_misc_ded").prop("readonly", false);
				 
				  
				  }else{
				  emp_misc_ded=0;
				  $("#emp_actual_misc_ded").val(emp_misc_ded);
				    $("#emp_actual_misc_ded").prop("readonly", true);
				 
				  }
				 
			}
			}


			  $("#emp_actual_others_addition").val('0');
			var gross_salary=Math.round((parseFloat(basic) + parseFloat($('#emp_actual_da').val()) + parseFloat($('#emp_actual_vda').val()) + parseFloat($('#emp_actual_hra').val())+parseFloat($('#emp_actual_others_alw').val())+parseFloat($('#emp_actual_tiff_alw').val())+parseFloat($('#emp_actual_conv').val()) 
			+ parseFloat($('#emp_actual_medical').val())+parseFloat($('#emp_actual_misc_alw').val())+parseFloat($('#emp_actual_over_time').val())+parseFloat($('#emp_actual_bouns').val())+parseFloat($('#emp_actual_leave_inc').val()) +parseFloat($('#emp_actual_hta').val())),2);
  
			$("#emp_actual_gross_salary").val(gross_salary);
	    }
	});
}

function OnblurCalculateAddition()
{

   
    var basic_pay = $('#emp_basic_pay').val();

      var other_addition=$('#emp_actual_others_addition').val();

    $('#emp_actual_gross_salary').val('');

    //Total Addition
   var total_gross_on_blur=Math.round((parseFloat(basic_pay) + parseFloat($('#emp_actual_da').val()) + parseFloat($('#emp_actual_vda').val()) + parseFloat($('#emp_actual_hra').val())+parseFloat($('#emp_actual_others_alw').val())+parseFloat($('#emp_actual_tiff_alw').val())+parseFloat($('#emp_actual_conv').val()) 
			+ parseFloat($('#emp_actual_medical').val())+parseFloat($('#emp_actual_misc_alw').val())+parseFloat($('#emp_actual_over_time').val())+parseFloat($('#emp_actual_bouns').val())+parseFloat($('#emp_actual_leave_inc').val()) +parseFloat($('#emp_actual_hta').val())+parseFloat(other_addition)),2);
  
	$('#emp_actual_gross_salary').val(total_gross_on_blur);
				   

   
}


</script>
<script src="{{ asset('js/monthpicker.min.js') }}"></script>
<script>
//$('.demo-1').Monthpicker();
</script>


