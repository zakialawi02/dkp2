<?php $this->extend('Layouts/dashboardTemplate') ?>

<?php $this->section('title') ?>
<?= $title ?? ""; ?> • Dashboard
<?php $this->endSection() ?>

<?php $this->section('og_title') ?>
<?= $title ?? ""; ?> • Dashboard
<?php $this->endSection() ?>

<?php $this->section('css') ?>
<style>
    .card table {
        font-size: 0.95rem;
    }
</style>
<?php $this->endSection() ?>


<?php $this->section('content') ?>
<?= $this->include('components/dependencies/_datatables') ?>

<div class="">
    <div class="mb-3">
        <h1 class="fs-3"> Data Permohonan Disetujui Tanpa Lampiran</h1>
    </div>

    <div class="card p-3">
        <div class="mb-3">
            <button type="button" class="btn btn-sm btn-primary" id="refreshTable"><i class="bi bi-arrow-counterclockwise"></i> Refresh</button>
        </div>
        <div class="">
            <table class="table-hover table-striped table" id="myTable" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col" style="min-width: 120px; max-width: 140px;">Tanggal Masuk</th>
                        <th scope="col" style="min-width: 120px; max-width: 140px;">Tanggal Dibalas</th>
                        <th scope="col" style="min-width: 150px; max-width: 200px;">NIK</th>
                        <th scope="col" style="min-width: 200px; max-width: 300px;">Nama</th>
                        <th scope="col" style="min-width: 200px; max-width: 300px;">Alamat</th>
                        <th scope="col" style="min-width: 240px; max-width: 320px;">Jenis Kegiatan</th>
                        <th scope="col" style="min-width: 120px">Action</th>
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
<script>
    $(document).ready(function() {
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
                [1, 'DESC']
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                },
                {
                    data: 'date_updated',
                    name: 'date_updated',
                },
                {
                    data: 'nik',
                    name: 'nik',
                },
                {
                    data: 'nama',
                    name: 'nama',
                },
                {
                    data: 'alamat',
                    name: 'alamat',
                },
                {
                    data: 'nama_kegiatan',
                    name: 'nama_kegiatan',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },

            ],
        });

        $("#refreshTable").click(function(e) {
            table.ajax.reload();
        });

        // Delete data
        $('body').on('submit', '.deleteData', function(e) {
            e.preventDefault();
            const data = $(this).closest('form').attr('action');

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
                url: `${data}`,
                success: function(response) {
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
                    $('#myTable').DataTable().ajax.reload();
                    updateCSRFToken(response);
                }
            });
        }
    });
</script>
<?php $this->endSection() ?>