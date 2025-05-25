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
            <div class="card-header"><strong class="card-title">Add New Payment Recieved</strong></div>
            <div class="card-body card-block">
              <form action="{{ url('procurement/sales/add-new-payment-recieved') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="clearfix"></div>
                <div class="lv-due" style="border:none;">
                  <!--<div class="lv-due-hd">
											<h4>Leave Due as on</h4>
										</div>-->
                  <div class="row form-group lv-due-body">
                    <div class="col-md-3">
                      <label for="text-input" class=" form-control-label">Select Bill No.</label>
                      <select class="form-control" onchange="getdetail(this.value);" name="bill_no" id="bill_no">
							<option value="" selected disabled>Select</option>
							@foreach($billing_rs as $billing)
							<option value="{{ $billing->billing_no }}">{{ $billing->billing_no }}</option>
							@endforeach
						</select>
					  </div>
					  
					  <div class="col-md-3">
                      <label for="text-input" class=" form-control-label">Bill To</label>
                     <input type="text" class="form-control" readonly="" id="bill_to">
					  </div>
					  <div class="col-md-3">
                      <label for="text-input" class=" form-control-label">Item Name</label>
                      <input type="text" class="form-control" readonly="" id="item_name">
                    </div>
					  
					  <div class="col-md-3">
					  	<label>Item Price</label>
						<input type="text" class="form-control" readonly="" id="item_price">
					  </div>
					  </div>
					  </div>
					  <div class="row form-group">
					  
                     <div class="col-md-3">
                      <label for="text-input" class=" form-control-label">UOM</label>
                      <input type="text" class="form-control" readonly="" id="unit">
					  </div>
					  <div class="col-md-3">
					  <label>Qty</label>
					  <input type="text" class="form-control" readonly="" id="qty">
					  </div>
					  <div class="col-md-3">
					  <label>Total Price</label>
					  <input type="text" class="form-control" readonly=""  id="tot_price">
					  </div>
					  <div class="col-md-3">
							<label>Discount</label>
							<input type="text" class="form-control" readonly=""  id="discount">
						</div>
					  </div>
					  <div class="row form-group">
					  
                   	
					<div class="col-md-3">
							<label>CGST (%)</label>
							<input type="text" class="form-control" readonly="" id="cgst">
						</div>
					<div class="col-md-3">
						<label>SGST (%)</label>
						<input type="text" class="form-control" readonly="" id="sgst">
					</div>
					<div class="col-md-3">
							<label>IGST (%)</label>
							<input type="text" class="form-control" readonly="" id="igst">
						</div>
					<div class="col-md-3">						
							<label>Billing Amount</label>
							<input type="text" class="form-control" readonly="" id="billing_amount">
						</div>
                  </div>
				  
				  <div class="row form-group">
				  
                   		
						<div class="col-md-3">						
							<label>Billing Date</label>
							<input type="date" class="form-control" readonly="" id="billing_date">
						</div>
					<div class="col-md-3">						
							<label>Deduction</label>
							<input type="text" class="form-control" name="deduction" id="deduction" onblur="getafterdedamt(this.value);">
						</div>
						<div class="col-md-3">						
							<label>Payable Amount</label>
							<input type="text" class="form-control" name="payable_amt" id="payable_amt">
						</div>
						<div class="col-md-3">						
							<label>Payment Recieved</label>
							<input type="text" class="form-control" name="payable_received" id="payable_received" onblur="getdue(this.value);">
						</div>
					 </div>
					 
					 <div class="row form-group">
					 	<div class="col-md-3">						
							<label>Due Amount</label>
							<input type="text" class="form-control" name="due_amt" id="due_amt">
						</div>
						<div class="col-md-3">						
							<label>Payment Date</label>
							<input type="date" class="form-control" name="payment_date" id="payment_date">
						</div>
						<div class="col-md-3">						
							<label>Payment Recieved Mode</label>
							<select class="form-control" name="payment_received_mode" id="payment_received_mode">
								<option>Cash</option>
								<option>Cheque</option>
								<option>Bank Transfer</option>
							</select>
						</div>
						<div class="col-md-3">						
							<label>Cheque No.</label>
							<input type="text" class="form-control" name="cheque_no" id="cheque_no">
						</div>
					 </div>
					 
					 <div class="row form-group">
					 	<div class="col-md-3">						
							<label>Cheque Date</label>
							<input type="text" class="form-control" name="cheque_date" id="cheque_date">
						</div>
						<div class="col-md-3">						
							<label>Credit Account</label>
							<select class="form-control" id="credit_account" name="credit_account" id="credit_account">
								<option value="" selected="" disabled="">Select Credit Account</option>
								<option value="CASH AT SBI BANK">CASH AT SBI BANK</option>
								<option value="OPERATIONS FUND">OPERATIONS FUND</option>
								<option value="SCRAP SALES">SCRAP SALES</option>
							<option value="PRODUCT SALES">PRODUCT SALES</option>
							<option value="ADVANCE RECEIVED">ADVANCE RECEIVED</option>
							</select>
						</div>
						<div class="col-md-6 btn-up">
							<button type="submit" class="btn btn-danger btn-sm">Submit</button>
                     <button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Reset</button>
					 </div>
					 </div>
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
@endsection

@section('scripts')
	@include('procurement.sales.partials.scripts')
<!-- Scripts -->
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

function getdetail(val)
{
	
	$.ajax({
					
			url:'{{url('sales/get-details')}}/'+val,
			type: "GET",
			
			success: function(jsonStr) {
				console.log(jsonStr);
				alert(jsonStr);
				var jqobj = jQuery.parseJSON(jsonStr);
				$("#bill_to").val(jqobj.bill_to);  
				$("#item_name").val(jqobj.item_name);  
				$("#item_price").val(jqobj.item_price);  
				$("#unit").val(jqobj.unit_of_measurement);  
				$("#qty").val(jqobj.qty);  
				$("#tot_price").val(jqobj.tot_price);  
				$("#discount").val(jqobj.discount);  
				$("#cgst").val(jqobj.cgst);  
				$("#sgst").val(jqobj.sgst);  
				$("#igst").val(jqobj.igst);  
				$("#billing_amount").val(jqobj.amt_including_tax);  
				$("#billing_date").val(jqobj.billing_dt);  
			 
			}
		});
}
function getafterdedamt(val)
{
		var billing_amount = $('#billing_amount').val();
		var payable_amt = billing_amount - val;
		$('#payable_amt').val(payable_amt);
}

function getdue(val)
{
		var payable_amt = $('#payable_amt').val();
		var due = payable_amt - val;
		$('#due_amt').val(due);
}
</script>
@endsection


