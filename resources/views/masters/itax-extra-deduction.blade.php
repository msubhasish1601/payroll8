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
                        <strong class="card-title">Income Tax Extra Deduction</strong>
                    </div>

                    @include('include.messages')
                    <div class="aply-lv">
                        <a href="{{ url('masters/add-itax-extra-deduction') }}" class="btn btn-default">Add New Income Tax Extra Deduction <i class="fa fa-plus"></i></a>
                    </div>
                    <br />
                    <div class="clear-fix">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Serial no.</th>
                                    <th>Financial Year</th>
                                    <th>Percentage</th>
                                    <th>Amount Greater</th>
                                    <th>Extra Description</th>
                                    <th>Extra Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($tax_extra_deduction as $extra)
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td>{{ $extra->financial_year }}</td>
                                    <td>{{ $extra->percentage }}</td>
                                    <td>{{ $extra->amount_greater }}</td>
                                    <td>{{ $extra->extra_desc }}</td>
                                    <td>{{ $extra->extra_type }}</td>
                                    <td><a href="{{url('masters/edit-itax-extra-deduction/')}}/{{$extra->id}}"><i class="ti-pencil-alt"></i></a>
                                        
                                    <a href="{{url('masters/del-itax-extra-deduction/')}}/{{$extra->id}}" onclick="return confirm('Are you sure you want to delete this Income Tax Extra Deduction?');"><i class="ti-trash"></i></a>

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