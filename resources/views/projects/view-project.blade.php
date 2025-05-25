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
                <h5 class="card-title">Project</h5>
            </div>
            <div class="col-md-6">

                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="{{ url('projects/vw-project') }}">Projects </a></li>

                        <li>/</li>
                        <li class="active">List</li>

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
                            <a href="{{ url('projects/add-project') }}" class="btn btn-default">Add New Project <i
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
                                    <th>Code</th>
                                    <th>Client</th>
                                    <th>Owner</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projects_rs as $project)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $project->name }}</td>
                                    <td>{{ $project->project_code }}</td>
                                    <td>{{ $project->client_name }}</td>
                                    <td>{{ $project->emp_fname }} {{ $project->emp_lname }}</td>
                                    <td>
                                        @if($project->status==0)
                                        pending
                                        @elseif($project->status==1)
                                        active
                                        @elseif($project->status==2)
                                        inactive
                                        @elseif($project->status==3)
                                        closed
                                        @elseif($project->status==4)
                                        cancelled
                                        @else
                                        hold
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{url('projects/edit-project')}}/{{$project->id}}"><i
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
