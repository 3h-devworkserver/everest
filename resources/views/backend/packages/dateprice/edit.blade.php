@extends ('backend.layouts.master')

@section ('title', trans('Edit Package Dates & Prices'))

@section('page-header')
<h1>
	{{ trans('Package Dates & Prices Management') }}
	<small>{{ trans('menus.packages.datesprices.edit') }}</small>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! link_to_route('admin.packages.index', trans('Package Management')) !!}</li>
<li class="active">{!! trans('Package Dates & Prices Edit') !!}</li>
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
		<div class="form-group row">
						<label class="control-label col-md-12">Trip Status</label>
						<div class="col-md-9">
						{!! Form::select('status[]',['Available'=>'Available','Limited Availability'=>'Limited Availability', 'Already Booked'=> 'Already Booked'],null,['class'=>'form-control']) !!}
						</div>
						<div class="col-md-3">
							<a class="btn btn-danger remove">Remove Date & Price</a>
						</div>
					</div>
	</div>
	
</div>
<div id="overlay">
	<i class="fa fa-refresh fa-spin loading-icon text-center display-none" ></i>
	{!! Form::model($package, ['url'=>'admin/packages/datesprices/'.$package->id, 'method'=>'patch', 'id'=>'package-form', 'class'=>'dateprice-form']) !!}

	<div class="row">
		<div class="col-md-9">
			<div class="box">
				<div class="box-body">
					<div class="form-group">
						<label class="control-label">Description</label>
						{!! Form::textarea('description',$package->datesPrices[0]->description,['class'=>'form-control', 'placeholder'=>'Enter Content']) !!}
					</div>
				</div>
			</div>

			<div class="box">
				<div class="box-body">
						@if((count($package->datesPrices)) > 0)
				<div class="block-dateprice">
					<div class="form-group">
						<label class="control-label">Dates Range</label>
						{!!Form::text('daterange[]',$package->datesPrices[0]->daterange,['class'=>'form-control daterange', 'placeholder'=> 'Enter Date'])!!}
					</div>
					<div class="form-group">
					<label class="control-label">Short Description <small>(Optional)</small></label>
					{!!Form::textarea('short_description[]',$package->datesPrices[0]->short_description,['class'=>'form-control', 'rows'=>'2', 'placeholder'=> 'Enter Short Description'])!!}
				</div>
					<div class="form-group">
						<label class="control-label">Price</label>
						{!! Form::input('number', 'price[]', $package->datesPrices[0]->price, ['step'=>'any', 'placeholder'=>'Enter Price', 'class' => 'form-control']) !!}
					</div>
					<div class="form-group row">
						<label class="control-label col-md-12">Trip Status</label>
						<div class="col-md-9">
						{!! Form::select('status[]',['Available'=>'Available','Limited Availability'=>'Limited Availability', 'Already Booked'=> 'Already Booked'],$package->datesPrices[0]->status,['class'=>'form-control']) !!}
						</div>
						<div class="col-md-3">
							<a class="btn btn-danger remove-dateprice">Remove Date & Price</a>
						</div>
					</div>
					</div>
					@endif

					<div id = "add-xtra-dateprice">

						<?php $i=0; ?>
						@foreach($package->datesPrices as $datePrice)
						@if($i != 0)
						<div class="block-dateprice">
							<hr>
							<div class="form-group">
								<label class="control-label">Dates Range</label>
								{!!Form::text('daterange[]',$datePrice->daterange,['class'=>'form-control daterange', 'placeholder'=> 'Enter Date'])!!}
							</div>
							<div class="form-group">
					<label class="control-label">Short Description <small>(Optional)</small></label>
					{!!Form::textarea('short_description[]',$datePrice->short_description,['class'=>'form-control', 'rows'=>'2', 'placeholder'=> 'Enter Short Description'])!!}
				</div>
							<div class="form-group">
								<label class="control-label">Price</label>
								{!! Form::input('number', 'price[]', $datePrice->price, ['step'=>'any', 'placeholder'=>'Enter Price', 'class' => 'form-control']) !!}
							</div>
							<div class="form-group row">
						<label class="control-label col-md-12">Trip Status</label>
						<div class="col-md-9">
						{!! Form::select('status[]',['Available'=>'Available','Limited Availability'=>'Limited Availability', 'Already Booked'=> 'Already Booked'],$datePrice->status,['class'=>'form-control']) !!}
						</div>
						<div class="col-md-3">
							<a class="btn btn-danger remove-dateprice">Remove Date & Price</a>
						</div>
					</div>
						</div>
						@endif
						<?php $i++; ?>
						@endforeach
					</div>

					<a class="btn btn-warning btn-add-dateprice">Add DatePrice </a>
					{{-- <a class="btn btn-danger btn-remove-dateprice">Remove DatePrice </a> --}}

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
					{!! Form::select('package_id',$packages ,$package->id,['id'=>'edit-dateprice-package', 'data-prev'=>$package->id, 'class'=>'form-control']) !!}
					<div>
				</div>
						<span class="msg-package-status text-danger display-none">Selected Package is already in use !!</span>
					</div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->


		</div>
	</div>
	<div class="row">
		<div class="col-md-offset-9 col-md-3">
			{!! Form::submit('Save',['class'=>'btn btn-orange']) !!}
		</div>

	</div>
	{!! Form::close() !!}
</div>
@include('backend.includes.tinymce')
<div class="clearfix"></div>
@endsection



