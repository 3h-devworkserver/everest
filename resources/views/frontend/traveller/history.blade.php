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
							@if(!empty($user->profile->profile_pic))
				                <div class="profile-bg" style="background-image:url({{asset('images/user/profile/'.$user->profile->profile_pic)}})"></div>
				            @else
				                <div class="profile-bg" style="background-image:url({{asset('images/new/mountain-biking.jpg')}})"></div>
				            @endif
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
						
						<h3>Purchased History</h3>						
							@if(count($user->userBookings) != 0)
								<?php $i = 1; ?>
								@foreach($user->userBookings as $booking)
								<?php 
								if($booking->type == 'package') {
									$booked = $booking->packageBooking->package;
								}else{
									$booked = $booking->flightReservation; 
								}
								?>
								<article class="activity-wrap @if($i > 11) display-none @endif">
									<div class="row">
										<div class="col-md-2">
											<figure>
												@if($booking->type == 'package')
												<a href="{{url('/package/'.$booked->slug)}}"><img src="{{asset('images/packages-new/'.$booked->feat_img)}}" alt=""></a>
												@else
												<img src="{{asset('images/upeverest-logo.png')}}" alt="">
												@endif

											</figure>
										</div>
										<div class="col-md-8">
											@if($booking->type == 'package')
												<h4><a href="{{url('/package/'.$booked->slug)}}">{{title_case($booked->title)}}</a></h4>
											@else
												<h4>{{title_case($booked->departure)}} to {{title_case($booked->arrival)}}</h4>
											@endif
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
														<i class="fa fa-clock-o"></i> Purchased On: {{Carbon\Carbon::parse($booking->purchased_at)->format('d M Y')}} 
													</li>
													<li>
														<i class="fa fa-money"></i>
														@if($booking->type == 'package')
															{{$booking->packageBooking->total_amount}} 
														@else
															{{$booked->total_amount}} 
														@endif
													</li>
												</ul>
											</div>
											@if($booking->type == 'package')
											<p>
												{!! $booked->description!!}
											</p>
											@else
											<p>
												
											</p>
											@endif

										</div>
										<div class="col-md-2 text-right">
											<div class="action">
												<a href="{{url('/traveller/purchase/'.$booking->id.'/detail')}}" target="_blank">
													<i class="fa fa-eye"></i>
												</a>
											</div>
										</div>
									</div>
								</article>
								<?php $i++; ?>
								@endforeach

								<a href="javascript:void(0)" class="btn btn-danger btn-viewall">View All</a>
							@else
								<div class="well not-found">
								<p class="lead text-center">No Purchased History</p>
								</div>
							@endif

						
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection