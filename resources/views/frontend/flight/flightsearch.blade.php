@extends('frontend.layouts.master-new')
@section('title') Search Flight | {{ $siteTitle or '' }}@endsection
@section('meta_keywords'){{ $meta_keywords }}@endsection
@section('meta_desc'){{ $meta_desc }}@endsection

@section('loader')
@include('frontend.includes.new.loader')
@endsection

@section('content')

<section class="main-content">
    	<div class="flight-booking-progress-step">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h3>Book Flight Tickets</h3>
							
					</div>
				</div>
			</div>
		</div>
         @include('frontend.includes.new.searchform')
	</section>
	
@endsection