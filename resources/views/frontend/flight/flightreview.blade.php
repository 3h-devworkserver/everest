@extends('frontend.layouts.master-new')
@section('title') Flight Review | {{ $siteTitle or '' }}@endsection
@section('meta_keywords'){{ $meta_keywords }}@endsection
@section('meta_desc'){{ $meta_desc }}@endsection

@section('loader')
@include('frontend.includes.new.loader')
@endsection

@section('content')

@include('frontend.includes.new.functions')

<section class="main-content">
	<div class="flight-booking-progress-step">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<ul class="progress-step progress-step--medium list-unstyled">
						<!-- <li class="is-complete"> -->
						<li class="is-complete">
							<span class="circle">
								<i class="fa fa-check"></i>
							</span>
							<span class="progress-text">Selection</span>
						</li>
						<!-- <li class="is-active"> -->
						<li class="is-active">
							<span class="circle">
								<i class="fa fa-file-text"></i>
							</span>
							<span class="progress-text">Review</span>
						</li>
						<li>
							<span class="circle">
								<i class="fa fa-user"></i>
							</span>
							<span class="progress-text">Passanger Details</span>
						</li>
						<li>
							<span class="circle">
								<i class="fa fa-credit-card"></i>
							</span>
							<span class="progress-text">Payment</span>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="flight-wrapper flight-review">
		<div class="container">
			<div class="flight-list-block">
			
				<div class="row">
					<div class="col-md-9">
						@if(!empty($flightDetail))
						<div class="flight-review-header">
							<div class="row">
								<div class="first-row">
									<div class="col-md-1 col-sm-2">
										<figure>
										<img src="{{$flightDetail->AirlineLogo}}" alt="">
										</figure>
									</div>
									<div class="col-md-8 col-sm-7 mobile-mode">
										<h4 class="box-title"><?php echo airlinesName($flightDetail->Airline); ?> ({{$flightDetail->FlightNo}})<small>Departure flight</small></h4>
										<a class="badge">Class {{$flightDetail->FlightClassCode}}</a>
									</div>
									<!-- <div class="col-md-3 col-sm-3 text-right">
										<a href="flight.html" class="btn btn-back"><i class="fa fa-angle-left"></i>Back To Flight List</a>
									</div> -->
								</div>
							</div>
						</div>
						<article class="box-flight">
							<div class="time row-fluid">
								<div class="col-md-3 col-sm-3">
									<div class="take-off review-tbl-title">
										<div class="icon">
											<i aria-hidden="true" class="fa fa-plane"></i>
										</div>
										<div class="desc">
											<span class="skin-color">Departure</span>
										</div>

									</div>

									<span class="dep-details">
										<span class="city">{{ucfirst(strtolower($flightDetail->Departure))}}</span>
										<span class="dep-date">
											<?php if(!empty($flightDetail->FlightDate)){
												echo (new DateTime($flightDetail->FlightDate))->format('D , j M Y ') ;
											}?>
										</span>
										<span class="time-head">
											<span class="time">{{$flightDetail->DepartureTime}}</span></span>
											
											<span class="terminal"></span>
										</span>

									</div>
									<div class="col-md-3 col-sm-3">
										<div class="landing review-tbl-title">
											<div class="icon">
												<i aria-hidden="true" class="fa fa-plane"></i>
											</div>
											<div class="desc">
												<span class="skin-color">Arrival</span>
											</div>

										</div>
										<span class="arr-details">
											<span class="city">{{ucfirst(strtolower($flightDetail->Arrival))}}</span>
											<span class="dep-date arr-date">
												<?php if(!empty($flightDetail->FlightDate)){
													echo (new DateTime($flightDetail->FlightDate))->format('D , j M Y ') ;
												}?>
											</span>
											<span class="time-head">
												<span class="time">{{$flightDetail->ArrivalTime}}</span>
											</span>
											<span class="terminal"></span>
										</span>
									</div>
									<div class="col-md-2 col-sm-2">
										<div class="total-time review-tbl-title">
											<div class="icon">
												<i class="fa fa-clock-o"></i></div>
												<div class="desc">
													<span class="skin-color">total time</span>

												</div>
											</div>
											<span class="text-center"><?php 
												$d1 = $flightDetail->FlightDate.' '.$flightDetail->DepartureTime;
												$d2 = $flightDetail->FlightDate.' '.$flightDetail->ArrivalTime;
												$datetime1 = new DateTime($d1);
												$datetime2 = new DateTime($d2);
												$interval = $datetime2->diff($datetime1);
												$elapsed = $interval->format('%h Hour, %i minutes');
												echo $elapsed;
												?></span>

											</div>
											<div class="col-md-2 col-sm-2">
												<div class="travel-class">
													<div class="review-tbl-title">
														<div class="icon">
															<i aria-hidden="true" class="fa fa-wheelchair"></i>
														</div>
														<div class="desc">
															<span class="skin-color">Type</span>
														</div>
													</div>

													<span>@if($flightDetail->Refundable == 'T') Refundable @else Non-Refundable @endif</span>
												</div>

											</div>
											<div class="col-md-2 col-sm-2">
												<div class="package-price">
													<div class="review-tbl-title">
														<div class="icon">
															<i aria-hidden="true" class="fa fa-calculator"></i>
														</div>
														<div class="desc">
															<span class="skin-color">Total Price
															</span>
														</div>
													</div>


													<span class="">
														<strong>
														 {{$flightDetail->Currency}} <?php echo custom_number_format(totalPrice($flightDetail->Adult, $flightDetail->Child, $flightDetail->AdultFare, $flightDetail->ChildFare, $flightDetail->ResFare, $flightDetail->FuelSurcharge, $flightDetail->Tax )) ?> 
														</strong>
														<small>Baggage Allowance - {{$flightDetail->FreeBaggage}} Included</small>
													</span>
												</div>
											</div>
										</div>
						</article>
						
							@endif


					@if(!empty($returnFlightDetail))
						<div class="flight-review-header">
							<div class="row">
								<div class="first-row">
									<div class="col-md-1 col-sm-2">
										<figure>
										<img src="{{$returnFlightDetail->AirlineLogo}}" alt="">
										</figure>
									</div>
									<div class="col-md-8 col-sm-7 mobile-mode">
										<h4 class="box-title"><?php echo airlinesName($returnFlightDetail->Airline); ?> ({{$returnFlightDetail->FlightNo}})<small>Return flight</small></h4>
										<a class="badge">Class {{$returnFlightDetail->FlightClassCode}}</a>
									</div>
									<!-- <div class="col-md-3 col-sm-3 text-right">
										<a href="flight.html" class="btn btn-back"><i class="fa fa-angle-left"></i>Back To Flight List</a>
									</div> -->
								</div>
							</div>
						</div>
						<article class="box-flight">
							<div class="time row-fluid">
								<div class="col-md-3 col-sm-3">
									<div class="take-off review-tbl-title">
										<div class="icon">
											<i aria-hidden="true" class="fa fa-plane"></i>
										</div>
										<div class="desc">
											<span class="skin-color">Departure</span>
										</div>

									</div>

									<span class="dep-details">
										<span class="city">{{ucfirst(strtolower($returnFlightDetail->Departure))}}</span>
										<span class="dep-date">
											<?php if(!empty($returnFlightDetail->FlightDate)){
												echo (new DateTime($returnFlightDetail->FlightDate))->format('D , j M Y ') ;
											}?>
										</span>
										<span class="time-head">
											<span class="time">{{$returnFlightDetail->DepartureTime}}</span></span>
											
											<span class="terminal"></span>
										</span>
									</div>
									<div class="col-md-3 col-sm-3">
										<div class="landing review-tbl-title">
											<div class="icon">
												<i aria-hidden="true" class="fa fa-plane"></i>
											</div>
											<div class="desc">
												<span class="skin-color">Arrival</span>
											</div>

										</div>
										<span class="arr-details">
											<span class="city">{{ucfirst(strtolower($returnFlightDetail->Arrival))}}</span>
											<span class="dep-date arr-date">
												<?php if(!empty($returnFlightDetail->FlightDate)){
													echo (new DateTime($returnFlightDetail->FlightDate))->format('D , j M Y ') ;
												}?>
											</span>
											<span class="time-head">
												<span class="time">{{$returnFlightDetail->ArrivalTime}}</span>
											</span>
											
											<span class="terminal"></span>
										</span>
									</div>
									<div class="col-md-2 col-sm-2">
										<div class="total-time review-tbl-title">
											<div class="icon">
												<i class="fa fa-clock-o"></i></div>
												<div class="desc">
													<span class="skin-color">total time</span>

												</div>
											</div>
											<span class="text-center"><?php 
												$d1 = $returnFlightDetail->FlightDate.' '.$returnFlightDetail->DepartureTime;
												$d2 = $returnFlightDetail->FlightDate.' '.$returnFlightDetail->ArrivalTime;
												$datetime1 = new DateTime($d1);
												$datetime2 = new DateTime($d2);
												$interval = $datetime2->diff($datetime1);
												$elapsed = $interval->format('%h Hour, %i minutes');
												echo $elapsed;
												?></span>

											</div>
											<div class="col-md-2 col-sm-2">
												<div class="travel-class">
													<div class="review-tbl-title">
														<div class="icon">
															<i aria-hidden="true" class="fa fa-wheelchair"></i>
														</div>
														<div class="desc">
															<span class="skin-color">Type</span>
														</div>
													</div>

													<span>@if($returnFlightDetail->Refundable == 'T') Refundable @else Non-Refundable @endif</span>
												</div>

											</div>
											<div class="col-md-2 col-sm-2">
												<div class="package-price">
													<div class="review-tbl-title">
														<div class="icon">
															<i aria-hidden="true" class="fa fa-calculator"></i>
														</div>
														<div class="desc">
															<span class="skin-color">Total Price
															</span>
														</div>
													</div>


													<span class="">
														<strong>
														 {{$returnFlightDetail->Currency}} <?php echo custom_number_format(totalPrice($returnFlightDetail->Adult, $returnFlightDetail->Child, $returnFlightDetail->AdultFare, $returnFlightDetail->ChildFare, $returnFlightDetail->ResFare, $returnFlightDetail->FuelSurcharge, $returnFlightDetail->Tax )) ?>
														</strong>
														<small>Baggage Allowance - {{$returnFlightDetail->FreeBaggage}} Included</small>
													</span>
												</div>
											</div>
										</div>
						</article>
						
							@endif

					</div>
					<div class="col-md-3 sidebar-total">
						<div class="grand-total">
							<div class="flight-more-info">
								<ul id="myTab" class="nav nav-tabs hidden-xs" role="tablist">
									<li class="active" role="presentation">
										<a href="#a" aria-controls="home" role="tab" data-toggle="tab">Departure</a>
									</li>
									@if(!empty($returnFlightDetail))
									<li class="" role="presentation">
										<a href="#b" aria-controls="home1" role="tab" data-toggle="tab">Return</a>
									</li>
									@endif
								</ul>
								<div class="tab-content">
									@if(!empty($flightDetail))
									<div id="a" class="tab-pane active" role="tabpanel">
										<h4>Departure Fare Details</h4>
										<div class="btm-block">
											<div class="grand-total-block">
												<h5>Base Fare</h5>
												<table class="table">
													@if($flightDetail->Adult != 0)
													<tr>
														<td>Adult(s) ‎({{$flightDetail->Adult}} X {{custom_number_format($flightDetail->AdultFare)}})‎</td>
														<td>{{custom_number_format($flightDetail->Adult * $flightDetail->AdultFare)}}</td>
													</tr>
													@endif
													@if($flightDetail->Child != 0)
													<tr>
														<td>Child(s) ‎({{$flightDetail->Child}} X {{custom_number_format($flightDetail->ChildFare)}})‎</td>
														<td>{{custom_number_format($flightDetail->Child * $flightDetail->ChildFare)}}</td>
													</tr>
													@endif
												</table>
												<h5>Surcharges :</h5>
												<table class="table">
													@if($flightDetail->Adult != 0)
													<tr>
														<td>Adult(s) ‎({{$flightDetail->Adult}} X {{custom_number_format($flightDetail->FuelSurcharge)}})‎</td>
														<td>{{custom_number_format($flightDetail->Adult * $flightDetail->FuelSurcharge)}}</td>
													</tr>
													@endif
													@if($flightDetail->Child != 0)
													<tr>
														<td>Child(s) ‎({{$flightDetail->Child}} X {{custom_number_format($flightDetail->FuelSurcharge)}})‎</td>
														<td>{{custom_number_format($flightDetail->Child * $flightDetail->FuelSurcharge)}}</td>
													</tr>
													@endif
												</table>
												<h5>Taxes and Fees :</h5>
												<table class="table">
													@if($flightDetail->Adult != 0)
													<tr>
														<td>Adult(s) ‎({{$flightDetail->Adult}} X {{custom_number_format($flightDetail->Tax + $flightDetail->ResFare)}})‎</td>
														<td>{{custom_number_format($flightDetail->Adult * ($flightDetail->Tax + $flightDetail->ResFare))}}</td>
													</tr>
													@endif
													@if($flightDetail->Child != 0)
													<tr>
														<td>Child(s) ‎({{$flightDetail->Child}} X {{custom_number_format($flightDetail->Tax + $flightDetail->ResFare)}})‎</td>
														<td>{{custom_number_format($flightDetail->Child * ($flightDetail->Tax + $flightDetail->ResFare))}}</td>
													</tr>
													@endif
												</table>

												<div class="total-block">
													<h3>Total Amount
													</h3>
												</div>
												<div class="total-block price">
													<h3>{{$flightDetail->Currency}} <?php echo custom_number_format(totalPrice($flightDetail->Adult, $flightDetail->Child, $flightDetail->AdultFare, $flightDetail->ChildFare, $flightDetail->ResFare, $flightDetail->FuelSurcharge, $flightDetail->Tax )) ?></h3>
												</div>

											</div>


										</div>
									</div>
									@endif
									@if(!empty($returnFlightDetail))
									<div id="b" class="tab-pane" role="tabpanel">
										<h4>Return Fare Details</h4>
										<div class="btm-block">
											<div class="grand-total-block">
												<h5>Base Fare</h5>
												<table class="table">
													@if($returnFlightDetail->Adult != 0)
													<tr>
														<td>Adult(s) ‎({{$returnFlightDetail->Adult}} X {{custom_number_format($returnFlightDetail->AdultFare)}})‎</td>
														</td>
														<td>{{custom_number_format($returnFlightDetail->Adult * $returnFlightDetail->AdultFare)}}</td>
													</tr>
													@endif
													@if($returnFlightDetail->Child != 0)
													<tr>
														<td>Child(s) ‎({{$returnFlightDetail->Child}} X {{custom_number_format($returnFlightDetail->ChildFare)}})‎</td>
														<td>{{custom_number_format($returnFlightDetail->Child * $returnFlightDetail->ChildFare)}}</td>
													</tr>
													@endif
												</table>
												<h5>Surcharges :</h5>
												<table class="table">
													@if($returnFlightDetail->Adult != 0)
													<tr>
														<td>Adult(s) ‎({{$returnFlightDetail->Adult}} X {{custom_number_format($returnFlightDetail->FuelSurcharge)}})‎</td>
														<td>{{custom_number_format($returnFlightDetail->Adult * $returnFlightDetail->FuelSurcharge)}}</td>
													</tr>
													@endif
													@if($returnFlightDetail->Child != 0)
													<tr>
														<td>Child(s) ‎({{$returnFlightDetail->Child}} X {{custom_number_format($returnFlightDetail->FuelSurcharge)}})‎</td>
														<td>{{custom_number_format($returnFlightDetail->Child * $returnFlightDetail->FuelSurcharge)}}</td>
													</tr>
													@endif
												</table>
												<h5>Taxes and Fees :</h5>
												<table class="table">
													@if($returnFlightDetail->Adult != 0)
														<tr>
															<td>Adult(s) ‎({{$returnFlightDetail->Adult}} X {{custom_number_format($returnFlightDetail->Tax + $returnFlightDetail->ResFare)}})‎</td>
															<td>{{custom_number_format($returnFlightDetail->Adult * ($returnFlightDetail->Tax + $returnFlightDetail->ResFare))}}</td>
														</tr>
													@endif
													@if($returnFlightDetail->Child != 0)
														<tr>
															<td>Child(s) ‎({{$returnFlightDetail->Child}} X {{custom_number_format($returnFlightDetail->Tax + $returnFlightDetail->ResFare)}})‎</td>
															<td>{{custom_number_format($returnFlightDetail->Child * ($returnFlightDetail->Tax + $returnFlightDetail->ResFare))}}</td>
														</tr>
													@endif
												</table>

												<div class="total-block">
													<h3>Total Amount
													</h3>
												</div>
												<div class="total-block price">
													<h3>{{$returnFlightDetail->Currency}} <?php echo custom_number_format(totalPrice($returnFlightDetail->Adult, $returnFlightDetail->Child, $returnFlightDetail->AdultFare, $returnFlightDetail->ChildFare, $returnFlightDetail->ResFare, $returnFlightDetail->FuelSurcharge, $returnFlightDetail->Tax )) ?></h3>
												</div>

											</div>


										</div>
									</div>
									@endif
								</div>
							</div>
							<!--
							<div class="btm-block">
                                <div class="discount-wrap">
                                    <h3>Apply Discount</h3>
                                    <form action="#">
                                        <div class="input-group">
                                          <input type="text" class="form-control" placeholder="Search for...">
                                          <span class="input-group-btn">
                                            <button class="btn btn-back" type="button">
                                                Apply</button>
                                          </span>
                                        </div>
                                    </form>
                                </div>
                			</div> -->
						</div>

						
					</div>

							
				

				</div>

				<div class="button-groups">
							<div class="row">
								<div class="col-md-12">
								{!! Form::open(['url'=>'/flight/search', 'class' => 'modifyFlightSearchForm'])!!}
													{!!Form::hidden('departure', $departure)!!}
													{!!Form::hidden('arrival', $arrival)!!}
													{!!Form::hidden('adult', $flightDetail->Adult)!!}
													{!!Form::hidden('child', $flightDetail->Child)!!}
													{!!Form::hidden('country', $country)!!}
													{!!Form::hidden('date_depart', $flightDetail->FlightDate)!!}
													@if($trip_type == 'R')
													{!!Form::hidden('date_return', $returnFlightDetail->FlightDate)!!}
													@else
													{!!Form::hidden('date_return', '')!!}
													@endif
													{!!Form::hidden('trip_type', $trip_type)!!}

									<button class="btn btn-back pull-left"><i class="fa fa-angle-left"></i>Back</button>

									{!! Form::close() !!}

									@if(Auth::check())

									{!! Form::open(['url'=>'/flight/passengers']) !!}
										<input type="hidden" name="flightDetail" value='<?php echo json_encode($flightDetail); ?>'>
										@if($trip_type == 'R')
										<input type="hidden" name="returnFlightDetail" value='<?php echo json_encode($returnFlightDetail); ?>'>
										@endif
										<input type="hidden" name="tripType" class="trip-type" value="{{$trip_type}}">
									 	<input type="hidden" name="country" value="{{$country}}">
									 	<input type="hidden" name="departure" value="{{$departure}}">
									 	<input type="hidden" name="arrival" value="{{$arrival}}">
									 	<?php /* ?>
									 	<input type="hidden" name="userId" value="<?php echo Crypt::encrypt(Auth::user()->id) ?>">
									 	<?php */ ?>
										<button class="btn btn-continue pull-right">
											Continue <i class="fa fa-angle-right"></i>
										</button>
									{!! Form::close() !!}

									@else
									<button class="btn btn-continue pull-right" data-toggle="modal" data-target="#login">
										continue <i class="fa fa-angle-right"></i>

									</button>
									@endif
								</div>

								<!-- Modal -->
								<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
									<div class="modal-dialog" role="document">
										<div class="modal-content">

											<div class="modal-body">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<div class="row">
													<div class="col-md-6">
														<div class="login-wrap">


															<h3>Login to upeverst</h3>
															<p>
																Already a member? Log-in to speed up the booking process We will fill in most of the details for you. 
															</p>
															{!! Form::open(['url' =>'/flight/passengers', 'class'=>'registeredUserForm']) !!}
															<input type="hidden" name="_token" value='{{csrf_token()}}' class="token">
																<div class="form-group">
																	<label for="exampleInputEmail1">Email address</label>
																	<input type="email" name="email" class="form-control email" id="exampleInputEmail1" placeholder="Email">
																</div>
																<div class="form-group">
																	<label for="exampleInputPassword1">Password</label>
																	<input type="password" name="password" class="form-control password" id="exampleInputPassword1" placeholder="Password">
																</div>
																
																<input type="hidden" name="flightDetail" value='<?php echo json_encode($flightDetail); ?>'>
																@if($trip_type == 'R')
																<input type="hidden" name="returnFlightDetail" value='<?php echo json_encode($returnFlightDetail); ?>'>
																@endif
																<input type="hidden" name="tripType" class="trip-type" value="{{$trip_type}}">
															 	<input type="hidden" name="country" value="{{$country}}">
															 	<input type="hidden" name="departure" value="{{$departure}}">
															 	<input type="hidden" name="arrival" value="{{$arrival}}">
																<!--
																<div class="checkbox">
																	<label>
																		<input type="checkbox"> Remember me
																	</label>
																</div> -->
																<button type="button" class="btn btn-continue btnTravellerLogin">Login</button>
															{!! Form::close() !!}
														</div>
													</div>
													<div class="col-md-6">
														<div class="guest-wrap">
															<h3>Continue as a guest</h3>
															<p>
																If you do not have a Privilege Club account you can complete the booking as a guest. 
															</p>
															@if($trip_type == 'R')
																{!! Form::open(['url' =>'/flight/passengers']) !!}
																<input type="hidden" name="flightDetail" value='<?php echo json_encode($flightDetail); ?>'>
																<input type="hidden" name="returnFlightDetail" value='<?php echo json_encode($returnFlightDetail); ?>'>
																<input type="hidden" name="tripType" class="trip-type" value="{{$trip_type}}">
															 	<input type="hidden" name="country" value="{{$country}}">
															 	<input type="hidden" name="departure" value="{{$departure}}">
															 	<input type="hidden" name="arrival" value="{{$arrival}}">
																<button class="btn btn-continue">
																	Continue <i class="fa fa-angle-right"></i>
																</button>
																{!! Form::close() !!}
															@else
																{!! Form::open(['url' =>'/flight/passengers']) !!}
																<input type="hidden" name="flightDetail" value='<?php echo json_encode($flightDetail); ?>'>
																<input type="hidden" name="tripType" class="trip-type" value="{{$trip_type}}">
															 	<input type="hidden" name="country" value="{{$country}}">
															 	<input type="hidden" name="departure" value="{{$departure}}">
															 	<input type="hidden" name="arrival" value="{{$arrival}}">
																<button class="btn btn-continue">
																	Continue <i class="fa fa-angle-right"></i>
																</button>
																{!! Form::close() !!}
															@endif
														</div>
													</div>
												</div>
											</div>

										</div>
									</div>
								</div>
							</div>
						</div>
				
			</div>
		</div>
	</div>
</section>


				@endsection