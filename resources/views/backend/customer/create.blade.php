@extends ('backend.layouts.master')

@section ('title', trans('Create Customer'))

@section('page-header')
<h1>
	{{ trans('Customer Management') }}
	<small>{{ trans('menus.customers.create') }}</small>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! link_to_route('admin.customers.index', trans('Customer Management')) !!}</li>
<li class="active">{!! trans('Customers Create') !!}</li>
@stop

@section('content')
<!-- Main content -->

{!! Form::open(['url'=>'admin/customers', 'id'=>'myForm', 'class'=>'customerForm', 'files'=> 'true']) !!}
<div class="row">
  <div class="col-md-3">
    <!-- Profile Image -->
    <div class="box box-primary">
      <div class="box-body box-profile">
        <img class="profile-user-img img-responsive img-circle profile-avatar" src="{{url('images/3hammers_footer.png')}}" alt="User profile picture">
        <h3 class="profile-username text-center"></h3>
        <p class="text-muted text-center">
         Traveller
        </p>
       
        <div class="profileInput">
          <span class="uploadButton"><i class="fa fa-camera"></i>
            <input
            id="profilePic"
            name="profilePic"
            accept="image/*"
            type="file" onchange="readURLprofile(this);">
          </span>
        </div>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
    <div class="uploadProcess"></div>
    <div class="box-feature-btn">
    <?php /* ?>
      @if ($user->roles()->first()->id==1)
      <a class="btn btn-block btn-primary btn-flat" href="{{ route('admin.access.user.change-password', $user->id) }}">
        <i class="fa fa-key"></i> Change Password
      </a>
      @endif
      <?php */ ?>
    </div>
  </div><!-- /.col -->
  	<div class="col-md-9">
    	<div class="box">
			<div class="box-body">
				<div class="element-wrapper">
					<div class="form-group">
						<label class="control-label">Title</label>
						{!! Form::select('title', [''=>'-- Choose Title -- ', 'MR'=>'Mr', 'MRS'=>'Mrs', 'MS'=>'Ms'], null, ['class'=>'box form-control' ]) !!}
					</div>
					<div class="form-group">
						<label class="control-label">First Name</label>
						{!! Form::text('fname',null,['class'=>'form-control', 'placeholder'=>'Enter First Name']) !!}
					</div>
					<div class="form-group">
						<label class="control-label">Middle Name</label>
						{!! Form::text('mname',null,['class'=>'form-control', 'placeholder'=>'Enter Middle Name']) !!}
					</div>
					<div class="form-group">
						<label class="control-label">Last Name</label>
						{!! Form::text('lname',null,['class'=>'form-control', 'placeholder'=>'Enter Last Name']) !!}
					</div>
					<div class="form-group">
						<label class="control-label">Email</label>
						{!! Form::email('email',null,['class'=>'form-control', 'placeholder'=>'Enter Email']) !!}
					</div>
					<div class="form-group">
						<label class="control-label">Address</label>
						{!! Form::text('address',null,['class'=>'form-control', 'placeholder'=>'Enter Address']) !!}
					</div>
					<div class="form-group">
						<label class="control-label">Password</label>
						{!! Form::input('password', 'password', null,['class'=>'form-control', 'placeholder'=>'Enter Password']) !!}
					</div>
					<div class="form-group">
						<label class="control-label">Confirm Password</label>
						{!! Form::input('password', 'password_confirmation',null,['class'=>'form-control', 'placeholder'=>'Confirm Password']) !!}
					</div>
					<div class="form-group">
						<label class="control-label">Nationality</label>
						<select name="country" id="country" class="form-control" onchange="print_state('state',this.selectedIndex);">

						</select>
					</div>
					<div class="form-group">
						<label class="control-label">State / Province</label>
						<select name="state" id="state" class="form-control" >

						</select>
					</div>
					<div class="form-group">
						<label class="control-label">Phone Type</label>
						{!! Form::select('phone_type', [''=>'-- Select Phone Type --', 'Mobile'=>'Mobile', 'Home'=>'Home', 'Office'=>'Office'], null , ['class'=>'form-control']) !!}
					</div>
					<div class="form-group">
						<label class="control-label">Phone Number</label>
						{!! Form::text('phone_number',null,['class'=>'form-control', 'placeholder'=>'Enter Phone Number']) !!}
					</div>
					<div class="form-group">
						<label class="control-label">Document Type</label>
						{!! Form::select('document_type',[''=>'-- Select Document Type', 'passport' => 'Passport', 'birth-certificate'=>'Birth Certificate', 'id-card'=> 'ID Card' ], null, ['class'=>'form-control']) !!}
					</div>
					<div class="form-group">
						<label class="control-label">Document Number</label>
						{!! Form::text('document_number',null,['class'=>'form-control', 'placeholder'=>'Enter Document Number']) !!}
					</div>
					<div class="form-group">
						<label class="control-label">Document Upload</label>
						<span class="btn btn-primary btn-file btn-sm">
							<i class="fa fa-folder-open"></i>Upload Map Image
							<input type="file" onchange="readURLdoc(this);" name="DocUpload" accept="image/*" class="image-upload">
						</span>
						<div id="doc-preview" class="show-img-bg display-none" alt="Image Preview"></div>
					</div>
				</div>
					<div class="form-group">
						{!! Form::submit('Save',['class'=>'btn btn-orange customer-btn']) !!}
					</div>
			</div>
		</div>
	</div><!-- /.col -->
</div><!-- /.row -->
{!! Form::close() !!}









<?php  /* ?>


{!! Form::open(['url'=>'admin/customers', 'id'=>'myForm', 'files'=> 'true']) !!}
<div class="row">

	<div class="col-md-9">
		<div class="box">
			<div class="box-body">
				<div class="form-group">
					<label class="control-label">Title</label>
					{!! Form::select('title[]', [''=>'Title', 'MR'=>'Mr', 'MRS'=>'Mrs', 'MS'=>'Ms'], null, ['class'=>'box form-control' ]) !!}
				</div>
				<div class="form-group">
					<label class="control-label">First Name</label>
					{!! Form::text('fname',null,['class'=>'form-control', 'placeholder'=>'Enter First Name']) !!}
				</div>
				<div class="form-group">
					<label class="control-label">Middle Name</label>
					{!! Form::text('mname',null,['class'=>'form-control', 'placeholder'=>'Enter Middle Name']) !!}
				</div>
				<div class="form-group">
					<label class="control-label">Last Name</label>
					{!! Form::text('lname',null,['class'=>'form-control', 'placeholder'=>'Enter Last Name']) !!}
				</div>
				<div class="form-group">
					<label class="control-label">Email</label>
					{!! Form::email('email',null,['class'=>'form-control', 'placeholder'=>'Enter Email']) !!}
				</div>
				<div class="form-group">
					<label class="control-label">Password</label>
					{!! Form::input('password', 'password', null,['class'=>'form-control', 'placeholder'=>'Enter Password']) !!}
				</div>
				<div class="form-group">
					<label class="control-label">Confirm Password</label>
					{!! Form::input('password', 'password_confirmation',null,['class'=>'form-control', 'placeholder'=>'Confirm Password']) !!}
				</div>
				<div class="form-group">
					<label class="control-label">Address</label>
					{!! Form::text('address',null,['class'=>'form-control', 'placeholder'=>'Enter Address']) !!}
				</div>
				<div class="form-group">
					<label class="control-label">Nationality</label>
					<select name="country" id="country" class="form-control" onchange="print_state('state',this.selectedIndex);">

					</select>
				</div>
				<div class="form-group">
					<label class="control-label">State / Province</label>
					<select name="state" id="state" class="form-control" >

					</select>
				</div>
				<div class="form-group">
					<label class="control-label">Phone Type</label>
					{!! Form::select('phone_type', ['Mobile'=>'Mobile', 'Home'=>'Home', 'Office'=>'Office'], null , ['class'=>'form-control']) !!}
				</div>
				<div class="form-group">
					<label class="control-label">Phone Number</label>
					{!! Form::text('phone_number',null,['class'=>'form-control', 'placeholder'=>'Enter Phone Number']) !!}
				</div>

			</div>
		</div>

	</div> <!-- col -->

	<div class="col-md-3">

	</div>

</div>



<div class="row">
	<div class="col-md-offset-9 col-md-3">
		{!! Form::submit('Save',['class'=>'btn btn-orange']) !!}
	</div>
	
</div>


{!! Form::close() !!}
<?php */?>

<script language="javascript">
	print_country("country","-- Select Country --");
	$("#state").append(new Option("-- Select State --", ""));
</script>

@include('backend.includes.tinymce')





<div class="clearfix"></div>

@endsection



