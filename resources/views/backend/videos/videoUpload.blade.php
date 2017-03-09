@extends ('backend.layouts.master')

@section ('title', trans('video management'))

@section('page-header')
    <h1>
        {{ trans('Video Management') }}
        <small>Videos</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">Videos</li>
@stop

@section('content')
    {!! Form::open(array('url'=>'admin/videos/create','method'=>'POST','class'=>'video-form', 'files'=>true)) !!} 
      <!-- <div class="browse-btn">
        <div class="input-group">
          <span class="input-group-btn">
            <span class="btn btn-primary btn-file" id="">
              <i class="fa fa-folder-open" aria-hidden="true"></i>Browse
               <input id="p_videoUpload" type="file" name="video">
            </span>
          </span>
        </div>
          </div> -->
          <div class="row">
            <div class="col-md-6"> 
              <div class="form-group">
                <label>Embed Your Video From Youtube</label>
                {!! Form::input('text', 'url',null, ['class' => 'form-control', 'id' => 'url','placeholder' => trans('validation.attributes.youtubeUrl'), 'required']) !!}
              </div>
            </div>
            <div class="col-md-6">
            <ul class="page-list">
          @foreach($pages as $page)
          <li>
          <input name="page[]" type="checkbox" value="{{$page->id}}" id="{{$page->id}}">
          <label for="{{$page->id}}">{{$page->title}}</label>
          </li>
          @endforeach
          </ul> 
            </div>
          </div>
        {!! Form::submit('Submit', array('class'=>'btn btn-orange','style' => 'margin-left:0;')) !!}
      {!! Form::close() !!}
@stop

