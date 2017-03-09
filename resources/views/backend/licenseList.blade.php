@extends ('backend.layouts.master')

@section ('title', 'Unapproved License')

@section('page-header')
    <h1>
        {{ trans('menus.unapproved_license') }}
        <small>List of unapproved license</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! trans('menus.unapproved_license') !!}</li>
@stop

@section('content')
	{!! $table !!}

    <div class="clearfix"></div>
@endsection

