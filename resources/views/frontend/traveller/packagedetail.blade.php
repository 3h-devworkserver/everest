@extends('frontend.layouts.master-new')

@section('title'){{ $meta_title or '' }}@endsection
@section('meta_title'){{ $meta_title or '' }}@endsection
@section('meta_keywords'){{ $meta_keywords or '' }}@endsection
@section('meta_desc'){{ $meta_desc or '' }}@endsection
@section('content')

<div class="main-content">
	<div class="container">
		<div class="travel-booking booking-views">
			
			<div class="row">
				<div class="col-md-8 col-sm-8" id="traveller-info">
					<div class="page-header bold_page-header">
						<h2>{{$package->title}} BOOKING</h2>
					</div>
					
					<div class="booking-summary">
						<div class="well">							
							
							<h2>Booking Overview</h2>

							<div class="trip-block trip-details">
								<h3>Trip Details</h3>
								<?php 
								$date = $dPrice->daterange;
								$pieces = explode("-", $date);
								?>
								<dl class="dl-horizontal">
									<dt>Package Name</dt>
									<dd>{{$package->title}}</dd>
									<dt>Departure Date</dt>
									<dd>{{$pieces[0]}}</dd>
									<dt>Return Date</dt>
									<dd>{{$pieces[1]}}</dd>
										  {{-- <dt>Duration</dt>
										  <dd>15days</dd> --}}
										  {{-- <dt>Flights</dt>
										  <dd>Trips includes flights which are subject to availability</dd> --}}
										</dl>

									</div>
									@if(count($package->optionsAccomodation) != 0)
									<div class="trip-block trip-accomodation">
										<h3>Accommodation</h3>
										<h4>{{$package->optionsAccomodation[0]->name}}</h4>
										{!! $package->optionsAccomodation[0]->content !!}
									{{-- <p> This tour spends 3 nights in standard hotels and 12 nights in mountain lodges (teahouses).</p>

									<p>Most lodges now have twin-bedded rooms but you should still be prepared to sleep in multi-bedded rooms on the occasional night. In the last decade the quality of the lodges and the food has improved significantly, but you should expect fairly basic accommodation at the highest points of the trek. Some lodges now have showers (charged at £2-£4 per shower) and all have basic toilets. </p> --}}
								</div>
								@endif
								<div class="trip-block trip-cost">
									<h3>Trip Cost Breakdown</h3>
									<dl class="dl-horizontal">
										<dt>Base Price</dt>
										<dd>USD {{ $packageBooking->main_package_amount}}</dd>

									</dl>
									
								</div>
								<div class="trip-block trip-payment-options">
									<h3>Payment Options</h3>
									<dl class="dl-horizontal">
										<dt>Total Amount</dt>
										<dd>USD {{$packageBooking->total_amount}}</dd>									
									</dl>

								</div>
								<div class="trip-block travellers-detail">
									<h3>Travellers detail</h3>
									<table class="table">
										<tr>
											<th>Travellers Name</th>
											<th>Document Number</th>
											<th>DOB</th>
										</tr>
										
										<?php $y = 0; ?>
										@while($y < $packageBooking->total_person)
											@if($y == 0)
											<tr>
												<td>{{$mainTraveller->profile->title}}. {{$mainTraveller->profile->fname}} {{$mainTraveller->profile->mname}} {{$mainTraveller->profile->lname}}</td>
												<td>{{$mainTraveller->profile->document_no}}</td>
												<td>{{$mainTraveller->profile->dob_year}}-{{$mainTraveller->profile->dob_month}}-{{$mainTraveller->profile->dob_day}}</td>
											</tr>
											@else
											<tr>
												<td>{{$mainTraveller->otherTravellers[$y-1]->profile->title}}. {{$mainTraveller->otherTravellers[$y-1]->profile->fname}} {{$mainTraveller->otherTravellers[$y-1]->profile->mname}} {{$mainTraveller->otherTravellers[$y-1]->profile->lname}}</td>
												<td>{{$mainTraveller->otherTravellers[$y-1]->profile->document_no}}</td>
												<td>{{$mainTraveller->otherTravellers[$y-1]->profile->dob_year}}-{{$mainTraveller->otherTravellers[$y-1]->profile->dob_month}}-{{$mainTraveller->otherTravellers[$y-1]->profile->dob_day}}</td>
											</tr>
											@endif
										<?php $y++; ?>
										@endwhile
									</table>
								</div>

								<div class="trip-block emergency-contact">
									<h3>Emergency Contact Detail</h3>	
									<dl class="dl-horizontal">
										<dt>Full Name</dt>
										<dd>{{$mainTraveller->profile->em_fname}} {{$mainTraveller->profile->em_mname}} {{$mainTraveller->profile->em_lname}}</dd>
										<dt>Phone Number</dt>
										<dd >{{$mainTraveller->profile->em_phone}}</dd>
									</dl>									
								</div>
								<div class="trip-block correspondence-contact">
									<h3>Correspondence Address</h3>
									<dl class="dl-horizontal">
										<dt>Your Detail</dt>
										<dd>{{$mainTraveller->profile->address}}, {{$mainTraveller->profile->city}} {{$mainTraveller->profile->postal_zip}}, {{$mainTraveller->profile->country}}</dd>
									</dl>	
								</div>
								
							</div>
						</div>
					</div>
					<div class="col-md-4 col-sm-4">
						<div class="sidebar-travel">
							<div class="total-block">
								<h2 class="block-title">Booking Summary</h2>

								<div class="trip-more-info-block summary">

									<div class="trip-more-info-list">
										<div class="info-title sub-heading-title when">When: </div>
										<div class="info-description">{{$dPrice->daterange}}</div>
									</div>
									<div class="trip-more-info-list">
										<div class="info-title sub-heading-title when">Traveller: </div>
										<div class="info-description" id="traveller">

											<?php $y = 0; ?>
											@while($y < $packageBooking->total_person)
												@if($y == 0)
												<p>{{$mainTraveller->profile->title}}. {{$mainTraveller->profile->fname}} {{$mainTraveller->profile->mname}} {{$mainTraveller->profile->lname}}</p>
												@else
												<p>{{$mainTraveller->otherTravellers[$y-1]->profile->title}}. {{$mainTraveller->otherTravellers[$y-1]->profile->fname}} {{$mainTraveller->otherTravellers[$y-1]->profile->mname}} {{$mainTraveller->otherTravellers[$y-1]->profile->lname}}</p>
												@endif
											<?php $y++; ?>
											@endwhile
										</div>
									</div>

											<div class="total-price-details-box">
												<div class="clearfix sub-heading-title">
													<div class="label-text total-passenger-price pull-left">Total Tour Cost</div>
													<div class="content-text total-passenger-price pull-right">USD {{$packageBooking->main_package_amount}}</div>
												</div>
											</div>
											@if(!empty($packageBooking->addon_selected))
											<?php 
												$selectedAddon = explode(',', $packageBooking->addon_packages_detail);
		                                        
											?>
											<div class="total-price-details-box  exten-text">
												<div class="clearfix sub-heading-title">
													<div class="label-text total-passenger-price ">Extension Packages</div>
													<div class="content-text total-passenger-price pull-right ext hide" extprice="0" ></div>
													<div class="extension">
														@foreach($selectedAddon as $string)
														<?php $selectedAddonDetail = explode('-', $string); ?>
														<div class="clearfix">
															<div class="ext-text pull-left">
																<?php 
																	$title = DB::table('packages')->where('id', $selectedAddonDetail[0])->value('title');
																?>
																<p>{{$title}}<br><small>(@if($selectedAddonDetail[1] == 1){{$selectedAddonDetail[1]}} Person @else {{$selectedAddonDetail[1]}} Persons @endif)</small>
																</p>
															</div>
															<div class="content-text total-passenger-price ext pull-right">
															USD {{$selectedAddonDetail[2]}}
															</div>
														</div>
														@endforeach
													</div>
												</div>
											</div>
											@endif

											<div class="total-footer">
												<div class="clearfix sub-heading-title">
													<div class="label-text total-passenger-price pull-left">
														<h3>Total 
															<small>Tax Included</small></h3>
														</div>
														<?php /* ?>
														<div class="content-text total-passenger-price pull-right"><span id = "total">USD {{ count($travellers) * $dPrice->price}}</span></div>
														<?php */ ?>
														<div class="content-text total-passenger-price pull-right"><span id = "total">USD {{$packageBooking->total_amount}}</span></div>
													</div>


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