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
            <h5 class="card-title">P Tax Slab</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Payroll Master</a></li>
                                
								<li>/</li>
                                <li class="active">P Tax Slab</li>
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
                        <a href="{{ url('masters/add-tax-slab') }}" class="btn btn-default">Add New P Tax Slab <i class="fa fa-plus"></i></a>
                    </div>
                    </div>


                    @include('include.messages')
                    
                    <br />
                    <div class="clear-fix">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Serial no.</th>
                                    <th>Salary from</th>
                                    <th>Salary To</th>
                                    <th>P Tax Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($tax_slab as $tax)
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td>{{ $tax->salary_from }}</td>
                                    <td>{{ $tax->salary_to }}</td>
                                    <td>{{ $tax->p_tax_amount }}</td>
                                    <td><a href="{{url('masters/edit-tax-slab/')}}/{{$tax->id}}"><i class="ti-pencil-alt"></i></a>
                                        
                                    <a href="{{url('masters/del-tax-slab/')}}/{{$tax->id}}" onclick="return confirm('Are you sure you want to delete this P Tax Slab?');"><i class="ti-trash"></i></a>

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