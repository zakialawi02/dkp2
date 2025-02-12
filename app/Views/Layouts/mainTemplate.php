<!DOCTYPE html>
<html lang="<?= str_replace('_', '-', service('request')->getLocale()) ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title><?= $this->renderSection('title') . " | SIMATALAUT KALTIM | Sistem Informasi Tata Ruang Laut Kaltim" ?? "SIMATALAUT KALTIM | Sistem Informasi Tata Ruang Laut Kaltim" ?></title>
    <meta name="description" content="<?= $this->renderSection('meta_description') ?? '' ?>">
    <meta name="author" content="<?= $this->renderSection('meta_author') ?? 'Ahmad Zaki Alawi' ?>">

    <meta property="og:title" content="<?= $this->renderSection('og_title') ?? "" ?>" />
    <meta property="og:type" content="<?= $this->renderSection('og_type') ?? 'website' ?>" />
    <meta property="og:url" content="<?= $this->renderSection('og_url') ?? current_url() ?>" />
    <meta property="og:description" content="<?= $this->renderSection('og_description') ?? "" ?>" />
    <meta property="og:image" content="<?= $this->renderSection('og_image') ?? base_url('assets/img/favicon.png') ?>" />

    <meta name="robots" content="<?= $this->renderSection('meta_robots') ?? 'index,follow' ?>">

    <meta name="csrf-token" content="<?= csrf_hash() ?>">

    <!-- Favicons -->
    <link href="<?= base_url('assets/img/favicon.png') ?>" rel="icon">
    <link href="<?= base_url('assets/img/favicon.png') ?>" rel="apple-touch-icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Vendor CSS Files -->
    <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?= base_url('assets/css/main_general.css') ?>" rel="stylesheet">


    <?= $this->renderSection('css') ?>
</head>

<body class="index-page">
    <?= $this->include('components/front/_header'); ?>

    <main class="main">


        <!-- Content -->
        <?= $this->renderSection('content') ?>


    </main><!-- End #main -->

    <?= $this->include('components/front/_footer'); ?>

    <!-- Vendor JS Files -->
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

    <!-- Template Main JS File -->
    <script src="<?= base_url('assets/js/main_general.js') ?>"></script>

    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>

    <?= $this->renderSection('javascript') ?>

</body>


</html>