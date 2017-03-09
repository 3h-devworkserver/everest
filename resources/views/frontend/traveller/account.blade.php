@extends('frontend.layouts.master-new')
@section('title') Traveller Account | {{ $siteTitle }}@endsection
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
							<li role="presentation" class="active"><a href="#a" aria-controls="a" role="tab" data-toggle="tab">Transaction History</a></li>
							<li role="presentation"><a href="#b" aria-controls="b" role="tab" data-toggle="tab">Payment Methods</a></li>
							<li role="presentation"><a href="#c" aria-controls="c" role="tab" data-toggle="tab">Setting</a></li>
						</ul>
						<!-- Tab panes -->
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane active" id="a">
								<h4>Transaction History</h4>
								<hr>
								<p class="lead text-center">
									No Transactions
								</p>
							</div>
							<div role="tabpanel" class="tab-pane" id="b">
								<h4>Payment Methods</h4>
								<hr>
								<form action="#">
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<label>Choose Card <em>*</em></label>
												<select name="" id="" class="form-control">
													<option value="">Master Card</option>
													<option value="">Visa Card</option>
												</select>
											</div>
											<div class="col-md-6">
												<label>Card number <em>*</em></label>
												<input type="text" class="form-control">
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<label>Expires on <em>*</em></label>
												<div class="row">
													<div class="col-md-6">
														<input type="text" class="form-control" placeholder="Month">
													</div>
													<div class="col-md-3">
														<input type="text" class="form-control" placeholder="Date">
													</div>
													<div class="col-md-3">
														<input type="text" class="form-control" placeholder="Year">
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<label>Security Code <em>*</em></label>
												<input type="text" class="form-control">
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<label>First Name <em>*</em></label>
												<input class="form-control" type="text" placeholder="Your First Name">
											</div>
											<div class="col-md-6">
												<label>Last Name <em>*</em></label>
												<input class="form-control" type="text" placeholder="Your Last Name">
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<label>Postal code</label>
												<input class="form-control" type="text" placeholder="">
											</div>
											<div class="col-md-6">
												<label>Country</label>
												<input class="form-control" type="email" placeholder="">
											</div>
										</div>
									</div>
									<input type="submit" class="btn btn-danger" value="Add Payment Method">
								</form>
							</div>
							<div role="tabpanel" class="tab-pane" id="c">
								<h4>Account Setting</h4>
								<hr>
								<form action="#">
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<label>Country of Residence</label>
												<input class="form-control" type="text" placeholder="" value="Nepal">
											</div>
										</div>
									</div>
									<input type="submit" class="btn btn-danger" value="Save Country">
								</form>
								<hr> Deactivate My Account
								<hr>
								<button class="btn btn-danger">Decativated</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection