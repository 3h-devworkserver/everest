@extends ('backend.layouts.master')

@section ('title', trans('summitteer'))

@section('page-header')
    <h1>
        {{ trans('Summitteer') }}
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
@stop

@section('content')
    {!! form($form) !!}
@stop