@extends ('backend.layouts.master')

@section ('title', trans('Package Category Management'))

@section('page-header')
<h1>
	{{ trans('Package Category Management') }}
	<small>{{ trans('menus.packages.category.create') }}</small>
	<a href="{{url('admin/packages/category/create')}}" class="btn btn-info left-spacer">Create Category</a>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! link_to_route('admin.packages.index', trans('Package Management')) !!}</li>
<li class="active">{!! trans('Packages Category') !!}</li>
@stop

@section('content')
{!! $table !!}

<div class="clearfix"></div>
@endsection