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
    <link href=" https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.css " rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?= base_url('assets/css/main_general.css') ?>" rel="stylesheet">

    <style>
        .sidebar {
            width: 60px;
            background: #f8f9fa;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 100;
        }

        .sidebar i {
            font-size: 20px;
            margin: 15px 0;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .sidebar i.active {
            color: var(--primary-color);
        }

        .sidebar i:hover {
            color: var(--secondary-color);
        }

        .main-content {
            margin-left: 60px;
            flex: 1;
            display: flex;
            flex-direction: column;
            height: calc(100vh - 56px);
            margin-top: 56px;
        }

        .map-container {
            flex: 1;
            background: #fff;
            position: relative;
        }

        .bottombar {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #fff;
            padding: 8px 15px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .bottombar i {
            font-size: 18px;
            margin: 0 10px;
            cursor: pointer;
            z-index: 10;
        }

        .close-btn {
            cursor: pointer;
            font-size: 24px;
        }

        .form-radio {
            transform: scale(1.3);
            margin-right: 0.5rem;
        }
    </style>

    <?= $this->renderSection('css') ?>
</head>

<body class="overflow-hidden">
    <?= $this->include('components/front/_headerMap'); ?>

    <div class="sidebar">
        <div class="p-4 m-2"></div>
        <i class="bi bi-layers" id="toggleLayers" data-bs-toggle="tooltip" title="Layers"></i>
        <i class="bi bi-rulers" id="toggleMeasurement" data-bs-toggle="tooltip" title="Measurement"></i>
        <i class="bi bi-geo" id="toggleCekKesesuaian" data-bs-toggle="tooltip" title="Cek Kesesuaian"></i>
        <i class="bi bi-geo-alt" data-bs-toggle="tooltip" title="Location"></i>
        <i class="bi bi-vector-pen" data-bs-toggle="tooltip" title="Draw"></i>
    </div>


    <main class="main-content">
        <div class="map-container">
            <!-- Content -->
            <?= $this->renderSection('content') ?>
        </div>

        <div class="bottombar">
            <i class="bi bi-zoom-in" data-bs-toggle="tooltip" title="Zoom In"></i>
            <i class="bi bi-search" data-bs-toggle="tooltip" title="Search"></i>
            <i class="bi bi-house" data-bs-toggle="tooltip" title="Home"></i>
            <i class="bi bi-layers" data-bs-toggle="tooltip" title="Layers"></i>
            <i class="bi bi-rulers" data-bs-toggle="tooltip" title="Measure"></i>
        </div>

    </main><!-- End #main -->


    <!-- Vendor JS Files -->
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

    <!-- Template Main JS File -->
    <script src="<?= base_url('assets/js/main_general.js') ?>"></script>

    <script>
        $(".navbar-toggler").click(function(e) {
            $("#navbarNav").toggleClass("collapse");
            $("#navbarNav").toggleClass("show");
        });
        $("#navbarNav .nav-item.nav-link").click(function(e) {
            $("#navbarNav").removeClass("collapse");
        });
        $(document).click(function(e) {
            if (!$(e.target).closest("#navbarNav").length) {
                $("#navbarNav").removeClass("show");
            }
        });
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        const loaderSpinner = `<div class="text-center text-primary"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></>`;

        /**
         * Creates a panel toggle handler with the given configuration.
         *
         * @param {Object} config - Configuration object for the panel toggle handler.
         * @param {string} config.toggleButtonId - The ID of the toggle button.
         * @param {string} config.panelId - The ID of the panel.
         * @param {string} config.closeButtonId - The ID of the close button.
         * @param {Array<Object>} [config.otherPanelConfigs=[]] - Array of other panel configurations.
         */
        function createPanelToggleHandler(config) {
            const {
                toggleButtonId,
                panelId,
                closeButtonId,
                otherPanelConfigs = []
            } = config;

            const $toggleButton = $(`#${toggleButtonId}`);
            const $panel = $(`#${panelId}`);
            const $closeButton = $(`#${closeButtonId}`);

            // Fungsi untuk menutup panel lain
            function closeOtherPanels() {
                otherPanelConfigs.forEach(otherConfig => {
                    const $otherPanel = $(`#${otherConfig.panelId}`);
                    const $otherToggleButton = $(`#${otherConfig.toggleButtonId}`);

                    if ($otherPanel.hasClass('show')) {
                        $otherPanel.removeClass('show');
                        $otherToggleButton.removeClass('active');
                    }
                });
            }

            // Event listener untuk tombol toggle
            $toggleButton.on('click', function() {
                // Tutup panel lain terlebih dahulu
                closeOtherPanels();

                // Toggle panel saat ini
                $panel.toggleClass('show');
                $toggleButton.toggleClass('active', $panel.hasClass('show'));
            });

            // Event listener untuk tombol close
            $closeButton.on('click', function() {
                $panel.removeClass('show');
                $toggleButton.removeClass('active');
            });
        }

        // Konfigurasi untuk layer panel
        createPanelToggleHandler({
            toggleButtonId: 'toggleLayers',
            panelId: 'layerPanel',
            closeButtonId: 'closeLayers',
            otherPanelConfigs: [{
                toggleButtonId: 'toggleMeasurement',
                panelId: 'measurementPanel'
            }]
        });

        // Konfigurasi untuk measurement panel
        createPanelToggleHandler({
            toggleButtonId: 'toggleMeasurement',
            panelId: 'measurementPanel',
            closeButtonId: 'closeMeasurement',
            otherPanelConfigs: [{
                toggleButtonId: 'toggleLayers',
                panelId: 'layerPanel'
            }]
        });

        createPanelToggleHandler({
            toggleButtonId: 'toggleCekKesesuaian',
            panelId: 'cekKesesuaianPanel',
            closeButtonId: 'closeCekKesesuaian',
            otherPanelConfigs: []
        });

        // Contoh cara menambahkan panel baru
        // createPanelToggleHandler({
        //     toggleButtonId: 'toggleSettings',
        //     panelId: 'settingsPanel',
        //     closeButtonId: 'closeSettings',
        //     otherPanelConfigs: [
        //         {
        //             toggleButtonId: 'toggleLayers',
        //             panelId: 'layerPanel'
        //         },
        //         {
        //             toggleButtonId: 'toggleMeasurement',
        //             panelId: 'measurementPanel'
        //         }
        //     ]
        // });

        // Catatan: 
        // 1. Pastikan jQuery sudah di-include sebelum script ini
        // 2. Struktur HTML harus memiliki id yang sesuai dengan konfigurasi
        // 3. Gunakan kelas 'show' untuk menampilkan/menyembunyikan panel
    </script>

    <?= $this->renderSection('javascript') ?>

</body>


</html>