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
color: #fff;font-size: 18px;text-transform: uppercase;}.modal-header .close{color:#fff;opacity:1;}#myModal button:hover, button:focus, .button:hover, .button:focus{background:none;}label{font-weight:600;margin-bottom:8px;}.modal-body{background: #f5f5f5;}fieldset {background: #fff;} fieldset h4{color: #01a798;}.custom-file-label::after{background-color:#01a798;color: #fff;}.card form label{font-weight:600;}.card .sel-form{width: 650px;margin: 0 auto;padding:30px 30px 0;} .btn.btn-default{background: #01a798;color: #fff;height: 30px;width: 40px;padding: 3px;}button.btn.btn-success {background: #01a798;border-color: #01a798;}.form-control{height:35px;}.hide{display:none;}select.form-control{height:35px;}
.card form{padding:0;}.row{max-width:100%;}table thead, table tfoot {background: #dcdbdb;}.table-bordered thead td, .table-bordered thead th {border-bottom-width: 2px;  vertical-align: top;text-align: center;}#addmorePOIbutton{font-size: 22px;height: 32px;padding: 0 9px;}
</style>

<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
      <!-- Widgets  -->
      <div class="row">
	
	  <form name="basicform" id="basicform" method="post" action="" enctype="multipart/form-data" >
       {{ csrf_field() }}
        <div class="main-card">
		<div class="card">
		 <div class="card-header"> <strong>Educational Qualification</strong> </div>
		 
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
            <div class="card-header"> <strong>Educational Qualification</strong> </div>
            <div class="card-body card-block">
            	
              <table class="table table-bordered" >
			  	<thead>
					<tr>
						<th>Qualification</th>
						<th>Discipline</th>
						<th>Institute Name</th>
						<th>Board/University</th>
						<th>Year of Passing</th>
						<th>Percentage</th>
						<th>Grade</th>
						<th>Upload Image</th>
					</tr>
				</thead>
				
				<tbody id="eduTable">
					
				</tbody>
			  </table>
			  <div class="col-md-2">
						<button type="submit" class="btn btn-default">Save</button>
			  </div>
			
          </div>
        </div>
      </div>
    </div>
    </form>
    <!-- /Widgets -->
  </div>
  <!-- .animated -->
</div>
<!-- /.content -->
<div class="clearfix"></div>



@endsection

@section('scripts')

@include('employee.partials.scripts')

<script>

$( document ).ready(function() {
    
	

});


/*$('#diarySubmit').click(function () {
        var distanceRan = $("#distanceField").val();
        var timeRan = $("#timeField").val();
        var dateRan = $("#dateField").val();
        $('#POITable').append("<tr>" + "<td>" + dateRan + "</td>" + "<td>" + distanceRan + "</td>" + "<td>" + timeRan + "</td>" + "</tr>");
});*/
	






	function getEmpCode()
	{
		var empcode = $("#empcode option:selected").val();
			//alert(empcode);
		$.ajax({
			type:'GET',
			url:'{{url('empdetails')}}/'+empcode,				
			success: function(response){

				//console.log(response);
				var obj = jQuery.parseJSON(response);
				$('#eduTable').html('<tr><td>'+obj.emp_viii_qualification +'</td><td>'+obj.emp_viii_dicipline +'</td><td>'+obj.emp_viii_inst_name +'</td><td>'+obj.emp_viii_board_name +'</td><td>'+obj.emp_viii_pass_year +'</td><td>'+obj.emp_viii_percentage +'</td><td>'+obj.emp_viii_rank +'</td><td><input type="file" name="eight_certificate" class="form-control"></td></tr><tr><td>'+obj.emp_x_qualification +'</td><td>'+obj.emp_x_dicipline +'</td><td>'+obj.emp_x_institute_name +'</td><td>'+obj.emp_x_board_name +'</td><td>'+obj.emp_x_pass_year +'</td><td>'+obj.emp_x_percentage +'</td><td>'+obj.emp_x_rank +'</td><td><input type="file" class="form-control" name="ten_certificate"></td></tr><tr><td>'+obj.emp_xii_qualification +'</td><td>'+obj.emp_xii_dicipline +'</td><td>'+obj.emp_xii_institute_name +'</td><td>'+obj.emp_xii_board_name +'</td><td>'+obj.emp_xii_pass_year +'</td><td>'+obj.emp_x_percentage +'</td><td>'+obj.emp_x_rank +'</td><td><input type="file" name="tenplustwo_certificate" class="form-control"></td></tr><tr><td>'+obj.emp_graduate_qualification +'</td><td>'+obj.emp_graduate_dicipline +'</td><td>'+obj.emp_graduate_institute_name +'</td><td>'+obj.emp_graduate_board_name +'</td><td>'+obj.emp_graduate_pass_year +'</td><td>'+obj.emp_graduate_percentage +'</td><td>'+obj.emp_graduate_rank +'</td><td><input type="file" class="form-control" name="graduate_certificate"></td></tr><tr><td>'+obj.emp_pgraduate_qualification +'</td><td>'+obj.emp_pgraduate_dicipline +'</td><td>'+obj.emp_pgraduate_institute_name +'</td><td>'+obj.emp_pgraduate_board_name +'</td><td>'+obj.emp_pgraduate_pass_year +'</td><td>'+obj.emp_pgraduate_pass_year +'</td><td>'+obj.emp_pgraduate_rank +'</td><td><input type="file" class="form-control" name="pgraduate_certificate"></td></tr><tr><td>'+obj.emp_other_qualification +'</td><td>'+obj.emp_other_dicipline +'</td><td>'+obj.emp_other_inst_name +'</td><td>'+obj.emp_other_board_name +'</td><td>'+obj.emp_other_pass_year +'</td><td>'+obj.emp_other_percentage +'</td><td>'+obj.emp_other_rank +'</td><td><input type="file" class="form-control" name="other_certificate"></td></tr>');
			}
			
		});

	}

</script>  
@endsection




