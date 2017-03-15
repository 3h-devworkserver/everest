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
 <div class="select-options">
        <div class="btn-group">
          <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              {{ trans('Customers') }} <span class="caret"></span>
          </button>
          <ul class="dropdown-menu pull-right" role="menu">
            <li><a href="{{route('admin.customers.index')}}">{{ trans('All Customers') }}</a></li>

            {{-- <li><a href="{{route('admin.customers.registered')}}">{{ trans('Registered') }}</a></li> --}}
            <li><a href="#">{{ trans('Registered') }}</a></li>
            
          </ul>
        </div>    
    </div>

    <div class="clearfix"></div>

{!! $table !!}

<div class="clearfix"></div>
@endsection