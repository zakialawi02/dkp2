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
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae at est, pariatur veritatis dolor repudiandae.</p>
    </div>
</div>

<?php $this->endSection() ?>


<?php $this->section('javascript') ?>
<!-- Code here -->
<?php $this->endSection() ?>