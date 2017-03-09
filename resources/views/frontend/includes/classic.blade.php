@extends('frontend.layouts.master')
@section('title'){{ $siteTitle }}@endsection
@section('content')
<section class="banner bg-wrap {!! $page->image !!}" style="background-image: url({!! url().'/images/'.$page->image !!});">
	<div class="container"></div>
</section>
<?php /* ?><section class="full-width-search">
	<div class="container">
		<div class="row">
			<form class="form-inline">
				<div class="form-group col-md-5 col-xs-5 col-sm-5">
					<select class="SlectBox form-control">
						<option selected="selected">Select Region</option>
						<option>Annapurna</option>
						<option>Mustang</option>
						<option value="Makalu">Makalu</option>
					</select>
				</div>
				<div class="form-group col-md-5 col-xs-5 col-sm-5">
					<select class="SlectBox form-control" placeholder="this is placeholder">
						<option selected="selected">Select Adventure</option>
						<option>Bungyjumping</option>
						<option>Paragliding</option>
						<option value="Makalu">Rafting</option>
					</select>
				</div>
				<div class="form-group  col-md-2 col-xs-2 col-sm-2">
					<button type="submit" class="btn btn-default">Select</button>
				</div>
			</form>
		</div>
	</div>
</section><?php */ ?>
<section class="full-width-search">
		<div class="container">
			<div class="row">
				<form class="form-inline">
					<div class="form-group col-md-10 col-xs-12 col-sm-10">
						<select class="SlectBox form-control">
							<option selected="selected">Search Upeverest</option>
							<option>Annapurna</option>
							<option>Mustang</option>
							<option value="Makalu">Makalu</option>
						</select>
					</div>
					<!-- <div class="form-group col-md-5 col-xs-5 col-sm-5">
						<select class="SlectBox form-control" placeholder="this is placeholder">
							<option selected="selected">Select Adventure</option>
							<option>Bungyjumping</option>
							<option>Paragliding</option>
							<option value="Makalu">Rafting</option>
						</select>
					</div> -->
					<div class="form-group  col-md-2 col-xs-2 col-sm-2">
						<button type="submit" class="btn btn-default">Select</button>
					</div>
				</form>
			</div>
		</div>
	</section>
<div class="main-content">
	<div class="container">
		{!! $page->content !!}
	</div>
	@if(!empty($static))
		@foreach($static as $s)
			{!! $s->content !!}
		@endforeach
	@endif
</div>

@stop