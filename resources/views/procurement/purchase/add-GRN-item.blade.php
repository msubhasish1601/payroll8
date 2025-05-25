@extends('procurement.purchase.layouts.master')

@section('title')
GRN For Item
@endsection

@section('sidebar')
	@include('procurement.purchase.partials.sidebar')
@endsection

@section('header')
	@include('procurement.purchase.partials.header')
@endsection

<style>
.indent {
    background: #f1f0f0;
    width: 600px;
    margin: 0 auto 18px;
    padding: 15px;
}

.lv-due-body {
    background: #e0e0e0;
    margin: 0;
    padding: 10px 15px 15px;
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
            <div class="card-header"><strong class="card-title" style="font-size:21px; font-weight: 100;"><img src="{{asset('images/grn.png')}}" alt="" style="width:35px;"> Add GRN</strong></div>
            <div class="card-body card-block">
              <form action="{{ url('procurement/purchase/add-GRN-item') }}" method="post" enctype="multipart/form-data" id="myform" style="padding:2% 5%;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="clearfix"></div>
                <div class="lv-due" style="border:none;">
                 <div class="row form-group lv-due-body indent" style="margin-left: 65px;">
				 	<div class="col-md-4">
						<label>PO Number</label>
						</div>
						<div class="col-md-8">
						<select class="form-control" name="purchase_order_no" onchange="getpoitem(this.value)"  required>
							<option value="" selected disabled>Select</option>
							@foreach($pr_no_rs as $po_no)
							<option value="{{ $po_no->purchase_order_no }}">{{ $po_no->purchase_order_no }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-6" id="new">

					</div>
				 </div>
                  <div id="new1"></div>

                    <div class="row form-group" style="background: #ececec;padding: 15px;">
                        <div class="col-md-12">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" value="" id="check1" checked onchange="getchecked()">I hereby certify that goods have been received as per
                                    specification ordered and found in good condition
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" value="" id="check2" onchange="getchecked()">Items received found in good condition and have been installed
                                    successfully. It is further added that the installed items are working satisfactorily.
                                </label>
                            </div>
                        </div>
                    </div>

				 <button type="submit" class="btn btn-danger btn-sm" id="submit">Submit</button>

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



		function getpoitem(val)
		{
			// alert(val);
			$.ajax({

				url:'{{url('procurement/purchase/itemgrnwith-po-details')}}/'+val,
				type: "GET",

				success: function(jsonStr) {


					$("#new1").html(jsonStr);


				}
			});
		}
		function getbalance(row)
		{

			var order_qty = $('#balance_qty'+row).val();
			var receive_qty = $('#receive_qty'+row).val();
			//alert(balance_qty);
				var balance_qty = order_qty - receive_qty;
				$('#balance_qty'+row).val(balance_qty);

		}
		// function addnewrow(rowid)
		// {
		// 	if (rowid != ''){
		// 			$('#add'+rowid).attr('disabled',true);

		// 		}


		// 	$.ajax({

		// 			url:'{{url('procurement/purchase/get-add-row-grn-item')}}/'+rowid,
		// 			type: "GET",

		// 			success: function(jsonStr) {
		// 				console.log(jsonStr);
		// 				$(".addrow").append(jsonStr);

		// 			}
		// 		});
		// }
		/*function getiteminfo(val,row)
		{
			$.ajax({
				url:'{{url('procurement/purchase/get-item-rate')}}/'+val+'/'+row,
				type: "GET",
				success: function(jsonStr) {
					var jqObj = jQuery.parseJSON(jsonStr);
					$("#price"+row).val(jqObj.rate);
				 }
			});

		}*/
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


        function getchecked() {
            if(!$("#check1").is(":checked") && !$("#check2").is(":checked")) {
                alert('Please check at least one checkbox!!!');
                $('#check1').prop('checked', true);
            }
        }
	</script>
@endsection
