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



@section('scripts')
	@include('procurement.indent.partials.scripts')
@endsection

@section('content')
<style>
    .aply-lv a {
    background: #1c9ac5;
    color: #fff;
    padding: 6px 24px;
    font-size: 14px;
    }

    .card-title {
    font-size: 21px !important;
    }

    .btn-info {
        color: #fff;
        background-color: #17a2b8;
        border-color: #17a2b8;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        padding: 6px 10px;
    }
</style>
        <!-- Content -->
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
                <!-- Widgets  -->
                <div class="row">

                    <div class="main-card">

                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title" style="font-size:21px; font-weight: 100;"><img src="{{asset('images/product.png')}}" alt="">PF Details</strong>
                            </div>
                            @if(!empty($gpf_details))
                            @if(count($gpf_details)!='0')
							<div class="aply-lv" style="padding-right: 36px;">
								<a href="{{ url('employee-corner/gpf-loan-apply') }}" class="btn btn-default">Apply for GPF Withdrawal <i class="fa fa-plus"></i></a>
							</div>
                             @endif
                            @endif
                            <div class="card-body">

							<div class="srch-rslt" style="overflow-x:scroll;">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
											<th>Month</th>
                                            <th>PF No.</th>
											<th>Opening Balance</th>
											<th>Own Contributions</th>
											<th>Company Contributions</th>
                                            <th>Closing Balance</th>
                                            {{--  --}}
                                        </tr>
                                    </thead>
                                    <tbody>
									@foreach($gpf_details as $gpf_detail)

                                        <tr>
                                            <td>{{ $gpf_detail->month_year }}</td>
                                            <td>{{ $gpf_detail->emp_pf_no }}</td>
											<td>{{ $gpf_detail->opening_balance }}</td>
											<td>{{ $gpf_detail->own_share }} </td>
											<td>{{ $gpf_detail->company_share }}</td>
                                            <td>{{ $gpf_detail->closing_balance }}</td>
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
