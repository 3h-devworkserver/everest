@foreach($gallerys as $gallery)
		<div class="thumbnail radioconsistency">
			<a style="background-image:url({{ asset($gallery->path) }})"  data-fancybox-group="gallery" title="{{ $gallery->caption }} " class="fancybox bg-image"></a>
			
	                <button data-imgid= "{{$gallery->id}}" data-userid= "{{$gallery->user_id}}" id="galleryDeleteButton">
	                <i>&times;</i>
	                </button> 
            {!! Form::hidden('id',$gallery->id) !!}
                {!! Form::hidden('user_id',$gallery->user_id,['id' => 'user_id']) !!}
            <div class="profile"> 
					<div class="radio">
					   @if ($gallery->path === $user->profile->profileImg)
				    	<label>
						  <input type="radio" value="{{$gallery->path}}" name="status" data-imgid= "{{$gallery->id}}" data-userid= "{{$gallery->user_id}}" checked /> Set as Profile Picture
						</label>
						@else
				    	<label>
						  <input type="radio" value="{{$gallery->path}}" name="status" data-imgid= "{{$gallery->id}}" data-userid= "{{$gallery->user_id}}"   /> Set as Profile Picture
						</label>
						@endif
					</div>
            </div>  
		</div>	
@endforeach
