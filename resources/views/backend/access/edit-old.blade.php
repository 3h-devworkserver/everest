@extends ('backend.layouts.master')
@section ('title', trans('menus.user_management') . ' | ' . trans('menus.user_profile'))
@section('page-header')
<h1>
{{ trans('menus.user_profile') }}
</h1>
@endsection
@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! trans('menus.user_profile') !!}</li>
@stop
@section('content')
<script type="text/javascript">
          $(document).ready(function(){
            $("select.chosen-selectmain").chosen();
                    });
</script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script type=text/javascript>
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
 </script>
      <script type="text/javascript">
       $(document).ready(function() {

        var config = "{{$availibility}}";
        console.log(config);
        if (config != '') {
          console.log(config);
          var allBookeddates = config.split(",");
          $('#simpliest-usage').multiDatesPicker
          ({
            //format: 'yyyy-mm-dd',
            minDate: 0,
            addDates: allBookeddates,
            });
                      
            }
            else {
            console.log("no data");
              $('#simpliest-usage').multiDatesPicker
                      ({
                        //format: 'yyyy-mm-dd',
                        minDate: 0,
                        addDates: allBookeddates,
                        
            });
            }
        
        $('.demo .code').each(function() {

          eval($(this).attr('title','NEW: edit this code and test it!').text());
        })
      });
    </script>

<div class="row">
  <div class="col-md-3">
    <!-- Profile Image -->
    <div class="box box-primary">
      <div class="box-body box-profile">
        <img class="profile-user-img img-responsive img-circle profile-avatar" src="{{ asset($user->profile->profileImg) }}" alt="User profile picture">
        <h3 class="profile-username text-center">{{ $user->name }}</h3>
        <p class="text-muted text-center">
          @if ($user->roles()->count() > 0)
          @foreach ($user->roles as $role)
          {!! $role->name !!}<br/>
          @endforeach
          @else
          None
          @endif
        </p>
        @if ($user->id == access()->user()->id)
        {!! Form::open() !!}
        <div class="profileInput">
          <span class="uploadButton"><i class="fa fa-camera"></i>
            <input
            id="profilePic"
            name="profilePic"
            data-url="{{ route('backend.admin.profile.pic.upload') }}"
            accept="image/*"
            type="file">
          </span>
        </div>
        {!! Form::close() !!}
        @endif
        </div><!-- /.box-body -->
        </div><!-- /.box -->
        <div class="uploadProcess"></div>
        
        @if ($user->roles()->first()->id != 1 AND $user->roles()->first()->id != 3)
        <!-- Certified Button -->
        @if ($user->guide->certified == 1)
        <a class="btn btn-block btn-success btn-lg btn-flat btn-social">
          <i class="fa fa-certificate"></i> Certified
        </a>
        @else
        <a class="btn btn-block btn-danger btn-lg btn-flat btn-social">
          <i class="fa fa-circle-o"></i> Not Certified
        </a>
        @endif
        @if ($user->hasLicense())
        <a class="btn btn-block btn-primary btn-lg btn-flat btn-social" href="{{ route('backend.license', $user->id) }}">
          <i class="fa fa-eye"></i> View License
        </a>
        @endif
        @endif
        @if ($user->roles()->first()->id==1)
        <a class="btn btn-block btn-primary btn-lg btn-flat btn-social" href="{{ route('admin.access.user.change-password', $user->id) }}">
          <i class="fa fa-key"></i> Change Password
        </a>
        @endif
        </div><!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
        <div id="successmsg" style="display: none;"></div>
        <div id="failedmsg" style="display: none;"></div>
            <ul class="nav nav-tabs">
              <li class="active"><a href="#settings" data-toggle="tab">General Info</a></li>
              @if ($user->id != 1)
              <li><a href="#license" data-toggle="tab">Certification</a></li>
              <li><a href="#images" data-toggle="tab">Images</a></li>
              <li><a href="#videos" data-toggle="tab">Videos</a></li>
              <li><a href="#booking" data-toggle="tab">Booked Days</a></li>
              @endif
              
            </ul>
            <div class="tab-content">
              @if ($user->id != 1)
              
                        @endif
                        <div class="active tab-pane" id="settings">
                          {!! Form::model($user, ['route' => ['admin.access.users.update', $user->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) !!}
                          <div class="form-group">
                            {!! Form::label('fname', trans('validation.attributes.fname'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
                            <div class="col-lg-10">
                              {!! Form::text('fname', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.fname'), 'required']) !!}
                            </div>
                            </div><!--form control-->
                            <div class="form-group">
                              {!! Form::label('name', trans('validation.attributes.lname'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
                              <div class="col-lg-10">
                                {!! Form::text('lname', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.lname')]) !!}
                              </div>
                              </div><!--form control-->
                              <div class="form-group">
                                {!! Form::label('email', trans('validation.attributes.email'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
                                <div class="col-lg-10">
                                  {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.email'), 'required']) !!}
                                </div>
                                </div><!--form control-->
                                <div class="form-group">
                                {!! Form::label('gender', trans('validation.attributes.gender'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
                                <div class="col-lg-10">
                                  {!! Form::select('gender', array('Male' => 'Male', 'Female' => 'Female', 'Other' =>'Other'), $user->gender, array('class'=>'form-control')) !!}

                                </div>
                                </div><!--form control-->
                                <div class="form-group">
                                {!! Form::label('experience', trans('validation.attributes.experience'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
                                <div class="col-lg-10">
                                  {!! Form::selectYear('experience', 1992, Carbon\Carbon::today()->format('Y'), $user->profile->experience, ['class' => 'form-control']) !!}

                                </div>
                                </div><!--form control-->
                                  <div class="form-group required">
                                  {!! Form::label('mainArea', trans('validation.attributes.mainArea'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
                                  <div class="col-lg-10">
                                  <select id="target" name="mGuidingArea" class="form-control target" >
                                  <option value="{{ $selectedarea }}" selected>{{ $selectedarea }}</option>
                                 
                                  @foreach($guidearea as  $option)
                                  <option value="{{$option}}" >
                                    {{$option}}
                                  </option>
                                  @endforeach
                                  </select>
                                  </div>
                                  </div><!--form control-->
                                  <div id="onchangehide" style=" ">
                                    <div class="form-group required" id="otherarea">
                                        {!! Form::label('otherArea', trans('validation.attributes.otherArea'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
                                        <div class="col-lg-10">

                                            <select class="chosen-select form-control" multiple="multiple" name="OtherGuidingArea[]" id="places">
                                                @foreach($guidearea as $place)
                                                    <option value="{{$place}}" @foreach($selectedoarea as $p) @if($place === $p) selected="selected"@endif @endforeach>{{$place}}</option>
                                                @endforeach
                                            </select>



                                          </div>
                                    </div><!--form control-->
                                  </div>
                                  <div id="otherguidearea"></div>

                                <div class="form-group">
                                  {!! Form::label('about', trans('validation.attributes.about'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
                                  <div class="col-lg-10">
                                    {!! Form::textarea('about', null, ['class' => 'form-control','size' => '30x5']) !!}
                                  </div>
                                  </div><!--form control-->
                                    <div class="form-group required" id="otherarea">
                                      {!! Form::label('language', trans('validation.attributes.language'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
                                      <div class="col-lg-10">
                                      {!! Form::select('language[]', $selectedlang, $guidelanguage, ['class' => 'form-control chosen-select', 'multiple' => true]) !!}
                                      </div>
                                  </div><!--form control-->

                                  <div class="form-group required" id="otherarea">
                                      {!! Form::label('specilizedarea', trans('validation.attributes.specilizedarea'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
                                      <div class="col-lg-10">
                                      {!! Form::text('specilizedarea', ' ', array('class' => 'form-control')) !!}
                                      </div>
                                  </div><!--form control-->
                                  @if ($user->id != 1)
                                  <div class="form-group">
                                    {!! Form::label('price', trans('validation.attributes.price'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
                                    <div class="col-lg-10">
                                      {!! Form::input('number','price', $user->guide->price, ['class' => 'form-control'])!!}
                                    </div>
                                    </div><!--form control-->
                                    
                                    <div class="form-group">
                                      <label class="col-lg-2 col-md-2 control-label">{{ trans('validation.attributes.active') }}</label>
                                      <div class="col-md-8">
                                        <input type="checkbox" value="1" name="status" {{ $user->status == 1 ? 'checked' : '' }} />
                                      </div>
                                      </div><!--form control-->
                                      <div class="form-group">
                                        <label class="col-lg-2 col-md-2 control-label">{{ trans('validation.attributes.confirmed') }}</label>
                                        <div class="col-md-8">
                                          <input type="checkbox"  value="1" name="confirmed" {{ $user->confirmed == 1 ? 'checked' : '' }} />
                                        </div>
                                        </div><!--form control-->
                                          @endif
                                          <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                              <div class="pull-right">
                                                <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
                                              </div>
                                            </div>
                                          </div>
                                          <!--  @if ($user->id == 1)
                                          {!! Form::hidden('status', 1) !!}
                                          {!! Form::hidden('confirmed', 1) !!}
                                          {!! Form::hidden('assignees_roles[]', 1) !!}
                                          @endif -->
                                          {!! Form::close() !!}
                                          </div><!-- /.tab-pane -->

         <div class="tab-pane consistency" id="images">
          <div class="row wrap-all">
              {!! Form::open(['url'=>'#','id'=>'gallerySetProfileForm']) !!}
            <div class="gallery-list" id="images-list">

                  <div id="galleryshow">
                    @include('backend.gallery.images')
                  </div>
                  
            </div>
            <div class="imagesUploadArea">
              <div class="thumbnail browse-image">
                   <div class="galleryUploadButton">
                       <span class="uploadButton"><i class="fa fa-plus"></i></span>
                          <input 
                              id="galleryPicture"
                              name="galleryPic"
                              data-url="{{ route('frontend.guide.addgallery.upload') }}"
                              accept="image/*" 
                              type="file"
                              multiple>
                    </div> 
                    {!! Form::hidden('id', $user->id) !!}
                <div class="imglicloader" style="display: none;">
                {!!Form::image('images/ajax-loader.gif')!!}
                </div>

              </div>
              <div class="loader-overlay"><div class="custom-loader"></div></div>
            </div>

            <div class="form-group btmsave">
                    <div class="col-md-12">
                      <div class="pull-right">
                      {!! Form::submit(trans('strings.save_button'), ['class' => 'btn btn-success', 'id' => 'submit']) !!}
                      </div>
                    </div>
                    </div>
              {!! Form::close()!!}
          </div>
            
        </div>                                    
        <!-- <div class="tab-pane" id="images">
          <div class="row">
            <div class="col-md-4 col-sm-4 imagesUploadArea">
              <div class="thumbnail browse-image">
                {!! Form::open() !!}
                   <div class="galleryUploadButton">
                       <span class="uploadButton"><i class="fa fa-plus"></i></span>
                          <input 
                              id="galleryPic"
                              name="galleryPic"
                              data-url="{{ route('frontend.guide.gallery.upload') }}"                        
                              accept="image/*" 
                              type="file"
                              multiple>
                    </div> 
                    {!! Form::hidden('id', $user->id) !!}
                {!! Form::close() !!}
                <div class="loader-overlay"><div class="custom-loader"></div></div>
              </div>
            </div>
            <div class="gallery-list" id="images-list">
              @include('backend.gallery.images')
            </div>
          </div>
        </div> -->

        <div class="tab-pane" id="license">
          <div class="row">
             <div class="gallery-list" id="images-list">
              <div id="licenseshow">
                @include('backend.gallery.licence')
              </div>
        </div>
            <div class="imagesUploadArea">
              <div class="thumbnail browse-image">

                {!! Form::open() !!}
                   <div class="galleryUploadButton">
                       <span class="uploadButton"><i class="fa fa-plus"></i></span>
                          <input 
                              id="licensePicture"
                              name="licensegalleryPic"
                              data-url="{{ route('backend.guide.license.upload') }}"
                              accept="image/*" 
                              type="file"
                              multiple>
                    </div> 
                    {!! Form::hidden('id', $user->id) !!}
                    
                {!! Form::close() !!}
                <div class="imglicloader" style="display: none;">
                {!!Form::image('images/ajax-loader.gif')!!}
                </div>
                </div>
                <div class="loader-overlay"><div class="custom-loader"></div></div>
          </div>
          <div class="col-md-12">
          {!! Form::open(['url' => '#','method'=>'POST', 'role' => 'form',  'files'=> false, 'id'=>'mylicenseForm']) !!}
                <div class="checkbox chkbox">
                      <input type="checkbox"  value="1" name="certified" /> Check here to certify this user
                </div>

                {!! Form::hidden('id', $user->id) !!}
                    
                <div class="form-group">
                      <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
                </div>
                {!! Form::close() !!}
          </div>
        </div>
        
           
        </div>
        <div class="tab-pane" id="videos">
          <div class="row">
            <div class="gallery-list"  id="videos-list">
              <div id="displayvideo">
                @include('backend.gallery.videos')
              </div>
            </div>
            <div class="imagesUploadArea">
              <div class="thumbnail browse-image">
                 <a  data-toggle="modal" data-target="#video-modal" class="bg-image">
                    <div class="galleryUploadButton"><span class="uploadButton"><i class="fa fa-plus"></i></span></div>
                  </a>
                <div class="galleryUploadProcess"></div>
              </div>
            </div>
          </div>
        </div>

         <div class="tab-pane" id="booking">
          <div class="book-it-content">
          
          {!! Form::open(['url' => '#','method'=>'POST', 'role' => 'form',  'files'=> false, 'id'=>'mybookingEditForm']) !!}
            
            <div class="demo first">
            <h3 class="selectdates">Select Dates</h3>
            <div id="simpliest-usage" class="box"></div>
            </div>
            {!! Form::hidden('id', $user->id) !!}       
            <div class="form-group">
              <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
            </div>
            {!! Form::close() !!}
          </div>
        </div>
      </div><!-- /.tab-content -->
     </div><!-- /.nav-tabs-custom -->
    </div><!-- /.col -->
  </div><!-- /.row -->
  <div class="modal fade" id="video-modal" tabindex="-1" role="dialog" aria-labelledby="myVideoLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Embed Your Video From Youtube</h4>
                    </div>
                    <div class="modal-body">
                    <div class="row">
                     <div class="video-message"></div>
                        {!! Form::open(['url' => '', 'role' => 'form', 'id'=>'addVideoForm']) !!}
                                  <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        {!! Form::input('text', 'url',null, ['class' => 'form-control', 'id' => 'url','placeholder' => trans('validation.attributes.youtubeUrl'), 'required']) !!}
                                    </div>
                                  </div>
                                  <div class="col-md-6 col-sm-6">
                                    <div class="form-group">    
                                        {!! Form::input('text', 'caption',null, ['class' => 'form-control', 'id' => 'caption','placeholder' => trans('strings.caption')]) !!}
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        {!! Form::hidden('id', $user->id) !!}
                                        {!! Form::submit(trans('labels.button.submit'), ['class' => 'btn btn-defaultn btn-primary']) !!}
                                    </div>
                                  </div>
                                     <div class="loader-overlay"><div class="custom-loader"></div></div>
                       {!! Form::close() !!}
                    </div>
                    </div>
            </div>
        </div>
</div>
@stop
@section('after-scripts-end')
  {!! HTML::script('js/backend/access/permissions/script.js') !!}
  {!! HTML::script('js/backend/access/users/script.js') !!}
  {!! HTML::script('blueimp/load-image.all.min.js') !!}
  {!! HTML::script('blueimp/canvas-to-blob.js') !!}
  {!! HTML::script('blueimp/jquery.iframe-transport.js') !!}
  {!! HTML::script('blueimp/jquery.fileupload.js') !!}
  {!! HTML::script('blueimp/jquery.fileupload-process.js') !!}
  {!! HTML::script('blueimp/jquery.fileupload-image.js') !!}
  {!! HTML::script('blueimp/jquery.fileupload-validate.js') !!}
  {!! HTML::script('fancybox/jquery.fancybox.js?v=2.1.5') !!}
  {!! HTML::script('js/customUpload.js') !!}
  {!! HTML::script('js/backend/customCalendarbackend.js') !!}
  {!! HTML::script('js/backend/daterangepicker.js') !!}

  


@stop

@section('after-styles-end')
  {!! HTML::style('fancybox/jquery.fancybox.css') !!}
  {!! HTML::style('blueimp/css/jquery.fileupload.css') !!}
  {!! HTML::style('blueimp/css/jquery.fileupload-ui.css') !!}
@stop