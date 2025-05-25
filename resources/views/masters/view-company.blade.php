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
                <h5 class="card-title">Company Master</h5>
            </div>
            <div class="col-md-6">

                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Company</a></li>

                        <li>/</li>
                        <li class="active">Company Master</li>

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
                            <a href="{{ url('masters/add-company') }}" class="btn btn-default">Add New Company Master <i
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
                                    <th>Company Name</th>
                                    <th>Company Address</th>
                                    <th>Company Phone No.</th>
                                    <th>Company FAX</th>
                                    <th>Website</th>
                                    <th>Mail ID</th>
                                    <th>Company GSTIN</th>
                                    <th>Company CIN</th>
                                    <th>CGST</th>
                                    <th>SGST</th>
                                    <th>IGST</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($companies_rs as $company)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $company->company_name }}</td>

                                    <td>{{ $company->company_address }}</td>
                                    <td>{{ $company->company_phone }}</td>
                                    <td>{{ $company->company_fax }}</td>
                                    <td>{{ $company->company_web }}</td>
                                    <td>{{ $company->company_mail }}</td>
                                    <td>{{ $company->company_gstin }}</td>
                                    <td>{{ $company->company_cin }}</td>
                                    <td>{{ $company->company_cgst }}</td>
                                    <td>{{ $company->company_sgst }}</td>
                                    <td>{{ $company->company_igst }}</td>
                                    <td>
                                        <a href="{{url('masters/edit-company')}}/{{$company->id}}"><i
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
@include('masters.partials.scripts')
@endsection
