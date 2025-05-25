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
            <h5 class="card-title">Employee Type DA</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Payroll Master</a></li>
                                
								<li>/</li>
                                <li class="active">Employee Type DA</li>
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
                        <a href="{{ url('masters/add-emp-type-da') }}" class="btn btn-default">Add New Employee Type DA <i class="fa fa-plus"></i></a>
                    </div>
                    </div>

                    @include('include.messages')
                    
                    <br />
                    <div class="clear-fix">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Serial no.</th>
                                    <th>Employee Type</th>
                                    <th>DA Percent</th>
                                    <th>Grade</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($emp_type_da as $type_da)
                                <tr>
                                    
                                    <td><?php echo $i++; ?></td>
                                    <td>{{ $type_da->employee_type_name }}</td>
                                    <td>{{ $type_da->da_percent }}</td>
                                    <td>{{ $type_da->grade_name }}</td>
                                    <td>
                                        <a href="{{url('masters/edit-emp-type-da/')}}/{{$type_da->id}}"><i class="ti-pencil-alt"></i></a>
                                        <a href="{{url('masters/del-emp-type-da/')}}/{{$type_da->id}}" onclick="return confirm('Are you sure you want to delete this Employee Type DA?');"><i class="ti-trash"></i></a>
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