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

        <div class="container-fluid mt--6">
            <div class="row">
                <div class="col-md-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <h3 class="card-title" style="font-size:16px;padding:10px;"><i class="fa fa-key"></i> Change Password</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @include('include.messages')
                            <form action="{{url('save-change-password')}}" method="post">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Old Password</label>
                                            <input type="text" class="form-control" value=""
                                                id="exampleFormControlInput1" name="old_pass" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>New Password</label>
                                            <input type="text" class="form-control" value=""
                                                id="exampleFormControlInput1" name="new_pass" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Confirm Password</label>
                                            <input type="text" class="form-control" value=""
                                                id="exampleFormControlInput1" name="confirm_pass" required>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <button class="btn btn-danger btn-sm" type="submit">Submit</button>
                                    </div>
                                </div>


                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>



            </div>



        </div>




    </div>
    <!-- .animated -->
</div>
<!-- /.content -->




@endsection


@section('scripts')
@include('masters.partials.scripts')
@endsection
