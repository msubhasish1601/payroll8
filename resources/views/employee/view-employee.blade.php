@extends('employee.layouts.master')

@section('title')
Employee Information System-Employees
@endsection

@section('sidebar')
@include('employee.partials.sidebar')
@endsection

@section('header')
@include('employee.partials.header')
@endsection

@section('scripts')
@include('employee.partials.scripts')
@endsection

@section('content')

<?php
function my_simple_crypt($string, $action = 'encrypt')
{
    // you may change these values to your own
    $secret_key = 'bopt_saltlake_kolkata_secret_key';
    $secret_iv = 'bopt_saltlake_kolkata_secret_iv';

    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ($action == 'encrypt') {
        $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    } else if ($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}
?>
<!-- Content -->
<style>
    .right-panel {

    margin-top: 93px;
}
.card form {
    	padding: 19px 0 0 0;
        background:none;
	}
</style>
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="row" style="border:none;">
            <div class="col-md-6">
                <h5 class="card-title">Employee Master</h5>
            </div>
            <div class="col-md-6">
                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Employee</a></li>
                        <li>/</li>
                        <li class="active">Employee Master</li>

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
                        <a href="{{ url('add-employee') }}" class="btn btn-default" style="float:right;">Add Employee Master <i class="fa fa-plus"></i></a>
                        @if(count($employee_rs)>0)
                        <form  method="post" action="{{ url('xls-export-employees') }}" enctype="multipart/form-data" >
											<input type="hidden" name="_token" value="{{ csrf_token() }}">

											<button data-toggle="tooltip" data-placement="bottom" title="Download Excel" class="btn btn-default" style="background:none !important;padding: 10px 15px;margin-top: -30px;float:right;margin-right: 15px;" type="submit"><img  style="width: 35px;" src="{{ asset('img/excel-dnld.png')}}"></button>
												</form>
                                <form  method="post" action="{{ url('xls-export-employee-only') }}" enctype="multipart/form-data" >
											<input type="hidden" name="_token" value="{{ csrf_token() }}">

											<button data-toggle="tooltip" data-placement="bottom" title="Download Excel" class="btn btn-default" style="background:none !important;padding: 10px 15px;margin-top: -30px;float:right;margin-right: 15px;" type="submit">Employee Only</button>
												</form>
                        @endif
                    </div>
                    </div>

                    <!-- @if(Session::has('message'))
										<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
								@endif	 -->
                    @include('include.messages')

                    <!-- <div class="aply-lv">
                        <a href="{{ url('add-employee') }}" class="btn btn-default">Add Employee Master <i class="fa fa-plus"></i></a>
                    </div> -->
                    <br />
                    <div class="clear-fix">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl No.</th>
                                    <th>Employee ID</th>
                                    <th>Employee Code</th>
                                    <th>Employee Name</th>
                                    <th>Designation</th>
                                    <th>Mobile</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employee_rs as $employee)
                                <tr>
                                    <td>{{ $loop->iteration}}</td>
                                    <td>{{ $employee->emp_code}}</td>
                                    <td>{{ $employee->old_emp_code}}</td>
                                    <td>{{ $employee->salutation."".$employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname }}</td>
                                    <td>{{ $employee->emp_designation }}</td>
                                    <td>{{ $employee->emp_ps_mobile }}</td>
                                    <td>
                                    <a href="{{ url('edit-employee') }}?q={{ my_simple_crypt( $employee->emp_code, 'encrypt' )}}"><i class="ti-pencil-alt"></i></a>

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
