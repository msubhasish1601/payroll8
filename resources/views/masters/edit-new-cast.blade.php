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
            <h5 class="card-title">Edit New Caste</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">HCM Master</a></li>
                                <li>/</li>
                                <li><a href="#">Caste</a></li>
                                <li>/</li>
                                <li class="active">Edit New Caste</li>
						
                            </ul>
                        </span>
</div>
</div>
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">
                   
                    <div class="card-body card-block">
                        <p>(*) Marked Fields are Mandatory</p>
                        <form action="{{ url('masters/update-new-cast') }}" method="post" enctype="multipart/form-data">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="<?php if (!empty($getCast[0]->id)) { echo $getCast[0]->id; } ?>">
                            <div class="row form-group">



                                <div class="col-md-4">
                                    <label for="text-input" class=" form-control-label">Caste Name <span>(*)</span></label>

                                    <input type="text" class="form-control" required id="cast_name" name="cast_name" value="<?php if (!empty($getCast[0]->cast_name)) { echo $getCast[0]->cast_name; } ?>">

                                    @if ($errors->has('cast_name'))
                                    <div class="error" style="color:red;">{{ $errors->first('cast_name') }}</div>
                                    @endif

                                </div>
                                

                                    <div class="col-md-4">
                                        <label for="text-input" required class=" form-control-label">Status<span>(*)</span></label>
                                        <select class="form-control" name="cast_status">
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>

                                    </div>
</div>
                                 <div class="row form-group">

                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-danger btn-sm">Submit</button>

                                </div>
                            </div>





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
@endsection