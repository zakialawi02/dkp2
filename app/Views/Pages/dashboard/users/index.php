<?php $this->extend('Layouts/dashboardTemplate') ?>

<?php $this->section('title') ?>
Dashboardss
<?php $this->endSection() ?>

<?php $this->section('og_title') ?>
Dashboard
<?php $this->endSection() ?>

<?php $this->section('css') ?>

<?php $this->endSection() ?>

<?php $this->section('content') ?>
<?= $this->include('components/dependencies/_datatables') ?>


<div class="card p-3">

    <div class="d-flex justify-content-end align-items-center mb-3 px-2">
        <button class="btn btn-primary" id="createNewUser" data-bs-toggle="modal" data-bs-target="#userModal" type="button"> Add User </button>
    </div>

    <div class="table-responsive">
        <table class="table-hover table-striped table" id="myTable" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Name</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Registered</th>
                    <th scope="col">Active</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="userModal" aria-labelledby="userModalLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Modal title</h5>
                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="error-messages"></div>

                <form class="form-horizontal" id="userForm" method="post" action="">

                    <input id="_method" name="_method" type="hidden">

                    <div class="form-group mb-3">
                        <label for="name">Name</label>
                        <input class="form-control" id="full_name" name="full_name" type="text" value="<?= old('full_name') ?>" placeholder="Enter your Name" required autofocus>
                    </div>

                    <div class="form-group mb-3">
                        <label for="username">Username</label>
                        <input class="form-control" id="username" name="username" type="text" value="<?= old('username') ?>" placeholder="Enter your username" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label for="role">Role</label>
                            <select class="form-control" name="role" id="role" required>
                                <option value="">--Pilih Role--</option>
                                <?php foreach ($auth_groups as $key => $value) : ?>
                                    <option value="<?= $value['name'] ?>"><?= $value['name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="role">Status</label>
                            <select class="form-control" name="active" id="active" required>
                                <option value="0">Inactive</option>
                                <option value="1">Active</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input class="form-control" id="email" name="email" type="email" value="<?= old('email') ?>" placeholder="Enter email" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input class="form-control" id="password" name="password" type="password" placeholder="Enter password">
                        <span class="text-muted" id="passwordHelpBlock"></span>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
                <button class="btn btn-primary" id="saveBtn" type="submit">Save changes</button>
            </div>
        </div>
    </div>
</div>


<?php $this->endSection() ?>


<?php $this->section('javascript') ?>

<script>
    $(document).ready(function() {
        let table = new DataTable('#myTable', {
            processing: true,
            serverSide: true,
            ajax: "<?= current_url() ?>",
            lengthMenu: [
                [10, 15, 25, 50, -1],
                [10, 15, 25, 50, "All"]
            ],
            language: {
                paginate: {
                    previous: '<i class="mdi mdi-chevron-left"></i>',
                    next: '<i class="mdi mdi-chevron-right"></i>'
                }
            },
            order: [
                [2, 'asc']
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'user_image',
                    name: 'photo',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'full_name',
                    name: 'full_name'
                },
                {
                    data: 'username',
                    name: 'username'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'role',
                    name: 'name'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    searchable: false
                },
                {
                    data: 'active',
                    name: 'active'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
        });

        // Setup CSRF Token for AJAX requests
        function setupCSRFToken() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }
        // Update CSRF token after every successful request
        function updateCSRFToken(response) {
            var csrfToken = response.responseJSON.token;

            $('meta[name="csrf-token"]').attr('content', csrfToken);
        }

        const cardErrorMessages = `<div id="body-messages" class="alert alert-danger" role="alert"></div>`;

        // Open modal for creating new user
        $('#createNewUser').click(function() {
            $('#userModal').find('.modal-title').text('Add User');
            $('#userForm').attr('method', 'POST');
            $('#_method').val('POST');
            $('#userForm').trigger("reset");
            $('#userForm').attr('action', '<?= route_to('admin.users.store') ?>');
            $('#saveBtn').text('Create');
            $("#error-messages").html("");
            $("#passwordHelpBlock").html("");
        });

        // Save new or updated user
        $('#saveBtn').on('click', function(e) {
            e.preventDefault();
            setupCSRFToken();
            const formData = $('#userForm').serialize();
            const formAction = $('#userForm').attr('action');
            const method = $('#userForm').attr('method');

            $.ajax({
                type: method,
                url: formAction,
                data: formData,
                beforeSend: function() {
                    $("#error-messages").html("");
                    $('#saveBtn').prop('disabled', true);
                },
                success: function(response) {
                    $('#userModal').modal('hide');
                    $('#myTable').DataTable().ajax.reload();
                    Swal.fire({
                        title: "Success!",
                        text: response.message,
                        icon: "success",
                        timer: 2000,
                        timerProgressBar: true,
                        confirmButtonText: "Ok"
                    });
                },
                error: function(error) {
                    console.log(error);

                    $("#error-messages").html(cardErrorMessages);
                    const messages = error.responseJSON.errors;
                    console.log(messages);
                    $.each(messages, function(indexInArray, message) {
                        console.log(message);
                        $("#body-messages").append('<span>' + message + '</span> <br>');
                    });
                },
                complete: function(response) {
                    $('#saveBtn').prop('disabled', false);
                    updateCSRFToken(response);
                }
            });

        });

        // Edit user
        $('body').on('click', '.editUser', function() {
            $("#error-messages").html("");
            $("#passwordHelpBlock").html("blank if you don't want to change");
            const username = $(this).data('user');

            $.get(`<?= route_to('admin.users.show', ':username') ?>`.replace(':username', username), function(data) {
                $('#userModal').modal('show');
                $('#userModal').find('.modal-title').text('Edit User');
                $('#userForm').attr('action', `<?= route_to('admin.users.update', ':username') ?>`.replace(':username', username));
                $('#saveBtn').text('Update');
                $('#_method').val('PUT');
                $('#full_name').val(data.full_name);
                $('#username').val(data.username);
                $('#role').val(data.role);
                $('#email').val(data.email);
                $('#active').val(data.active ? "1" : "0");
            });
        });

        // Delete user
        $('body').on('click', '.deleteUser', function(e) {
            e.preventDefault();
            const username = $(this).data('user');
            confirmDelete(username);
        })

        function confirmDelete(username) {
            Swal.fire({
                title: "Are you sure you want to delete this record?",
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#74788d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonColor: '#5664d2',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteUser(username);
                }
            });
        }

        function deleteUser(username) {
            setupCSRFToken();
            $.ajax({
                type: "DELETE",
                url: `<?= route_to('admin.users.destroy', ':username') ?>`.replace(':username', username),
                success: function(response) {
                    $('#myTable').DataTable().ajax.reload();
                    Swal.fire({
                        title: "Success!",
                        text: response.message,
                        icon: "success",
                        timer: 2000,
                        timerProgressBar: true,
                        confirmButtonText: "Ok"
                    });
                },
                error: function(error) {
                    console.log(error);
                    if (error.status === 500) {
                        Swal.fire({
                            title: "Error!",
                            text: "Failed executing request. Please refresh the page and try again.",
                            icon: "error",
                            timer: 2000,
                            timerProgressBar: true,
                            confirmButtonText: "Ok"
                        });
                    }
                },
                complete: function(response) {
                    updateCSRFToken(response);
                }
            });
        }
    });
</script>

<?php $this->endSection() ?>