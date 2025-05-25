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
            <h5 class="card-title">HR Pay Parameters</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Payroll Master</a></li>
                                
								<li>/</li>
                                <li class="active">HR Pay Parameters</li>
						
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
                        <a href="{{ url('masters/add-hr-pay-parameter') }}" class="btn btn-default">Add Co-Operative Master <i class="fa fa-plus"></i></a>
                    </div>
                    </div>


                    @include('include.messages')
                   
                    <br />
                    <div class="clear-fix">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Serial no.</th>
                                    <th>PF Percentage</th>
                                    <th>PF Bar Amount</th>
                                    <th>APF Percentage</th>
                                    <th>HRA Default Percent</th>
                                    <th>PF Loan Interest</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($hr_pay as $hr)
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td>{{ $hr->pf_percentage }}</td>
                                    <td>{{ $hr->pf_bar_amount }}</td>
                                    <td>{{ $hr->apf_percentage }}</td>
                                    <td>{{ $hr->hra_default_percentage }}</td>
                                    <td>{{ $hr->pf_loan_interest }}</td>
                                    <td><a href="{{url('masters/edit-hr-pay-parameter/')}}/{{$hr->id}}"><i class="ti-pencil-alt"></i></a>
                                        
                                    <a href="{{url('masters/del-hr-pay-parameter/')}}/{{$hr->id}}" onclick="return confirm('Are you sure you want to delete this HR Pay Parameters?');"><i class="ti-trash"></i></a>

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