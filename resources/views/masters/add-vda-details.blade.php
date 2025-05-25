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
            <h5 class="card-title">Add VDA Details</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">VDA Details</a></li>
                                
								<!-- <li>/</li>
                <li class="#"><a href="#">Loan Listing</a></li>
                                 -->
                                <li>/</li>
                                <li class="active">Add VDA Details</li>
						
                            </ul>
                        </span>
</div>
</div>

        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">
                    <!-- <div class="card-header">
                        <strong>Add VDA Details</strong>
                    </div> -->
                    <div class="card-body card-block">

                        <form action="{{ url('masters/save-vda-details') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row form-group">

                            <div class="col-md-4">
                                    <label class=" form-control-label">Pay Month Year <span>(*)</span></label>
                                    <input type="month" required id="pay_month_year" name="pay_month_year" class="form-control" value="" >
                                    @if ($errors->has('pay_month_year'))
                                    <div class="error" style="color:red;">{{ $errors->first('pay_month_year') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Employee Type <span>(*)</span></label>

                                    <select class="form-control" name="emp_type" required>

                                        <option value='' selected disabled>Select</option>
                                        @foreach($employee as $emptype)
                                        <option value='{{ $emptype->id }}'  >{{ $emptype->employee_type_name }}</option>
                                        @endforeach

                                    </select>

                                    @if ($errors->has('emp_type'))
                                    <div class="error" style="color:red;">{{ $errors->first('emp_type') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">VDA Current <span>(*)</span></label>
                                    <input type="text" required id="vda_current" name="vda_current" class="form-control" value="" >
                                    @if ($errors->has('vda_current'))
                                    <div class="error" style="color:red;">{{ $errors->first('vda_current') }}</div>
                                    @endif
                                </div>

                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class=" form-control-label">VDA Previous <span>(*)</span></label>
                                    <input type="text" required id="vda_previous" name="vda_previous" class="form-control" value="" >
                                    @if ($errors->has('vda_previous'))
                                    <div class="error" style="color:red;">{{ $errors->first('vda_previous') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">VDA Previous Previous <span>(*)</span></label>
                                    <input type="text" required id="vda_previous_previous" name="vda_previous_previous" class="form-control" value="" >
                                    @if ($errors->has('vda_previous_previous'))
                                    <div class="error" style="color:red;">{{ $errors->first('vda_previous_previous') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">OT VDA <span>(*)</span></label>
                                    <input type="text" required id="ot_vda" name="ot_vda" class="form-control" value="" >
                                    @if ($errors->has('ot_vda'))
                                    <div class="error" style="color:red;">{{ $errors->first('ot_vda') }}</div>
                                    @endif
                                </div>

                            </div>

                            <button type="submit" class="btn btn-danger btn-sm">Submit
                            </button>

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
<?php //include("footer.php"); 
?>
</div>
<!-- /#right-panel -->






@endsection