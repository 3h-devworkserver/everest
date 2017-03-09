@extends ('backend.layouts.master')

@section ('title', trans('Search Link Management'))

@section('page-header')
<h1>
    {{ trans('Search Link Management') }}
    <small>Search Link</small>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">Search Link</li>
@stop

@section('content')
{!! Form::open(array('url'=>'admin/linksearch/create','method'=>'POST','class'=>'linksearch-form', 'files'=>true)) !!} 

<div class="row">
    <div class="col-md-6"> 
        <div class="form-group">
            <label>Keyword</label>
            {!! Form::input('text', 'keyword','', ['class' => 'form-control', 'id' => 'keyword','placeholder' => 'e.g: everest,annapurna']) !!} 
        </div>
        <div class="form-group">
            <label>URL</label>
            {!! Form::input('text', 'url','', ['class' => 'form-control', 'id' => 'url','placeholder' => 'e.g: http://www.facebook.com']) !!} 
        </div>
    </div>
</div>
{!! Form::submit('Submit', array('class'=>'btn btn-orange','style' => 'margin-left:0;')) !!}
{!! Form::close() !!}

@stop

