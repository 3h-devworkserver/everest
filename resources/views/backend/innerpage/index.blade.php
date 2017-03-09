@extends ('backend.layouts.master')

@section ('title', trans('Page Management'))

@section('page-header')
    <h1>
        {{ trans('Page Management') }}
        <small>{{ trans('menus.active_innerpages') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! trans('Inner Page Management') !!}</li>
@stop

@section('content')

    {!! $table !!}

    <div class="clearfix"></div>
@endsection

