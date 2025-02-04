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

<div class="">
    <div class="mb-3">
        <h1 class="fs-3">Data Permohonan Masuk</h1>
    </div>

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table-hover table-striped table" id="myTable" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">No. Permohonan</th>
                        <th scope="col" style="min-width: 150px; max-width: 200px;">Tanggal Masuk</th>
                        <th scope="col" style="min-width: 200px; max-width: 300px;">Nama Pemohon</th>
                        <th scope="col" style="min-width: 150px; max-width: 200px;">NIK</th>
                        <th scope="col" style="min-width: 200px; max-width: 300px;">Alamat</th>
                        <th scope="col" style="min-width: 200px; max-width: 300px;">Jenis Kegiatan</th>
                        <th scope="col" style="min-width: 120px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>2023-10-02</td>
                        <td>Jane Doe</td>
                        <td>9876543210987654</td>
                        <td>456 Elm St, Springfield</td>
                        <td>Usaha pembudidayaan ikan laut (kerapu, kakap, baronang)</td>
                        <td>
                            <a href="/dashboard/permohonan/edit/1" class="btn btn-sm btn-warning"><i class="bi bi-binoculars"></i> Periksa</a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>2023-10-03</td>
                        <td>Robert Smith</td>
                        <td>5551234567890123</td>
                        <td>789 Oak St, Springfield</td>
                        <td>Jasa Wisata Tirta (bahari)</td>
                        <td>
                            <a href="/dashboard/permohonan/edit/1" class="btn btn-sm btn-warning"><i class="bi bi-binoculars"></i> Periksa</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->endSection() ?>


<?php $this->section('javascript') ?>
<!-- Code here -->
<?php $this->endSection() ?>