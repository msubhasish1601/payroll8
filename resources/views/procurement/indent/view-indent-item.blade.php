@extends('procurement.indent.layouts.master')

@section('title')
Payroll Information System-Company
@endsection

@section('sidebar')
	@include('procurement.indent.partials.sidebar')
@endsection

@section('header')
	@include('procurement.indent.partials.header')
@endsection



@section('content')
<style>
	.card-title {
    	font-size: 21px !important;
	}

	.deleteButton {
		background-color: #c53f09 !important;
    	border-color: #c53f09 !important;

	}

	#create_button {
	    background: green;
	    border: 1px solid green;
	    /*position: absolute;*/
	    right: 11%;
	    top: 69px;
	}
</style>
  <div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
      <!-- Widgets  -->
      <div class="row">
        <div class="main-card">
          <div class="card">
            <div class="card-header"><strong class="card-title">View Indent Item</strong></div>
            <div class="card-body card-block">
              <form action="{{ url('procurement/indent/vw-indent-item') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
			  <input type="hidden" name="_token" value="{{ csrf_token() }}">
			  

			  @foreach($items as $key => $item)
                <input type="hidden" name="id" id="hidden_id" value="<?php if(!empty($item->id)){ echo $item->id; } ?>">
                <input type="hidden" name="indent_no" id="indent_no" value="<?php if(!empty($item->indent_no)){ echo $item->indent_no; } ?>">

                <div class="clearfix"></div>
                <div class="lv-due" style="border:none;">
                  <!--<div class="lv-due-hd">
											<h4>Leave Due as on</h4>
										</div>-->
                  <div class="row form-group lv-due-body">
                    <div class="col-md-2">
					
                      <label for="text-input" class=" form-control-label">Item Name</label>
						<input type="text" class="form-control" id="item_id<?php echo $key; ?>" value="<?php if(!empty($item->item_id)){ echo $item->item_name; } ?>" readonly>
						<input type="hidden" class="form-control" name="item_code[]" id="item_code<?php echo $key; ?>" value="<?php if(!empty($item->item_id)){ echo $item->item_id; } ?>">
					   @if ($errors->has('item_code'))
						<div class="error" style="color:red;">{{ $errors->first('item_code') }}</div>
						@endif
					  </div>
					  <div class="col-md-1">
                      <label for="text-input" class=" form-control-label">Type</label>
                      <input type="text" class="form-control" name="item_type[]" id="item_type<?php echo $key; ?>" value="<?php if(!empty($item->item_type)){ echo $item->item_type; } ?>" readonly>
					   @if ($errors->has('item_type'))
						<div class="error" style="color:red;">{{ $errors->first('item_type') }}</div>
						@endif
                      </div>
					  <div class="col-md-1">
                      <label for="text-input" class=" form-control-label">Unit</label>
                
					  <input type="text" class="form-control"  id="unit<?php echo $key; ?>" value="<?php if(!empty($item->unit_id)){ echo $item->unit_name; } ?>" readonly>
					  <input type="hidden" class="form-control" name="unit_id[]" id="unit_id<?php echo $key; ?>" value="<?php if(!empty($item->unit_id)){ echo $item->unit_id; } ?>">
						  
					   @if ($errors->has('unit_id'))
						<div class="error" style="color:red;">{{ $errors->first('unit_id') }}</div>
						@endif
					  </div>
					  <div class="col-md-2">
                      <label for="text-input" class=" form-control-label">Required Qty.</label>
                      <input type="text" class="form-control" name="required_qty[]" id="required_qty<?php echo $key; ?>" value="<?php if(!empty($item->required_qty)){ echo $item->required_qty; } ?>" readonly >
					   @if ($errors->has('required_qty'))
						<div class="error" style="color:red;">{{ $errors->first('required_qty') }}</div>
						@endif
                    </div>

                    <div class="col-md-2">
                      <label for="text-input" class=" form-control-label">Aprroved Qty.</label>
                      <input type="text" class="form-control" name="approved_qty[]" id="approved_qty<?php echo $key; ?>" onblur="getRejectedItems(<?php echo $key; ?>)" value="<?php if(!empty($item->approved_qty)){ echo $item->approved_qty; } ?>" >
					   @if ($errors->has('approved_qty'))
						<div class="error" style="color:red;">{{ $errors->first('approved_qty') }}</div>
						@endif
                    </div>
                    <div class="col-md-2">
                      <label for="text-input" class=" form-control-label">Rejected Qty.</label>
                      <input type="text" class="form-control" name="rejected_qty[]" id="rejected_qty<?php echo $key; ?>" value="<?php if(!empty($item->rejected_qty)){ echo $item->rejected_qty; } ?>" readonly >
					   @if ($errors->has('rejected_qty'))
						<div class="error" style="color:red;">{{ $errors->first('rejected_qty') }}</div>
						@endif
                    </div>
                    <div class="col-md-2">
                      <label for="text-input" class=" form-control-label">Status</label>
                      <select class="form-control" name="status[]" required >
                      	<option value="" >Select</option>
                      	<option value="approved" selected>Approve</option>
                      	<option value="rejected">Reject</option>
                      </select>
                      <!-- <input type="text" class="form-control" name="status[]" id="status<?php echo $key; ?>" value="<?php if(!empty($item->status)){ echo $item->status; } ?>" > -->
					   @if ($errors->has('status'))
						<div class="error" style="color:red;">{{ $errors->first('status') }}</div>
						@endif
                    </div>
                    <div class="col-md-2" style="display: none;" id="reason">
                      <label for="text-input" class=" form-control-label">Reason</label>
                      <textarea name="reason"></textarea> 
                      <!-- <input type="text" class="form-control" name="status[]" id="status<?php echo $key; ?>" value="<?php if(!empty($item->status)){ echo $item->status; } ?>" > -->
					   @if ($errors->has('reason'))
						<div class="error" style="color:red;">{{ $errors->first('reason') }}</div>
						@endif
                    </div>
					  
					  
					  </div>
					  <div class="addrow"></div>
					  </div>
					  @endforeach
					  <div class="row form-group">
					  
                     <div class="col-md-3">
					 	<label>Indent Made By Department</label>
						<!-- <input type="text" class="form-control" readonly="" name="department_name" value="Department1"> -->
						
						<input type="text" class="form-control" name="department_name" value="<?php  echo $items[0]->department_name;  ?>" readonly>
					    @if ($errors->has('department_name'))
						 <div class="error" style="color:red;">{{ $errors->first('department_name') }}</div>
						@endif
					 </div>
					  <div class="col-md-3">
					  <label>Indent Made By</label>
					
              		  <input type="text " class="form-control" name="empployee_name" value="<?php echo $items[0]->emp_fname. " ".$items[0]->emp_mname. " ".$items[0]->emp_lname;  ?>" readonly>
              		  <input type="hidden" name="empployee_id" id="empployee_id" value="<?php if(!empty($item->indent_made_by)){ echo $item->indent_made_by; } ?>">
					  </div>
					  <div class="col-md-3">
					  <label>Indent Date</label>
					  <input type="date" class="form-control" name="indent_date" value="<?php echo $items[0]->indent_date;  ?>" readonly>
					  @if ($errors->has('indent_date'))
						<div class="error" style="color:red;">{{ $errors->first('indent_date') }}</div>
						@endif
					  </div>
					  <div class="col-md-3">
					  <label>Required Date</label>
					  <input type="date" class="form-control" name="required_date" value="<?php echo $items[0]->required_date;  ?>" readonly>
					  @if ($errors->has('required_date'))
						<div class="error" style="color:red;">{{ $errors->first('required_date') }}</div>
						@endif
					  </div>
					  </div>
					  <!-- <div class="row form-group">
                   		<div class="col-md-3">
			              <div><label>Status</label></div>
			              <div class="radio-inline">
			                <label><input type="radio" name="status" value="approved">Approved</label>&nbsp;&nbsp;
			              </div>
			               <div class="radio-inline">
			                <label><input type="radio" name="status" value="rejected">Rejected</label>
			              </div>
			            </div>
                  	</div> -->
                  
				  
						<button type="submit" class="btn btn-danger btn-sm">Submit</button>
                     <!-- <button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Reset</button> -->
              </form>
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
@endsection



@section('scripts')
	@include('procurement.indent.partials.scripts')
	


<script>
	// var hidden_id = $('#hidden_id').val();
	// // alert(hidden_id);

	// if(hidden_id != '')
	// {	
	// 	var rowid = 1;
	// 	$('#add'+rowid).attr('disabled',true);
	// 	$('#del').attr('disabled',true);
	// }
	// else
	// {
	// 	var rowid = 1;
	// 	$('#add'+rowid).attr('disabled',false);
	// 	$('#del').attr('disabled',false);
	// }

	// function addnewrow(rowid) 
	// {
		
	// 	if (rowid != ''){
	// 			$('#add'+rowid).attr('disabled',true);
				
	// 	}
		
		
		
	// 	//alert(rowid);
	// 	$.ajax({
				
	// 			url:'{{url('procurement/indent/get-add-row-item')}}/'+rowid,
	// 			type: "GET",
				
	// 			success: function(response) {
					
	// 				$(".addrow").append(response);  
				 
	// 			}
	// 		});
	// }
	// function del(rowid)
	// {
	// 	//alert(rowid);
	// 	if (rowid != ''){
	// 	$('#add'+rowid).attr('disabled',false);
	// 	}
	// 	$(".itemslot" + rowid).html('');
	// 	var row = rowid - 1;
	// 	$('#add'+row).attr('disabled',false);
	// }
	
	// function gettotal(rowid)
	// {
	// 	var price = $("#price"+rowid).val();
	// 	var qty = $('#quantity'+rowid).val();
	// 	//alert(price);
	// 	var total = price * qty;
	// 	$("#total"+rowid).val(total);
	// }
	
	// function getdetails(val,rowid)
	// {
	// 	//alert(val);
	// 	$.ajax({
				
	// 			url:'{{url('procurement/indent/get-item-details')}}/'+val+'/'+rowid,
	// 			type: "GET",
				
	// 			success: function(response) {
					
	// 				// alert(response);
	// 				var jqObj = jQuery.parseJSON(response);
	// 				//alert(jqObj.rate);
	// 				//$("#price"+rowid).val(jqObj.rate);  
	// 				$("#item_type"+rowid).val(jqObj.type);  
	// 				$("#unit"+rowid).val(jqObj.unit_name);  
	// 				$("#unit_id"+rowid).val(jqObj.unit_id);    
				 
	// 			}
	// 		});
	// }

	// // selectEmployee();

 // //    var select_emp = "<?php  if(!empty($item->indent_made_by)){ echo $item->indent_made_by;}?>";
  
 // //    setTimeout(function(){
 // //      if(select_emp!=""){
 // //        $("#empployee_id option[value='"+select_emp+"']").prop('selected', 'selected'); 
 // //      }
 // //    },1000);

	// // function selectEmployee(){
 // //      var department_id = $("#department_id option:selected").val();
 // //      $.ajax({
 // //        type:'GET',
 // //        url:'{{url('dak/employeelist')}}/'+department_id,        
 // //        success: function(response){
          
 // //            // console.log(response);
 // //            var option = '';
 // //            option += '<option value="">Select Employee</option>';
 // //            for (var i=0;i<response.length;i++){
 // //              option += '<option value="'+ response[i].emp_code+ '">' + response[i].emp_fname + " " +response[i].emp_mname + " " +response[i].emp_lname+  "(" +response[i].emp_code+ ")" + '</option>';
 // //            }
 // //            $('#empployee_id').html(option);
                     
 // //        }
 // //      });
 //    }
 

 	function getRejectedItems(rowid)
	{
		// alert(rowid);

		var req_item = $('#required_qty'+rowid).val();
		var aprv_item = $('#approved_qty'+rowid).val();
		var rej_item = req_item - aprv_item;

		$('#rejected_qty'+rowid).val(rej_item);

		if(req_item != aprv_item)
		{
			$('#reason'+rowid).show();
		}
		else
		{
			$('#reason'+rowid).hide();
		}
		

	}

	


</script>
	
@endsection
