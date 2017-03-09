@extends('frontend.layouts.master-new')
@section('title') Traveller History | {{ $siteTitle }}@endsection
@section('content')

<section class="main-content dashboard-wrapper">
	
	@include('frontend.traveller.includes.navbar')
	
	<div class="dashboard">
		<div class="container">
			<div class="row">
				<div class="col-md-3 col-sm-3">
					<div class="profile-block">
						<div class="profile-picture">
							<div class="profile-bg" style="background-image:url('images/mountain-biking.jpg');"></div>
							<div class="profile-img" style="background-image:url('images/mountain-biking.jpg');"></div>
						</div>
						<div class="profile-desc text-center">
							<h3>Caroline Belfort</h3>
							<h5>Kusunti,Jawlakhel</h5>
						</div>

						<div class="profile-footer text-center">
							<a href="#" class="btn btn-default">view profile</a>
						</div>
					</div>
				</div>
				<div class="col-md-9 col-sm-9">
					<div class="user-activity">
						
						<h3>Package List</h3>						
						
						<article class="activity-wrap">
							<div class="row">
								<div class="col-md-1">
									<figure>
										<img src="images/valentines.png" alt="">
										
									</figure>
								</div>
								<div class="col-md-4">
									<h4>Pokhara Calling</h4>
									
									
									
								</div>
								<div class="col-md-5">
									<div class="meta-activity">
										<ul class="list-unstyled list-inline">
											<li> <i class="fa fa-tag"></i>Valentine Package</li>
											<li>
												<i class="fa fa-clock-o"></i> 10 Feb 2017
											</li>
										</ul>
									</div>
								</div>
								<div class="col-md-2 text-right">
									<div class="action">
										<a href="#">
											<i class="fa fa-pencil"></i>
										</a>
										<a href="#">
											<i class="fa fa-trash"></i>
										</a>
										
									</div>
								</div>
							</div>
						</article>
						<article class="activity-wrap">
							<div class="row">
								<div class="col-md-1">
									<figure>
										<img src="images/inside_everest_trekking_small_1.jpg" alt="">
										
									</figure>
								</div>
								<div class="col-md-4">
									<h4>Trekking in the Everest region</h4>
									
									
									
								</div>
								<div class="col-md-5">
									<div class="meta-activity">
										<ul class="list-unstyled list-inline">
											<li> <i class="fa fa-tag"></i>Trekking Package</li>
											<li>
												<i class="fa fa-clock-o"></i> 10 Feb 2017
											</li>
										</ul>
									</div>
								</div>
								<div class="col-md-2 text-right">
									<div class="action">
										<a href="#">
											<i class="fa fa-pencil"></i>
										</a>
										<a href="#">
											<i class="fa fa-trash"></i>
										</a>
										
									</div>
								</div>
							</div>
						</article>
						<article class="activity-wrap">
							<div class="row">
								<div class="col-md-1">
									<figure>
										<img src="images/paragliding.jpg" alt="">
										
									</figure>
								</div>
								<div class="col-md-4">
									<h4>Paragliding</h4>
									
									
									
								</div>
								<div class="col-md-5">
									<div class="meta-activity">
										<ul class="list-unstyled list-inline">
											<li> <i class="fa fa-tag"></i>Valentine Package</li>
											<li>
												<i class="fa fa-clock-o"></i> 10 Feb 2017
											</li>
										</ul>
									</div>
								</div>
								<div class="col-md-2 text-right">
									<div class="action">
										<a href="#">
											<i class="fa fa-pencil"></i>
										</a>
										<a href="#">
											<i class="fa fa-trash"></i>
										</a>
										
									</div>
								</div>
							</div>
						</article>
						<article class="activity-wrap">
							<div class="row">
								<div class="col-md-1">
									<figure>
										<img src="images/valentines.png" alt="">
										
									</figure>
								</div>
								<div class="col-md-4">
									<h4>Pokhara Calling</h4>
									
									
									
								</div>
								<div class="col-md-5">
									<div class="meta-activity">
										<ul class="list-unstyled list-inline">
											<li> <i class="fa fa-tag"></i>Valentine Package</li>
											<li>
												<i class="fa fa-clock-o"></i> 10 Feb 2017
											</li>
										</ul>
									</div>
								</div>
								<div class="col-md-2 text-right">
									<div class="action">
										<a href="#">
											<i class="fa fa-pencil"></i>
										</a>
										<a href="#">
											<i class="fa fa-trash"></i>
										</a>
										
									</div>
								</div>
							</div>
						</article>
						<article class="activity-wrap">
							<div class="row">
								<div class="col-md-1">
									<figure>
										<img src="images/inside_everest_trekking_small_1.jpg" alt="">
										
									</figure>
								</div>
								<div class="col-md-4">
									<h4>Trekking in the Everest region</h4>
									
									
									
								</div>
								<div class="col-md-5">
									<div class="meta-activity">
										<ul class="list-unstyled list-inline">
											<li> <i class="fa fa-tag"></i>Trekking Package</li>
											<li>
												<i class="fa fa-clock-o"></i> 10 Feb 2017
											</li>
										</ul>
									</div>
								</div>
								<div class="col-md-2 text-right">
									<div class="action">
										<a href="#">
											<i class="fa fa-pencil"></i>
										</a>
										<a href="#">
											<i class="fa fa-trash"></i>
										</a>
										
									</div>
								</div>
							</div>
						</article>
						<article class="activity-wrap">
							<div class="row">
								<div class="col-md-1">
									<figure>
										<img src="images/paragliding.jpg" alt="">
										
									</figure>
								</div>
								<div class="col-md-4">
									<h4>Paragliding</h4>
									
									
									
								</div>
								<div class="col-md-5">
									<div class="meta-activity">
										<ul class="list-unstyled list-inline">
											<li> <i class="fa fa-tag"></i>Valentine Package</li>
											<li>
												<i class="fa fa-clock-o"></i> 10 Feb 2017
											</li>
										</ul>
									</div>
								</div>
								<div class="col-md-2 text-right">
									<div class="action">
										<a href="#">
											<i class="fa fa-pencil"></i>
										</a>
										<a href="#">
											<i class="fa fa-trash"></i>
										</a>
										
									</div>
								</div>
							</div>
						</article>
						<article class="activity-wrap">
							<div class="row">
								<div class="col-md-1">
									<figure>
										<img src="images/valentines.png" alt="">
										
									</figure>
								</div>
								<div class="col-md-4">
									<h4>Pokhara Calling</h4>
									
									
									
								</div>
								<div class="col-md-5">
									<div class="meta-activity">
										<ul class="list-unstyled list-inline">
											<li> <i class="fa fa-tag"></i>Valentine Package</li>
											<li>
												<i class="fa fa-clock-o"></i> 10 Feb 2017
											</li>
										</ul>
									</div>
								</div>
								<div class="col-md-2 text-right">
									<div class="action">
										<a href="#">
											<i class="fa fa-pencil"></i>
										</a>
										<a href="#">
											<i class="fa fa-trash"></i>
										</a>
										
									</div>
								</div>
							</div>
						</article>
						<article class="activity-wrap">
							<div class="row">
								<div class="col-md-1">
									<figure>
										<img src="images/inside_everest_trekking_small_1.jpg" alt="">
										
									</figure>
								</div>
								<div class="col-md-4">
									<h4>Trekking in the Everest region</h4>
									
									
									
								</div>
								<div class="col-md-5">
									<div class="meta-activity">
										<ul class="list-unstyled list-inline">
											<li> <i class="fa fa-tag"></i>Trekking Package</li>
											<li>
												<i class="fa fa-clock-o"></i> 10 Feb 2017
											</li>
										</ul>
									</div>
								</div>
								<div class="col-md-2 text-right">
									<div class="action">
										<a href="#">
											<i class="fa fa-pencil"></i>
										</a>
										<a href="#">
											<i class="fa fa-trash"></i>
										</a>
										
									</div>
								</div>
							</div>
						</article>
						<article class="activity-wrap">
							<div class="row">
								<div class="col-md-1">
									<figure>
										<img src="images/paragliding.jpg" alt="">
										
									</figure>
								</div>
								<div class="col-md-4">
									<h4>Paragliding</h4>
									
									
									
								</div>
								<div class="col-md-5">
									<div class="meta-activity">
										<ul class="list-unstyled list-inline">
											<li> <i class="fa fa-tag"></i>Valentine Package</li>
											<li>
												<i class="fa fa-clock-o"></i> 10 Feb 2017
											</li>
										</ul>
									</div>
								</div>
								<div class="col-md-2 text-right">
									<div class="action">
										<a href="#">
											<i class="fa fa-pencil"></i>
										</a>
										<a href="#">
											<i class="fa fa-trash"></i>
										</a>
										
									</div>
								</div>
							</div>
						</article>

						<nav aria-label="...">
							<ul class="pager">
								<li><a href="#"><i class="fa fa-angle-left"></i> &nbsp;Previous</a></li>
								<li><a href="#">Next &nbsp; <i class="fa fa-angle-right"></i></a></li>
							</ul>
						</nav>
						

						
						
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection