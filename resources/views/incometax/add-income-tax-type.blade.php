@extends('incometax.layouts.master')

@section('title')
BELLEVUE - Income Tax Module
@endsection

@section('sidebar')
@include('incometax.partials.sidebar')
@endsection

@section('header')
@include('incometax.partials.header')
@endsection

@section('scripts')
@include('incometax.partials.scripts')
@endsection

@section('content')

<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="row" style="border:none;">
            <div class="col-md-6">
                <h5 class="card-title">Add Income Tax Type Master</h5>
            </div>
            <div class="col-md-6">
                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Income Tax Type Master</a></li>
                        <li>/</li>
                        <li><a href="#">Add Income Tax Type Master</a></li>
                    </ul>
                </span>
            </div>
        </div>
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">
                   
                    <div class="card-body card-block">

                        <form action="{{ url('itax/save-income-tax-type') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class=" form-control-label">Financial Year <span>(*)</span></label>
                                    <!-- <input type="text" required id="financial_year" name="financial_year" class="form-control" value=""> -->
                                    <select name="financial_year" class="form-control" >
                                        <option value="">Choose a year</option>
                                        <?php $starting_year  = date('Y', strtotime('-10 year'));
                                        $ending_year = date('Y', strtotime('+10 year'));
                                        $current_year = date('Y');
                                        for ($starting_year; $starting_year <= $ending_year; $starting_year++) {
                                            echo '<option value="' . $starting_year . '-' . ($starting_year + 1) . '"';
                                            if ($starting_year ==  $current_year) {
                                                echo ' selected="selected"';
                                            }
                                            echo ' >' . $starting_year . '-' . ($starting_year + 1) . '</option>';
                                        }               ?>
                                    </select>
                                    @if ($errors->has('financial_year'))
                                    <div class="error" style="color:red;">{{ $errors->first('financial_year') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Income Tax Type Description <span>(*)</span></label>
                                    <input type="text" required id="tax_desc" name="tax_desc" class="form-control" value="">
                                    @if ($errors->has('tax_desc'))
                                    <div class="error" style="color:red;">{{ $errors->first('tax_desc') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Max Amount <span>(*)</span></label>
                                    <input type="number" step="any" required id="max_amount" name="max_amount" class="form-control" value="">
                                    @if ($errors->has('max_amount'))
                                    <div class="error" style="color:red;">{{ $errors->first('max_amount') }}</div>
                                    @endif
                                    <p>Input numeric ZERO if there is not ceiling.</p>
                                </div>
                                <div class="col-md-4">
                                    <label class=" form-control-label">Form 16 Reference</label>
                                    <input type="text"  id="form_xvi_ref" name="form_xvi_ref" class="form-control" value="" >
                                    @if ($errors->has('form_xvi_ref'))
                                    <div class="error" style="color:red;">{{ $errors->first('form_xvi_ref') }}</div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class=" form-control-label">Itax report Reference</label>
                                    <input type="text"  id="itax_form_ref" name="itax_form_ref" class="form-control" value="" >
                                    @if ($errors->has('itax_form_ref'))
                                    <div class="error" style="color:red;">{{ $errors->first('itax_form_ref') }}</div>
                                    @endif
                                </div>

                            </div>
                            <p>(*) marked fields are mandatory</p>
                            
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