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
                        <strong class="card-title">Income Tax Max Saving Master</strong>
                    </div>

                    @include('include.messages')
                    <div class="aply-lv">
                        <a href="{{ url('masters/add-itax-max-saving') }}" class="btn btn-default">Add New Income Tax Max Saving Master <i class="fa fa-plus"></i></a>
                    </div>
                    <br />
                    <div class="clear-fix">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Serial no.</th>
                                    <th>Financial Year</th>
                                    <th>Gender</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($tax_max_saving as $tax_max)
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td>{{ $tax_max->financial_year }}</td>
                                    <td>{{ $tax_max->gender }}</td>
                                    <td>{{ $tax_max->amount }}</td>
                                    <td><a href="{{url('masters/edit-itax-max-saving/')}}/{{$tax_max->id}}"><i class="ti-pencil-alt"></i></a>
                                        
                                    <a href="{{url('masters/del-itax-max-saving/')}}/{{$tax_max->id}}" onclick="return confirm('Are you sure you want to delete this Income Tax Max Saving Master?');"><i class="ti-trash"></i></a>

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