@extends('leave.layouts.master')

@section('title')
Payroll Information System-Apply For Tour
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
							<strong class="card-title">Tour Listing</strong>
                             <!--@if(Session::has('message'))
                                <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
                            @endif-->
							@include('include.messages')
						</div>

							<div class="card-body">
                                <div class="aply-lv"><a href="{{ url('employee-corner/apply-for-tour') }}" class="btn btn-default">Tour Apply <i class="fa fa-plus"></i></a></div>
							</div>

							<table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sl. No.</th>
                                            <th>Apply Date</th>
                                            <th>From Date</th>
                                            <th>To Date</th>
                                            <th>Duration</th>
                                            <th>Purpose</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									 @foreach($tour_apply_rs as $tourdtl)
                                        <tr>
                                        	<td>{{$loop->iteration}}</td>
											<td>{{ \Carbon\Carbon::parse($tourdtl->apply_date)->format('d-m-Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($tourdtl->from_date)->format('d-m-Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($tourdtl->apply_date)->format('d-m-Y') }}</td>
                                            <td>{{$tourdtl->duration}}</td>
                                            <td>{{$tourdtl->purpose}}</td>
                                            <td><a href="{{url('employee-corner/tourdtl/'.$tourdtl->id)}}" target="_blank" style="background: #17a2b8; color: #fff;padding: 5px 10px;">View</a></td>
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




<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script>


</script>

        @endsection

@section('scripts')
@include('attendance.partials.scripts')

@endsection
