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

<style>
 .btn-add {
    background: green !important;
    border: 1px solid green !important;
    /*position: absolute !important;*/
    right: 11% !important;
    top: 69px !important;
}
.deleteButton {
    background-color: #c53f09 !important;
    border-color: #c53f09 !important;
}
.btn-sm {
    color: #fff !important;
    background-color: #278a05 !important;
    border-color: #278a05 !important;
    border-radius: 0 !important;
}
</style>


@section('content')
  <!-- Content -->
  <div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
      <!-- Widgets  -->
      <div class="row">
        <div class="main-card">
          <div class="card">
            <div class="card-header" style="font-weight: 100; font-size: 21px !important;"><strong class="card-title"><img src="{{asset('images/requisition.png')}}" alt="" style="width:30px;">Add New Purchase Request</strong></div>
            <div class="card-body card-block">
              <form action="{{ url('procurement/indent/add-new-requisition-item') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
			  <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="clearfix"></div>
                <div class="lv-due" style="border:none;">

                  <div class="row form-group lv-due-body">
                    <div class="col-md-2">
					<?php $tr_id=1; ?>
                      <label for="text-input" class=" form-control-label">Item Name</label>
                      <select class="form-control" name="item_code[]" onchange="getdetails(this.value,<?php echo $tr_id; ?>);" required>
                        <option value="" selected disabled>Select</option>
                        @foreach($item_rs as $item)
                        <option value="{{ $item->item_code }}">{{ $item->name }}</option>
						@endforeach
                      </select>
					   @if ($errors->has('item_code'))
						<div class="error" style="color:red;">{{ $errors->first('item_code') }}</div>
						@endif
					  </div>
					  <div class="col-md-2">
                      <label for="text-input" class=" form-control-label">Item Type</label>
                      <input type="text" class="form-control" name="item_type[]" id="item_type<?php echo $tr_id; ?>" readonly>
                    </div>
					<div class="col-md-1">
						<label>Unit</label>
						 <input type="text" class="form-control"  id="unit<?php echo $tr_id; ?>" readonly>
						  <input type="hidden" class="form-control" name="unit_id[]" id="unit_id<?php echo $tr_id; ?>" >
					   @if ($errors->has('unit_id'))
						<div class="error" style="color:red;">{{ $errors->first('unit_id') }}</div>
						@endif
					</div>
					<div class="col-md-2">
						<label>Price<span>(*)</span></label>
						<input type="text" class="form-control" id="price<?php echo $tr_id; ?>" name="price[]" required>
					</div>
					<div class="col-md-1">
						<label>Qty<span>(*)</span></label>
						<input type="text" class="form-control" id="quantity<?php echo $tr_id; ?>" name="quantity[]" onblur="gettotal(<?php echo $tr_id; ?>);" required>
					</div>
					<div class="col-md-2">
						<label>Total</label>
						<input type="text" class="form-control" id="total<?php echo $tr_id; ?>" name="total[]" readonly>
					</div>
					  <div class="col-md-2 btn-up">

						<button type="button" class="btn btn-danger deleteButton" onClick="del('<?php echo $tr_id; ?>')"> <i class="fa fa-trash" aria-hidden="true"></i>Remove</button>
					  </div>

					  </div>
					   <div class="addrow"></div>
					  </div>

					  <button type="button" class="btn btn-danger btn-add" id="add<?php echo $tr_id; ?>" onClick="addnewrow()" data-id="<?php echo $tr_id; ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i>Add More</button>
					  <br><br>
					  <div class="row form-group">

					 <div class="col-md-4">
					 	<label>Purchase Request Made by Department</label>
						<!-- <input type="text" class="form-control" readonly="" value="Department Name"  name="department_name"> -->
						<select class="form-control" name="department_name" id="department_id" onchange="selectEmployee()" required>
							<option value="" selected disabled>Select</option>
							@foreach($department_rs as $department)
							<option value="{{ $department->department_name }}">{{ $department->department_name }}</option>
							@endforeach
						</select>
					    @if ($errors->has('department_name'))
						 <div class="error" style="color:red;">{{ $errors->first('department_name') }}</div>
						@endif
					 </div>
					  <div class="col-md-4">
					  <label>Purchase Request Made By</label>
					   <select class="form-control" name="empployee_id" id="empployee_id">

              		  </select>
					  </div>

                          <div class="col-md-4">
                              <label>Purchase Request Date</label>
                              <input type="text" class="form-control" name="request_date" value="<?php if(!empty($item->request_date)){ echo $item->request_date; } else { echo date('d-m-Y'); } ?>" required readonly>
                              @if ($errors->has('request_date'))
                                  <div class="error" style="color:red;">{{ $errors->first('request_date') }}</div>
                              @endif
                          </div>

					  </div>

					  <div class="row form-group">

					  <div class="col-md-3">
					  <label>Required Date<span>(*)</span></label>
					  <input type="date" class="form-control" name="required_date" value="<?php if(!empty($item->required_date)){ echo $item->required_date; } ?>" >
					  @if ($errors->has('required_date'))
						<div class="error" style="color:red;">{{ $errors->first('required_date') }}</div>
						@endif
					  </div>
                          <div class="col-md-3">
                              <label>File Upload</label>
                              <input type="file" class="form-control" name="doc_upload">
                              @if ($errors->has('doc_upload'))
                                  <div class="error" style="color:red;">{{ $errors->first('doc_upload') }}</div>
                              @endif
                          </div>
                          <div class="col-md-6">
                              <label>Remarks</label>
                              <textarea rows="2" class="form-control" name="remarks"></textarea>
                          </div>
					  </div>
					  <div class="row form-group">



					<div class="col-md-4 btn-up">
						<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-thumbs-o-up" aria-hidden="true" style="font-size:18px;"></i>Submit</button>

					</div>
                  </div>

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
	function addnewrow()
	{
		// if (rowid != ''){
		// 		$('#add'+rowid).attr('disabled',true);

		// 	}


		// rowid++;

		var rowid = $('.lv-due-body').length;
		// alert(rowid);
		$.ajax({

				url:'{{url('procurement/indent/get-add-row-req-item')}}/'+rowid,
				type: "GET",

				success: function(jsonStr) {
					// console.log(jsonStr);
					$(".addrow").append(jsonStr);
				 	rowid++;
				}
			});
	}
	function del(rowid)
	{
		//alert(rowid);
		if (rowid != ''){
		$('#add'+rowid).attr('disabled',false);
		}
		$(".itemslot" + rowid).html('');
		var row = rowid - 1;
		$('#add'+row).attr('disabled',false);
	}

	function gettotal(rowid)
	{
		var price = $("#price"+rowid).val();
		var qty = $('#quantity'+rowid).val();
		//alert(price);
		var total = price * qty;
		$("#total"+rowid).val(total);
	}

	function getdetails(val,rowid)
	{
		//alert(val);
		$.ajax({

				url:'{{url('procurement/indent/get-item-details')}}/'+val+'/'+rowid,
				type: "GET",

				success: function(jsonStr) {

					//alert(jsonStr);
					var jqObj = jQuery.parseJSON(jsonStr);
					//alert(jqObj.rate);
					//$("#price"+rowid).val(jqObj.rate);
					$("#item_type"+rowid).val(jqObj.item_type);
					$("#unit"+rowid).val(jqObj.unit_name);
					$("#unit_id"+rowid).val(jqObj.unit_id);

				}
			});
	}

	selectEmployee();

 //    var select_emp = "<?php  if(!empty($item->indent_made_by)){ echo $item->indent_made_by;}?>";

 //    setTimeout(function(){
 //      if(select_emp!=""){
 //        $("#empployee_id option[value='"+select_emp+"']").prop('selected', 'selected');
 //      }
 //    },1000);

	function selectEmployee(){
      var department_id = $("#department_id option:selected").val();
      $.ajax({
        type:'GET',
        url:'{{url('dak/employeelist')}}/'+department_id,
        success: function(response){

            // console.log(response);
            var option = '';
            option += '<option value="">Select Employee</option>';
            for (var i=0;i<response.length;i++){
              option += '<option value="'+ response[i].emp_code+ '">' + response[i].emp_fname + " " +response[i].emp_mname + " " +response[i].emp_lname+  "(" +response[i].emp_code+ ")" + '</option>';
            }
            $('#empployee_id').html(option);

        }
      });
    }

</script>

@endsection
