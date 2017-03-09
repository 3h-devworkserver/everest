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
							<a href="{{url('package/'.$slug.'/'.$datePrice.'/'.$travellers[0]->group_id.'/booking-step1')}}" >Step 1 - Travellers </a>
							<a href="{{url('/package/'.$slug.'/'.$datePrice.'/'.$groupId.'/booking-step2')}}" >Step 2 - Summary  </a>
							<a href="#" class="active">Step 3 - Confirm </a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8 col-sm-8" id="traveller-info">
						<div class="page-header bold_page-header">
								<h2>{{$package->title}} BOOKING</h2>
						</div>
					
						<div class="travel-form">
						{!! Form::open(['url'=>'package/'.$slug.'/'.$datePrice.'/booking-step3-payment', 'id'=>'booking-3']) !!}

								<div class="form-group pt0">
									<span class="form-title">Select</span>
									<!-- <label>Select </label>&nbsp;&nbsp; --><span class="radio-error text-danger"></span>
									<div class="row">
									<div class="col-md-12">
									<div class="payment-options ">
										<div class="radio">
										    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
										  <label for="optionsRadios1">
										    <img src="{{url('images/new/card-1.png')}}" alt="">
										  </label>
										</div>
										<div class="radio">
										    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
										  <label for="optionsRadios2">
										    <img src="{{url('images/new/card-2.png')}}" alt="">
										  </label>
										</div>
										<div class="radio">
										    <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3">
										  <label for="optionsRadios3">
										    <img src="{{url('images/new/card-3.png')}}" alt="">
										  </label>
										</div>
										<div class="radio">
										    <input type="radio" name="optionsRadios" id="optionsRadios4" value="option1">
										  <label for="optionsRadios4">
										    <img src="{{url('images/new/card-4.png')}}" alt="">
										  </label>
										</div>
										<div class="radio">
										    <input type="radio" name="optionsRadios" id="optionsRadios5" value="option5">
										  <label for="optionsRadios5">
										    <img src="{{url('images/new/card-6.png')}}" alt="">
										  </label>
										</div>
										<div class="radio">
										    <input type="radio" name="optionsRadios" id="optionsRadios6" value="option6">
										  <label for="optionsRadios6">
										    <img src="{{url('images/new/card-5.png')}}" alt="">
										  </label>
										</div>
										
									</div>
									</div>
									</div>

								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label>Full Name</label>
											<input type="text" name="name" class="form-control" placeholder="Enter Your Full Name">
										</div>
										<div class="col-md-6">
											<label>Credit Card Number</label>
											<input type="text" name="credit_card" class="form-control" placeholder="Enter Your Credit Card Number">
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-7 col-sm-7 col-xs-8">
											<label>Expiration Date</label>
											<div class="row">
												<div class="col-md-8 col-sm-7 col-xs-6">
												<select name="exp_year" class=" form-control box" >
									<option value="">YEAR</option>
									<?php $j = date('Y'); ?>
									@while($j != 1900 )
										<option value"{{$j}}" >{{$j}}</option>
										<?php $j--; ?>
									@endwhile
								</select>
													{{-- <input type="text" class="form-control" placeholder="YEAR"> --}}
													
												</div>
												<div class="col-md-4 col-sm-5 col-xs-6">
												{!! Form::select('exp_month', [''=>'MM', '1'=>'Jan', '2'=>'Feb', '3'=>'Mar', '4'=>'Apr', '5'=>'May', '6'=>'Jun', '7'=>'Jul', '8'=>'Aug', '9'=>'Sep', '10'=>'Oct', '11'=>'Nov', '12'=>'Dec'], null, ['class'=>'box form-control', ]) !!}
													{{-- <input type="text" class="form-control" placeholder="MONTH"> --}}
													
												</div>
											</div>
										</div>
										<div class="col-md-5 col-sm-5 col-xs-4">
											<label for="">CW</label>
											<input type="text" name="cw" class="form-control">
										</div>
										
									</div>
								</div>

								<div class="row">
									<div class="col-md-12">
										<a id="payment" class="btn btn-danger btn-step">Confirm</a>
									</div>
								</div>
							{!! Form::close() !!}
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
											@foreach($travellers as $traveller)
												<p>{{$traveller->title}}. {{$traveller->fname}} {{$traveller->mname}} {{$traveller->lname}}<p>
											@endforeach</div>
									</div>
						
								<div class="total-price-details-box">
									
									<div class="clearfix sub-heading-title">
										<div class="label-text total-passenger-price pull-left">Tour Cost</div>
										<div class="content-text total-passenger-price pull-right">USD {{$dPrice->price}}</div>
									</div>

								</div>
								<div class="total-footer">
									<div class="clearfix sub-heading-title">
										<div class="label-text total-passenger-price pull-left">
										<h3>Total 
								  		<small>Tax Included</small></h3>
								  	</div>
										<div class="content-text total-passenger-price pull-right"><span id = "total">USD {{ count($travellers) * $dPrice->price}}</span></div>
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