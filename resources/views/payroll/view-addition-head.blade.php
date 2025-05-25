@extends('layouts.master')

@section('title')
Payroll Information System-Addition Head
@endsection

@section('sidebar')
	@include('partials.sidebar')
@endsection

@section('header')
	@include('partials.header')
@endsection



@section('scripts')
	@include('partials.scripts')
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
									<strong class="card-title">Addition Head</strong>
								</div>
								@if(Session::has('message'))										
										<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
								@endif	
								<div class="aply-lv">
								<a href="{{ url('pis/addition-head') }}" class="btn btn-default">Add Addition Head <i class="fa fa-plus"></i></a>
							</div>
								<br/>
								 <div class="clear-fix">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sl. No.</th>
                                            <th>Head Name</th>
											<th>Alias</th>
											<th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									@foreach($addition_head_rs as $addition_head)
                                        <tr>
                                            <td>{{ $loop->iteration  }}</td>
                                            <td>{{ $addition_head->head_name }}</td>
                                            <td>{{ $addition_head->alias_name }}</td>
											<td>{{ $addition_head->description }}</td>
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
       <?php //include("footer.php"); ?>
    </div>
    <!-- /#right-panel -->


@endsection
