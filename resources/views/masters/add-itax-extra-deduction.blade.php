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
                        <strong>Add Income Tax Extra Deduction</strong>
                    </div>
                    <div class="card-body card-block">

                        <form action="{{ url('masters/save-itax-extra-deduction') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row form-group">
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

                                <div class="col-md-4">
                                    <label class=" form-control-label">Percentage <span>(*)</span></label>
                                    <input type="text" required id="percentage" name="percentage" class="form-control" value="">
                                    @if ($errors->has('percentage'))
                                    <div class="error" style="color:red;">{{ $errors->first('percentage') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Amount Greater <span>(*)</span></label>
                                    <input type="text" required id="amount_greater" name="amount_greater" class="form-control" value="">
                                    @if ($errors->has('amount_greater'))
                                    <div class="error" style="color:red;">{{ $errors->first('amount_greater') }}</div>
                                    @endif
                                </div>

                            </div>
                            <div class="row form-group">
                            
                                <div class="col-md-4">
                                    <label class=" form-control-label">Extra Description <span>(*)</span></label>
                                    <input type="text" required id="extra_desc" name="extra_desc" class="form-control" value="">
                                    @if ($errors->has('extra_desc'))
                                    <div class="error" style="color:red;">{{ $errors->first('extra_desc') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Extra Type <span>(*)</span></label>
                                    <input type="text" required id="extra_type" name="extra_type" class="form-control" value="">
                                    @if ($errors->has('extra_type'))
                                    <div class="error" style="color:red;">{{ $errors->first('extra_type') }}</div>
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