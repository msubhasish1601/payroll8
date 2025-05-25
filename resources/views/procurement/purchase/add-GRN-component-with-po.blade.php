@extends('procurement.purchase.layouts.master')

@section('title')
GRN For Component
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
            <div class="card-header"><strong class="card-title">Add GRN for Component</strong></div>
            <div class="card-body card-block">
              <form action="{{ url('procurement/purchase/add-GRN-component-with-po') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="clearfix"></div>
                <div class="lv-due" style="border:none;">
                 <div class="row form-group">
				 	<div class="col-md-6">
						<label>Select PO Status</label>
						<select class="form-control" name="po_status" onchange="getpostatus(this.value);" required>
							<option value="" selected disabled>Select</option>
							<option value="with">With PO</option>
							<option value="without">Without PO</option>
						</select>
					</div>
					<div class="col-md-6" id="new">
						
					</div>
				 </div>
				 <div id="new1"></div>
                    
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
	
		function getpostatus(val)
		{
			//window.location = "{{ url('procurement/purchase/add-GRN-component-with-po') }}?po_status="+val;
			
			if(val == 'with')
			{
				$.ajax({
					
					url:'{{url('procurement/purchase/grnwith-po')}}/'+val,
					type: "GET",
					
					success: function(jsonStr) {
						
						
						$("#new").html(jsonStr);  
						
					 
					}
				});
			}
			else
			{
				$.ajax({
					
					url:'{{url('procurement/purchase/grnwithout-po')}}/'+val,
					type: "GET",
					
					success: function(jsonStr) {
						
						
						$("#new1").html(jsonStr);  
						
					 
					}
				});
			}
		}
		
		function getpocomp(val)
		{
			//alert(val);
			$.ajax({
				
				url:'{{url('procurement/purchase/grnwith-po-details')}}/'+val,
				type: "GET",
				
				success: function(jsonStr) {
					
					
					$("#new1").html(jsonStr);  
					
				 
				}
			});
		}
		function getbalance(row)
		{
			
			var balance_qty = $('#balance_qty'+row).val();
			var receive_qty = $('#receive_qty'+row).val();
			//alert(balance_qty);
				var balance_qty = balance_qty - receive_qty;
				$('#balance_qty'+row).val(balance_qty);				
			
		}
		function addnewrow(rowid) 
		{
			if (rowid != ''){
					$('#add'+rowid).attr('disabled',true);
					
				}
			
			
			$.ajax({
					
					url:'{{url('procurement/purchase/get-add-row-grn-comp')}}/'+rowid,
					type: "GET",
					
					success: function(jsonStr) {
						console.log(jsonStr);
						$(".addrow").append(jsonStr);  
					 
					}
				});
		}	
		function getcompinfo(val,row)
		{
			//alert(row);
			$.ajax({
				
				url:'{{url('procurement/purchase/get-comp-rate')}}/'+val+'/'+row,
				type: "GET",
				
				success: function(jsonStr) {
					
					//console.log(jsonStr);
					var jqObj = jQuery.parseJSON(jsonStr);
					//alert(jqObj.rate);
					$("#price"+row).val(jqObj.rate);  
  
				 }
			});

		}
		function gettotal(row)
		{
			var qty = $('#qty'+row).val();
			var price = $('#price'+row).val();
			var tax = $('#tax'+row).val();
			var total_with_tax = parseInt(price * qty) + parseInt((qty * price * tax)/100);
			$('#total_with_tax'+row).val(total_with_tax);
		}
		function getqty(row)
		{
			var qty = $('#qty'+row).val();
			$('#receive_qty'+row).val(qty);
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
	</script>
@endsection
