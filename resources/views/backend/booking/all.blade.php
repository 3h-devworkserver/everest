@extends ('backend.layouts.master')

@section ('title', trans('menus.booking_management'))

@section('page-header')
    <h1>
        {{ trans('menus.booking_management') }}
        <small>{{ $booking_type }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{{ $booking_type }}</li>
@stop

@section('content')
    {!! $table !!}
    <div class="clearfix"></div>
@stop

