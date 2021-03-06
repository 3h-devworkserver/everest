@extends ('backend.layouts.master')

@section ('title', trans('Customer Management'))

@section('page-header')
<h1>
	{{ trans('Customer Management') }}
	<small>{{ trans('menus.customer.create') }}</small>
	<a href="{{url('admin/customers/create')}}" class="btn btn-info left-spacer">Create Customer</a>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! link_to_route('admin.customers.index', trans('Customer Management')) !!}</li>
{{-- <li class="active">{!! trans('Packages Category') !!}</li> --}}
@stop

@section('content')
    <div class="clearfix"></div>

{!! $table !!}

<div class="clearfix"></div>
@endsection