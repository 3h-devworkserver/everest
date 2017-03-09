@extends ('backend.layouts.master')

@section ('title', trans('menus.page_management'))

@section('page-header')
    <h1>
        {{ trans('menus.page_management') }}
        <small>{{ trans('menus.pages.edit') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.pages.index', trans('menus.page_management')) !!}</li>
    <li class="active">{!! trans('menus.pages.edit') !!}</li>
@stop

@section('content')
    @include('backend.pages.includes.header-buttons')
    {!! form($form) !!}
    @include('backend.includes.tinymce')
   
    <div class="clearfix"></div>
@stop