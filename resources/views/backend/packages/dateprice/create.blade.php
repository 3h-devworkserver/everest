@extends ('backend.layouts.master')

@section ('title', trans('Create Package Dates & Prices'))

@section('page-header')
<h1>
	{{ trans('Package Dates & Prices Management') }}
	<small>{{ trans('menus.packages.datesprices.create') }}</small>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! link_to_route('admin.packages.index', trans('Package Management')) !!}</li>
<li class="active">{!! trans('Package Dates & Prices Create') !!}</li>
@stop

@section('content')
<div class="xtra-dateprice display-none">
	<div class="block-dateprice">
	<hr>
		<div class="form-group">
			<label class="control-label">Dates Range</label>
			{!!Form::text('daterange[]',null,['class'=>'form-control daterange', 'placeholder'=> 'Enter Date'])!!}
		</div>
		<div class="form-group">
					<label class="control-label">Short Description <small>(Optional)</small></label>
					{!!Form::textarea('short_description[]',null,['class'=>'form-control', 'rows'=>'2', 'placeholder'=> 'Enter Short Description'])!!}
				</div>
		<div class="form-group">
			<label class="control-label">Price</label>
			{!! Form::input('number', 'price[]', null, ['step'=>'any', 'placeholder'=>'Enter Price', 'class' => 'form-control']) !!}
		</div>
		<div class="form-group">
			<label class="control-label">Trip Status</label>
			{!! Form::select('status[]',['Available'=>'Available','Limited Availability'=>'Limited Availability', 'Already Booked'=> 'Already Booked'],null,['class'=>'form-control']) !!}
		</div>
	</div>
	
</div>
<div id="overlay">
<i class="fa fa-refresh fa-spin loading-icon text-center display-none" ></i>
{!! Form::open(['url'=>'admin/packages/datesprices', 'id'=>'package-form', 'class'=>'dateprice-form']) !!}

<div class="row">
	<div class="col-md-9">
		<div class="box">
			<div class="box-body">
				<div class="form-group">
					<label class="control-label">Description</label>
					{!! Form::textarea('description',null,['class'=>'form-control', 'placeholder'=>'Enter Content']) !!}
				</div>
			</div>
		</div>

		<div class="box">
			<div class="box-body">

				<div class="form-group">
					<label class="control-label">Dates Range</label>
					{!!Form::text('daterange[]',null,['class'=>'form-control daterange', 'placeholder'=> 'Enter Date'])!!}
				</div>
				<div class="form-group">
					<label class="control-label">Short Description <small>(Optional)</small></label>
					{!!Form::textarea('short_description[]',null,['class'=>'form-control', 'rows'=>'2', 'placeholder'=> 'Enter Short Description'])!!}
				</div>
				<div class="form-group">
					<label class="control-label">Price</label>
					{!! Form::input('number', 'price[]', null, ['step'=>'any', 'placeholder'=>'Enter Price', 'class' => 'form-control']) !!}
				</div>
				<div class="form-group">
					<label class="control-label">Trip Status</label>
					{!! Form::select('status[]',['Available'=>'Available','Limited Availability'=>'Limited Availability', 'Already Booked'=> 'Already Booked'],null,['class'=>'form-control']) !!}
				</div>

				<div id = "add-xtra-dateprice">

				</div>

				<a class="btn btn-warning btn-add-dateprice">Add DatePrice </a>
				<a class="btn btn-danger btn-remove-dateprice">Remove DatePrice </a>

			</div>



		</div>



	</div>

	<div class="col-md-3">

		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">Package</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div><!-- /.box-tools -->
			</div><!-- /.box-header -->
			<div class="box-body">
			<div class="form-group" >
				{!! Form::select('package_id',$packages ,null,['id'=>'dateprice-package', 'class'=>'form-control']) !!}
				</div>
				<div>
						<span class="msg-package-status text-danger display-none">Selected Package is already in use !!</span>
					</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->

		
	</div>
</div>
<div class="row">
	<div class="col-md-offset-9 col-md-3">
		{!! Form::submit('Save',['class'=>'btn btn-orange', 'id'=>'dateprice-btn']) !!}
	</div>
	
</div>
{!! Form::close() !!}
</div>
@include('backend.includes.tinymce')
<div class="clearfix"></div>
@endsection



