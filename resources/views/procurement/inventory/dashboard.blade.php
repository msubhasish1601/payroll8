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
                    <!--<div class="card">
                        <div class="card-header">
                            <strong><i class="fa fa-eye" aria-hidden="true"></i> View Tour Status for the Month: October, 2018</strong>
                        </div>
                        <div class="card-body card-block">
                            <form action="#" method="post" enctype="multipart/form-data" style="padding:2% 5%;">


                                <div class="row form-group">
                                <div class="col-md-6">
                                    <label for="from-date" class=" form-control-label">From Date (*)</label>
                                    <input type="date" id="from-date" name="from-date" placeholder="dd/mm/yyyy" class="form-control">
                                    <p>(*) marked fields are mandatory</p>
                               </div>
                               <div class="col-md-6">
                                    <label for="to-date" class=" form-control-label">To Date (*)</label>
                                    <input type="date" id="from-date" name="to-date" placeholder="dd/mm/yyyy" class="form-control">
                                    </div>
                                </div>
                        <div class="card-body" style="text-align:center;">
                            <button type="button" class="btn btn-danger btn-sm">Search</button>
                            <button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Reset</button>
                        </div>





                        </form>


                    </div>

                </div>-->

                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><img src="{{asset('images/requisition.png')}}" alt="" style="width:30px;"> Re-Order Item</strong>
                        </div>

                        <div class="card-body">


                            <div class="srch-rslt" style="overflow-x:scroll;">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered" style="text-align:center;">
                                    <thead>
                                    <tr style="text-align:center;">
                                        <th>Sl. No.</th>
                                        <th>Item Name</th>
                                        <th>Minimum Stock Value</th>
                                        <th>Present Stock Value</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=1; foreach($results as  $result) { $item_code = $result['itemcode'] ?>

                                    <tr>
                                        <td><?php echo $i++ ?></td>
                                        <td><?php echo $result['itemname'] ?></td>
                                        <td><?php echo $result['itemminimumstock'] ?></td>
                                        <td><?php echo $result['closing_balance'] ?></td>
                                        <?php if ($result['closing_balance'] <= $result['itemminimumstock']) { ?>
                                        <td style="text-align:center;"><a class="btn btn-info" title="Re-order" href='{{url("procurement/indent/add-requisition-itemwise/$item_code")}}' style="background:red;border:1px solid red"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Re-Order</a>

                                        </td>
                                        <?php } else { ?>
                                        <td style="text-align:center;">
                                        <?php } ?>
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
