@extends('frontend.layouts.master-new')
@section('title') Choose a Flight | {{ $siteTitle or '' }}@endsection
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
						<li class="is-active">
							<span class="circle">
								<i class="fa fa-check"></i>
							</span>
							<span class="progress-text">Selection</span>
						</li>
						<!-- <li class="is-active"> -->
						<li class="">
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
	<div class="flight-wrapper">
		<div class="flight-search-form modify-search">
			<div class="container">
				<div class="panel">
					<div class="search-form-content pull-left">
						<div class="row">
							<div class="col-md-4 col-sm-4">									
								<h4 class="box-title"><small>@if($trip_type == 'R')Round Trip @else Oneway flight @endif</small>{{$departureFull}} to {{$arrivalFull}}</h4>
								<!-- <div class="stops">1 STOP</div> -->


							</div>
							<div class="col-md-5 col-sm-4">
								<div class="schedule">
									<div class="departure">
										<p class="departure-caption">Departing</p>
										<span class="departure-timings">
												<!-- <span class="date">
													<i class="fa fa-calendar-o"></i>
													27
												</span> -->
												<span class="month">
													<?php if(!empty($date_depart)){
														echo (new DateTime($date_depart))->format('j M Y D') ;
													}?>
													{{-- 27 oct 2016
													thu --}}
												</span>
											</span>
											
										</div>
										<div class="arrival">
											<p class="departure-caption">Returning</p>
											<span class="departure-timings">
												<!-- <span class="date">
													<i class="fa fa-calendar-o"></i>
													27
												</span> -->
												<span class="month">
													<?php if(!empty($date_return)){
														echo (new DateTime($date_return))->format('j M Y D') ;
													}?>
													{{-- 27 oct 2016
													thu --}}
												</span>
											</span>
											
										</div>
									</div>

								</div>
								<div class="col-md-3 col-sm-4">
									<div class="passanger-wrap">
										<div>
											<p>Adult</p>
											<div class="passenger-count">
												<?php 
												$num = $adult;
												$int = (int)$num;
												$num_padded = sprintf("%02d", $num);
												echo $num_padded;
												?>
											</div>
										</div>
										<div>
											<p>Child</p>
											<div class="passenger-count">
												<?php 
												$num = $child;
												$int = (int)$num;
												$num_padded = sprintf("%02d", $num);
												echo $num_padded;
												?>
											</div>

										</div>
										<!-- <div>
											<p>Infant</p>
											<div class="passenger-count">
												<?php 
												$num = $infant;
												$int = (int)$num;
												$num_padded = sprintf("%02d", $num);
												echo $num_padded;
												?>
											</div>
										</div> -->
									</div>
								</div>
							</div>
							

							
						</div>
						<div class="button-right pull-right">
							<button class="btn btn-default btn-block" type="button" data-toggle="collapse" data-target="#modifysearch" aria-expanded="false" aria-controls="collapseExample">
								Modify Search
							</button>
						</div>
						
					</div>
					<div class="collapse" id="modifysearch">
						<div class="well">
							<button id="closepanel" class="btn btn-info closepanel">&times;</button>

							@include('frontend.includes.new.searchformpart')

						</div>
					</div>
				</div>
		</div>

		@if( (!empty($outAvailability)) && (!empty($outAvailability)) )
			<div class="container">
				<!-- <h2>{{$departureFull}} to {{$arrivalFull}}</h3> -->

				<div class="flight-list-block">

					@if(!empty($outAvailability))
					<div id="outbound-flight">
						<h4 class="flight-bound"><i class="fa fa-plane"></i>Departure Flight - {{$departureFull}} to {{$arrivalFull}}
						<span class="pull-right">Please select Departure Flight</span>
						</h4>

						<div class="flight-schedule-slider">

							<div id="owl-demo" class="owl-carousel owl-theme flight-schedule">
							<?php $i=-3; ?>
							@while($i<4)
								<div class="item @if($i == 0) active @endif">
								<?php 
									$date = new DateTime(date('Y-m-d', strtotime($date_depart .' '.$i.' day')));
									$today = new DateTime(date('Y-m-d'));
								 ?>
									<a href="javascript:void(0)" @if($i != 0) class="modifySearchFlight 
																<?php 
																    if($date < $today){
																        echo 'not-active';
																    }
																?>" @endif>
										<?php if(!empty($date_depart)){
											echo $date->format('D') ;
										}?>,
										<span class="thumb-price">
											<?php if(!empty($date_depart)){
												echo $date->format('j M') ;
											}?>
											<span class="year">
												<?php if(!empty($date_depart)){
													echo $date->format('Y') ;
												}?>
											</span>
										</span> 
									</a>
									@if($i != 0)
													{!! Form::open(['url'=>'/flight/search', 'class' => 'display-none modifyFlightSearchForm'])!!}
													{!!Form::hidden('departure', $departure)!!}
													{!!Form::hidden('arrival', $arrival)!!}
													{!!Form::hidden('adult', $adult)!!}
													{!!Form::hidden('child', $child)!!}
													{!!Form::hidden('country', $country)!!}
													{!!Form::hidden('date_depart', $date->format('j-M-Y'))!!}
													{!!Form::hidden('date_return', $date_return)!!}
													{!!Form::hidden('trip_type', $trip_type)!!}

													{!! Form::close() !!}
									@endif
								</div>
								<?php $i++; ?>
								@endwhile
							</div>
						</div>
										<div class="sort-block">
											<div class="row">
												<div class="col-md-2 col-sm-2"> <h5>Sort Result By</h5> </div>
												<div class="col-md-2 col-sm-2">

													<h4 class="filters dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
														<a class="highprice"><span>Price <i class="fa fa-long-arrow-down"></i></span></a>
														<a class="lowprice display-none"><span>Price <i class="fa fa-long-arrow-up"></i></span></a>
													</h4>

												<!--
													<div class="SumoSelect">
														<select class="SlectBox form-control" name="" id="">
															<option>name</option>
															<option>2</option>
															<option>3</option>
															<option>4</option>
															<option>5</option>
														</select>
													</div>
												-->
											</div>
											<div class="col-md-2 col-sm-2">

												<div class="dropdown">
													<h4 class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
														<a class="earlyflight"><span>Time <i class="fa  fa-long-arrow-down"></i></span></a>
														<a class="lateflight hide" ><span>Time <i class="fa  fa-long-arrow-up"></i></span></a>
													</h4>
												</div>
											</div>

												<div class="col-md-2 col-sm-2">
													<h4 class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
														<a class="ascClass"><span>Class <i class="fa fa-long-arrow-down"></i></span></a>
														<a class="descClass display-none"><span>Class <i class="fa fa-long-arrow-up"></i></span></a>
													</h4>
												</div>

												<div class="col-md-2 col-sm-2">
						                            <div class="dropdown">
						                                <h4 class="dropdown-toggle" data-toggle="dropdown"><span>Fare <i class="fa fa-angle-down"></i></span> </h4>
						                                <ul class="dropdown-menu">
						                                    <li><a class="flightfareall">All</a></li>
						                                    <li><a class="flightrefundable">Refundable</a></li>
						                                    <li><a class="flightnonrefundable">Non-Refundable</a></li>
						                                </ul>
						                            </div>
													<!-- <div class="SumoSelect">
														<select class="SlectBox form-control flightFareType" name="" id="">
															<option selected disabled value="">sort by Fare Type</option>
															<option value="all">All</option>
															<option value="refund">Refundable</option>
															<option value="non-refund">Non-Refundable</option>
														</select>
													</div> -->
												</div>
											<!--
												<div class="col-md-2 col-sm-2">
						                            <div class="dropdown">
						                                <h4 class="dropdown-toggle" data-toggle="dropdown"><span>Airlines<i class="fa fa-angle-down"></i></span></h4>
						                                <ul class="dropdown-menu airline-filter">
						                                    <li><a id="airlineall">All Airlines </a></li>
						                                    <li>
						                                        <input id="U4" class="checkbox-custom" data-filter="flightair" type="checkbox">
						                                        <label for="U4" class="checkbox-custom-label">Buddha Airlines</label>
						                                    </li>
						                                    <li>
						                                        <input id="S1" class="checkbox-custom" data-filter="flightair" type="checkbox">
						                                        <label for="S1" class="checkbox-custom-label">Saurya Airlines</label> 
						                                    </li>
						                                    <li>
						                                        <input id="RMK" class="checkbox-custom" data-filter="flightair" type="checkbox">
						                                        <label for="RMK" class="checkbox-custom-label">Simrik Airlines</label>
						                                    </li>
						                                    <li>
						                                        <input id="TA" class="checkbox-custom" data-filter="flightair" type="checkbox">
						                                        <label for="TA" class="checkbox-custom-label">Tara Airlines</label>
						                                    </li>
						                                    <li>
						                                        <input id="YT" class="checkbox-custom" data-filter="flightair" type="checkbox">
						                                        <label for="YT" class="checkbox-custom-label">Yeti Airlines</label>
						                                    </li>
						                                </ul>
						                            </div>
												</div> -->
									
											</div>
										</div>

										<div class="departureFlight">
											<div class="searchWrapper">
												@foreach($outAvailability as $avail)

												<article class="box-flight oneway-flight" data-price="<?php echo totalPrice($avail->Adult, $avail->Child, $avail->AdultFare, $avail->ChildFare, $avail->ResFare, $avail->FuelSurcharge, $avail->Tax ) ?>" data-class="{{$avail->FlightClassCode}}" data-time ="<?php echo strtotime(($avail->FlightDate.' '. $avail->DepartureTime)) ?>" data-fare="{{$avail->Refundable}}" data-airlines="{{$avail->Airline}}">

											<!-- 	<figure class="col-md-2 col-sm-2">
					                                <span class="airlines-thumb" style="background-image:url({{$avail->AirlineLogo}});"></span>
					                            </figure> -->
					                            <div class="details">
					                            	<div class="details-wrapper">
					                            		<div class="first-row row-fluid">

					                            			<div class="col-md-8 col-sm-8 col-xs-12">
					                            				<img src="{{$avail->AirlineLogo}}" alt="">
					                            				<h4 class="box-title"><?php echo airlinesName($avail->Airline); ?> ({{$avail->FlightNo}})</h4>
					                            				<!-- <a class="badge">1 STOP</a> --><a class="badge">Class {{$avail->FlightClassCode}}</a>
					                            				

					                            			</div>
					                            			<div class="col-md-2 col-sm-2">
					                            				<span class="fare-type">
					                            					Fare Type : @if($avail->Refundable == 'T') Refundable @else Non-Refundable @endif
					                            				</span>
					                            				<span class="baggage">
					                            					Baggage : @if(!empty($avail->FreeBaggage)) {{$avail->FreeBaggage}} @endif
					                            				</span>
					                            			</div>
					                            			<div class="col-md-2 col-sm-2 col-xs-12">
					                            				<span class="price"><small>Total</small>
					                            					{{$avail->Currency}} <?php echo custom_number_format(totalPrice($avail->Adult, $avail->Child, $avail->AdultFare, $avail->ChildFare, $avail->ResFare, $avail->FuelSurcharge, $avail->Tax ),2) ?>
					                            				</span>
					                            			</div>
					                            		</div>
					                            		<div class="second-row row-fluid">
					                            			<div class="col-md-10 col-sm-10">
					                            				<div class="row-fluid time">
					                                    			<div class="col-md-12">
					                                    				<h5><i class="fa fa-plane"></i>{{ucfirst(strtolower($avail->Departure))}} <i class="fa fa-long-arrow-right"></i>{{ucfirst(strtolower($avail->Arrival))}}</h5>
					                                    				<div class="short-desc">
																			<span class="depart-date">
																				{{$avail->DepartureTime}}
																				 <small><?php echo (new DateTime($avail->FlightDate))->format('j M Y') ?></small>
																			</span>
																			<span class="distance-line">
																				<span class="distance-time"><i class="fa fa-clock-o"></i>
																				<?php 
					                            								$d1 = $avail->FlightDate.' '.$avail->DepartureTime;
					                            								$d2 = $avail->FlightDate.' '.$avail->ArrivalTime;
					                            								$datetime1 = new DateTime($d1);
					                            								$datetime2 = new DateTime($d2);
					                            								$interval = $datetime2->diff($datetime1);
					                            								$elapsed = $interval->format('%h hr %i min');
					                            								echo $elapsed;
					                            								?>
					                            								</span>
																				<span class="flight-name">{{$avail->FlightNo}}</span>
																			</span>
																			<span class="arv-date">
																				{{$avail->ArrivalTime}}
																				<small><?php echo (new DateTime($avail->FlightDate))->format('j M Y') ?></small>
																			</span>
					                                    				</div>
					                                    			</div>
					                                    			
					                                    		</div>
					                                    		<?php /* ?>
					                            				<div class="time row-fluid">
					                            					<div class="take-off col-sm-4">
					                            						<div class="icon">
					                            							<i class="fa fa-plane" aria-hidden="true"></i>
					                            						</div>
					                            						<div class="desc">
					                            							<span class="skin-color">{{ucfirst(strtolower($avail->Departure))}}</span>
					                            							<span><span class="time-head">{{$avail->DepartureTime}}</span><?php echo (new DateTime($avail->FlightDate))->format('j M Y') ?></span>
					                            							<!-- <span>Indianapolis</span> -->

					                            						</div>
					                            					</div>
					                            					<div class="landing col-sm-4">
					                            						<div class="icon">
					                            							<i class="fa fa-plane" aria-hidden="true"></i>
					                            						</div>
					                            						<div class="desc">
					                            							<span class="skin-color">{{ucfirst(strtolower($avail->Arrival))}}</span>
					                            							<span><span class="time-head">{{$avail->ArrivalTime}}</span><?php echo (new DateTime($avail->FlightDate))->format('j M Y') ?></span>
					                            							<!-- <span>Paris</span> -->
					                            						</div>
					                            					</div>
					                            					<div class="total-time col-sm-4">
					                            						<div class="icon">
					                            							<i class="fa fa-clock-o"></i></div>
					                            							<div class="desc">
					                            								<span class="skin-color">total time</span><br>
					                            								<?php 
					                            								$d1 = $avail->FlightDate.' '.$avail->DepartureTime;
					                            								$d2 = $avail->FlightDate.' '.$avail->ArrivalTime;
					                            								$datetime1 = new DateTime($d1);
					                            								$datetime2 = new DateTime($d2);
					                            								$interval = $datetime2->diff($datetime1);
					                            								$elapsed = $interval->format('%h hour %i minutes');
					                            								echo $elapsed;
					                            								?>
					                            							</div>
					                            						</div>
					                            						
					                            				</div> <?php */ ?>

					                                     </div>
					                                     <div class="col-md-2 col-sm-2">
					                                     	<div class="action" data-img=
					                                     	"{{url('/images/new/tick.png')}}" data-flight-id="{{$avail->FlightId}}" data-flight='<?php echo json_encode($avail); ?>'>
					                                     	<a href="javascript:void(0)" class="btn btn-danger btn-block btn-sm out-btn">Select</a>
					                                     </div>

					                                 </div>
					                             </div>
					                         </div>
					                     </div>

					                 </article>               
					                 @endforeach
					             </div>
					         </div>
					     </div>
					     @endif


					     @if(!empty($inAvailability))
					     <div id="inbound-flight">
					     	<h4 class="flight-bound"><i class="fa fa-plane"></i>Return Flight - {{$arrivalFull}} to {{$departureFull}}
					     		<span class="pull-right">Please select Returning Flight</span>
					     	</h4>

					     	<div class="flight-schedule-slider">

					     		<div id="owl-demo" class="owl-carousel owl-theme flight-schedule">
							<?php $i=-3; ?>
							@while($i<4)
								<div class="item @if($i == 0) active @endif">
								<?php 
									$date = new DateTime(date('Y-m-d', strtotime($date_return .' '.$i.' day')));
									$today = new DateTime(date('Y-m-d'));
								 ?>
									<a href="javascript:void(0)" @if($i != 0) class="modifySearchFlight 
																<?php 
																    if($date < $today){
																        echo 'not-active';
																    }
																?>" @endif>
										<?php if(!empty($date_return)){
											echo $date->format('D') ;
										}?>,
										<span class="thumb-price">
											<?php if(!empty($date_return)){
												echo $date->format('j M') ;
											}?>
											<span class="year">
												<?php if(!empty($date_return)){
													echo $date->format('Y') ;
												}?>
											</span>
										</span> 
									</a>
									@if($i != 0)
													{!! Form::open(['url'=>'/flight/search', 'class' => 'display-none modifyFlightSearchForm'])!!}
													{!!Form::hidden('departure', $departure)!!}
													{!!Form::hidden('arrival', $arrival)!!}
													{!!Form::hidden('adult', $adult)!!}
													{!!Form::hidden('child', $child)!!}
													{!!Form::hidden('country', $country)!!}
													{!!Form::hidden('date_depart', $date_depart)!!}
													{!!Form::hidden('date_return', $date->format('j-M-Y'))!!}
													{!!Form::hidden('trip_type', $trip_type)!!}

													{!! Form::close() !!}
									@endif
								</div>
								<?php $i++; ?>
								@endwhile

											</div>
										</div>
										<div class="sort-block">
											<div class="row">
												<div class="col-md-2 col-sm-2"> <h5>Sort Result By</h5> </div>
												<div class="col-md-2 col-sm-2">

													<h4 class="filters dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
														<a class="returnHighprice"><span>Price <i class="fa fa-long-arrow-down"></i></span></a>
														<a class="returnLowprice display-none"><span>Price <i class="fa fa-long-arrow-up"></i></span></a>
													</h4>

												<!--
													<div class="SumoSelect">
														<select class="SlectBox form-control" name="" id="">
															<option>name</option>
															<option>2</option>
															<option>3</option>
															<option>4</option>
															<option>5</option>
														</select>
													</div>
												-->
											</div>
											<div class="col-md-2 col-sm-2">

												<div class="dropdown">
													<h4 class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
														<a class="returnEarlyflight"><span>Time <i class="fa  fa-long-arrow-down"></i></span></a>
														<a class="returnLateflight hide" ><span>Time <i class="fa  fa-long-arrow-up"></i></span></a>
													</h4>
												</div>

												<?php /* ?>
													<div class="SumoSelect">
														<select class="SlectBox form-control sortByPrice" name="" id="" >
															<option selected disabled value="">sort by price</option>
															<option value="asc">asc</option>
															<option value="desc">desc</option>
														</select>
													</div>
													<?php */ ?>
												</div>

												<div class="col-md-2 col-sm-2">
													<h4 class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
														<a class="returnAscClass"><span>Class <i class="fa fa-long-arrow-down"></i></span></a>
														<a class="returnDescClass display-none"><span>Class <i class="fa fa-long-arrow-up"></i></span></a>
													</h4>
												</div>

												<div class="col-md-2 col-sm-2">
						                            <div class="dropdown">
						                                <h4 class="dropdown-toggle" data-toggle="dropdown"><span>Fare <i class="fa fa-angle-down"></i></span> </h4>
						                                <ul class="dropdown-menu">
						                                    <li><a class="returnflightfareall">All</a></li>
						                                    <li><a class="returnflightrefundable">Refundable</a></li>
						                                    <li><a class="returnflightnonrefundable">Non-Refundable</a></li>
						                                </ul>
						                            </div>
												</div>
												<!--
												<div class="col-md-2 col-sm-2">
						                            <div class="dropdown">
						                                <h4 class="dropdown-toggle" data-toggle="dropdown"><span>Airlines<i class="fa fa-angle-down"></i></span></h4>

						                                <ul class="dropdown-menu return-airline-filter">
						                                    <li><a id="airlineall">All Airlines </a></li>
						                                    <li>
						                                        <input id="returnU4" class="checkbox-custom" data-filter="flightair" type="checkbox">
						                                        <label for="returnU4" class="checkbox-custom-label">Buddha Airlines</label>
						                                    </li>
						                                    <li>
						                                        <input id="returnS1" class="checkbox-custom" data-filter="flightair" type="checkbox">
						                                        <label for="returnS1" class="checkbox-custom-label">Saurya Airlines</label> 
						                                    </li>
						                                    <li>
						                                        <input id="returnRMK" class="checkbox-custom" data-filter="flightair" type="checkbox">
						                                        <label for="returnRMK" class="checkbox-custom-label">Simrik Airlines</label>
						                                    </li>
						                                    <li>
						                                        <input id="returnTA" class="checkbox-custom" data-filter="flightair" type="checkbox">
						                                        <label for="returnTA" class="checkbox-custom-label">Tara Airlines</label>
						                                    </li>
						                                    <li>
						                                        <input id="returnYT" class="checkbox-custom" data-filter="flightair" type="checkbox">
						                                        <label for="returnYT" class="checkbox-custom-label">Yeti Airlines</label>
						                                    </li>
						                                </ul>
						                            </div>
												</div>  -->
												
											</div>
										</div>

										<div class="returnFlight">
											<div class="returnSearchWrapper">
												@foreach($inAvailability as $avail)
												<article class="box-flight oneway-flight" data-price="<?php echo totalPrice($avail->Adult, $avail->Child, $avail->AdultFare, $avail->ChildFare, $avail->ResFare, $avail->FuelSurcharge, $avail->Tax ) ?>" data-class="{{$avail->FlightClassCode}}" data-time ="<?php echo strtotime(($avail->FlightDate.' '. $avail->DepartureTime)) ?>" data-fare="{{$avail->Refundable}}">

											<!-- 	<figure class="col-md-2 col-sm-2">
					                                <span class="airlines-thumb" style="background-image:url({{$avail->AirlineLogo}});"><!-- <img width="94" height="90" alt="" src="images/buddha-air-logo.png"> </span>
					                            </figure> -->
					                            <div class="details">
					                            	<div class="details-wrapper">
					                            		<div class="first-row row-fluid">
					                            			<div class="col-md-8 col-sm-8 col-xs-12">
					                            				<img src="{{$avail->AirlineLogo}}" alt="">
					                            				<h4 class="box-title"><?php echo airlinesName($avail->Airline); ?> ({{$avail->FlightNo}})</h4>
					                            				<!-- <a class="badge">1 STOP</a> --><a class="badge">Class {{$avail->FlightClassCode}}</a>
					                            			</div>
					                            			<div class="col-md-2 col-sm-2">
					                            				<span class="fare-type">
					                            					Fare Type : @if($avail->Refundable == 'T') Refundable @else Non-Refundable @endif
					                            				</span>
					                            				<span class="baggage">
					                            					Baggage : @if(!empty($avail->FreeBaggage)) {{$avail->FreeBaggage}} @endif
					                            				</span>
					                            			</div>
					                            			<div class="col-md-2 col-sm-2 col-xs-12">
					                            				<span class="price"><small>Total</small>
					                            					{{$avail->Currency}} <?php echo custom_number_format(totalPrice($avail->Adult, $avail->Child, $avail->AdultFare, $avail->ChildFare, $avail->ResFare, $avail->FuelSurcharge, $avail->Tax ), 2) ?>
					                            				</span>
					                            			</div>
					                            		</div>
					                            		<div class="second-row row-fluid">
					                            			<div class="col-md-10 col-sm-10">

					                            				<div class="row-fluid time">
					                                    			<div class="col-md-12">
					                                    				<h5><i class="fa fa-plane"></i>{{ucfirst(strtolower($avail->Arrival))}} <i class="fa fa-long-arrow-left"></i>{{ucfirst(strtolower($avail->Departure))}}</h5>
					                                    				<div class="short-desc">
																			<span class="depart-date">
																				{{$avail->ArrivalTime}}
																				 <small><?php echo (new DateTime($avail->FlightDate))->format('j M Y') ?></small>
																			</span>
																			<span class="distance-line">
																				<span class="distance-time"><i class="fa fa-clock-o"></i>
																				<?php 
					                            								$d1 = $avail->FlightDate.' '.$avail->DepartureTime;
					                            								$d2 = $avail->FlightDate.' '.$avail->ArrivalTime;
					                            								$datetime1 = new DateTime($d1);
					                            								$datetime2 = new DateTime($d2);
					                            								$interval = $datetime2->diff($datetime1);
					                            								$elapsed = $interval->format('%h hr %i min');
					                            								echo $elapsed;
					                            								?>
					                            								</span>
																				<span class="flight-name">{{$avail->FlightNo}}</span>
																			</span>
																			<span class="arv-date">
																				{{$avail->DepartureTime}}
																				<small><?php echo (new DateTime($avail->FlightDate))->format('j M Y') ?></small>
																			</span>
					                                    				</div>
					                                    			</div>
					                                    			
					                                    		</div>
					                                    	<?php /* ?>
					                            				<div class="time row-fluid">
					                            					<div class="take-off col-sm-4">
					                            						<div class="icon">
					                            							<i class="fa fa-plane" aria-hidden="true"></i>
					                            						</div>
					                            						<div class="desc">
					                            							<span class="skin-color">{{$avail->Departure}}</span>
					                            							<span><span class="time-head">{{$avail->DepartureTime}}</span><?php echo (new DateTime($avail->FlightDate))->format('j M Y') ?></span>
					                            							<!-- <span>Indianapolis</span> -->

					                            						</div>
					                            					</div>
					                            					<div class="landing col-sm-4">
					                            						<div class="icon">
					                            							<i class="fa fa-plane" aria-hidden="true"></i>
					                            						</div>
					                            						<div class="desc">
					                            							<span class="skin-color">{{$avail->Arrival}}</span>
					                            							<span><span class="time-head">{{$avail->ArrivalTime}}</span><?php echo (new DateTime($avail->FlightDate))->format('j M Y') ?></span>
					                            							<!-- <span>Paris</span> -->
					                            						</div>
					                            					</div>
					                            					<div class="total-time col-sm-4">
					                            						<div class="icon">
					                            							<i class="fa fa-clock-o"></i></div>
					                            							<div class="desc">
					                            								<span class="skin-color">total time</span><br>
					                            								<?php 
					                            								$d1 = $avail->FlightDate.' '.$avail->DepartureTime;
					                            								$d2 = $avail->FlightDate.' '.$avail->ArrivalTime;
					                            								$datetime1 = new DateTime($d1);
					                            								$datetime2 = new DateTime($d2);
					                            								$interval = $datetime2->diff($datetime1);
					                            								$elapsed = $interval->format('%h hours %i minutes');
					                            								echo $elapsed;
					                            								?>
					                            							</div>
					                            						</div>
					                            					</div>
					                            					<?php */ ?>
					                                     	<!-- <div class="first-desc">
					                                     		<div class="first-desc-wrap">
					                                     			<div class="destination-wrap">
						                                     			<div>Indianapolis</div>
						                                     			<div><i class="fa fa-long-arrow-right"></i></div>
						                                     			<div>Paris</div>
						                                     		</div>
						                                     		<div class="time-info">
						                                     			<div>19:25</div>
						                                     			<div>13hrs 40min</div>
						                                     			<div>16:25</div>
						                                     		</div>
					                                     		</div>
					                                     	</div> -->

					                                     </div>
					                                     <div class="col-md-2 col-sm-2">
					                                     	<div class="action" data-img=
					                                     	"{{url('/images/new/tick.png')}}" data-return-flight-id="{{$avail->FlightId}}" data-return-flight='<?php echo json_encode($avail); ?>'>
					                                     	<a href="javascript:void(0)" class="btn btn-danger btn-block btn-sm in-btn">Select</a>
					                                     </div>

					                                 </div>
					                             </div>
					                         </div>
					                     </div>

					                 </article>               
					                 @endforeach
					             </div>
					         </div>
					     </div>
					     @endif
					 </div>

					 @if($trip_type == "R")
					 <form action="{{url('/flight/review')}}" method="post" class="flightSelectFormR">
					 	<input type="hidden" name="_token" value="{{csrf_token()}}" class="token">
					 	<input type="hidden" name="flightId" class="flight-id">
					 	<input type="hidden" name="flightDetail" class="flight-detail">
					 	<input type="hidden" name="returnFlightId" class="return-flight-id">
					 	<input type="hidden" name="returnFlightDetail" class="return-flight-detail">
					 	<input type="hidden" name="tripType" class="trip-type" value="{{$trip_type}}">
					 	<input type="hidden" name="country" value="{{$country}}">
					 	<input type="hidden" name="departure" value="{{$departure}}">
					 	<input type="hidden" name="arrival" value="{{$arrival}}">
					 	<button class="btn btn-next flightSelectForm-btn" disabled>Continue</button>
					 </form>
					 @else
					 <form action="{{url('/flight/review')}}" method="post" class="flightSelectFormO">
					 	<input type="hidden" name="_token" value="{{csrf_token()}}" class="token">
					 	<input type="hidden" name="flightId" class="flight-id">
					 	<input type="hidden" name="flightDetail" class="flight-detail">
					 	<input type="hidden" name="tripType" class="trip-type" value="{{$trip_type}}">
					 	<input type="hidden" name="country" value="{{$country}}">
					 	<input type="hidden" name="departure" value="{{$departure}}">
					 	<input type="hidden" name="arrival" value="{{$arrival}}">
					 	<button class="btn btn-next flightSelectForm-btn" disabled>Continue</button>
					 </form>
					 @endif





			</div>
		@else
		<div class="noResult">
			<div class="container">
			<p>No result found.. Please modify your search</p>
			</div>
		</div>
		<script type="text/javascript">
		$(document).ready(function(){
			$('#modifysearch').addClass('in');
		});
		</script>

		@endif


				</div>
		</section>


		@endsection