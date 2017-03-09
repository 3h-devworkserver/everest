@extends ('backend.layouts.master')

@section ('title', trans('Create Traveller Registration Email'))

@section('page-header')
<h1>
	{{ trans('Traveller Registration Email Management') }}
	<small>{{ trans('menus.email.travellerregister.create') }}</small>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">Email Management</li>
<li class="active">{!! trans('Traveller Registration Email Create') !!}</li>
@stop

@section('content')
{!! Form::open(['url'=>'admin/email/travellerregister', 'id'=>'package-form']) !!}

<div class="row">
<div class="col-md-12">
		<div class="box">
			<div class="box-body">

				<div class="form-group">
					<label class="control-label">Email Template</label>
					{!! Form::textarea('content',null,['class'=>'form-control', 'placeholder'=>'Enter Content']) !!}
				</div>
				<div class="form-group">
					{!! Form::submit('Save',['class'=>'btn btn-orange']) !!}
				</div>
			</div>
		</div>
	</div>


</div>

{!! Form::close() !!}
@include('backend.includes.tinymce')
<div class="clearfix"></div>
@endsection



