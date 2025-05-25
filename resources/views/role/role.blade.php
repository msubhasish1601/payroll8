@extends('role.layouts.master')

@section('title')
{{ config('app.name', 'Laravel') }} Configuration-Role
@endsection

@section('sidebar')
@include('role.partials.sidebar')
@endsection

@section('header')
@include('role.partials.header')
@endsection

@section('content')
<!-- Content -->
<div class="content">
	<!-- Animated -->
	<div class="animated fadeIn">
	<div class="row" style="border:none;">
            <div class="col-md-6">
            <h5 class="card-title">Role Management</h5>
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Role</a></li>
                                <li>/</li>
								<li><a href="#">Role Management</a></li>
								<li>/</li>
                                <li><a href="#">Add New Role</a></li>
                            </ul>
                        </span>
</div>
</div>
		<!-- Widgets  -->
		<div class="row">
			<div class="main-card">
				<?php //print_r($role_authorization); exit;
?>
				<div class="card">

					<div class="card-body">
						<!-- @if(Session::has('message'))
						<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok"></span><em> {{ Session::get('message') }}</em></div>
						@endif -->
						@include('include.messages')
						<form action="{{ url('role/save-user-role') }}" method="post" enctype="multipart/form-data">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="clearfix"></div>
							<div class="lv-due" style="border:none;">
								<?php $tr_id = 1;?>
								<div class="row form-group lv-due-body">
									<div class="col-md-4">
										<label>Select Module <span>(*)</span></label>
										<select class="form-control"  name="module_name" onchange="getSubModules(this.value);" required>
											<option value="" selected disabled>Select Module</option>
											@foreach($module as $mod)
											<option value="{{$mod->id}}" <?php if (!empty($role_authorization->module_name)) {if ($role_authorization->module_name == $mod->id) {?> selected="selected" <?php }}?>>{{$mod->module_name}}</option>
											@endforeach
										</select>

									</div>

									<div class="col-md-4">
										<label>Sub Module <span>(*)</span></label>
										<select class="form-control" name="sub_module_name" id="sub_module_id" onchange="getMenu(this.value)" required>
											<option value='' selected disabled>Select</option>

										</select>

									</div>

									<div class="col-md-4">
										<label>Menu <span>(*)</span></label>
										<!--<select data-placeholder="Select Menu Name" multiple class="standardSelect" id="role_menus" name="menu_name<?php //echo $tr_id;
?>[]">
                            <option value="" label="default"></option>
                        </select>-->
										<select class="form-control" id="role_menus" name="menu_name[]" multiple required>

										</select>

									</div>
								</div>
								<div class="row form-group">
									<div class="col-md-4">
										<label>Rights <span>(*)</span></label>
										<select data-placeholder="Select Rights" multiple class="standardSelect" name="user_rights_name[]" required>
											<option value="" label="default"></option>
											<option value="Add">Add</option>
											<option value="Edit">Edit</option>
											<option value="Delete">Delete</option>
										</select>
									</div>

									<div class="col-md-4">
										<label>User ID <span>(*)</span></label>
										<select data-placeholder="Select User ID" multiple class="standardSelect" name="member_id[]" required>
											<option value="" label="default"></option>
											@foreach($users as $user)

											<option value="{{$user->email}}">{{$user->email}}</option>
											@endforeach
										</select>
										<!-- <input type="hidden" name="user_type[]" > -->
									</div>

									<div class="col-md-4 btn-up">
										<button type="submit" class="btn btn-danger btn-sm">Submit</button>
										<button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Reset</button>
									</div>

									<div class="clearfix"></div>
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

@endsection

@section('scripts')
@include('role.partials.scripts')
<script>
	//$('.mdb-select').materialSelect();
	function getSubModules(module_id) {
		$.ajax({
			type: 'GET',
			url: '{{url('role/get-sub-modules')}}/' + module_id,
			success: function(response) {
				//console.log(response);
				$("#sub_module_id").html(response);
			}
		});
	}

	function getMenu(sub_module_id) {
		$.ajax({
			type: 'GET',
			url: '{{url('role/get-role-menu')}}/' + sub_module_id,
			success: function(response) {
				console.log(response);
				$("#role_menus").html(response);
			}
		});
	}
</script>



@endsection