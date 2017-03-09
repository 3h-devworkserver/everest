@extends ('backend.layouts.master')

@section ('title', trans('Create Package Option'))

@section('page-header')
<h1>
	{{ trans('Package Option Management') }}
	<small>{{ trans('menus.packages.options.create') }}</small>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! link_to_route('admin.packages.index', trans('Package Management')) !!}</li>
<li class="active">{!! trans('Packages Option Create') !!}</li>
@stop

@section('content')
{!! Form::open(['url'=>'admin/packages/options', 'id'=>'package-form']) !!}

<div class="row">
	<div class="col-md-9">
		<div class="box">
			<div class="box-body">

				<div class="form-group">
					<label class="control-label">Name</label>
					{!! Form::text('name',null,['class'=>'form-control', 'placeholder'=>'Enter Name']) !!}
				</div>


				<div class="form-group">
					<label class="control-label">Type Name</label>
					{!! Form::text('type_name',null,['class'=>'form-control', 'placeholder'=>'Enter Type Name']) !!}
				</div>

<?php /* ?>
<div class="form-group designation display-none">
	<label class="control-label">Designation</label>
	{!! Form::text('designation',null,['class'=>'form-control', 'placeholder'=>'Enter Designation']) !!}
</div>
<?php */ ?>

<div class="form-group">
	<label class="control-label">Content</label>
	{!! Form::textarea('content',null,['class'=>'form-control', 'placeholder'=>'Enter Content']) !!}
</div>

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
			{!! Form::select('package_id',$packages ,null,['class'=>'form-control']) !!}
		</div><!-- /.box-body -->
	</div><!-- /.box -->

<?php /* ?>
	<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">Type</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div><!-- /.box-tools -->
			</div><!-- /.box-header -->
			<div class="box-body">
				{!! Form::select('type',['accomodation'=>'First Block', 'expert'=> 'Second Block'],null,['class'=>'form-control option-type']) !!}
			</div><!-- /.box-body -->
		</div><!-- /.box -->
		<?php */ ?>

	</div>
</div>
<div class="row">
	<div class="col-md-offset-9 col-md-3">
		{!! Form::submit('Save',['class'=>'btn btn-orange']) !!}
	</div>
	
</div>
{!! Form::close() !!}
@include('backend.includes.tinymce')
<div class="clearfix"></div>
@endsection