@extends ('backend.layouts.master')
@section ('Settings Management', trans('menus.settings_management'))
@section('page-header')
    <h1>
        {{ trans('menus.settings_management') }}
        
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! trans('menus.settings_management') !!}</li>
@stop
@section('content')
   {!! form_start($form) !!}
   <div class="row">
   {!! form_until($form, 'pinterest') !!}
   <div class="form-group col-md-12 col-sm-12">
   		<img class="uploaded-img"src="{{ asset($setting->logo) }}" width="80px"/>
   				<!-- <div class="logoUpload btn btn-primary">
		    <span>Upload</span>
		    <input id="uploadBtn" type="file" class="upload" name="logo" accept="image/*"/>
		</div> -->

		<div class="logoUpload">
			<input id="uploadLogo" placeholder="Choose Logo" disabled="disabled"/>
			<div class="input-group">
				<div class="input-group-btn">
					<span class="btn btn-primary btn-file">
						<i aria-hidden="true" class="fa fa-cloud-upload"></i>Upload
						<input type="file" accept="image/*" name="logo" class="upload" id="uploadBtn">
					</span>
				</div>
			</div>
		</div>
   {!! form_rest($form) !!}
	</div>
   
    <div class="clearfix"></div>
	</div>

@endsection

@section('after-scripts-end')
	<script>
		$(document).ready(function(){
		    $("#uploadBtn").change(function(){
		     	    var imageName = $(this).val();
		     	    $("#uploadLogo").val(imageName);
		    });
		});
	</script>
@endsection


    

