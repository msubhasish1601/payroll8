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
                        <strong>Edit Employee Type DA</strong>
                    </div>
                    <div class="card-body card-block">

                        <form action="{{ url('masters/update-emp-type-da') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $emp_type_da->id }}">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class=" form-control-label">Employee Type <span>(*)</span></label>

                                    <select class="form-control" name="emp_type" required>

                                        <option value='' selected disabled>Select</option>
                                        @foreach($emp_type as $type)
                                        <option value='{{ $type->id }}'  <?php  if ($emp_type_da->emp_type == $type->id) { echo 'selected'; } ?>>{{ $type->employee_type_name }}</option>
                                        @endforeach

                                    </select>

                                    @if ($errors->has('emp_type'))
                                    <div class="error" style="color:red;">{{ $errors->first('emp_type') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">DA Percent <span>(*)</span></label>
                                    <input type="text" required id="da_percent" name="da_percent" class="form-control" value="{{ $emp_type_da->da_percent }}" >
                                    @if ($errors->has('da_percent'))
                                    <div class="error" style="color:red;">{{ $errors->first('da_percent') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Employee Grade <span>(*)</span></label>

                                    <select class="form-control" name="emp_grade" required>

                                        <option value='' selected disabled>Select</option>
                                        @foreach($grade_type as $grade)
                                        <option value='{{ $grade->id }}'  <?php  if ($emp_type_da->emp_grade == $grade->id) { echo 'selected'; } ?>>{{ $grade->grade_name }}</option>
                                        @endforeach
                                       
                                    </select>

                                    @if ($errors->has('emp_grade'))
                                    <div class="error" style="color:red;">{{ $errors->first('emp_grade') }}</div>
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