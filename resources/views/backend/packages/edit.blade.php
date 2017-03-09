@extends ('backend.layouts.master')

@section ('title', trans('Edit Package'))

@section('page-header')
<h1>
	{{ trans('Package Management') }}
	<small>{{ trans('menus.packages.Edit') }}</small>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! link_to_route('admin.packages.index', trans('Package Management')) !!}</li>
<li class="active">{!! trans('Packages Edit') !!}</li>
@stop

@section('content')
<!-- Main content -->



{!! Form::model($package, ['method'=> 'patch', 'url'=>'admin/packages/'.$package->id, 'id'=>'package-form', 'files'=> 'true']) !!}
<div class="row">
	<div class="col-md-9">
		<div class="box">
			<div class="box-body">
				<div class="form-group">
					<label class="control-label">Title</label>
					{!! Form::text('title',null,['class'=>'form-control', 'placeholder'=>'Enter Title']) !!}
				</div>

				<div class="form-group">
					<label class="control-label">Description</label>
					{!! Form::textarea('description',null,['class'=>'form-control', 'placeholder'=>'Enter Description']) !!}
				</div>





			</div>
		</div>

		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Package Details</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div><!-- /.box-tools -->
			</div>
			<div class="box-body">

				<div class="form-group">
					<label class="control-label">Duration <small>(In Days)</small></label>
					{!! Form::input('number', 'duration', null, ['placeholder'=>'Enter Duration in Days', 'class' => 'form-control']) !!}
				</div>

				<div class="form-group">
					<label class="control-label">Trek Period <small>(In Days)</small></label>
					{!! Form::input('number', 'trek_period', null, ['placeholder'=>'Enter Trek Period in Days', 'class' => 'form-control']) !!}
				</div>

				<div class="form-group">
					<label class="control-label">Trek Type</label>
					{!! Form::select('trek_type',['1'=>'Easy', '2'=> 'Moderate'],null,['class'=>'form-control']) !!}
				</div>

				<div class="form-group">
					<label class="control-label">Trek Start & End Point</label>
					{!! Form::text('trek_st_end',null,['class'=>'form-control', 'placeholder'=>'Enter Trek Start & End Point']) !!}
				</div>

				<div class="form-group">
					<label class="control-label">Highest Altitude  <small>(In Meters)</small></label>
					{!! Form::input('number', 'altitude', null, ['placeholder'=>'Enter altitude in Meters', 'class' => 'form-control']) !!}
				</div>

				<div class="form-group">
					<label class="control-label">Warning</label>
					{!! Form::text('warning',null,['class'=>'form-control', 'placeholder'=>'Enter Warning']) !!}
				</div>

				<div class="form-group">
					<label class="control-label">Best Period</label>
					{!! Form::text('best_period',null,['class'=>'form-control', 'placeholder'=>'Enter Best Period']) !!}
				</div>

				<div class="form-group">
					<label class="control-label">Flights</label>
					{!! Form::text('flight',null,['class'=>'form-control', 'placeholder'=>'Enter Flights Information']) !!}
				</div>

				<div class="form-group">
					<label class="control-label">Price Per Person</label>
					{!! Form::input('number', 'price',  null, ['step'=>'any', 'placeholder'=>'Enter Price Per Person', 'class' => 'form-control']) !!}
				</div>
			</div>
		</div>  <!-- box -->


		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Description</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div><!-- /.box-tools -->
			</div>
			<div class="box-body">
				<div class="form-group">
					<label class="control-label">Short Description</label>
					{!! Form::textarea('short_desc',null,['class'=>'form-control', 'placeholder'=>'Enter Short Description']) !!}
				</div>

				<div class="form-group">
					<label class="control-label">Long Description</label>
					{!! Form::textarea('long_desc',null,['class'=>'form-control', 'placeholder'=>'Enter Short Description']) !!}
				</div>
				<div class="form-group">
					<label class="control-label">Short Description <small>(Below Enquiry Button)</small></label>
					{!! Form::textarea('short_desc2',null,['class'=>'form-control', 'placeholder'=>'Enter Short Description']) !!}
				</div>
			</div>
		</div> <!-- /.box -->

		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Map Information</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div><!-- /.box-tools -->
			</div><!-- /.box-header -->

			<div class="box-body">
				<div class="form-group">
					<span class="btn btn-primary btn-file btn-sm">
						<i class="fa fa-folder-open"></i>Upload Map Image
						<input type="file" name="upload-map" class="form-control" onchange="readURLmap(this);" >
					</span>
					<br>
					@if(!empty($package->map_image))
					<div id="map-img-preview" >
						<div style="background-image:url({{url('images/packages-new/maps/'.$package->map_image)}})" alt = "image preview" title="image preview" class="show-img-bg width-50 ">
						</div>
						<a class="btn btn-danger" data-id="{{$package->id}}" id="delete-map-image">Delete Image</a>
					</div>
					<br>
					@endif
					<div id="map-preview" class="show-img-bg width-50 display-none" alt="Image Preview"></div>
				</div>
			</div>

			<div class="box-body">
				<div class="form-group">
					<label class="control-label">Latitude <small>(used only if image is not provided)</small></label>
					{!! Form::text('latitude',null,['class'=>'form-control', 'placeholder'=>'Enter Latitude']) !!}
				</div>
				<div class="form-group">
					<label class="control-label">Longitude <small>(used only if image is not provided)</small></label>
					{!! Form::text('longitude',null,['class'=>'form-control', 'placeholder'=>'Enter Longitude']) !!}
				</div>
				<div class="form-group">
					<label class="control-label">Map Address <small>(used only if image is not provided)</small></label>
					{!! Form::text('map_address',null,['class'=>'form-control', 'placeholder'=>'Enter Map Address']) !!}
				</div>
			</div>

		</div>


	</div> <!-- col -->

	<div class="col-md-3">

		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">Status</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div><!-- /.box-tools -->
			</div><!-- /.box-header -->
			<div class="box-body">
				{!! Form::select('status',['0'=>'Inactive', '1'=> 'Active'],null,['class'=>'form-control']) !!}
			</div><!-- /.box-body -->
		</div><!-- /.box -->


		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">Featured Image</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div><!-- /.box-tools -->
			</div><!-- /.box-header -->
			<div class="box-body">
				<div class="form-group">
					<span class="btn btn-primary btn-file btn-sm">
						<i class="fa fa-folder-open"></i>Upload Featured Image
						<input type="file" name="upload" class="form-control" onchange="readURL(this);" >
					</span>
					<br>
					@if(!empty($package->feat_img))
					<div id="feat-img-preview" >
						<div style="background-image:url({{url('images/packages-new/'.$package->feat_img)}})" alt = "image preview" title="image preview" class="show-img-bg col-md-12 col-xs-6">
						</div>
					</div>
					<br>
					@endif
					<div id="preview" class="show-img-bg col-md-12 col-xs-6 display-none" alt="Image Preview"></div>
				</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->


		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">Category</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div><!-- /.box-tools -->
			</div><!-- /.box-header -->
			<div class="box-body">
				<div class="form-group">
					<ul class="list-unstyled">
						
						<?php 
							$packageCategorys = $package->packageCategory;
						 ?>
						@foreach($categorys as $cat)
							<?php $i = 0; ?>
							@foreach($packageCategorys as $category)
								@if($category->id == $cat->id)
									<li>{!! Form::checkbox('cat[]',$cat->id, 'true') !!} <span>{{$cat->title}}</span></li>
									<?php $i = 1; break; ?>
								@endif
							@endforeach
							@if($i == 0)
								<li>{!! Form::checkbox('cat[]',$cat->id) !!} <span>{{$cat->title}}</span></li>
							@endif
						@endforeach
					</ul>
				</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->

		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">Package Type</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div><!-- /.box-tools -->
			</div><!-- /.box-header -->
			<div class="box-body">
				{!! Form::select('pack_type',['main'=>'Main Package', 'addon'=> 'Addon Package'],null,['class'=>'form-control pack_type']) !!}
			</div><!-- /.box-body -->
		</div><!-- /.box -->

		<div class="box box-default addon-block">
			<div class="box-header with-border">
				<h3 class="box-title">Select Addon Package</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div><!-- /.box-tools -->
			</div><!-- /.box-header -->
			<div class="box-body">
				{!! Form::select('addon_pack[]', $addon, $addonSelected,['class'=>'form-control addon', 'multiple']) !!}
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


@include('backend.includes.tinymce')



<div class="clearfix"></div>

@endsection

