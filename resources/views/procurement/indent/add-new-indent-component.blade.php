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
  <!-- Content -->
  <div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
      <!-- Widgets  -->
      <div class="row">
        <div class="main-card">
          <div class="card">
            <div class="card-header"><strong class="card-title">Add New Indent for Component</strong></div>
            <div class="card-body card-block">
              <form action="{{ url('procurement/indent/add-new-indent-component') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
			  <input type="hidden" name="_token" value="{{ csrf_token() }}">
               
                <div class="clearfix"></div>
                <div class="lv-due" style="border:none;">
                  <!--<div class="lv-due-hd">
											<h4>Leave Due as on</h4>
										</div>-->
                  <div class="row form-group lv-due-body">
                    <div class="col-md-3">
					<?php $tr_id=1; ?>
					
                      <label for="text-input" class=" form-control-label">Component Name</label>
					  
					  <select class="form-control" name="component_id[]" onchange="getdetails(this.value,<?php echo $tr_id; ?>);" required>
                        <option value="" selected disabled>Select</option>
                        @foreach($component_rs as $component)
                        <option value="{{ $component->id }}">{{ $component->component_name }}</option>
						@endforeach
                      </select>	
					   @if ($errors->has('component_id'))
						<div class="error" style="color:red;">{{ $errors->first('component_id') }}</div>
						@endif
					  </div>
					  <div class="col-md-2">
                      <label for="text-input" class=" form-control-label">Component Type</label>
                      <input type="text" class="form-control" name="component_type[]" id="component_type<?php echo $tr_id; ?>">
					   @if ($errors->has('component_type'))
						<div class="error" style="color:red;">{{ $errors->first('component_type') }}</div>
						@endif
                    </div>
					  <div class="col-md-2">
                      <label for="text-input" class=" form-control-label">UOM</label>
                      <input type="text" class="form-control" name="unit[]" id="unit<?php echo $tr_id; ?>">
						<input type="hidden" class="form-control" name="unit_id[]" id="unit_id<?php echo $tr_id; ?>">
					   @if ($errors->has('unit_id'))
						<div class="error" style="color:red;">{{ $errors->first('unit_id') }}</div>
						@endif
					  </div>
					  <div class="col-md-3">
                      <label for="text-input" class=" form-control-label">No. of Pieces Required</label>
                      <input type="text" class="form-control" name="required_qty[]">
					   @if ($errors->has('required_qty'))
						<div class="error" style="color:red;">{{ $errors->first('required_qty') }}</div>
						@endif
                    </div>
					  <div class="col-md-2 btn-up" style="text-align: right;">
					  	<button type="button" class="btn btn-danger" id="add<?php echo $tr_id; ?>" onClick="addnewrow(<?php echo $tr_id; ?>)" data-id="<?php echo $tr_id; ?>"><i class="fa fa-plus" aria-hidden="true"></i></button>
						<button type="button" class="btn btn-danger" id="delete<?php echo $tr_id; ?>" onClick="del('<?php echo $tr_id; ?>')"> <i class="fa fa-remove" aria-hidden="true"></i></button>
					  </div>
					  
					  </div>
					  <div class="addrow"></div>
					  </div>
					  <div class="row form-group">
					  <div class="col-md-3">
					  	<label>Institute Name</label>
						<!-- <input type="text" class="form-control" readonly="" name="institute_name" value="Adamas University"> -->
						<select class="form-control" name="institute_name" required>
							<option value="" selected disabled>Select</option>
							@foreach($institute_rs as $institute)
							<option value="{{ $institute->institute_name }}">{{ $institute->institute_name }}</option>
							@endforeach
						</select>	
		
					   @if ($errors->has('institute_name'))
						<div class="error" style="color:red;">{{ $errors->first('institute_name') }}</div>
						@endif
					  </div>
                     <div class="col-md-3">
					 	<label>Indent Made By Department</label>
						<!-- <input type="text" class="form-control" readonly="" name="department_name" value="Department1"> -->
						<select class="form-control" name="department_name" required>
							<option value="" selected disabled>Select</option>
							@foreach($department_rs as $department)
							<option value="{{ $department->department_name }}">{{ $department->department_name }}</option>
							@endforeach
						</select>	
					    @if ($errors->has('department_name'))
						 <div class="error" style="color:red;">{{ $errors->first('department_name') }}</div>
						@endif
						
					 </div>
					  <div class="col-md-3">
					  <label>Indent Made By</label>
					  <input type="text" class="form-control"  name="indent_made_by" value="">
					  </div>
					  <div class="col-md-3">
					  <label>Indent Date</label>
					  <input type="date" class="form-control" name="indent_date" value="{{ old('indent_date') }}" required>
					   @if ($errors->has('indent_date'))
						<div class="error" style="color:red;">{{ $errors->first('indent_date') }}</div>
						@endif
					  </div>
					  </div>
						<div class="row form-group">
							
						</div>
				  
						<button type="submit" class="btn btn-danger btn-sm">Submit</button>
                    <button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Reset</button>
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
		//alert(rowid);
		if (rowid != ''){
				$('#add'+rowid).attr('disabled',true);
			}
		
		$('#delete'+rowid).attr('disabled',true);
		
		//alert(rowid);
		$.ajax({
				
				url:'{{url('procurement/indent/get-add-row')}}/'+rowid,
				type: "GET",
				
				success: function(jsonStr) {
					console.log(jsonStr);
					$(".addrow").append(jsonStr);  
				 
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
	
	function getdetails(val,rowid)
	{
		//alert(val);
		$.ajax({
				
				url:'{{url('procurement/indent/get-comp-details')}}/'+val+'/'+rowid,
				type: "GET",
				
				success: function(jsonStr) {
					
					//alert(jsonStr);
					var jqObj = jQuery.parseJSON(jsonStr);
					//alert(jqObj.rate);
					//$("#price"+rowid).val(jqObj.rate);  
					$("#component_type"+rowid).val(jqObj.component_type);  
					$("#unit"+rowid).val(jqObj.unit_name);  
					$("#unit_id"+rowid).val(jqObj.unit_id);  
				 
				}
			});
	}
	
</script>
	
@endsection
