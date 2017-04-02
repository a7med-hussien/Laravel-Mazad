@extends('layouts.app')

@section("styles")
    <link rel="stylesheet" href="{{ asset("css/jquery.dataTables.min.css") }}">
    <link rel="stylesheet" href="{{ asset("css/dashboard.css") }}">
    <link rel="stylesheet" href="{{ asset("css/sweetalert.css") }}">
    <link rel="stylesheet" href="{{ asset("css/countrySelect.min.css") }}">
    <link rel="stylesheet" href="{{ asset("css/font-awesome.min.css") }}">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">My Items List 
                    <button class="btn btn-success pull-right" data-toggle="modal" data-target="#new-item"> <i class="glyphicon glyphicon-plus"></i> Add New Item</button>
                </div>

                <div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#active" aria-controls="active" role="tab" data-toggle="tab">Active Items</a>
                        </li>
                        <li role="presentation">
                            <a href="#drafts" aria-controls="drafts" role="tab" data-toggle="tab">Drafts Items</a>
                        </li>
                        <li role="presentation">
                            <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="active">
                            <div class="panel-body">
                                <table class="table table-hover table-striped items-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Online</th>
                                            <th class="text-center">Highest Bid</th>
                                            <th class="text-center">No. Of Bid</th>
                                            <th class="text-center">Image</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="items-output">
                                        @foreach($items as $item)
                                            <tr class="text-center">
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->price }}</td>
                                                @if($item->online)
                                                    <td><span class='label label-success'>Yes</span></td>
                                                @else
                                                    <td><span class='label label-danger'>No</span></td>
                                                @endif
                                                <td>{{ $item->highest_price }}</td>
                                                <td>{{ $item->bids }}</td>
                                                <td>
                                                    <img src="{{ $item->image }}" class='img-responsive item-image' alt="{{ $item->name }}">
                                                </td>
                                                <td>
                                                    <form action='items/{{ $item->id }}' method='POST' id="delete-item" class='remove form-inline'>
                                                        {{ csrf_field() }}
                                                        {{ method_field("DELETE") }}
                                                        <button type='submit' class='btn btn-sm btn-danger'>
                                                            <i class='glyphicon glyphicon-trash'></i>
                                                        </button>
                                                    </form>
                                                    <a href='javascript:;' data-id="{{ $item->id }}" class='edit-item btn btn-primary btn-sm'>
                                                        <i class='glyphicon glyphicon-edit'></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>     
                        </div>

                        <div role="tabpanel" class="tab-pane" id="drafts">
                            <div class="panel-body">
                                <table class="table table-hover table-striped items-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Online</th>
                                            <th class="text-center">Highest Bid</th>
                                            <th class="text-center">No. Of Bid</th>
                                            <th class="text-center">Image</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="items-output">
                                        @foreach($drafts as $draft)
                                            <tr class="text-center">
                                                <td>{{ $draft->name }}</td>
                                                <td>{{ $draft->price }}</td>
                                                @if($draft->online)
                                                    <td><span class='label label-success'>Yes</span></td>
                                                @else
                                                    <td><span class='label label-danger'>No</span></td>
                                                @endif
                                                <td>{{ $draft->highest_price }}</td>
                                                <td>{{ $draft->bids }}</td>
                                                <td>
                                                    <img src="{{ $draft->image }}" class='img-responsive item-image' alt="{{ $draft->name }}">
                                                </td>
                                                <td>
                                                    <form action='items/{{ $draft->id }}/delete' method='POST' id="forcedelete-item" class='remove form-inline'>
                                                        {{ csrf_field() }}
                                                        {{ method_field("DELETE") }}
                                                        <button type='submit' class='btn btn-sm btn-danger'>
                                                            <i class='glyphicon glyphicon-trash'></i>
                                                        </button>
                                                    </form>
                                                    <a href='javascript:;' data-id="{{ $draft->id }}" class='restore-item btn btn-info btn-sm'>
                                                        <i class='glyphicon glyphicon-refresh'></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="profile">
                            <div class="panel-body">
                                <div class="col-sm-12">
                                    <div class="card hovercard">
                                        <div class="cardheader"></div>
                                        <div class="avatar">
                                            <img alt="" src="{{ $user->avatar }}">
                                        </div>
                                        <div class="info">
                                            <span class="edit-icon" data-toggle="modal" data-target="#edit-profile-modal"><i class="fa fa-edit"></i></span>
                                            <div class="title">
                                                <a target="_blank" href="javascript:;">{{ $user->name }}</a>
                                            </div>
                                            <div class="desc">{{ $user->email }}</div>
                                            <div class="desc">{{ $user->location }}</div>
                                            @if($user->gender == 'male')
                                                <div class="desc"><i class="fa fa-male" aria-hidden="true"></i> Male</div>
                                            @else
                                                <div class="desc"><i class="fa fa-female" aria-hidden="true"></i> Female</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add New Item Modal -->
<div class="modal fade" id="new-item" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center">Add New Item</h4>
            </div>
            <form action="#" method="POST" id="new-item-form">
                <div class="modal-body clearfix">
                    {{ csrf_field() }}
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Item Name" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="number" name="price" placeholder="Item Price" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label"> Online : </label>
                            <label class="radio-inline" for="yes">
                                <input type="radio" name="online" id="yes" value="1" checked> Yes
                            </label>
                            <label class="radio-inline" for="no">
                                <input type="radio" name="online" id="no" value="0"> No
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <textarea name="details" placeholder="Item Details" class="form-control"></textarea>
                    </div>
                    <div class="col-md-12">
                        <label for="image">Item Image: </label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" value="Add Item" class="btn btn-primary">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Edit Item Modal -->
<div class="modal fade" id="edit-item-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center">Edit Item</h4>
            </div>
            <form action="#" method="POST" id="edit-item-form">
                <div class="modal-body clearfix">
                    {{ csrf_field() }}
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="hidden" name="id" id="id">
                            <input type="text" id="name" name="name" placeholder="Item Name" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="number" id="price" name="price" placeholder="Item Price" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label"> Online : </label>
                            <label class="radio-inline" for="yes">
                                <input type="radio" name="online" id="yes" value="1"> Yes
                            </label>
                            <label class="radio-inline" for="no">
                                <input type="radio" name="online" id="no" value="0"> No
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <textarea name="details" id="details" placeholder="Item Details" class="form-control"></textarea>
                    </div>
                    <div class="col-md-6">
                        <p>Old Item Image</p>
                        <img src="" id="item-image" class="img-responsive" alt="">
                    </div>
                    <div class="col-md-6">
                        <label for="image">Uplad New Image: </label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" value="Update Item" class="btn btn-primary">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="edit-profile-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center">Edit Profile</h4>
            </div>
            <form action="#" method="POST" id="edit-profile-form">
                <div class="modal-body clearfix">
                    {{ csrf_field() }}
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label"> Username : </label>
                            <input type="text" id="name" name="name" placeholder="Username" value="{{ $user->name }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label"> E-mail Address : </label>
                            <input type="email" name="email" placeholder="E-mail Address" value="{{ $user->email }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label"> Gender : </label>
                            <select name="gender" class="form-control">
                                <option value="0" disabled>Select Your Gender</option>
                                <option value="male" @if($user->gender == 'male') selected @endif>Male</option>
                                <option value="female" @if($user->gender == 'female') selected @endif>Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label"> Location : </label>
                            <input type="text" id="location" name="location" value="{{ $user->location }}" placeholder="Location" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p>Old Profile Image</p>
                        <img src="{{ $user->avatar }}" class="img-responsive" alt="{{ $user->name }}">
                    </div>
                    <div class="col-md-6">
                        <label for="image">Uplad New Image: </label>
                        <input type="file" name="avatar" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" value="Update Profile" class="btn btn-primary">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section("scripts")
    <script src="{{ asset("js/jquery.dataTables.min.js") }}"></script>
    <script src="{{ asset("js/sweetalert.min.js") }}"></script>
    <script src="{{ asset("js/countrySelect.min.js") }}"></script>
    <script>
        $(function(){
            
            $(".items-table").DataTable();

             $("#location").countrySelect();

            $("form#new-item-form").on("submit", function(event) {
                event.preventDefault();

                $.ajax({
                    url: "",
                    type: "POST",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        window.location.reload();
                    },
                    berforeSend: function() {
                        // Loading / WaitMe
                    }
                });
            });

            $("a.edit-item").on("click", function(){
                var item_id = $(this).data('id');
                $.ajax({
                    url: 'items/'+item_id,
                    type: "GET",
                    success: function(response) {
                        // console.log(response);
                        $("#id").val(response.id);
                        $("#name").val(response.name);
                        $("#price").val(response.price);
                        $("#details").val(response.details);
                        if (response.online) {
                            $("#edit-item-form #yes").attr("checked", "checked");
                        } else {
                            $("#edit-item-form #no").attr("checked", "");
                        }
                        $("#item-image").attr("src", response.image);

                        $("#edit-item-modal").modal("show");
                    }
                });
            });

            $("#edit-item-form").on("submit", function(event) {
                event.preventDefault();

                var id = $("#id").val();

                $.ajax({
                    url: "items/"+id,
                    data: new FormData(this),
                    type: "POST",
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        window.location.reload();
                    }
                });
            });


            $("#delete-item").on("submit", function(event) {
                event.preventDefault();

                swal({
                    title: "Are you sure?",
                    text: "this item will be drafted!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, draft it!",
                    closeOnConfirm: false
                },
                function(){
                    $.ajax({
                        url: $("#delete-item").attr("action"),
                        data: $("#delete-item").serialize(),
                        type: "DELETE", 
                        success: function(response) {
                            swal("Drafted!", "Your item drafted.", "success");
                            window.location.reload();
                        }
                    });
                });
            });

            $("#forcedelete-item").on("submit", function(event) {
                event.preventDefault();

                swal({
                    title: "Are you sure?",
                    text: "this item will be Deleted!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Delete it!",
                    closeOnConfirm: false
                },
                function(){
                    $.ajax({
                        url: $("#forcedelete-item").attr("action"),
                        data: $("#forcedelete-item").serialize(),
                        type: "DELETE", 
                        success: function(response) {
                            swal("Drafted!", "Your item Deleted.", "success");
                            window.location.reload();
                        }
                    });
                });
            });

            $('.restore-item').on('click', function(){
                var draft_id = $(this).data('id');

                $.ajax({
                    url: "items/"+draft_id+"/restore",
                    type: "GET",
                    success: function(response) {
                        window.location.reload();
                    }
                });
            });

            $("#edit-profile-form").on("submit", function(event){
                event.preventDefault();

                $.ajax({
                    url: 'profile',
                    type: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        window.location.reload();
                    }
                });
            });

        });
    </script>
@endsection