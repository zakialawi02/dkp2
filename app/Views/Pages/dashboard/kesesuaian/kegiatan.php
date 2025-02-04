<?php $this->extend('Layouts/dashboardTemplate') ?>

<?php $this->section('title') ?>
<?= $title ?? ""; ?> • Dashboard
<?php $this->endSection() ?>

<?php $this->section('og_title') ?>
<?= $title ?? ""; ?> • Dashboard
<?php $this->endSection() ?>

<?php $this->section('css') ?>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.min.css" rel="stylesheet">

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
        <div class="table-responsive">
            <table class="table-hover table-striped table" id="myTable" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col" style="min-width: 50px; max-width: 100px;">No.</th>
                        <th scope="col" style="min-width: 300px; max-width: 500px;">Nama Kegiatan</th>
                        <th scope="col" style="min-width: 100px; max-width: 300px;">Kode Kegiatan</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->endSection() ?>


<?php $this->section('javascript') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.all.min.js"></script>

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
    });
</script>
<?php $this->endSection() ?>