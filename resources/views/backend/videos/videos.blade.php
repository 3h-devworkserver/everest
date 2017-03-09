@extends ('backend.layouts.master')
@section ('title', trans('video management'))
@section('page-header')
<h1>
    {{ trans('Video Management') }}
</h1>
@endsection
@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">Videos</li>
@stop
@section('content')
<div class="btn-group pull-right addguide">
    
    <a href="{!! url('admin/videos/create') !!}" class="btn btn-default"> {{ trans('Add New Video') }} </a>
    
</div>
    {!! $table !!}
<div class="clearfix"></div>
@stop