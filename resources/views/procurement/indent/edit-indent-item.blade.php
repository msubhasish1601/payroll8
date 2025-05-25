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
	    top: 69px !important;
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
            <div class="card-header"><strong class="card-title">Edit Indent Item</strong></div>
            <div class="card-body card-block">
              <form action="{{ url('procurement/indent/edit-indent-item') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
			  <input type="hidden" name="_token" value="{{ csrf_token() }}">


			  @foreach($items as $key=>$item)

                <input type="hidden" name="indent_no" id="indent_no" value="<?php if(!empty($item->indent_no)){ echo $item->indent_no; } ?>">


                <div class="lv-due" style="border:none;">
                  <!--<div class="lv-due-hd">
											<h4>Leave Due as on</h4>
										</div>-->
                  <div class="row form-group lv-due-body">
                    <div class="col-md-3">
					<?php $tr_id= $key; ?>
                      <label for="text-input" class=" form-control-label">Item Name</label>
						<select class="form-control" id="item_code<?php echo $tr_id; ?>"name="item_code[]" onchange="getdetails(this.value,<?php echo $tr_id; ?>);" readonly >
                        <option value="">Select</option>
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
                      <label for="text-input" class=" form-control-label">Units</label>
					  <input type="text" class="form-control"  id="unit<?php echo $tr_id; ?>" value="<?php if(!empty($item->unit_id)){ echo $item->unitname; } ?>" readonly>
						  <input type="hidden" class="form-control" name="unit_id[]" id="unit_id<?php echo $tr_id; ?>" value="<?php if(!empty($item->unit_id)){ echo $item->unit_id; } ?>">

					   @if ($errors->has('unit_id'))
						<div class="error" style="color:red;">{{ $errors->first('unit_id') }}</div>
						@endif
					  </div>
					  <div class="col-md-3">
                      <label for="text-input" class=" form-control-label">Quantity</label>
                      <input type="text" class="form-control" name="required_qty[]" value="<?php if(!empty($item->required_qty)){ echo $item->required_qty; } ?>" >
					   @if ($errors->has('required_qty'))
						<div class="error" style="color:red;">{{ $errors->first('required_qty') }}</div>
						@endif
                    </div>
					  <div class="col-md-2 btn-up" style="text-align: right;">
						<button type="button" class="btn btn-danger deleteButton" id="del" onClick="remove('<?php echo $item->id; ?>')" disabled> <i class="fa fa-trash" aria-hidden="true"></i>Remove</button>
					  </div>

					  </div>

					  </div>
					  @endforeach

					  <div id="new">
					  </div>
					<!--<table id="myTable">
					  <tbody>


					  </tbody>
					</table>-->

					  <button type="button" class="btn btn-danger btn-add" id="add" onClick="addnewrow()"><i class="fa fa-plus" aria-hidden="true">Add More</i></button>
					  <div class="row form-group">

                     <div class="col-md-4">
					 	<label>Indent Made By Department</label>
						<!-- <input type="text" class="form-control" readonly="" name="department_name" value="Department1"> -->

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
					  <label>Indent Made By</label>

              		  <select class="form-control" name="empployee_id" id="empployee_id" readonly>

              		  </select>
					  </div>
					  <div class="col-md-4">
					  <label>Indent Date</label>
					  <input type="date" class="form-control" name="indent_date" value="<?php echo $items[0]->indent_date;  ?>" readonly>
					  @if ($errors->has('indent_date'))
						<div class="error" style="color:red;">{{ $errors->first('indent_date') }}</div>
						@endif
					  </div>
					  </div>
					  <div class="row form-group">
					  <div class="col-md-3">
					  <label>Required Date</label>
					  <input type="date" class="form-control" name="required_date" value="<?php echo $items[0]->required_date;  ?>" readonly>
					  @if ($errors->has('required_date'))
						<div class="error" style="color:red;">{{ $errors->first('required_date') }}</div>
						@endif
					  </div>
					  </div>



						<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-thumbs-o-up" aria-hidden="true" style="font-size:18px;"></i>Submit</button>
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

$("#add").click(function(){
  $(".deleteButton").attr("disabled", false);
});

function addnewrow(){

	var numItems = $('.lv-due').length;
	//alert(numItems);
	// $result_status1="<option value='' selected disabled>Select</option>";
	// foreach($item_rs as $item)
	// {
 //        $result_status1.='<option value="'.$item['id'].'">'.$item['name'].'</option>';
	// }



$('#new').append('<div class="lv-due" style="border:none;"><div class="row form-group lv-due-body"><div class="col-md-3"><label for="text-input" class=" form-control-label">Item Name</label><select class="form-control" id="item_code'+numItems+'" name="item_code[]" onchange="getdetails(this.value,'+numItems+')"><option value="">Select</option>@foreach($item_rs as $item_new)<option value="{{ $item_new->item_code }}" >{{ $item_new->name }}</option>@endforeach</select></div><div class="col-md-2"><label for="text-input" class=" form-control-label">Item Type</label><input type="text" class="form-control" id="item_type'+numItems+'" name="item_type[]" readonly></div><div class="col-md-2"><label for="text-input" class=" form-control-label">Units</label><input type="text" class="form-control"  id="unit'+numItems+'" readonly><input type="hidden" class="form-control" name="unit_id[]" id="unit_id'+numItems+'"></div><div class="col-md-3"><label for="text-input" class=" form-control-label">No. of Pieces Required</label><input type="text" class="form-control" name="required_qty[]" ></div><div class="col-md-2 btn-up" style="text-align: right;"><button type="button" id="del" class="btn btn-danger deleteButton" onClick="remove('+numItems+')"> <i class="fa fa-trash" aria-hidden="true"></i>Remove</button></div></div></div>');

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
					// alert(jqObj.type);
					$("#item_code"+rowid).val(val);
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

    function remove(rowid)
	{
		alert(rowid);
		// if (rowid != ''){
		// $('#add'+rowid).attr('disabled',false);
		// }
		// $(".itemslot" + rowid).html('');
		// var row = rowid - 1;
		// $('#add'+row).attr('disabled',false);

		$(document).on('click','.deleteButton',function() {
     		$(this).closest("div.lv-due").remove();
		});
	}
</script>

@endsection
