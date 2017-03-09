@extends ('backend.layouts.master')

@section ('title', trans('Inner Page Edit'))

@section('page-header')
<h1>
    {{ trans('Inner Page Management') }}
    <small>{{ trans('Inner Page Edit') }}</small>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! link_to_route('admin.innerpages.index', trans('Inner Page Management')) !!}</li>
<li class="active">{!! trans('Inner Page Edit') !!}</li>
@stop

@section('content')

{!! form_start($form) !!}
<div class="page-fields">
    {!! form_until($form, 'content') !!}
    <div class="browse-btn">
        <div class="input-group">
            <span class="input-group-btn">
                <span class="btn btn-primary btn-file">
                    <i class="fa fa-folder-open" aria-hidden="true"></i>Browse
                    {!! Form::file('blockPic', ['class' => 'file_upload']) !!}
                </span>
            </span>
             <span id="disp_file_path" style="margin: 15px;"></span>
        </div>
    </div>
    @if(!empty($innerpage->image))
    <div class="preview bg-image" style="background-image:url({{ asset('/images/'.$innerpage->image) }})" ></div>
    @endif
</div>
<div class="page-fields">{!! form_until($form, 'meta_desc') !!}</div>

<div class="page-fields block-options">
    <h2>Static Blocks</h2>
    @if(!empty($static))
    <div class="static-block" id="static_block">
        <div id="page_staticblock">
            @foreach($static as $key => $sdata)
            <?php //echo '<pre>';print_r($sdata);?>

            <div class="addmore-html">
                <input type="hidden" name="counter[]" value="1">
                <input type="hidden" id="uniqueId" name="uniqueId[]" value="{{$sdata->uniqueid}}">
                <div class="form-group">
                    <label for="sposition" class="control-label">Section Position</label>
                    <select name="sposition[]" id="sposition" class="form-control" style="width:100px;">                        
                        <option value="top" {{ ($sdata->position=='top' || $sdata->position == '') ? 'selected' : "" }}>Top</option>
                        <option value="bottom" {{ $sdata->position=='bottom' ? 'selected' : "" }}>Bottom</option>
                    </select>
                </div>

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
                    <input class="form-control" name="surl[]" type="text" id="surl" value="{{$sdata->url}}">   
                </div>

                <div class="form-group static-image">
                    <!-- <label for="simage" class="control-label">Image File</label> -->
                    <div class="browse-btn">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-primary btn-file">
                                    <i aria-hidden="true" class="fa fa-folder-open"></i>Browse
                                    <input type="file" name="simage[]" id="simage" class="simage">
                                </span>
                                
                            </span>
                            <span class="disp_file_path_static" style="margin: 15px;"></span>
                        </div>
                    </div>
                    @if(!empty($sdata->image))
                    <div class="preview bg-image" style="background-image:url({{ asset('/images/staticimages/'.$sdata->image) }})" ></div>
                    @endif
                </div>
                <a href="{{url().'/admin/static/'.$sdata->id.'/delete'}}" class="btn btn-danger" id="{{$sdata->id}}">Delete static block</a>
            </div>

            @endforeach
        </div>
        <div class="loader-overlay" style="display: none;"><div class="custom-loader"></div></div>

        <div class="form-group">
            <button type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only innerpageStaticBlock">Add static block</button>
        </div>  
    </div>
    @else
    <div class="static-block" id="static_block">
        <div id="page_staticblock"></div>
        <div class="loader-overlay" style="display: none;"><div class="custom-loader"></div></div>
        <div class="form-group">
            <button type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only innerpageStaticBlock">Add static block</button>
        </div>  
    </div>
    @endif
</div>      


{!! form_rest($form) !!}
@include('backend.includes.tinymce')

<div class="clearfix"></div>
<script type="text/javascript">

     $(function()
    {
        $('.file_upload').on('change',function ()
        {
            var filePath = $(this).val();
            $('#disp_file_path').html(filePath);
        });
        
        $('.simage').on('change',function ()
        {            
            var filePath = $(this).val();
            $(this).parents('.browse-btn').find('.disp_file_path_static').html(filePath);
        });
    });

</script>
@stop