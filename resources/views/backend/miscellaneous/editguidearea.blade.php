@extends ('backend.layouts.master')

@section ('title', trans('menus.guidearea_management'))

@section('page-header')
    <h1>
        {{ trans('menus.addguide_area') }}
        <small>Guide Area Reviews</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">Guide Area Reviews</li>
@stop

@section('content')
    {!! Form::model($guidearea, ['route' => ['admin.guidearea.update', $guidearea->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH','files'=>true]) !!}
      <div class="form-group">
          {!! Form::input('text', 'guide_area',null, ['class' => 'form-control', 'id' => 'caption','placeholder' => trans('strings.addguide')]) !!}
      </div> 
          {!! Form::submit('Submit', array('class'=>'send-btn')) !!}
      {!! Form::close() !!}
@stop

