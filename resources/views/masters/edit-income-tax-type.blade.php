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
                        <strong>Edit Income Tax Type Master</strong>
                    </div>
                    <div class="card-body card-block">

                        <form action="{{ url('masters/update-income-tax-type') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $income_tax->id}}">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class=" form-control-label">Financial Year <span>(*)</span></label>
                                    <input type="text" required id="financial_year" name="financial_year" class="form-control" value="{{ $income_tax->financial_year}}" >
                                    
                                    @if ($errors->has('financial_year'))
                                    <div class="error" style="color:red;">{{ $errors->first('financial_year') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Income Tax Type Description <span>(*)</span></label>
                                    <input type="text" required id="tax_desc" name="tax_desc" class="form-control" value="{{ $income_tax->tax_desc}}" >
                                    @if ($errors->has('tax_desc'))
                                    <div class="error" style="color:red;">{{ $errors->first('tax_desc') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Max Amount <span>(*)</span></label>
                                    <input type="text" required id="max_amount" name="max_amount" class="form-control" value="{{ $income_tax->max_amount}}" >
                                    @if ($errors->has('max_amount'))
                                    <div class="error" style="color:red;">{{ $errors->first('max_amount') }}</div>
                                    @endif
                                </div>
                               
                            </div>

                            <div class="row form-group">
                            <div class="col-md-4">
                                    <label class=" form-control-label">Tax Type <span>(*)</span></label>
                                    <input type="text" required id="tax_type" name="tax_type" class="form-control" value="{{ $income_tax->tax_type}}" >
                                    @if ($errors->has('tax_type'))
                                    <div class="error" style="color:red;">{{ $errors->first('tax_type') }}</div>
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