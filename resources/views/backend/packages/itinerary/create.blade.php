@extends ('backend.layouts.master')

@section ('title', trans('Create Package Itinerary'))

@section('page-header')
<h1>
	{{ trans('Package Itinerary Management') }}
	<small>{{ trans('menus.packages.itinerary.create') }}</small>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! link_to_route('admin.packages.index', trans('Package Management')) !!}</li>
<li class="active">{!! trans('Package Itinerary Create') !!}</li>
@stop

<div class = "xtra-itinerary display-none">
	<div class="block-itinerary">
		<hr>
		<div class="form-group">
			<label class="control-label">Day</label>
			{!! Form::input('number', 'day_it[]', null, ['placeholder'=>'Enter Day', 'class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			<label class="control-label">Title</label>
			{!! Form::text('title_it[]',null,['class'=>'form-control', 'placeholder'=>'Enter Title']) !!}
		</div>

		<div class="form-group">
			<label class="control-label">Walk Distance <small>(In KM)</small></label>
			{!! Form::input('number', 'walk_it[]', null, ['placeholder'=>'Enter Walk Distance in KM', 'step'=>'any', 'class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			<label class="control-label">Content</label>
			{!! Form::textarea('content_it[]',null,['class'=>'form-control editor', 'placeholder'=>'Enter Content']) !!}
		</div>
		<div class="form-group">
			<label class="control-label">Order</label>
			{!! Form::input('number', 'order_it[]', null, ['placeholder'=>'Enter Order', 'min'=>'0', 'class' => 'form-control']) !!}
		</div>
	</div>

</div>
@section('content')

<div id="overlay">
<i class="fa fa-refresh fa-spin loading-icon text-center display-none" ></i>
{!! Form::open(['url'=>'admin/packages/itinerary', 'id'=>'package-form', 'class'=>'iti-form']) !!}
	<div class="row">
	<div class="col-md-9">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Itinerary Details</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div><!-- /.box-tools -->
			</div>
			<div class="box-body">

				<div class = "itinerary">
					<div class="form-group">
						<label class="control-label">Day</label>
						{!! Form::input('number', 'day_it[]', null, ['placeholder'=>'Enter Day', 'class' => 'form-control']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">Title</label>
						{!! Form::text('title_it[]',null,['class'=>'form-control', 'placeholder'=>'Enter Title']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">Walk Distance <small>(In KM)</small></label>
						{!! Form::input('number', 'walk_it[]', null, ['placeholder'=>'Enter Walk Distance in KM', 'step'=>'any', 'class' => 'form-control']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">Content</label>
						{!! Form::textarea('content_it[]',null,['class'=>'form-control tinymce', 'placeholder'=>'Enter Content']) !!}
					</div>
					<div class="form-group">
			<label class="control-label">Order</label>
			{!! Form::input('number', 'order_it[]', null, ['placeholder'=>'Enter Order', 'min'=>'0', 'class' => 'form-control']) !!}
		</div>

					<div id = "add-xtra-itinerary">

					</div>

				</div>
				<a class="btn btn-warning btn-add-itinerary">Add Itinerary </a>
				<a class="btn btn-danger btn-remove-itinerary">Remove Itinerary </a>

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
				{!! Form::select('package_id',$packages,null,['class'=>'form-control', 'id'=>'itinerary-package']) !!}
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
		{!! Form::submit('Save',['class'=>'btn btn-orange', 'id'=>'itinerary-btn']) !!}
	</div>
	
</div>


{!! Form::close() !!}
</div>
@include('backend.includes.tinymce')


@endsection