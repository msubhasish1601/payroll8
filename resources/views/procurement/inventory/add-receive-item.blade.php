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
.card-title img {
    width: 35px !important;
}

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
            <div class="card-header"><strong class="card-title" style="font-size:21px; font-weight: normal;"><img src="{{asset('images/recieve1.png')}}" alt="">  Recieve Item</strong></div>
            <div class="card-body card-block">
              <form action="{{ url('procurement/inventory/add-receive-item') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="clearfix"></div>
                <div class="lv-due" style="border:none;">
                  
                  <div class="row form-group lv-due-body indent">
                    <div class="col-md-4">
                      <label for="text-input" class=" form-control-label">Select GRN No.</label>
                  	</div>
                  	<div class="col-md-8">
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
@endsection

@section('scripts')
	@include('procurement.inventory.partials.scripts')
	<script>
	function getgrnno(val)
	{
		//alert(val);
		$.ajax({
			url:'{{ url('procurement/inventory/get-rcv-item-details') }}/'+val,
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