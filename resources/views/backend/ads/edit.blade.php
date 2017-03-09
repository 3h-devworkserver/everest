@extends ('backend.layouts.master')

@section ('title', trans('Ad Management'))

@section('page-header')
<h1>
    {{ trans('Ad Management') }}
    <small>Video</small>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">Ad</li>
@stop

@section('content')
{!! Form::model($ad, ['route' => ['admin.ads.update', $ad->id], 'role' => 'form', 'class' => 'ad-edit' ,'method' => 'PATCH','files'=>true]) !!}
<div class="row">
    <div class="col-md-6">
        <strong>Ad Image</strong>
        <div class="thumbnail" style="margin:20px;">
            <img src="<?php echo url() . '/images/' . $ad->ads; ?>" width ="50%" />
        </div>
        <div class="browse-btn">
            <div class="input-group">
                <span class="input-group-btn">
                    <span class="btn btn-primary btn-file">
                        <i class="fa fa-folder-open" aria-hidden="true"></i>Browse
                        {!! Form::file('ads', ['class' => 'file_upload']) !!}
                    </span>
                </span>
                <span id="disp_file_path" style="margin: 15px;"></span>
            </div>
        </div>
        
        {!! Form::input('text', 'link',$ad->link, ['class' => 'form-control', 'id' => 'link','placeholder' => 'e.g: http://www.facebook.com']) !!}  

    </div>
    <div class="col-md-6">
        <ul class="page-list">
            @foreach($pages as $page)
            <li>
                <input name="page[]" type="checkbox" value="{{$page->id}}" <?php
                $pages_id = explode(',', $ad->pages_id);
                foreach ($pages_id as $key => $value)
                    if ($page->id == $value)
                        echo 'checked';
                ?> id="{{$page->id}}" >
                <label for="{{$page->id}}">{{$page->title}}</label>
            </li>
            @endforeach
        </ul>
    </div>

</div>
{!! Form::submit('Submit', array('class'=>'btn btn-orange','style' => 'margin-left:0;')) !!}
{!! Form::close() !!}


<script type="text/javascript">

     $(function()
    {
        $('.file_upload').on('change',function ()
        {
            var filePath = $(this).val();
            $('#disp_file_path').html(filePath);
        });
    });

</script>

@stop