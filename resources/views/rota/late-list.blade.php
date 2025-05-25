@extends('rota.layouts.master')
@section('title')
BELLEVUE - Module
@endsection
@section('sidebar')
@include('rota.partials.sidebar')
@endsection

@section('header')
@include('rota.partials.header')
@endsection
@section('scripts')
@include('rota.partials.scripts')
@endsection

@section('content')

<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
    <div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title">Late Policy</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Time Shift Management</a></li>
                                <li>/</li>
                                <li class="active">Late Policy</li>
						
                            </ul>
                        </span>
</div>
</div>
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                

                <div class="card">
                    <div class="card-header">
                    <div class="aply-lv" style="padding-right: 36px;">
                        <a href="{{ url('rota/add-late-policy') }}" class="btn btn-default">Add Late Policy <i class="fa fa-plus"></i></a>
                    </div>
                    </div>
                    @include('include.messages')
                    
                    <div class="card-body">

                        <div class="srch-rslt" style="overflow-x:scroll;">
                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>Department</th>
                                        <th>Designation</th>
                                        <th>Shift Code</th>
                                        <th>Max Grace Period</th>
                                        <th>No. of Days Allow</th>
                                        <th>No. of Day Salary Deducted</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employee_type_rs as $candidate)
                                    
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $candidate->department_name }}</td> 
                                        <td>{{ $candidate->designation_name }}</td>
                                        <td>{{ $candidate->shift_code }}</td>
                                        <td>{{ $candidate->max_grace }} min</td>
                                        <td>{{ $candidate->no_allow }} </td>
                                        <td>{{ $candidate->no_day_red }} </td>

                                        <td><a href="{{url('rota/edit-late-policy')}}/{{$candidate->id}}"><i class="ti-pencil-alt"></i></a>



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