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
            <div class="card-header" style="font-weight: 100; font-size: 21px !important;"><strong class="card-title"><img src="{{asset('images/requisition.png')}}" alt="" style="width:30px;">Edit Purchase Request</strong></div>
            <div class="card-body card-block">
              <form action="{{ url('procurement/indent/edit-request') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
			  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @foreach($items as $key=>$item)

                <input type="hidden" name="indent_no" id="indent_no" value="<?php if(!empty($item->requisition_no)){ echo $item->requisition_no; } ?>">

                <div class="clearfix"></div>
                <div class="lv-due" style="border:none;">

                  <div class="row form-group lv-due-body">
                    <div class="col-md-2">
					<?php $tr_id=$key; ?>
                      <label for="text-input" class=" form-control-label">Item Name</label>
                      <select class="form-control" id="item_code<?php echo $tr_id; ?>" name="item_code[]" onchange="getdetails(this.value,<?php echo $tr_id; ?>);" required readonly  >
                        <option value="" selected disabled>Select</option>
                        @foreach($item_rs as $item_new)
                        <option value="{{ $item_new->item_code }}" <?php if(!empty($item->item_code)){ if($item_new->item_code == $item->item_code) { echo "selected"; } } ?>>{{ $item_new->name }}</option>
						@endforeach
                      </select>
					   @if ($errors->has('item_code'))
						<div class="error" style="color:red;">{{ $errors->first('item_code') }}</div>
						@endif
					  </div>
					  <div class="col-md-2">
                      <label for="text-input" class=" form-control-label">Item Type</label>
                      <input type="text" class="form-control" name="item_type[]" id="item_type<?php echo $tr_id; ?>" value="<?php if(!empty($item->item_type)){ echo $item->item_type; } ?>" readonly>
                    </div>
					<div class="col-md-2">
						<label>Unit</label>
						 <input type="text" class="form-control"  id="unit<?php echo $tr_id; ?>" value="<?php if(!empty($item->unit_id)){ echo $item->unit_name; } ?>" readonly>
						  <input type="hidden" class="form-control" name="unit_id[]" id="unit_id<?php echo $tr_id; ?>" value="<?php if(!empty($item->unit_id)){ echo $item->unit_id; } ?>" >
					   @if ($errors->has('unit_id'))
						<div class="error" style="color:red;">{{ $errors->first('unit_id') }}</div>
						@endif
					</div>
					<div class="col-md-1">
						<label>Price</label>
						<input type="text" class="form-control" id="price<?php echo $tr_id; ?>" value="<?php if(!empty($item->price)){ echo $item->price; } ?>" name="price[]">
					</div>
					<div class="col-md-1">
						<label>Qty</label>
						<input type="text" class="form-control" id="quantity<?php echo $tr_id; ?>" name="quantity[]" value="<?php if(!empty($item->quantity)){ echo $item->quantity; } ?>"  onblur="gettotal(<?php echo $tr_id; ?>);">
					</div>
					<div class="col-md-2">
						<label>Total</label>
						<input type="text" class="form-control" id="total<?php echo $tr_id; ?>" value="<?php if(!empty($item->total)){ echo $item->total; } ?>" name="total[]" >
					</div>
					  <div class="col-md-2 btn-up">

						<button type="button" class="btn btn-danger deleteButton" onClick="del('<?php echo $tr_id; ?>')"> <i class="fa fa-trash" aria-hidden="true"></i>Remove</button>
					  </div>

					  </div>
					  @endforeach
					   <div id="addrow"></div>
					  </div>

					  <button type="button" class="btn btn-danger btn-add" id="add<?php echo $tr_id; ?>" onClick="addnewrow(<?php echo $tr_id; ?>)" data-id="<?php echo $tr_id; ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i>Add More</button>
					  <br><br>
					  <div class="row form-group">

					 <div class="col-md-4">
					 	<label>Requisition Made by Department</label>
						<!-- <input type="text" class="form-control" readonly="" value="Department Name"  name="department_name"> -->
						<select class="form-control" name="department_name" id="department_id" onchange="selectEmployee()" required readonly>
							<option value="" selected disabled>Select</option>
							@foreach($department_rs as $department)
							<option value="{{ $department->department_name }}" <?php if(!empty($item->department_name)){ if($department->department_name == $item->department_name) { echo "selected"; } } ?>>{{ $department->department_name }}</option>
							@endforeach
						</select>
					    @if ($errors->has('department_name'))
						 <div class="error" style="color:red;">{{ $errors->first('department_name') }}</div>
						@endif
					 </div>
					  <div class="col-md-4">
					  <label>Requisition Made By</label>
					   <select class="form-control" name="empployee_id" id="empployee_id" readonly>

              		  </select>
					  </div>
					  <div class="col-md-4">
					  <label>Remarks</label>
					  <textarea rows="2" class="form-control" name="remarks" value="" required readonly><?php if(!empty($item->remarks)){ echo $item->remarks; } ?></textarea>
					  </div>
					  </div>

					  <div class="row form-group">
					  <div class="col-md-3">
					  <label>Request Date</label>
					  <input type="text" class="form-control" name="request_date" value="<?php if(!empty($item->requisition_date)){ echo $item->requisition_date; } ?>" required readonly>
					  @if ($errors->has('request_date'))
						<div class="error" style="color:red;">{{ $errors->first('request_date') }}</div>
						@endif
					  </div>
					  <div class="col-md-3">
					  <label>Required Date</label>
					  <input type="date" class="form-control" name="required_date" value="<?php if(!empty($item->required_date)){ echo $item->required_date; } ?>" required readonly>
					  @if ($errors->has('required_date'))
						<div class="error" style="color:red;">{{ $errors->first('required_date') }}</div>
						@endif
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
	function addnewrow(rowid)
	{

		var numItems = $('.lv-due').length;

		$('#addrow').append('<div class="lv-due" style="border:none;"><div class="row form-group lv-due-body"><div class="col-md-2"><label for="text-input" class=" form-control-label">Item Name</label><select class="form-control" id="item_code'+numItems+'" name="item_code[]" onchange="getdetails(this.value,'+numItems+')"><option value="">Select</option>@foreach($item_rs as $item_new)<option value="{{ $item_new->item_code }}" >{{ $item_new->name }}</option>@endforeach</select></div><div class="col-md-2"><label for="text-input" class=" form-control-label">Item Type</label><input type="text" class="form-control" id="item_type'+numItems+'" name="item_type[]" readonly></div><div class="col-md-2"><label for="text-input" class=" form-control-label">Unit</label><input type="text" class="form-control"  id="unit'+numItems+'" readonly><input type="hidden" class="form-control" name="unit_id[]" id="unit_id'+numItems+'"></div><div class="col-md-1"><label>Price</label><input type="text" class="form-control" id="price'+numItems+'" name="price[]"></div><div class="col-md-1"><label>Qty</label><input type="text" class="form-control" id="quantity'+numItems+'" name="quantity[]" onblur="gettotal('+numItems+');"></div><div class="col-md-2"><label for="text-input" class=" form-control-label">Total</label><input type="text" class="form-control" id="total'+numItems+'" name="total[]" ></div><div class="col-md-2 btn-up" style="text-align: right;"><button type="button" id="del" class="btn btn-danger deleteButton" onClick="remove('+numItems+')"> <i class="fa fa-trash" aria-hidden="true"></i>Remove</button></div></div></div>');

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
		alert(val);
		$.ajax({

				url:'{{url('procurement/indent/get-item-details')}}/'+val+'/'+rowid,
				type: "GET",

				success: function(jsonStr) {

					//alert(jsonStr);
					var jqObj = jQuery.parseJSON(jsonStr);
					console.log(jqObj);
					//alert(jqObj.rate);
					//$("#price"+rowid).val(jqObj.rate);
					$("#item_code"+rowid).val(val);
					$("#item_type"+rowid).val(jqObj.item_type);
					$("#unit"+rowid).val(jqObj.unit_name);
					$("#unit_id"+rowid).val(jqObj.unit_id);

				}
			});
	}

	selectEmployee();

    var select_emp = "<?php  if(!empty($item->requisition_made_by)){ echo $item->requisition_made_by;}?>";

    setTimeout(function(){
      if(select_emp!=""){
        $("#empployee_id option[value='"+select_emp+"']").prop('selected', 'selected');
      }
    },1000);

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
