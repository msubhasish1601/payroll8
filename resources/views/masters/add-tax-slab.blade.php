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
            <h5 class="card-title">Add P Tax Slab</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Payroll Master</a></li>
                                
								<li>/</li>
                                <li><a href="#">P Tax Slab</a></li>
                                
								<li>/</li>
                                <li class="active">Add P Tax Slab</li>
                            </ul>
                        </span>
</div>
</div>
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">
                    <!-- <div class="card-header">
                        <strong>Add P Tax Slab</strong>
                    </div> -->
                    <div class="card-body card-block">

                        <form action="{{ url('masters/save-tax-slab') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row form-group">

                                <div class="col-md-4">
                                    <label class=" form-control-label">Salary From <span>(*)</span></label>
                                    <input type="text" required id="salary_from" name="salary_from" class="form-control" value="">
                                    @if ($errors->has('salary_from'))
                                    <div class="error" style="color:red;">{{ $errors->first('salary_from') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Salary To <span>(*)</span></label>
                                    <input type="text" required id="salary_to" name="salary_to" class="form-control" value="">
                                    @if ($errors->has('salary_to'))
                                    <div class="error" style="color:red;">{{ $errors->first('salary_to') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">P Tax Amount <span>(*)</span></label>
                                    <input type="text" required id="p_tax_amount" name="p_tax_amount" class="form-control" value="">
                                    @if ($errors->has('p_tax_amount'))
                                    <div class="error" style="color:red;">{{ $errors->first('p_tax_amount') }}</div>
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