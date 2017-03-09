@extends ('backend.layouts.master')

@section ('title', trans('menus create'))

@section('page-header')
    <h1>
        {{ trans('Menu Management') }}
    </h1>
@endsection
@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.menus.index', trans('Menu Management')) !!}</li>
    <li class="active">{!! trans('Create Menu') !!}</li>
@stop

@section('content')
  <div class="row">
    <div class="col-md-8">  
      <div class="well">
        <p class="lead"><a href="{{ url('admin/menus')}}" class="btn btn-default pull-right">Go Back</a> Menu</p>
		
		{!! Form::model($item, array('url' => "admin/menus/edit/{$item->id}", 'class' => 'form-horizontal')) !!}
		<div class="form-group">
		    <label for="title" class="col-lg-2 control-label">Title</label>
		    <div class="col-lg-10">
		      {!! Form::text('title',null,array('class'=>'form-control')) !!}
		    </div>
		</div>
		<div class="form-group">
		    <label for="label" class="col-lg-2 control-label">Label</label>
		    <div class="col-lg-10">
		      {!! Form::text('label',null,array('class'=>'form-control')) !!}
		    </div>
		</div>
		<div class="form-group">
		    <label for="url" class="col-lg-2 control-label">URL</label>
		    <div class="col-lg-10">
		      {!! Form::text('url',null,array('class'=>'form-control')) !!}
		    </div>
		</div>
		<div class="form-group">
		    <div class="col-md-6 col-md-offset-6 text-right">
		      <button type="submit" class="btn btn-lg btn-default">Update item</button>
		    </div>
		</div>
		{!! Form::close() !!}
      </div>
    </div>
    
  </div>
@stop

