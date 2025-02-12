<?php $this->extend('Layouts/dashboardTemplate') ?>

<?php $this->section('title') ?>
<?= $title ?? ""; ?> • Dashboard
<?php $this->endSection() ?>

<?php $this->section('og_title') ?>
<?= $title ?? ""; ?> • Dashboard
<?php $this->endSection() ?>

<?php $this->section('css') ?>
<!-- Code here -->
<?php $this->endSection() ?>


<?php $this->section('content') ?>
<?= $this->include('components/dependencies/_datatables') ?>

<div class="">
    <div class="mb-3">
        <h1 class="fs-3">Data Permohonan Masuk</h1>
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
                        <th scope="col" style="min-width: 150px; max-width: 200px;">Tanggal Masuk</th>
                        <th scope="col" style="min-width: 150px; max-width: 270px;">Nama Pemohon</th>
                        <th scope="col" style="min-width: 150px; max-width: 200px;">NIK</th>
                        <th scope="col" style="min-width: 200px; max-width: 300px;">Alamat</th>
                        <th scope="col" style="min-width: 220px; max-width: 340px;">Jenis Kegiatan</th>
                        <th scope="col" style="min-width: 100px">Action</th>
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
                    data: 'nama',
                    name: 'nama',
                },
                {
                    data: 'nik',
                    name: 'nik',
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
    });
</script>
<?php $this->endSection() ?>