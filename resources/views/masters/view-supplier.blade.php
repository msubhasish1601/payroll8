@extends('masters.layouts.master')

@section('title')
Configuration-Supplier
@endsection

@section('sidebar')
	@include('masters.partials.sidebar')
@endsection

@section('header')
	@include('masters.partials.header')
@endsection





@section('content')
      <!-- Content -->
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
            <div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title"> Supplier</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Procurement Master</a></li>
                                
								<!-- <li>/</li>
                <li class="active"><a href="#">Sub Catagory</a></li>
                                 -->
                                <li>/</li>
                                <li class="active">Supplier</li>
						
                            </ul>
                        </span>
</div>
</div>
                <!-- Widgets  -->
                <div class="row">

                    <div class="main-card">
                        <!--<div class="card">
                            <div class="card-header">
                                <strong><i class="fa fa-eye" aria-hidden="true"></i> View Tour Status for the Month: October, 2018</strong>
                            </div>
                            <div class="card-body card-block">
                                <form action="#" method="post" enctype="multipart/form-data" style="padding:2% 5%;">


                                    <div class="row form-group">
									<div class="col-md-6">
                                        <label for="from-date" class=" form-control-label">From Date (*)</label>
                                        <input type="date" id="from-date" name="from-date" placeholder="dd/mm/yyyy" class="form-control">
										<p>(*) marked fields are mandatory</p>
                                   </div>
								   <div class="col-md-6">
                                        <label for="to-date" class=" form-control-label">To Date (*)</label>
                                        <input type="date" id="from-date" name="to-date" placeholder="dd/mm/yyyy" class="form-control">
										</div>
                                    </div>
							<div class="card-body" style="text-align:center;">
                                <button type="button" class="btn btn-danger btn-sm">Search</button>
                                <button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Reset</button>
                            </div>





							</form>


                        </div>

                    </div>-->

                        <div class="card">
                            <div class="card-header">
                            <div class="aply-lv" style="padding-right: 36px;">
								<a href="{{ url('masters/add-supplier') }}" class="btn btn-default">Add New Supplier <i class="fa fa-plus"></i></a>
							</div>
                            </div>
							<!-- @if(Session::has('message'))
									<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
							@endif -->
                            @include('include.messages')
						
                            <div class="card-body">

							<div class="srch-rslt" style="overflow-x:scroll;">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered table-responsive" style=" ">
                                    <thead>
                                        <tr>
											<th>Sl no.</th>
											<th>Supplier Code</th>
                                            <th>Supplier Name</th>
                                            <th>Supplier Business</th>
                                            <th>GSTIN</th>
                                            <th>PAN No</th>
                                            <th>Mobile</th>
											<th>Email</th>
											<th>Alt. Contact No.</th>
											<th>Status</th>
											<th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
										@foreach($supplier_rs as $supplier)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $supplier->supplier_code }}</td>
											<td>{{ $supplier->contact_person_name }}</td>
											<td>{{ $supplier->supplier_business_name }}</td>
											<td>{{ $supplier->supplier_gstin }}</td>
											<td>{{ $supplier->pan_no }}</td>
											<td>{{ $supplier->supplier_mobile }}</td>
											<td>{{ $supplier->supplier_email }}</td>
											<td>{{ $supplier->supplier_alt_no }}</td>
											<td>{{ $supplier->supplier_status }}</td>
											<td><a href='{{url("masters/edit-supplier/$supplier->id")}}'><i class="ti-pencil-alt"></i></a>
												</td>
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


        <div class="clearfix"></div>

        @endsection

@section('scripts')
@include('masters.partials.scripts')

@endsection
