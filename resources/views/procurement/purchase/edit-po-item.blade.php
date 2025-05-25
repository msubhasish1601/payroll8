@extends('procurement.purchase.layouts.master')

@section('title')
Purchase Order For Item
@endsection

@section('sidebar')
	@include('procurement.purchase.partials.sidebar')
@endsection

@section('header')
	@include('procurement.purchase.partials.header')
@endsection





@section('content')
<style>
	.card-title img {
    	width: 35px;
	}

	h4.modal-title img {
	    width: 35px;
	    margin-right: 15px;
	}
</style>
  <!-- Content -->
  <div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
      <!-- Widgets  -->
      <div class="row">
        <div class="main-card">
          <div class="card">
            <div class="card-header"><strong class="card-title"style="font-size:21px; font-weight: 100;"><img src="{{asset('images/issue-register.png')}}" alt="">  Add Purchase Order</strong></div>
            <div class="card-body card-block">
              <form action="{{ url('procurement/purchase/update-po-item') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
				 <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="clearfix"></div>



                <div class="lv-due" style="border:none;">
                 <div class="row form-group">
				 	<div class="col-md-6">
						<label>Requisition Number</label>

						<input type="text" class="form-control" name="requisition_no" id="requisition_no" required readonly value="<?php if(!empty($po_items[0]->requisition_no)){ echo $po_items[0]->requisition_no; } ?>">

					</div>
					<div class="col-md-6">
						<label>Supplier Name</label>
						<select class="form-control" name="supplier_name" required readonly>
							<option value="" selected disabled>Select</option>
							@foreach($supplier_rs as $supplier)
							<option value="{{ $supplier->supplier_code }}" <?php if(!empty($po_items[0]->supplier_name)){ if($po_items[0]->supplier_name == $supplier->supplier_code) { echo "selected"; } } ?>>{{ $supplier->supplier_name }}</option>
							@endforeach
						</select>




					</div>
				 </div>
                  <div  id="new">

                   @foreach($po_items as $key => $po_item)

                   		<div class="row form-group lv-due-body">
                    <div class="col-md-1">
                      <label for="text-input" class=" form-control-label">Item</label>
                      <input type="text" class="form-control" readonly=""   value="<?php echo $po_item->item_name; ?>">
					  <input type="hidden" class="form-control" readonly="" name="item_code[]"  value="<?php if(!empty($po_item->item_code)){ echo $po_item->item_code; } ?>">
					  <input type="hidden" readonly="" name="purchase_order_no[]" value="<?php if(!empty($po_item->purchase_order_no)){ echo $po_item->purchase_order_no; } ?>" class="form-control">
					  </div>
					  <div class="col-md-1">
						<label>Qty</label>
						<input type="text" class="form-control" readonly="" id="qty<?php echo $key; ?>" name="qty[]" value="<?php if(!empty($po_item->qty)){ echo $po_item->qty; } ?>">
						<input type="hidden" class="form-control"  id="balance_qty'.$i.'" name="balance_qty[]" value="<?php if(!empty($po_item->balance_qty)){ echo $po_item->balance_qty; } ?>">
					</div>
					<div class="col-md-1">
						<label>Unit</label>
						<input type="text" readonly="" value="<?php echo $po_item->unit_name; ?>" class="form-control">
						<input type="hidden" readonly="" name="unit_id[]" value="<?php if(!empty($po_item->unit_id)){ echo $po_item->unit_id; } ?>" class="form-control">
					</div>
					<div class="col-md-1">
						<label>Price</label>
						<input type="text" class="form-control" readonly="" id="price<?php echo $key; ?>" name="price[]" value="<?php if(!empty($po_item->price)){ echo $po_item->price; } ?>">
					</div>
					  <div class="col-md-2">
                      <label for="text-input" class=" form-control-label">Offer Price</label>
                      <input type="text" class="form-control" id="offer_price<?php echo $key; ?>" name="offer_price[]" onblur="gettotalwithouttax(<?php echo $key; ?>);" value="<?php if(!empty($po_item->offer_price)){ echo $po_item->offer_price; } ?>">
                    </div>
                    <div class="col-md-1">
                      <label for="text-input" class=" form-control-label">SGST</label>
                      <input type="text" class="form-control" name="sgst[]" id="sgst<?php echo $key; ?>" value="<?php if(!empty($po_item->sgst)){ echo $po_item->sgst; }else { echo '0'; } ?>">
                    </div>
					 <div class="col-md-1">
                      <label for="text-input" class=" form-control-label">CGST</label>
                      <input type="text" class="form-control" name="cgst[]" id="cgst<?php echo $key; ?>" onblur="gettotalwithtax(<?php echo $key; ?>)" value="<?php if(!empty($po_item->cgst)){ echo $po_item->cgst; } else { echo '0'; } ?>">
                    </div>
                    <div class="col-md-1">
                      <label for="text-input" class=" form-control-label">IGST</label>
                      <input type="text" class="form-control" name="igst[]" value="<?php if(!empty($po_item->igst)){ echo $po_item->igst; } else { echo '0'; } ?>" id="igst<?php echo $key; ?>" onblur="gettotalwithtax(<?php echo $key; ?>)">
                    </div>


					<div class="col-md-3">
						<label>Total Without Tax</label>
						<input type="text" class="form-control" name="total_without_tax[]" id="total_without_tax<?php echo $key; ?>" value="<?php if(!empty($po_item->total_without_tax)){ echo $po_item->total_without_tax; } ?>" readonly>
					</div>
					<div class="col-md-3">
						<label>Total With Tax</label>
						<input type="text" class="form-control" name="total_with_tax[]" id="total_with_tax<?php echo $key; ?>" value="<?php if(!empty($po_item->total_with_tax)){ echo $po_item->total_with_tax; } ?>" readonly>
					</div>
					<div class="col-md-1 btn-up">
						<button type="button" class="btn btn-danger" style="background: #d00404; border-color: #d00404;" onClick="del(<?php echo $key; ?>)"> <i class="fa fa-remove" aria-hidden="true"></i>Remove</button>
					  </div>
					  </div>
                   @endforeach

					  </div>
			</div>
					  <div class="row form-group" id="new1">

					  </div>

					  <fieldset>
					  <h4 style="padding-bottom:15px;">Shipping Information</h4>
					  <div class="row form-group">
					  <div class="col-md-6">
					  	<label>Name</label>
						<input type="text" class="form-control" name="shipping_name" value="<?php if(!empty($po_items[0]->shipping_name)){ echo $po_items[0]->shipping_name; } ?>">
					  </div>
						<div class="col-md-6">
					  	<label>Company</label>
						<input type="text" class="form-control" name="shipping_company" value="<?php if(!empty($po_items[0]->shipping_company)){ echo $po_items[0]->shipping_company; } ?>">
					  </div>
					</div>
					<div class="row form-group">
					  <div class="col-md-6">
					  	<label>Address</label>
						<input type="text" class="form-control" name="shipping_address" value="<?php if(!empty($po_items[0]->shipping_address)){ echo $po_items[0]->shipping_address; } ?>">
					  </div>
						<div class="col-md-3">
					  	<label>City</label>
						<input type="text" class="form-control" name="shipping_city" value="<?php if(!empty($po_items[0]->shipping_city)){ echo $po_items[0]->shipping_city; } ?>">
					  </div>
					  <div class="col-md-3">
					  	<label>State</label>
						<input type="text" class="form-control" name="shipping_state" value="<?php if(!empty($po_items[0]->shipping_state)){ echo $po_items[0]->shipping_state; } ?>">
					  </div>
					</div>

					<div class="row form-group">
						<div class="col-md-3">
							<label>Pin</label>
							<input type="text" class="form-control" name="shipping_pin" value="<?php if(!empty($po_items[0]->shipping_pin)){ echo $po_items[0]->shipping_pin; } ?>">
						</div>
						<div class="col-md-3">
							<label>Delivery Date</label>
							<input type="date" class="form-control" name="delivery_date" value="<?php if(!empty($po_items[0]->delivery_date)){ echo $po_items[0]->delivery_date; } ?>">
						</div>
						<div class="col-md-3">
							<label>Shipping Charges (In Rs.)</label>
							<input type="text" class="form-control" name="shipping_charges" value="<?php if(!empty($po_items[0]->shipping_charges)){ echo $po_items[0]->shipping_charges; } ?>">
						</div>
						<div class="col-md-3">
							<label>Other Charges (In Rs.)</label>
							<input type="text" class="form-control" name="other_charges" value="<?php if(!empty($po_items[0]->id)){ echo $po_items[0]->other_charges; } ?>">
						</div>
					</div>
					</fieldset>
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
<div class="clearfix"></div>
@endsection

@section('scripts')
	@include('procurement.purchase.partials.scripts')
	<script>
		//getreqno();
	// function getreqno(val)
	// {
	// 	//alert(val);
	// 	//window.location = "{{ url('procurement/purchase/add-po-component') }}?reqno="+val;
	// 	$.ajax({

	// 			url:'{{url('procurement/purchase/get-req-details')}}/'+val,
	// 			type: "GET",

	// 			success: function(jsonStr) {


	// 				$("#new").html(jsonStr);


	// 			}
	// 		});

	// 	$.ajax({

	// 			url:'{{url('procurement/purchase/get-req-info')}}/'+val,
	// 			type: "GET",

	// 			success: function(jsonStr) {


	// 				$("#new1").html(jsonStr);


	// 			}
	// 		});
	// }

	function gettotalwithouttax(row)
	{
		// alert(row);
		var qty = $('#qty'+row).val();
		var offer_price = $('#offer_price'+row).val();
		var tot_without_tax = qty * offer_price;
		$('#total_without_tax'+row).val(tot_without_tax);

		gettotalwithtax(row);
	}
	function gettotalwithtax(row)
	{
		// alert('hi');
		var sgst = $('#sgst'+row).val();
		var cgst = $('#cgst'+row).val();
		var igst = $('#igst'+row).val();
		var tot_without_tax = $('#total_without_tax'+row).val();
		var tax = parseInt(sgst) + parseInt(cgst) + parseInt(igst);
		// alert(tax);
		var tot_with_tax = parseInt(tot_without_tax) + parseInt((tax * tot_without_tax)/100);
		$('#total_with_tax'+row).val(tot_with_tax);
	}
	function del(rowid)
	{
		$("#itemslot"+rowid).html('');
	}

	function selectDistrict(){
    	// alert('hi');
      var state_id = $("#supplier_state").val();
      // alert(state_id);
      $.ajax({
        type:'GET',
        url:'{{url('masters/supplier/dist')}}/'+state_id,
        success: function(response){

            console.log(response);
            var option = '';
            option += '<option value="">Select District</option>';
            for (var i=0;i<response.length;i++){
              option += '<option value="'+ response[i].id+ '">' + response[i].name +  '</option>';
            }
            $('#supplier_district').html(option);

        }
      });
    }
	</script>
@endsection
