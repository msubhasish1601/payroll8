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
            <h5 class="card-title">Shift Management</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Time Shift Management</a></li>
                                <li>/</li>
                                <li class="active">Shift Management</li>
						
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
                        <a href="{{ url('rota/add-shift-management') }}" class="btn btn-default">Add Shift Management <i class="fa fa-plus"></i></a>
                    </div>
                    </div>
                    @include('include.messages')
                    
                    <div class="card-body">

                        <div class="srch-rslt" style="overflow-x:scroll;">
                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>Shift Code</th>
                                        <th>Shift Description</th>
                                        <th>Work In Time</th>
                                        <th>Work Out Time</th>
                                        <th>Break Time From</th>
                                        <th>Break Time To</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employee_type_rs as $candidate)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $candidate->shift_code }}</td>
                                        <td>{{ $candidate->shift_des }}</td>
                                        <td>{{ date('h:i a',strtotime($candidate->time_in)) }}</td>
                                        <td>{{ date('h:i a',strtotime($candidate->time_out)) }}</td>
                                        <td>{{ date('h:i a',strtotime($candidate->rec_time_in)) }}</td>
                                        <td>{{ date('h:i a',strtotime($candidate->rec_time_out)) }}</td>

                                        <td><a href="{{url('rota/edit-shift-management')}}/{{$candidate->id}}"><i class="ti-pencil-alt"></i></a>



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