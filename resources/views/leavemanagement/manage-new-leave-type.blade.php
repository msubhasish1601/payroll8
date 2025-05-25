

@extends('leavemanagement.layouts.master')

@section('title')
Leave Type System-Company
@endsection

@section('sidebar')
	@include('leavemanagement.partials.sidebar')
@endsection

@section('header')
	@include('leavemanagement.partials.header')
@endsection

@section('scripts')
	@include('leavemanagement.partials.scripts')
@endsection

@section('content')

 <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
            <div class="row" style="border:none; margin-top:100px;">
            <div class="col-md-6">
            <h5 class="card-title">Manage New Leave Type</h5>
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
							<li><a href="#">Employee</a></li>
                                <li>/</li>
                                <!-- <li><a href="#">Employee Master</a></li>
                                <li>/</li> -->
                                <li class="active">Pay Structure</li>

                            </ul>
                        </span>
</div>
</div>
                <!-- Widgets  -->
                <div class="row">

                    <div class="main-card" style="width:900px;margin-top: 60px;">
                        <div class="card" style="">
                        <div class="card-header">
                            <!-- <strong class="card-title">Manage New Leave Type</strong> -->
                        </div>

                            <div class="card-body card-block">
                                <form action="{{url('leave-management/new-leave-type')}}" method="post" enctype="multipart/form-data" class="form-horizontal" >
                                    @csrf
                                    <input type="hidden" name="id" value="<?php if (!empty($holidaydtl->id)) {echo $holidaydtl->id;}?>">
                                    <div class="row form-group">
                                    <div class="col-md-6">
                                        <label>Leave Type <span>(*)</span></label>
                                        <input type="text" required name='leave_type_name' class="form-control" id="leave-type" value="<?php if (isset($holidaydtl->id)) {echo $holidaydtl->leave_type_name;}?>{{ old('leave_type_name') }}">
                                         @if($errors->has('leave_type_name'))
                                            <div class="error" style="color:red;">{{$errors->first('leave_type_name')}}</div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                    <label>Alias <span>(*)</span></label>
                                <input type="text" name='alies' required class="form-control" id="alies" value="<?php if (isset($holidaydtl->id)) {echo $holidaydtl->alies;}?>{{ old('alies') }}">
                                 @if($errors->has('alies'))
                                            <div class="error" style="color:red;">{{ $errors->first('alies') }}</div>
                                 @endif
                                </div>



                            </div>
                            <div class="row form-group">
                            <div class="col-md-12">
                                <label>Remarks</label>
                                <textarea rows="3" name='remarks' class="form-control" id="remarks"><?php if (isset($holidaydtl->id)) {echo $holidaydtl->remarks;}?></textarea>

                                </div>
                            </div>



                                <button type="submit" class="btn btn-danger btn-sm">Submit</button>
                                <p>(*) marked fields are mandatory</p>

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
        <!-- /.content -->

@endsection
