@extends ('backend.layouts.master')

@section ('title', trans('Package Gallery Management'))

@section('page-header')
<h1>
	{{ trans('Package Gallery Management') }}
	<small>{{ trans('menus.packages.gallery.create') }}</small>
	<a href="{{url('admin/packages/gallery/create')}}" class="btn btn-info left-spacer">Create Gallery</a>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! link_to_route('admin.packages.index', trans('Package Management')) !!}</li>
<li class="active">{!! trans('Package Gallery') !!}</li>
@stop

@section('content')
<table id="example" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S.N</th>
                  <th>Gallery Name</th>
                  <th>Package Selected</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $sn=1; ?>
                @foreach($gallerys as $gallery)
                <tr>
                  <td>{{$sn++}}</td>
                  <td>{{$gallery->name}}</td>
                  <?php
		$title = \DB::table('packages')->where('id', $gallery->package_id)->value('title');
					?>
                  <td>{{$title}}</td>
                  <td>
                 
                      <a  href="{{url('admin/packages/gallery/'.$gallery->package_id.'/edit')}}" title="Edit Slider Image"><i class="btn btn-info btn-xs glyphicon glyphicon-edit btn-with-icon"> Edit</i></a>
	                
	                  {!! Form::open(['url'=>'admin/packages/gallery/delete/'.$gallery->package_id, 'method'=>'DELETE' , 'class'=>'display-none', 'id'=>'form-delete-'.$gallery->package_id]) !!}
	                  {!! Form::close() !!}
	                	<a  type ="submit" href="#" onclick="save('{{$gallery->package_id}}')" title="Delete Gallery Images"><i class="btn btn-danger btn-xs glyphicon glyphicon-trash btn-with-icon"> Delete</i></a>

	               </td>
                </tr>
                @endforeach
                
                </tbody>
              </table>
<script >
 $(document).ready(function(){
 	$('#example').dataTable();

 });

 function save(id){
         	if (confirm('Are you sure want to delete !!!')) {
         		document.getElementById("form-delete-"+id).submit();
         	}
         }
 </script>
<div class="clearfix"></div>
@endsection

