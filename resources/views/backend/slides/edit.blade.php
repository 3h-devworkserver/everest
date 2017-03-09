@extends ('backend.layouts.master')

@section ('title', trans('menus.slides_management'))

@section('page-header')
<h1>
    {{ trans('menus.slides_management') }}
    <small>Slides Reviews</small>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">Slides Reviews</li>
@stop

@section('content')
<!-- {!! Form::model($slide, ['route' => ['admin.slides.update', $slide->id], 'role' => 'form', 'method' => 'PATCH','files'=>true]) !!}
<div class="thumbnail radioconsistency">
  <a style="background-image:url({{ asset($slide->path) }})"  data-fancybox-group="gallery" title="{{ $slide->caption }} " class="fancybox bg-image"></a>
</div>  
  <div class="form-group browse-btn">
    <span class="btn btn-default btn-file">
        Browse {!! Form::file('image') !!}
    </span> 
  </div>
  <div class="form-group">
      {!! Form::input('textarea', 'caption',null, ['class' => 'form-control', 'id' => 'caption','placeholder' => trans('strings.caption')]) !!}
  </div> 
  {!! Form::hidden('id',$slide->id) !!}
      {!! Form::submit('Submit', array('class'=>'send-btn')) !!}
  {!! Form::close() !!} -->
{!! Form::model($slide, ['route' => ['admin.slides.update', $slide->id], 'role' => 'form', 'class' => 'slider-edit' ,'method' => 'PATCH','files'=>true]) !!}
<div class="row">
    <div class="col-md-4">
        <div class="thumbnail radioconsistency">
            <a style="background-image:url({{ asset($slide->path) }})"  data-fancybox-group="gallery" title="{{ $slide->caption }} " class="fancybox bg-image"></a>
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-group caption">
            {!! Form::input('textarea', 'caption',null, ['class' => 'form-control', 'id' => 'caption','placeholder' => trans('strings.caption')]) !!}
        </div> 
        <div class="form-group link">
            <?php //echo '<pre>'; print_r($inner_pages); ?>

            {!! Form::select('link', $inner_pages_array, $slide->link) !!}
            <strong>Select Page to be linked</strong>
        </div> 

        <!--           <div class="form-group browse-btn">
           Browse {!! Form::file('image') !!}
        </div> -->
        <div class="browse-btn">
            <div class="input-group">
                <span class="input-group-btn">
                    <span class="btn btn-primary btn-file">
                        <i class="fa fa-folder-open" aria-hidden="true"></i>Browse
                        {!! Form::file('image', ['class' => 'file_upload']) !!}
                    </span>
                </span>
                <span class="disp_file_path" style="margin: 15px;"></span>
            </div>
        </div>
        {!! Form::hidden('id',$slide->id) !!}
        {!! Form::submit('Submit', array('class'=>'btn btn-orange')) !!}
    </div>
</div>
{!! Form::close() !!}
<script>
    $('.file_upload').on('change', function ()
    {
        var filePath = $(this).val();
        $('.disp_file_path').html(filePath);
    });
</script>
@stop