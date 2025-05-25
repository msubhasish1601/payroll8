@extends('masters.layouts.master')

@section('title')
Configuration-Category
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
            <h5 class="card-title">Add Catagory</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Procurement Master</a></li>
                                
								<li>/</li>
                <li><a href="#">Catagory</a></li>
                                
                                <li>/</li>
                                <li class="active">Add New Catagory</li>
						
                            </ul>
                        </span>
</div>
</div>
<!-- {{asset('images/product.png')}} -->
    <!-- Widgets  -->
    <div class="row">
      <div class="main-card">
        <div class="card">
          <!-- <div class="card-header"><strong class="card-title"><img src="" style="width:50%;" alt="">Add New Category</strong></div> -->
          <div class="card-body card-block">
            <form action="{{ url('masters/save-category') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" id="category_id" name="id" value="<?php if (!empty($category->id)) {
                                                                        echo $category->id;
                                                                      } ?>" />


              <div class="clearfix"></div>
              <div class="lv-due" style="border:none;">
                <!--<div class="lv-due-hd">
											<h4>Leave Due as on</h4>
										</div>-->
                <div class="row form-group lv-due-body">
                  <div class="col-md-4">
                    <label for="text-input" class=" form-control-label">Category Code</label>
                    <input type="text" class="form-control" required name="cat_code" value="<?php if (!empty($category->cat_code)) {
                                                                                      echo $category->cat_code;
                                                                                    } ?>">
                    @if ($errors->has('cat_code'))
                    <div class="error" style="color:red;">{{ $errors->first('cat_code') }}</div>
                    @endif
                  </div>
                  <div class="col-md-4">
                    <label for="text-input" class=" form-control-label">Category Name</label>
                    <input type="text" class="form-control" required name="cat_name" value="<?php if (!empty($category->cat_name)) {
                                                                                      echo $category->cat_name;
                                                                                    } ?>">
                    @if ($errors->has('cat_name'))
                    <div class="error" style="color:red;">{{ $errors->first('cat_name') }}</div>
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

@endsection