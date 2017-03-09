@extends('frontend.layouts.masterProfile')
@section('title') Recent Activity | {{ $siteTitle }}@endsection
@section('content')	
	<section class="dashboard">
		<div class="profile">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
					    <div class="profile-img pull-left">
					        <span class="avatar"><i class="fa fa-user"></i></span>
					        <label class="username">{{ Auth::user()->username}}</label>
					    </div>

					    <div class="view-profile pull-right">
					        <a class="btn btn-danger" href="{{ route('frontend.traveller.profile')}}">View Profile</a>
					    </div>
					</div>
				</div>
			</div>	
		</div>
		<div class="container">
			<div class="wrapper">
				<div class="row">
					<div class="col-md-12">
						<div class="recentactives">
							<h1>Recently Addes Guides</h1>
						
						@foreach ($bookings as $booking)
							<div class="post">
								<div class="row">
									<div class="col-md-10">
										<div class="user">
											<a href="{{ URL::to('guide/'.$booking->user->username) }}" style="background-image:url({{ $booking->user->picture }})"></a>
											<div class="name">
												<h5>{{ $booking->user->name }}</h5>
												<span>{{ $booking->user->experience }}  
												@if($booking->user->experience<'2')
                                                Year
                                                @else
                                                Years
                                                @endif
                                                (experience)</span>
												<div>
													<span class="rating average">
														<span>{{ $booking->user->guide->rating_cache }}</span>
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-2 text-center">
										<span class="booked">Booked {{ $booking->created_at->diffForHumans() }}</span>
										@if ( $booking->verified)
											<span class="label label-success">Approved</span>
										@else
											<span class="label label-danger">Pending</span>
										@endif
										<button class="btn btn-primary cust-btn-sm">View Detail</button>
									</div>
								</div>
							</div>
						@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection

