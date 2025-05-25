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
            <h5 class="card-title">Add GPF Rate List</h5>
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">PayrollMaster</a></li>

								<li>/</li>
                                <li><a href="#">GPF Rate List</a></li>

								<li>/</li>
                                <li class="active">Add GPF Rate List</li>

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
                            <form action="{{ url('masters/gpf-rate-save') }}" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" value="<?php if (!empty($gpf_details->id)) {echo $gpf_details->id;}?>">

                                <div class="row form-group">

                                    <div class="col-md-4">
                                        <label class="form-control-label">Rate of Interest<span>(*)</span></label>
                                        <input type="text" name="rate_of_interest" required id="rate_of_interest"  value="<?php if (!empty($gpf_details->rate_of_interest)) {echo $gpf_details->rate_of_interest;}?>" class="form-control" value="" required>
                                        @if ($errors->has('rate_of_interest'))
                                            <div class="error" style="color:red;">{{ $errors->first('rate_of_interest') }}</div>
                                        @endif
                                    </div>

                                    <div class="col-md-4">
                                        <label class=" form-control-label">From Date<span>(*)</span></label>
                                         <input type="date" name="from_date" required class="form-control"   value="<?php if (!empty($gpf_details->from_date)) {echo $gpf_details->from_date;}?>" required>
                                        @if ($errors->has('from_date'))
                                            <div class="error" style="color:red;">{{ $errors->first('from_date') }}</div>
                                        @endif
                                    </div>

                                    <div class="col-md-4">
                                        <label class=" form-control-label">To Date<span>(*)</span></label>
                                         <input type="date" name="to_date" required class="form-control" value="<?php if (!empty($gpf_details->to_date)) {echo $gpf_details->to_date;}?>"  required>
                                        @if ($errors->has('to_date'))
                                            <div class="error" style="color:red;">{{ $errors->first('to_date') }}</div>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <label class=" form-control-label">Effected On<span>(*)</span></label>
                                         <input type="date" name="effect_on" required class="form-control" value="<?php if (!empty($gpf_details->effect_on)) {echo $gpf_details->effect_on;}?>" required>
                                        @if ($errors->has('effect_on'))
                                            <div class="error" style="color:red;">{{ $errors->first('effect_on') }}</div>
                                        @endif
                                    </div>


                                    <div class="col-md-4">
                                        <label class=" form-control-label">File Number<span>(*)</span></label>
                                         <input type="text" name="gpf_no "  required class="form-control"  value="<?php if (!empty($gpf_details->gpf_no)) {echo $gpf_details->gpf_no;}?> " required>
                                        @if ($errors->has('gpf_no'))
                                            <div class="error" style="color:red;">{{ $errors->first('gpf_no') }}</div>
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
