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
              <form action="{{ url('procurement/purchase/add-po-item') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
				 <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="clearfix"></div>
                <div class="lv-due" style="border:none;">

                    <div class="row form-group" style="padding-bottom:23px;border-bottom: 1px solid #d2d1d1;width:100%;">
                    <div class="col-md-6">
                        <label>Supplier Name</label>
                        <select class="form-control" id="supplier_name" name="supplier_name" onchange="getSupplier();">
                            <option value="" selected disabled>Select</option>
                            @foreach($supplier_rs as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->supplier_business_name }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div id = "supplier_info" class="col-md-6" style="display: none;">
                        <label>Supplier Address</label>
                       <textarea id="supplier_address" class="form-control"> </textarea>

                    </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-6">
                            <label>Purchase Request Number</label>
                            <select class="form-control" onchange="getreqno(this.value);" name="requisition_no" id="requisition_no" required>
                                <option value="" selected disabled>Select</option>
                                @foreach($req_item_rs as $req_item)
                                    <option value="{{ $req_item->requisition_no }}">{{ $req_item->requisition_no }}</option>
                                @endforeach
                            </select>
                        </div>


                    </div>
                    <div class="row form-group">
                        <div  id="new" style="padding-bottom:23px;border-bottom: 1px solid #d2d1d1;padding-left: 15px;width:100%;">



					  </div>


					  <div class="row form-group" id="new1" style="width:100%;padding-top: 29px;">

                    </div>
                </div>


					  <fieldset>
					  <h4 style="padding-bottom:15px;">Shipping Information</h4>
					  <div class="row form-group">

						<div class="col-md-6">
					  	<label>Name</label>
						<input type="text" class="form-control" name="shipping_company" value="BELLEVUE" readonly>
					  </div>
                          <div class="col-md-6">
                              <label>Address</label>
                              <input type="text" class="form-control" name="shipping_address" value="Under Ministry of HRD, Government of India, Plot No. - 7, Block EA, Sector-I, Opposite Labony Estate, Salt Lake City" readonly>
                          </div>
					</div>
					<div class="row form-group">

						<div class="col-md-3">
					  	<label>City</label>
						<input type="text" class="form-control" name="shipping_city" value="Kolkata" readonly>
					  </div>
					  <div class="col-md-3">
					  	<label>State</label>
						<input type="text" class="form-control" name="shipping_state" value="West Bengal" readonly>
					  </div>
                        <div class="col-md-3">
                            <label>Pin</label>
                            <input type="text" class="form-control" name="shipping_pin" value="700064" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Required Delivery Date</label>
                            <input type="date" class="form-control" name="delivery_date" >
                        </div>
					</div>

					<div class="row form-group">


						<div class="col-md-3">
							<label>Shipping Charges (In Rs.)</label>
							<input type="text" class="form-control" name="shipping_charges" value="0" >
						</div>
						<div class="col-md-3">
							<label>Other Charges (In Rs.)</label>
							<input type="text" class="form-control" name="other_charges" value="0" >
						</div>
                        <div class="col-md-3">
                            <label>Quotation No./ Ref. No.</label>
                            <input type="text" class="form-control" name="quotation_no"  >
                        </div>
                        <div class="col-md-3">
                            <label>Quotation Date</label>
                            <input type="date" class="form-control" name="quotation_date"  >
                        </div>
                        <div class="col-md-3" >
                            <label>Terms & Condition</label>
{{--                            <input type="text" class="form-control" name="terms_conditions" >--}}
                            <textarea class="form-control" name="terms_conditions" ></textarea>
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

<!---------------------supplier-modal------------------>
<!-- Modal -->
<div id="myModal1" class="modal fade supplier" role="dialog">
  <div class="modal-dialog" style="max-width:900px;margin:2% auto;">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="font-size: 19px;"><img src="{{asset('images/supplier.png')}}" alt=""> Add New Supplier</h4>
      </div>
      <div class="modal-body">
        <form action="{{ url('masters/supplier') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" id="supplier_id" name="id"  />

                <div class="clearfix"></div>
                <div class="lv-due" style="border:none;">

                  <div class="bef-ship" style="border-bottom: 1px solid #ccc !important; ">
                  <div class="row form-group lv-due-body">
                    <div class="col-md-3">
                      <label for="text-input" class=" form-control-label">Supplier Code</label>
                      <input type="text" class="form-control" name="supplier_code" required="" >
					  @if ($errors->has('supplier_code'))
						<div class="error" style="color:red;">{{ $errors->first('supplier_code') }}</div>
					   @endif
                    </div>
                    <div class="col-md-3">
                      <label for="text-input" class=" form-control-label">Supplier Name</label>
                      <input type="text" class="form-control" name="supplier_name" required="" >
					  @if ($errors->has('supplier_name'))
						<div class="error" style="color:red;">{{ $errors->first('supplier_name') }}</div>
					   @endif
                    </div>
                    <div class="col-md-3">
                      <label for="text-input" class=" form-control-label">Business Name</label>
                      <input type="text" class="form-control" id="cname" name="supplier_business_name" required="" >
					   @if ($errors->has('supplier_business_name'))
						<div class="error" style="color:red;">{{ $errors->first('supplier_business_name') }}</div>
					   @endif
                    </div>
                    <div class="col-md-3">
						<label for="text-input" class=" form-control-label">GSTIN</label>
                      <input type="text" class="form-control" name="supplier_gstin" required="" >
						@if ($errors->has('supplier_gstin'))
						<div class="error" style="color:red;">{{ $errors->first('supplier_gstin') }}</div>
					   @endif
					</div>
				</div>
					<div class="row form-group lv-due-body">
					<div class="col-md-3">
						<label for="text-input" class=" form-control-label">PAN No.</label>
						<input type="text" class="form-control" name="pan_no" required="" >
					   @if ($errors->has('pan_no'))
						<div class="error" style="color:red;">{{ $errors->first('pan_no') }}</div>
					   @endif
					</div>
                  </div>
              </div>

				  <h4 style="margin-top:15px;color: #027398;font-size:18px;">Contact Information</h4><br>
				   <div class="row form-group lv-due-body">
				   	<div class="col-md-3">
						<label for="text-input" class=" form-control-label">Email</label>
						<input type="email" class="form-control" name="supplier_email" required="">
						@if ($errors->has('supplier_email'))
						<div class="error" style="color:red;">{{ $errors->first('supplier_email') }}</div>
					   @endif
					</div>
				   	<div class="col-md-3">
					<label for="text-input" class=" form-control-label">Mobile</label>
                      <input type="text" class="form-control" name="supplier_mobile" required="" >
					   @if ($errors->has('supplier_mobile'))
						<div class="error" style="color:red;">{{ $errors->first('supplier_mobile') }}</div>
					   @endif
                    </div>
					<div class="col-md-3">
					<label for="text-input" class=" form-control-label">Alternate contact number</label>
                      <input type="text" class="form-control" name="supplier_alt_no"  >
					   @if ($errors->has('supplier_alt_no'))
						<div class="error" style="color:red;">{{ $errors->first('supplier_alt_no') }}</div>
					   @endif
                    </div>
					<div class="col-md-3">
					<label for="text-input" class=" form-control-label">State</label>
                      <select class="form-control" name="supplier_state" id="supplier_state" onchange="selectDistrict()" required="">
						<option>Select State</option>
						@foreach($states as $state)
						<option value="{{ $state->id }}">{{ $state->state_name }}</option>
						@endforeach
					</select>
					   @if ($errors->has('supplier_state'))
						<div class="error" style="color:red;">{{ $errors->first('supplier_state') }}</div>
					   @endif
                   	    </div>
					</div>

					<div class="row form-group lv-due-body">
						<div class="col-md-3">
						<label for="text-input" class=" form-control-label">District</label>
                      <select class="form-control" name="supplier_district" id="supplier_district">

                      </select>
					   @if ($errors->has('supplier_district'))
						<div class="error" style="color:red;">{{ $errors->first('supplier_district') }}</div>
					   @endif
						</div>
						<div class="col-md-4">
						<label for="text-input" class=" form-control-label">Country</label>
						<input type="text" class="form-control" name="supplier_country" value="India" readonly="" >
					   @if ($errors->has('supplier_country'))
						<div class="error" style="color:red;">{{ $errors->first('supplier_country') }}</div>
					   @endif
						</div>
					</div>


					<div class="col-md-4 btn-up">
					<button type="submit" class="btn btn-danger btn-sm">Submit</button>

					</div>
					</div>

{{--                </div>--}}
              </form>
      </div>

    </div>
  </div>
</div>
@endsection

@section('scripts')
@include('procurement.purchase.partials.scripts')
	<script>
	function getreqno(val)
	{
		// alert(val);
        var supplier = $("#supplier_name").val();

		//window.location = "{{ url('procurement/purchase/add-po-component') }}?reqno="+val;
		$.ajax({

				url:'{{url('procurement/purchase/get-req-details')}}/'+val,
				type: "GET",

				success: function(jsonStr) {


					$("#new").html(jsonStr);


				}
			});

		$.ajax({

				url:'{{url('procurement/purchase/get-req-info')}}/'+val,
				type: "GET",

				success: function(jsonStr) {


					$("#new1").html(jsonStr);


				}
			});
	}

	function gettotalwithouttax(row)
	{
		// alert(row);
        var supplier = $("#supplier_name").val();
        var item = $('#item_id'+row).val();

        $.ajax({
            url:'{{url('procurement/purchase/get-supplier-state')}}/'+supplier+'/'+item,
            type: "GET",
            datatype: 'JSON',
            success: function(jsonStr) {
               // console.log(jsonStr);
                var result = $.parseJSON(jsonStr);
                // console.log(result.supplier_state);
                var offr_price = $('#offer_price'+row).val();
                var gst_prcnt = result.gst;
                var final_gst_amount = (offr_price * gst_prcnt)/100;
                if(result.supplier_state == 'WB')
               {
                   var gst_amnt = final_gst_amount/2;
                   var cgst = $('#cgst'+row).val(gst_amnt);
                   var sgst = $('#sgst'+row).val(gst_amnt);
               }
               else{
                   var igst = $('#igst'+row).val(final_gst_amount);
                }
                var qty = $('#qty'+row).val();
                var offer_price = $('#offer_price'+row).val();
                var tot_without_tax = qty * offer_price;
                $('#total_without_tax'+row).val(tot_without_tax);
            }
        });

	}
	function gettotalwithtax(row)
	{
		var sgst = $('#sgst'+row).val();
		var cgst = $('#cgst'+row).val();
		var igst = $('#igst'+row).val();
		var tot_without_tax = $('#total_without_tax'+row).val();
		var tax = parseInt(sgst) + parseInt(cgst) + parseInt(igst);
		// alert(tax);
		var tot_with_tax = parseInt(tot_without_tax) + parseInt(tax );
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

    function getSupplier()
    {
        $("#supplier_info").show();
        var supplier_id = $("#supplier_name").val();



        $.ajax({

            url:'{{url('masters/supplier/supplierinfo')}}/'+supplier_id,
            type: "GET",

            success: function(jsonStr) {
                //console.log(jsonStr);
                obj = JSON.parse(jsonStr);
                $("#supplier_address").val(obj.contact_person_address);



            }
        });
    }
	</script>
@endsection
