@extends('projects.layouts.master')

@section('title')
QOLARIS - Clients Module
@endsection

@section('content')

<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="row" style="border:none;">
            <div class="col-md-6">
                <h5 class="card-title">Create New Clients Information</h5>
            </div>
            <div class="col-md-6">
                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Client</a></li>
                        <li>/</li>
                        <li class="active">Create New Clients Information</li>
                    </ul>
                </span>
            </div>
        </div>
        <!-- Widgets  -->
        <div class="main-card">
            <div class="card">
                <div class="card-body card-block">
                    <form action="{{ url('projects/save-clients') }}" method="post" enctype="multipart/form-data"
                        class="form-horizontal">
                        {{csrf_field()}}
                        <div class="row form-group">
                            <div class="col-12 col-md-6">
                                <label for="email-input" class=" form-control-label" required> Name
                                    <!-- <span class="error">(*)</span> -->
                                </label>
                                <input type="text" required id="name" name="name" class="form-control" value="">
                                @if ($errors->has('name'))
                                <div class="error" style="color:red;">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="password-input" class=" form-control-label">Phone
                                    <!-- <span class="error">(*)</span> -->
                                </label>
                                <input type="text" id="poc_phone_no" name="poc_phone_no" class="form-control" value=""
                                    maxlength="10" pattern="\d{10}" title="Please enter exactly 10 digits">

                                @if ($errors->has('phone'))
                                <div class="error" style="color:red;">{{ $errors->first('phone') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-6">
                                <label for="selectSm" class=" form-control-label"> Email</label>
                                <input type="email" id="poc_email" name="poc_email" class="form-control" value="">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="selectSm" class=" form-control-label"> Type</label>
                                <select name="type" id="type" class="form-control" required>
                                    <option value="" hidden>Select Type</option>
                                    <option value="Public">Public</option>
                                    <option value="Private">Private</option>
                                </select>
                                <!-- <input type="text" id="type" name="type" class="form-control" value=""> -->
                            </div>

                        </div>
                        <div class="row form-group">

                            <div class="col-12 col-md-6">
                                <label for="selectSm" class=" form-control-label"> Status</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="" hidden>Select Type</option>
                                    <option value="0">Pending</option>
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                                <!-- <input type="text" id="status" name="status" class="form-control" value=""> -->
                            </div>
                        </div>

                </div>

                <div class="card-body">
                    <button type="submit" class="btn btn-primary" style="position: relative;left: 900px;">Save
                    </button>

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
<div class="clearfix"></div>





@endsection
