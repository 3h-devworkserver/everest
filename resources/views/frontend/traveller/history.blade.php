@extends('frontend.layouts.master-new')
@section('title') Traveller History | {{ $siteTitle }}@endsection
@section('meta_title'){{ $meta_title }}@endsection
@section('meta_keywords'){{ $meta_keywords }}@endsection
@section('meta_desc'){{ $meta_desc }}@endsection

@section('content')

<section class="main-content dashboard-wrapper">
	
	@include('frontend.traveller.includes.navbar')
	
	<div class="dashboard">
		<div class="container">
			<div class="row">
				<div class="col-md-3 col-sm-3">
					<div class="profile-block">
			            <div class="profile-picture">
			              <div class="profile-bg" style="background-image:url({{asset('images/new/mountain-biking.jpg')}})"></div>
			              @if(!empty($user->profile->profile_pic))
			                <div class="profile-img" style="background-image:url({{asset('images/user/profile/'.$user->profile->profile_pic)}});"></div>
			              @else
			                <div class="profile-img" style="background-image:url()}});"></div>
			              @endif
			            </div>
			            <div class="profile-desc text-center">
			              <h3>{{$user->profile->fname}} {{$user->profile->mname}} {{$user->profile->lname}}</h3>
			              <h5>{{$user->profile->address}} @if($user->profile->city), {{$user->profile->city}} @endif @if($user->profile->state), {{$user->profile->state}} @endif </h5>
			            </div>

			            <div class="profile-footer text-center">
			              <a href="{{url('traveller/profile')}}" class="btn btn-default">view profile</a>
			            </div>
			        </div>
				</div>
				<div class="col-md-9 col-sm-9">
              		@include('includes.partials.messages')

					<div class="user-activity">
						
						<h3>Purchased List</h3>						
						
						@foreach($user->userBookings as $booking)
							<?php 
	              				if($booking->type == 'package') {
	              					$booked = $booking->packageBooking->package;
	              				}else{
	              					$booked = $booking->flightReservation; 
	              				}
	              			?>
							<article class="activity-wrap">
								<div class="row">
									<div class="col-md-1">
										<figure>
											@if($booking->type == 'package')
												<img src="{{asset('images/packages-new/'.$booked->feat_img)}}" alt="">
											@else
												<img src="{{asset('images/upeverest-logo.png')}}" alt="">
											@endif
										</figure>
									</div>
									<div class="col-md-4">
										@if($booking->type == 'package')
											<h4>{{title_case($booked->title)}}</h4>
										@else
											<h4>{{title_case($booked->departure)}} to {{title_case($booked->arrival)}}</h4>
										@endif
									</div>
									<div class="col-md-5">
										<div class="meta-activity">
											<ul class="list-unstyled list-inline">
												<li> <i class="fa fa-tag"></i>
													@if($booking->type == 'package')
														<?php $i = 1; ?>
								                        @foreach($booked->packageCategory as $cat)
								                          @if($i == 1)
								                            {{$cat->title}}
								                          @else
								                            , {{$cat->title}}
								                          @endif
								                          <?php $i++; ?>
								                        @endforeach
								                    @else
								                    	@if($booked->return_type == 'R') Round Trip Flight @else One Way Flight @endif
								                    @endif
												</li>
												<li>
													<i class="fa fa-clock-o"></i> {{Carbon\Carbon::parse($booking->purchased_at)->format('d M Y')}}
												</li>
											</ul>
										</div>
									</div>
									<!--
									<div class="col-md-2 text-right">
										<div class="action">
											<a href="#">
												<i class="fa fa-pencil"></i>
											</a>
											<a href="#">
												<i class="fa fa-trash"></i>
											</a>
											
										</div>
									</div>
									-->
								</div>
							</article>
						@endforeach

						<nav aria-label="...">
							<ul class="pager">
								<li><a href="#"><i class="fa fa-angle-left"></i> &nbsp;Previous</a></li>
								<li><a href="#">Next &nbsp; <i class="fa fa-angle-right"></i></a></li>
							</ul>
						</nav>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection