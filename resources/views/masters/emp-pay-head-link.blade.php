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
            <h5 class="card-title">Employee Pay Head Link Master</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Payroll Master</a></li>
                                
								<li>/</li>
                                <li class="active">Employee Pay Head Link Master</li>
						
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
                        <a href="{{ url('masters/add-emp-pay-head-link') }}" class="btn btn-default">Add New Employee Pay Head Link <i class="fa fa-plus"></i></a>
                    </div>
                    </div>


                    @include('include.messages')
                  
                    <br />
                    <div class="clear-fix">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Serial no.</th>
                                    <th>Pay Deduction ID</th>
                                    <th>Employee Name</th>
                                    <th>Pay Deduction Head</th>
                                    <th>Pay Value</th>
                                    <th>Pay Type</th>
                                    <th>Value Type</th>
                                    <th>Minimum Limit</th>
                                    <th>Maximum Limit</th>
                                    <th>Deduction Order</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($emp_pay_head_link as $pay_head)
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td>{{ $pay_head->pay_deduct_id }}</td>
                                    <td>{{ $pay_head->emp_fname }} {{ $pay_head->emp_mname }} {{ $pay_head->emp_lname }}</td>
                                    <td>{{ $pay_head->pay_deduct_head }}</td>
                                    <td>{{ $pay_head->pay_value }}</td>
                                    <td>{{ $pay_head->pay_type }}</td>
                                    <td>{{ $pay_head->value_type }}</td>
                                    <td>{{ $pay_head->min_limit }}</td>
                                    <td>{{ $pay_head->max_limit }}</td>
                                    <td>{{ $pay_head->deduct_order }}</td>
                                    <td><a href="{{url('masters/edit-emp-pay-head-link/')}}/{{$pay_head->id}}"><i class="ti-pencil-alt"></i></a>
                                        
                                    <a href="{{url('masters/del-emp-pay-head-link/')}}/{{$pay_head->id}}" onclick="return confirm('Are you sure you want to delete this Employee Pay Head Link Master?');"><i class="ti-trash"></i></a>

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