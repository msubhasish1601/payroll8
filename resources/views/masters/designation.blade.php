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
            <h5 class="card-title">Designation Master</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">HCM Master</a></li>
                                <li>/</li>
                                <li><a href="#"><li class="active">Designation Master</li>
</a></li>
                                <li>/</li>
                            
                                <li class="active">Add New Designation</li>
						
                            </ul>
                        </span>
</div>
</div>
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">
                    <!-- <div class="card-header">
                        <strong>Add Designation Master</strong>
                    </div> -->
                    <div class="card-body card-block">

                        <form action="{{ url('masters/save-designation') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label for="text-input" class=" form-control-label">Select Department <span>(*)</span></label>

                                    <select class="form-control" name="department_code" required>

                                        <option value='' selected disabled>Select</option>
                                        @foreach($department as $dept)
                                        <option value='{{ $dept->id }}' <?php if (app('request')->input('id')) {
                                                                            if ($designation->department_code == $dept->department_code) {
                                                                                echo 'selected';
                                                                            }
                                                                        } ?> <?php if (app('request')->input('id')) {
                                                                                                                                                                                                        if ($designation->department_code == $dept->id) {
                                                                                                                                                                                                            echo 'selected';
                                                                                                                                                                                                        }
                                                                                                                                                                                                    } ?>>{{ $dept->department_name }}</option>

                                        @endforeach

                                    </select>
                                    @if ($errors->has('department_code'))
                                    <div class="error" style="color:red;">{{ $errors->first('department_code') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label for="email-input" class=" form-control-label">Enter Designation <span>(*)</span></label>
                                    <input type="text" required id="designation_name" name="designation_name" class="form-control" <?php if (app('request')->input('id')) {?>value="<?php
                                                                                                                                        echo $designation->designation_name;?>"<?php 
                                                                                                                                    } ?>  >
                                    @if ($errors->has('designation_name'))
                                    <div class="error" style="color:red;">{{ $errors->first('designation_name') }}</div>
                                    @endif
                                </div>
                                <?php if (app('request')->input('id')) {  ?>

                                    <div class="col-md-6">
                                        <label for="text-input" class=" form-control-label">Status<span>(*)</span></label>
                                        <select class="form-control" name="des_status" required>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>

                                    </div>

                                <?php  } ?>

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