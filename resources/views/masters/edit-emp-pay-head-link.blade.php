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
            <h5 class="card-title">Edit Employee Pay Head Link Master</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Payroll Master</a></li>
                                
								<li>/</li>
                                <li><a href="#">Employee Pay Head Link Master</a></li>
                                
								<li>/</li>
                                <li class="active">Edit Employee Pay Head Link Master</li>
						
                            </ul>
                        </span>
</div>
</div>
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">
                    <!-- <div class="card-header">
                        <strong>Edit Employee Pay Head Link Master</strong>
                    </div> -->
                    <div class="card-body card-block">

                        <form action="{{ url('masters/update-emp-pay-head-link') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $pay_head_link->id}}">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class=" form-control-label">Pay Deduction ID <span>(*)</span></label>
                                    <input type="text" required id="pay_deduct_id" name="pay_deduct_id" class="form-control" value="{{ $pay_head_link->pay_deduct_id}}">
                                    @if ($errors->has('pay_deduct_id'))
                                    <div class="error" style="color:red;">{{ $errors->first('pay_deduct_id') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Employee Name <span>(*)</span></label>

                                    <select class="form-control" name="emp_name" required>
                                        <option value='' selected disabled>Select</option>
                                        @foreach($employee as $emp)
                                        <option value='{{ $emp->id }}' <?php  if ($pay_head_link->emp_name == $emp->id) { echo 'selected'; } ?>>{{ $emp->emp_fname }} {{ $emp->emp_mname }} {{ $emp->emp_lname }}</option>

                                        @endforeach
                                    </select>
                                    @if ($errors->has('emp_name'))
                                    <div class="error" style="color:red;">{{ $errors->first('emp_name') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Pay Deduction Head <span>(*)</span></label>
                                    <input type="text" required id="pay_deduct_head" name="pay_deduct_head" class="form-control" value="{{ $pay_head_link->pay_deduct_head}}">
                                    @if ($errors->has('pay_deduct_head'))
                                    <div class="error" style="color:red;">{{ $errors->first('pay_deduct_head') }}</div>
                                    @endif
                                </div>

                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class=" form-control-label">Pay Value <span>(*)</span></label>
                                    <input type="text" required id="pay_value" name="pay_value" class="form-control" value="{{ $pay_head_link->pay_value}}">
                                    @if ($errors->has('pay_value'))
                                    <div class="error" style="color:red;">{{ $errors->first('pay_value') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Pay Type <span>(*)</span></label>
                                    <input type="text" required id="pay_type" name="pay_type" class="form-control" value="{{ $pay_head_link->pay_type}}">
                                    @if ($errors->has('pay_type'))
                                    <div class="error" style="color:red;">{{ $errors->first('pay_type') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Value Type <span>(*)</span></label>

                                    <select class="form-control" name="value_type" required>

                                        <option value='' selected disabled>Select</option>
                                        <option value='1' <?php  if ($pay_head_link->value_type == '1') { echo 'selected'; } ?>>Value 1</option>
                                        <option value='2' <?php  if ($pay_head_link->value_type == '2') { echo 'selected'; } ?>>Value 2</option>

                                    </select>
                                    @if ($errors->has('value_type'))
                                    <div class="error" style="color:red;">{{ $errors->first('value_type') }}</div>
                                    @endif
                                </div>

                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class=" form-control-label">Minimum Limit <span>(*)</span></label>
                                    <input type="text" required id="min_limit" name="min_limit" class="form-control" value="{{ $pay_head_link->min_limit}}">
                                    @if ($errors->has('min_limit'))
                                    <div class="error" style="color:red;">{{ $errors->first('min_limit') }}</div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class=" form-control-label">Maximum Limit <span>(*)</span></label>
                                    <input type="text" required id="max_limit" name="max_limit" class="form-control" value="{{ $pay_head_link->max_limit}}">
                                    @if ($errors->has('max_limit'))
                                    <div class="error" style="color:red;">{{ $errors->first('max_limit') }}</div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class=" form-control-label">Deduction order <span>(*)</span></label>
                                    <input type="text" required id="deduct_order" name="deduct_order" class="form-control" value="{{ $pay_head_link->deduct_order}}">
                                    @if ($errors->has('deduct_order'))
                                    <div class="error" style="color:red;">{{ $errors->first('deduct_order') }}</div>
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