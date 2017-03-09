@extends ('backend.layouts.master')

@section ('title', trans('Ad Management'))

@section('page-header')
<h1>
    {{ trans('Ad Management') }}
    <small>Ads</small>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">Videos</li>
@stop

@section('content')
{!! Form::open(array('url'=>'admin/ads/create','method'=>'POST','class'=>'ads-form', 'files'=>true)) !!} 

<div class="row">
    <div class="col-md-6"> 
        <div class="form-group">
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
            {!! Form::input('text', 'link','', ['class' => 'form-control', 'id' => 'link','placeholder' => 'e.g: http://www.facebook.com']) !!} 
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

