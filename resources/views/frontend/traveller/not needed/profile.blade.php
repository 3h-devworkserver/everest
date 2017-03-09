@extends('frontend.layouts.masterProfile')
@section('title') Profile | {{ $siteTitle }}@endsection
@section('content')
<section class="dashboard">
		<div class="container">

			<div class="row">

				<div class="col-md-3">
					<h4>{{ $user->name }}</h4>
					<div class="profile-image">
						
						{!! Form::open() !!}
						 	
		                  	 <!-- <div class="profile-avatar bg-image" style="background-image: url({{ $user->profilePic }})"></div> -->
		                  	 <img src="{{ $user->profilePic }}" class="profile-avatar bg-image" />
		                  	 
		                  	 <div class="profileInput">
		                  	 <span class="uploadButton"><i class="fa fa-camera"></i><span>Upload</span></span>
		                        <input 
		                            id="profilePic"
							        name="profilePic"
							        data-url="{{ route('frontend.traveller.profile.pic.upload') }}"
							        
		                            accept="image/*" 
		                            type="file">
		                          

		                        <!-- Preview(s) will be displayed here -->
		                      </div>  
                    	{!! Form::close() !!}

					</div>
					<div class="uploadProcess"></div>
				</div>
				<div class="col-md-9">
				@include('includes.partials.messages')
					<div class="profile-edit">
						<h4>User Profile</h4>
						<div class="row">
							<div class="col-md-12 profile-form">
								{!! form($form) !!}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</section>

@endsection

@section('after-scripts-end')

    <!-- Load required JS libraries. -->
    {!! HTML::script('blueimp/load-image.all.min.js') !!}
    {!! HTML::script('blueimp/canvas-to-blob.js') !!}
    {!! HTML::script('blueimp/jquery.iframe-transport.js') !!}
    {!! HTML::script('blueimp/jquery.fileupload.js') !!}
    {!! HTML::script('blueimp/jquery.fileupload-process.js') !!}
    {!! HTML::script('blueimp/jquery.fileupload-image.js') !!}
    {!! HTML::script('blueimp/jquery.fileupload-validate.js') !!}

    {!! HTML::script('js/customUpload.js') !!}
    <script language="javascript">
    	print_country("country","{{ $user->country }}");
    	$("#state").append(new Option("{{ $user->state }}", "{{ $user->state }}"));
    </script>

  
@stop

@section('after-styles-end')
  {!! HTML::style('blueimp/css/jquery.fileupload.css') !!}
  {!! HTML::style('blueimp/css/jquery.fileupload-ui.css') !!}
  {!! HTML::script('js/countries.js') !!}
@stop