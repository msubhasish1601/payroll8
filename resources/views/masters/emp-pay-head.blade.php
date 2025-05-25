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
            <h5 class="card-title">Employee Pay Head Master</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Payroll Master</a></li>
                                
								<li>/</li>
                                <li class="active">Employee Pay Head Master</li>
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
                        <a href="{{ url('masters/add-new-pay-head') }}" class="btn btn-default">Add New Employee Pay Head <i class="fa fa-plus"></i></a>
                    </div>
                    </div>


                    @include('include.messages')
                    
                    <br />
                    <div class="clear-fix">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Serial no.</th>
                                    <th>Pay Type</th>
                                    <th>Pay Deduction Name</th>
                                    <th>Pay Deduction Head</th>
                                    <th>Function Name</th>
                                    <th>Value Type</th>
                                    <th>Pay Value</th>
                                    <th>Calculation Order</th>
                                    <th>Print Order</th>
                                    <th>I Order</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($emp_pay_head as $pay_head)
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td>{{ $pay_head->pay_type }}</td>
                                    <td>{{ $pay_head->pay_deduction_name }}</td>
                                    <td>{{ $pay_head->pay_deduction_head }}</td>
                                    <td>{{ $pay_head->function_name }}</td>
                                    <td>{{ $pay_head->value_type }}</td>
                                    <td>{{ $pay_head->pay_value }}</td>
                                    <td>{{ $pay_head->calculation_order }}</td>
                                    <td>{{ $pay_head->print_order }}</td>
                                    <td>{{ $pay_head->i_order }}</td>
                                    <td><a href="{{url('masters/edit-pay-head/')}}/{{$pay_head->id}}"><i class="ti-pencil-alt"></i></a>
                                        
                                    <a href="{{url('masters/del-pay-head/')}}/{{$pay_head->id}}" onclick="return confirm('Are you sure you want to delete this Employee Pay Head?');"><i class="ti-trash"></i></a>

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