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



@section('scripts')

@endsection

@section('content')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css" rel="stylesheet" />

<link rel="stylesheet" href="http://192.168.1.34/bopt/public/bootstrap/datepicker.css">
<script src="http://192.168.1.34/bopt/public/bootstrap/bootstrap-datepicker.js"></script>

<style>
    ul#stepForm, ul#stepForm li {
      margin: 0;
      padding: 0;
    }
    ul#stepForm li {
      list-style: none outside none;
    }
    label{margin-top: 10px;}
    .help-inline-error{color:red;}
    .container1 {
    display: block;
    position: relative;
    padding-left: 27px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 22px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
  }
  .pay-strct .form-group{margin-bottom:0;}h3.ad {background: #1c9ac5;color: #fff;padding: 5px 10px;font-size: 23px;}
  .addi {padding: 15px;margin-bottom: 9px;}
  /* Hide the browser's default checkbox */
  .container1 input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
  }

  /* Create a custom checkbox */
  .checkmark {
    position: absolute;
    top: 5px;
    left: 0;
    height: 15px;
    width: 15px;
      background-color: #d6d2d2;
  }

  /* On mouse-over, add a grey background color */
  .container1:hover input ~ .checkmark {
    background-color: #ccc;
  }

  /* When the checkbox is checked, add a blue background */
  .container1 input:checked ~ .checkmark {
    background-color: #1c9ac5;
  }

  /* Create the checkmark/indicator (hidden when not checked) */
  .checkmark:after {
    content: "";
    position: absolute;
    display: none;
  }

  /* Show the checkmark when checked */
  .container1 input:checked ~ .checkmark:after {
    display: block;
  }

  /* Style the checkmark/indicator */
  .container1 .checkmark:after {
    left: 5px;
    top: 2px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
  </style>


 <!-- Content -->
  <div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
      <!-- Widgets  -->
      <div class="row">
        <div class="main-card">
          <div class="card">
            <div class="card-header"> <strong>Employee Master</strong> </div>
            	@if(Session::has('message'))
				<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em ><i class="fa fa-check-square-o"></i> {{ Session::get('message') }}</em></div>
				@endif
            <div class="card-body card-block">
              <div class="panel panel-primary">


    <div class="panel-body">
      <form name="basicform" id="basicform" method="post" action="" enctype="multipart/form-data" >
        {{ csrf_field() }}
        <div id="sf1" class="frm">
          <fieldset>

            <legend>Personal and Service Details</legend>
			<div class="row form-group">
				<div class="col-md-3">
				<label>Employee Code </label>
                <input type="text" value="<?php   echo $employee_rs[0]->emp_code;  ?>" name="emp_code" class="form-control" readonly="1">
				</div>
				<div class="col-md-3">
					<label>First Name <span>(*)</span></label>
                    <input type="text" name="emp_fname" value="<?php   echo $employee_rs[0]->emp_fname;  ?>" class="form-control" id="fname" readonly required>
				</div>
				<div class="col-md-3">
					<label>Middle Name</label>
                    <input type="text" name="emp_mid_name" value="<?php   echo $employee_rs[0]->emp_mname;  ?>" class="form-control" id="fname" readonly>
				</div>
				<div class="col-md-3">
					<label>Last Name </label>
                    <input type="text" name="emp_lname" value="<?php   echo $employee_rs[0]->emp_lname;  ?>" class="form-control" id="lname" readonly>
				</div>
			</div>
            <div class="row form-group">
				<div class="col-md-3">
					<label>Father's Name <span>(*)</span></label>
                    <input type="text" name="emp_father_name" id="emp_father_name" value="<?php   echo $employee_rs[0]->emp_father_name;  ?>" readonly class="form-control" required>
				</div>
              	<div class="col-md-3">
			  	<label>Present City Class <span>(*)</span></label>
                    <select class="form-control" name="emp_present_city" required>
						<option value="">Select</option>
	                    <option value="A class City" <?php    if($employee_rs[0]->emp_present_city_class=='A class City'){ echo 'selected';}  ?>>A class City</option>
						<option value="B class City" <?php    if($employee_rs[0]->emp_present_city_class=='B class City'){ echo 'selected';}  ?>>B class City</option>
						<option value="C class City" <?php    if($employee_rs[0]->emp_present_city_class=='C class City'){ echo 'selected';}  ?>>C class City</option>
						<option value="D class City" <?php    if($employee_rs[0]->emp_present_city_class=='D class City'){ echo 'selected';}  ?>>D class City</option>
					</select>
			  </div>

			  <div class="col-md-3">
				  	<label>Residential  Distance (in Km.)</label>
	                <input type="text" name="emp_resdential_distance" value="<?php   echo $employee_rs[0]->emp_residential_distance; ?>" class="form-control">
			  </div>
			   <div class="col-md-3">
				   	<label>Home Town</label>
	                <input type="text" name="emp_home_town" value="<?php   echo $employee_rs[0]->emp_home_town;  ?>" class="form-control">
			   </div>
            </div>

			<div class="row form-group">
				<div class="col-md-3">
			   		<label>Nearest Railway Station</span></label>
                    <input type="text" name="emp_nearest_railway" value="<?php   echo $employee_rs[0]->emp_nearest_railway; ?>" class="form-control">
			    </div>
                <div class="col-md-4">
					<label>Mobile No. <span>(*)</span></label>
                    <input type="text" id="parmenent_mobile" name="emp_pr_mobile" readonly value="<?php   echo $employee_rs[0]->emp_pr_mobile; ?>" class="form-control" required>
				</div>

                <div class="col-md-4">
			  <label>Blood Group <span>(*)</span></label>
                          <select class="form-control" name="emp_blood_grp" required readonly>
                              <option value="">Select</option>
                              <option value="A +"  <?php    if($employee_rs[0]->emp_blood_group=="A +"){ echo 'selected';}  ?>>A +</option>
                              <option value="A -"  <?php    if($employee_rs[0]->emp_blood_group=="A -"){ echo 'selected';}  ?>>A -</option>
                              <option value="B +"  <?php    if($employee_rs[0]->emp_blood_group=="B +"){ echo 'selected';}  ?>>B +</option>
                              <option value="B -"  <?php    if($employee_rs[0]->emp_blood_group=="B -"){ echo 'selected';}  ?>>B -</option>
                              <option value="AB +"  <?php    if($employee_rs[0]->emp_blood_group=="AB +"){ echo 'selected';} ?>>AB +</option>
                              <option value="AB -"  <?php    if($employee_rs[0]->emp_blood_group=="AB -"){ echo 'selected';}  ?>>AB -</option>
                              <option value="O +"  <?php    if($employee_rs[0]->emp_blood_group=="O +"){ echo 'selected';} ?>>O +</option>
                              <option value="O -"  <?php    if($employee_rs[0]->emp_blood_group=="0 -"){ echo 'selected';}  ?>>O -</option>
                              <option value="Unknown">Unknown</option>
			</select>
			  </div>
			</div>


			<div class="row form-group">

                <div class="col-md-3">
				<label>Date of Birth <span>(*)</span></label>
                    <input type="date" name="emp_dob" id="emp_dob" onchange="calculateDor()" readonly data-date-format="DD MMMM YYYY" value="<?php   echo $employee_rs[0]->emp_dob;  ?>" class="form-control" required>
				</div>

				<div class="col-md-3">
				<label>Date of Joining <span>(*)</span></label>
                <input type="date" name="emp_doj" id="emp_doj" onchange="calculateDateOfIncrement()" readonly data-date-format="DD MMMM YYYY" value="<?php   echo $employee_rs[0]->emp_doj;  ?>" class="form-control" required>
				</div>
                <div class="col-md-3">
				<label>Date of Retirement </label>
                <input type="text" name="emp_retirement_date" id="emp_retirement_date"  value="<?php
                	$date_of_retire = date_create($employee_rs[0]->emp_retirement_date);
					echo date_format($date_of_retire, 'd/m/Y');
                 ?>" class="form-control" readonly>
				</div>




			<!-------------service-details-------------->



			<!--parmanent-address----------->
            <legend>Permanent Address</legend>
			<div class="row form-group">
				<div class="col-md-4">
					<label>Street No. and Name</label>
                        <input type="text" name="emp_pr_street_no" value="<?php   echo $employee_rs[0]->emp_pr_street_no; ?>" id="parmenent_street_name" class="form-control">
				</div>

				<div class="col-md-4">
					<label>Village</label>
                    <input id="parmenent_village" name="emp_per_village" value="<?php   echo $employee_rs[0]->emp_per_village;  ?>" type="text" class="form-control">
				</div>
				<div class="col-md-4">
					<label>City</label>
                        <input type="text" name="emp_pr_city" value="<?php   echo $employee_rs[0]->emp_pr_city;  ?>" id="parmenent_city" class="form-control">
				</div>


			</div>

			<div class="row form-group">

				<div class="col-md-4">
					<label>Post Office</label>

                    <input id="emp_per_post_office" name="emp_per_post_office" value="<?php   echo $employee_rs[0]->emp_per_post_office;  ?>" type="text" class="form-control">
				</div>

				<div class="col-md-4">
					<label>Police Station</label>
                    <input type="text" id="emp_per_policestation" name="emp_per_policestation" value="<?php   echo $employee_rs[0]->emp_per_policestation;  ?>" class="form-control">
				</div>


				<div class="col-md-4">
					<label>Pin Code <span>(*)</span> </label>
                     <input id="parmenent_pincode" name="emp_pr_pincode" value="<?php   echo $employee_rs[0]->emp_pr_pincode;  ?>" type="text" class="form-control" required >
				</div>

			</div>




			<div class="row form-group">


				<div class="col-md-4">
					<label>District</label>
                    <input type="text" id="emp_per_dist" name="emp_per_dist" value="<?php   echo $employee_rs[0]->emp_per_dist;  ?>" class="form-control">
				</div>

				<div class="col-md-4">
					<label>State <span>(*)</span></label>

                        <select name="emp_pr_state" id="parmenent_state" class="form-control">
						<option value="" label="Select">Select</option>
						<?php foreach($states as $state){ ?>
						<option value="<?php echo $state->state_name; ?>" <?php    if($employee_rs[0]->emp_pr_state==$state->state_name){ echo 'selected';}  ?>><?php echo $state->state_name; ?></option>
						<?php }  ?>
					</select>
				</div>

				<div class="col-md-4">
					<label>Country</label>
                    <input id="parmenent_country" name="emp_pr_country" value="<?php   echo $employee_rs[0]->emp_pr_country;  ?>" type="text" class="form-control" readonly>
				</div>
			</div>


<!--			------------------------->

			<!-- present-address--------->
          <legend>Present Address <span><label class="checkbox-inline"><input id="filladdress" type="checkbox" value="">( if Present Address is same as permanent Address )</label></span></legend>
			<div class="row form-group">
				<div class="col-md-4">
					<label>Street No. and Name</label>
                                        <input type="text" name="emp_ps_street_no" id="present_street_name" value="<?php   echo $employee_rs[0]->emp_ps_street_no;  ?>"  class="form-control">
				</div>


				<div class="col-md-4">
					<label>Village</label>
                    <input id="emp_ps_village" name="emp_ps_village" value="<?php   echo $employee_rs[0]->emp_ps_village;  ?>" type="text" class="form-control">
				</div>
				<div class="col-md-4">
					<label>City</label>
                                        <input type="text" name="emp_ps_city" id="present_city" value="<?php   echo $employee_rs[0]->emp_ps_city;  ?>" class="form-control">
				</div>

			</div>

			<div class="row form-group">
				<div class="col-md-4">
					<label>Post Office</label>
                    <input id="emp_ps_post_office" name="emp_ps_post_office" value="<?php   echo $employee_rs[0]->emp_ps_post_office; ?>" type="text" class="form-control">
				</div>


				<div class="col-md-4">
					<label>Police Station</label>
                    <input type="text" id="emp_ps_policestation" name="emp_ps_policestation" value="<?php   echo $employee_rs[0]->emp_ps_policestation; ?>" class="form-control">
				</div>

				<div class="col-md-4">
					<label>Pin Code <span>(*)</span></label>
                                        <input type="text" name="emp_ps_pincode" id="present_pincode" value="<?php   echo $employee_rs[0]->emp_ps_pincode;  ?>" class="form-control" required>
				</div>
			</div>
			<div class="row form-group">

				<div class="col-md-4">
					<label>District</label>
                    <input type="text" id="emp_ps_dist" name="emp_ps_dist" value="<?php   echo $employee_rs[0]->emp_ps_dist;  ?>" class="form-control">
				</div>

				<div class="col-md-4">
					<label>State <span>(*)</span></label>


                   <select name="emp_ps_state" id="present_state" class="form-control">
						<option value="" label="Select">Select</option>
						<?php foreach($states as $state){ ?>
						<option value="<?php echo $state->state_name; ?>" <?php    if($employee_rs[0]->emp_ps_state==$state->state_name){ echo 'selected';}  ?>><?php echo $state->state_name; ?></option>
						<?php }  ?>
					</select>
				</div>
				<div class="col-md-4">
					<label>Country</label>
                    <input type="text" name="emp_ps_country" id="emp_ps_country" value="<?php   echo $employee_rs[0]->emp_ps_country;  ?>" class="form-control" readonly>
				</div>

			</div>

	</div>




			<button class="btn btn-primary open1" type="button">Next <i class="ti-arrow-right"></i></button>


          </fieldset>
        </div>

        <div id="sf2" class="frm" style="display: none;">
          <fieldset>
            <legend>Service Details</legend>

<div class="row form-group">

    <div class="col-md-3">
        <label>Department <span>(*)</span></label>
     <select class="form-control" name="emp_department" required readonly>
         <option value="">Select</option>
         @foreach($department as $dept)
         <option value="{{$dept->department_name}}" <?php    if($employee_rs[0]->emp_department==$dept->department_name){ echo 'selected';}  ?>>{{$dept->department_name}}</option>
           @endforeach
        </select>
    </div>
    <div class="col-md-3">
    <label>Designation <span>(*)</span></label>
        <select class="form-control" name="emp_designation" required readonly>
            <option value="" label="Select">Select </option>
             @foreach($designation as $desg)
            <option value="{{$desg->designation_name}}" <?php    if($employee_rs[0]->emp_designation==$desg->designation_name){ echo 'selected';}  ?>>{{$desg->designation_name}}</option>
            @endforeach
    </select>
    </div>

    <div class="col-md-3">
    <label>Employee Type <span>(*)</span></label>
        <select class="form-control" name="emp_status" required readonly>
            <option value="">Select</option>
            @foreach($employee_type as $emp)
            <option value="{{$emp->employee_type_name}}" <?php    if($employee_rs[0]->emp_status==$emp->employee_type_name){ echo 'selected';}  ?>>{{$emp->employee_type_name}}</option>
            @endforeach
    </select>
</div>

<div class="col-md-3">
    <label>Image</label>
        <input type="file" name="emp_image" value="<?php  if(!empty($employee_rs[0]->emp_image)){ echo $employee_rs[0]->emp_image; } ?>" class="form-control">
</div>

<?php if(!empty($employee_rs[0]->emp_image)){?>
	<input type="hidden" name="edit_emp_image" value="{{ $employee_rs[0]->emp_image }}" />
<img src="{{ url('/') }}/storage/app/{{ $employee_rs[0]->emp_image }}" style="height:100px;width:100px" >
<?php } ?>

</div>


			<!---------------educational-details------------>
            <legend>Nomination</legend>
			<table border="1" class="table table-bordered table-responsove" style="border-collapse:collapse;overflow-x:scroll;">
				<thead>
					<tr>
						<th>Sl.No.</th>
						<th>Name</th>
                        <th>Address</th>
						<th>Relationship</th>
						<th>Date of Birth</th>
						<th>Share %</th>
<!--						<th>Action</th>-->
					</tr>
				</thead>
				    <tbody id="nomination">
					<tr>
						<td>1</td>
						<td><input type="text" name="emp_nomination_name_one" value="<?php   echo $employee_rs[0]->nominee_name_one;  ?>" class="form-control"></td>
                        <td><input type="text" name="nominee_relationship_address" value="<?php   echo $employee_rs[0]->nominee_relationship_address; ?>" class="form-control"></td>
						<td><input type="text" name="emp_nomination_relation_one" value="<?php   echo $employee_rs[0]->nominee_relationship_one; ?>" class="form-control"></td>

						<td><input type="date" name="emp_nomination_dob_one" value="<?php   echo $employee_rs[0]->nominee_dob_one; ?>" class="form-control"></td>
						<td><input type="text" name="emp_nomination_share_one" value="<?php   echo $employee_rs[0]->emp_nomination_share_one;  ?>" class="form-control"></td>
                        </tr>
                        <tr>
						<td>2</td>
						<td><input type="text" name="emp_nomination_name_two" value="<?php   echo $employee_rs[0]->nominee_name_two; ?>" class="form-control"></td>
                        <td><input type="text" name="nominee_relationship_address_two" value="<?php   echo $employee_rs[0]->nominee_relationship_address_two; ?>" class="form-control"></td>
						<td><input type="text" name="emp_nomination_relation_two" value="<?php   echo $employee_rs[0]->nominee_relationship_two;  ?>" class="form-control"></td>

						<td><input type="date" name="emp_nomination_dob_two" value="<?php   echo $employee_rs[0]->nominee_dob_two;  ?>" class="form-control"></td>
						<td><input type="text" name="emp_nomination_share_two" value="<?php   echo $employee_rs[0]->emp_nomination_share_two;  ?>" class="form-control"></td>
                        </tr>





				</tbody>
			</table>
			<!---------------------------------------->

            <div class="clearfix" style="height: 10px;clear: both;"></div>


            <div class="form-group">
                <button class="btn btn-warning back2" type="button"><i class="ti-arrow-left"></i> Back</button>
                <button class="btn btn-primary open2" type="button">Next <i class="ti-arrow-right"></i></span></button>
              </div>

          </fieldset>
        </div>

        <div id="sf3" class="frm" style="display: none;">
          <fieldset>
            <div class="row form-group">


            <div class="col-md-3">
				<label>Commutaed Status</label>
                                <select data-placeholder="Choose a Groupe..." name="commuted_status" class="form-control">
						<option value="" label="Select">Select</option>
						<option value="Yes" <?php    if($employee_rs[0]->commuted_status=='Yes'){ echo 'selected';}  ?>>Yes</option>
						<option value="No" <?php    if($employee_rs[0]->commuted_status=='No'){ echo 'selected';}  ?>>No</option>

				</select>
				</div>
                <div class="col-md-3">
				<label>Basic Pay <span>(*)</span></label>

                   <select class="form-control" name="emp_basic_pay" id="emp_basic_pay" required readonly>
                   </select>

				</div>
                <div class="col-md-3">
				<label>Commutaed percentage</label>
                <input type="text" name="commuted_value" id="commuted_value" onblur="calculateFinalAmount();" value="<?php   echo $employee_rs[0]->commuted_value;  ?>" class="form-control" required>
				</div>
            </div>





			<!--------------------------->

			<!---------contact-info------------>

			<!------------------------------->

          <div class="form-group">

                <button class="btn btn-warning back3" type="button"><i class="ti-arrow-left"></i> Back</button>
                <button class="btn btn-primary" type="submit">Submit <i class="ti-arrow-right"></i></button>
                <img src="spinner.gif" alt="" id="loader" style="display: none">
              </div>

          </fieldset>
        </div>
		<div id="sf4" class="frm" style="display: none;">
          <!------------pay-details-------------->
            <legend>Pay Details</legend>

            <div class="row form-group">

				<div class="col-md-3">
				<label>Pay In The Pay Level <span>(*)</span> </label>
                       <select class="form-control" name="emp_payscale" id="emp_payscale" onchange="setbasicpay()" required>
						<option value="" label="Select">Select</option>
						<?php foreach($payscale_master as $payscale){ ?>
							<option value="<?php echo $payscale->id;?>" <?php
								if($employee_rs[0]->emp_pay_scale==$payscale->id){ echo 'selected';}
							?> ><?php echo $payscale->payscale_code;  ?></option>
						<?php } ?>
				</select>
				</div>

				<div class="col-md-3">
				<label>Pension Payment Order (PPO).</label>
                    <input type="text" name="emp_pension_no" value="<?php   echo $employee_rs[0]->emp_pension_no;  ?>"  class="form-control" >
				</div>
			</div>

			<div class="row form-group">


				<div class="col-md-3">
				<label>PF Type <span>(*)</span></label>
                      <select data-placeholder="Choose a PF..." name="emp_pf_type" class="form-control" required>
						<option value="" label="Select">Select</option>
						<option value="nps" <?php    if($employee_rs[0]->emp_pf_type=='nps'){ echo 'selected';}  ?> >NPS</option>
						<option value="gpf" <?php    if($employee_rs[0]->emp_pf_type=='gpf'){ echo 'selected';} ?> >GPF</option>
						<option value="cpf" <?php    if($employee_rs[0]->emp_pf_type=='cpf'){ echo 'selected';} ?> >CPF </option>
				</select>
				</div>
				<div class="col-md-3">
				<label>Passport No.</label>
                                <input type="text" name="emp_passport_no" value="<?php   echo $employee_rs[0]->emp_passport_no;  ?>" class="form-control">
				</div>

				<div class="col-md-3">
				<label>GPF No./PRAN No. </label>
                                <input type="text" name="emp_pf_no" value="<?php   echo $employee_rs[0]->emp_pf_no; ?>" class="form-control">
				</div>

				<div class="col-md-3">
				<label>PAN No.</label>
                                <input type="text" name="emp_pan_no" value="<?php   echo $employee_rs[0]->emp_pan_no;  ?>" class="form-control">
				</div>
			</div>

			<div class="row form-group">



				<div class="col-md-3">
				<label>Payment Type</label>
                                <select class="form-control" name="emp_payment_type">
                                    <option value="">Select</option>
                                    <option value="inter bank" <?php    if($employee_rs[0]->emp_payment_type=='inter bank'){ echo 'selected';}  ?>>Inter Bank</option>
                                    <option value="intra bank" <?php    if($employee_rs[0]->emp_payment_type=='intra bank'){ echo 'selected';}  ?>>Intra Bank</option>
					</select>
				</div>
				<div class="col-md-3">
				<label>Bank Name <span>(*)</span></label>

				<select class="form-control" name="emp_bank_name" id="emp_bank_name" required onchange="populateBranch()">
					<option value="" label="Select">Select</option>
					@if(isset($bank) && !empty($bank))
					@foreach($bank as $key=>$value)
						<option value="{{ $value->id}}" <?php    if($employee_rs[0]->emp_bank_name==$value->id){ echo 'selected';}  ?>>{{ $value->master_bank_name}}</option>
					@endforeach
					@endif

				</select>

				</div>
				<div class="col-md-3">
					<label>Branch <span>(*)</span></label>
					<select class="form-control" name="bank_branch_id" id="bank_branch_id" required onclick="getIfcs()">
						<option value="" label="Select">Select Branch</option>
					</select>
			    </div>

			    <div class="col-md-3">
				<label>IFSC Code <span>(*)</span></label>
                   <input type="text" name="emp_ifsc_code" value="<?php   echo $employee_rs[0]->emp_ifsc_code;  ?>" id="emp_ifsc_code" class="form-control" readonly>
				</div>
			</div>

			<div class="row form-group">


				<div class="col-md-3">
				<label>Account No. <span>(*)</span></label>
                    <input type="text" name="emp_account_no" value="<?php   echo $employee_rs[0]->emp_account_no;  ?>" class="form-control" required>
				</div>


				<div class="col-md-3">
				<label style="color:#C0C0C0">Pay Level </label>
                        <select class="form-control" name="emp_grade">
						<option value="" label="Select">Select</option>
                           @foreach($grade as $empgrade)
						<option value="{{$empgrade->grade_name}}" <?php    if($employee_rs[0]->emp_grade==$empgrade->grade_name){ echo 'selected';}  ?>>{{$empgrade->grade_name}}</option>
						@endforeach
				</select>
				</div>

				<div class="col-md-3">
				<label>Aadhaar No. </label>
                    <input type="text" name="emp_aadhar_no" value="<?php   echo $employee_rs[0]->emp_aadhar_no;  ?>" class="form-control">
				</div>

			</div>
			 <div class="form-group">

                <button class="btn btn-warning back4" type="button"><i class="ti-arrow-left"></i> Back</button>
                <button class="btn btn-primary open4" type="button">Next <i class="ti-arrow-right"></i></button>
                <img src="spinner.gif" alt="" id="loader" style="display: none">
              </div>
			<!------------------------------------>
        </div>
		<div id="sf5" class="frm pay-strct" style="display: none;">
		<legend>Pay Structure</legend>


		<h3 class="ad">Earning</h3>
		<div class="addi">
		<div class="row form-group">
			<div class="col-md-3">
			<label class="container1">Dearness Allowance
                          <input name="da" value="1"  <?php    if($employee_rs[0]->da=='1'){ echo 'checked';}else{ }  ?> type="checkbox">
			  <span class="checkmark"></span>
			</label>
			</div>
			<div class="col-md-3">
			<label class="container1">House Rent Allowance
			  <input name="hra" value="1" <?php    if($employee_rs[0]->hra=='1'){ echo 'checked'; }else{ }  ?> type="checkbox">
			  <span class="checkmark"></span>
			</label>

			</div>
			<div class="col-md-3">
			<label class="container1">Transport Allowance
			  <input name="trans_allowance" <?php    if($employee_rs[0]->trans_allowance=='1'){ echo 'checked'; }else{ }  ?>  value="1" type="checkbox">
			  <span class="checkmark"></span>
			</label>

			</div>
			<div class="col-md-3">
			<label class="container1">D.A. on T.A.
			  <input name="da_on_ta" value="1" <?php    if($employee_rs[0]->da_on_ta=='1'){ echo 'checked'; }else{ }  ?> type="checkbox">
			  <span class="checkmark"></span>
			</label>

			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-3">
			<label class="container1">LTC
			  <input name="ltc" value="1"  <?php    if($employee_rs[0]->ltc=='1'){ echo 'checked'; }else{ } ?> type="checkbox">
			  <span class="checkmark"></span>
			</label>

			</div>
			<div class="col-md-3">
			<label class="container1">CEA
			  <input name="cea" value="1" <?php    if($employee_rs[0]->cea=='1'){ echo 'checked'; }else{ } ?> type="checkbox">
			  <span class="checkmark"></span>
			</label>

			</div>
			<div class="col-md-3">
			<label class="container1">Travelling Allowance
			  <input name="travelling_allowance" <?php    if($employee_rs[0]->travelling_allowance=='1'){ echo 'checked'; }else{ }?> value="1" type="checkbox">
			  <span class="checkmark"></span>
			</label>

			</div>
			<div class="col-md-3">
			<label class="container1">Daily Allowance
			  <input name="daily_allowance" <?php    if($employee_rs[0]->daily_allowance=='1'){ echo 'checked'; }else{ }  ?> value="1" type="checkbox">
			  <span class="checkmark"></span>
			</label>

			</div>
		</div>

		<div class="row form-group">
			<div class="col-md-3">
			<label class="container1">Advance
			  <input name="advance" value="1" <?php    if($employee_rs[0]->advance=='1'){ echo 'checked'; }else{ } ?> type="checkbox">
			  <span class="checkmark"></span>
			</label>

			</div>
			<div class="col-md-3">
			<label class="container1">Adjustment of Advance
			  <input name="adjustment_of_advance" <?php    if($employee_rs[0]->adjustment_advance=='1'){ echo 'checked'; }else{ }?> value="1" type="checkbox">
			  <span class="checkmark"></span>
			</label>

			</div>
			<div class="col-md-3">
			<label class="container1">Medical Reimbursement
			  <input name="medical_reimburshment" <?php    if($employee_rs[0]->medical_reimbursement=='1'){ echo 'checked'; }else{ }  ?> value="1" type="checkbox">
			  <span class="checkmark"></span>
			</label>

			</div>
                    <div class="col-md-3">
			<label class="container1">Special Allowance
			  <input name="spcl_allowance" <?php    if($employee_rs[0]->spcl_allowance=='1'){ echo 'checked'; }else{ }  ?> value="1" type="checkbox">
			  <span class="checkmark"></span>
			</label>
		    </div>
                     <div class="col-md-3">
			<label class="container1">Cash Handling Allowance
			  <input name="cash_handling_allowance" <?php    if($employee_rs[0]->cash_handling_allowance=='1'){ echo 'checked'; }else{ } ?> value="1" type="checkbox">
			  <span class="checkmark"></span>
			</label>
		    </div>
			<div class="col-md-3">
			<label class="container1">Others
			  <input name="add_others"  value="1" type="checkbox">
			  <span class="checkmark"></span>
			</label>

			</div>
		</div>
		</div>


		<h3 class="ad">Deduction</h3>
		<div class="addi">
		<div class="row form-group">
			<div class="col-md-3">
			<label class="container1">GPF
			  <input name="gpf" value="1" <?php    if($employee_rs[0]->gpf=='1'){ echo 'checked'; }else{ }  ?> type="checkbox">
			  <span class="checkmark"></span>
			</label>

			</div>
			<div class="col-md-3">
			<label class="container1">NPS
			  <input name="nps" value="1" <?php    if($employee_rs[0]->nps=='1'){ echo 'checked'; }else{ } ?> type="checkbox">
			  <span class="checkmark"></span>
			</label>

			</div>
			<div class="col-md-3">
			<label class="container1">CPF
			  <input name="cpf" value="1" <?php    if($employee_rs[0]->cpf=='1'){ echo 'checked'; }else{ }  ?> type="checkbox">
			  <span class="checkmark"></span>
			</label>

			</div>
			<div class="col-md-3">
			<label class="container1">GSLI
			  <input name="gsli" value="1" <?php    if($employee_rs[0]->gsli=='1'){ echo 'checked'; }else{ } ?> type="checkbox">
			  <span class="checkmark"></span>
			</label>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-3">
			<label class="container1">Income Tax
			  <input name="income_tax" value="1" <?php    if($employee_rs[0]->income_tax=='1'){ echo 'checked'; }else{ }  ?> type="checkbox">
			  <span class="checkmark"></span>
			</label>

			</div>
                    <div class="col-md-3">
			<label class="container1">CESS
			  <input name="cess" value="1" <?php    if($employee_rs[0]->cess=='1'){ echo 'checked'; }else{ }  ?> type="checkbox">
			  <span class="checkmark"></span>
			</label>

			</div>
			<div class="col-md-3">
			<label class="container1">Professional Tax
			  <input name="professional_tax" <?php    if($employee_rs[0]->professional_tax=='1'){ echo 'checked'; }else{ }  ?> value="1" type="checkbox">
			  <span class="checkmark"></span>
			</label>
			</div>
			<div class="col-md-3">
			<label class="container1">Others
			  <input name="ded_others" value="1"  type="checkbox">
			  <span class="checkmark"></span>
			</label>
			</div>
			<!--<div class="col-md-3">
			<div class="checkbox">
			  <label><input type="checkbox" value="">Daily Allowance</label>
			</div>
			</div>-->
		</div>


		</div>
		<div class="form-group">

                <button class="btn btn-warning back5" type="button"><i class="ti-arrow-left"></i> Back</button>
                <button class="btn btn-primary" type="submit">Submit <i class="ti-arrow-right"></i></button>
                <img src="spinner.gif" alt="" id="loader" style="display: none">
              </div>
		</div>
      </form>
    </div>
  </div>



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

 <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>


	<script src="{{ asset('js/lib/data-table/datatables.min.js') }}"></script>
    <script src="{{ asset('js/lib/data-table/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/lib/data-table/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/lib/data-table/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/lib/data-table/jszip.min.js') }}"></script>
    <script src="{{ asset('js/lib/data-table/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/lib/data-table/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/lib/data-table/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/lib/data-table/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('js/init/datatables-init.js') }}"></script>

	<script type="text/javascript">
        $(document).ready(function() {
        $('#bootstrap-data-table-export').DataTable();
      	});
	</script>



<script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>

<script type="text/javascript">



  jQuery().ready(function() {



	$('#parmenent_country').val("INDIA");
	$('#emp_ps_country').val("INDIA");

	//var myLength = $("#parmenent_pincode").val().length;
	jQuery('#parmenent_pincode').blur(function () {
  		var parmenent_pincode =  $("#parmenent_pincode").val();
  	var parmenent_pincode_length =  $("#parmenent_pincode").val().length;
    	if($.isNumeric(parmenent_pincode)!=true)
		 {
		 	$("#parmenent_pincode").val("");
			alert("Value is not Numeric");
		 }
		 if(parmenent_pincode_length!=6)
		 {
		 	$("#parmenent_pincode").val("");
			alert("Pincode should be six digit");
		 }
    	//alert(parmenent_pincode);
	});

	jQuery('#present_pincode').blur(function () {
  		var present_pincode =  $("#present_pincode").val();
  	    var present_pincode_length =  $("#present_pincode").val().length;
    	if($.isNumeric(present_pincode)!=true)
		 {
		 	$("#present_pincode").val("");
			alert("Value is not Numeric");
		 }
		 if(present_pincode_length!=6)
		 {
		 	$("#present_pincode").val("");
			alert("Pincode should be six digit");
		 }
    	//alert(parmenent_pincode);
	});




    showHideDiv();

	setbasicpay();
	populateBranch();

	var select_basic_id = "<?php   echo $employee_rs[0]->basic_pay;  ?>";
	var select_branch_id = "<?php   echo $employee_rs[0]->bank_branch_id;  ?>";

	setTimeout(function(){
      if(select_basic_id!=""){
		$("#emp_basic_pay option[value='"+select_basic_id+"']").prop('selected', true);
	  }

	  if(select_branch_id!=""){
		$("#bank_branch_id option[value='"+select_branch_id+"']").prop('selected', true);
	  }
    },1000);



	jQuery('#fname').keyup(function () {
    	this.value = this.value.replace(/[^a-zA-Z]/g,'');
	});

	jQuery('#emp_father_name').blur(function () {
    	this.value = this.value.replace(/[^a-zA-Z\s]/g,'');
	});

	jQuery('#parmenent_mobile').blur(function () {
    	this.value = this.value.replace(/[^0-9\.]/g,'');
    	var parmenent_mobile_length =  $("#parmenent_mobile").val().length;
    	if(parmenent_mobile_length!=10)
		 {
		 	$("#parmenent_mobile").val("");
			alert("Phone No. should be ten digit");
		 }
	});


	jQuery('#emp_ps_mobile').blur(function () {
    	this.value = this.value.replace(/[^0-9\.]/g,'');
    	var emp_ps_mobile_length =  $("#emp_ps_mobile").val().length;
    	if(emp_ps_mobile_length!=10)
		 {
		 	$("#emp_ps_mobile").val("");
			alert("Pincode should be ten digit");
		 }
	});


    // validate form on keyup and submit
    var v = jQuery("#basicform").validate({
      rules: {
        uname: {
          required: false,
          minlength: 2,
          maxlength: 16
        },
        uemail: {
          required: false,
          minlength: 2,
          email: true,
          maxlength: 100,
        },
        upass1: {
          required: false,
          minlength: 6,
          maxlength: 15,
        },
        upass2: {
          required: false,
          minlength: 6,
          equalTo: "#upass1",
        }

      },
      errorElement: "span",
      errorClass: "help-inline-error",
    });

    $(".open1").click(function() {
      if (v.form()) {
        $(".frm").hide("fast");
        $("#sf2").show("slow");
      }
    });

    $(".open2").click(function() {
      if (v.form()) {
        $(".frm").hide("fast");
        $("#sf3").show("slow");
      }
    });
	$(".open3").click(function() {
      if (v.form()) {
        $(".frm").hide("fast");
        $("#sf4").show("slow");
      }
    });
	$(".open4").click(function() {
      if (v.form()) {
        $(".frm").hide("fast");
        $("#sf5").show("slow");
      }
    });
	$(".open5").click(function() {
      if (v.form()) {
        $(".frm").hide("fast");
        $("#sf6").show("slow");
      }
    });

    $(".open6").click(function() {
      if (v.form()) {
        $("#loader").show();
         setTimeout(function(){
           $("#basicform").html('<h2>Employee Added Successfully</h2>');
         }, 1000);
        return false;
      }
    });

    $(".back2").click(function() {
      $(".frm").hide("fast");
      $("#sf1").show("slow");
    });

    $(".back3").click(function() {
      $(".frm").hide("fast");
      $("#sf2").show("slow");
    });
	$(".back4").click(function() {
      $(".frm").hide("fast");
      $("#sf3").show("slow");
    });
	$(".back5").click(function() {
      $(".frm").hide("fast");
      $("#sf4").show("slow");
    });
	$(".back6").click(function() {
      $(".frm").hide("fast");
      $("#sf5").show("slow");
    });

  });
</script>

<script>



		function getGrades(company_id)
		{
			$.ajax({
				type:'GET',
				url:'{{url('attendance/get-grades')}}/'+company_id,
				success: function(response){
				console.log(response);

				$("#grade_id").html(response);

				}

			});
		}

		function calculateDor(){
			var emp_dob = $("#emp_dob").val();
	    	var dateOfBirth = new Date(emp_dob);

	    	var sixty_years_ago = new Date(dateOfBirth.getFullYear()+60,dateOfBirth.getMonth(),dateOfBirth.getDate());

	    	if(dateOfBirth.getDate()==1 && sixty_years_ago.getMonth()==0){
	    		var lastdate = new Date(sixty_years_ago.getFullYear(), (sixty_years_ago.getMonth()+1), 0).getDate();
	    	   var lastDayWithSlashes = lastdate + '/' + '12' + '/' + (sixty_years_ago.getFullYear()-1);

	    	}else if(dateOfBirth.getDate()==1 && sixty_years_ago.getMonth()>0){
	    		var lastdate = new Date(sixty_years_ago.getFullYear(), (sixty_years_ago.getMonth()), 0).getDate();
	    		var lastDayWithSlashes = lastdate + '/' + (sixty_years_ago.getMonth()) + '/' + sixty_years_ago.getFullYear();

	    	}else{
	    		var lastdate = new Date(sixty_years_ago.getFullYear(), (sixty_years_ago.getMonth()+1), 0).getDate();
	    		var lastDayWithSlashes = lastdate +'/' + (sixty_years_ago.getMonth()+1) + '/' + sixty_years_ago.getFullYear();
	    	}

		    $("#emp_retirement_date").val(lastDayWithSlashes);
		}



		function calculateDateOfIncrement(){
			var emp_doj = $("#emp_doj").val();
			var dateOfJoining= new Date(emp_doj);
			var joingMonth=dateOfJoining.getMonth()+ 1;

			if(dateOfJoining.getDate()==1 && joingMonth==1){
				var nextIncrementDate = '01' + '/' + '07' + '/' + dateOfJoining.getFullYear();

			}else if(dateOfJoining.getDate()>=1 && (joingMonth>=1 && joingMonth<=6)){
				var nextIncrementDate = '01' + '/' + '01' + '/' + (dateOfJoining.getFullYear() +1);

			}else if(dateOfJoining.getDate()==1 && joingMonth==7){

				var nextIncrementDate = '01' + '/' + '01' + '/' + (dateOfJoining.getFullYear() +1);
			}else {

				var nextIncrementDate = '01' + '/' + '07' + '/' + (dateOfJoining.getFullYear() +1);
			}

		    $("#emp_next_increment_date").val(nextIncrementDate);

		}



		function setbasicpay(){
			var emp_payscale_id = $("#emp_payscale option:selected" ).val();

			$.ajax({
				type:'GET',
				url:'{{url('attendance/get-employee-scale')}}/'+emp_payscale_id,
				success: function(response){
					if(response.length>0){
						var option = '';
					for (var i=0;i<response.length;i++){
					   option += '<option value="'+ response[i].pay_scale_basic + '">' + response[i].pay_scale_basic + '</option>';
					}
					$('#emp_basic_pay').html(option);

					}

				}
			});
		}


		function populateBranch(){

			var emp_bank_id = $("#emp_bank_name option:selected" ).val();

			$.ajax({
				type:'GET',
				url:'{{url('attendance/get-employee-bank')}}/'+emp_bank_id,
				success: function(response){

					var option = '';
					for (var i=0;i<response.length;i++){
					   option += '<option value="'+ response[i].id + '">' + response[i].branch_name + '</option>';
					}
					$('#bank_branch_id').html(option);
				}
			});
		}





		function getIfcs(){

			var emp_branch_id= $("#bank_branch_id option:selected" ).val();

			$.ajax({
				type:'GET',
				url:'{{url('attendance/get-employee-bank-ifsc-code')}}/'+emp_branch_id,
				success: function(response){
						var obj = jQuery.parseJSON(response);
						$("#emp_ifsc_code" ).val(obj.ifsc_code);
				}
			});
		}


</script>


<script>
		function getEmployeeType(company_id)
		{
			//alert(company_id);
			$.ajax({
				type:'GET',
				url:'{{url('attendance/get-employee-type')}}/'+company_id,
				success: function(response){
				console.log(response);

				$("#employee_type_id").html(response);

				}

			});
		}
</script>

<script>
		function getDesignation(company_id)
		{
			//alert(company_id);
			$.ajax({
				type:'GET',
				url:'{{url('attendance/get-designation')}}/'+company_id,
				success: function(response){
				console.log(response);

				$("#designation_id").html(response);

				}

			});
		}
</script>

<script>
		function getHeadNames(grade_id)
		{
			var company_id=$("#company_id option:selected").val();
			//alert("Company"+company_id);
			//alert("Grade"+grade_id);
			$.ajax({
				type:'GET',
				url:'{{url('attendance/get-head-names')}}/'+company_id+'/'+grade_id,
				success: function(response){
				console.log(response);

				$("#head").html(response);

				}

			});
		}
</script>


<script type="text/javascript">

	function chckaddress() {
		var ischecked=$('#diffaddrress').is(":checked");
		//alert(ischecked);
		var permanent_street_no=$("#permanent_street_no").val();
		var permanent_city=$("#permanent_city").val();
		var permanent_state=$("#permanent_state").val();
		var permanent_country=$("#parmenent_country").val();
		var permanent_pin=$("#permanent_pin").val();
		var parmenent_mobile=$("#parmenent_mobile").val();

		if(ischecked)
		{
			$("#present_street_no").val(permanent_street_no);
			$("#present_city").val(permanent_city);
			$("#present_state").val(permanent_state);
			$("#emp_ps_country").val(permanent_country);
			$("#present_pin").val(permanent_pin);
			$("#present_mobile").val(parmenent_mobile);


		}
		else
		{
			$("#present_street_no").val('');
			$("#present_city").val('');
			$("#present_state").val('');
			$("#present_country").val('');
			$("#present_pin").val('');
			$("#present_mobile").val('');
		}



	}
    function calculateFinalAmount()
    {





        var commuted_value =$('#commuted_value').val();


        if(commuted_value>40){
            $('#commuted_value').val('');
        }






    }
</script>
<script src="{{ asset('js/jquery.autosuggest.js') }}"></script>
<script>
var reporting_person='';
var persons= reporting_person;
//alert("Suggest"+persons);
$("#reporting_person").autosuggest({
			sugggestionsArray: persons
		});
</script>
<script>

function getReportingPerson(val)
{
	alert(val);
	//var reporting_person= encodeURIComponent(val);
	//window.location = 'payment_receive.php?job_work_no='+reporting_person;\
	$.ajax({
		type:'GET',
		url:'{{url('attendance/get-reporting-names')}}',
		success: function(response){
		alert(response);
		//var jqObj = jQuery.parseJSON(response);
		//var jqObj =JSON.parse(response);
		//var jqObj = $.parseJSON(response);
		//console.log(jqObj.reporting_person);
		//alert(jqObj);
		$("#browsers").html(response);
		//reporting_person= response;
		//$("#reporting_person").val(jqObj.reporting_person);
		}

	});
}

</script>

<script>
	function getBranches(company_id)
	{
		//alert(company_id);
		$.ajax({
			type:'GET',
			url:'{{url('pis/get-branches')}}/'+company_id,
			success: function(response){
			console.log(response);

			$("#branch_id").html(response);

			}

		});
	}
</script>

      <script>

 $(document).ready(function() {
  var i = 1;
   //alert('hii');
  $('#add').click(function() {
    // alert('hii');
    i++;
    $('#marksheet').append('<tr id="row' + i + '"><td>'+ i +'</td><td><input type="text" name="qualification[]" class="form-control"></td><td><input type="text" name="dicipline[]" class="form-control"></td> <td><input type="text" name="inst_name[]" class="form-control"></td><td><input type="text" name="board_name[]" class="form-control"></td><td><input type="text" name="pass_year[]" class="form-control"></td><td><input type="text" name="percentage[]" class="form-control"></td><td><input type="text" name="rank[]" class="form-control"></td><td style="width:150px;"><button type="button" id="' + i + '" class="btn btn-default pls btn_remove" ><i class="fa fa-minus"></i></button></td></tr>');

  });


  $(document).on('click', '.btn_remove', function() {
    var button_id = $(this).attr("id");
    $('#row' + button_id + '').remove();
  });





});

                </script>
  <!--<td><input type="text" name="nomination_name[]" class="form-control"></td>
						<td><input type="text" name="nomination_relation[]" class="form-control"></td>
						<td><input type="text" name="nomination_age[]" class="form-control"></td>
						<td style="width:150px;"><button id="addnomination" class="btn btn-default pls"><i class="fa fa-plus"></i></button><button class="btn btn-default pls"><i class="fa fa-minus"></i></button></td>
					-->

 <script>

 $(document).ready(function() {
  var i = 1;

  $('#addnomination').click(function() {

    i++;
    $('#nomination').append('<tr id="rownominee' + i + '"><td>'+ i +'</td><td><input type="text" name="nomination_name[]" class="form-control"></td><td><input type="text" name="nomination_relation[]" class="form-control"></td> <td><input type="text" name="nomination_age[]" class="form-control"></td><td><button type="button" id="' + i + '" class="btn btn-default pls btn_remove_nominee"><i class="fa fa-minus"></i></button></td></tr>');

  });


  $(document).on('click', '.btn_remove_nominee', function() {
    var button_id = $(this).attr("id");
    $('#rownominee' + button_id + '').remove();
  });





});

                </script>
    <script>

$(document).ready(function(){
      $("#filladdress").on("click", function(){
         if (this.checked)
         {
            $("#present_street_name").val($("#parmenent_street_name").val());
            $("#present_city").val($("#parmenent_city").val());
            $("#present_state").val($("#parmenent_state").val());
            $("#emp_ps_country").val($("#parmenent_country").val());
            $("#present_pincode").val($("#parmenent_pincode").val());
            $("#emp_ps_village").val($("#parmenent_village").val());
            $("#emp_ps_post_office").val($("#emp_per_post_office").val());
           	$("#emp_ps_dist").val($("#emp_per_dist").val());
           	$("#emp_ps_policestation").val($("#emp_per_policestation").val());
            $("#emp_ps_mobile").val($("#parmenent_mobile").val());
            $("#present_street_name").prop("readonly", true);
            $("#present_city").prop("readonly", true);
            $("#emp_ps_country").prop("readonly", true);
            $("#present_state").prop("readonly", true);
            $("#present_pincode").prop("readonly", true);
            $("#present_mobile").prop("readonly", true);
        }
        else
        {
            $("#present_street_name").val('');
            $("#present_city").val('');
            $("#present_country").val('');
            $("#present_state").val('');
            $("#present_pincode").val('');
            $("#present_mobile").val('');
            $("#present_street_name").prop("readonly", false);
            $("#present_city").prop("readonly", false);
            $("#present_country").prop("readonly", false);
            $("#present_state").prop("readonly", false);
            $("#present_pincode").prop("readonly", false);
            $("#present_mobile").prop("readonly", false);
    }
    });

    /*$(document).on('change','#emp_bank_name', function(e){
    	var ifsccode = $('#emp_bank_name option:selected').data('ifsccode');
    	$('#emp_ifsc_code').val(ifsccode);

    });*/
});
        </script>

        <script>

        	function showHideDiv() {

        		var radioValue = $("input[name='emp_spouse_working']:checked").val();
            	if(radioValue=='Employee'){
            		$('#govt_emp').show();
        			$('#spouse_quarter').show();
            	}else{
            		$('#govt_emp').hide();
        			$('#spouse_quarter').hide();

            	}

        	}
        </script>
        @endsection

