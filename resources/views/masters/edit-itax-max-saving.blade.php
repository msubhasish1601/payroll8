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
                        <strong>Edit Income Tax Max Saving Master</strong>
                    </div>
                    <div class="card-body card-block">

                        <form action="{{ url('masters/update-itax-max-saving') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $tax_max->id }}">
                            <div class="row form-group">
                            <div class="col-md-4">
                                    <label class=" form-control-label">Financial Year <span>(*)</span></label>
                                    <input type="text" required id="financial_year" name="financial_year" class="form-control" value="{{ $tax_max->financial_year }}">
                                    @if ($errors->has('financial_year'))
                                    <div class="error" style="color:red;">{{ $errors->first('financial_year') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Gender <span>(*)</span></label>
                                    
                                    <select name="gender" class="form-control">
                                        <option value="" selected disabled>Select</option>
                                        <option value="Male" <?php if($tax_max->gender == 'Male'){ echo 'selected'; } ?>>Male</option>
                                        <option value="Female" <?php if($tax_max->gender == 'Female'){ echo 'selected'; } ?>>Female</option>
                                        
                                    </select>
                                    @if ($errors->has('gender'))
                                    <div class="error" style="color:red;">{{ $errors->first('gender') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Amount <span>(*)</span></label>
                                    <input type="text" required id="amount" name="amount" class="form-control" value="{{ $tax_max->amount }}">
                                    @if ($errors->has('amount'))
                                    <div class="error" style="color:red;">{{ $errors->first('amount') }}</div>
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