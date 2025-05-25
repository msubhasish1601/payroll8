@extends('projects.layouts.master')

@section('title')
BELLEVUE - Clients Module
@endsection

@section('sidebar')
@include('projects.partials.sidebar')
@endsection

@section('header')
@include('projects.partials.header')
@endsection

@section('scripts')
@include('projects.partials.scripts')
@endsection

@section('content')

<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">

        <div class="row" style="border:none;margin-right:15px;margin-left:15px;">
            <div class="col-md-6">
                <h5 class="card-title">Edit Client Information</h5>
            </div>
            <div class="col-md-6">

                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Client</a></li>

                        <li>/</li>
                        <li class="active">Edit Client Information</li>

                    </ul>
                </span>
            </div>
        </div>
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">
                    <!-- <div class="card-header">
                        <strong>Edit Company Information</strong>

                    </div> -->
                    <div class="card-body card-block">

                        <form action="{{ url('projects/update-clients') }}" method="post" enctype="multipart/form-data"
                            class="form-horizontal">
                            {{csrf_field()}}

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="<?php echo $ClientData->id; ?>">

                            <div class="row form-group">
                                <div class="col-12 col-md-6">
                                    <label for="email-input" class=" form-control-label"> Name
                                        <!-- <span class="error">(*)</span> -->
                                    </label>
                                    <input type="text" required id="name" name="name" class="form-control"
                                        value="{{$ClientData->name}}">
                                    @if ($errors->has('name'))
                                    <div class="error" style="color:red;">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="password-input" class=" form-control-label">Phone
                                        <!-- <span class="error">(*)</span> -->
                                    </label>
                                    <input type="text"  id="poc_phone_no" name="poc_phone_no"
                                        class="form-control" value="{{$ClientData->poc_phone_no}}" maxlength="10" pattern="\d{10}" title="Please enter exactly 10 digits">

                                    @if ($errors->has('phone'))
                                    <div class="error" style="color:red;">{{ $errors->first('phone') }}</div>
                                    @endif
                                </div>


                            </div>

                            <div class="row form-group">

                                <div class="col-12 col-md-6">
                                    <label for="selectSm" class=" form-control-label"> Email</label>
                                    <input type="email" id="poc_email" name="poc_email" class="form-control"
                                        value="{{$ClientData->poc_email}}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="selectSm" class=" form-control-label"> Type</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="" hidden>Select Type</option>
                                        <option @if($ClientData->type=='Public'){{'selected'}} @endif
                                            value="Public">Public</option>
                                        <option @if($ClientData->type=='Private'){{'selected'}} @endif
                                            value="Private">Private</option>
                                    </select>
                                    <!-- <input type="text" id="type" name="type" class="form-control" value=""> -->
                                </div>

                            </div>



                            <div class="row form-group">

                                <div class="col-12 col-md-6">
                                    <label for="selectSm" class=" form-control-label"> Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="" hidden>Select Type</option>
                                        <option @if($ClientData->status==0){{'selected'}} @endif value="0">Pending
                                        </option>
                                        <option @if($ClientData->status==1){{'selected'}} @endif value="1">Active
                                        </option>
                                        <option @if($ClientData->status==2){{'selected'}} @endif value="2">Inactive
                                        </option>
                                    </select>
                                    <!-- <input type="text" id="status" name="status" class="form-control" value=""> -->
                                </div>
                            </div>

                    </div>

                    <div class="card-body">
                        <button type="submit" class="btn btn-danger btn-sm" style="
    position: relative;
    left: 900px;
">Update
                        </button>

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
<div class="clearfix"></div>





@endsection