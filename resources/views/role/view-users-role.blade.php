@extends('role.layouts.master')
@section('title')
{{ config('app.name', 'Laravel') }} - Module
@endsection
@section('sidebar')
@include('role.partials.sidebar')
@endsection

@section('header')
@include('role.partials.header')
@endsection
@section('scripts')
@include('role.partials.scripts')
@endsection

@section('content')

<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
    <div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title">User Role</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Role</a></li>
                                <li>/</li>
                                <li><a href="#">User Role</a></li>
                            </ul>
                        </span>
</div>
</div>
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">

                <div class="card">
                    <div class="card-header">
                        

                        @include('include.messages')

<div class="aply-lv" style="padding-right: 36px;">
    <a href="{{ url('role/add-user-role') }}" class="btn btn-default">Add New User Role <i class="fa fa-plus"></i></a>
</div>
                    </div>

                    <!-- @if(Session::has('message'))										
										<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
								@endif	 -->
                   
                    <div class="card-body">

                        <div class="srch-rslt" style="overflow-x:scroll;">
                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>User ID</th>
                                        <th>Module Name</th>
                                        <th>Sub Module Name</th>
                                        <th>Menu</th>
                                        <th>Rights</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $role)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $role->member_id }}</td>
                                        <td>{{ $role->module_name }}</td>
                                        <td>{{ $role->sub_module_name }}</td>
                                        <td>{{ $role->menu_name }}</td>
                                        <td>{{ $role->rights }}</td>
                                        <td>
                                            <!--<a href='{{url("role/user-role/$role->id")}}'><i class="ti-pencil-alt"></i></a>-->
                                            <a href='{{url("role/delete-users-role/$role->id")}}' onclick="return confirm('Are you sure you want to delete this Access?');">
                                                <i class="ti-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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