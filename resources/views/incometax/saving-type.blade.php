@extends('incometax.layouts.master')

@section('title')
BELLEVUE - Income Tax Module
@endsection

@section('sidebar')
@include('incometax.partials.sidebar')
@endsection

@section('header')
@include('incometax.partials.header')
@endsection



@section('scripts')
@include('incometax.partials.scripts')
@endsection

@section('content')
<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="row" style="border:none;">
            <div class="col-md-6">
                <h5 class="card-title">Savings Type Master</h5>
            </div>
            <div class="col-md-6">
                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Savings Type Master</a></li>
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
                            <a href="{{ url('itax/add-saving-type') }}" class="btn btn-default">Add New Savings Type
                                Master <i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    @include('include.messages')
                    <br />
                    <div class="clear-fix">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Serial no.</th>
                                    <th>Financial Year</th>
                                    <th>Income Tax Type</th>
                                    <th>Savings Type Description</th>
                                    <th>Max Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($saving_type as $saving)
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td>{{ $saving->financial_year }}</td>
                                    <td>{{ $saving->tax_desc }}</td>
                                    <td>{{ $saving->saving_type_desc }}</td>
                                    <td>{{ $saving->max_amount	 }}</td>
                                    <td><a href="{{url('itax/edit-saving-type/')}}/{{$saving->id}}"><i
                                                class="ti-pencil-alt"></i></a>

                                        <a href="{{url('itax/del-saving-type/')}}/{{$saving->id}}"
                                            onclick="return confirm('Are you sure you want to delete this Savings Type Master?');"><i
                                                class="ti-trash"></i></a>

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