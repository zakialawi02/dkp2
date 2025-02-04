<!DOCTYPE html>
<html lang="<?= str_replace('_', '-', service('request')->getLocale()) ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title><?= $this->renderSection('title') ?? "" ?></title>
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
    <link href="<?= base_url('assets/img/apple-touch-icon.png') ?>" rel="apple-touch-icon">

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">

    <style>
        @media (max-width: 768px) {

            #myTable,
            #myTable1,
            #myTable2 {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }
    </style>

    <?= $this->renderSection('css') ?>
</head>

<body>

    <!-- ======= Header ======= -->
    <?= view('components/dashboard/_header') ?>

    <!-- ======= Sidebar ======= -->
    <?= view('components/dashboard/_sidebar') ?>

    <main class="main" id="main">
        <section class="section dashboard">
            <!-- Content Here -->
            <?= $this->renderSection('content') ?>
        </section>
    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <?= view('components/dashboard/_footer') ?>

    <a class="back-to-top d-flex align-items-center justify-content-center" href="#"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

    <!-- Template Main JS File -->
    <script src="<?= base_url('assets/js/main.js') ?>"></script>

    <?= $this->renderSection('javascript') ?>

</body>

</html>