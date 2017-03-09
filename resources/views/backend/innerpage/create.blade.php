@extends ('backend.layouts.master')

@section ('title', trans('Inner Page Create'))

@section('page-header')
    <h1>
        {{ trans('Inner Page Management') }}
        <small>{{ trans('Inner Page Create') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.innerpages.index', trans('Inner Page Management')) !!}</li>
    <li class="active">{!! trans('Inner Page Create') !!}</li>
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
    </div>
    <div class="page-fields">{!! form_until($form, 'meta_desc') !!}</div>
    <div class="page-fields block-options">
    <!-- <div class="static-block" id="sb"> -->
    <div class="static-block" id="static_block">
        <div id="page_staticblock"></div>
        <div class="loader-overlay" style="display: none;"><div class="custom-loader"></div></div>
        <div class="form-group">
            <button type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only innerpageStaticBlock">Add static block</button>
        </div>  
    </div>
    <!-- </div> -->
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
    });

</script>
@stop