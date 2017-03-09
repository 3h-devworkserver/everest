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
		<div class="travel-booking">
			<div class="travel-booking-step">
				<div class="row">
					<div class="col-md-12">
						<a href="#">Step 1 - Travellers </a>
						<a href="#" class="active">Step 2 - Summary  </a>
						<a href="#">Step 3 - Review &amp; Confirm </a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-9 col-sm-8">
					<div class="page-header bold_page-header">
						<h2>{{$package->title}} BOOKING SUMMARY</h2>
					</div>
					
					<div class="travel-detail">
						<div class="trip-info">
							<div class="table-responsive">
								<table class="table">
									<tr>
										<td>Package Name</td>
										<td >{{$package->title}}</td>
									</tr>
									<tr>
										<td>Tour Date</td>
										<td >{{$dPrice->daterange}}</td>
									</tr>
									<tr>
										<td>When</td>
										<td>{{$dPrice->daterange}}</td>
									</tr>

								</table>
							</div>
						</div>

						<div class="traveller-detail">
						<h4>Traveller Detail</h4>
							<div class="table-responsive">
								<table class="table">
									<tr>
										<td>Traveller Name</td>
										<td >DOB</td>
									</tr>
									@foreach($travellers as $traveller)
									<tr>
										<td>{{$traveller->title}} {{$traveller->fname}} {{$traveller->mname}} {{$traveller->lname}}</td>
										<td >{{$traveller->dob_year}}-{{$traveller->dob_month}}-{{$traveller->dob_day}}</td>
									</tr>
									@endforeach

								</table>
							</div>
						</div>

					</div>
				</div>

				<div class="col-md-3 col-sm-4">
					<div class="sidebar-travel">
						<div class="total-block">
							<div class="table-responsive">
								<table class="table">
									<tr>
										<td>Traveller</td>
										<td>1</td>
									</tr>
									<tr>
										<td>Tours</td>
										<td>{{$dPrice->price}}</td>
									</tr>
									<tr>
										<td>When</td>
										<td>{{$dPrice->daterange}}</td>
									</tr>
									<tr>
										<td>Person</td>
										<td>
											@foreach($travellers as $traveller)
											<p>{{$traveller->title}} {{$traveller->fname}} {{$traveller->mname}} {{$traveller->lname}}<p>
												@endforeach
											</td>
										</tr>
								   {{-- <tr>
								   		<td>Checkout</td>
								   		<td id = "checkout">0</td>
								   	</tr> --}}
								   </table>
								   <div class="total-footer">
								   	<h3>Total USD <span id = "total">{{$dPrice->price}}</span>
								   		<small>Tax Included</small>
								   	</h3>
								   </div>
								</div>
							</div>
						</div>
					</div>
					
				</div>

				
				
			</div>
		</div><!--Container -->



		@include('frontend.includes.new.members')
		

		
	</div>




	@endsection