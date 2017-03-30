@extends('frontend.layouts.master-new')
@section('title') Flight Review | {{ $siteTitle or '' }}@endsection
@section('meta_keywords'){{ $meta_keywords or '' }}@endsection
@section('meta_desc'){{ $meta_desc or '' }}@endsection

@section('content')

	@include('frontend.includes.new.functions')

	<section class="main-content">
		
		<div class="flight-wrapper flight-review">
			<div class="container">
				<div class="flight-list-block">

					<div class="row">
						<div class="col-md-9">

							@if(!empty($flightDetail))
								<div class="flight-review-header">
									<div class="row">
										<div class="first-row">
											<div class="col-md-1 col-sm-2 col-xs-3">
												<figure>
													<img src="{{$flightDetail->AirlineLogo}}" alt="">
												</figure>
											</div>
											<div class="col-md-8 col-sm-7 mobile-mode col-xs-9">
												<h4 class="box-title"><?php echo airlinesName($flightDetail->Airline); ?> ({{$flightDetail->FlightNo}})<small>Departure flight</small></h4>
												<span class="badge">Class {{$flightDetail->FlightClassCode}}</span>
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
											<div class="col-md-1 col-sm-2 col-xs-3">
												<figure>
													<img src="{{$returnFlightDetail->AirlineLogo}}" alt="">
												</figure>
											</div>
											<div class="col-md-8 col-sm-7 mobile-mode col-xs-9">
												<h4 class="box-title"><?php echo airlinesName($returnFlightDetail->Airline); ?> ({{$returnFlightDetail->FlightNo}})<small>Return flight</small></h4>
												<span class="badge">Class {{$returnFlightDetail->FlightClassCode}}</span>
											</div>
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
													?>
												</span>

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

				</div>
			</div>
		</div>
	</section>


@endsection