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
<?php $status_enum = ['diperbolehkan', 'diperbolehkan bersyarat', 'tidak diperbolehkan'] ?>

<div class="">
    <div class="mb-3">
        <h1 class="fs-3">Data Kesesuaian</h1>
    </div>

    <div class="card mb-3 py-3">
        <div class="card-body">
            <form id="tambahForm" method="post">
                <?= csrf_field(); ?>
                <div class="row">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="tambahZona" class="form-label">Zona</label>
                                        <select class="form-select select2" name="tambahZona" id="tambahZona" style="width: 100%;" required>
                                            <option></option>
                                            <?php foreach ($dataZona as $Z) : ?>
                                                <option value="<?= $Z->id_zona; ?>"><?= esc($Z->nama_zona); ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 tambahSubZona d-none">
                                    <div class="mb-3">
                                        <label for="tambahSubZona" class="form-label">Sub Zona</label>
                                        <select class="form-select form-select-sm" name="tambahSubZona" id="tambahSubZona" style="width: 100%;">
                                            <option value="Inti">Zona Inti</option>
                                            <option value="ZPT">Zona Pemanfaatan Terbatas</option>
                                            <option value="Lainnya">Zona Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="tambahKegiatan" class="form-label">Jenis Kegiatan</label>
                                        <select class="form-select select2" name="tambahKegiatan" id="tambahKegiatan" style="width: 100%;" required>
                                            <option> </option>
                                            <?php foreach ($dataKegiatan as $kg) : ?>
                                                <option value="<?= $kg->kode_kegiatan; ?>"><?= esc($kg->kode_kegiatan); ?> - <?= esc($kg->nama_kegiatan); ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="tambahStatus" class="form-label">Status Kesesuaian</label>
                                        <select class="form-select form-select-sm" name="tambahStatus" id="tambahStatus" required>
                                            <option>-- Pilih Status --</option>
                                            <?php foreach ($status_enum as $S) : ?>
                                                <option value="<?= $S; ?>"><?= $S; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-text" id="textHelp" style="color: red;"></div>
                    </div>
                    <div class="col-md-2 align-self-center">
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary" id="tambahkan">Tambahkan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card p-3">
        <div class="row mb-2">
            <div class="col-md-6 mb-2">
                <label class="form-label mb-2">Filter Berdasarkan:</label>
                <select class="form-select" id="pilihZona" name="pilihZona" style="width: 100%;">
                    <option value="0">Semua Zona</option>
                    <?php foreach ($dataZona as $Z) : ?>
                        <option value="<?= $Z->id_zona ?>" <?= ($Z->id_zona == $zona) ? 'selected' : '' ?>><?= esc($Z->nama_zona) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>

        <?php foreach ($dataZona as $Z) : ?>
            <?php if ($Z->id_zona == $zona) : ?>
                <?php $nama_zona = $Z->nama_zona ?>
                <?php break; ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <h6 class="pt-2 pb-2">Zona: <?= $nama_zona ?? 'Semua Zona' ?></h6>

        <div class="">
            <table class="table-hover table-striped table" id="myTable" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col" style="min-width: 50px; max-width: 100px;">#</th>
                        <th scope="col" style="min-width: 200px; max-width: 250px;">Zona</th>
                        <th scope="col" style="min-width: 100px; max-width: 180px;">Sub Zona</th>
                        <th scope="col" style="min-width: 100px; max-width: 120px;">Kode Kegiatan</th>
                        <th scope="col" style="min-width: 200px; max-width: 450px;">Nama Kegiatan</th>
                        <th scope="col" style="min-width: 180px; max-width: 240px;">Status Keseuaian</th>
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
                    <form id="editForm" method="post">
                        <?php csrf_field() ?>

                        <div class="mb-3">
                            <label for="editZona" class="form-label">Zona</label>
                            <select class="form-select select2" name="editZona" id="editZona" style="width: 100%;" required>
                                <option></option>
                                <?php foreach ($dataZona as $Z) : ?>
                                    <option value="<?= $Z->id_zona; ?>"><?= esc($Z->nama_zona); ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="mb-3 editSubZona">
                            <label for="editSubZona" class="form-label">Sub Zona</label>
                            <select class="form-select form-select-sm" name="editSubZona" id="editSubZona" style="width: 100%;">
                                <option value="Inti">Zona Inti</option>
                                <option value="ZPT">Zona Pemanfaatan Terbatas</option>
                                <option value="Lainnya">Zona Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editKegiatan" class="form-label">Jenis Kegiatan</label>
                            <select class="form-select select2" name="editKegiatan" id="editKegiatan" style="width: 100%;" required>
                                <option> </option>
                                <?php foreach ($dataKegiatan as $kg) : ?>
                                    <option value="<?= $kg->kode_kegiatan; ?>"><?= esc($kg->kode_kegiatan); ?> - <?= esc($kg->nama_kegiatan); ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="editStatus" class="form-label">Status Kesesuaian</label>
                            <?php $status_enum = ['diperbolehkan', 'diperbolehkan bersyarat', 'tidak diperbolehkan'] ?>
                            <select class="form-select form-select-sm" name="editStatus" id="editStatus" required>
                                <?php foreach ($status_enum as $S) : ?>
                                    <option value="<?= $S; ?>"><?= $S; ?></option>
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
    $("#pilihZona").select2({
        placeholder: "Pilih Kegiatan",
        allowClear: true
    });
    $("#tambahZona").select2({
        placeholder: "Pilih Zona",
        allowClear: true
    });
    $("#tambahKegiatan").select2({
        placeholder: "Pilih Kegiatan",
        allowClear: true
    });
    $("#editKegiatan").select2({
        placeholder: "Pilih Kegiatan",
        dropdownParent: $("#modalEdit"),
        allowClear: true
    });
    $("#editZona").select2({
        placeholder: "Pilih Zona",
        dropdownParent: $("#modalEdit"),
        allowClear: true
    });

    $("#pilihZona").change(function(e) {
        e.preventDefault();
        const zona = $("#pilihZona").val();
        const url = new URL(window.location.href);
        url.searchParams.set('zona', zona);
        window.history.pushState({}, '', url);
        table.ajax.url(url.href).load();
        $("h6[class='pt-2 pb-2']").text("Zona: " + $("#pilihZona").find(":selected").text());
    });

    let table = new DataTable('#myTable', {
        processing: true,
        serverSide: true,
        ajax: window.location.href,
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
            [1, 'ASC']
        ],
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'nama_zona',
                name: 'tbl_zona.nama_zona'
            },
            {
                data: 'sub_zona',
                name: 'tbl_kesesuaian.sub_zona'
            },
            {
                data: 'kode_kegiatan',
                name: 'tbl_kesesuaian.kode_kegiatan'
            },
            {
                data: 'nama_kegiatan',
                name: 'tbl_kegiatan.nama_kegiatan'
            },
            {
                data: 'status',
                name: 'tbl_kesesuaian.status',
                orderable: false,
                searchable: false,
                render: function(data) {
                    let statusColor = '';
                    switch (data) {
                        case 'diperbolehkan':
                            statusColor = 'green';
                            break;
                        case 'diperbolehkan bersyarat':
                            statusColor = 'orange';
                            break;
                        case 'tidak diperbolehkan':
                            statusColor = 'red';
                            break;
                    }
                    return `<span style="color:${statusColor}">${data.charAt(0).toUpperCase() + data.slice(1)}</span>`;
                }
            },
            {
                data: 'aksi',
                name: 'aksi',
                orderable: false,
                searchable: false
            }
        ],
        drawCallback: function(settings) {
            let api = this.api();
            let seen = {};

            api.rows({
                page: 'current'
            }).every(function(rowIdx, tableLoop, rowLoop) {
                let data = this.data();
                let key = data.nama_zona + '|' + data.sub_zona + '|' + data.kode_kegiatan;

                if (seen[key]) {
                    // kasih bold ke row yang sama
                    let row = $(this.node());
                    row.find('td:eq(1), td:eq(2), td:eq(3)').css('font-weight', 'bold');
                } else {
                    seen[key] = true;
                }
            });
        }
    });

    const cardErrorMessages = `<div id="body-messages" class="alert alert-danger" role="alert"></div>`;
    let subzona;
    let strictZone = ["Kawasan Konservasi Lainnya", "Taman", "Kawasan Konservasi Maritim", "Pencadangan/Indikasi Kawasan Konservasi"];
    $("#tambahZona").change(function() {
        let valueZona = $("#tambahZona").find(":selected").text();
        if (strictZone.includes(valueZona)) {
            $(".tambahSubZona").removeClass("d-none");
            $("#tambahSubZona").prop("required", true);
            subzona = true;
        } else {
            $(".tambahSubZona").addClass("d-none");
            $("#tambahSubZona").prop("required", false);
            subzona = false;
        }
    });
    $("#editZona").change(function() {
        let valueZona = $("#editZona").find(":selected").text();
        if (strictZone.includes(valueZona)) {
            $(".editSubZona").removeClass("d-none");
            $("#editSubZona").prop("required", true);
            subzona = true;
        } else {
            $(".editSubZona").addClass("d-none");
            $("#editSubZona").prop("required", false);
            subzona = false;
        }
    });

    // Save
    $("#tambahkan").click(function(e) {
        e.preventDefault();
        $("#tambahForm #textHelp").html("");
        let tambahZona = $("#tambahZona").val();
        let tambahSubZona = null;
        if (subzona) {
            tambahSubZona = $("#tambahSubZona").val();
        }
        let tambahKegiatan = $("#tambahKegiatan").val();
        let tambahStatus = $("#tambahStatus").val();
        let isValid = true;
        $("#tambahForm select[required]").each(function() {
            if ($(this).val() == "" || $(this).val() == null) {
                isValid = false;
                return;
            }
        });
        if (!isValid) {
            $("#tambahForm #textHelp").html("Harap isi semua kolom yang ada");
            return;
        }
        setupCSRFToken();
        $.ajax({
            type: "POST",
            url: `<?= route_to('admin.kesesuaian.kesesuaian.store') ?>`,
            data: {
                csrf_test_name: $('input[name="csrf_test_name"]').val(),
                tambahZona,
                tambahSubZona,
                tambahKegiatan,
                tambahStatus
            },
            dataType: "json",
            beforeSend: function() {
                $("#tambahForm #textHelp").html("");
                $("#tambahkan").prop("disabled", true);
            },
            success: function(response) {
                table.ajax.url(window.location.href).load();
                swal.fire({
                    title: "Berhasil",
                    text: response.message,
                    icon: "success",
                    showConfirmButton: true,
                    timer: 1500
                });
                $("#tambahForm")[0].reset();
                $("#tambahZona").val(null).trigger("change");
                $("#tambahKegiatan").val(null).trigger("change");
                $("#tambahkan").prop("disabled", false);
            },
            error: function(response) {
                console.error(response);
                swal.fire({
                    title: "Gagal",
                    text: response.responseJSON.message,
                    icon: "error",
                    showConfirmButton: true,
                    timer: 1500
                });
            },
            complete: function(response) {
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
        const dataKesesuaian = $(this).data('kesesuaian');

        $.get(`<?= route_to('admin.kesesuaian.kesesuaian.show', ':dataKesesuaian') ?>`.replace(':dataKesesuaian', dataKesesuaian), function(data) {
            $('#modalEdit').modal('show');
            $('#modalEdit').find('.modal-title').text('Edit Data');
            $('#editForm').attr('action', `<?= route_to('admin.kesesuaian.kesesuaian.update', ':dataKesesuaian') ?>`.replace(':dataKesesuaian', dataKesesuaian));
            $('#saveBtn').text('Update');
            $('#_method').val('PUT');
            $('#editZona').val(data?.data[0]?.id_zona).trigger('change');
            $('#editSubZona').val(data?.data[0]?.sub_zona);
            $('#editKegiatan').val(data?.data[0]?.kode_kegiatan).trigger('change');
            $('#editStatus').val(data?.data[0]?.status);
        });
    });

    // Delete data
    $('body').on('click', '.deleteData', function(e) {
        e.preventDefault();
        let csrfToken = $('input[name="csrf_test_name"]').val();
        const data = $(this).data('kesesuaian');

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
            url: `<?= route_to('admin.kesesuaian.kesesuaian.delete', ':data') ?>`.replace(':data', data),
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
</script>
<?php $this->endSection() ?>