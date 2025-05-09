<?php $this->extend('Layouts/dashboardTemplate') ?>

<?php $this->section('title') ?>
<?= $title ?? ""; ?> • Dashboard
<?php $this->endSection() ?>

<?php $this->section('og_title') ?>
<?= $title ?? ""; ?> • Dashboard
<?php $this->endSection() ?>

<?php $this->section('css') ?>

<?php $this->endSection() ?>


<?php $this->section('content') ?>
<?= $this->include('components/dependencies/_datatables') ?>

<div class="">
    <div class="mb-3">
        <h1 class="fs-3">Data Jenis Kegiatan</h1>
    </div>

    <div class="card p-3">
        <form id="tambahForm" action="<?= route_to('admin.kesesuaian.kegiatan.create'); ?>" method="post">
            <div class="row">
                <div class="col-md-10">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tambahKegiatan" class="form-label">Nama Kegiatan</label>
                                    <input type="text" class="form-control form-control-sm" id="tambahKegiatan" name="tambahKegiatan" placeholder="Nama Kegiatan" required="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="tambahKKegiatan" class="form-label">Kode Kegiatan</label>
                                    <input type="text" class="form-control form-control-sm" id="tambahKKegiatan" name="tambahKKegiatan" placeholder="K1" required="">
                                </div>
                            </div>
                        </div>
                        <div class="form-text" id="textHelp" style="color: red;"></div>
                    </div>
                </div>
                <div class="col-md-2 align-self-center">
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary" id="tambahkanBtn">Tambahkan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="card p-3">
        <div class="">
            <table class="table-hover table-striped table" id="myTable" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col" style="min-width: 50px; max-width: 100px;">No.</th>
                        <th scope="col" style="min-width: 300px; max-width: 500px;">Nama Kegiatan</th>
                        <th scope="col" style="min-width: 100px; max-width: 300px;">Kode Kegiatan</th>
                        <th scope="col" style="min-width: 100px; max-width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL EDIT/UPDATE -->
<div class="modal fade" id="modalEdit" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">✕</button>
            </div>
            <div class="modal-body">
                <div id="error-messages"></div>
                <div class="tempatEdit">
                    <form id="editForm" method="post">
                        <?php csrf_field() ?>

                        <div class="mb-3">
                            <label for="editKegiatan" class="form-label">Nama Kegiatan</label>
                            <input type="text" class="form-control" name="editKegiatan" id="editKegiatan" required>
                        </div>
                        <div class="mb-3">
                            <label for="editKKegiatan" class="form-label">Kode Kegiatan</label>
                            <input type="text" class="form-control" name="editKKegiatan" id="editKKegiatan" required>
                        </div>
                        <div class="form-text" id="textHelp" style="color: red;"></div>
                        <div class="p-1 text-end">
                            <button type="submit" role="button" class="btn btn-primary" id="saveBtn">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<?php $this->endSection() ?>


<?php $this->section('javascript') ?>

<script>
    $(document).ready(function() {
        const cardErrorMessages = `<div id="body-messages" class="alert alert-danger" role="alert"></div>`;

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
                [1, 'asc']
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama_kegiatan',
                    name: 'nama_kegiatan',
                },
                {
                    data: 'kode_kegiatan',
                    name: 'kode_kegiatan',
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false
                },
            ],
        });

        // Save
        $("#tambahForm").submit(function(e) {
            e.preventDefault();
            setupCSRFToken();
            $("#tambahForm #textHelp").html("");
            const formAction = $("#tambahForm").attr("action");
            let tambahKegiatan = $("#tambahKegiatan").val();
            let tambahKKegiatan = $("#tambahKKegiatan").val();

            $.ajax({
                type: "POST",
                url: formAction,
                data: {
                    "nama_kegiatan": tambahKegiatan,
                    "kode_kegiatan": tambahKKegiatan
                },
                beforeSend: function() {
                    $('#tambahkanBtn').prop('disabled', true);
                },
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
                    const messages = error.responseJSON.errors;
                    $.each(messages, function(indexInArray, message) {
                        $("#tambahForm #textHelp").append('<span>' + message + '</span> <br>');
                    });
                },
                complete: function(response) {
                    $('#tambahkanBtn').prop('disabled', false);
                    updateCSRFToken(response);
                }
            });
        });

        // Update
        $("#editForm").submit(function(e) {
            e.preventDefault();
            setupCSRFToken();
            const formData = $('#editForm').serialize();
            const formAction = $('#editForm').attr('action');
            const method = $('#editForm').attr('method');

            $.ajax({
                type: method,
                url: formAction,
                data: formData,
                beforeSend: function() {
                    $("#error-messages").html("");
                    $('#saveBtn').prop('disabled', true);
                },
                success: function(response) {
                    $('#modalEdit').modal('hide');
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
                    try {
                        $.each(messages, function(indexInArray, message) {
                            $("#body-messages").append('<span>' + message + '</span> <br>');
                        });
                    } catch (error) {
                        $("#body-messages").append('<span>' + messages + '</span> <br>');
                    }
                },
                complete: function(response) {
                    $('#saveBtn').prop('disabled', false);
                    updateCSRFToken(response);
                }
            });

        });

        // Edit data
        $('body').on('click', '.editData', function() {
            $("#error-messages").html("");
            const data = $(this).data('kode');

            $.get(`<?= route_to('admin.kesesuaian.kegiatan.show', ':data') ?>`.replace(':data', data), function(response) {
                $('#modalEdit').modal('show');
                $('#modalEdit').find('.modal-title').text('Edit Data');
                $('#editForm').attr('action', `<?= route_to('admin.kesesuaian.kegiatan.update', ':data') ?>`.replace(':data', data));
                $('#saveBtn').text('Update');
                $('#_method').val('PUT');
                $('#editKegiatan').val(response.data?.nama_kegiatan);
                $('#editKKegiatan').val(response.data?.kode_kegiatan);
            });
        });

        // Delete data
        $('body').on('click', '.deleteData', function(e) {
            e.preventDefault();
            let csrfToken = $('input[name="csrf_test_name"]').val();
            const data = $(this).data('kode');

            confirmDelete(data);
        })

        function confirmDelete(data) {
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
                    deleteData(data);
                }
            });
        }

        function deleteData(data) {
            setupCSRFToken();
            $.ajax({
                type: "DELETE",
                url: `<?= route_to('admin.kesesuaian.kegiatan.delete', ':data') ?>`.replace(':data', data),
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
                    console.error(error);
                    Swal.fire({
                        title: "Error!",
                        text: error.responseJSON.message,
                        icon: "error",
                        timer: 2000,
                        timerProgressBar: true,
                        confirmButtonText: "Ok"
                    });
                },
                complete: function(response) {
                    updateCSRFToken(response);
                }
            });
        }
    });
</script>
<?php $this->endSection() ?>