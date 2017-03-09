@extends ('backend.layouts.master')

@section ('title', trans('summitteer management'))

@section('page-header')
    <h1>
        {{ trans('Summitteer Management') }}
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! trans('Summitteer') !!}</li>
@stop

@section('content')

    {!! $table !!}

    <div class="clearfix"></div>
@endsection

