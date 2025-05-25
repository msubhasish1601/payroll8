@extends('procurement.inventory.layouts.master')

@section('title')
Inventory
@endsection

@section('sidebar')
	@include('procurement.inventory.partials.sidebar')
@endsection

@section('header')
	@include('procurement.inventory.partials.header')
@endsection
<style>
.row.form-group.lv-due-body.indent {
    background: #e2e2e2 !important;
    width: 600px !important;
    margin: 0 auto !important;
    padding: 15px !important;
}

.btn-danger {
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
            <div class="card-header">
            	<strong class="card-title" style="font-size:21px; font-weight: 100;"><img src="{{asset('images/issue-register.png')}}" alt="" style="width: 35px;">Issue Item</strong>
            </div>
            <div class="card-body card-block">
              <form action="{{ url('procurement/inventory/add-issue-register-item') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="clearfix"></div>
                <div class="lv-due" style="border:none;">
                  <!--<div class="lv-due-hd">
											<h4>Leave Due as on</h4>
										</div>-->
                  <div class="row form-group lv-due-body indent">
                    <div class="col-md-4">
                      <label for="text-input" class=" form-control-label">Select Indent No.</label>
                  	</div>
                  	<div class="col-md-8">
                     <select class="form-control" name="indent_no" onchange="getindentno(this.value);" required>
					  	<option value="" selected disabled>Select</option>
						@foreach($indent_rs as $indent)
						<option value="{{ $indent->indent_no }}">{{ $indent->indent_no }}</option>
						@endforeach
					  </select>
					  </div>
					 </div>

					 <div class="row form-group" id="new" style="margin-top: 20px;">
					  
					  </div>
					  </div>
					
						<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-thumbs-o-up" aria-hidden="true" style="font-size:18px;"></i>  Submit</button>
                     
				  
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
<div class="clearfix"></div>

<!---------------------supplier-modal------------------>
<!-- Modal -->
<div id="myModal1" class="modal fade supplier" role="dialog">
  <div class="modal-dialog" style="max-width:900px;margin:2% auto;">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="font-size: 19px;"><img src="{{asset('images/supplier.png')}}" alt="" style="width: 35px;"> Add Purchase Request</h4>
      </div>
      <div class="modal-body">
        <form action="{{ url('masters/supplier') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" id="supplier_id" name="id"  />
			  
                <div class="clearfix"></div>
                <div class="lv-due" style="border:none;">
                  
                  <div class="bef-ship" style="border-bottom: 1px solid #ccc !important; ">
                  <div class="row form-group lv-due-body">
                    <div class="col-md-2">
					<?php $tr_id=1; ?>
                      <label for="text-input" class=" form-control-label">Item Name</label>
                      
                      <input type="text" class="form-control" name="item_code" value="" id="item_code">

					   @if ($errors->has('item_code'))
						<div class="error" style="color:red;">{{ $errors->first('item_code') }}</div>
						@endif
					  </div>
					  <div class="col-md-2">
                      <label for="text-input" class=" form-control-label">Item Type</label>
                      <input type="text" class="form-control" name="item_type[]" id="item_type<?php echo $tr_id; ?>">
                    </div>
					<div class="col-md-2">
						<label>Unit</label>
						 <input type="text" class="form-control"  id="unit<?php echo $tr_id; ?>">
						  <input type="hidden" class="form-control" name="unit_id[]" id="unit_id<?php echo $tr_id; ?>">
					   @if ($errors->has('unit_id'))
						<div class="error" style="color:red;">{{ $errors->first('unit_id') }}</div>
						@endif
					</div>
					<div class="col-md-1">
						<label>Price</label>
						<input type="text" class="form-control" id="price<?php echo $tr_id; ?>" name="price[]">
					</div>
					<div class="col-md-1">
						<label>Qty</label>
						<input type="text" class="form-control" id="quantity<?php echo $tr_id; ?>" name="quantity[]" onblur="gettotal(<?php echo $tr_id; ?>);">
					</div>
					<div class="col-md-2">
						<label>Total</label>
						<input type="text" class="form-control" id="total<?php echo $tr_id; ?>" name="total[]">
					</div>
					  <div class="col-md-2 btn-up">
					  	
						
					  </div>
					  
					  </div>

					  <div class="row form-group">
                     
					 <div class="col-md-4">
					 	<label>Requisition Made by Department</label>
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
					  <label>Requisition Made By</label>
					   <select class="form-control" name="empployee_id" id="empployee_id">
                 
              		  </select>
					  </div>
					  <div class="col-md-4">
					  <label>Remarks</label>
					  <textarea rows="2" class="form-control" name="remarks"></textarea>
					  </div>
					  </div>

					  <div class="row form-group">
					  <div class="col-md-3">
					  <label>Request Date</label>
					  <input type="date" class="form-control" name="request_date" value="<?php if(!empty($item->request_date)){ echo $item->request_date; } ?>" required>
					  @if ($errors->has('request_date'))
						<div class="error" style="color:red;">{{ $errors->first('request_date') }}</div>
						@endif
					  </div>
					  <div class="col-md-3">
					  <label>Required Date</label>
					  <input type="date" class="form-control" name="required_date" value="<?php if(!empty($item->required_date)){ echo $item->required_date; } ?>" required>
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
				  
                </div>
              </form>
      </div>
      
    </div>
  </div>
</div>


@endsection


@section('scripts')
	@include('procurement.inventory.partials.scripts')
	<script>

	function getindentno(val)
	{
		// alert(val);
		$.ajax({
			url:'{{ url('procurement/inventory/get-indent-item-details') }}/'+val,
			type:"GET",
			success: function(jsonStr)
			{
				// alert(jsonStr);
				$("#new").html(jsonStr);  
			}
		});
	}

		/*$('#myModal1').on('shown.bs.modal', function (e) {

			$('a.btn-info').click(function() { 
			   
			    var id = $(this).attr('id').substring(1);
			   alert(id);
			});
  			
		});*/

		function myfunc() {

			alert($(this).attr('id'));
   
  		}
	</script>
@endsection