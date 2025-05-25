@extends('projects.layouts.master')

@section('title')
QOLARIS - Clients Module
@endsection


@section('content')


<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="row" style="border:none;">
            <div class="col-md-6">
                <h5 class="card-title">Client</h5>
            </div>
            <div class="col-md-6">

                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Client</a></li>

                        <li>/</li>
                        <li class="active">Client</li>

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
                            <a href="{{ url('projects/add-clients') }}" class="btn btn-default">Add New Client <i
                                    class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <!-- @if(Session::has('message'))
							<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
					@endif	 -->
                    @include('include.messages')

                    <br />
                    <div class="clear-fix">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl. No.</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clients_rs as $client)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ $client->poc_phone_no }}</td>
                                    <td>{{ $client->poc_email }}</td>
                                    <td>{{ $client->type}}</td>
                                    <td>
                                        @if($client->status==0)
                                        pending
                                        @elseif($client->status==1)
                                        active
                                        @else
                                        inactive
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{url('projects/edit-clients')}}/{{$client->id}}"><i
                                                class="fa fa-edit"></i></a>
                                        <!--<a href=""><i class="fa fa-trash"></i>-->
                                        </a>
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


@section('scripts')

@endsection
