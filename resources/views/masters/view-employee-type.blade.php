@extends('masters.layouts.master')

@section('title')
Payroll Information System-Employee Type
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
            <h5 class="card-title"> Employee Type</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">HCM Master</a></li>
                                
								<li>/</li>
                                <li class="active"> Employee Type</li>
						
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
                        <a href="{{ url('masters/add-employee-type') }}" class="btn btn-default">Add Employee Type <i class="fa fa-plus"></i></a>
                    </div>
                    </div>
                    <!-- @if(Session::has('message'))
                    <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok"></span><em> {{ Session::get('message') }}</em></div>
                    @endif -->
                    @include('include.messages')
                    
                    <br />
                    <div class="clear-fix">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl. No.</th>
                                    <th>Employee Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employee_type_rs as $employee_type)
                                <tr>
                                    <td>{{$loop->iteration}}</td>

                                    <td>{{ $employee_type->employee_type_name  }}</td>
                                    <td><a href='{{ url("masters/edit-employee-type/$employee_type->id") }}'><i class="ti-pencil-alt"></i></a>


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
<?php //include("footer.php"); 
?>
</div>
<!-- /#right-panel -->



@endsection