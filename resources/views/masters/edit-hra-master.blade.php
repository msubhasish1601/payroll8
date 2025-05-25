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
            <h5 class="card-title">HRA Master</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">HCM Master</a></li>
                                <li>/</li>
                                <li><a href="#">HRA Master</a></li>
                                <li>/</li>
                                <li class="active">Edit HRA Master</li>
						
                            </ul>
                        </span>
</div>
</div>
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">
                    <!-- <div class="card-header">
                        <strong>Edit HRA Master</strong>
                    </div> -->
                    <div class="card-body card-block">

                        <form action="{{ url('masters/update-hra-master') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $hra_master->id }}">
                            <div class="row form-group">

                                <div class="col-md-4">
                                    <label class=" form-control-label">HRA Rate <span>(*)</span></label>
                                    <input type="text" required id="hra_rate" name="hra_rate" class="form-control" value="{{ $hra_master->hra_rate }}">
                                    @if ($errors->has('hra_rate'))
                                    <div class="error" style="color:red;">{{ $errors->first('hra_rate') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Employee Type <span>(*)</span></label>

                                    <select class="form-control" name="emp_type" required>

                                        <option value='' selected disabled>Select</option>
                                        @foreach($emp_type as $emp)
                                        <option value='{{ $emp->id }}'  <?php  if ($hra_master->emp_type == $emp->id) { echo 'selected'; } ?>>{{ $emp->employee_type_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('emp_type'))
                                    <div class="error" style="color:red;">{{ $errors->first('emp_type') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Max Amount <span>(*)</span></label>
                                    <input type="text" required id="max_amount" name="max_amount" class="form-control" value="{{ $hra_master->max_amount }}">
                                    @if ($errors->has('max_amount'))
                                    <div class="error" style="color:red;">{{ $errors->first('max_amount') }}</div>
                                    @endif
                                </div>

                            </div>

                            <div class="row form-group">

                                <div class="col-md-4">
                                    <label class=" form-control-label">Grade Type <span>(*)</span></label>

                                    <select class="form-control" name="grade_type" required>

                                        <option value='' selected disabled>Select</option>
                                        @foreach($grade_type as $grade)
                                        <option value='{{ $grade->id }}'  <?php  if ($hra_master->grade_type == $grade->id) { echo 'selected'; } ?>>{{ $grade->grade_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('grade_type'))
                                    <div class="error" style="color:red;">{{ $errors->first('grade_type') }}</div>
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