<?php $this->extend('Layouts/mainTemplate'); ?>

<?php $this->section('title') ?>
<?= $title ?? ""; ?>
<?php $this->endSection() ?>

<?php $this->section('meta_description') ?>

<?php $this->endSection() ?>

<?php $this->section('meta_keywords') ?>

<?php $this->endSection() ?>

<?php $this->section('og_title') ?>
<?= $title ?? ""; ?>
<?php $this->endSection() ?>

<?php $this->section('css') ?>
<!-- Code here -->
<?php $this->endSection() ?>

<?php $this->section('content') ?>
<div class="title-data">
    <h2 class="text-white fw-bold">Modul</h2>
</div>

<section>
    <div class="container mt-3 pt-3">
        <?php if (empty($dataModul)) : ?>
            <div class="data-list d-flex flex-wrap justify-content-center w-100 gap-2 p-3">
                <p>Tidak ada data</p>
            </div>
        <?php else : ?>
            <div class="data-list d-flex flex-wrap justify-content-start w-100 gap-2 p-3">
                <?php foreach ($dataModul as $row) : ?>
                    <div class="card" style="width: 18rem;">
                        <img src=" /assets/img/<?= (empty($row->thumb_modul)) ? 'document.png' : $row->thumb_modul ?>" class="card-img-top p-2" alt="thumbnail" style="width: 8rem; align-self: center;">
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($row->judul_modul); ?></h5>
                            <p class="card-text"><?= esc($row->deskripsi); ?></p>
                            <!-- <p style="font-size: smaller;">Zipped Shapefile</p> -->
                            <a href="/dokumen/modul/<?= esc($row->file_modul); ?>" class="btn btn-primary bi bi-cloud-arrow-down-fill" target="_blank"> Download</a>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>

    </div>
</section>

<?php $this->section('javascript') ?>
<!-- Code here -->
<?php $this->endSection() ?>

<?php $this->endSection() ?>