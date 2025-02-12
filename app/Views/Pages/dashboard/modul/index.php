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
        <h1 class="fs-3">Data Modul</h1>
    </div>

    <div class="card p-3">

        <div class="d-flex justify-content-end align-items-center mb-3 px-2">
            <a href="<?= route_to('admin.modul.create'); ?>" class="btn btn-sm btn-primary"> Tambah Modul </a>
        </div>

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                <?= session()->getFlashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-x-circle me-1"></i>
                <?= session()->getFlashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="">
            <table class="table-hover table-striped table" id="myTable" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Judul Modul</th>
                        <th>Deskripsi</th>
                        <th>Modul</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($dataModul as $M) : ?>
                        <tr>
                            <th><?= $i++; ?></th>
                            <td><?= esc($M->judul_modul); ?></td>
                            <td><?= esc($M->deskripsi); ?></td>
                            <td><a href="/dokumen/modul/<?= $M->file_modul; ?>" class="bi bi-file-earmark-pdf"> File</a></td>
                            <td>
                                <div class="d-inline-flex gap-1">
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <form action="<?= route_to('admin.modul.edit', $M->id_modul); ?>" method="get">
                                            <button type="submit" class="btn-sm btn btn-primary bi bi-pencil-square"></button>
                                        </form>
                                    </div>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <form id="delete-form-<?= $M->id_modul; ?>" class="delete-data" action="<?= route_to('admin.modul.destroy', $M->id_modul); ?>" method="post">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn-sm btn btn-danger bi bi-trash"></button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->endSection() ?>


<?php $this->section('javascript') ?>
<script>
    function confirmDelete(form) {
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
                form.submit();
            }
        });
    }

    $(document).ready(function() {
        $('.delete-data').on('submit', function(e) {
            e.preventDefault();
            confirmDelete(this);
        });
    });
</script>
<?php $this->endSection() ?>