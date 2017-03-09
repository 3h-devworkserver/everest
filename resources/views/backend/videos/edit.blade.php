@extends ('backend.layouts.master')

@section ('title', trans('video management'))

@section('page-header')
    <h1>
        {{ trans('Video Management') }}
        <small>Video</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">Video</li>
@stop

@section('content')
      {!! Form::model($video, ['route' => ['admin.videos.update', $video->id], 'role' => 'form', 'class' => 'video-edit' ,'method' => 'PATCH','files'=>true]) !!}
      <div class="row">
        <div class="col-md-6">
   
          {!! Form::input('text', 'url',$video->video, ['class' => 'form-control', 'id' => 'url','placeholder' => 'https://vimeo.com/67992157']) !!}  
          <div class="thumbnail">
              <?php
              $link = parse_vimeo($video->video);
        $video_link = "http://player.vimeo.com/video/" . $link;
              ?>
            <iframe src="{{$video_link}}"></iframe>
          </div>
        </div>
        <div class="col-md-6">
          <ul class="page-list">
          @foreach($pages as $page)
          <li>
          <input name="page[]" type="checkbox" value="{{$page->id}}" <?php $pages_id = explode(',', $video->pages_id); foreach ($pages_id as $key => $value)if($page->id == $value) echo 'checked';?> id="{{$page->id}}" >
          <label for="{{$page->id}}">{{$page->title}}</label>
          </li>
          @endforeach
          </ul>
        </div>
        
      </div>
      {!! Form::submit('Submit', array('class'=>'btn btn-orange','style' => 'margin-left:0;')) !!}
      {!! Form::close() !!}
@stop