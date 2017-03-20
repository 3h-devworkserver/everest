@extends ('backend.layouts.master')

@section ('title', trans('Purchase Order Summary'))

@section('page-header')
<h1>
	{{ trans('Purchase Order Summary') }}
	<small>{{ trans('menus.customer.create') }}</small>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! link_to_route('admin.customers.index', trans('Purchase Order Summary')) !!}</li>
{{-- <li class="active">{!! trans('Packages Category') !!}</li> --}}
@stop

@section('content')

    <div class="clearfix"></div>

{!! $table !!}

<div class="clearfix"></div>
@endsection