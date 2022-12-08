@extends('layouts/master' )

@section('title'){{'Manage Images'}}@endsection

@section('content')

<div class="container-fluid">

    <div class="text-center"><a href="{{route('home')}}"><img src="{{asset('assets/images/promina.png')}}" style="width:200px"></a></div>
	<h2 class="d-flex align-items-center justify-content-between">
		<span>Manage Images</span>
		<button class="btn btn-sm btn-success float-right" data-toggle="modal" data-target="#addnew"><i class="fa fa-plus"></i> Add New</button>
	</h2>

    @if(Session::has("success"))
        <div class="alert alert-success col-lg-12 col-md-12 col-sm-12 alert-dismissible">
            <i class="close fa fa-times" style="cursor:pointer;" data-dismiss="alert" aria-hidden="true"></i>
            <i class="fa fa-check"></i> &nbsp; {{Session::get('success')}}
            @php Session::forget('success'); @endphp
        </div>
    @endif

    @if(Session::has("error"))
        <div class="alert alert-danger col-lg-12 col-md-12 col-sm-12 alert-dismissible">
            <i class="close fa fa-times" style="cursor:pointer;" data-dismiss="alert" aria-hidden="true"></i>
            <i class="fa fa-exclamation-triangle"></i> &nbsp; {{Session::get('error')}}
            @php Session::forget('error'); @endphp
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger col-lg-12 col-md-12 col-sm-12 alert-dismissible">
            <i class="close fa fa-times" style="cursor:pointer;" data-dismiss="alert" aria-hidden="true"></i>
            @foreach($errors->all() as $error)
                <i class="fa fa-times"></i> &nbsp; {{$error}}<br>
            @endforeach
        </div>
    @endif

	<div class="card">
		<div class="card-header bg-info">
            <span class="text-white">Images List</span>
            <a href="{{route('albums.index')}}"><button class="btn btn-sm btn-warning float-right"><i class="fa fa-arrow-left"></i> Back to albums</button></a>
        </div>
		<div class="card-body p-0">
			@if($images->count()==0)
				<div class="text-center text-danger"><br><br><br><i class="fa fa-info-circle fa-3x"></i><br><br>There is no images here!<br><br><br></div>
			@else
				<table class="table table-striped">
					<thead><tr><th>#</th><th>Name</th><th>Images</th><th style="width:300px;">Options</th></tr></thead><tbody>
					@foreach($images as $index => $image)
						<tr>
							<td>{{$index+1}}</td>
							<td>{{$image->name}}</td>
							<td><img style="width:100px;height:100px;" src="{{Storage::url($image->media)}}" /></td>
							<td>
								<button data-image="{{$image->id}}" data-name="{{$image->name}}" class="btn btn-sm btn-warning editButton"><i class="fa fa-edit"></i> Edit</button>
								<button data-image="{{$image->id}}" data-name="{{$image->name}}" data-file="{{Storage::url($image->media)}}" class="btn btn-sm btn-danger deleteButton"><i class="fa fa-times"></i> Delete</button>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			@endif
		</div>
		<div class="card-footer"><span>Total Images: <strong>{{$images->count()}}</strong></span></div>
	</div>

</div>

<div class="modal fade" id="addnew">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{route('images.store')}}" method="post" enctype="multipart/form-data">
            <div class="modal-header">
                <div class="modal-title">Add New Image</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{csrf_field()}}
                <input type="hidden" name="album" value="{{$album->id}}">
                <div class="form-group">
                    <label>Image Name:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Image name...">
                    </div>
                </div>
                <div class="form-group">
                    <label>Image File:</label>
                    <div class="input-group">
                        <input type="file" class="form-control" name="file" id="file" accept="image/*">
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Save</button>
            </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="editForm">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{route('images.update')}}" method="post">
            <div class="modal-header">
                <div class="modal-title">Edit Image</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{csrf_field()}}
                <input type="hidden" name="image" id="image" value="">
                <div class="form-group">
                    <label>Image Name:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Image name...">
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Update</button>
            </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="deleteForm">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{route('images.delete')}}" method="post">
            <div class="modal-header">
                <div class="modal-title">Delete Image</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{csrf_field()}}
                <input type="hidden" name="image" id="image" value="">
                <div class="form-group">
                    <label>Image Name:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="name" id="name" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label>Image File:</label>
                    <div class="input-group">
                        <img id="file" src="" style="width:200px;height:200px;">
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-sm btn-success" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Confirm</button>
            </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@endsection

@section('scripts')
    <script type="text/javascript">
        $(".editButton").on("click", function(){
            $("#editForm #image").val($(this).data("image"));
            $("#editForm #name").val($(this).data("name"));
            $("#editForm").modal("show");
        });
        $(".deleteButton").on("click", function(){
            $("#deleteForm #image").val($(this).data("image"));
            $("#deleteForm #name").val($(this).data("name"));
            $("#deleteForm #file").attr('src', $(this).data("file"));
            $("#deleteForm").modal("show");
        });
    </script>
@endsection