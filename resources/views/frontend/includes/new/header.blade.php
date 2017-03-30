<header>
	<div class="container">
		<div class="logo">
			<h1>
			<a href="{{URL::to('/')}}">
				<img src="{{asset('images/upeverest logo.png')}}" alt="">
			</a>
			</h1>
		</div>
				<div class="site-text"><p>Nepal- adventure of a life time</p></div>
		<div class="header-right">
			<div class="menu">
					<ul class="list-unstyled list-inline mobile-btn-block">
						<li><a href="{{url('/flight/flightsearch')}}"><i class="fa fa-plane"></i>flight</a></li>
						<li><a href="{{url('trekking')}}"><i class="fa fa-map-o"></i>trekking</a></li>
						@if(Auth::guest())
						<li class="btn-login"><a href="{{url('/login')}}">login</a> <span>/</span> <a href="{{url('/register')}}">register</a></li>
						@endif
						<!-- <li><a href="#"><i class="fa fa-bed"></i>local room</a></li>
						<li><a href="#"><i class="fa fa-car"></i>car rental</a></li> -->
						<?php /* ?>
						<li>
							<button type="button" class="btn btn-danger" onclick="window.location='{{url('package/valentines-package')}}';">
							  <i class="fa fa-heart-o"></i>Valentine's Special
							</button>
							
						</li>
						<?php */ ?>
					</ul>
					@if(Auth::check())
					<div class="auth">
					    <div class="auth-thumb">
					      <span class="auth-img">
					        <i class="fa fa-user-o"></i>
					      </span>
					      
					    </div>
					    <ul class="list-unstyled">
					        <li class="dropdown">
					            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
					            	<span class="auth-name">{{Auth::user()->fname}} </span>
					                <i class="fa fa-angle-down"></i>
					              </a>
					            <ul class="dropdown-menu navmenu-nav">
					                <li><a href="@if(Auth::user()->hasRole(1)) {{url('admin/dashboard')}} @else {{url('traveller/dashboard')}} @endif"><i aria-hidden="true" class="fa fa-tachometer"></i>Dashboard</a></li>
					                @if(Auth::user()->hasRole(2))
										<li><a href="{{url('traveller/profile')}}"><i aria-hidden="true" class="fa fa-user"></i>Profile</a></li>
										<li><a href="{{url('traveller/history')}}"><i aria-hidden="true" class="fa fa-money"></i>Purchased History</a></li>
					                @endif
					                <li><a href="@if(Auth::user()->hasRole(1)) {{url('auth/logout')}} @else {{url('traveller/logout')}} @endif"><i class="fa fa-sign-out"></i>Log out</a></li>
					            </ul>
					        </li>
					    </ul>
					</div>
					@endif
			</div>
			
			<button class="menu-icon">
			<span class="bars"></span>
			<span class="bars"></span>
			<span class="bars"></span>
			</button>
			<!--<form action=""">
			<div class="search">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Search for..." name="q">
					<span class="input-group-btn">
						<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
					</span>
					</div>
				</div>
			</form>-->
				<!-- <button class="booked">
					<img src="images/icon~plane.png" alt="">
					<span class="hidden-xs">BOOK A FLIGHT</span>
				</button> -->
			</div>
		</div>
		<div class="mega-menu">
			<div class="divider"></div>
			<div class="container">
			@if(!empty($menus))			
				@foreach($menus as $key => $menu)							
					<div class="column">					
						<a class="title" href="{{$menu->url}}">{{$menu->title}}<i class="fa fa-angle-down" aria-hidden="true"></i></a>
						<!-- for giving link to talk to everest summitters -->						
						<?php $sub_menu = \DB::table('menus')->where('parent_id', $menu->id)->orderby('order', 'asc')->get();?>
						<ul class="sub-menu">
							@foreach($sub_menu as $s_menu)								
							<li><a href="{{url().'/'.$s_menu->url}}">{{$s_menu->title}}</a></li>	
							@endforeach	
						</ul>
					</div>
					
				@endforeach
			@endif
			</div>
			<div class="mega-footer">
				<div class="container">

					<a href="{{url('blog')}}" class="btn btn-default">BLOG</a>
					<a href="{{url('talk-to-everest-summitters')}}" class="btn btn-default">Talk to Everest Summitters</a>
				</div>
			</div>
			<?php /* ?>
			 <div class="mega-footer">
				<div class="container">

					<a href="{{url('blog')}}" class="btn btn-default">BLOG</a>
					<a href="{{url('videos-everest-trekking')}}" class="btn btn-default">VLOG</a>
					<a href="{{url('talk-to-travel-expert')}}" class="btn btn-default">TALK TO OUR EXPERTS</a>
					<a href="{{url('great-himal-race')}}" class="btn btn-default">GREAT HIMAL RACE</a>
				</div>
			</div> 
			<?php */ ?>
		</div>
		<div class="booking-form">
			<div class="container">
				<div class="info row">
					<div class="col-md-12">
						<p>Flight Tickets available for domestic destinations within Nepal only.</p>
						<span class="close"><!-- <i class="fa fa-times" aria-hidden="true"></i> -->
						<img src="{{asset('images/close.png')}}" alt="">
					</span>
				</div>
			</div>
			<div class="form-wrap row">
				<form action="">
					<div class="col-md-12">
						<div class="radio">
							<div class="form-group">
								<input type="radio" id="radio01" name="radio" />
								<label for="radio01">
									<span>
										<span class="inner"></span>
									</span>
									Round Trip
								</label>
							</div>
							<div class="form-group">
								<input type="radio" id="radio02" name="radio" />
								<label for="radio02">
									<span>
										<span class="inner"></span>
									</span>
									One Way
								</label>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<select class="SlectBox form-control">
								<option selected="selected">From</option>
								<option>Lorem ipsum</option>
							</select>
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<select class="SlectBox form-control">
								<option selected="selected">To</option>
								<option>Consectetur </option>
							</select>
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group date-picker">
									<label for="from">Departure</label>
									<input type="text" id="from" name="from">
									<span class="calender-icon">
										<img src="{{asset('images/icon~calendar.png')}}">
									</span>
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group date-picker">
									<label for="to">Return</label>
									<input type="text" id="to" name="to">
									<span class="calender-icon">
										<img src="{{asset('images/icon~calendar.png')}}">
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="row">
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<label for="">Adult</label>
											<select class="SlectBox form-control">
												<option selected="selected">1</option>
												<option>2 </option>
												<option>3 </option>
											</select>
										</div>
									</div>
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<label for="">Children</label>
											<select class="SlectBox form-control">
												<option selected="selected">1</option>
												<option>2 </option>
												<option>3 </option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label for="">Nationality</label>
									<select class="SlectBox form-control">
										<option selected="selected">Nepali</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-offset-9 col-md-3  col-sm-offset-9 col-sm-3">
						<div class="form-group">
							<input class="btn btn-default" type="submit" value="FIND FLIGHT">
						</div>
					</div>
				</form>
				</div><!--form-wrap-->
			</div>
		</div>
	</header>