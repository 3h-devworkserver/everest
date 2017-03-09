@extends('frontend.layouts.master-new')
@section('title') Traveller Passport Image | {{ $siteTitle }}@endsection
@section('content')

<section class="main-content dashboard-wrapper">

	@include('frontend.traveller.includes.navbar')
	
	<div class="profile">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div>
						<!-- Nav tabs -->
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active"><a href="#a" aria-controls="a" role="tab" data-toggle="tab">Passport Info</a></li>
							<li role="presentation"><a href="#b" aria-controls="b" role="tab" data-toggle="tab">Passport Image</a></li>
							
						</ul>
						<!-- Tab panes -->
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane active" id="a">
								<h4>Passport Info</h4>
								<hr>
								<form action="#">
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<label>Passport Number <em>*</em></label>
												<input type="text" class="form-control">
											</div>
											<div class="col-md-6">
												<label>Passport Type</label>
												<input type="text" class="form-control">
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<label>Issue Date <em>*</em></label>
												<input type="text" class="form-control">
											</div>
											<div class="col-md-6">
												<label>Expire Date</label>
												<input type="text" class="form-control">
											</div>
										</div>
									</div>
									
									
									
									<input type="submit" class="btn btn-danger" value="Save">
								</form>
							</div>
							<div role="tabpanel" class="tab-pane" id="b">
								<h4>Passport Image</h4>
								<hr>
								<form action="#">
									<div class="form-group">
										<div class="row">
											<div class="col-md-12">
												<span class="btn btn-default btn-file passport-img">
													<i class="fa fa-image"></i>
													Upload Picture
													<input type="file">
												</span>

												<p class="help-block">
													image size not exceeds more than 100kb
												</p>
												
											</div>
											
										</div>
									</div>
									
									
									
									<input type="submit" class="btn btn-danger" value="Upload">
								</form>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection