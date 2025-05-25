@extends('masters.layouts.master')

@section('title')
BELLEVUE - Masters Module
@endsection

@section('sidebar')
    @include('masters.partials.sidebar')
@endsection

@section('header')
    @include('masters.partials.header')
@endsection



@section('scripts')
    @include('masters.partials.scripts')
@endsection

@section('content')


 <!-- Content -->
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
            <div class="row" style="border:none;">
            <div class="col-md-6">       
            <!-- <h5 class="card-title">Add Co-Operative Master</h5>       -->
            <h5 class="card-title">Add Bonus Rate</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">PayrollMaster</a></li>
                                
								<li>/</li>
                                <li><a href="{{ url('masters/bonus-rate') }}">Bonus Rate List</a></li>
                                
								<li>/</li>
                                <li class="active">Add Bonus Rate</li>
						
                            </ul>
                        </span>
</div>
</div>
                <!-- Widgets  -->
                <div class="row">

                    <div class="main-card">
                        <div class="card">
                            <!-- <div class="card-header">
                            <strong>Rate of Interest</strong>

                            </div> -->
                            <div class="card-body card-block">
                            <form action="{{ url('masters/save-bonus-rate') }}" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" value="<?php if(!empty($gpf_details->id)){ echo $gpf_details->id; }  ?>">

                                <div class="row form-group">

                                    <div class="col-md-4">
                                        <label class="form-control-label">Effective From<span>(*)</span></label>
										<input type="date" id="effective_from" name="effective_from" required class="form-control" value="<?php if(!empty($gpf_details->effectiveFfrom)){ echo $gpf_details->effective_from; }  ?>" required>
                                        
										@if ($errors->has('emp_financial_year'))
                                            <div class="error" style="color:red;">{{ $errors->first('emp_financial_year') }}</div>
                                        @endif
                                    </div>

                                    
                                    <div class="col-md-4">
                                        <label class=" form-control-label">Bonus Rate<span>(*)</span></label>
                                         <input type="number" step="any" id="interest" name="interest" required class="form-control" value="<?php if(!empty($gpf_details->interest)){ echo $gpf_details->interest; }  ?>" required>
                                       
									   @if ($errors->has('interest'))
                                            <div class="error" style="color:red;">{{ $errors->first('interest') }}</div>
                                        @endif
                                    </div>

 
  <div class="col-md-4">
                                    <label class=" form-control-label"> Status <span>(*)</span></label>
									<select id="status" name="status" class="form-control" required>
									<option value="active">Active</option>
									<option value="inactive">Inactive</option>
                                   </select>
                                    @if ($errors->has('status'))
                                    <div class="error" style="color:red;">{{ $errors->first('status') }}</div>
                                    @endif
                                </div>

                                </div>

								<button type="submit" class="btn btn-danger btn-sm">Submit</button>

								<p>(*) marked fields are mandatory</p>
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
       <?php //include("footer.php"); ?>
    </div>
    <!-- /#right-panel -->

@endsection





@section('scripts')
@include('masters.partials.scripts')

@endsection
