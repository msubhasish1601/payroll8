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
                        <strong>Edit Savings Type Master</strong>
                    </div>
                    <div class="card-body card-block">

                        <form action="{{ url('masters/save-saving-type') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class=" form-control-label">Financial Year <span>(*)</span></label>
                                    <input type="text" required id="financial_year" name="financial_year" class="form-control" value="{{ $saving_type->financial_year }}">
                                    
                                    @if ($errors->has('financial_year'))
                                    <div class="error" style="color:red;">{{ $errors->first('financial_year') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Income Tax Type <span>(*)</span></label>
                                    <select name="i_tax_type" class="form-control">
                                        <option value="">Select</option>
                                        @foreach($tax_type as $tax)
                                        <option value='{{ $tax->id }}' <?php  if ($saving_type->i_tax_type == $tax->id) { echo 'selected'; } ?>>{{ $tax->tax_desc }}</option>

                                        @endforeach
                                    </select>
                                    @if ($errors->has('i_tax_type'))
                                    <div class="error" style="color:red;">{{ $errors->first('i_tax_type') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Saving Type Description <span>(*)</span></label>
                                    <input type="text" required id="saving_type_desc" name="saving_type_desc" class="form-control" value="{{ $saving_type->saving_type_desc }}">
                                    @if ($errors->has('saving_type_desc'))
                                    <div class="error" style="color:red;">{{ $errors->first('saving_type_desc') }}</div>
                                    @endif
                                </div>

                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class=" form-control-label">Maximum Amount <span>(*)</span></label>
                                    <input type="text" required id="max_amount" name="max_amount" class="form-control" value="{{ $saving_type->max_amount }}">
                                    @if ($errors->has('max_amount'))
                                    <div class="error" style="color:red;">{{ $errors->first('max_amount') }}</div>
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