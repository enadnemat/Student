@extends('admin.layouts.app')
@section('content')
    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>
            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">


                <div class="topbar-divider d-none d-sm-block"></div>

                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span
                            class="mr-2 d-none d-lg-inline text-gray-600 small">{{Auth::user()->username ?? "Admin"}}</span>
                        <img class="img-profile rounded-circle"
                             src="{{asset('admin_assets/img/undraw_profile.svg')}}">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                         aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Profile
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                            Settings
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                            Activity Log
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>

            </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Content Row -->
            <div class="row">
                <!-- Content Column -->
                <div class="col-lg-12 mb-4">
                    <div class="row">
                        <div class="col-3">
                            <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#createUserModel">
                                Create New user
                            </button>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#createSubjectModel">
                                Create New Subject
                            </button>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#assignSubjectModel">
                                Assign a subject to user
                            </button>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#setMarkModel">
                                Set Mark
                            </button>
                        </div>
                    </div>
                </div>

                <table id="table" class="table table-striped table-bordered " style="width: 100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->


    <!-- Model-->

    @includeIf('admin.modals.create-user')

    @includeIf('admin.modals.create-subject')

    @includeIf('admin.modals.update-user')

    @includeIf('admin.modals.delete-user')

    @includeIf('admin.modals.set-mark')

    @includeIf('admin.modals.assign-subject',[ 'users', 'subjects' ])

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <script>

        //user table
        $(document).ready(function () {
            $('#table').dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('admin.tables')}}",
                columns: [
                    {data: "id", name: "id"},
                    {data: "username", name: "username"},
                    {data: "email", name: "email"},
                    {data: "is_active", name: "is_active"},
                    {data: "action", name: "action", "searchable": false},
                ]
            });

        });

        // createUser
        $('#createUser').validate({
            rules: {
                username: {
                    required: true,
                    remote: {
                        url: "{{route('checkUsername')}}",
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            username: function () {
                                return $("input[name=username]").val();
                            }
                        },
                    },
                },
                email: 'required',
                password: {
                    required: true,
                    minlength: 8,
                },
                is_active: 'required',
            },
            messages: {
                username: {
                    required: 'This field is required',
                    remote: 'This username is taken',
                },
                email: 'This field is required',
                password: {
                    required: 'This field is required',
                    minlength: 'Password should be at least 8 characters',
                },
                is_active: 'This field is required',
            },
            submitHandler:
                function (form) {
                    var formData = new FormData(document.forms['createUser']);

                    $.ajax({
                        url: "{{route('admin.create.user')}}",
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        cache: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            $("#createUser")[0].reset();
                            $('#createUserModel').modal('toggle');
                            $('.modal-backdrop').hide();
                            $('#table').DataTable().ajax.reload();
                        },
                        error: function (reject) {

                        },
                    });
                }
        });

        // createSubject
        $('#createSubject').validate({
            rules: {
                name: {
                    required: true,
                },
                pass_mark: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "This field is required.",
                },
                pass_mark: {
                    required: "This field is required.",
                },
            },
            submitHandler:
                function (form) {
                    var formData = new FormData(document.forms['createSubject']);
                    $.ajax({
                        url: "{{route('admin.create.subject')}}",
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        cache: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            $("#createSubject")[0].reset();
                            $('#createSubjectModel').modal('toggle');
                            $('.modal-backdrop').hide();
                        },
                        error: function (reject) {
                            alert(reject)
                        },
                    });
                }
        });

        //assign subject to user
        $('#assignSubject').validate({
            rules: {
                user_id: {
                    required: true,
                },
                subject_id: {
                    required: true,
                },
            },
            messages: {
                user_id: {
                    required: "This field is required",
                },
                subject_id: {
                    required: "This field is required",
                },
            }
            ,
            submitHandler:
                function (form) {
                    var formData = new FormData(document.forms['assignSubject']);
                    $.ajax({
                        url: "{{route('admin.assignSubject')}}",
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        cache: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },

                        success: function (data) {
                            $("#assignSubject")[0].reset();
                            $('#assignSubjectModel').modal('toggle');
                            $('.modal-backdrop').hide();
                        },
                        error: function (reject) {
                            alert(reject.message)
                        },
                    });
                }
        });

        // getUserData
        $('#table').on('click', '.updateUser', function () {
            var id = $(this).data('id');

            console.log(id);
            $('#txt_empid').val(id);
            $.ajax({
                url: "{{ route('getUserData') }}",
                type: 'post',
                data: {
                    _token: "{{csrf_token()}}",
                    id: id
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success == 1) {
                        $('#userUsername').val(response.username);
                        $('#userEmail').val(response.email);
                        $('#is_active').val(response.is_active);
                        table.ajax.reload();
                    } else {
                        alert("Invalid ID.");
                    }
                }
            });

        });

        // updateUserData
        $('#btn_save').click(function () {
            var id = $('#txt_empid').val();

            var username = $('#userUsername').val().trim();
            var email = $('#userEmail').val().trim();
            var is_active = $('#is_active').val().trim();

            if (username != '' && email != '' && is_active != '') {

                // AJAX request
                $.ajax({
                    url: "{{ route('updateUserData') }}",
                    type: 'post',
                    data: {
                        _token: "{{csrf_token()}}",
                        id: id,
                        username: username,
                        email: email,
                        is_active: is_active,
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success == 1) {
                            //alert(response.msg);

                            // Empty and reset the values
                            $('#userUsername', '#userEmail').val('');
                            $('#is_active').val('1');
                            $('#txt_empid').val(0);

                            // Close modal
                            $('#updateModal').hide();

                            location.reload();
                        } else {
                            //alert(response.msg);
                        }
                    }
                });

            } else {
                alert('Please fill all fields.');
            }
        });

        // get id for deleteUser
        $('#table').on('click', '.deleteUser', function () {
            var id = $(this).data('id');
            $('#txt_empid').val(id);
        });

        //deleteUser
        $('#btn_delete').click(function () {
            var id = $('#txt_empid').val();

            console.log(id);
            $.ajax({
                url: "{{route('user.delete')}}",
                type: 'post',
                data: {
                    _token: "{{csrf_token()}}",
                    id: id,
                },
                success: function (response) {
                    $('#deleteModal').modal('toggle');
                    $('.modal-backdrop').hide();
                    $('#table').DataTable().ajax.reload();
                },
            });
        });

        //get subject user doesn't have
        $(document).ready(function () {
            $('select[name="user_id"]').on('change', function () {
                var user_id = $(this).val();
                if (user_id) {
                    $.ajax({
                        url: "{{route('admin.getSubjects')}}",
                        data: {
                            _token: "{{csrf_token()}}",
                            user_id: user_id,
                        },
                        type: "post",
                        datatype: "json",
                        success: function (data) {
                            $('select[name="subject_id"]').empty();
                            $('select[name="subject_id"]').append('<option selected disabled> Select Subject</option>')
                            $.each(data, function (key, value) {
                                $('select[name="subject_id"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    })
                }
            })
        });


        //get subject based on user_id
        $(document).ready(function () {
            $('select[name="id_user"]').on('change', function () {
                var user_id = $(this).val();
                if (user_id) {
                    $.ajax({
                        url: "{{route('admin.getUserSubjects')}}",
                        data: {
                            _token: "{{csrf_token()}}",
                            user_id: user_id,
                        },
                        type: "post",
                        datatype: "json",
                        success: function (data) {
                            $('select[name="id_subject"]').empty();
                            $('select[name="id_subject"]').append('<option selected disabled> Select Subject</option>')
                            $.each(data, function (key, value) {
                                $('select[name="id_subject"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    })
                }
            })
        });

        //getMark
        $(document).ready(function () {
            $('select[name="id_subject"]').on('change', function () {
                var id_subject = $(this).val();
                var user_id = $('select[name="id_user"]').val();

                if (id_subject != '' && user_id != '') {

                    $.ajax({
                        url: "{{route('admin.getMark')}}",
                        data: {
                            _token: "{{csrf_token()}}",
                            user_id: user_id,
                            subject_id: id_subject,
                        },
                        type: "post",
                        datatype: "json",
                        success: function (data) {
                            console.log(data);
                            $('input[name="mark"]').val(data.mark);
                        }
                    })
                }
            });
        });

        //update mark
        $('#setMark').validate({
            rules: {
                id_user: {
                    required: true,
                },
                id_subject: {
                    required: true,
                },
                mark: {
                    required: true
                },
            },
            messages: {
                id_user: {
                    required: "This field is required",
                },
                id_subject: {
                    required: "This field is required",
                },
                mark: {
                    required: "This field is required",
                },
            },
            submitHandler:function (){
                var formData = new FormData(document.forms['setMark']);
                $.ajax({
                    url: "{{route('admin.updateMark')}}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        $("#setMark")[0].reset();
                        $('#setMarkModel').modal('toggle');
                        $('.modal-backdrop').hide();
                    },
                    error: function (reject) {
                        alert(reject)
                    },
                });
            },
        })


    </script>

@endsection
