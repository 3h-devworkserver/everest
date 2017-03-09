@extends ('backend.layouts.master')

@section ('title', trans('Edit Package'))

@section('page-header')
<h1>
    {{ trans('Package Management') }}
    <small>{{ trans('menus.packages.edit') }}</small>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! link_to_route('admin.packages.index', trans('Package Management')) !!}</li>
<li class="active">{!! trans('Packages Edit') !!}</li>
@stop

@section('content')
{!! form_start($form) !!}
<div id="default_fields">
    <div class="page-fields">
        {!! form_until($form, 'price') !!}
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
    </div>
    <div class="page-fields" id="block_option">{!! form_until($form, 'select_field') !!}</div>
</div>
<div class="static" id="static_block">
    <div id="added_blocks">
        @foreach($static as $key => $sdata)
        <?php //echo '<pre>';print_r($sdata);?>

        <div class="addmore-html">
            <input type="hidden" name="counter[]" value="1">
            <input type="hidden" id="uniqueId" name="uniqueId[]" value="{{$sdata->uniqueid}}">
            <h4>Create Static Block</h4>
            <div class="form-group">
                <label for="stitle" class="control-label">Title</label>
                <input class="form-control" name="stitle[]" type="text" id="stitle" value="{{$sdata->title}}">
            </div>
            <div class="form-group">
                <label for="scontent" class="control-label">Content</label>
                <textarea class="form-control scontent" name="scontent[]" id="statcontent" aria-hidden="true">{{$sdata->content}}</textarea>
            </div>
            <div class="form-group">
                <label for="surl" class="control-label">URL</label>
                <input class="form-control" name="surl[]" type="url" id="surl" value="{{$sdata->url}}">   
            </div>
            <div class="form-group static-image">

                <label for="simage" class="control-label">Image File</label>
                <div class="browse-btn">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <span class="btn btn-primary btn-file">
                                <i aria-hidden="true" class="fa fa-folder-open"></i>Browse
                                <input type="file" name="simage[]" id="simage">
                            </span>
                        </span>                
                    </div>
                </div>
                @if(!empty($sdata->image))
                <div class="preview bg-image" style="background-image:url({{ asset('/images/staticimages/'.$sdata->image) }})" ></div>
                @endif
            </div>
            <a href="{{url().'/admin/static/'.$sdata->id.'/delete'}}" class="delete-btn" id="{{$sdata->id}}">Delete static block</a>
        </div>

        @endforeach
        <!-- <div class="addmore-html">
    <input type="hidden" name="counter[]" value="1">
    <input type="hidden" name="uniqueId[]" value="1">
    <h4>Create Static Block</h4>
    <div class="form-group">
        <label for="stitle" class="control-label">Title</label>
        <input class="form-control" name="stitle[]" type="text" id="stitle">
    </div>
    <div class="form-group">
        <label for="scontent" class="control-label">Content</label>
       <textarea class="form-control scontent" name="scontent[]" id="statcontent" aria-hidden="true"></textarea>
    </div>
    <div class="form-group">
        <label for="surl" class="control-label">URL</label>
        <input class="form-control" name="surl[]" type="url" id="surl">   
    </div>
    <div class="form-group static-image">
        <label for="simage" class="control-label">Image</label>
        <input name="simage[]" type="file" id="simage">
    </div>
</div> -->

    </div>
    <div class="loader-overlay" style="display: none;"><div class="custom-loader"></div></div>
    <div class="form-group">
        <button type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only add-static" id="addTr">Add more static block</button>
    </div>  
</div>
@if(!empty($gallery))
<div class="static" id="gallery">
    <h4>Gallary</h4>
    <!-- <input id="galleryupload" type="file" name="files" multiple data-url="{{url().'/admin/packages'}}" data-sequential-uploads="true" data-form-data='{"script": "true"}' accept="image/*"> -->
    @foreach($gallery as $galleryId)
    <input type="hidden" name="galleryId[]" value="{{$galleryId->id}}">
    <!-- <img src="{{url().'/images/packages/'.$galleryId->image}}"> -->
    @endforeach
    <div class="form-group">
        <div id="imgpreview"></div>
    </div>
    <div class="form-group">
        <input id="galleryupload" class="galleryupload" type="file" name="gallery[]" multiple accept="image/*">            
    </div>
    <!--  <div class="form-group">
        <label for="caption" class="control-label">Caption</label>
        <input class="form-control" type="text" id="caption" name="caption">
    </div> -->
</div>
@endif
<div class="static" id="video">
    <div class="form-group">
        <label id="videoupload" class="control-label">Video</label>
        <input id="videoupload" type="file" name="video">
    </div>
</div>
{!! form_end($form) !!}
@include('backend.includes.tinymce')


<div class="clearfix"></div>
<script>
    $('.file_upload').on('change', function ()
    {
        var filePath = $(this).val();
        $('.disp_file_path').html(filePath);
    });
</script>
@stop