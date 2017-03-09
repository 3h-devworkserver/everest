@foreach($licenses as $gallery)
		<div class="thumbnail">
			<a style="background-image:url({{ asset($gallery->path) }})"  data-fancybox-group="gallery" href="{{ asset($gallery->path) }}" title="{{ $gallery->caption }} " class="fancybox bg-image"></a>
			
			{!! Form::open(['url'=>'#','id'=>'addlicenseDeleteForm']) !!} 
                {!! Form::hidden('id',$gallery->id) !!}
	                <button type="submit" id="galleryDeleteButton" onclick="return confirm('Are you sure you want to delete this item?');">
	                    <i>&times;</i>
	                </button> 
            {!! Form::close() !!}
                
		</div>	
 @endforeach