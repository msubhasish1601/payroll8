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
                <h5 class="card-title">Income Tax Deposits</h5>
            </div>
            <div class="col-md-6">
                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Income Tax Deposits</a></li>
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
                            <a href="{{ url('itax/add-deposit') }}" class="btn btn-default">Add New Income Tax Deposit <i class="fa fa-plus"></i></a>
                        </div>
                    </div>

                    @include('include.messages')

                    <br />
                    <div class="clear-fix">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Serial no.</th>
                                    <th>Payment Date</th>
                                    
                                    <th>Amount</th>
                                    <th>Challan No.</th>
                                    <th>BSR Code</th>
                                    <th>Name of Bank & Branch Where Tax Deposited</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($records as $record)
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td>{{ $record->payment_date }}</td>
                                    
                                    <td>{{ $record->amount }}</td>
                                    <td>{{ $record->challan_no	 }}</td>
                                    <td>{{ $record->bsr_code	 }}</td>
                                    <td>{{ $record->bank	 }}</td>
                                    <td><a href="{{url('itax/edit-deposit/')}}/{{$record->id}}"><i
                                                class="ti-pencil-alt"></i></a>

                                        <a href="{{url('itax/del-deposit/')}}/{{$record->id}}"
                                            onclick="return confirm('Are you sure you want to delete this Income Tax Deposit?');"><i
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