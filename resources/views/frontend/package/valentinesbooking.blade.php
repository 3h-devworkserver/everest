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
	<div class="container" >
		{{-- {!!Form:: open(['url'=>'package/'.$slug.'/'.$datePrice.'/booking-step2', 'id'=>'traveller-info', 'files'=>'true']) !!} --}}
		<div class="travel-booking" id="traveller-info">

			<div class="travel-booking-step">
				<!--	<div class="row">
						<div class="col-md-12">
							<a href="#" class="active">Step 1 - Travellers </a>
							<a href="#" >Step 2 - Summary  </a>
							<a href="#">Step 3 - Confirm </a>
						</div>
					</div>-->
				</div> 

				<div class="row">
					<div class="col-md-8 col-sm-8">
						<div class="page-header bold_page-header">
							<h2>{{$package->title}} BOOKING</h2>
						</div>
						@if (session()->has('invalid'))
						<div class="alert alert-danger">
							{{session('invalid')}}
						</div>
						@endif
						
						<div class="alert alert-danger promo-error hide">

						</div>
						<div class="alert alert-success update hide">
						</div>

						@if(!empty($success))
						<div class="alert alert-success">
							{!!$success!!}
						</div>
						@endif



						@if(empty($success))
						<div id="">
							<div class="travel-form">

								<!--	<p class="form-title">Lead Traveller:</p>  -->
								<div class="form-info">
									

									<div class="form-group">
										<span class="form-title">Promo Code:</span>
										<form method="post" id="checkPromoForm" action="javascript:;" >
											<div class="row">
												<div class="col-md-8 col-sm-6">
													{{-- <label>Please enter generated Promo Code <em>*</em></label> --}}
													{!!Form::text('promocode',null, ['class'=>'form-control promocode', 'placeholder'=>'Please enter generated Promo Code to continue' ]) !!}
													<input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
													<p class="help-block">Promo Code not generated yet ? <a href="javascript:;" data-toggle="modal" data-target="#valentine-promo">GET YOUR PROMO CODE</a></p>
												</div>
												<div class="col-md-4">
													<div class="check">
														<button class="btn btn-danger checkPromo">Check Promo Code</button><div class="loading hide ">
														<i class="fa fa-refresh fa-spin"></i>
													</div>
												</div>
											</div>
											
										</div>
									</form>

								</div>

								{{-- <div id="CoupleInfoForm"> --}}
									<form action="javascript:;" id="CoupleInfoForm" method="post">
										<div class="form-group hide">
											<span class="form-title"> Details:</span>
											<div class="row">
												<div class="col-md-6 col-sm-6">
													<label>Full Name </label>
													{!!Form::text('fullname',null, ['class'=>'form-control', ]) !!}
													{{-- <input type="email" class="form-control"> --}}
												</div>
												<div class="col-md-6 col-sm-6">
													<label>Valentine’s Full Name </label>
													{!!Form::text('valentine_fullname',null, ['class'=>'form-control', ]) !!}
													{{-- <input type="text" class="form-control"> --}}
												</div>
											</div>

											<div class="row">
												<div class="col-md-6 col-sm-6 issue-date">
													<label>Email</label>
													{!!Form::email('email',null, ['class'=>'form-control', ]) !!}
													{{-- <input type="text" class="form-control"> --}}

												</div>

												<div class="col-md-6 col-sm-6">
													<label>Contact No</label>
													{!!Form::text('contact',null, ['class'=>'form-control']) !!}
													{{-- <input type="email" class="form-control"> --}}
												</div>
												{!!Form::hidden('promo_code', null) !!}
											</div>
											<div class="row">
												<div class="col-md-12">
													 <div class="check">

													<button type="submit" class="btn btn-danger">Update Info</button>
													<div class="loading hide">
													<i class="fa fa-refresh fa-spin"></i>
													</div>
													</div> 
												</div>
											</div>


									</div>
								</form>


							{{-- </div> --}}


						</div>
						<div class="payment-options hide">
							<div class="form-group">
								<span class="form-title">Payment Option:</span>
								<div class="image-esewa">
									<img src="{{url('images/esewa.jpeg')}}" width="90" alt="">
								</div>
							</div>
						</div>





<!-- extra package   -->


<div class="add-extra-package">
<div class="interest">
<h2 class="interest-txt">You might be interested in...</h2>
<p class="validatepromo">Please validate your promocode to purchase package.</p>
</div>
					<div class="row">	
					
                     <?php $i=1; ?>             
				@foreach($packages as $pack)
						<div class="col-md-6 col-sm-6">
							<div class="thumbnail">

								<div class="checkbox">
								<?php /* ?>
								    <input type="checkbox" id="check{{$i}}" name="package[]" class="addxtraPack" value="{{$pack->price}}" data-id="{{$pack->id}}"><?php */ ?>
								    <label for="check{{$i}}">{{$pack->title}}</label>
								  </div> 
								<div class="thumb-img bg-wrap" style="background-image:url({{asset('images/packages-new/'.$pack->feat_img) }});">
								<div class="pack-msg"><p>Extension package selected.</p></div>
								</div>
								<div class="price">+NPR {{$pack->price}} <small>per Person</small></div>
								<div class="addextraPackageDiv hide">
								<label>For</label>
									<select name="packages" data-id="{{$pack->id}}" class="form-control addextraPackage ">
										<option value="">-- Select --</option>
										<option value="{{$pack->price}}" data-no="1" data-title="{{$pack->title}}" data-id="{{$pack->id}}">Single</option>
										<option value="{{$pack->price * 2}}" data-no="2" data-title="{{$pack->title}}" data-id="{{$pack->id}}">Couple</option>
									</select>
								</div>
								<a href="{{url('/package/'.$pack->slug)}}" target="_blank" class="btn btn-gray">view itinerary</a>
							</div>
						</div>
						<?php $i++; ?>
					@endforeach
					</div>
				</div>

<!-- end of extra package   -->



						{{-- {!!Form::open(['url'=> '#', 'id'=>'esewaForm'])!!} --}}

						
						{{-- {!!Form::close()!!} --}}

						{{-- </form> --}}
					</div>
				</div>
				@endif




			</div>

			@if(empty($success))
			<div class="col-md-4 col-sm-4">
				<div class="sidebar-travel">
					<div class="total-block">
						<h2 class="block-title">Booking Summary</h2>

						<div class="trip-more-info-block summary">

							<div class="trip-more-info-list">
								<div class="info-title sub-heading-title when">When: </div>
								<div class="info-description">{{$dPrice->daterange}}</div>
							</div>
							{{-- <div class="trip-more-info-list">
								<div class="info-title sub-heading-title when">Traveller: </div>
								<div class="info-description" id="traveller">2</div>
							</div> --}}

							<div class="total-price-details-box">

								<div class="clearfix sub-heading-title">
									<div class="label-text total-passenger-price pull-left ">Tour Cost</div>
									<div class="content-text total-passenger-price pull-right">NPR {{$dPrice->price}}</div>
								</div>

							</div>

<div class="total-price-details-box">

								<div class="clearfix sub-heading-title">
									<div class="label-text total-passenger-price pull-left">Service Charge (10%)</div>
									<div class="content-text total-passenger-price pull-right ">NPR {{($dPrice->price)*(10/100)}}</div>
								</div>

							</div>

<div class="total-price-details-box  exten-text hide">

								<div class="clearfix sub-heading-title">
									<div class="label-text total-passenger-price ">Extension Packages</div>
									<div class="content-text total-passenger-price pull-right ext hide" extprice="0" ></div>
									<div class="extension">
										
									</div>


								</div>

							</div>



							<div class="total-footer">
								<div class="clearfix sub-heading-title">
									<div class="label-text total-passenger-price pull-left">
										<h3>Total 
											<small>Tax Included</small></h3>
										</div>
										<div class="content-text total-passenger-price pull-right"><span id = "total" initial-total="{{$dPrice->price + (($dPrice->price)*(10/100))}}" totalprice = "{{$dPrice->price + (($dPrice->price)*(10/100))}}">NPR {{$dPrice->price + (($dPrice->price)*(10/100))}}</span></div>
									</div>


								</div>
						
							</div>

						</div>

		<?php 
						$amt = round($dPrice->price, 2);
						$txAmt = 0;
						$psc = round(($dPrice->price)*(10/100), 2);
						$pdc = 0;
						$tAmt = $amt + $txAmt + $psc + $pdc;
						?>

						<form action="https://esewa.com.np/epay/main" method="POST" id="esewaForm"> 
							<input value="{{$tAmt}}" name="tAmt" type="hidden"> 
							<input value="{{$amt}}" name="amt" type="hidden"> 
							<input value="{{$txAmt}}" name="txAmt" type="hidden">
							<input value="{{$psc}}" name="psc" type="hidden"> 
							<input value="{{$pdc}}" name="pdc" type="hidden"> 
							<input value="Upeverest_esewa" name="scd" type="hidden">  
							<input value="Package-{{$rand}}" name="pid" type="hidden"> 
							<input value="{{url('package/'.$package->slug.'/'.$datePrice.'/booking-success/promoid')}}?q=su" type="hidden" name="su">
							{{-- <input value="http://abc.com/failure.html?q=fu" type="hidden" name="fu">  --}}
							<input value="{{url('package/'.$package->slug.'/'.$datePrice.'/valentines-booking')}}?q=fu" type="hidden" name="fu"> 

							<div class="row esewabtn" >
								<div class="col-md-12">
									<input value="Purchase Package" type="submit" id="submit" class="btn btn-danger btn-step" disabled> 
									{{-- {!! Form::submit('Pay By eSewa',['id'=>'submit', 'class'=>'btn btn-danger btn-step']) !!} --}}
									{{-- <a href="{{url('package/'.$slug.'/booking-step3')}}" class="btn btn-danger btn-step">Continue</a> --}}

								</div>
							</div>
							{{-- </form> --}}


						</form>



					</div>
				</div>
				@endif

			</div>



		</div>
		{{-- {!!Form::close() !!} --}}
	</div><!--Container -->

	<div class="divider"></div>


	{{-- @include('frontend.includes.new.members') --}}



</div>

@endsection