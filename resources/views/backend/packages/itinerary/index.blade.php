@extends ('backend.layouts.master')

@section ('title', trans('Package Itinerary Management'))

@section('page-header')
<h1>
	{{ trans('Package Itinerary Management') }}
	<small>{{ trans('menus.packages.itinerary.create') }}</small>
	<a href="{{url('admin/packages/itinerary/create')}}" class="btn btn-info left-spacer">Create Package Itinerary</a>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! link_to_route('admin.packages.index', trans('Package Management')) !!}</li>
{{-- <li class="active">{!! trans('Packages Category') !!}</li> --}}
@stop

@section('content')

<table id="example" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S.N</th>
                  <th>Package Selected</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $sn=1; ?>
                @foreach($itinerarys as $itinerary)
                <tr>
                  <td>{{$sn++}}</td>
                  <?php
		$title = \DB::table('packages')->where('id', $itinerary->package_id)->value('title');
					?>
                  <td>{{$title}}</td>
                  <td>
                 
                      <a  href="{{url('admin/packages/itinerary/'.$itinerary->package_id.'/edit')}}" title="Edit Itinerary"><i class="btn btn-info btn-xs glyphicon glyphicon-edit btn-with-icon"> Edit</i></a>
	                
	                  {!! Form::open(['url'=>'admin/packages/itinerary/'.$itinerary->package_id.'/delete', 'method'=>'DELETE' , 'class'=>'display-none', 'id'=>'form-delete-'.$itinerary->package_id]) !!}
	                  {!! Form::close() !!}
	                	<a  type ="submit" href="#" onclick="save('{{$itinerary->package_id}}')" title="Delete Itinerary"><i class="btn btn-danger btn-xs glyphicon glyphicon-trash btn-with-icon"> Delete</i></a>

	               </td>
                </tr>
                @endforeach
                
                </tbody>
              </table>

 <script >
 $(document).ready(function(){
 	$('#example').dataTable();

 });
 </script>
  <script type="text/javascript">
         function save(id){
         	if (confirm('Are you sure want to delete !!!')) {
         		document.getElementById("form-delete-"+id).submit();
         	}
         }
         </script>

<div class="clearfix"></div>
@endsection