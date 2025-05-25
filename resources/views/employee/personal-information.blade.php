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
<style>
.bzm-date-picker label, .bzm-date-picker input{border:none;}.ui-notification.success{display:none;}

.card-header {background: #01a798;color:#fff;}.modal-title {
color: #fff;font-size: 18px;text-transform: uppercase;}.modal-header .close{color:#fff;opacity:1;}#myModal button:hover, button:focus, .button:hover, .button:focus{background:none;}label{font-weight:600;margin-bottom:8px;}.modal-body{background: #f5f5f5;}fieldset {background: #fff;} fieldset h4{color: #01a798;}.custom-file-label::after{background-color:#01a798;color: #fff;}.card form label{font-weight:600;}.card .sel-form{width: 650px;margin: 0 auto;padding:30px 30px 0;} .btn.btn-default{background: #01a798;color: #fff;height: 30px;width: 40px;padding: 3px;}button.btn.btn-success {background: #01a798;border-color: #01a798;}.form-control{height:35px;}.hide{display:none;}
</style>

 <div class="content">
    <!-- Animated -->
    <form class="sel-form" action=""  method="post" enctype="multipart/form-data">
    	 {{ csrf_field() }}
    <div class="animated fadeIn">
      <!-- Widgets  -->
      <div class="row">
	
	  
        <div class="main-card">
		<div class="card">
		 <div class="card-header"> <strong>Personal Information</strong> </div>
		 
		 <div class="card-body card-block">
		 	
			<div class="row form-group">
				<div class="col-md-4"><label>Select Employee Code</label></div>
				<div class="col-md-6">
					<select class="form-control" id="empcode" name="empcode" onchange="getEmpCode()"; requied>
						<option value="">Select</option>
						<?php foreach($employees as $employee){ ?>
						<option value="<?php echo $employee->emp_code; ?>"><?php echo $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname." (".$employee->emp_code.")";  ?></option>
						<?php } ?>
					</select>
				</div>
			</div>

			
		 </div>
		</div>
		
          <div class="card">
            <div class="card-header"> <strong>Personal Information</strong> </div>
            <div class="card-body card-block">
              <form>
	   	<div class="row form-group">
			<div class="col-md-4">
				<label>Name</label>
				<input type="text" name="empname" id="empname" value="" class="form-control" readonly>
			</div>
			<div class="col-md-4">
				<label>Designation</label>
				<input type="text" name="emp_designation" id="emp_designation" value="" class="form-control" readonly>
			</div>
			<div class="col-md-4"></div>
		</div>
		
		<fieldset>
			<h4>Photograph</h4>
			<div class="row form-group">

				<div class="col-md-4">
					<input type="hidden" name="edit_appoinment_letter_image" id="edit_appoinment_letter_image"  />
					<label>At the time of appointment</label>
					<div class="input-group mb-3">
					  <div class="custom-file">
					    <input type="file" name="appoinment_letter_image" class="custom-file-input">
					    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
					  </div>	
				</div>
				</div>
				
				<div class="col-md-4">
					<input type="hidden" name="edit_image_after_eighteenyears" id="edit_image_after_eighteenyears"  />

					<label>After completing 18 yrs of service</label>
					<div class="input-group mb-3">
  
				  <div class="custom-file">
				    <input type="file" class="custom-file-input" name="image_after_eighteenyears" id="image_after_eighteenyears">
				    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
				  </div>
				</div>
				</div>
				
				<div class="col-md-4">
					<input type="hidden" name="edit_image_before_retirement" id="edit_image_before_retirement"  />

					<label>12 months before the date of retirement</label>
					<div class="input-group mb-3">
  
					  <div class="custom-file">
					    <input type="file" class="custom-file-input" name="image_before_retirement">
					    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
					  </div>
					</div>
				</div>
			</div>
		</fieldset>
		
		<fieldset>
			<div class="row form-group">
				<div class="col-md-4">
					<label>Aadhar No.</label>
					<input type="text" class="form-control">
				</div>
				
				<div class="col-md-4">
					<input type="hidden" name="edit_upload_adhar_card" id="edit_upload_adhar_card"  />

					<label>Upload Aadhar Card</label>
					<div class="input-group mb-3">
  
					  <div class="custom-file">
					    <input type="file" class="custom-file-input" name="upload_adhar_card" id="upload_adhar_card">
					    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
					  </div>
					</div>
				</div>
				
				<div class="col-md-4">
					<label>Father's Name</label>
					<input type="text" name="emp_fathername" id="emp_fathername" value="" class="form-control" readonly="">
				</div>
			</div>
			
			<div class="row form-group">
			<div class="col-md-4">
				<label>Mother's Name</label>
				<input type="text" class="form-control">
			</div>
			<div class="col-md-4">
				<label>Date of Birth</label>
				<input type="text" name="dob" id="dob" value="" class="form-control" readonly="">
			</div>
			<div class="col-md-4">
				<label>Date of Superannuation</label>
				<input type="text" name="dor" id="dor" value="" class="form-control" readonly="">
			</div>
			</div>
			
			<div class="row form-group">
			<div class="col-md-4">
				<label>Nationality</label>
				<select class="form-control" id="nationality" name="nationality">
					<option value="INDIAN">Indian</option>
					<option value="other">Nepalese</option>
					<option value="other">Bhutanese</option>
				</select>
				</div>
				<div class="col-md-4">
					<label>Whether belongs to SC/ST/OBC</label>
					<div class="custom-control custom-radio custom-control-inline">
					<input type="radio" class="custom-control-input castclass" id="customRadio2" name="checkcast" value="no" checked>
					<label class="custom-control-label" for="customRadio2">No</label>
					
				  </div>
				  <div class="custom-control custom-radio custom-control-inline">
					<input type="radio" class="custom-control-input castclass" id="customRadio" name="checkcast" value="yes">
					<label class="custom-control-label" for="customRadio">Yes</label>
				  </div> 
				</div>
				
				<div class="col-md-4">
					<label>Whether differently-abled</label>
					<div class="custom-control custom-radio custom-control-inline">
					<input type="radio" class="custom-control-input physicalstatus" id="customRadio4" name="physical_status" value="no" checked>
					<label class="custom-control-label" for="customRadio4">No</label>
				  </div>
				  <div class="custom-control custom-radio custom-control-inline">
					<input type="radio" class="custom-control-input physicalstatus" id="customRadio3" name="physical_status" value="yes">
					<label class="custom-control-label" for="customRadio3">Yes</label>
				  </div> 
				</div>
				
				
				<!-----------------certificate-block-------------------->
				<div class="col-md-4 nbcheck" id="nepbhut">
					<input type="hidden" name="edit_upload_eligibility_certificate" id="edit_upload_eligibility_certificate"  />
				<label>Upload Eligibility certificate</label>
				<div class="input-group mb-3">
  
				  <div class="custom-file">
				    <input type="file" class="custom-file-input" name="upload_eligibility_certificate" id="upload_eligibility_certificate">
				    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
				  </div>
				</div>
				</div>			
				
				
				<div class="col-md-4" id="cert">
					<input type="hidden" name="edit_upload_cast_certificate" id="edit_upload_cast_certificate"  />
					<label>If Yes, Upload Cast Certificate</label>
				<div class="input-group mb-3">
  
				  <div class="custom-file">
				    <input type="file" class="custom-file-input" name="upload_cast_certificate" id="upload_cast_certificate">
				    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
				  </div>
				</div>
				</div>
			
				
				<div class="col-md-4" id="physicalcertificate" >
					<input type="hidden" name="edit_upload_physical_certificate" id="edit_upload_physical_certificate"  />
				<label>If Yes, Upload Physical Certificate</label>
				<div class="input-group mb-3">
  
				  <div class="custom-file">
				    <input type="file" class="custom-file-input" name="upload_physical_certificate" id="upload_physical_certificate">
				    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
				  </div>
				</div>
				</div>
				<!---------------------------------------->

			</div>
			
			<div class="row form-group">
				<div class="col-md-4">
					<label>Marital Status</label>
					<select class="form-control" name="marital_status" id="marital_status" required="">
						<option value="single">Single</option>
						<option value="married">Married</option>
						<option value="divorced">Divorced/Separated</option>
						<option value="widow">Widow/Widower</option>
					</select>
				</div>
				<div class="col-md-4">
					<label>If Married, name of Spouse</label>
					<input type="text" name="spouse_name" class="form-control">
				</div>
				
				<div class="col-md-4">
					<input type="hidden" name="edit_upload_bigamy" id="edit_upload_bigamy" />

				<label>Upload declaration regarding bigamy*</label>
				<div class="input-group mb-3">
				  <div class="custom-file">
				    <input type="file" class="custom-file-input" name="upload_bigamy" id="upload_bigamy">
				    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
				  </div>
				</div>
				</div>
			</div>
			</fieldset>
			<fieldset>
			<h4>Permanent Address</h4>
			<div class="row form-group">
			<div class="col-md-4">
				<label>Street No. and Name</label>
				<input type="text" name="per_street_name" id="per_street_name" value="" class="form-control" readonly="">
			</div>
			<div class="col-md-4">
				<label>Village</label>
				<input type="text" name="per_village" id="per_village" value="" class="form-control" readonly="">
			</div>
			<div class="col-md-4">
				<label>City</label>
				<input type="text" name="per_city" id="per_city" value="" class="form-control" readonly="">
			</div>
			<div class="col-md-4">
				<label>Post Office</label>
				<input type="text" name="per_post_office" id="per_post_office" value="" class="form-control" readonly="">
			</div>
			<div class="col-md-4">
				<label>Police Station</label>
				<input type="text" name="per_police_station" id="per_police_station" value="" class="form-control" readonly="">
			</div>
			<div class="col-md-4">
				<label>Pincode</label>
				<input type="text" name="per_pincode" id="per_pincode" value="" class="form-control" readonly="">
			</div>
			<div class="col-md-4">
				<label>District</label>
				<input type="text" name="per_district" id="per_district" value="" class="form-control" readonly="">
			</div>
			<div class="col-md-4">
				<label>State</label>
				<input type="text" name="per_state" id="per_state" value="" class="form-control" readonly="">
			</div>
			<div class="col-md-4">
				<label>Country</label>
				<select class="form-control" name="emp_per_country" id="emp_per_country">
					<option>India</option>
					<option>Nepal</option>
					<option>Bhutan</option>
				</select>
			</div>
			</div>
			</fieldset>
			<fieldset>
			<h4>Present Address <span style="display: inline-block;" class="custom-control custom-checkbox"></span></h4>
			<div class="row form-group">
			<div class="col-md-4">
				<label>Street No. and Name</label>
				<input type="text" name="pre_street_name" id="pre_street_name" value="" class="form-control" readonly="">
			</div>
			<div class="col-md-4">
				<label>Village</label>
				<input type="text" name="pre_village" id="pre_village" value="" class="form-control" readonly="">
			</div>
			<div class="col-md-4">
				<label>City</label>
				<input type="text" name="pre_city" id="pre_city" value="" class="form-control" readonly="">
			</div>
			<div class="col-md-4">
				<label>Post Office</label>
				<input type="text" name="pre_post_office" id="pre_post_office" value="" class="form-control" readonly="">
			</div>
			<div class="col-md-4">
				<label>Police Station</label>
				<input type="text" name="pre_police_station" id="pre_police_station" value="" class="form-control" readonly="">
			</div>
			<div class="col-md-4">
				<label>Pincode</label>
				<input type="text" name="pre_pincode" id="pre_pincode" value="" class="form-control" readonly="">
			</div>
			<div class="col-md-4">
				<label>District</label>
				<input type="text" name="pre_district" id="pre_district" value="" class="form-control" readonly="">
			</div>
			<div class="col-md-4">
				<label>State</label>
				<input type="text" name="pre_state" id="pre_state" value="" class="form-control" readonly="">
			</div>
			<div class="col-md-4">
				<label>Country</label>
				<select class="form-control" name="emp_pre_country" id="emp_pre_country">
					<option>India</option>
					<option>Nepal</option>
					<option>Bhutan</option>
				</select>
			</div>
			</div>
			
			
			<div class="row form-group">
				<div class="col-md-3">
					<label>Mobile No.</label>
					<input type="text" id="emp_mobile" value="" readonly="" class="form-control">
				</div>
				<div class="col-md-3">
					<label>Alternate Phone No.</label>
					<input type="text" name="emp_alternative_mob" id="emp_alternative_mob" value="" class="form-control">
				</div>
				<div class="col-md-3">
					<label>Email ID</label>
					<input type="email" id="email" value="" readonly="" class="form-control">
				</div>
				<div class="col-md-3">
					<label>Alternate Email ID</label>
					<input type="email" name="alternative_email" id="alternative_email" value="" class="form-control">
				</div>
			</div>
			
			</fieldset>
			
			<fieldset>
			
			<div class="row form-group">
				<div class="col-md-6">
					<label>Hometown at the time of entry into the Govt. service</label>
					<input type="text" name="home_town" id="home_town" class="form-control">
				</div>
				<div class="col-md-3">
					<label>Nearest Railway Station</label>
					<input type="text" name="nearest_railway_station" id="nearest_railway_station" class="form-control">
				</div>
				<div class="col-md-3">
					<label>Nearest Airport</label>
					<input type="text" name="nearest_airport" id="nearest_airport" class="form-control">
				</div>
			</div>
			
			<div class="row form-group">
				<input type="hidden" name="edit_upload_signature" id="edit_upload_signature" />
				<div class="col-md-6">
					<label>Signature along with left thumb impression of Govt. Servant with date</label>
					<div class="input-group mb-3">
  
					  <div class="custom-file">
						<input type="file" class="custom-file-input" name="upload_signature" id="upload_signature">
						<label class="custom-file-label" for="inputGroupFile01">Choose file</label>
					  </div>
					</div>
				</div>
				
				<div class="col-md-6">
					<input type="hidden" name="edit_upload_officialseal" id="edit_upload_officialseal" />
					<label>Signature &amp; Designation of Attesting Officer along with date &amp; official seal affixed</label>
					<div class="input-group mb-3">
  
					  <div class="custom-file">
						<input type="file" class="custom-file-input" name="upload_officialseal" id="upload_officialseal">
						<label class="custom-file-label" for="inputGroupFile01">Choose file</label>
					  </div>
					 
					</div>
					 <p>*(as per CCS (Conduct) Rules, 1964)</p>
				</div>
				<button type="submit" class="btn btn-danger btn-sm">Save</button>
			</div>
			</fieldset>
          </div>
        </div>
      </div>
    </div>
    <!-- /Widgets -->
  </div>

  </form>
  <!-- .animated -->
</div>
<!-- /.content -->
<div class="clearfix"></div>



@endsection

@section('scripts')

@include('employee.partials.scripts')

<script>

$( document ).ready(function() {
    var castValue = $("input[name='checkcast']:checked").val();
		
		if(castValue=='no'){

	 	$("#cert").hide();
		}else{

		 $("#cert").show();
		}

	var physicalStatus = $("input[name='physical_status']:checked").val();
		if(physicalStatus=='no'){

	 		$("#physicalcertificate").hide();
		}else{

		 	$("#physicalcertificate").show();
		}


});
	
	$("input[type='radio'].castclass").click(function(){
		var castValue = $("input[name='checkcast']:checked").val();
		
		if(castValue=='no'){

	 	$("#cert").hide();
		}else{

		 $("#cert").show();
		}

	});


	$("input[type='radio'].physicalstatus").click(function(){
		var physicalStatus = $("input[name='physical_status']:checked").val();
		if(physicalStatus=='no'){

	 		$("#physicalcertificate").hide();
		}else{

		 	$("#physicalcertificate").show();
		}
	});


	function getEmpCode()
	{
		var empcode = $("#empcode option:selected").val();

		$.ajax({
			type:'GET',
			url:'{{url('empdetails')}}/'+empcode,				
			success: function(response){

				//console.log(response);
				var obj = jQuery.parseJSON(response);
				$("#empname").val(obj.emp_fname+" "+obj.emp_mname+" "+obj.emp_lname);
			    $("#emp_designation").val(obj.emp_designation);
			    $("#dob").val(obj.emp_dob);
				$("#dor").val(obj.emp_retirement_date);
				$("#per_street_name").val(obj.emp_pr_street_no);
				$("#per_village").val(obj.emp_per_village);
				$("#per_city").val(obj.emp_pr_city);
				$("#per_post_office").val(obj.emp_per_post_office);
				$("#per_police_station").val(obj.emp_per_policestation);
				$("#per_pincode").val(obj.emp_pr_pincode);
				$("#per_district").val(obj.emp_per_dist);
				$("#per_state").val(obj.emp_pr_state);

				$("#pre_street_name").val(obj.emp_ps_street_no);
				$("#pre_village").val(obj.emp_ps_village);
				$("#pre_city").val(obj.emp_ps_city);
				$("#pre_post_office").val(obj.emp_ps_post_office);
				$("#pre_police_station").val(obj.emp_ps_policestation);
				$("#pre_pincode").val(obj.emp_ps_pincode);
				$("#pre_district").val(obj.emp_ps_dist);
				$("#pre_state").val(obj.emp_ps_state);
				$("#emp_mobile").val(obj.emp_pr_mobile);
				$("#email").val(obj.emp_ps_email);
				$("#emp_fathername").val(obj.emp_father_name);
				$('#edit_appoinment_letter_image').val(obj.appoinment_letter_image);
				$('#edit_image_after_eighteenyears').val(obj.image_after_eighteenyears);
				$('#edit_image_before_retirement').val(obj.image_before_retirement);
				$('#edit_upload_adhar_card').val(obj.upload_adhar_card);

				$('#edit_upload_eligibility_certificate').val(obj.upload_eligibility_certificate);
				$('#edit_upload_cast_certificate').val(obj.upload_cast_certificate);
				$('#edit_upload_physical_certificate').val(obj.upload_physical_certificate);
				$('#edit_upload_bigamy').val(obj.upload_bigamy);
				$('#edit_upload_signature').val(obj.upload_signature);
				$('#edit_upload_officialseal').val(obj.upload_officialseal);

			}
			
		});

	}

</script>  
@endsection




