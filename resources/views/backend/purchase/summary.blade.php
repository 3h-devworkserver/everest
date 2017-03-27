@extends ('backend.layouts.master')

@section ('title', trans('Purchase Order Summary'))

@section('page-header')
<h1>
	{{ trans('Purchase Order Summary') }}
	<small>{{ trans('menus.purchases.summary') }}</small>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! link_to_route('admin.purchases.index', trans('Purchase Order Summary')) !!}</li>
@stop

@section('content')

@include('frontend.includes.new.functions')

<!-- Main content -->
<div class="row">

	<div class="col-md-6">
		
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Purchase Details</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div><!-- /.box-tools -->
			</div>
			<div class="box-body">
				<div class="purchase-table">
					<table>
						<tr>
							<td>Order Id</td>
							@if($booking->type == 'flight')
							<td>{{$booking->flightReservation->order_id}}</td>
							@else
							<td>{{$booking->packageBooking->order_id}}</td>
							@endif
						</tr>
						<tr>
							<td>Type</td>
							<td>{{$booking->type}}</td>
						</tr>
						<tr>
							<td>Status</td>
							<td>{{$booking->status}}</td>
						</tr>
						<tr>
							<td>Purchased Date</td>
							<td>{{\Carbon\Carbon::parse($booking->purchased_at)->format('Y/m/d')}}</td>
						</tr>

					</table>
				</div>
			</div>
		</div>  <!-- box -->

		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">@if($booking->type == 'flight')Flight Information @else Package @endif</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div><!-- /.box-tools -->
			</div>
			<div class="box-body">
				@if($booking->type == 'flight')
				<p>Flight Type : @if($flight->return_type == 'R') Round Trip @else One Way @endif</p>
				<div class="purchase-table">
					@if(!empty($flightDetail))
					<table>
						<p>Departure Flight</p>
						<tr>
							<td>Airline</td>
							<td>{{airlinesName($flightDetail->Airline)}}</td>
						</tr>
						<tr>
							<td>Flight Date</td>
							<td>{{$flightDetail->FlightDate}}</td>
						</tr>
						<tr>
							<td>Departure</td>
							<td>{{$flightDetail->Departure}}</td>
						</tr>
						<tr>
							<td>Departure Time</td>
							<td>{{$flightDetail->DepartureTime}}</td>
						</tr>
						<tr>
							<td>Arrival</td>
							<td>{{$flightDetail->Arrival}}</td>
						</tr>
						<tr>
							<td>Arrival Time</td>
							<td>{{$flightDetail->ArrivalTime}}</td>
						</tr>
						<tr>
							<td>Flight No</td>
							<td>{{$flightDetail->FlightNo}}</td>
						</tr>
						<tr>
							<td>Flight Id</td>
							<td>{{$flightDetail->FlightId}}</td>
						</tr>
						<tr>
							<td>Flight Class</td>
							<td>{{$flightDetail->FlightClassCode}}</td>
						</tr>
					</table>
					@endif

						@if($flight->return_type == 'R')
							<div class="purchase-table">
							@if(!empty($flightDetail))
								<table>
								<p>Return Flight</p>
								<tr>
									<td>Airline</td>
									<td>{{airlinesName($returnFlightDetail->Airline)}}</td>
								</tr>
								<tr>
									<td>Flight Date</td>
									<td>{{$returnFlightDetail->FlightDate}}</td>
								</tr>
								<tr>
									<td>Departure</td>
									<td>{{$returnFlightDetail->Departure}}</td>
								</tr>
								<tr>
									<td>Departure Time</td>
									<td>{{$returnFlightDetail->DepartureTime}}</td>
								</tr>
								<tr>
									<td>Arrival</td>
									<td>{{$returnFlightDetail->Arrival}}</td>
								</tr>
								<tr>
									<td>Arrival Time</td>
									<td>{{$returnFlightDetail->ArrivalTime}}</td>
								</tr>
								<tr>
									<td>Flight No</td>
									<td>{{$returnFlightDetail->FlightNo}}</td>
								</tr>
								<tr>
									<td>Flight Id</td>
									<td>{{$returnFlightDetail->FlightId}}</td>
								</tr>
								<tr>
									<td>Flight Class</td>
									<td>{{$returnFlightDetail->FlightClassCode}}</td>
								</tr>
								</table>
							@endif
							</div>
						@endif

					</table>
				</div>
				@else
					<div class="purchase-table">
						<table>
							<tr>
								<td>Package</td>
								<td>{{$package->title}}</td>
							</tr>
							<tr>
								<td>Date</td>
								<td>{{$datePrice->daterange}}</td>
							</tr>
							<tr>
								<td>Main Package Amount</td>
								<td>{{$packageBooking->total_person}} @if($packageBooking->total_person == 1)Person @else Persons @endif -USD {{$packageBooking->main_package_amount}}</td>
							</tr>
							@if(!empty($addon))
							<tr>
								<td>Addon Packages</td>
								<td>
								<?php /* ?>
								<?php $i = 0; ?>
								@foreach($addon as $xtra)
									<?php 
										$pack = DB::table('packages')->where('id', $xtra)->first();
										$addonDetailPart = explode('-', $addonDetail[$i]);
									?>

									<p>{{$pack->title}} - {{$addonDetailPart[1]}} @if($addonDetailPart[1] == 1)Person @else Persons @endif - USD {{$addonDetailPart[2]}} </p>
									<?php $i++; ?>
								@endforeach
								<?php */ ?>

								<?php $i = 0; ?>
								@foreach($addonDetail as $detail)
									@if(!empty($detail))
										<?php 
											$addonDetailPart = explode('-', $detail);
											$pack = DB::table('packages')->where('id', $addonDetailPart[0])->first();
										?>

										<p>{{$pack->title}} - {{$addonDetailPart[1]}} @if($addonDetailPart[1] == 1)Person @else Persons @endif - USD {{$addonDetailPart[2]}} </p>
									@endif
									<?php $i++; ?>
								@endforeach

								</td>
							</tr>
							@endif
							<tr>
								<td>Total Amount</td>
								<td>USD {{$packageBooking->total_amount}}</td>
							</tr>
						</table>
					</div>
				@endif
				
			</div>
		</div>  <!-- box -->

	</div> <!-- col -->

	<div class="col-md-6">

		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Traveller Information</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div><!-- /.box-tools -->
			</div>
			<div class="box-body">
				@if($booking->type == 'flight')
				<div class="purchase-table">
					<table>
						<tr>
							<td>No. of Adult</td>
							<td>{{$flightDetail->Adult}}</td>
						</tr>
						<tr>
							<td>No. of Child</td>
							<td>{{$flightDetail->Child}}</td>
						</tr>
						<tr>
							<td>Lead Traveller Name</td>
							<td>{{$mainTraveller->title}}. {{$mainTraveller->fname}} {{$mainTraveller->mname}} {{$mainTraveller->lname}}</td>
						</tr>
						<tr>
							<td>Email</td>
							<td>{{$mainTraveller->email}}</td>
						</tr>
						<tr>
							<td>Phone ({{$mainTraveller->phone_type}})</td>
							<td>{{$mainTraveller->phone}}</td>
						</tr>
						<tr>
							<td>Nationality</td>
							<td>{{$mainTraveller->nationality}}</td>
						</tr>
						<tr>
							<td>Address</td>
							<td>@if($mainTraveller->address){{$mainTraveller->address}},@endif @if($mainTraveller->city){{$mainTraveller->city}},@endif @if($mainTraveller->postal_zip){{$mainTraveller->postal_zip}},@endif @if($mainTraveller->state){{$mainTraveller->state}},@endif @if($mainTraveller->country){{$mainTraveller->country}}@endif</td>
						</tr>

					</table>
				</div>
				@else
					<div class="purchase-table">
						<table>
							<tr>
								<td>No. of Traveller</td>
								<td>{{$packageBooking->total_person}}</td>
							</tr>
							<tr>
								<td>Lead Traveller Name</td>
								<td>{{$mainTraveller->title}}. {{$mainTraveller->fname}} {{$mainTraveller->mname}} {{$mainTraveller->lname}}</td>
							</tr>
							<tr>
								<td>Email</td>
								<td>{{$mainTraveller->email}}</td>
							</tr>
							<tr>
								<td>Phone</td>
								<td>{{$mainTraveller->phone}}</td>
							</tr>
							<tr>
								<td>Nationality</td>
								<td>{{$mainTraveller->nationality}}</td>
							</tr>
							<tr>
								<td>Address</td>
								<td>@if($mainTraveller->address){{$mainTraveller->address}},@endif @if($mainTraveller->city){{$mainTraveller->city}},@endif @if($mainTraveller->postal_zip){{$mainTraveller->postal_zip}},@endif @if($mainTraveller->state){{$mainTraveller->state}},@endif @if($mainTraveller->country){{$mainTraveller->country}}@endif</td>
							</tr>
						</table>
					</div>
				@endif
				
			</div>
		</div>  <!-- box -->
		
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Payment Information</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div><!-- /.box-tools -->
			</div>
			<div class="box-body">
				<div class="purchase-table">
					@if($booking->type == 'flight')
						<table>
							<tr>
								<td>Payment Option</td>
								<td>{{$flight->payment_type}}</td>
							</tr>
							<tr>
								<td>Order Id</td>
								<td>{{$flight->order_id}}</td>
							</tr>
							<tr>
								<td>Ref Id</td>
								<td>{{$flight->refId}}</td>
							</tr>
							<tr>
								<td>Total Amount</td>
								<td>{{$flightDetail->Currency}} {{$flight->total_amount}}</td>
							</tr>
						</table>
					@else
						<table>
							<tr>
								<td>Payment Option</td>
								<td>{{$packageBooking->payment_type}}</td>
							</tr>
							<tr>
								<td>Order Id</td>
								<td>{{$packageBooking->order_id}}</td>
							</tr>
							<tr>
								<td>Ref Id</td>
								<td>{{$packageBooking->refId}}</td>
							</tr>
							<tr>
								<td>Total Amount</td>
								<td>USD {{$packageBooking->total_amount}}</td>
							</tr>
						</table>
					@endif
				</div>
				
			</div>
		</div>  <!-- box -->

		


	</div>

</div>


<div class="clearfix"></div>

@endsection



