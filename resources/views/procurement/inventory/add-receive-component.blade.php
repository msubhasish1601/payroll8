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
            <div class="card-header"><strong class="card-title">Recieve Component</strong></div>
            <div class="card-body card-block">
              <form action="{{ url('procurement/inventory/add-receive-component') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="clearfix"></div>
                <div class="lv-due" style="border:none;">
                  
                  <div class="row form-group lv-due-body">
                    <div class="col-md-6">
                      <label for="text-input" class=" form-control-label">Select GRN No.</label>
                      <select class="form-control" name="grn_no" onchange="getgrnno(this.value);" required>
					  	<option value="" selected disabled>Select</option>
						@foreach($grn_rs as $grn)
						<option value="{{ $grn->grn_no }}">{{ $grn->grn_no }}</option>
						@endforeach
					  </select>
					  </div>
					 </div>
					<div class="row form-group" id="new">
						
					</div>
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
	@include('procurement.inventory.partials.scripts')
	<script>
	function getgrnno(val)
	{
		//alert(val);
		$.ajax({
			url:'{{ url('procurement/inventory/get-rcv-component-details') }}/'+val,
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
