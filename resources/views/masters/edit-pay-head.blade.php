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
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">
                    <div class="card-header">
                        <strong>Add Employee Pay Head Master</strong>
                    </div>
                    <div class="card-body card-block">

                        <form action="{{ url('masters/update-pay-head') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $pay_head->id }}">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class=" form-control-label">Pay Type <span>(*)</span></label>

                                    <select class="form-control" name="pay_type">

                                        <option value='' selected disabled>Select</option>
                                        @foreach($pay_type as $type)
                                        <option value='{{ $type->id }}' <?php  if ($pay_head->pay_type == $type->pay_type) { echo 'selected'; } ?>>{{ $type->pay_type }}</option>
                                        @endforeach

                                    </select>

                                    @if ($errors->has('pay_type'))
                                    <div class="error" style="color:red;">{{ $errors->first('pay_type') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Pay Deduction Name <span>(*)</span></label>
                                    <input type="text" required id="pay_deduction_name" name="pay_deduction_name" class="form-control" value="{{ $pay_head->pay_deduction_name }}">
                                    @if ($errors->has('pay_deduction_name'))
                                    <div class="error" style="color:red;">{{ $errors->first('pay_deduction_name') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Pay Deduction Head <span>(*)</span></label>
                                    <input type="text" required id="pay_deduction_head" name="pay_deduction_head" class="form-control" value="{{ $pay_head->pay_deduction_head }}">
                                    @if ($errors->has('pay_deduction_head'))
                                    <div class="error" style="color:red;">{{ $errors->first('pay_deduction_head') }}</div>
                                    @endif
                                </div>

                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class=" form-control-label">Function Name <span>(*)</span></label>
                                    <input type="text" required id="function_name" name="function_name" class="form-control" value="{{ $pay_head->function_name }}">
                                    @if ($errors->has('function_name'))
                                    <div class="error" style="color:red;">{{ $errors->first('function_name') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Value Type <span>(*)</span></label>

                                    <select class="form-control" name="value_type" required>

                                        <option value='' selected disabled>Select</option>
                                        <option value='1' <?php  if ($pay_head->value_type == '1') { echo 'selected'; } ?>>Value 1</option>
                                        <option value='2' <?php  if ($pay_head->value_type == '2') { echo 'selected'; } ?>>Value 2</option>

                                    </select>
                                    @if ($errors->has('value_type'))
                                    <div class="error" style="color:red;">{{ $errors->first('value_type') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Pay Value <span>(*)</span></label>
                                    <input type="text" required id="pay_value" name="pay_value" class="form-control" value="{{ $pay_head->pay_value }}">
                                    @if ($errors->has('pay_value'))
                                    <div class="error" style="color:red;">{{ $errors->first('pay_value') }}</div>
                                    @endif
                                </div>

                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class=" form-control-label">Calculation Order <span>(*)</span></label>
                                    <input type="text" required id="calculation_order" name="calculation_order" class="form-control" value="{{ $pay_head->calculation_order }}">
                                    @if ($errors->has('calculation_order'))
                                    <div class="error" style="color:red;">{{ $errors->first('calculation_order') }}</div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class=" form-control-label">Print Order <span>(*)</span></label>
                                    <input type="text" required id="print_order" name="print_order" class="form-control" value="{{ $pay_head->print_order }}">
                                    @if ($errors->has('print_order'))
                                    <div class="error" style="color:red;">{{ $errors->first('print_order') }}</div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class=" form-control-label">I order <span>(*)</span></label>
                                    <input type="text" required id="i_order" name="i_order" class="form-control" value="{{ $pay_head->i_order }}">
                                    @if ($errors->has('i_order'))
                                    <div class="error" style="color:red;">{{ $errors->first('i_order') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class=" form-control-label">Status<span>(*)</span></label>
                                    <select class="form-control" name="pay_head_status" required>
                                        <option value="">Select</option>
                                        <option value="active" <?php  if ($pay_head->pay_head_status == 'active') { echo 'selected'; } ?>>Active</option>
                                        <option value="inactive" <?php  if ($pay_head->pay_head_status == 'inactive') { echo 'selected'; } ?>>Inactive</option>
                                    </select>

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