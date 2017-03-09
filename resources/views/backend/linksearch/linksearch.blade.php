@extends ('backend.layouts.master')
@section ('title', trans('Search Link Management'))
@section('page-header')
<h1>
    {{ trans('Search Link Management') }}
</h1>
@endsection
@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">Search Link</li>
@stop
@section('content')
<div class="btn-group pull-right addguide">
    
    <a href="{!! url('admin/linksearch/create') !!}" class="btn btn-default"> {{ trans('Add New Search Link') }} </a>
    
</div>
    {!! $table !!}
<div class="clearfix"></div>
@stop