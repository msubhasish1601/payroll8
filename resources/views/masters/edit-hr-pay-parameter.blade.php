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
                        <strong>Edit HR Pay Parameters</strong>
                    </div>
                    <div class="card-body card-block">

                        <form action="{{ url('masters/update-hr-pay-parameter') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $hr_pay->id}}">
                            <div class="row form-group">

                                <div class="col-md-4">
                                    <label class=" form-control-label">PF Percentage <span>(*)</span></label>
                                    <input type="text" required id="pf_percentage" name="pf_percentage" class="form-control" value="{{ $hr_pay->pf_percentage}}">
                                    @if ($errors->has('pf_percentage'))
                                    <div class="error" style="color:red;">{{ $errors->first('pf_percentage') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">PF Bar Amount <span>(*)</span></label>
                                    <input type="text" required id="pf_bar_amount" name="pf_bar_amount" class="form-control" value="{{ $hr_pay->pf_bar_amount}}">
                                    @if ($errors->has('pf_bar_amount'))
                                    <div class="error" style="color:red;">{{ $errors->first('pf_bar_amount') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">APF Percentage <span>(*)</span></label>
                                    <input type="text" required id="apf_percentage" name="apf_percentage" class="form-control" value="{{ $hr_pay->apf_percentage}}">
                                    @if ($errors->has('apf_percentage'))
                                    <div class="error" style="color:red;">{{ $errors->first('apf_percentage') }}</div>
                                    @endif
                                </div>

                            </div>

                            <div class="row form-group">

                                <div class="col-md-4">
                                    <label class=" form-control-label">HRA Default Percent <span>(*)</span></label>
                                    <input type="text" required id="hra_default_percentage" name="hra_default_percentage" class="form-control" value="{{ $hr_pay->hra_default_percentage}}">
                                    @if ($errors->has('hra_default_percentage'))
                                    <div class="error" style="color:red;">{{ $errors->first('hra_default_percentage') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">PF Loan Interest <span>(*)</span></label>
                                    <input type="text" required id="pf_loan_interest" name="pf_loan_interest" class="form-control" value="{{ $hr_pay->pf_loan_interest}}">
                                    @if ($errors->has('pf_loan_interest'))
                                    <div class="error" style="color:red;">{{ $errors->first('pf_loan_interest') }}</div>
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