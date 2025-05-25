<?php
	error_reporting(0);
	include("includes/head.php");

?>
<body>
<?php 
		include("includes/left-panel.php");
   ?>
<!-- Right Panel -->
<div id="right-panel" class="right-panel">
  <?php include("includes/header.php");?>
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
  .table-bordered thead td, .table-bordered thead th {
    border-bottom-width: 2px;
    font-size: 14px;
    background: #1c9ac5;
    color: #fff;
}
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
            <div class="card-body card-block">
              <div class="panel panel-primary">
    
    <div class="panel-body">
      <form name="basicform" id="basicform" method="post" action="">
        
        <div id="sf1" class="frm">
          <fieldset>
            <legend>Personal and Service Details</legend>
			<div class="row form-group">
				<div class="col-md-3">
					<label>First Name <span>(*)</span></label>
					<input type="text" class="form-control" id="fname">
				</div>
				<div class="col-md-3">
					<label>Middle Name</label>
					<input type="text" class="form-control" id="fname">
				</div>
				<div class="col-md-3">
					<label>Last Name <span>(*)</span></label>
					<input type="text" class="form-control" id="fname">
				</div>
				<div class="col-md-3">
					<label>Father's Name</label>
					<input type="text" class="form-control">
				</div>
				
			</div>
            <div class="row form-group">
              <div class="col-md-3">
			  	<label>Present City Class</label>
				<select class="form-control">
					<option>Select</option>
					<option>A class City</option>
					<option>B class City</option>
					<option>C class City</option>
					<option>D class City</option>
			</select>
			  </div>
			  <div class="col-md-3">
			  	<label>Residential Dsiatnce (in Km.)</label>
				<input type="text" class="form-control">
			  </div>
			   <div class="col-md-3">
			   	<label>Home Town</span></label>
				<input type="text" class="form-control">
			   </div>
              <div class="col-md-3">
			   	<label>Nearest Railway Station</span></label>
				<input type="text" class="form-control">
			   </div>
            </div>
			
			
			
            <div class="clearfix" style="height: 10px;clear: both;"></div>
			
			<legend>Spouse Details</legend>
			
			<div class="row form-group">
				<div class="col-md-4">
					<label>Spouse Working Status</label><br>
					<div class="form-check-inline">
					  <label class="form-check-label">
						<input type="radio" class="form-check-input" name="optradio">Employee
					  </label>
					</div>
				<div class="form-check-inline">
				  <label class="form-check-label">
					<input type="radio" class="form-check-input" name="optradio">House Wife
				  </label>
				</div>
				<div class="form-check-inline">
				  <label class="form-check-label">
					<input type="radio" class="form-check-input" name="optradio">Others
				  </label>
				</div>
				<div class="form-check-inline">
				  <label class="form-check-label">
					<input type="radio" class="form-check-input" name="optradio">Same Organization
				  </label>
				</div>
				</div>
			
					<div class="col-md-4">
						<label>Government Employee?</label><br>
						<div class="form-check-inline">
				  <label class="form-check-label">
					<input type="radio" class="form-check-input" name="optradio">Yes
				  </label>
				</div>
				<div class="form-check-inline">
				  <label class="form-check-label">
					<input type="radio" class="form-check-input" name="optradio">No
				  </label>
				</div>
					</div>
					
					<div class="col-md-4">
						<label>Spose have quarter?</label><br>
						<div class="form-check-inline">
				  <label class="form-check-label">
					<input type="radio" class="form-check-input" name="optradio">Yes
				  </label>
				</div>
				<div class="form-check-inline">
				  <label class="form-check-label">
					<input type="radio" class="form-check-input" name="optradio">No
				  </label>
				</div>
					</div>
				</div>
			
			<!-------------service-details-------------->
			<legend>Service Details</legend>
			
			<div class="row form-group">
				<div class="col-md-3">
					<label>Designation</label>
					<select class="form-control">
						<option>Select</option>
						<option>Lower division clerk</option>
						<option>Scale I Officer</option>
						<option>Scale II Officer</option>
					</select>
				</div>
				<div class="col-md-3">
					<label>Branch</label>
					<select class="form-control">
						<option>Select</option>
						<option>Director</option>
						<option>Manager</option>
						<option>Clerk</option>
					</select>
				</div>
				<div class="col-md-3">
					<label>Department</label>
					<select class="form-control">
						<option>Select</option>
						<option>Admin</option>
						<option>Account Officer</option>
						<option>Admin cum Account Officer</option>
					</select>
				</div>
				<div class="col-md-3">
					<label>Eligible for Promotion</label>
					<select class="form-control">
						<option>Select</option>
						<option>Yes</option>
						<option>No</option>
					</select>
				</div>
			</div>
			
			<div class="row form-group">
				<div class="col-md-3">
				<label>Date of Joining</label>
				<input type="date" class="form-control">
				</div>
				<div class="col-md-3">
				<label>Date of Retirement</label>
				<input type="date" class="form-control">
				</div>
				<div class="col-md-3">
				<label>Next Incerement Date</label>
				<input type="date" class="form-control">
				</div>
				<div class="col-md-3">
				<label>Employee Status/label>
				<select class="form-control">
					<option>Select</option>
					<option>Probationary Employee</option>
					<option>Parmanent Employee</option>
				</select>
				</div>
			</div>
			
			<div class="row form-group">
			<div class="col-md-3">
				<label>Shift Group</label>
				<select class="form-control">
					<option>Select</option>
					<option>Day</option>
					<option>Night</option>
				</select>
				</div>
				<div class="col-md-3">
				<label>From Date</label>
				<input type="date" class="form-control">
				</div>
				<div class="col-md-3">
				<label>Till Date</label>
				<input type="date" class="form-control">
				</div>
				<div class="col-md-3 btn-up">
				<button class="btn btn-primary open1" type="button">Next <i class="ti-arrow-right"></i></button> 
				</div>
				
			</div>
			
			<!----------------------------------------->
			
			
            

          </fieldset>
        </div>

        <div id="sf2" class="frm" style="display: none;">
          <fieldset>
		  
		  <!------------pay-details-------------->
            <legend>Pay Details</legend>


            <div class="row form-group">
				<div class="col-md-3">
				<label>Grade</label>
					<select class="form-control">
						<option value="" label="Select">Select</option>
						<option value="">2-V-II</option>
						<option value="">2-V-III</option>
						<option value="">2-V-III</option>											
				</select>
				</div>
				<div class="col-md-3">
				<label>Group Name</label>
					<select data-placeholder="Choose a Grade..." class="form-control">
						<option value="" label="Select">Select</option>
						<option value="">A</option>
						<option value="">B</option>
						<option value="">C</option>
						<option value="">D</option>											
				</select>
				</div>
				<div class="col-md-3">
				<label>Pay Scale Code</label>
					<select class="form-control">
						<option value="" label="Select">Select</option>
						<option value="">2-V-II</option>
						<option value="">2-V-III</option>
						<option value="">2-V-III</option>											
				</select>
				</div>
				<div class="col-md-3">
				<label>Designation</label>
					<select class="form-control">
						<option value="" label="Select">Select</option>
						<option value="">Lower Division Clerk</option>
						<option value="">Upper Division Clerk</option>
						<option value="">Officer</option>											
				</select>
				</div>
			</div>
			
			<div class="row form-group">
				<div class="col-md-3">
				<label>Basic Pay</label>
					<input type="text" class="form-control">
				</div>
				<div class="col-md-3">
				<label>Pension No.</label>
					<input type="text" class="form-control">
				</div>
				<div class="col-md-3">
				<label>PF Type</label>
					<select data-placeholder="Choose a Grade..." class="form-control">
						<option value="" label="Select">Select</option>
						<option value="">NPS</option>
						<option value="">NPS</option>
						<option value="">NPS</option>											
				</select>
				</div>
				<div class="col-md-3">
				<label>Passport No.</label>
					<input type="text" class="form-control">
				</div>
			</div>
			
			<div class="row form-group">
				<div class="col-md-3">
				<label>Time Office Code</label>
					<input type="text" class="form-control">
				</div>
				<div class="col-md-3">
				<label>PF/PRAN No.</label>
					<input type="text" class="form-control">
				</div>
				<div class="col-md-3">
				<label>PAN No.</label>
					<input type="text" class="form-control">
				</div>
				<div class="col-md-3">
				<label>Payment Type</label>
					<select class="form-control">
						<option>Select</option>
						<option>Inter Bank</option>
						<option>Intra Bank</option>
					</select>
				</div>
			</div>
			
			<div class="row form-group">
				<div class="col-md-3">
				<label>Bank Name</label>
					<input type="text" class="form-control">
				</div>
				<div class="col-md-3">
				<label>IFSC Code</label>
					<input type="text" class="form-control">
				</div>
				<div class="col-md-3">
				<label>Account No.</label>
					<input type="text" class="form-control">
				</div>
			</div>
			
			<!------------------------------------>
			
			<!---------------educational-details------------>
			<table border="1" class="table table-bordered table-responsove" style="border-collapse:collapse;overflow-x:scroll;">
				<thead>
					<tr>
						<th>Sl.No.</th>
						<th>Qualification</th>
						<th>Discipline</th>
						<th>Institute Name</th>
						<th>Board/University</th>
						<th>Year of Passing</th>
						<th>Percentage</th>
						<th>Rank/Position</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>1</td>
						<td><input type="text" class="form-control"></td>
						<td><input type="text" class="form-control"></td>
						<td><input type="text" class="form-control"></td>
						<td><input type="text" class="form-control"></td>
						<td><input type="text" class="form-control"></td>
						<td><input type="text" class="form-control"></td>
						<td><input type="text" class="form-control"></td>
						<td style="width:150px;"><button class="btn btn-default pls"><i class="fa fa-plus"></i></button><button class="btn btn-default pls"><i class="fa fa-minus"></i></button></td>
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
            <legend>Nomination</legend>
			<table border="1" class="table table-bordered table-responsove" style="border-collapse:collapse;overflow-x:scroll;">
				<thead>
					<tr>
						<th>Sl.No.</th>
						<th>Name</th>
						<th>Relationship</th>
						<th>Age</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>1</td>
						<td><input type="text" class="form-control"></td>
						<td><input type="text" class="form-control"></td>
						<td><input type="text" class="form-control"></td>
						<td style="width:150px;"><button class="btn btn-default pls"><i class="fa fa-plus"></i></button><button class="btn btn-default pls"><i class="fa fa-minus"></i></button></td>
					</tr>
				</tbody>
			</table>
			
			<legend>Medical Information</legend>
            <div class="row form-group">
              <div class="col-md-4">
			  <label>Blood Group</label>
			  <select class="form-control">
			  <option>Select</option>
				<option>A +</option>
				<option>A -</option>
				<option>B +</option>
				<option>B -</option>
				<option>AB +</option>
				<option>AB -</option>
				<option>O +</option>
				<option>O -</option>
				<option>Unknown</option>
			</select>
			  </div>
			   <div class="col-md-4">
			  <label>Eye Sight (Left)</label>
			  <input type="text" class="form-control" id="">
			  </div>
			   <div class="col-md-4">
			  <label>Eye Sight (Right)</label>
			  <input type="text" class="form-control" id="">
			  </div>
            </div>
			
			
			
			 <div class="row form-group">
			 <div class="col-md-4">
			  <label class="">Family Plan Status</label>
			  <select class="form-control">
			  	<option>Select</option>
				<option>yes</option>
				<option>No</option>
			  </select>
			  </div>
              
			   <div class="col-md-4">
			  <label>Family Plan Date</span></label>
			  <input type="date" class="form-control" id="">
			  </div>
			   <div class="col-md-4">
			  <label>Height (in cm)</label>
			  <input type="text" class="form-control" id="">
			  </div>
            </div>
			
			
			<div class="row form-group">
              <div class="col-md-4">
			  <label class="">Weight (in Kgs)</label><br>
			  <input type="text" class="form-control">
			  </div>
			   <div class="col-md-4">
			  <label>Identification Mark (1)</label><br>
			  <input type="text" class="form-control">
			  </div>
			   <div class="col-md-4">
			  <label>Identification Mark (2)</label><br>
			  <input type="text" class="form-control">
			  </div>

               

            </div>
			<div class="row form-group">
			<div class="col-md-4">
				<label>Physical Status</label>
				<select class="form-control">
					<option>Select</option>
					<option>PWD</option>
					<option>Normal</option>
				</select>
				</div>
			</div>
			
			<!--parmanent-address----------->
			<legend>Parmanent Address</legend>
			<div class="row form-group">
				<div class="col-md-4">
					<label>Street No. and Name</label>
					<input type="text" class="form-control">
				</div>
				<div class="col-md-4">
					<label>City</label>
					<input type="text" class="form-control">
				</div>
				<div class="col-md-4">
					<label>State</label>
					<input type="text" class="form-control">
				</div>
			</div>
			
			<div class="row form-group">
				<div class="col-md-4">
					<label>Country</label>
					<input type="text" class="form-control">
				</div>
				<div class="col-md-4">
					<label>Pin Code</label>
					<input type="text" class="form-control">
				</div>
				
			</div>
			<!--------------------------->
			
			<!--present-address----------->
			<legend>Present Address <span><label class="checkbox-inline"><input type="checkbox" value="">( if Present Address is same as Parmanent Address )</label></span></legend>
			<div class="row form-group">
				<div class="col-md-4">
					<label>Street No. and Name</label>
					<input type="text" class="form-control">
				</div>
				<div class="col-md-4">
					<label>City</label>
					<input type="text" class="form-control">
				</div>
				<div class="col-md-4">
					<label>State</label>
					<input type="text" class="form-control">
				</div>
			</div>
			
			<div class="row form-group">
				<div class="col-md-4">
					<label>Country</label>
					<input type="text" class="form-control">
				</div>
				<div class="col-md-4">
					<label>Pin Code</label>
					<input type="text" class="form-control">
				</div>
				<div class="col-md-4">
					<label>Phone No.</label>
					<input type="text" class="form-control">
				</div>
				
			</div>
			<div class="row form-group">
				<div class="col-md-4">
					<label>Mobile No.</label>
					<input type="text" class="form-control">
				</div>
				<div class="col-md-4">
					<label>Email</label>
					<input type="email" class="form-control">
				</div>
				
			</div>
			<!--------------------------->
			
			<!---------contact-info------------>
			
			<!------------------------------->
			
          <div class="form-group">
             
                <button class="btn btn-warning back3" type="button"><i class="ti-arrow-left"></i> Back</button> 
                <button class="btn btn-primary open3" type="button">Next <i class="ti-arrow-right"></i></button> 
                <img src="spinner.gif" alt="" id="loader" style="display: none">
              </div>

          </fieldset>
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
<?php //include("footer.php"); ?>
</div>
<!-- /#right-panel -->
<!-- Scripts -->
 <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="assets/js/main.js"></script>
	
	
	<script src="assets/js/lib/data-table/datatables.min.js"></script>
    <script src="assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
    <script src="assets/js/lib/data-table/dataTables.buttons.min.js"></script>
    <script src="assets/js/lib/data-table/buttons.bootstrap.min.js"></script>
    <script src="assets/js/lib/data-table/jszip.min.js"></script>
    <script src="assets/js/lib/data-table/vfs_fonts.js"></script>
    <script src="assets/js/lib/data-table/buttons.html5.min.js"></script>
    <script src="assets/js/lib/data-table/buttons.print.min.js"></script>
    <script src="assets/js/lib/data-table/buttons.colVis.min.js"></script>
    <script src="assets/js/init/datatables-init.js"></script>
	
	 <script type="text/javascript">
        $(document).ready(function() {
          $('#bootstrap-data-table-export').DataTable();
      } );
	</script>
	

    
<script type="text/javascript" src="assets/js/jquery.validate.js"></script>	
<script type="text/javascript">
  
  jQuery().ready(function() {

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
        $("#loader").show();
         setTimeout(function(){
           $("#basicform").html('<h2>Employee Added Successfully</h2>');
         }, 1000);
        return false;
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
</body>
</html>