@extends('holiday.layouts.master')

@section('title')
Holiday Dashboard
@endsection


@section('sidebar')
@include('holiday.partials.sidebar')
@endsection

@section('header')
@include('holiday.partials.header')
@endsection


@section('scripts')
@include('holiday.partials.scripts')
@endsection

@section('content')


<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
                <div class="row" style="border:none;">
                    <div class="col-md-6">

						@if(isset($holidaydtl) && !empty($holidaydtl))
							<h5 class="card-title">Edit Holiday Type</h5>
						@else
							<h5 class="card-title">Add Holiday Type</h5>
						@endif
                    </div>
                    <div class="col-md-6">

                        <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Holiday Management</a></li>
                                <li>/</li>
                                <li><a href="#">Holiday Type List</a></li>
                                <li>/</li>
                                @if(isset($holidaydtl) && !empty($holidaydtl))
                                <li class="active">Edit Holiday Type</li>
                                @else
                                <li class="active">Add Holiday Type</li>
                                @endif
                            </ul>
                        </span>
                    </div>
                </div>

                <!-- Widgets  -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card custom-card">
                            <div class="card-header">

                            </div>
                            <div class="card-body">
                                <form action="{{ url('holiday/add-holiday-type') }}" method="post"
                                    enctype="multipart/form-data" class="form-horizontal">

                                    {{csrf_field()}}
                                    <input type="hidden" name="id"
                                        value="<?php if (!empty($holidaydtl->id)) {echo $holidaydtl->id;}?>">
                                    <div class="row">

                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="inputFloatingLabel" class="placeholder">Holiday
                                                    Type</label>
                                                <input id="inputFloatingLabel" type="text"
                                                    class="form-control input-border-bottom" required="" name="name"
                                                    value="<?php if (isset($holidaydtl->id)) {echo $holidaydtl->name;}?>{{ old('name') }}">

                                                @if ($errors->has('name'))
                                                <div class="error" style="color:red;">
                                                    {{ $errors->first('name') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-6"><button type=submit" class="btn btn-default"
                                                style="margin-top:10px;">Submit</button></div>
                                    </div>
                            </div>
                            </form>
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
    @section('scripts')
    @include('holiday.partials.scripts')
    <script>
    </script>
    @endsection