<div class="search-cat">
	<form id="guide-search" action="{{URL::to('search/results')}}" method="get" >
		<div class="select-type type">
			<!-- <div class="SumoSelect" tabindex="0"> -->
			<select multiple="multiple" name="gAreas" class="testselect2" placeholder="Type">
				<option value="Tour">Tour</option>
				<option value="Trekking">Trekking</option>
				<option value="Safari">Safari</option>
				<option value="Bird-Watching">Bird Watching</option>
				<option value="Rafting">Rafting</option>
				<option value="Advanture-Sports">Advanture Sports</option>
				<option value="Peaking-Climbing">Peaking Climbing</option>
				<option value="Cycling">Cycling</option>
				<option value="Yoga-Meditation">Yoga Meditation</option>
			</select>
		</div>
		<div class="select-type">
			<!-- <select class="form-control">
					<option>Language</option>
					<option>Spanish</option>
					<option>Japanese</option>
			</select> -->
			<div class="dropdown availability">
				<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Availability
				<span><i></i></span>
				</button>
				<div class="dropdown-menu">
					<ul class="" aria-labelledby="dropdownMenu1">
						<label>
							<input type="radio" name="date" class="single">Single Day
						</label>
						<label>
							<input type="radio" name="date" class="between">Between Days
						</label>
					</ul>
					<div class="single-date-select">
						<p>
							<label>Date:</label>
							<input type="text" id="datepicker">
						</p>
						<button class="btn btn-primary cust-btn-sm pull-right">Select</button>
					</div>
					<div class="between-date-selection">
						<p>
							<label for="from">From :</label>
							<input type="text" id="from" name="from">
						</p>
						<p>
							<label for="to">To</label>
							<input type="text" id="to" name="to">
						</p>
						<button class="btn btn-primary cust-btn-sm pull-right">Select</button>
					</div>
				</div>
			</div>
		</div>
		<div class="select-type">
			<!-- <select class="form-control">
					<option>Language</option>
					<option>Spanish</option>
					<option>Japanese</option>
			</select> -->
			<!-- <div class="SumoSelect" tabindex="0"> -->
			<select multiple="multiple" name="somename0" class="testselect2" placeholder="Select Language">
				<option value="Spanish">Spanish</option>
				<option value="English">English</option>
				<option value="French">French</option>
			</select>
		</div>
		<div class="select-type select-one">
			<!-- <select class="form-control">
						<option>Order</option>
						<option>Experience</option>
						<option>Rating</option>
			</select> -->
			<select placeholder="Order" class="SlectBox">
				<option value=""></option>
				<option value="Experience">Experience</option>
				<option value="Rating">Rating</option>
			</select>
		</div>
		<div class="input-type">
			<input type="text" placeholder="Name, Destination">
		</div>
		<div class="submit-wrap">
			<!-- <input type="submit" value="" class="btn btn-danger"> -->
			<button class="btn btn-danger"><i class="fa fa-search"></i></button>
		</div>
	</form>
</div>