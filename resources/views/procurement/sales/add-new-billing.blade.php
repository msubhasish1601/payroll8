@extends('procurement.sales.layouts.master')

@section('title')
Sales
@endsection

@section('sidebar')
	@include('procurement.sales.partials.sidebar')
@endsection

@section('header')
	@include('procurement.sales.partials.header')
@endsection




@section('content')
  <!-- Content -->
  <div class="content" style="padding-top:0;">
    <!-- Animated -->
    <div class="animated fadeIn">
      <!-- Widgets  -->
      <div class="row">
        <div class="main-card">
          <div class="card">
            <div class="card-header"><strong class="card-title">Add New Billing</strong></div>
            <div class="card-body card-block">
              <form action="{{ url('procurement/sales/add-new-billing') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="clearfix"></div>
                <div class="lv-due" style="border:none;">
                  
                  <div class="row form-group lv-due-body">
                    <div class="col-md-3">
                      <label for="text-input" class=" form-control-label">Select Institute</label>
                      <select class="form-control" name="institute_code">
							<option value="" selected disabled>Select</option>
							@foreach($institute_rs as $institute)
							<option value="{{ $institute->institute_code }}">{{ $institute->institute_name }}</option>
							@endforeach
						</select>
					  </div>
					  <div class="col-md-3">
                      <label for="text-input" class=" form-control-label">Select CCR</label>
                      <select class="form-control" name="ccr">
							<option value="" selected disabled>Select</option>
							<option>CCR1</option>
							<option>CCR2</option>
						</select>
					  </div>
					  <div class="col-md-3">
                      <label for="text-input" class=" form-control-label">Bill To</label>
                     <input type="text" class="form-control" name="bill_to">
					  </div>
					  <div class="col-md-3">
                      <label for="text-input" class=" form-control-label">Select Item</label>
                      <select class="form-control" name="item_code" onchange="getunit(this.value);">
							<option value="" selected disabled>Select</option>
							@foreach($item_rs as $item)
							<option value="{{ $item->item_code }}">{{ $item->item_name }}</option>
							@endforeach
						</select>
                    </div>
					  
					  
					  </div>
					  </div>
					  <div class="row form-group">
					  <div class="col-md-3">
					  	<label>Bill No.</label>
						<input type="text" class="form-control" name="bill_no">
					  </div>
					  <div class="col-md-3">
					  	<label>Item Price</label>
						<input type="text" class="form-control" name="item_price" id="item_price">
					  </div>
                     <div class="col-md-3">
                      <label for="text-input" class=" form-control-label">UOM</label>
                      <!--<select class="form-control" name="unit_id">
							<option value="" selected="disabled">Select Unit</option>
							@foreach($unit_rs as $unit)
							<option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
							@endforeach
						</select>-->
						<input type="text" class="form-control" name="unit_of_measurement" id="unit">
					  </div>
					  <div class="col-md-3">
					  <label>Qty</label>
					  <input type="text" class="form-control" name="qty" id="qty" onblur="totalprice(this.value);" value='0'>
					  </div>
					  
					  </div>
					  <div class="row form-group">
					  <div class="col-md-3">
					  <label>Total Price</label>
					  <input type="text" class="form-control" name="tot_price" id="total_price" value='0'>
					  </div>
                   	<div class="col-md-3">
							<label>Discount</label>
							<input type="text" class="form-control" id="discount" value='0' name="discount">
						</div>
					<div class="col-md-3">
							<label>CGST (%)</label>
							<input type="text" class="form-control" id="cgst" value='0' name="cgst">
						</div>
					<div class="col-md-3">
						<label>SGST (%)</label>
						<input type="text" class="form-control" id="sgst" onblur="gettotalwithtax();" value='0' name="sgst">
					</div>
					
                  </div>
				  
				  <div class="row form-group">
				  <div class="col-md-3">
							<label>IGST (%)</label>
							<input type="text" class="form-control" id="igst" onblur="gettotalwithtax();" value='0' name="igst">
						</div>
                   		<div class="col-md-3">						
							<label>Total Amount Including Tax</label>
							<input type="text" class="form-control" id="total_with_tax" value='0' name="amt_including_tax">
						</div>
						<div class="col-md-3">						
							<label>Billing Date</label>
							<input type="date" class="form-control" name="billing_dt">
						</div>
					<div class="col-md-3 btn-up">
							<button type="submit" class="btn btn-danger btn-sm">Submit</button>
                     <button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Reset</button>
              </form>
					
                  </div>
				  
						
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

@section('scripts')
	@include('procurement.sales.partials.scripts')
	
	<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
	<script src="{{ asset('js/main.js') }}"></script>
	<script src="{{ asset('js/lib/chosen/chosen.jquery.min.js') }}"></script>

	<script>
		jQuery(document).ready(function() {
			jQuery(".standardSelect").chosen({
				disable_search_threshold: 10,
				no_results_text: "Oops, nothing found!",
				width: "100%"
			});
		});
	</script>
	<script>
		function getunit(val)
		{
			//alert(val);
			$.ajax({
					
					url:'{{url('sales/get-unit')}}/'+val,
					type: "GET",
					
					success: function(jsonStr) {
						console.log(jsonStr);
						$("#unit").val(jsonStr);  
					 
					}
				});
		}
		function totalprice(val)
		{
			var qty = val;
			var item_price = $('#item_price').val();
			//alert(item_price);
			var total = qty * item_price;
			$('#total_price').val(total);
		}
		function gettotalwithtax()
		{
			var total = $('#total_price').val(); 
			var cgst = $('#cgst').val();
			var sgst = $('#sgst').val();
			var igst = $('#igst').val();
			var discount = $('#discount').val();
			//alert(total);
			if(sgst != '')
			{
				if(discount != '')
				{
				var cgst_value = ((parseInt(total) - parseInt(discount)) * cgst)/100;
				var sgst_value = ((parseInt(total) - parseInt(discount)) * sgst)/100;
				var actual_total = (parseInt(total) - parseInt(discount));
				var total_with_tax =  (parseInt(actual_total) + parseInt(cgst_value) + parseInt(sgst_value));
				}
			}
			
			if(igst != '')
			{
			var igst_value = ((parseInt(total) - parseInt(discount)) * igst)/100;
			var actual_total = parseInt(total) - parseInt(discount);alert(igst_value);
			var total_with_tax = parseInt(actual_total) + parseInt(igst_value); 
			}
			
			$('#total_with_tax').val(total_with_tax);
			
		}
	</script>
@endsection

@endsection

