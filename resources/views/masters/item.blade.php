@extends('masters.layouts.master')

@section('title')
Configuration-Item
@endsection

@section('sidebar')
	@include('masters.partials.sidebar')
@endsection

@section('header')
	@include('masters.partials.header')
@endsection





@section('content')
 <!-- Content -->
  <div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
    <div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title">Add New Item</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Procurement Master</a></li>
                                
								<li>/</li>
                <li><a href="#">Item</a></li>
                                
                                <li>/</li>
                                <li class="active">Add New item</li>
						
                            </ul>
                        </span>
</div>
</div>
          
      <!-- Widgets  -->
      <div class="row">
        <div class="main-card">
          <div class="card">
            <!-- <div class="card-header"><strong class="card-title"><img src=" " alt="">Add New Item</strong></div> -->
            <div class="card-body card-block">
              <form action="{{ url('masters/save-item') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="item_id" name="id" value="<?php if(!empty($item->id)){ echo $item->id; } ?>" />

                <div class="clearfix"></div>
                <div class="lv-due" style="border:none;">
                  <!--<div class="lv-due-hd">
											<h4>Leave Due as on</h4>
										</div>-->
                  <div class="row form-group lv-due-body">
                    <div class="col-md-4">
                       <label for="text-input" class=" form-control-label">Item Code</label>
                      <input type="text" class="form-control" name="item_code" required>
          					   @if ($errors->has('item_code'))
          							<div class="error" style="color:red;">{{ $errors->first('item_code') }}</div>
          						   @endif
                    </div>
                    <div class="col-md-4">
                       <label for="text-input" class=" form-control-label">Item Name</label>
                      <input type="text" class="form-control" id="cname" name="name" required >
                       @if ($errors->has('name'))
                        <div class="error" style="color:red;">{{ $errors->first('name') }}</div>
                         @endif
                    </div>
          					<div class="col-md-4">
                        <label for="text-input" class=" form-control-label">Item Type</label>
                        <select class="form-control" name="type" required>
                        <option value="" selected="disabled">Select Type</option>
                        <option value="inventory" <?php if(!empty($item->type)){ if("inventory"== $item->type) { echo "selected"; } } ?>>Inventory</option>
                        <option value="assets" <?php if(!empty($item->type)){ if("assets"== $item->type){ echo "selected";}} ?>>Assets</option>
                        <option value="expense" <?php if(!empty($item->type)){ if("expense"== $item->type){ echo "selected";}} ?>>Expense</option>
                      </select>
          					   @if ($errors->has('item_type'))
          							<div class="error" style="color:red;">{{ $errors->first('item_type') }}</div>
          						   @endif
                    </div>

                    <div class="col-md-4">
                    <label>Category</label>
                      <select class="form-control" id="category_id" name="c_id" onchange="selectSubCategory()" required>
                      <option value="" >Select Category</option>
                      @foreach($categories as $category)
                      <option value="{{ $category->cat_code }}" <?php if(!empty($item->c_id)){ if($category->cat_code == $item->c_id) { echo "selected"; } } ?>>{{ $category->cat_name }}</option>
                      @endforeach
                      </select>
                      @if ($errors->has('unit_id'))
                      <div class="error" style="color:red;">{{ $errors->first('unit_id') }}</div>
                      @endif
                    </div>

                    <div class="col-md-4">
                    <label>Sub Category</label>
                      <select class="form-control" id="sub_category_id" name="sc_id" required>
                      <option value="" >Select SubCategory</option>
                      <!-- @foreach($subcategories as $subcategory)
                      <option value="{{ $subcategory->id }}" <?php if(!empty($item->sc_id)){ if($subcategory->id == $item->sc_id) { echo "selected"; } } ?>>{{ $subcategory->sub_cat_name }}</option>
                      @endforeach -->
                      </select>
                      @if ($errors->has('unit_id'))
                      <div class="error" style="color:red;">{{ $errors->first('unit_id') }}</div>
                      @endif
                    </div>

                    <div class="col-md-4">
                      <label for="text-input" class=" form-control-label">Min. stock Level</label>
                    <input type="number" class="form-control" name="min_stock" required >

                    @if ($errors->has('min_stock'))
                      <div class="error" style="color:red;">{{ $errors->first('min_stock') }}</div>
                    @endif
                    </div>

                    <div class="col-md-4">
                      <label for="text-input" class=" form-control-label">Max. stock Level</label>
                    <input type="number" class="form-control" required name="max_stock" >

                    @if ($errors->has('max_stock'))
                      <div class="error" style="color:red;">{{ $errors->first('max_stock') }}</div>
                    @endif
                    </div>

          					<div class="col-md-4">
                      <label>Unit</label>
                        <select class="form-control" id="item_unit" name="unit_id" required>
          							<option value="" selected="disabled">Select Unit</option>
            							@foreach($unit_rs as $unit)
            							<option value="{{ $unit->id }}" <?php if(!empty($item->unit_id)){ if($unit->id == $item->unit_id) { echo "selected"; } } ?>>{{ $unit->name }}</option>
            							@endforeach
          					     </select>
              					 @if ($errors->has('unit_id'))
              						<div class="error" style="color:red;">{{ $errors->first('unit_id') }}</div>
              					 @endif
                    </div>

                  <div class="col-md-4">
                    <label>Stockable</label>
                      <select class="form-control" name="stockable" required>
                      <option value='' selected disabled>Select</option>
                      <option value="yes" <?php if(!empty($item->stockable)){ if("yes"== $item->stockable) { echo "selected"; } } ?> >Yes</option>
                      <option value="no" <?php if(!empty($item->stockable)){ if("no"== $item->stockable) { echo "selected"; } } ?> >No</option>
                      </select>
                       @if ($errors->has('stockable'))
                      <div class="error" style="color:red;">{{ $errors->first('stockable') }}</div>
                       @endif
                  </div>

                  <div class="col-md-4">
                    <label>Status</label>
                      <select class="form-control" name="status" required>
                      <option value='' selected disabled>Select</option>
        							<option value="active" <?php if(!empty($item->status)){ if("active"== $item->status) { echo "selected"; } } ?> >Active</option>
        							<option value="inactive" <?php if(!empty($item->status)){ if("inactive"== $item->status) { echo "selected"; } } ?> >Inactive</option>
        						  </select>
        						   @if ($errors->has('status'))
        							<div class="error" style="color:red;">{{ $errors->first('status') }}</div>
        						   @endif
                  </div>

                      <div class="col-md-4">
                          <label for="text-input" class=" form-control-label">GST(%)</label>
                          <input type="text" class="form-control"  name="gst" value="<?php if(!empty($item->gst)){ echo $item->gst; } ?>">

                          @if ($errors->has('gst'))
                              <div class="error" style="color:red;">{{ $errors->first('gst') }}</div>
                          @endif
                      </div>

                      <div class="col-md-4">
                          <label for="text-input" class=" form-control-label">Description(If any)</label>
                          <textarea class="form-control" name="item_desc" value="<?php if(!empty($item->item_desc)){ echo $item->item_desc; } ?>"></textarea>

                          @if ($errors->has('item_desc'))
                              <div class="error" style="color:red;">{{ $errors->first('item_desc') }}</div>
                          @endif
                      </div>
                  </div>
				          <button type="submit" class="btn btn-danger btn-sm">Submit</button>
                  <button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Reset</button>
                </div>
              </form>
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
@include('masters.partials.scripts')

<script>
  selectSubCategory();

    var sub_category = "<?php  if(!empty($item->sc_id)){ echo $item->sc_id;}?>";

    setTimeout(function(){
      if(sub_category!=""){
        $("#sub_category_id option[value='"+sub_category+"']").prop('selected', 'selected');
      }
    },1000);


    function selectSubCategory(){
      var category_id = $("#category_id option:selected").val();
      // alert(category_id);
      $.ajax({
        type:'GET',
        url:'{{url('masters/subcategory')}}/'+category_id,
        success: function(response){

            console.log(response);
            var option = '';
            option += '<option value="">Select SubCategory</option>';
            for (var i=0;i<response.length;i++){
              option += '<option value="'+ response[i].sub_cat_code+ '">' + response[i].sub_cat_name  + '</option>';
            }
            $('#sub_category_id').html(option);

        }
      });
    }
</script>

@endsection
