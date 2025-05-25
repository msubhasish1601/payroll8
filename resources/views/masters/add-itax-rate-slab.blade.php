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
                        <strong>Add Income Tax Rate Slab Master</strong>
                    </div>
                    <div class="card-body card-block">

                        <form action="{{ url('masters/save-itax-rate-slab') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class=" form-control-label">Amount From <span>(*)</span></label>
                                    <input type="text" required id="amount_from" name="amount_from" class="form-control" value="">
                                    @if ($errors->has('amount_from'))
                                    <div class="error" style="color:red;">{{ $errors->first('amount_from') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Amount To <span>(*)</span></label>
                                    <input type="text" required id="amount_to" name="amount_to" class="form-control" value="">
                                    @if ($errors->has('amount_to'))
                                    <div class="error" style="color:red;">{{ $errors->first('amount_to') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Percentage <span>(*)</span></label>
                                    <input type="text" required id="percentage" name="percentage" class="form-control" value="">
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
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        
                                    </select>
                                    @if ($errors->has('gender'))
                                    <div class="error" style="color:red;">{{ $errors->first('gender') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Additional Amount <span>(*)</span></label>
                                    <input type="text" required id="additional_amount" name="additional_amount" class="form-control" value="">
                                    @if ($errors->has('additional_amount'))
                                    <div class="error" style="color:red;">{{ $errors->first('additional_amount') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Financial Year <span>(*)</span></label>
                                    <select name="financial_year" class="form-control">
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