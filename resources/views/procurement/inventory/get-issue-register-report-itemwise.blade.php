@extends('procurement.inventory.layouts.master')

@section('title')
    Inventory
@endsection

@section('sidebar')
    @include('procurement.inventory.partials.sidebar')
@endsection

@section('header')
    @include('procurement.inventory.partials.header')
@endsection



@section('scripts')
    @include('procurement.inventory.partials.scripts')
@endsection


@section('content')
    <style>
        .bzm-date-picker label, .bzm-date-picker input{border:none;}.ui-notification.success{display:none;}
    </style>


    <!-- Content -->
    <div class="content">
        <!-- Animated -->
        <div class="animated fadeIn">
            <!-- Widgets  -->
            <div class="row">
                <div class="main-card">
                    <div class="card">
                        <div class="card-header"> <strong>Get Issue Register Report</strong> </div>
                        <div class="card-body card-block">

                            @if(Session::has('message'))
                                <div class="alert alert-danger" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
                            @endif
                            <form action="" method="post" enctype="multipart/form-data" style="width: 700px;margin: 0 auto;">

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="row form-group">


                                    <div class="col-md-4">
                                        <label for="text-input" class="form-control-label">Select Start Date</label>
                                        <input type="date" class="form-control" name="start_date" id="start_date" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="text-input" class=" form-control-label">Select End Date</label>
                                        <input type="date" class="form-control" name="to_date" id="to_date" required>

                                    </div>

                                    <div class="col-md-4">
                                        <label for="text-input" class=" form-control-label">Select Item</label>
{{--                                        <label>Select Item</label>--}}
                                        <!-- <input type="text" class="form-control" readonly="" value="Department Name"  name="department_name"> -->
                                        <select class="form-control" name="item_name" id="item_name" required>
                                            <option value="" selected disabled>Select</option>
                                            @foreach($items as $item)
                                                <option value="{{ $item->item_code }}">{{ $item->item_name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('item_name'))
                                            <div class="error" style="color:red;">{{ $errors->first('item_name') }}</div>
                                        @endif

                                    </div>



                                    <div class="col-md-4 btn-up" style=" margin-top: 20px;">
                                        <button type="submit" class="btn btn-danger btn-sm">Submit </button>
                                    </div>
                                </div>

                            </form>
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
    </div>
    <!-- /#right-panel -->
    <!-- Scripts -->
@endsection

@section('scripts')
    @include('employee.scripts')
@endsection
