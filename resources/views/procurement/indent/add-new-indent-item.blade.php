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

	.btn-add {
	    background: green !important;
	    border: 1px solid green !important;
	    /*position: absolute !important;*/
	    right: 11% !important;
	    /*top: 69px !important;*/
	}

	.btn-sm {
	    color: #fff !important;
	    background-color: #278a05 !important;
	    border-color: #278a05 !important;
	    border-radius: 0 !important;
	}
</style>
  <div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
      <!-- Widgets  -->
      <div class="row">
        <div class="main-card">
          <div class="card">
            <div class="card-header"><strong class="card-title">Add New Indent for Item</strong></div>
            <div class="card-body card-block">
              <form action="{{ url('procurement/indent/add-new-indent-item') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
			  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" id="hidden_id" value="<?php if(!empty($item->id)){ echo $item->id; } ?>">
                <input type="hidden" name="indent_no" id="indent_no" value="<?php if(!empty($item->indent_no)){ echo $item->indent_no; } ?>">

                <div class="clearfix"></div>
                <div class="lv-due" style="border:none;" id="dynamic_row">
                  <!--<div class="lv-due-hd">
											<h4>Leave Due as on</h4>
										</div>-->
										<?php $tr_id=1; ?>
                  <div class="row form-group lv-due-body itemslot" id="<?php echo $tr_id; ?>">
                    <div class="col-md-3">

                      <label for="text-input" class=" form-control-label">Item Name</label>
                       <select class="form-control" name="item_code[]" id="item_code<?php echo $tr_id; ?>" onchange="getdetails(this.value,<?php echo $tr_id; ?>);" required>
                        <option value="" selected disabled>Select</option>
                        @foreach($item_rs as $item_new)
                        <option value="{{ $item_new->item_code }}" <?php if(!empty($item->item_id)){ if($item_new->item_code == $item->item_id) { echo "selected"; } } ?> >{{ $item_new->name }}</option>
						@endforeach
                      </select>
					   @if ($errors->has('item_code'))
						<div class="error" style="color:red;">{{ $errors->first('item_code') }}</div>
						@endif
					  </div>
					  <div class="col-md-2">
                      <label for="text-input" class=" form-control-label">Item Type</label>
                      <input type="text" class="form-control" name="item_type[]" id="item_type<?php echo $tr_id; ?>" value="<?php if(!empty($item->item_type)){ echo $item->item_type; } ?>" readonly>
					   @if ($errors->has('item_type'))
						<div class="error" style="color:red;">{{ $errors->first('item_type') }}</div>
						@endif
                      </div>
					  <div class="col-md-2">
                      <label for="text-input" class=" form-control-label">Unit</label>

					  <input type="text" class="form-control"  id="unit<?php echo $tr_id; ?>" value="<?php if(!empty($item->unit_id)){ echo $unit_rs->unit_name; } ?>" readonly>
						  <input type="hidden" class="form-control" name="unit_id[]" id="unit_id<?php echo $tr_id; ?>" value="<?php if(!empty($item->unit_id)){ echo $unit_rs->id; } ?>">
					   @if ($errors->has('unit_id'))
						<div class="error" style="color:red;">{{ $errors->first('unit_id') }}</div>
						@endif
					  </div>
					  <div class="col-md-3">
                      <label for="text-input" class=" form-control-label">Quantity Required</label>
                      <input type="text" class="form-control" id="required_qty<?php echo $tr_id; ?>" name="required_qty[]" onkeypress="checkQuantity(<?php echo $tr_id; ?>)" value="<?php if(!empty($item->required_qty)){ echo $item->required_qty; } ?>" required>
					   @if ($errors->has('required_qty'))
						<div class="error" style="color:red;">{{ $errors->first('required_qty') }}</div>
						@endif
                    </div>
					  <div class="col-md-2 btn-up" style="text-align: right;">
					  	<button type="button" class="btn btn-danger btn-add" id="add<?php echo $tr_id; ?>" onClick="addnewrow(<?php echo $tr_id; ?>)" data-id="<?php echo $tr_id; ?>"><i class="fa fa-plus" aria-hidden="true"></i>Add More</button>
					  </div>
					  <div class="col-md-2 btn-up" style="text-align: right;">
						<button type="button" class="btn btn-danger " id="del" style="background: #d00404; border-color: #d00404;" onClick="delRow(<?php echo $tr_id; ?>)" disabled> <i class="fa fa-remove" aria-hidden="true">Remove</i></button>
					  </div>

					  </div>

					  </div>
					  <div class="row form-group">

                     <div class="col-md-3">
					 	<label> Department</label>
						<!-- <input type="text" class="form-control" readonly="" name="department_name" value="Department1"> -->
						<select class="form-control" name="department_name" id="department_id" onchange="selectEmployee()" required>
							<option value="" selected disabled>Select</option>
							@foreach($department_rs as $department)
							<option value="{{ $department->department_name }}" <?php if(!empty($item->department_name)){ if($department->department_name == $item->department_name) { echo "selected"; } } ?>>{{ $department->department_name }}</option>
							@endforeach
						</select>
					    @if ($errors->has('department_name'))
						 <div class="error" style="color:red;">{{ $errors->first('department_name') }}</div>
						@endif
					 </div>
					  <div class="col-md-3">
					  <label>Indent Made By</label>
					  <select class="form-control" name="empployee_id" id="empployee_id" required="">

              		  </select>
					  </div>
					  <div class="col-md-3">
					  <label>Indent Made Date</label>
					  <input type="date" class="form-control" name="indent_date" value="<?php  echo date('Y-m-d');  ?>" required readonly>
					  @if ($errors->has('indent_date'))
						<div class="error" style="color:red;">{{ $errors->first('indent_date') }}</div>
						@endif
					  </div>
					  <div class="col-md-3">
					  <label>Indent Required Date</label>
					  <input type="date" class="form-control" name="required_date" value="<?php if(!empty($item->required_date)){ echo $item->required_date; } ?>" required>
					  @if ($errors->has('required_date'))
						<div class="error" style="color:red;">{{ $errors->first('required_date') }}</div>
						@endif
					  </div>
					  </div>
					  <div class="row form-group">


                  </div>

						<button type="submit" class="btn btn-danger btn-sm">Submit</button>

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

<!--<script>

	$( document ).ready(function() {

		$('.deleteButton').attr('disabled', true);
	});


		function addnewrow(rowid)
	{
		if (rowid != ''){
				$('#add'+rowid).attr('disabled',true);

			}



		alert(rowid);
		$.ajax({

				url:'{{url('procurement/indent/get-add-row-item')}}/'+rowid,
				type: "GET",

				success: function(jsonStr) {
					console.log(jsonStr);
					$(".addrow").append(jsonStr);

				}
			});
	}

		$(document).on("click", ".deleteButton", function() {
    	$(this).closest('.lv-due-body').remove();
	});

	function selectEmployee(){
      var department_id = $("#department_name option:selected").val();
      $.ajax({
        type:'GET',
        url:'{{url('dak/employeelist')}}/'+department_id,
        success: function(response){

            console.log(response);
            var option = '';
            option += '<option value="">Select Employee</option>';
            for (var i=0;i<response.length;i++){
              option += '<option value="'+ response[i].emp_code+ '">' + response[i].emp_fname + " " +response[i].emp_mname + " " +response[i].emp_lname+  "(" +response[i].emp_code+ ")" + '</option>';
            }
            $('#indent_made_by').html(option);

        }
      });
    }

	function gettotal(rowid)
	{
		var price = $("#price"+rowid).val();
		var qty = $('#quantity'+rowid).val();
		//alert(price);
		var total = price * qty;
		$("#total"+rowid).val(total);
	}

	function getdetails(val)
	{

		var index = $(".lv-due-body").index();
		alert(index);
		$.ajax({

				url:'{{url('procurement/indent/get-item-details')}}/'+val,
				type: "GET",

				success: function(response) {

					var jqObj = jQuery.parseJSON(response);

					// $("#price"+rowid).val(jqObj.rate);
					$("#item_type"+rowid).val(jqObj.type);
					$("#unit"+rowid).val(jqObj.unit_name);
					$("#unit_id"+rowid).val(jqObj.unit_id);

				}
			});
	}
</script>-->

<script>

	var hidden_id = $('#hidden_id').val();
	// alert(hidden_id);

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

	function addnewrow(rowid)
	{

		if (rowid != ''){
				$('#add'+rowid).attr('disabled',true);

		}



		//alert(rowid);
		$.ajax({

				url:'{{url('procurement/indent/get-add-row-item')}}/'+rowid,
				type: "GET",

				success: function(response) {

					$("#dynamic_row").append(response);

				}
			});
	}

	function delRow(rowid)
	{
		var lastrow = $(".itemslot:last").attr("id");
        //alert(lastrow);
        var active_div = (lastrow-1);
        $('#add'+active_div).attr('disabled',false);
        $(document).on('click','.deleteButton',function() {
            $(this).closest("div.itemslot").remove();
        });


	    /*$(document).on('click','.deleteButton',function(rowid) {
            if (rowid > 1){
                $('#add'+rowid).removeAttr("disabled");

            }
  		    $(this).closest("div.itemslot").remove();
		});*/
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

				success: function(response) {

					// alert(response);
					var jqObj = jQuery.parseJSON(response);
					//alert(jqObj.rate);
					//$("#price"+rowid).val(jqObj.rate);
					$("#item_type"+rowid).val(jqObj.item_type);
					$("#unit"+rowid).val(jqObj.unit_name);
					$("#unit_id"+rowid).val(jqObj.unit_id);

				}
			});
	}

	selectEmployee();

    var select_emp = "<?php  if(!empty($item->indent_made_by)){ echo $item->indent_made_by;}?>";

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

    function checkQuantity(rowid)
    {
        var item_id = $("#item_code"+rowid).val();
        // alert(item_id);

        $.ajax({
            type:'GET',
            url:'{{url('procurement/indent/get-item-stock')}}/'+item_id+'/'+rowid,
            success: function(response){

                var jqObj = jQuery.parseJSON(response);
                var req_qty = $("#required_qty"+rowid).val();
                if(parseInt(jqObj.closing_stock) < parseInt(req_qty))
                {
                    alert('Required quantity should be less than available quantity!!');
                     $("#required_qty"+rowid).val('');
                }
            }
        });
    }
</script>

@endsection
