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
                        <strong>Edit Income Tax Rate Slab Master</strong>
                    </div>
                    <div class="card-body card-block">

                        <form action="{{ url('masters/update-itax-rate-slab') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $tax_rate->id }}">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class=" form-control-label">Amount From <span>(*)</span></label>
                                    <input type="text" required id="amount_from" name="amount_from" class="form-control" value="{{ $tax_rate->amount_from }}">
                                    @if ($errors->has('amount_from'))
                                    <div class="error" style="color:red;">{{ $errors->first('amount_from') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Amount To <span>(*)</span></label>
                                    <input type="text" required id="amount_to" name="amount_to" class="form-control" value="{{ $tax_rate->amount_to }}">
                                    @if ($errors->has('amount_to'))
                                    <div class="error" style="color:red;">{{ $errors->first('amount_to') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Percentage <span>(*)</span></label>
                                    <input type="text" required id="percentage" name="percentage" class="form-control" value="{{ $tax_rate->percentage }}">
                                    @if ($errors->has('percentage'))
                                    <div class="error" style="color:red;">{{ $errors->first('percentage') }}</div>
                                    @endif
                                </div>

                            </div>

                            <div class="row form-group">

                                <div class="col-md-4">
                                    <label class=" form-control-label">Gender <span>(*)</span></label>
                                    <select name="gender" class="form-control">
                                        <option value="" selected disabled>Select</option>
                                        <option value="Male" <?php if($tax_rate->gender == 'Male'){ echo 'selected'; } ?>>Male</option>
                                        <option value="Female" <?php if($tax_rate->gender == 'Female'){ echo 'selected'; } ?>>Female</option>
                                        
                                    </select>
                                    @if ($errors->has('gender'))
                                    <div class="error" style="color:red;">{{ $errors->first('gender') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Additional Amount <span>(*)</span></label>
                                    <input type="text" required id="additional_amount" name="additional_amount" class="form-control" value="{{ $tax_rate->additional_amount }}">
                                    @if ($errors->has('additional_amount'))
                                    <div class="error" style="color:red;">{{ $errors->first('additional_amount') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Financial Year <span>(*)</span></label>
                                    <input type="text" required id="financial_year" name="financial_year" class="form-control" value="{{ $tax_rate->financial_year }}">
                                    
                                    @if ($errors->has('financial_year'))
                                    <div class="error" style="color:red;">{{ $errors->first('financial_year') }}</div>
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