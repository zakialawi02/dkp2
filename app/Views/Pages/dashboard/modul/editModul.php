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
        <h1 class="fs-3">Edit Modul</h1>
    </div>

    <div class="card p-3">
        <form action="<?= route_to('admin.modul.update', $dataModul->id_modul); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
            <?= csrf_field(); ?>
            <input type="hidden" name="_method" value="PUT">

            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="judul_modul" class="form-label">Judul Modul <span style="color: red;">*</span></label>
                        <input type="text" class="form-control form-control-sm" id="judul_modul" name="judul_modul" placeholder="Nama/Judul Modul" value="<?= $dataModul->judul_modul ?? old('judul_modul'); ?>" required>
                        <?php if (session()->has('errors')) : ?>
                            <span class="text-danger"><?= session('errors.judul_modul') ?></span>
                        <?php endif ?>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Modul <span style="color: red;">*</span></label>
                        <textarea type="text" class="form-control form-control-sm" id="deskripsi" name="deskripsi" placeholder="Deskripsi Modul" rows="5" required><?= $dataModul->deskripsi ?? old('deskripsi'); ?></textarea>
                        <?php if (session()->has('errors')) : ?>
                            <span class="text-danger"><?= session('errors.deskripsi') ?></span>
                        <?php endif ?>
                    </div>
                    <div class="mb-3">
                        <label for="file_modul" class="form-label">File Modul <span style="color: red;">*</span></label>
                        <input type="file" class="form-control form-control-sm" id="file_modul" name="file_modul" accept=".pdf, .xlsx, .docx, .csv, image/*" required>
                        <?php if (session()->has('errors')) : ?>
                            <span class="text-danger"><?= session('errors.file_modul') ?></span>
                        <?php endif ?>
                    </div>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php $this->endSection() ?>


<?php $this->section('javascript') ?>
<!-- Code here -->
<?php $this->endSection() ?>