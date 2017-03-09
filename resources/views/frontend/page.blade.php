@extends('frontend.layouts.master-new')
<!--@section('title'){{$page->title}}@endsection-->
@section('title'){{ $meta_title }}@endsection
<!--@section('meta_title'){{ $meta_title }}@endsection-->
@section('meta_keywords'){{ $meta_keywords }}@endsection
@section('meta_desc'){{ $meta_desc }}@endsection

@section('content')
<div class="main-content">
	<div class="container">
		<?php
		echo list_breadcrumbs($page->slug, $page->title);
		?>

		<div class="row">

			<div class="col-md-8 col-sm-8">

				<div class="page-header bold_page-header">
					<h2>{{$page->title}}</h2>
				</div>

			</div>

			<div class="col-md-4 col-sm-8">

				<!--socila icons-->

				@include('frontend.includes.sharethis')

			</div>

		</div>
		<?php
		$advs = \DB::table('page_ads')->where('pages_id', 'like', '%' . $page->id . 'abcd%')->get();

		$contentClass = 'col-md-12 col-sm-12';
		if ($advs)
			$contentClass = 'col-md-8 col-sm-8';

		// die('am here');
		?>
		<div class="feature-content">

			<div class="row">

				<div class="<?= $contentClass ?>">

					<div class="full_content">

						<?php
						$content_length = strlen($page->content);
						if ($content_length > 1000) {
							//echo '<div class="short_content" style="height:200px;overflow:hidden">';
							echo '<div class="">';
							echo $page->content;
							echo '</div>';
							?>                        
							<?php
						} else {
							?>
							<div class="full_content">
								<?php echo $page->content; ?>
							</div>
							<?php
						}
						?>    


					</div>       

				</div>
				<?php
				if ($advs) {
					?>
					<div class="col-md-4 col-sm-4">

						<!--ads-->


						<p>Advertisement</p>

						<?php
						foreach ($advs as $row) {
							?>
							<div class="adds">
								<a href="<?= $row->link ?>" target="_blank">
									<img src="<?= url() . '/images/' . $row->ads ?>" alt="">
								</a>

							</div>

						<?php }
						?>


					</div>
					<?php
				}
				?>

			</div>

		</div>

		
		<?php if ($page->slug == 'contact') { ?>
						
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
						@endif

						
						@if(Session::has('message'))
                                                
                                                    <script>
                                                      
                                                        $(document).ready(function(){


                                                        $('html, body').animate({
                                                           scrollTop: $('#successMessage').offset().top
                                                        }, 2000);

                                                        });

                                                    </script>

						<p id="successMessage" class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
						@endif


						<div class="contact-form">

							<form action="{{url()}}/submitContact" method="post">

								<div class="row">

									<div class="col-md-6 col-sm-6">

										<div class="form-group">

											<input type="text" class="form-control" placeholder="Name" name="name" />

										</div>

										<div class="form-group">

											<input type="Email" class="form-control" placeholder="Email" name="email" />

										</div>
									   
										

										<div class="form-group">

											<input type="text" class="form-control" placeholder="Contact No." name="contactno" />

										</div>
									</div>

									<div class="col-md-6 col-sm-6">
										<div class="form-group text-area">
											<textarea class="form-control" placeholder="Message" name="message"></textarea>
										</div>
										<input type="hidden" name="_token" value="{{ csrf_token() }}" />
									</div>

									<div class="col-md-6 col-sm-6 captcha">
										   {!! app('captcha')->display(); !!}
									</div>
									<div class="col-md-6 col-sm-6">
										<button type="submit" class="btn btn-default">Send</button>
									</div>

								</div>

							</form>

						</div>

					<?php } ?>
			</div>
		<div class="divider"></div>

		@include('frontend.includes.new.essential')
		<?php $video = \DB::table('p_videos')->where('pages_id', 'LIKE', '%' . $page->id . 'abcd%')->get(); ?>

		<?php
		foreach ($video as $v) {
			$link = parse_vimeo($v->video);
			$video_link = "http://player.vimeo.com/video/" . $link;
			?>

			<div class="video">

				<iframe src=" {{$video_link}}" height="100%" width="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>

			</div>
		<?php } ?>

</div>
<script>
    $(document).ready(function () {
        $('.readmore').click(function () {
            $('.short_content').css('height', 'auto');
            $(this).hide();
        });
    });

</script>
@stop