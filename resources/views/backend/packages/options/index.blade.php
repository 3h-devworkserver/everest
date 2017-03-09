@extends ('backend.layouts.master')

@section ('title', trans('Package Option Management'))

@section('page-header')
<h1>
	{{ trans('Package Option Management') }}
	<small>{{ trans('menus.packages.option.create') }}</small>
	<a href="{{url('admin/packages/options/create')}}" class="btn btn-info left-spacer">Create Option</a>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! link_to_route('admin.packages.index', trans('Package Management')) !!}</li>
<li class="active">{!! trans('Packages Option') !!}</li>
@stop

@section('content')
{!! $table !!}

<div class="clearfix"></div>
@endsection