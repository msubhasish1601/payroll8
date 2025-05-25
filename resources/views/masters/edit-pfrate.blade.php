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
            <h5 class="card-title">Edit PF Loan Interest List</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">PayrollMaster</a></li>
                                
								<li>/</li>
                                <li><a href="#">PF Loan Interest List</a></li>
                                
								<li>/</li>
                                <li class="active">Edit PF Loan Interest List</li>
						
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
                            <form action="{{ url('masters/update-pfinterest') }}" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" value="<?php if(!empty($gpf_details->id)){ echo $gpf_details->id; }  ?>">

                                <div class="row form-group">

                                    <div class="col-md-4">
                                        <label class="form-control-label">Effective From<span>(*)</span></label>
										<input type="date" id="effective_from" name="effective_from" required class="form-control" value="<?php if(!empty($gpf_details->effective_from)){ echo date('Y-m-d',strtotime($gpf_details->effective_from)); }  ?>" required>
                                        
										@if ($errors->has('effectiveFfrom'))
                                            <div class="error" style="color:red;">{{ $errors->first('effectiveFfrom') }}</div>
                                        @endif
                                    </div>

                                    
                                    <div class="col-md-4">
                                        <label class=" form-control-label">Interest Rate<span>(*)</span></label>
                                         <input type="number" step="any" id="interest" name="interest" required class="form-control" value="<?php if(!empty($gpf_details->interest)){ echo $gpf_details->interest; }  ?>" required>
                                       
									   @if ($errors->has('interest'))
                                            <div class="error" style="color:red;">{{ $errors->first('interest') }}</div>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <label class=" form-control-label"> Status <span>(*)</span></label>
                                        <select id="status" name="status" class="form-control" required>
                                            <option value="active" @if($gpf_details->status=='active') selected @endif>Active</option>
                                            <option value="inactive"  @if($gpf_details->status=='inactive') selected @endif>Inactive</option>
                                        </select>
                                        @if ($errors->has('group_name'))
                                            <div class="error" style="color:red;">{{ $errors->first('group_name') }}</div>
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
