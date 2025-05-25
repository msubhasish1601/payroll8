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
            <h5 class="card-title">HRA Master</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">HCM Master</a></li>
                                <li>/</li>
                                <li class="active">HRA Master</li>
						
                            </ul>
                        </span>
</div>
</div>
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">

                    <div class="card-header">
                    <div class="aply-lv">
                        <a href="{{ url('masters/add-hra-master') }}" class="btn btn-default">Add New HRA Master <i class="fa fa-plus"></i></a>
                    </div>
                    </div>


                    @include('include.messages')
                   
                    <br />
                    <div class="clear-fix">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Serial no.</th>
                                    <th>HRA Rate</th>
                                    <th>Employee Type</th>
                                    <th>Max Amount</th>
                                    <th>Grade Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($hra_master as $hra)
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td>{{ $hra->hra_rate }}</td>
                                    <td>{{ $hra->employee_type_name }}</td>
                                    <td>{{ $hra->max_amount }}</td>
                                    <td>{{ $hra->grade_name }}</td>
                                    <td><a href="{{url('masters/edit-hra-master/')}}/{{$hra->id}}"><i class="ti-pencil-alt"></i></a>
                                        
                                    <a href="{{url('masters/del-hra-master/')}}/{{$hra->id}}" onclick="return confirm('Are you sure you want to delete this HRA Master?');"><i class="ti-trash"></i></a>

                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>


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