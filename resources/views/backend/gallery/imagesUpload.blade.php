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
{!! Form::open(array('url'=>'admin/slides/create','method'=>'POST','class'=>'slider-form', 'files'=>true)) !!}
<div class="form-group caption">
    {!! Form::input('textarea', 'caption',null, ['class' => 'form-control', 'id' => 'caption','placeholder' => trans('strings.caption')]) !!}
</div> 
<div class="form-group link">
    <?php //echo '<pre>'; print_r($inner_pages); ?>

    {!! Form::select('link', $inner_pages_array) !!}
    <strong>Select Page to be linked</strong>
</div> 
<!-- <div class="form-group browse-btn">
  <span class="btn btn-default btn-file">
      Browse {!! Form::file('image') !!}
  </span>
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

{!! Form::submit('Submit', array('class'=>'btn btn-orange','style' => 'margin-left:0;')) !!}
{!! Form::close() !!}

<script>
    $('.file_upload').on('change', function ()
    {
        var filePath = $(this).val();
        $('.disp_file_path').html(filePath);
    });
</script>
@stop

