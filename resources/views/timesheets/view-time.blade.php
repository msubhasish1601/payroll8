@extends('timesheets.layouts.master')

@section('title')
QOLARIS - TimeSheet Module
@endsection

@section('content')


<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="row" style="border:none;">
            <div class="col-md-6">
                <h5 class="card-title">TimeSheet</h5>
            </div>
            <div class="col-md-6">

                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">TimeSheet</a></li>

                        <li>/</li>
                        <li class="active">TimeSheet</li>

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
                            <a href="{{ url('timesheets/add-timesheet') }}" class="btn btn-default">Add
                                Timesheet_details <i class="fa fa-plus"></i></a>
                        </div>
                    </div>

                    @include('include.messages')

                    <br />
                    <div class="clear-fix">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl. No.</th>
                                    <th>Date</th>
                                    <th>Total Hrs Locked</th>
                                    <th>Status</th>
                                    <th>Created On</th>
                                    <th>Update On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $tsStatus=\Helpers::getTimesheetStatus();
                                @endphp
                                @foreach($timesheet_detail as $tsd)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tsd->sheet_date }}</td>
                                    <td>{{$tsd->total_hours_locked}}</td>
                                    <td>{{$tsStatus[$tsd->status]}}</td>
                                    <td>{{ date('d-m-Y h:i A',strtotime($tsd->created_at)) }}</td>
                                    <td>{{ date('d-m-Y h:i A',strtotime($tsd->updated_at)) }}</td>
                                    <td>
                                        @if($tsd->status == 'P')
                                        <a href="{{url('timesheets/edit-timesheets')}}/{{$tsd->id}}"><i
                                                class="fa fa-edit"></i></a>
                                        </a>
                                        @else
                                        <a href="{{url('timesheets/view-timesheets')}}/{{$tsd->id}}"><i
                                                class="fa fa-eye"></i></a>
                                        </a>
                                        @endif
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
@section('pagecss')
<link rel="stylesheet" href="{{ asset('css/select2.min.css')}}">
@endsection
@section('scripts')
<script src="{{ asset('js/select2.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {
    initailizeSelect2();
});
// Initialize select2
function initailizeSelect2() {

    $(".select2_el").select2();
}
</script>
@endsection
