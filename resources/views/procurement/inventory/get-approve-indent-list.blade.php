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
        #weatherWidget .currentDesc {
            color: #ffffff!important;
        }
        .traffic-chart {
            min-height: 335px;
        }
        #flotPie1  {
            height: 150px;
        }
        #flotPie1 td {
            padding:3px;
        }
        #flotPie1 table {
            top: 20px!important;
            right: -10px!important;
        }
        .chart-container {
            display: table;
            min-width: 270px ;
            text-align: left;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        #flotLine5  {
            height: 105px;
        }

        #flotBarChart {
            height: 150px;
        }
        #cellPaiChart{
            height: 160px;
        }

    </style>



    <!-- Content -->
    <div class="content">
        <!-- Animated -->
        <div class="animated fadeIn">
            <!-- Widgets  -->
            <div class="row">

                <div class="main-card">


                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><img src="{{asset('images/requisition.png')}}" alt="" style="width:30px;"> View Approved Indents</strong>
                        </div>

                        <div class="card-body">

                            <div class="srch-rslt" style="overflow-x:scroll;">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered" style="text-align:center;">
                                    <thead>
                                    <tr style="text-align:center;">
                                        <th>Sl. No.</th>
                                        <th>Approved Indent No.</th>
                                        <th>Indent Made By</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=1; foreach($indent_lists as  $result) { ?>

                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $result->indent_no; ?></td>
                                        <td><?php echo $result->emp_fname .''. $result->emp_mname .''. $result->emp_lname; ?></td>
                                        <td><a class="btn btn-round btn-info" href='{{url("procurement/inventory/add-issue-register-item")}}'><i class="fa fa-plus" style="color: #fff;" aria-hidden="true"></i></a></td>

                                    </tr>
                                    <?php }  ?>



                                    </tbody>
                                </table>
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



@endsection
