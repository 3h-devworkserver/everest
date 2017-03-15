@extends('frontend.layouts.master-new')

@section('title'){{ $meta_title }}@endsection
<!--@section('meta_title'){{ $meta_title }}@endsection-->
@section('meta_keywords'){{ $meta_keywords }}@endsection
@section('meta_desc'){{ $meta_desc }}@endsection


@section('content')

<div class="extra-traveller display-none">
	<div class="form-group">
		<span class="form-title">Contact:</span>
		<div class="row">
			<div class="col-md-3 col-sm-4">
				<label>Title <em>*</em></label>
				{!! Form::select('title[]', [''=>'Title', 'MR'=>'Mr', 'MRS'=>'Mrs', 'MS'=>'Ms'], null, ['class'=>'box form-control' ]) !!}
				{{-- {!! Form::select('title[]', [''=>'Title', 'MR'=>'Mr', 'MRS'=>'Mrs', 'MS'=>'Ms', 'DR'=>'Dr', 'PROF'=>'Prof', 'CAPT'=>'Captain', 'SHK'=>'Sheikh', 'SHKA'=>'Shaikha', 'GENE'=>'General', 'BRIG'=>'Brigadier', 'COLO'=>'Colonel'], null, ['class'=>'box form-control','required' ]) !!} --}}
					<!-- <select name="title" class="SlectBox form-control">
                        <option value="" selected="selected">Title</option>
                        <option value="MR">Mr</option>
                        <option value="MRS">Mrs</option>
                        <option value="MS">Ms</option>
                        <option value="DR">Dr</option>
                        <option value="PROF">Prof</option>
                        <option value="CAPT">Captain</option>
                        <option value="SHK">Sheikh</option>
                        <option value="SHKA">Shaikha</option>
                        <option value="GENE">General</option>
                        <option value="BRIG">Brigadier</option>
                        <option value="COLO">Colonel</option>
                    </select> -->

                </div>
                <div class="col-md-3 col-sm-4">
                	<label>First Name <em>*</em></label>
                	{!!Form::text('fname[]',null, ['class'=>'form-control', ]) !!}
                </div>
                <div class="col-md-3 col-sm-4">
                	<label>Middle Name</label>
                	{!!Form::text('mname[]',null, ['class'=>'form-control']) !!}
                </div>
                <div class="col-md-3 col-sm-4">
                	<label>Last Name <em>*</em></label>
                	{!!Form::text('lname[]',null, ['class'=>'form-control', ]) !!}
                </div>
            </div>
            <div class="row">

            	<div class="col-md-6 col-sm-6">
            		<label>Phone Number</label>
            		{!!Form::text('phone[]',null, ['class'=>'form-control']) !!}
            	</div>
            	<div class="col-md-6 col-sm-12 date-birth">
            		<label>Date Of Birth <em>*</em></label>
            		<div class="row">
            			<div class="col-md-5 col-sm-6 col-xs-6 pad-adj">
            				<select name="dob_year[]" class="yearpicker form-control box" >
            					<option value="">YEAR</option>
            				</select>
            			</div>
            			<div class="col-md-7 col-sm-6 col-xs-6 pad-adj">
            				<div class="row-fluid">
            					<div class="col-md-6 col-sm-6 col-xs-6">
            						{!! Form::select('dob_month[]', [''=>'MM', '1'=>'Jan', '2'=>'Feb', '3'=>'Mar', '4'=>'Apr', '5'=>'May', '6'=>'Jun', '7'=>'Jul', '8'=>'Aug', '9'=>'Sep', '10'=>'Oct', '11'=>'Nov', '12'=>'Dec'], null, ['class'=>'box form-control', ]) !!}
            						{{-- {!! Form::select('dob_month', [''=>'MM', '1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5', '6'=>'6', '7'=>'7', '8'=>'8', '9'=>'9', '10'=>'10', '11'=>'11', '12'=>'12'], null, ['class'=>'SlectBox form-control', ]) !!} --}}
            						{{-- {!! Form::input('number', 'dob_month', null, ['placeholder'=>'MM', 'class' => 'form-control', 'min'=>'01', 'max'=>'12', ]) !!} --}}
            						{{-- <input type="text" name="dob_month"  class="form-control" placeholder="MM"> --}}
            					</div>
            					<div class="col-md-6 col-sm-6 col-xs-6">
            						<select name="dob_day[]" class="daypicker form-control box" >
            							<option value="">DD</option>
            						</select>
            					</div>
            				</div>
            			</div>
            		</div>
            	</div>
            </div>

            <div class="row">
            	<div class="col-md-4 col-sm-6">
            		<label>Email <em>*</em></label>
            		{!!Form::email('email[]',null, ['class'=>'form-control', ]) !!}
            	</div>
            	<div class="col-md-4 col-sm-6">
            		<label>Password <em>*</em></label>
            		{!!Form::input('password', 'password' ,null, ['class'=>'form-control passfield', 'id'=>'password' ]) !!}
            	</div>
            	<div class="col-md-4 col-sm-6">
            		<label>Confirm Password <em>*</em></label>
            		{!!Form::input('password', 'password_confirmation' ,null, ['class'=>'form-control passfield', ]) !!}
            	</div>
            </div>

        </div>

        <div class="form-group">
        	<span class="form-title">PASSPORT:</span>
        	<div class="row">
        		<div class="col-md-4 col-sm-6">
        			<label>Passport Number <em>*</em></label>
        			{!!Form::text('passport[]',null, ['class'=>'form-control', ]) !!}
        		</div>
        		<div class="col-md-3 col-sm-6">
        			<label>Nationality</label>
        			{!!Form::text('nationality[]',null, ['class'=>'form-control']) !!}
        		</div>
        		<div class="col-md-5 col-sm-12 issue-date">
        			<label>Issue Date <em>*</em></label>
        			<div class="row">
        				<div class="col-md-5 col-sm-6  col-xs-6 pad-adj">
        					<select name="issue_year[]" class="yearpicker form-control box" >
        						<option value="">YEAR</option>
        					</select>
        				</div>
        				<div class="col-md-7 col-sm-6  col-xs-6 pad-adj">
        					<div class="row-fluid">
        						<div class="col-md-6 col-sm-6 col-xs-6 ">
        							{!! Form::select('issue_month[]', [''=>'MM', '1'=>'Jan', '2'=>'Feb', '3'=>'Mar', '4'=>'Apr', '5'=>'May', '6'=>'Jun', '7'=>'Jul', '8'=>'Aug', '9'=>'Sep', '10'=>'Oct', '11'=>'Nov', '12'=>'Dec'], null, ['class'=>'box form-control', ]) !!}
        						</div>
        						<div class="col-md-6 col-sm-6 col-xs-6 ">
        							<select name="issue_day[]" class="daypicker form-control box" >
        								<option value="">DD</option>
        							</select>
        						</div>
        					</div>
        				</div>
        			</div>
        		</div>
        	</div>
        	<div class="row">
        		<div class="col-md-4 col-sm-6">
        			<label>Passport Issue Place</label>
        			{!!Form::text('issue_place[]',null, ['class'=>'form-control']) !!}
        		</div>
        		<div class="col-md-3 col-sm-6">
        			<label>Upload Passport Image<em>*</em></label>
        			<span class="btn btn-primary btn-file btn-sm">
        				<i class="fa fa-folder-open"></i>Upload
        				<input type="file" id="image" class="image" name="image[]" >
        			</span>
        			<span class="image-name"></span>
        		</div>

        		<div class="col-md-5 col-sm-12 issue-date">
        			<label>Expiration Date <em>*</em></label>
        			<div class="row">
        				<div class="col-md-5 col-sm-6  col-xs-6 pad-adj">
        					<select name="exp_year[]" class="yearpicker form-control box" >
        						<option value="">YEAR</option>
        					</select>
        				</div>
        				<div class="col-md-7 col-sm-6  col-xs-6 pad-adj">
        					<div class="row-fluid">
        						<div class="col-md-6 col-sm-6 col-xs-6 ">
        							{!! Form::select('exp_month[]', [''=>'MM', '1'=>'Jan', '2'=>'Feb', '3'=>'Mar', '4'=>'Apr', '5'=>'May', '6'=>'Jun', '7'=>'Jul', '8'=>'Aug', '9'=>'Sep', '10'=>'Oct', '11'=>'Nov', '12'=>'Dec'], null, ['class'=>'box form-control', ]) !!}
        						</div>
        						<div class="col-md-6 col-sm-6 col-xs-6 ">
        							<select name="exp_day[]" class="daypicker form-control box" >
        								<option value="">DD</option>
        							</select>
        						</div>
        					</div>
        				</div>
        			</div>
        		</div>
        	</div>

        </div>
        <div class="form-group">
        	<span class="form-title">address:</span>
        	<div class="row">
        		<div class="col-md-6 col-sm-5">
        			<label>Mailing Address <em>*</em></label>
        			{!!Form::text('address[]',null, ['class'=>'form-control', ]) !!}
        		</div>
        		<div class="col-md-3 col-sm-3">
        			<label>City<em>*</em></label>
        			{!!Form::text('city[]',null, ['class'=>'form-control', ]) !!}
        		</div>
        		<div class="col-md-3 col-sm-4 issue-date">
        			<label>Postal/Zip Code <em>*</em></label>
        			{!!Form::text('postal_zip[]',null, ['class'=>'form-control', ]) !!}
        		</div>
        	</div>
        	<div class="row">
        		<div class="col-md-4 col-sm-6">
        			<label>Country<em>*</em></label>
        			{!!Form::select('country[]', [], null, ['class'=>'form-control countrylist' ]) !!}
        		</div>
                <div class="col-md-4 col-sm-6">
                    <label>Province of State</label>
                    {!!Form::select('state[]', [], null, ['class'=>'form-control statelist']) !!}
                </div>
        	</div>

        </div>

        <div class="form-group">
        	<span class="form-title">Medical:</span>
        	<div class="row">
        		<div class="col-md-4 col-sm-6">
        			<label>Emergency First Name <em>*</em></label>
        			{!!Form::text('em_fname[]',null, ['class'=>'form-control', ]) !!}
        		</div>
        		<div class="col-md-4 col-sm-6">
        			<label>Emergency Last Name <em>*</em></label>
        			{!!Form::text('em_lname[]',null, ['class'=>'form-control', ]) !!}
        		</div>
        		<div class="col-md-4 col-sm-6 issue-date">
        			<label>Emergency Phone Number<em>*</em></label>
        			{!!Form::text('em_phone[]',null, ['class'=>'form-control', ]) !!}
        		</div>
        	</div>
        	<div class="row">
        		<div class="col-md-4 col-sm-6">
        			<label>Country<em>*</em></label>
        			{!!Form::select('em_country[]', [], null, ['class'=>'form-control countrylist' ]) !!}
        		</div>
                <div class="col-md-4 col-sm-6">
                    <label>Province of State</label>
                    {!!Form::select('em_state[]', [], null, ['class'=>'form-control statelist']) !!}
                </div>
        	</div>

        </div>
    </div>

    <div class="extra-traveller2 display-none">
    	<div class="form-group">
    		<span class="form-title">Contact:</span>
    		<div class="row">
    			<div class="col-md-3 col-sm-4">
    				<label>Title <em>*</em></label>
    				{!! Form::select('title[]', [''=>'Title', 'MR'=>'Mr', 'MRS'=>'Mrs', 'MS'=>'Ms'], null, ['class'=>'box form-control' ]) !!}
    				{{-- {!! Form::select('title[]', [''=>'Title', 'MR'=>'Mr', 'MRS'=>'Mrs', 'MS'=>'Ms', 'DR'=>'Dr', 'PROF'=>'Prof', 'CAPT'=>'Captain', 'SHK'=>'Sheikh', 'SHKA'=>'Shaikha', 'GENE'=>'General', 'BRIG'=>'Brigadier', 'COLO'=>'Colonel'], null, ['class'=>'box form-control','required' ]) !!} --}}
					<!-- <select name="title" class="SlectBox form-control">
                        <option value="" selected="selected">Title</option>
                        <option value="MR">Mr</option>
                        <option value="MRS">Mrs</option>
                        <option value="MS">Ms</option>
                        <option value="DR">Dr</option>
                        <option value="PROF">Prof</option>
                        <option value="CAPT">Captain</option>
                        <option value="SHK">Sheikh</option>
                        <option value="SHKA">Shaikha</option>
                        <option value="GENE">General</option>
                        <option value="BRIG">Brigadier</option>
                        <option value="COLO">Colonel</option>
                    </select> -->

                </div>
                <div class="col-md-3 col-sm-4">
                	<label>First Name <em>*</em></label>
                	{!!Form::text('fname[]',null, ['class'=>'form-control', ]) !!}
                </div>
                <div class="col-md-3 col-sm-4">
                	<label>Middle Name</label>
                	{!!Form::text('mname[]',null, ['class'=>'form-control']) !!}
                </div>
                <div class="col-md-3 col-sm-4">
                	<label>Last Name <em>*</em></label>
                	{!!Form::text('lname[]',null, ['class'=>'form-control', ]) !!}
                </div>
            </div>
            <div class="row">
            	<div class="col-md-4 col-sm-6">
            		<label>Email <em>*</em></label>
            		{!!Form::email('email[]',null, ['class'=>'form-control', ]) !!}
            	</div>
            	<div class="col-md-3 col-sm-6">
            		<label>Phone Number</label>
            		{!!Form::text('phone[]',null, ['class'=>'form-control']) !!}
            	</div>
            	<div class="col-md-5 col-sm-12 date-birth">
            		<label>Date Of Birth <em>*</em></label>
            		<div class="row">
            			<div class="col-md-5 col-sm-6 col-xs-6 pad-adj">
            				<select name="dob_year[]" class="yearpicker form-control box" >
            					<option value="">YEAR</option>
            				</select>
            			</div>
            			<div class="col-md-7 col-sm-6 col-xs-6 pad-adj">
            				<div class="row-fluid">
            					<div class="col-md-6 col-sm-6 col-xs-6">
            						{!! Form::select('dob_month[]', [''=>'MM', '1'=>'Jan', '2'=>'Feb', '3'=>'Mar', '4'=>'Apr', '5'=>'May', '6'=>'Jun', '7'=>'Jul', '8'=>'Aug', '9'=>'Sep', '10'=>'Oct', '11'=>'Nov', '12'=>'Dec'], null, ['class'=>'box form-control', ]) !!}
            						{{-- {!! Form::select('dob_month', [''=>'MM', '1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5', '6'=>'6', '7'=>'7', '8'=>'8', '9'=>'9', '10'=>'10', '11'=>'11', '12'=>'12'], null, ['class'=>'SlectBox form-control', ]) !!} --}}
            						{{-- {!! Form::input('number', 'dob_month', null, ['placeholder'=>'MM', 'class' => 'form-control', 'min'=>'01', 'max'=>'12', ]) !!} --}}
            						{{-- <input type="text" name="dob_month"  class="form-control" placeholder="MM"> --}}
            					</div>
            					<div class="col-md-6 col-sm-6 col-xs-6">
            						<select name="dob_day[]" class="daypicker form-control box" >
            							<option value="">DD</option>
            						</select>
            					</div>
            				</div>
            			</div>
            		</div>
            	</div>
            </div>

        </div>

        <div class="form-group">
        	<span class="form-title">PASSPORT:</span>
        	<div class="row">
        		<div class="col-md-4 col-sm-6">
        			<label>Passport Number <em>*</em></label>
        			{!!Form::text('passport[]',null, ['class'=>'form-control', ]) !!}
        			{{-- <input type="text" class="form-control"> --}}
        		</div>
        		<div class="col-md-3 col-sm-6">
        			<label>Nationality</label>
        			{!!Form::text('nationality[]',null, ['class'=>'form-control']) !!}
        		</div>
        		<div class="col-md-5 col-sm-12 issue-date">
        			<label>Issue Date <em>*</em></label>
        			<div class="row">
        				<div class="col-md-5 col-sm-6  col-xs-6 pad-adj">
        					<select name="issue_year[]" class="yearpicker form-control box" >
        						<option value="">YEAR</option>
        					</select>
        				</div>
        				<div class="col-md-7 col-sm-6  col-xs-6 pad-adj">
        					<div class="row-fluid">
        						<div class="col-md-6 col-sm-6 col-xs-6 ">
        							{!! Form::select('issue_month[]', [''=>'MM', '1'=>'Jan', '2'=>'Feb', '3'=>'Mar', '4'=>'Apr', '5'=>'May', '6'=>'Jun', '7'=>'Jul', '8'=>'Aug', '9'=>'Sep', '10'=>'Oct', '11'=>'Nov', '12'=>'Dec'], null, ['class'=>'box form-control', ]) !!}
        						</div>
        						<div class="col-md-6 col-sm-6 col-xs-6 ">
        							<select name="issue_day[]" class="daypicker form-control box" >
        								<option value="">DD</option>
        							</select>
        						</div>
        					</div>
        				</div>
        			</div>
        		</div>
        	</div>
        	<div class="row">
        		<div class="col-md-4 col-sm-6">
        			<label>Passport Issue Place</label>
        			{!!Form::text('issue_place[]',null, ['class'=>'form-control']) !!}
        		</div>
        		<div class="col-md-3 col-sm-6">
        			<label>Upload Passport Image<em>*</em></label>
        			<span class="btn btn-primary btn-file btn-sm">
        				<i class="fa fa-folder-open"></i>Upload
        				<input type="file" id="image" class="image" name="image[]" >
        			</span>
        			<span class="image-name"></span>
        		</div>

        		<div class="col-md-5 col-sm-12 issue-date">
        			<label>Expiration Date <em>*</em></label>
        			<div class="row">
        				<div class="col-md-5 col-sm-6  col-xs-6 pad-adj">
        					<select name="exp_year[]" class="yearpicker form-control box" >
        						<option value="">YEAR</option>
        					</select>
        				</div>
        				<div class="col-md-7 col-sm-6  col-xs-6 pad-adj">
        					<div class="row-fluid">
        						<div class="col-md-6 col-sm-6 col-xs-6 ">
        							{!! Form::select('exp_month[]', [''=>'MM', '1'=>'Jan', '2'=>'Feb', '3'=>'Mar', '4'=>'Apr', '5'=>'May', '6'=>'Jun', '7'=>'Jul', '8'=>'Aug', '9'=>'Sep', '10'=>'Oct', '11'=>'Nov', '12'=>'Dec'], null, ['class'=>'box form-control', ]) !!}
        						</div>
        						<div class="col-md-6 col-sm-6 col-xs-6 ">
        							<select name="exp_day[]" class="daypicker form-control box" >
        								<option value="">DD</option>
        							</select>
        						</div>
        					</div>
        				</div>
        			</div>
        		</div>
        	</div>

        </div>
        <div class="form-group">
        	<span class="form-title">address:</span>
        	<div class="row">
        		<div class="col-md-6 col-sm-5">
        			<label>Mailing Address <em>*</em></label>
        			{!!Form::text('address[]',null, ['class'=>'form-control', ]) !!}
        		</div>
        		<div class="col-md-3 col-sm-3">
        			<label>City<em>*</em></label>
        			{!!Form::text('city[]',null, ['class'=>'form-control', ]) !!}
        		</div>
        		<div class="col-md-3 col-sm-4 issue-date">
        			<label>Postal/Zip Code <em>*</em></label>
        			{!!Form::text('postal_zip[]',null, ['class'=>'form-control', ]) !!}
        		</div>
        	</div>
        	<div class="row">
        		<div class="col-md-4 col-sm-6">
        			<label>Country<em>*</em></label>
        			{!!Form::select('country[]', [], null, ['class'=>'form-control countrylist' ]) !!}
        		</div>
                <div class="col-md-4 col-sm-6">
                    <label>Province of State</label>
                    {!!Form::select('state[]', [], null, ['class'=>'form-control statelist']) !!}
                </div>
        	</div>
        </div>

        <div class="form-group">
        	<span class="form-title">Medical:</span>
        	<div class="row">
        		<div class="col-md-4 col-sm-6">
        			<label>Emergency First Name <em>*</em></label>
        			{!!Form::text('em_fname[]',null, ['class'=>'form-control', ]) !!}
        		</div>
        		<div class="col-md-4 col-sm-6">
        			<label>Emergency Last Name <em>*</em></label>
        			{!!Form::text('em_lname[]',null, ['class'=>'form-control', ]) !!}
        		</div>
        		<div class="col-md-4 col-sm-6 issue-date">
        			<label>Emergency Phone Number<em>*</em></label>
        			{!!Form::text('em_phone[]',null, ['class'=>'form-control', ]) !!}
        		</div>
        	</div>
        	<div class="row">
        		<div class="col-md-4 col-sm-6">
        			<label>Country<em>*</em></label>
        			{!!Form::select('em_country[]', [], null, ['class'=>'form-control countrylist' ]) !!}
        		</div>
                <div class="col-md-4 col-sm-6">
                    <label>Province of State</label>
                    {!!Form::select('em_state[]', [], null, ['class'=>'form-control statelist']) !!}
                </div>
        	</div>

        </div>
    </div>

{{-- <section class="banner bg-wrap {!! $page->image !!}" style="background-image: url({!! url().'/images/'.$page->image !!});">
    <div class="container"></div>
</section> --}}
{{-- @include('frontend.includes.region') --}}
{{-- @include('frontend.includes.new.search') --}}


<div class="main-content">
	<div class="container">
		{!!Form:: open(['url'=>'package/'.$slug.'/'.$datePrice.'/booking-step2', 'id'=>'traveller-info', 'files'=>'true']) !!}
		<div class="travel-booking">
			<div class="travel-booking-step">
				<div class="row">
					<div class="col-md-12">
						<a href="#" class="active">Step 1 - Travellers </a>
						<a href="#" >Step 2 - Summary  </a>
						<a href="#">Step 3 - Confirm </a>
					</div>
				</div>
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
					
					<div class="travel-form">

						<div class="form-group">
							<span class="form-title">Travellers: 
							</span>

							<div class="traveller-select">
								<h4>How may people are you travelling with?</h4>
								<div class="select-menu">
									<label>Adult(18+)</label>
									<select name="adult" id="adult" class="SlectBox form-control" data-rate="{{$dPrice->price}}">
										<option>1</option>
										<option>2</option>
										<option>3</option>
										<option>4</option>
									</select>
								</div>
							</div>

						</div>

						<p class="form-title">Lead Traveller:</p>
						<div class="form-info">

							<div class="form-group">
								<span class="form-title">Contact:</span>

								<div class="row">
									<div class="col-md-3 col-sm-4">
										<label>Title <em>*</em></label>
										{!! Form::select('title[]', [''=>'Title', 'MR'=>'Mr', 'MRS'=>'Mrs', 'MS'=>'Ms'], null, ['class'=>'box form-control' ]) !!}
										{{--	{!! Form::select('title[]', [''=>'Title', 'MR'=>'Mr', 'MRS'=>'Mrs', 'MS'=>'Ms', 'DR'=>'Dr', 'PROF'=>'Prof', 'CAPT'=>'Captain', 'SHK'=>'Sheikh', 'SHKA'=>'Shaikha', 'GENE'=>'General', 'BRIG'=>'Brigadier', 'COLO'=>'Colonel'], null, ['class'=>'SlectBox form-control' ]) !!} --}}
													<!-- <select name="title" class="SlectBox form-control">
					                                    <option value="" selected="selected">Title</option>
					                                    <option value="MR">Mr</option>
					                                    <option value="MRS">Mrs</option>
					                                    <option value="MS">Ms</option>
					                                    <option value="DR">Dr</option>
					                                    <option value="PROF">Prof</option>
					                                    <option value="CAPT">Captain</option>
					                                    <option value="SHK">Sheikh</option>
					                                    <option value="SHKA">Shaikha</option>
					                                    <option value="GENE">General</option>
					                                    <option value="BRIG">Brigadier</option>
					                                    <option value="COLO">Colonel</option>
					                                </select> -->

					                            </div>
					                            <div class="col-md-3 col-sm-4">
					                            	<label>First Name <em>*</em></label>
					                            	{!!Form::text('fname[]',null, ['class'=>'form-control', ]) !!}
					                            </div>
					                            <div class="col-md-3 col-sm-4">
					                            	<label>Middle Name</label>
					                            	{!!Form::text('mname[]',null, ['class'=>'form-control']) !!}
					                            </div>
					                            <div class="col-md-3 col-sm-4">
					                            	<label>Last Name <em>*</em></label>
					                            	{!!Form::text('lname[]',null, ['class'=>'form-control', ]) !!}
					                            </div>
					                        </div>
					                        <div class="row">

					                        	<div class="col-md-6 col-sm-6">
					                        		<label>Phone Number</label>
					                        		{!!Form::text('phone[]',null, ['class'=>'form-control']) !!}
					                        	</div>
					                        	<div class="col-md-6 col-sm-12 date-birth">
					                        		<label>Date Of Birth <em>*</em></label>
					                        		<div class="row">
					                        			<div class="col-md-5 col-sm-6 col-xs-6 pad-adj">
					                        				<select name="dob_year[]" class="yearpicker form-control box" >
					                        					<option value="">YEAR</option>
					                        				</select>
					                        			</div>
					                        			<div class="col-md-7 col-sm-6 col-xs-6 pad-adj">
					                        				<div class="row-fluid">
					                        					<div class="col-md-6 col-sm-6 col-xs-6">
					                        						{!! Form::select('dob_month[]', [''=>'MM', '1'=>'Jan', '2'=>'Feb', '3'=>'Mar', '4'=>'Apr', '5'=>'May', '6'=>'Jun', '7'=>'Jul', '8'=>'Aug', '9'=>'Sep', '10'=>'Oct', '11'=>'Nov', '12'=>'Dec'], null, ['class'=>'box form-control', ]) !!}
					                        						{{-- {!! Form::select('dob_month', [''=>'MM', '1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5', '6'=>'6', '7'=>'7', '8'=>'8', '9'=>'9', '10'=>'10', '11'=>'11', '12'=>'12'], null, ['class'=>'SlectBox form-control', ]) !!} --}}
					                        						{{-- {!! Form::input('number', 'dob_month', null, ['placeholder'=>'MM', 'class' => 'form-control', 'min'=>'01', 'max'=>'12', ]) !!} --}}
					                        						{{-- <input type="text" name="dob_month"  class="form-control" placeholder="MM"> --}}
					                        					</div>
					                        					<div class="col-md-6 col-sm-6 col-xs-6">
					                        						<select name="dob_day[]" class="daypicker form-control box" >
					                        							<option value="">DD</option>
					                        						</select>
					                        					</div>
					                        				</div>
					                        			</div>
					                        		</div>
					                        	</div>
					                        </div>

					                        <div class="row">
					                        	<div class="col-md-4 col-sm-6">
					                        		<label>Email <em>*</em></label>
					                        		{!!Form::email('email[]',null, ['class'=>'form-control', ]) !!}
					                        	</div>
					                        	<div class="col-md-4 col-sm-6">
					                        		<label>Password <em>*</em></label>
					                        		{!!Form::input('password', 'password' ,null, ['class'=>'form-control passfield', 'id'=>'password']) !!}
					                        	</div>
					                        	<div class="col-md-4 col-sm-6">
					                        		<label>Confirm Password <em>*</em></label>
					                        		{!!Form::input('password', 'password_confirmation' ,null, ['class'=>'form-control passfield', 'id'=>'password_confirmation' ]) !!}
					                        	</div>
					                        </div>

					                    </div>

					                    <div class="form-group">
					                    	<span class="form-title">PASSPORT:</span>
					                    	<div class="row">
					                    		<div class="col-md-4 col-sm-6">
					                    			<label>Passport Number <em>*</em></label>
					                    			{!!Form::text('passport[]',null, ['class'=>'form-control', ]) !!}
					                    		</div>
					                    		<div class="col-md-3 col-sm-6">
					                    			<label>Nationality</label>
					                    			{!!Form::text('nationality[]',null, ['class'=>'form-control']) !!}
					                    		</div>
					                    		<div class="col-md-5 col-sm-12 issue-date">
					                    			<label>Issue Date <em>*</em></label>
					                    			<div class="row">
					                    				<div class="col-md-5 col-sm-6  col-xs-6 pad-adj">
					                    					<select name="issue_year[]" class="yearpicker form-control box" >
					                    						<option value="">YEAR</option>
					                    					</select>
					                    				</div>
					                    				<div class="col-md-7 col-sm-6  col-xs-6 pad-adj">
					                    					<div class="row-fluid">
					                    						<div class="col-md-6 col-sm-6 col-xs-6 ">
					                    							{!! Form::select('issue_month[]', [''=>'MM', '1'=>'Jan', '2'=>'Feb', '3'=>'Mar', '4'=>'Apr', '5'=>'May', '6'=>'Jun', '7'=>'Jul', '8'=>'Aug', '9'=>'Sep', '10'=>'Oct', '11'=>'Nov', '12'=>'Dec'], null, ['class'=>'box form-control', ]) !!}
					                    						</div>
					                    						<div class="col-md-6 col-sm-6 col-xs-6 ">
					                    							<select name="issue_day[]" class="daypicker form-control box" >
					                    								<option value="">DD</option>
					                    							</select>
					                    						</div>
					                    					</div>
					                    				</div>
					                    			</div>
					                    		</div>
					                    	</div>
					                    	<div class="row">
					                    		<div class="col-md-4 col-sm-6">
					                    			<label>Passport Issue Place</label>
					                    			{!!Form::text('issue_place[]',null, ['class'=>'form-control']) !!}
					                    		</div>
					                    		<div class="col-md-3 col-sm-6">
					                    			<label>Passport Image<em>*</em></label>
					                    			<span class="btn btn-primary btn-file btn-sm">
					                    				<i class="fa fa-folder-open"></i>Upload
					                    				<input type="file" id="image" class="image" name="image[]" >
					                    			</span>
					                    			<span class="image-name"></span>
					                    		</div>

					                    		<div class="col-md-5 col-sm-12 issue-date">
					                    			<label>Expiration Date <em>*</em></label>
					                    			<div class="row">
					                    				<div class="col-md-5 col-sm-6  col-xs-6 pad-adj">
					                    					<select name="exp_year[]" class="yearpicker form-control box" >
					                    						<option value="">YEAR</option>
					                    					</select>
					                    				</div>
					                    				<div class="col-md-7 col-sm-6  col-xs-6 pad-adj">
					                    					<div class="row-fluid">
					                    						<div class="col-md-6 col-sm-6 col-xs-6 ">
					                    							{!! Form::select('exp_month[]', [''=>'MM', '1'=>'Jan', '2'=>'Feb', '3'=>'Mar', '4'=>'Apr', '5'=>'May', '6'=>'Jun', '7'=>'Jul', '8'=>'Aug', '9'=>'Sep', '10'=>'Oct', '11'=>'Nov', '12'=>'Dec'], null, ['class'=>'box form-control', ]) !!}
					                    						</div>
					                    						<div class="col-md-6 col-sm-6 col-xs-6 ">
					                    							<select name="exp_day[]" class="daypicker form-control box" >
					                    								<option value="">DD</option>
					                    							</select>
					                    						</div>
					                    					</div>
					                    				</div>
					                    			</div>
					                    		</div>
					                    	</div>

					                    </div>
					                    <div class="form-group">
					                    	<span class="form-title">address:</span>
					                    	<div class="row">
					                    		<div class="col-md-6 col-sm-5">
					                    			<label>Mailing Address <em>*</em></label>
					                    			{!!Form::text('address[]',null, ['class'=>'form-control', ]) !!}
					                    		</div>
					                    		<div class="col-md-3 col-sm-3">
					                    			<label>City<em>*</em></label>
					                    			{!!Form::text('city[]',null, ['class'=>'form-control', ]) !!}
					                    		</div>
					                    		<div class="col-md-3 col-sm-4 issue-date">
					                    			<label>Postal/Zip Code <em>*</em></label>
					                    			{!!Form::text('postal_zip[]',null, ['class'=>'form-control', ]) !!}
					                    		</div>
					                    	</div>
					                    	<div class="row">
					                    		<div class="col-md-4 col-sm-6">
					                    			<label>Country<em>*</em></label>
                                                    {!!Form::select('country[]', [], null, ['class'=>'form-control countrylist', 'id' => 'country_id' ]) !!}
					                    			{{-- {!!Form::select('country[]', [], null, ['class'=>'form-control countrylist', 'id' => 'country_id', 'onchange'=>"print_state(this.closest('[class^=col-md]').next(),this.selectedIndex);" ]) !!} --}}
					                    		</div>
                                                <div class="col-md-4 col-sm-6">
                                                    <label>Province of State</label>
                                                    {!!Form::select('state[]', [], null, ['class'=>'form-control statelist']) !!}
                                                </div>
					                    	</div>

					                    </div>

					                    <div class="form-group">
					                    	<span class="form-title">Medical:</span>
					                    	<div class="row">
					                    		<div class="col-md-4 col-sm-6">
					                    			<label>Emergency First Name <em>*</em></label>
					                    			{!!Form::text('em_fname[]',null, ['class'=>'form-control', ]) !!}
					                    		</div>
					                    		<div class="col-md-4 col-sm-6">
					                    			<label>Emergency Last Name <em>*</em></label>
					                    			{!!Form::text('em_lname[]',null, ['class'=>'form-control', ]) !!}
					                    		</div>
					                    		<div class="col-md-4 col-sm-6 issue-date">
					                    			<label>Emergency Phone Number<em>*</em></label>
					                    			{!!Form::text('em_phone[]',null, ['class'=>'form-control', ]) !!}

					                    		</div>
					                    	</div>
					                    	<div class="row">
					                    		<div class="col-md-4 col-sm-6">
					                    			<label>Country<em>*</em></label>
					                    			{!!Form::select('em_country[]', [], null, ['class'=>'form-control countrylist', ]) !!}
					                    		</div>
                                                <div class="col-md-4 col-sm-6">
                                                    <label>Province of State</label>
                                                    {!!Form::select('em_state[]', [], null, ['class'=>'form-control statelist']) !!}
                                                </div>
					                    	</div>

					                    </div>

					                </div>

					                <div class="add-extra-package">
					                	<div class="row">
                                            <?php $i=1; ?> 					
                                            @foreach($addon as $pack)
                                            <div class="col-md-6 col-sm-6">
                                                <div class="thumbnail">

                                                    <div class="checkbox">
                                                        {{-- <input type="checkbox" id="check{{$i}}" name="package[]" class="addxtraPack" value="{{$pack->price}}" data-id="{{$pack->id}}"> --}}
                                                        <label for="check{{$i}}">{{$pack->title}}</label>
                                                    </div> 
                                                    <div class="thumb-img bg-wrap" style="background-image:url({{asset('images/packages-new/'.$pack->feat_img) }});">
                                                        <div class="pack-msg"><p>Extension package selected.</p></div>
                                                    </div>
                                                    <div class="price">+NPR {{$pack->price}} <small>per Person</small></div>
                                                    <div class="addextraPackageDiv">
                                                        <div class="select-number">
                                                            <label>For</label>
                                                            <select name="addon_packages_detail[]" data-id="{{$pack->id}}" class="form-control addonPackage ">
                                                                <option value="">-- Select --</option>
                                                                <option value="{{$pack->id.'-'.'1'.'-'.$pack->price}}" data-no="1" data-title="{{$pack->title}}" data-id="{{$pack->id}}" data-price="{{$pack->price}}">1</option>
                                                                <option value="{{$pack->id.'-'.'2'.'-'.$pack->price * 2}}" data-no="2" data-title="{{$pack->title}}" data-id="{{$pack->id}}" data-price="{{$pack->price *2}}">2</option>
                                                                <option value="{{$pack->id.'-'.'3'.'-'.$pack->price * 3}}" data-no="3" data-title="{{$pack->title}}" data-id="{{$pack->id}}" data-price="{{$pack->price *3}}">3</option>
                                                                <option value="{{$pack->id.'-'.'4'.'-'.$pack->price * 4}}" data-no="4" data-title="{{$pack->title}}" data-id="{{$pack->id}}" data-price="{{$pack->price *4}}">4</option>
                                                                <option value="{{$pack->id.'-'.'5'.'-'.$pack->price * 5}}" data-no="5" data-title="{{$pack->title}}" data-id="{{$pack->id}}" data-price="{{$pack->price *5}}">5</option>
                                                                <option value="{{$pack->id.'-'.'6'.'-'.$pack->price * 6}}" data-no="6" data-title="{{$pack->title}}" data-id="{{$pack->id}}" data-price="{{$pack->price *6}}">6</option>
                                                                <option value="{{$pack->id.'-'.'7'.'-'.$pack->price * 7}}" data-no="7" data-title="{{$pack->title}}" data-id="{{$pack->id}}" data-price="{{$pack->price *7}}">7</option>
                                                                <option value="{{$pack->id.'-'.'8'.'-'.$pack->price * 8}}" data-no="8" data-title="{{$pack->title}}" data-id="{{$pack->id}}" data-price="{{$pack->price *8}}">8</option>
                                                                <option value="{{$pack->id.'-'.'9'.'-'.$pack->price * 9}}" data-no="9" data-title="{{$pack->title}}" data-id="{{$pack->id}}" data-price="{{$pack->price *9}}">9</option>
                                                                <option value="{{$pack->id.'-'.'10'.'-'.$pack->price * 10}}" data-no="10" data-title="{{$pack->title}}" data-id="{{$pack->id}}" data-price="{{$pack->price *10}}">10</option>
                                                            </select>
                                                        </div>
                                                        <a href="{{url('/package/'.$pack->slug)}}" target="_blank" class="btn btn-gray">view itinerary</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $i++; ?>
                                            @endforeach

                                        </div>
                                    </div>

                                    <input type="hidden" name="total_amount" class="totalAmount" value="{{$dPrice->price}}">
                                    <input type="hidden" name="addon_pack[]" class="addonId">
                                    <input type="hidden" name="extensionText" class="extensionText">

                                    <div class="row">
                                      <div class="col-md-12">
                                         {!! Form::submit('Continue',['id'=>'submit', 'class'=>'btn btn-danger btn-step']) !!}
                                         {{-- <a href="{{url('package/'.$slug.'/booking-step3')}}" class="btn btn-danger btn-step">Continue</a> --}}

                                     </div>
                                 </div>
                                 {{-- </form> --}}
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
                                      <div class="info-description" id="traveller">1</div>
                                    </div>

                                    <div class="total-price-details-box">
                                        <div class="clearfix sub-heading-title">
                                        <div class="label-text total-passenger-price pull-left">Tour Cost</div>
                                        <div class="content-text total-passenger-price pull-right">USD {{$dPrice->price}}</div>
                                        </div>
                                    </div>

                                <div class="total-price-details-box  exten-text hide ">
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
                                       <div class="content-text total-passenger-price pull-right"><span id = "total" initial-total="{{$dPrice->price}}" totalprice = "{{$dPrice->price}}">NPR {{$dPrice->price}}</span></div>
                                    </div>

                                </div>
                                </div>

                            </div>
                        </div>
                    </div>

           </div>

       </div>
       {!!Form::close() !!}
   </div><!--Container -->

   <div class="divider"></div>

   @include('frontend.includes.new.members')

</div>

@endsection