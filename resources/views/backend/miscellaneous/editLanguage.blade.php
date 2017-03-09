@extends ('backend.layouts.master')

@section ('title', trans('menus.lanugage_management'))

@section('page-header')
    <h1>
        {{ trans('menus.lanugage_management') }}
        <small>Language Reviews</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">Language Reviews</li>
@stop

@section('content')
    {!! Form::model($language, ['route' => ['admin.language.update', $language->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH','files'=>true]) !!}
      <div class="form-group">
          {!! Form::input('text', 'language',null, ['class' => 'form-control', 'id' => 'caption','placeholder' => trans('strings.addlanguage')]) !!}
      </div> 
          {!! Form::submit('Submit', array('class'=>'send-btn')) !!}
      {!! Form::close() !!}
@stop

