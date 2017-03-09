@extends ('backend.layouts.master')

@section ('title', trans('Edit Package Itinerary'))

@section('page-header')
<h1>
	{{ trans('Package Itinerary Management') }}
	<small>{{ trans('menus.packages.itinerary.edit') }}</small>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! link_to_route('admin.packages.index', trans('Package Management')) !!}</li>
<li class="active">{!! trans('Package Itinerary Edit') !!}</li>
@stop
@section('content')

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

<div id="overlay">
<i class="fa fa-refresh fa-spin loading-icon text-center display-none" ></i>
{!! Form::model($package, ['method'=> 'patch', 'id'=>'package-form', 'class'=>'iti-form', 'url'=>'admin/packages/itinerary/'.$package->id, 'id'=>'package-form']) !!}

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
				@if(empty(count($package->itinerarys)))
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
						{!! Form::textarea('content_it[]',null,['class'=>'form-control', 'placeholder'=>'Enter Content']) !!}
					</div>
					<div class="form-group">
			<label class="control-label">Order</label>
			{!! Form::input('number', 'order_it[]', null, ['placeholder'=>'Enter Order', 'min'=>'0', 'class' => 'form-control']) !!}
		</div>
				@else
					<div class="form-group">
						<label class="control-label">Day</label>
						{!! Form::input('number', 'day_it[]', $package->itinerarys[0]->day_it, ['placeholder'=>'Enter Day', 'class' => 'form-control']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">Title</label>
						{!! Form::text('title_it[]',$package->itinerarys[0]->title_it,['class'=>'form-control', 'placeholder'=>'Enter Title']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">Walk Distance <small>(In KM)</small></label>
						{!! Form::input('number', 'walk_it[]', $package->itinerarys[0]->walk_it, ['placeholder'=>'Enter Walk Distance in KM', 'step'=>'any', 'class' => 'form-control']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">Content</label>
						{!! Form::textarea('content_it[]',$package->itinerarys[0]->content_it,['class'=>'form-control tinymce', 'placeholder'=>'Enter Content']) !!}
					</div>
					<div class="form-group">
			<label class="control-label">Order</label>
			{!! Form::input('number', 'order_it[]', $package->itinerarys[0]->order_it, ['placeholder'=>'Enter Order', 'min'=>'0', 'class' => 'form-control']) !!}
		</div>
				@endif

					<div id = "add-xtra-itinerary">

					<?php $j = 0; ?>
					@if(!empty($package->itinerarys))
					@foreach($package->itinerarys as $itinerary)
					@if($j != 0)
					<div class="block-itinerary">
					<hr>
						<div class="form-group">
						<label class="control-label">Day</label>
						{!! Form::input('number', 'day_it[]', $itinerary->day_it, ['placeholder'=>'Enter Day', 'class' => 'form-control']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">Title</label>
						{!! Form::text('title_it[]',$itinerary->title_it,['class'=>'form-control', 'placeholder'=>'Enter Title']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">Walk Distance <small>(In KM)</small></label>
						{!! Form::input('number', 'walk_it[]', $itinerary->walk_it, ['placeholder'=>'Enter Walk Distance in KM', 'step'=>'any', 'class' => 'form-control']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">Content</label>
						{!! Form::textarea('content_it[]',$itinerary->content_it,['class'=>'form-control tinymce', 'placeholder'=>'Enter Content']) !!}
					</div>
					<div class="form-group">
			<label class="control-label">Order</label>
			{!! Form::input('number', 'order_it[]', $itinerary->order_it, ['placeholder'=>'Enter Order', 'min'=>'0', 'class' => 'form-control']) !!}
		</div>
					</div>
					@endif
					<?php $j++; ?>
					@endforeach
					@endif
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
				{!! Form::select('package_id',$packages,$package->id,['class'=>'form-control','id'=>'edit-itinerary-package', 'data-prev'=>$package->id]) !!}
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