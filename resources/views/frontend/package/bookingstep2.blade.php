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
						{{-- <a href="{{url('package/'.$slug.'/'.$datePrice.'/'.$travellers[0]->group_id.'/booking-step1')}}" >Step 1 - Travellers </a> --}}
						<a href="{{url('/package/'.$slug.'/'.$datePrice.'/booking-step1/edit')}}" >Step 1 - Travellers </a>
						<a href="#" class="active">Step 2 - Summary  </a>
						<a href="#">Step 3 -  Confirm </a>
					</div>
				</div>
			</div>
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
										<dd>USD {{ count($data->fname) * $dPrice->price}}</dd>

									</dl>
									
								</div>
								<div class="trip-block trip-payment-options">
									<h3>Payment Options</h3>
									<dl class="dl-horizontal">

										{{-- <dt>Minimun Deposit</dt>
										<dd >USD {{ (count($data->fname) * $dPrice->price) * (25/100)}}</dd> --}}
										<dt>Total Amount</dt>
										<dd>USD {{$data->total_amount}}</dd>									
									</dl>

								</div>
								<div class="trip-block travellers-detail">
									<h3>Travellers detail</h3>
									<table class="table">
										<tr>
											<th>Travellers Name</th>
											<th>Passport Number</th>
											<th>DOB</th>
											<!-- <th>Insurance</th>-->
											<!-- <th>Single Suppliment</th>-->
										</tr>

										<?php /* ?>
										@foreach($travellers as $traveller)
										<tr>
											<td>{{$traveller->title}}. {{$traveller->fname}} {{$traveller->mname}} {{$traveller->lname}}</td>
											<td>{{$traveller->passport}}</td>
											<td>{{$traveller->dob_year}}-{{$traveller->dob_month}}-{{$traveller->dob_day}}</td>
										</tr>
										@endforeach
										<?php */ ?>
										
										<?php $y = 0; ?>
										@while($y < count($data->fname))
										<tr>
											<td>{{$data->title[$y]}}. {{$data->fname[$y]}} {{$data->mname[$y]}} {{$data->lname[$y]}}</td>
											<td>{{$data->passport[$y]}}</td>
											<td>{{$data->dob_year[$y]}}-{{$data->dob_month[$y]}}-{{$data->dob_day[$y]}}</td>
										</tr>
										<?php $y++; ?>
										@endwhile
									</table>
								</div>

								<?php /* ?>
								<div class="trip-block emergency-contact">
									<h3>Emergency Contact Detail</h3>	
									<dl class="dl-horizontal">
										<dt>Full Name</dt>
										<dd>{{$travellers[0]->em_fname}} {{$travellers[0]->em_mname}} {{$travellers[0]->em_lname}}</dd>
										<dt>Phone Number</dt>
										<dd >{{$travellers[0]->em_phone}}</dd>
									</dl>									
								</div>
								<?php */ ?>

								<div class="trip-block emergency-contact">
									<h3>Emergency Contact Detail</h3>	
									<dl class="dl-horizontal">
										<dt>Full Name</dt>
										<dd>{{$data->em_fname[0]}} {{$data->em_mname[0]}} {{$data->em_lname[0]}}</dd>
										<dt>Phone Number</dt>
										<dd >{{$data->em_phone[0]}}</dd>
									</dl>									
								</div>
								
								<?php /* ?>
								<div class="trip-block correspondence-contact">
									<h3>Correspondence Address</h3>
									<dl class="dl-horizontal">
										<dt>Your Detail</dt>
										<dd>{{$travellers[0]->address}}, {{$travellers[0]->city}} {{$travellers[0]->postal_zip}}, {{$travellers[0]->country}}</dd>
									</dl>	
								</div>
								<?php */  ?>
								<div class="trip-block correspondence-contact">
									<h3>Correspondence Address</h3>
									<dl class="dl-horizontal">
										<dt>Your Detail</dt>
										<dd>{{$data->address[0]}}, {{$data->city[0]}} {{$data->postal_zip[0]}}, {{$data->country[0]}}</dd>
									</dl>	
								</div>
								
								<div class="trip-block terms-conditions">
									<h3>Terms &amp; Conditions</h3>

									{!! Form::open(['url'=>'package/'.$slug.'/'.$datePrice.'/booking-step3', 'id'=>'booking-2']) !!}		
									<div class="checkbox">
										<label>
											<input type="checkbox" name="condition">I have read, understood and accepted the booking <a href="#">terms and conditions</a>
										</label>
									</div>
									
									<?php /* ?>
									<input type="hidden" name="group_id" value="{{$groupId}}">
									<?php */ ?>

									{!! Form::close() !!}
								</div>

							</div>

							<div class="button-div">
							
								<a href="{{url('/package/'.$slug.'/'.$datePrice.'/booking-step1/edit')}}" class="btn btn-danger pull-left">Back to Step 1</a>
								<a id="summary-continue" class="btn btn-danger pull-right">Continue</a>
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
											<?php /* ?>
											@foreach($travellers as $traveller)
											{{$traveller->title}}. {{$traveller->fname}} {{$traveller->mname}} {{$traveller->lname}}<p>
											@endforeach
											<?php */ ?>

											<?php $y = 0; ?>
											@while($y < count($data->fname))
											<p>{{$data->title[$y]}}. {{$data->fname[$y]}} {{$data->mname[$y]}} {{$data->lname[$y]}}</p>
											<?php $y++; ?>
											@endwhile
										</div>
									</div>

											<div class="total-price-details-box">
												<div class="clearfix sub-heading-title">
													<div class="label-text total-passenger-price pull-left">Total Tour Cost</div>
													<div class="content-text total-passenger-price pull-right">USD {{count($data->fname) * $dPrice->price}}</div>
												</div>
											</div>

											<div class="total-price-details-box  exten-text @if(empty($extensionText)) hide @endif ">
												<div class="clearfix sub-heading-title">
													<div class="label-text total-passenger-price ">Extension Packages</div>
													<div class="content-text total-passenger-price pull-right ext hide" extprice="0" ></div>
													<div class="extension">
													@if(!empty($extensionText)) 
														{!! $extensionText !!} 
													@endif
													</div>
												</div>
											</div>

											<div class="total-footer">
												<div class="clearfix sub-heading-title">
													<div class="label-text total-passenger-price pull-left">
														<h3>Total 
															<small>Tax Included</small></h3>
														</div>
														<?php /* ?>
														<div class="content-text total-passenger-price pull-right"><span id = "total">USD {{ count($travellers) * $dPrice->price}}</span></div>
														<?php */ ?>
														<div class="content-text total-passenger-price pull-right"><span id = "total">USD {{$totalAmount}}</span></div>
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