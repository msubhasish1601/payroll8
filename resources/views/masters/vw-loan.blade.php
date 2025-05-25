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
            <div class="content">
  <!-- Animated -->
  <div class="animated fadeIn">
  <div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title"><?php if(empty($loan_details->id)){ ?>Add <?php } ?>Loan</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Loan Master</a></li>
                                
								<li>/</li>
                <li class="#"><a href="#">Loan Listing</a></li>
                                
                                <li>/</li>
                                <li class="active"><?php if(empty($loan_details->id)){ ?>Add <?php } ?>Loan</li>
						
                            </ul>
                        </span>
</div>
</div>
                <!-- Widgets  -->
                <div class="row">

                    <div class="main-card">
                        <div class="card">
                            <!-- <div class="card-header">
                            <strong><?php if(empty($loan_details->id)){ ?>Add <?php } ?>Loan</strong>

                            </div> -->
                            <div class="card-body card-block">
                            <form action="{{ url('masters/save-loandetail') }}" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" value="<?php if(!empty($loan_details->id)){ echo $loan_details->id; }  ?>">
                                <div class="row form-group">

                                    <div class="col-md-3">
                                        <label class="form-control-label">Loan Id<span>(*)</span></label>
                                        <input type="text" name="loan_id" id="loan_id" class="form-control" value="<?php if(!empty($loan_details->loan_id)){ echo $loan_details->loan_id; }else{ echo  $loan_code;}  ?>"readonly  required>
                                        @if ($errors->has('loan_id'))
                                            <div class="error" style="color:red;">{{ $errors->first('loan_id') }}</div>
                                        @endif
                                    </div>

                                    <div class="col-md-3">
                                        <label class=" form-control-label">Loan Type<span>(*)</span></label>
                                         <input type="text" name="loan_type" class="form-control" value="<?php if(!empty($loan_details->loan_type)){ echo $loan_details->loan_type; }  ?>" required>
                                        @if ($errors->has('loan_type'))
                                            <div class="error" style="color:red;">{{ $errors->first('loan_type') }}</div>
                                        @endif
                                    </div>

                                    <div class="col-md-3">
                                        <label class=" form-control-label">Remarks<span>(*)</span></label>
                                         <input type="text" name="remarks" class="form-control" value="<?php if(!empty($loan_details->remarks)){ echo $loan_details->remarks; }  ?>" required>
                                        @if ($errors->has('remarks'))
                                            <div class="error" style="color:red;">{{ $errors->first('remarks') }}</div>
                                        @endif
                                    </div>

                                    <div class="col-md-3">
                                        <label for="exampleInputEmail1">Status</label>
                                        <select name="loan_status" id="loan_status" class="form-control" required>
                                            <option value="active" <?php if(!empty($loan_details->loan_status)) { if($loan_details->loan_status == "active"){ echo "selected"; } } ?> >Active</option>
                                            <option value="deactive" <?php if(!empty($loan_details->loan_status)) { if($loan_details->loan_status == "deactive"){ echo "selected"; } } ?>>Deactive</option>
                                        </select>
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
