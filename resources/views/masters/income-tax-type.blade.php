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
                        <strong class="card-title">Income Tax Type Master</strong>
                    </div>


                    @include('include.messages')
                    <div class="aply-lv">
                        <a href="{{ url('masters/add-income-tax-type') }}" class="btn btn-default">Add New Income Tax Type <i class="fa fa-plus"></i></a>
                    </div>
                    <br />
                    <div class="clear-fix">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Serial no.</th>
                                    <th>Income Tax Type Description</th>
                                    <th>Tax Type</th>
                                    <th>Max Amount</th>
                                    <th>Financial Year</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($income_tax as $tax)
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td>{{ $tax->tax_desc }}</td>
                                    <td>{{ $tax->tax_type }}</td>
                                    <td>{{ $tax->max_amount }}</td>
                                    <td>{{ $tax->financial_year	 }}</td>
                                    <td><a href="{{url('masters/edit-income-tax-type/')}}/{{$tax->id}}"><i class="ti-pencil-alt"></i></a>
                                        
                                    <a href="{{url('masters/del-income-tax-type/')}}/{{$tax->id}}" onclick="return confirm('Are you sure you want to delete this Income Tax Type?');"><i class="ti-trash"></i></a>

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