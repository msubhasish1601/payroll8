@extends('procurement.purchase.layouts.master')

@section('title')
Purchase Order For Component
@endsection

@section('sidebar')
	@include('procurement.purchase.partials.sidebar')
@endsection

@section('header')
	@include('procurement.purchase.partials.header')
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
            <div class="card-header"><strong class="card-title">Add Purchase Order for Component</strong></div>
            <div class="card-body card-block">
              <form action="{{ url('procurement/purchase/add-po-component') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
			  <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="clearfix"></div>
                <div class="lv-due" style="border:none;">
                 <div class="row form-group">
				 	<div class="col-md-6">
						<label>Requisition Number</label>
						<select class="form-control" name="requisition_no" id="requisition_no" onchange="getreqno(this.value);" required>
							<option value="" selected disabled>Select</option>
							@foreach($req_component_rs as $req_component)
							<option value="{{ $req_component->requisition_no }}" >{{ $req_component->requisition_no }}</option>
							@endforeach
						</select>
					</div>
					
					
					<div class="col-md-6">
						<label>Supplier Name</label>
						<select class="form-control" name="supplier_name">
							<option value="" selected disabled>Select</option>
							@foreach($supplier_rs as $supplier)
							<option value="{{ $supplier->supplier_code }}">{{ $supplier->supplier_name }}</option>
							@endforeach
						</select>
					</div>
				 </div>
						<div  id="new">
				  
                   
						</div>
						
			</div>
					  <div class="row form-group" id="new1">
                     
					  </div>
					  
					  <fieldset>
					  <h4 style="padding-bottom:15px;">Shipping Information</h4>
					  <div class="row form-group">
					  <div class="col-md-6">
					  	<label>Name</label>
						<input type="text" class="form-control" name="shipping_name">
					  </div>
						<div class="col-md-6">
					  	<label>Company</label>
						<input type="text" class="form-control" name="shipping_company">
					  </div>
					</div>
					<div class="row form-group">
					  <div class="col-md-6">
					  	<label>Address</label>
						<input type="text" class="form-control" name="shipping_address">
					  </div>
						<div class="col-md-3">
					  	<label>City</label>
						<input type="text" class="form-control" name="shipping_city">
					  </div>
					  <div class="col-md-3">
					  	<label>State</label>
						<input type="text" class="form-control" name="shipping_state">
					  </div>
					</div>
					
					<div class="row form-group">
						<div class="col-md-3">
							<label>Pin</label>
							<input type="text" class="form-control" name="shipping_pin">
						</div>
						<div class="col-md-3">
							<label>Delivery Date</label>
							<input type="date" class="form-control" name="delivery_date">
						</div>
						<div class="col-md-3">
							<label>Shipping Charges (In Rs.)</label>
							<input type="text" class="form-control" name="shipping_charges">
						</div>
						<div class="col-md-3">
							<label>Other Charges (In Rs.)</label>
							<input type="text" class="form-control" name="other_charges">
						</div>
					</div>
					</fieldset>
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
	@include('procurement.purchase.partials.scripts')
	<script>
	function getreqno(val)
	{
		//alert(val);
		//window.location = "{{ url('procurement/purchase/add-po-component') }}?reqno="+val;
		$.ajax({
				
				url:'{{url('procurement/purchase/get-comp-req-details')}}/'+val,
				type: "GET",
				
				success: function(jsonStr) {
					
					
					$("#new").html(jsonStr);  
					
				 
				}
			});
			
		$.ajax({
				
				url:'{{url('procurement/purchase/get-comp-req-info')}}/'+val,
				type: "GET",
				
				success: function(jsonStr) {
					
					
					$("#new1").html(jsonStr);  
					
				 
				}
			});
	}	

	function gettotalwithouttax(row)
	{
		//alert(row);
		var qty = $('#qty'+row).val();
		var offer_price = $('#offer_price'+row).val();
		var tot_without_tax = qty * offer_price;
		$('#total_without_tax'+row).val(tot_without_tax);
	}
	function gettotalwithtax(row)
	{
		var tax = $('#tax'+row).val();
		var tot_without_tax = $('#total_without_tax'+row).val();
		var tot_with_tax = parseInt(tot_without_tax) + parseInt((tax * tot_without_tax)/100); 
		$('#total_with_tax'+row).val(tot_with_tax);
	}
	function del(rowid)
	{
		$("#itemslot"+rowid).html('');
	}
	</script>
@endsection
