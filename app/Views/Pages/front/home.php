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
<!-- Modul Segment -->
<section id="hero" class="hero section">

    <img src="<?= base_url('assets/img/Web-SIMATALAUT.webp') ?>" alt="" data-aos="fade-in">

    <div class="container">
        <div class="align-items-center text-center">
            <h2 data-aos="fade-up" data-aos-delay="100">Selamat Datang</h2>
            <p data-aos="fade-up" data-aos-delay="200">Di Aplikasi Sistem Informasi Tata Ruang Laut Kaltim (Simata Laut Kaltim) Dinas Kelautan dan Perikanan Provinsi Kalimantan Timur.</p>
            <div class="d-flex justify-content-center gap-2 mt-4" data-aos="fade-up" data-aos-delay="300">
                <a href="/cek" class="btn btn-primary">Cek Kesesuaian Lokasi</a>
                <a href="https://oss.go.id/" class="btn btn-light ms-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Via OSS" target="_blank">Ajukan Perizinan Usaha</a>
            </div>
        </div>
    </div>

</section>
<!-- End Modul Segment -->

<!-- Modul Segment -->
<section class="modul pt-5" id="modul" style="min-height: 20vh;">
    <div class="container p-5 ">

        <center class="">
            <h2>Modul</h2>
        </center>

        <center class="">
            <p>Modul ini adalah koleksi sumber daya untuk membantu anda menjelajahi tata ruang laut di Provinsi Kalimantan Timur. Temukan peraturan, panduan, dan dokumen penting lainnya.</p>
            <br>
            <a href="/data/modul" class="btn btn-primary">Lihat Dokumen</a>
        </center>

    </div>
</section>

<!-- discover -->
<section id="discover">

    <div class="container p-5">
        <div class="mt-5 p-2"></div>
        <center>
            <h2>Ajukan Permohonan</h2>
            <p>Anda dapat mengajukan permohonan informasi ruang laut secara mandiri dengan sistem daring (online)</p>
        </center>

        <div class="d-flex flex-wrap gap-4 align-content-center justify-content-center mt-3 pt-2">
            <div class="card" style="width: 15rem;">
                <img src="<?= base_url('assets/img/checking.png'); ?>" class="card-img-top p-4">
                <div class="card-body">
                    <center>
                        <h5 class="card-title">Cek Kesesuaian</h5>
                        <p class="card-text">Melihat Kesesuaian Kegiatan Pemanfaatan Ruang Laut.</p>
                    </center>
                </div>
            </div>
            <div class="card" style="width: 15rem;">
                <img src="<?= base_url('assets/img/create.png'); ?>" class="card-img-top p-4">
                <div class="card-body">
                    <center>
                        <h5 class="card-title">Buat Ajuan</h5>
                        <p class="card-text">Buat Ajuan Melakukan permohonan Informasi Kesesuaian ruang Laut secara mandiri dengan sistem daring (online).</p>
                    </center>
                </div>
            </div>
            <div class="card" style="width: 15rem;">
                <img src="<?= base_url('assets/img/verification.png'); ?>" class="card-img-top p-4">
                <div class="card-body">
                    <center>
                        <h5 class="card-title">Lihat Status Ajuan</h5>
                        <p class="card-text">Pemohon dapat melihat status pengajuan Informasi Kesesuaian Ruang Laut.</p>
                    </center>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- discover End -->

<!-- About Segment -->
<section class="about pt-5" id="about" style="min-height: 20vh;">
    <div class="container p-5 ">

        <center class="">
            <h2>Tentang Kami</h2>
        </center>

        <center class="">
            <p>Aplikasi Simata Laut Kaltim (Sistem Informasi Tata Ruang Laut Kaltim) merupakan aplikasi yang dapat digunakan oleh masyarakat umum untuk memberikan akses Informasi Kesesuaian Kegiatan Pemanfaatan Ruang Laut di wilayah pesisir dan laut Provinsi Kalimantan Timur.</p>
        </center>

    </div>
</section>
<?php $this->endSection() ?>

<?php $this->section('javascript') ?>
<!-- Code here -->
<?php $this->endSection() ?>