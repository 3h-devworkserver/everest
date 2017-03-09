@extends ('backend.layouts.master')
@section ('title', trans('Ads Management'))
@section('page-header')
<h1>
    {{ trans('Ads Management') }}
</h1>
@endsection
@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">Videos</li>
@stop
@section('content')
<div class="btn-group pull-right addguide">
    
    <a href="{!! url('admin/ads/create') !!}" class="btn btn-default"> {{ trans('Add New Ad') }} </a>
    
</div>
    {!! $table !!}
<div class="clearfix"></div>
@stop