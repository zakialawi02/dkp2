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
        <h1 class="fs-3">Data Permohonan Tidak Disetujui</h1>
    </div>

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table-hover table-striped table" id="myTable" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">No. Permohonan</th>
                        <th scope="col" style="min-width: 150px; max-width: 200px;">Tanggal Masuk</th>
                        <th scope="col" style="min-width: 150px; max-width: 200px;">NIK</th>
                        <th scope="col" style="min-width: 200px; max-width: 300px;">Nama</th>
                        <th scope="col" style="min-width: 200px; max-width: 300px;">Alamat</th>
                        <th scope="col" style="min-width: 200px; max-width: 300px;">Jenis Kegiatan</th>
                        <th scope="col" style="min-width: 120px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>2023-10-01</td>
                        <td>1234567890123456</td>
                        <td>John Doe</td>
                        <td>123 Main St, Springfield</td>
                        <td>Pemasangan pipa intake dan outake industri dan perikanan</td>
                        <td>
                            <a href="/dashboard/permohonan/edit/1" class="btn btn-sm btn-warning" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="edit data"><i class="bi bi-pencil-square"></i></a>
                            <a href="/dashboard/permohonan/view/1" class="btn btn-sm btn-primary" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="view data"><i class="bi bi-eye"></i></a>
                            <form action="/dashboard/permohonan/delete/1" method="post" class="d-inline" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="delete data">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i></button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>2023-10-02</td>
                        <td>9876543210987654</td>
                        <td>Jane Doe</td>
                        <td>456 Elm St, Springfield</td>
                        <td>Budidaya mangrove</td>
                        <td>
                            <a href="/dashboard/permohonan/edit/1" class="btn btn-sm btn-warning" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="edit data"><i class="bi bi-pencil-square"></i></a>
                            <a href="/dashboard/permohonan/view/1" class="btn btn-sm btn-primary" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="view data"><i class="bi bi-eye"></i></a>
                            <form action="/dashboard/permohonan/delete/1" method="post" class="d-inline" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="delete data">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i></button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>2023-10-03</td>
                        <td>2468101214161824</td>
                        <td>Richard Roe</td>
                        <td>789 Oak St, Springfield</td>
                        <td>Pembuangan Hasil Pengerukan (Dumping Area)</td>
                        <td>
                            <a href="/dashboard/permohonan/edit/1" class="btn btn-sm btn-warning" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="edit data"><i class="bi bi-pencil-square"></i></a>
                            <a href="/dashboard/permohonan/view/1" class="btn btn-sm btn-primary" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="view data"><i class="bi bi-eye"></i></a>
                            <form action="/dashboard/permohonan/delete/1" method="post" class="d-inline" role="group" aria-label="First group" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="delete data">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i></button>
                            </form>
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