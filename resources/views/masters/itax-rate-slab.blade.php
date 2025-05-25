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
                        <strong class="card-title">Income Tax Rate Slab Master</strong>
                    </div>

                    @include('include.messages')
                    <div class="aply-lv">
                        <a href="{{ url('masters/add-itax-rate-slab') }}" class="btn btn-default">Add New Income Tax Rate Slab Master <i class="fa fa-plus"></i></a>
                    </div>
                    <br />
                    <div class="clear-fix">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Serial no.</th>
                                    <th>Amount From</th>
                                    <th>Amount To</th>
                                    <th>Percentage</th>
                                    <th>Gender</th>
                                    <th>Additional Amount</th>
                                    <th>Financial Year</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($tax_rate_slab as $tax_rate)
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td>{{ $tax_rate->amount_from }}</td>
                                    <td>{{ $tax_rate->amount_to }}</td>
                                    <td>{{ $tax_rate->percentage }}</td>
                                    <td>{{ $tax_rate->gender }}</td>
                                    <td>{{ $tax_rate->additional_amount }}</td>
                                    <td>{{ $tax_rate->financial_year }}</td>
                                    <td><a href="{{url('masters/edit-itax-rate-slab/')}}/{{$tax_rate->id}}"><i class="ti-pencil-alt"></i></a>
                                        
                                    <a href="{{url('masters/del-itax-rate-slab/')}}/{{$tax_rate->id}}" onclick="return confirm('Are you sure you want to delete this Income Tax Rate Slab Master?');"><i class="ti-trash"></i></a>

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