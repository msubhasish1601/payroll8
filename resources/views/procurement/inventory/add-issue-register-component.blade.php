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





@section('content')
  <!-- Content -->
  <div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
      <!-- Widgets  -->
      <div class="row">
        <div class="main-card">
          <div class="card">
            <div class="card-header"><strong class="card-title">Issue Component</strong></div>
            <div class="card-body card-block">
              <form action="{{ url('procurement/inventory/add-issue-register-component') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
                 <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="clearfix"></div>
                <div class="lv-due" style="border:none;">
                  
                  <div class="row form-group lv-due-body">
                    <div class="col-md-6">
                      <label for="text-input" class=" form-control-label">Select Indent No.</label>
                      <select class="form-control" name="indent_no" onchange="getindentno(this.value);" required>
					  	<option value="" selected disabled>Select</option>
						@foreach($indent_rs as $indent)
						<option value="{{ $indent->indent_no }}">{{ $indent->indent_no }}</option>
						@endforeach
					  </select>
					  </div>
					 </div>
					 <div class="row form-group" id="new">
							
					  </div>
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
	@include('procurement.inventory.partials.scripts')
	<script>
	function getindentno(val)
	{
		//alert(val);
		$.ajax({
			url:'{{ url('procurement/inventory/get-indent-component-details') }}/'+val,
			type:"GET",
			success: function(jsonStr)
			{
				//alert(jsonStr);
				$("#new").html(jsonStr);  
			}
		});
	}		
	</script>
@endsection