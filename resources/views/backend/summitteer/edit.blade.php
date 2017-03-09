@extends ('backend.layouts.master')

@section ('title', trans('Edit Summitteer'))

@section('page-header')
    <h1>
        {{ trans('Summitteer') }}
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
@stop

@section('content')
{!! form($form) !!}
    <div class="clearfix"></div>
@stop