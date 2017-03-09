@foreach($videos as $gallery)
		<div class="thumbnail">
			<a style="background-image:url({{ asset('images/1.jpg') }})" data-fancybox-group="gallery" href="{{ $gallery->path }}?fs=1&amp;autoplay=1" class="video"></a>
			
			{!! Form::open(['route'=>'frontend.guide.video.delete','id'=>'videoDeleteForm']) !!} 
                {!! Form::hidden('id',$gallery->id) !!}
                <button type="submit" id="videoDeleteButton" onclick="return confirm('Are you sure you want to delete this item?');">
                    <i>&times;</i>
                </button> 
            {!! Form::close() !!}
            
		</div>	
@endforeach
