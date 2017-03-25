@extends('frontend.layouts.master-new')

@section('title'){{ $meta_title }}@endsection
<!--@section('meta_title'){{ $meta_title }}@endsection-->
@section('meta_keywords'){{ $meta_keywords }}@endsection
@section('meta_desc'){{ $meta_desc }}@endsection
@section('content')
{{-- <section class="banner bg-wrap {!! $page->image !!}" style="background-image: url({!! url().'/images/'.$page->image !!});">
    <div class="container"></div>
</section> --}}
{{-- @include('frontend.includes.region') --}}
{{-- @include('frontend.includes.new.search') --}}

<div class="main-content">
		<div class="container">
		{!!Form::open() !!}
			<div class="travel-booking">
				<div class="travel-booking-step">
					<div class="row">
						<div class="col-md-12">
							<a href="#" class="active">Step 1 - Pricing </a>
							<a href="#">Step 2 - Travellers </a>
							<a href="#">Step 3 - Review &amp; Confirm </a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-9 col-sm-8">
						<div class="page-header bold_page-header">
								<h2>CLASSIC EVEREST BOOKING</h2>
						</div>
					
						<div class="travel-form">
							<form action="#">
								<div class="form-group">
									<p class="form-title">Travellers: 
										<small>How may people are you travelling with?</small>
									</p>

									<div class="traveller-select">
										<div class="select-menu">
											<label>Adult(18+)</label>
											<select name="adult" id="adult" class="SlectBox form-control" data-rate="{{$package->price}}">
												<option>1</option>
												<option>2</option>
												<option>3</option>
												<option>4</option>
											</select>
										</div>
										<div class="select-menu">
											<label>Youth(12-17+)</label>
											<select name="youth" id="youth" class="SlectBox form-control">
												<option>1</option>
												<option>2</option>
												<option>3</option>
												<option>4</option>
											</select>
										</div>

										
									</div>

								</div>

								<div class="form-group">
									<p class="form-title">TOUR DATE:</p>
									<div class="date-select">
										<div class="">{!!Form::text('tour_date', null, ['class'=>'date-wrap']) !!}</div>
										<!--<div class="date-wrap">  Saturday, December 12, 2015 </div>-->
										<div class="date-nav">
											<div class="btn btn-nav disabled">Previous</div>
											<div class="btn btn-nav">Next</div>
										</div>
									</div>
								</div>

								<div class="form-group">
									<p class="form-title">extra days:</p>
									<label>Arrive</label>
									<div class="date-select">
										<div class="">{!!Form::text('tour_date', null, ['class'=>'date-wrap']) !!}</div>
										{{-- <div class="date-wrap">Saturday, December 12, 2015</div> --}}
										<div class="date-nav">
											<div class="btn btn-nav">Earlier</div>
											<div class="btn btn-nav disabled">Next</div>
										</div>
									</div>

									<label>depart</label>
									<div class="date-select">
										<div class="">{!!Form::text('tour_date', null, ['class'=>'date-wrap']) !!}</div>
										{{-- <div class="date-wrap">Saturday, December 12, 2015</div> --}}
										<div class="date-nav">
											<div class="btn btn-nav disabled">Earlier</div>
											<div class="btn btn-nav">Next</div>
										</div>
									</div>

								</div>
							</form>
						</div>
					</div>

					<div class="col-md-3 col-sm-4">
						<div class="total-block">
							<div class="table-responsive">
							  <table class="table">
								   <tr>
								   		<td>Traveller</td>
								   		<td id = "traveller">1</td>
								   </tr>
								   <tr>
								   		<td>Tours</td>
								   		<td id = "tours">{{$package->price}}</td>
								   </tr>
								   <tr>
								   		<td>Extra Days</td>
								   		<td id = "days">0</td>
								   </tr>
								   <tr>
								   		<td>Checkout</td>
								   		<td id = "checkout">0</td>
								   </tr>
							  </table>
							  <div class="total-footer">
							  	<h3>Total USD <span id = "total">{{$package->price}}</span>
							  		<small>Tax Included</small>
							  	</h3>
							  </div>
							</div>
						</div>
					</div>
					
				</div>
				<div class="add-extra-package">
					<div class="row">
@foreach($package->packageCategory as $category)
	@foreach($category->package as $pack)
				@if($package->id != $pack->id)
						<div class="col-md-3 col-sm-3">
							<div class="thumbnail">
								<div class="checkbox">
								    <input type="checkbox" name="check[]" value="{{$pack->id}}" id="check">
								    <label for="check">{{$pack->title}}</label>
								  </div>
								<div class="thumb-img bg-wrap" style="background-image:url({{asset('images/new/home_blog_right_pokhara.png')}});"></div>
								<div class="price">+USD {{$pack->price}}</div>
								<a href="#" class="btn btn-gray">view itinerary</a>
							</div>
						</div>
				@endif
	@endforeach
@endforeach
				<!--		<div class="col-md-3 col-sm-3">
							<div class="thumbnail">
								<div class="checkbox">
								    <input type="checkbox" name="check" id="check">
								    <label for="check">Extension Pokhara</label>
								  </div>
								<div class="thumb-img bg-wrap" style="background-image:url({{asset('images/new/home_blog_right_pokhara.png')}});"></div>
								<div class="price">+USD 500</div>
								<a href="#" class="btn btn-gray">view itinerary</a>
							</div>
						</div>

						<div class="col-md-3 col-sm-3">
							<div class="thumbnail">
								<div class="checkbox">
								    <input type="checkbox" name="check" id="check1">
								    <label for="check1">Bungy Jumping</label>
								  </div>
								<div class="thumb-img bg-wrap" style="background-image:url({{asset('images/new/bungy-in-nepal.jpg')}});"></div>
								<div class="price">+USD 300</div>
								<a href="#" class="btn btn-gray">view itinerary</a>
							</div>
						</div>

						<div class="col-md-3 col-sm-3">
							<div class="thumbnail">
								<div class="checkbox">
								    <input type="checkbox" name="check" id="check2">
								    <label for="check2">Paragliding</label>
								  </div>
								<div class="thumb-img bg-wrap" style="background-image:url({{asset('images/new/paragliding.jpg')}});"></div>
								<div class="price">+USD 270</div>
								<a href="#" class="btn btn-gray">view itinerary</a>
							</div>
						</div>
						<div class="col-md-3 col-sm-3">
							<div class="thumbnail">
								<div class="checkbox">
								    <input type="checkbox" name="check" id="check3">
								    <label for="check3">Raffting</label>
								  </div>
								<div class="thumb-img bg-wrap" style="background-image:url({{asset('images/new/home_body_small_2.jpg')}});"></div>
								<div class="price">+USD 100</div>
								<a href="#" class="btn btn-gray">view itinerary</a>
							</div>
						</div> -->
						
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<a href="{{url('package/'.$slug.'/booking-step2')}}" class="btn btn-danger btn-step">Request Space</a>
					</div>
				</div>
				
			</div>
		{!!Form::close() !!}
		</div><!--Container -->

		<div class="divider"></div>


@include('frontend.includes.new.members')
		

		
	</div>




@endsection




