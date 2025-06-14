<?php $this->extend('Layouts/dashboardTemplate') ?>

<?php $this->section('title') ?>
<?= $title ?? ""; ?> • Dashboard
<?php $this->endSection() ?>

<?php $this->section('og_title') ?>
<?= $title ?? ""; ?> • Dashboard
<?php $this->endSection() ?>

<?php $this->section('css') ?>
<!-- code here -->
<?php $this->endSection() ?>


<?php $this->section('content') ?>
<?= $this->include('components/dependencies/_datatables') ?>

<div class="">
    <div class="mb-3">
        <h1 class="fs-3">Data Kawasan</h1>
    </div>

    <div class="card p-3">
        <form id="tambahForm" action="<?= route_to('admin.kesesuaian.kawasan.create'); ?>" method="post">
            <?= csrf_field(); ?>
            <div class="row">
                <div class="col-md-10">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="kode_kawasan" class="form-label">Kode Kawasan (Kawasan)</label>
                                    <input type="text" class="form-control form-control-sm" id="kode_kawasan" name="kode_kawasan" placeholder="Kode Kawasan" required>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="zona" class="form-label">Zona</label>
                                    <select class="form-select select2" name="zona" id="zona" style="width: 100%;" required>
                                        <option></option>
                                        <?php foreach ($dataZona as $Z) : ?>
                                            <option value="<?= $Z['id_zona']; ?>"><?= $Z['nama_zona']; ?></option>
                                        <?php endforeach ?>
                                    </select>
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
                        <th scope="col" style="min-width: 100px; max-width: 300px;">Kawasan</th>
                        <th scope="col" style="min-width: 300px; max-width: 500px;">Zona</th>
                        <th scope="col" style="min-width: 100px; max-width: 300px;">Aksi</th>
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
                    <form id="editForm" action="" method="post">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="_method" id="_method" value="PUT">

                        <div class="mb-3">
                            <label for="editKawasan" class="form-label">Kode Kawasan (Kawasan)</label>
                            <input type="text" class="form-control form-control-sm" id="editKawasan" name="editKawasan" placeholder="Kode Kawasan" required>
                        </div>
                        <div class="mb-3">
                            <label for="editZona" class="form-label">Zona</label>
                            <select class="form-select select2" name="editZona" id="editZona" style="width: 100%;" required>
                                <option></option>
                                <?php foreach ($dataZona as $Z) : ?>
                                    <option value="<?= $Z['id_zona']; ?>"><?= $Z['nama_zona']; ?></option>
                                <?php endforeach ?>
                            </select>
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
        $("#zona").select2({
            placeholder: "Pilih Zona",
            allowClear: true
        });
        $("#editZona").select2({
            placeholder: "Pilih Zona",
            dropdownParent: $("#modalEdit"),
            allowClear: true
        });

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
                [2, 'ASC']
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'kode_kawasan',
                    name: 'kode_kawasan',
                },
                {
                    data: 'nama_zona',
                    name: 'nama_zona',
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false
                },

            ],
        });

        const cardErrorMessages = `<div id="body-messages" class="alert alert-danger" role="alert"></div>`;

        // Save
        $("#tambahForm").submit(function(e) {
            e.preventDefault();
            setupCSRFToken();
            $("#tambahForm #textHelp").html("");
            const formAction = $("#tambahForm").attr("action");
            let kode_kawasan = $("#kode_kawasan").val();
            let zona = $("#zona").val();

            $.ajax({
                type: "POST",
                url: formAction,
                data: {
                    "zona": zona,
                    "kode_kawasan": kode_kawasan,
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
                    $('#tambahForm')[0].reset();
                    $("#zona").val(null).trigger('change');
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

        // Edit data
        $('body').on('click', '.editData', function() {
            $("#error-messages").html("");
            $("#passwordHelpBlock").html("blank if you don't want to change");
            const dataKawasan = $(this).data('id');

            $.get(`<?= route_to('admin.kesesuaian.kawasan.show', ':dataKawasan') ?>`.replace(':dataKawasan', dataKawasan), function(data) {
                $('#modalEdit').modal('show');
                $('#modalEdit').find('.modal-title').text('Edit Data');
                $('#editForm').attr('action', `<?= route_to('admin.kesesuaian.kawasan.update', ':dataKawasan') ?>`.replace(':dataKawasan', dataKawasan));
                $('#saveBtn').text('Update');
                $('#_method').val('PUT');
                $('#editKawasan').val(data?.data?.kode_kawasan);
                $('#editZona').val(data?.data?.id_zona).trigger('change');
            });
        });

        // Delete data
        $('body').on('click', '.deleteData', function(e) {
            e.preventDefault();
            const kawasan = $(this).data('id');

            confirmDelete(kawasan);
        })

        function confirmDelete(kawasan) {
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
                    deleteData(kawasan);
                }
            });
        }

        function deleteData(kawasan) {
            setupCSRFToken();
            $.ajax({
                type: "DELETE",
                url: `<?= route_to('admin.kesesuaian.kawasan.delete', ':kawasan') ?>`.replace(':kawasan', kawasan),
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