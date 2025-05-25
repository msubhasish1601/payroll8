@extends('procurement.indent.layouts.master')

@section('title')
Payroll Information System-Company
@endsection

@section('sidebar')
  @include('procurement.indent.partials.sidebar')
@endsection

@section('header')
  @include('procurement.indent.partials.header')
@endsection


<style>
    #weatherWidget .currentDesc {
        color: #ffffff!important;
    }
        .traffic-chart {
            min-height: 335px;
        }
        #flotPie1  {
            height: 150px;
        }
        #flotPie1 td {
            padding:3px;
        }
        #flotPie1 table {
            top: 20px!important;
            right: -10px!important;
        }
        .chart-container {
            display: table;
            min-width: 270px ;
            text-align: left;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        #flotLine5  {
             height: 105px;
        }

        #flotBarChart {
            height: 150px;
        }
        #cellPaiChart{height: 160px;} .card .btn-danger {padding: 4px 10px;}
    </style>

  <!-- Content -->
  <div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
      <!-- Widgets  -->
      <div class="row">
        <div class="main-card">
          <div class="card">
            <div class="card-header"><strong class="card-title"><img src="{{assets(images/product.png)}}" alt=""> Add New Product</strong></div>
            <div class="card-body card-block">
              <form action="{{ url('masters/item') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
                <!--<div class="emp-descp-main">   
								<div class="col-md-4 emp-desc">Employee Id: <span>1234</span></div>
								<div class="col-md-4 emp-desc">Employee Name: <span>Dibyendu Paul</span></div>
								<div class="col-md-4 emp-desc">Designation: <span>Manager</span></div>
								<div class="col-md-4 emp-desc">Grade: <span>1234</span></div>
								<div class="col-md-4 emp-desc">Date of Application: <span>13.10.2018</span></div>
								</div>-->
                <div class="clearfix"></div>
                <div class="lv-due" id="parent_div" style="border:none;">
                  <!--<div class="lv-due-hd">
											<h4>Leave Due as on</h4>
										</div>-->
                  <div class="row form-group lv-due-body child_div">
				
                    <div class="col-md-3">                      
                     	<label>Item Name</label>
						<input type="text" class="form-control" name="item_name">
				    </div>
					  <div class="col-md-3">
              <label for="text-input" class=" form-control-label">Item Type</label>
              <select class="form-control" name="item_type">
							<option value="" selected="disabled">Select Type</option>
							<option value="inventory">Inventory</option>
							<option value="assets">Assets</option>
							
																																					
						</select>
					  </div>
					  <!-- <div class="col-md-3">
                      <label for="text-input" class=" form-control-label">Product Category</label>
                     <select class="form-control">
							<option value="" selected="disabled">Select Type</option>
							<option value="">Category1</option>
							<option value="">Category2</option>
							<option value="">Category3</option>
							<option value="">Category4</option>																														
						</select>
                    </div> -->
					  <div class="col-md-3 ">
					  	<label>Min. stock</label>
						<input type="number" class="form-control" name="min_stock">
						</div>
					  
				  </div>
					  
				<div class="row form-group">
				<div class="col-md-3">
						<label for="text-input" class=" form-control-label">Item Unit</label>
              <select class="form-control" name="item_unit">
							<option value="" selected="disabled">Select Unit</option>
							<option value="">Pcs</option>
							<option value="">Mtrs</option>
							<option value="">Kg</option>
							<option value="">Category4</option>																														
						</select>
					  </div>	
					  
					 	
				</div>
			 
					
				  
						<button type="button" class="btn btn-danger btn-sm"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Submit</button>
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
<div class="clearfix"></div>

</div>
<!-- /#right-panel -->
<!-- Scripts -->
@section('scripts')
  @include('procurement.indent.partials.scripts')

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
jQuery(document).ready(function($){
$('#create_button').click(function() {
    var html = $('.child_div:first').parent().html();
    $(html).insertBefore(this);
});

$(document).on("click", ".deleteButton", function() {
    $(this).closest('.child_div').remove();
});
});
</script>
@endsection
