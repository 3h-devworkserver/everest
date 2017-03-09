@extends ('backend.layouts.master')

@section ('title', trans('Edit Package Gallery'))

@section('page-header')
<h1>
	{{ trans('Package Gallery Management') }}
	<small>{{ trans('menus.packages.gallery.edit') }}</small>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! link_to_route('admin.packages.index', trans('Package Management')) !!}</li>
<li class="active">{!! trans('Packages Gallery Edit') !!}</li>
@stop

@section('content')

<div id="overlay">
<i class="fa fa-refresh fa-spin loading-icon text-center" style="display:none;"></i>

{!! Form::model($package, ['url'=>'admin/packages/gallery/'.$package->id,'method'=>'patch', 'id'=>'myForm', 'files'=>'true']) !!}

<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-body">

			<div class="form-group">
						<label class="control-label">Gallery Name</label>
						{!! Form::text('name',$package->galleryRotators[0]->name,['class'=>'form-control', 'placeholder'=>'Enter Gallery Name']) !!}
					</div>

				<div class="form-group">
					<label class="control-label">Package</label>

					{!! Form::select('package_id',$packages,$package->id,['class'=>'form-control', 'id'=> 'edit-gallery-package', 'data-prev'=>$package->id ]) !!}
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
					@if(!empty($package))
						<h4>Previous Images</h4>
					<div id="dbFiles" class="row dbFiles">
						@foreach($package->galleryRotators as $rotator)
						<div class="parent-image col-md-6 col-sm-6 margin-btm2"> 
							{{-- <br> --}}
							
							
								<div class="show-img-bg2" style="background-image: url({{asset('/images/packages-new/rotator/'.$rotator->image)}})"></div>
								<button class="btn btn-danger gallery-image" data-id="{{$rotator->id}}"><span class="glyphicon glyphicon-trash"></span></button>
							
							@if($rotator->default == 1)
							{!! Form::radio('default', $rotator->image, true) !!}Set Default Image
							@else
							{!! Form::radio('default', $rotator->image) !!}Set Default Image
							@endif
						</div>
						@endforeach
					</div>
					@endif
					{{-- <br> --}}
					<hr>
					<div id="selectedFiles">
					</div>
					<div class="col-md-12">
					<span class="btn btn-primary btn-file btn-sm">
						<i class="fa fa-folder-open"></i>Upload Images
						<input type="file" id="files" name="files[]" multiple>
					</span>
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
					@if(!empty($package))
						<h4>Previous Images</h4>
					<div id="dbFiles2" class="row dbFiles">
						@foreach($package->galleryLists as $list)
						<div class="parent-image col-md-6 col-sm-6 margin-btm2"> 
							{{-- <br> --}}
							
								<div class="show-img-bg2" style="background-image: url({{asset('/images/packages-new/gallerylist/'.$list->image)}})"></div>
								<button class="btn btn-danger gallery-image"  data-id="{{$list->id}}"><span class="glyphicon glyphicon-trash"></span></button>
						</div>
						@endforeach
					</div>
					@endif
					{{-- <br> --}}
					<hr>
					<div id="selectedFiles2">
					</div>
					<div class="col-md-12">
					<span class="btn btn-primary btn-file btn-sm">
						<i class="fa fa-folder-open"></i>Upload Images
						<input type="file" id="files2" name="files2[]" multiple>
					</span>
					</div>
					

					
				</div>
				



			</div>
		</div>
	</div>


</div>
{!! Form::submit('Save',['class'=>'test btn btn-orange']) !!}


{!! Form::close() !!}
</div>
<div class="clearfix"></div>


{{-- <div class="form-group">
					<span class="btn btn-primary btn-file btn-sm">
						<i class="fa fa-folder-open"></i>Upload Images
						<input type="file" id="files2" name="files2[]" multiple>
					</span>
					@if(!empty($package))
					<div id="dbFiles2">
						@foreach($package->galleryLists as $list)
							{{$list->image}}
						@endforeach
					</div>
					@endif
					<div id="selectedFiles2"></div>
				</div>

				--}}



				@endsection