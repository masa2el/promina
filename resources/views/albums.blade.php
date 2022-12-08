@extends('layouts/master' )

@section('title'){{'Manage Albums'}}@endsection

@section('content')

<div class="container-fluid">

    <div class="text-center"><a href="{{route('home')}}"><img src="{{asset('assets/images/promina.png')}}" style="width:200px"></a></div>
	<h2 class="d-flex align-items-center justify-content-between">
		<span>Manage Albums</span>
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
			<span class="text-white">Albums List</span>
            <a href="{{route('home')}}"><button class="btn btn-sm btn-warning float-right"><i class="fa fa-home"></i></button></a>
		</div>
		<div class="card-body p-0">
			@if($albums->count()==0)
				<div class="text-center text-danger"><br><br><br><i class="fa fa-info-circle fa-3x"></i><br><br>There is no albums here!<br><br><br></div>
			@else
				<table class="table table-striped">
					<thead><tr><th>#</th><th>Name</th><th>Images</th><th style="width:300px;">Options</th></tr></thead><tbody>
					@foreach($albums as $index => $album)
						<tr>
							<td>{{$index+1}}</td>
							<td>{{$album->name}}</td>
							<td>{{$album->images->count()}} Images</td>
							<td>
								<a href="{{route('images.index', $album->id)}}"><button class="btn btn-sm btn-primary"><i class="fa fa-images"></i> Manage</button></a>
								<button data-album="{{$album->id}}" data-name="{{$album->name}}" class="btn btn-sm btn-warning editButton"><i class="fa fa-edit"></i> Edit</button>
								<button data-album="{{$album->id}}" data-name="{{$album->name}}" data-images="{{$album->images->count()}}" class="btn btn-sm btn-danger deleteButton"><i class="fa fa-times"></i> Delete</button>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			@endif
		</div>
		<div class="card-footer d-flex justify-content-between"><span>Total Albums: <strong>{{$albums->count()}}</strong></span><span>Total Images: <strong>{{$totalImages}}</strong></span></div>
	</div>

</div>

<div class="modal fade" id="addnew">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{route('albums.store')}}" method="post">
            <div class="modal-header">
                <div class="modal-title">Add New Album</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            	{{csrf_field()}}
                <div class="form-group">
                    <label>Album Name:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Album name...">
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
        <form action="{{route('albums.update')}}" method="post">
            <div class="modal-header">
                <div class="modal-title">Edit Album</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{csrf_field()}}
                <input type="hidden" name="album" id="album" value="">
                <div class="form-group">
                    <label>Album Name:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Album name...">
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
        <form action="{{route('albums.delete')}}" method="post">
            <div class="modal-header">
                <div class="modal-title">Delete Album</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{csrf_field()}}
                <input type="hidden" name="album" id="album" value="">
                <div class="form-group">
                    <label>Album Name:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="name" id="name" disabled>
                    </div>
                </div>
                <div id="extra" style="display:none;">
	                <div class="form-group text-danger">
	                	You cannot delete album with images, please select an action:
	                </div>
	                <div class="form-group">
	                    <label>Action:</label>
	                    <div class="input-group">
	                        <select onchange="selectAction(this.value)" class="form-control" name="action" id="action">
	                        	<option value="">- Selcet Action -</option>
	                        	<option value="delete">delete all images</option>
	                        	<option value="move">move all images</option>
	                        </select>
	                    </div>
	                </div>
	                <div id="moveBox" class="form-group" style="display:none;">
	                    <label>Albums:</label>
	                    <div class="input-group">
	                        <select class="form-control" name="moveto" id="moveto">
	                        	<option value="">- Selcet Album -</option>
	                        	@foreach($albums as $a)
	                        	<option value="{{$a->id}}">{{$a->name}}</option>
	                        	@endforeach
	                        </select>
	                    </div>
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
    	function selectAction(action){
    		$("#deleteForm #extra #moveBox #moveto option").removeAttr('disabled');
    		if(action=="move"){
    			let album = $("#deleteForm #album").val();
            	$("#deleteForm #extra #moveBox").show();
	    		$("#deleteForm #extra #moveBox #moveto option[value='"+album+"']").attr('disabled', true);
    		}else{
            	$("#deleteForm #extra #moveBox").hide();
    		}
    	}
        $(".editButton").on("click", function(){
            $("#editForm #album").val($(this).data("album"));
            $("#editForm #name").val($(this).data("name"));
            $("#editForm").modal("show");
        });
        $(".deleteButton").on("click", function(){
        	let images = $(this).data("images");
            $("#deleteForm #album").val($(this).data("album"));
            $("#deleteForm #name").val($(this).data("name"));
            $("#deleteForm #images").val(images);
            if(images>0){
            	$("#deleteForm #extra").show();
            }else{
            	$("#deleteForm #extra").hide();
            }
            $("#deleteForm").modal("show");
        });
    </script>
@endsection