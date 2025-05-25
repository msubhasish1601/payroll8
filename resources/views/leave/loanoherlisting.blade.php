@extends('leave.layouts.master')

@section('title')
Payroll Information System-Company
@endsection

@section('sidebar')
	@include('leave.partials.sidebar')
@endsection

@section('header')
	@include('leave.partials.header')
@endsection







@section('content')
         <!-- Content -->
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
                <!-- Widgets  -->
                <div class="row">

                    <div class="main-card">

                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">View Loan  Status</strong>
                            </div>
							<div class="aply-lv" style="    padding-right: 36px;">
								<a href="{{ url('employee-corner/loan-apply') }}" class="btn btn-default">Apply Loan <i class="fa fa-plus"></i></a>
							</div>
                            <div class="card-body">
                                <!-- @if(Session::has('Loan_msg'))
                                <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('Loan_msg') }}</em></div>
                            @endif -->
                            @include('include.messages')
							<div class="srch-rslt" style="overflow-x:scroll;">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Application Date</th>
                                            <th>Loan Type</th>
											<th> Amount</th>
											<th> Status</th>

                                        </tr>
                                    </thead>
                                    <tbody>
										@foreach($leave_apply_rs as $loan_apply)

                                        <tr>
                                            <td><?php echo $loan_apply->apply_date; ?></td>
                                            
											<td><?php echo $loan_apply->loan_type; ?></td>
											<td><?php echo $loan_apply->loan_amount; ?></td>

											<td>{{ $loan_apply->loan_status }}</td>



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


        @endsection

@section('scripts')
@include('leave.partials.scripts')

@endsection

