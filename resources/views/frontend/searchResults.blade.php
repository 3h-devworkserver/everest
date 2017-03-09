@extends('frontend.layouts.master-new')
@section('title') Search Results | {{ $meta_title }}@endsection
<!--@section('meta_title'){{ $meta_title }}@endsection-->
@section('meta_keywords'){{ $meta_keywords }}@endsection
@section('meta_desc'){{ $meta_desc }}@endsection

@section('banner')
	<section class="banner">
	<div class="search-wrap">
      	<div class="container">
            <div class="row">
                <div class="col-md-12">
                    @include('frontend.includes.searchbar')
         		</div>
        	</div>
      	</div>
    </div>
    </section>
@endsection


@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h2 class="text-center">Search Result</h2>
			</div>
		</div>

	</div> <!--end row-->

	<div class="row">
		<div class="col-md-12 text-center">
			<button class="btn btn-primary cust-btn-lg"> View more</button>
		</div>
	</div>	
@stop

