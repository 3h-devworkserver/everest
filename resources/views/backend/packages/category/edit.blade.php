@extends ('backend.layouts.master')

@section ('title', trans('Edit Package Category'))

@section('page-header')
<h1>
	{{ trans('Package Category Management') }}
	<small>{{ trans('menus.packages.category.edit') }}</small>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! link_to_route('admin.packages.index', trans('Package Management')) !!}</li>
<li class="active">{!! trans('Packages Category Edit') !!}</li>
@stop

@section('content')
{!! Form::model($category,['url'=>'admin/packages/category/'.$category->id, 'method' => 'patch', 'id'=>'package-form']) !!}
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
	{!! Form::textarea('description',null,['class'=>'form-control', 'placeholder'=>'Enter Short Description']) !!}
</div>

{!! Form::submit('Save',['class'=>'btn btn-orange']) !!}

</div>
</div>
</div>
</div>

{!! Form::close() !!}

<div class="clearfix"></div>
@endsection