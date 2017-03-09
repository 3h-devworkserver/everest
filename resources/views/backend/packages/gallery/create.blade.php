@extends ('backend.layouts.master')

@section ('title', trans('Create Package Gallery'))

@section('page-header')
<h1>
	{{ trans('Package Gallery Management') }}
	<small>{{ trans('menus.packages.gallery.create') }}</small>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! link_to_route('admin.packages.index', trans('Package Management')) !!}</li>
<li class="active">{!! trans('Packages Gallery Create') !!}</li>
@stop

@section('content')

<style>
	
</style>
<div id="overlay">
	<i class="fa fa-refresh fa-spin loading-icon text-center display-none" ></i>
	{!! Form::open(['url'=>'admin/packages/gallery', 'id'=>'myForm', 'files'=>'true']) !!}

	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-body">

					<div class="form-group">
						<label class="control-label">Gallery Name</label>
						{!! Form::text('name',null,['class'=>'form-control', 'placeholder'=>'Enter Gallery Name']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">Package</label>

						{!! Form::select('package_id',$packages,null,['class'=>'form-control', 'id'=>'gallery-package']) !!}
						<div>
							<span class="msg-package-status text-danger display-none">Selected Package is already in use !!</span>
						</div>

					</div>
				</div>

			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Rotator</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div><!-- /.box-tools -->
				</div><!-- /.box-header -->
				<div class="box-body">

					<div class="form-group">
						<span class="btn btn-primary btn-file btn-sm">
							<i class="fa fa-folder-open"></i>Upload Images
							<input type="file" id="files" name="files[]" multiple>
						</span>
						<div id="selectedFiles" class="row">
							
						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">List</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div><!-- /.box-tools -->
				</div><!-- /.box-header -->
				<div class="box-body">

					<div class="form-group">
						<span class="btn btn-primary btn-file btn-sm">
							<i class="fa fa-folder-open"></i>Upload Images
							<input type="file" id="files2" name="files2[]" multiple>
						</span>
						<div id="selectedFiles2" class="row"></div>
					</div>

				</div>
			</div>
		</div>


	</div>
	{!! Form::submit('Save',['class'=>'test btn btn-orange']) !!}


	{!! Form::close() !!}
</div>
<div class="clearfix"></div>







@endsection