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
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">

                    <div class="card-header">
                        <strong class="card-title">Savings Type Master</strong>
                    </div>


                    @include('include.messages')
                    <div class="aply-lv">
                        <a href="{{ url('masters/add-saving-type') }}" class="btn btn-default">Add New Savings Type Master <i class="fa fa-plus"></i></a>
                    </div>
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
                                    <td>{{ $saving->tax_type }}</td>
                                    <td>{{ $saving->saving_type_desc }}</td>
                                    <td>{{ $saving->max_amount	 }}</td>
                                    <td><a href="{{url('masters/edit-saving-type/')}}/{{$saving->id}}"><i class="ti-pencil-alt"></i></a>
                                        
                                    <a href="{{url('masters/del-saving-type/')}}/{{$saving->id}}" onclick="return confirm('Are you sure you want to delete this Savings Type Master?');"><i class="ti-trash"></i></a>

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