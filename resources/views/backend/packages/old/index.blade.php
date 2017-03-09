@extends ('backend.layouts.master')

@section ('title', trans('Package Management'))

@section('page-header')
    <h1>
        {{ trans('Package Management') }}
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! trans('Packagement') !!}</li>
@stop

@section('content')

    {!! $table !!}
    <div class="clearfix"></div>
@endsection

