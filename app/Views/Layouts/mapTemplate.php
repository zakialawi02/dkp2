<!DOCTYPE html>
<html lang="<?= str_replace('_', '-', service('request')->getLocale()) ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title><?= $this->renderSection('title') . " | SIMATALAUT KALTIM | Sistem Informasi Tata Ruang Laut Kaltim" ?? " SIMATALAUT KALTIM | Sistem Informasi Tata Ruang Laut Kaltim" ?></title>
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
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href=" https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.css " rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <!-- Template Main CSS File -->
    <link href="<?= base_url('assets/css/main_general.css') ?>" rel="stylesheet">

    <style>
        .sidebar {
            position: fixed;
            width: 60px;
            background: #f8f9fa;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            left: 0;
            top: 0;
            z-index: 100;
            padding: 10px 15px;
            gap: 10px;
        }

        .sidebar i {
            font-size: 20px;
            margin: 10px 0;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .icon-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 10px;
            color: #333;
            cursor: pointer;
            text-align: center;
        }

        .icon-wrapper i.active,
        .icon-wrapper i.active+span,
        .icon-wrapper i:hover,
        .icon-wrapper i:hover+span {
            color: var(--primary-color);
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
            display: flex;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #fff;
            padding: 8px 15px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 10;
            gap: 10px;
        }

        .bottombar i {
            font-size: 18px;
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

        .info_status {
            font-size: small;
            display: block;
        }

        @media screen and (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
        }
    </style>

    <?= $this->renderSection('css') ?>
</head>

<body class="overflow-hidden">
    <?= $this->include('components/front/_headerMap'); ?>

    <div class="sidebar d-none d-md-flex">
        <div class="p-4 m-2"></div>

        <div class="icon-wrapper">
            <i class="bi bi-layers toggleLayers" data-bs-toggle="tooltip" title="Layers"></i>
            <span>Layers</span>
        </div>
        <div class="icon-wrapper">
            <i class="bi bi-rulers toggleMeasurement" data-bs-toggle="tooltip" title="Pengukuran"></i>
            <span>Ukur</span>
        </div>
        <div class="icon-wrapper">
            <i class="bi bi-geo toggleCekKesesuaian" data-bs-toggle="tooltip" title="Cek Kesesuaian"></i>
            <span>Cek</span>
        </div>
    </div>



    <main class="main-content">
        <div class="map-container">
            <!-- Content -->
            <?= $this->renderSection('content') ?>
        </div>

        <div class="bottombar d-md-none">
            <div class="icon-wrapper">
                <i class="bi bi-zoom-in toggleZoomIn" data-bs-toggle="tooltip" title="Zoom In"></i>
                <span>Zoom In</span>
            </div>
            <div class="icon-wrapper">
                <i class="bi bi-search toggleSearch" data-bs-toggle="tooltip" title="Search"></i>
                <span>Search</span>
            </div>
            <div class="icon-wrapper">
                <i class="bi bi-layers toggleLayers" data-bs-toggle="tooltip" title="Layers"></i>
                <span>Layers</span>
            </div>
            <div class="icon-wrapper">
                <i class="bi bi-rulers toggleMeasurement" data-bs-toggle="tooltip" title="Pengukuran"></i>
                <span>Ukur</span>
            </div>
            <div class="icon-wrapper">
                <i class="bi bi-geo toggleCekKesesuaian" data-bs-toggle="tooltip" title="Cek Kesesuaian"></i>
                <span>Cek</span>
            </div>
        </div>


    </main><!-- End #main -->


    <!-- Vendor JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.all.min.js"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <!-- Template Main JS File -->
    <script src="<?= base_url('assets/js/main_general.js') ?>"></script>

    <script>
        // Setup CSRF Token for AJAX requests
        function setupCSRFToken() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }
        // Update CSRF token after every successful request
        function updateCSRFToken(response) {
            var csrfToken = response.responseJSON.token;
            $('meta[name="csrf-token"]').attr('content', csrfToken);
            $('input[name="csrf_test_name"]').val(csrfToken);
        }

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

        $(".zona").html(loaderSpinner);
        $(".kawasan").html(loaderSpinner);
        $(".kode").html(loaderSpinner);

        /**
         * Creates a panel toggle handler with the given configuration.
         *
         * @param {Object} config - Configuration object for the panel toggle handler.
         * @param {string} config.toggleButtonId - The ID or class of the toggle button.
         * @param {string} config.panelId - The ID or class of the panel.
         * @param {string} config.closeButtonId - The ID or class of the close button.
         * @param {Array<Object>} [config.otherPanelConfigs=[]] - Array of other panel configurations.
         */
        function createPanelToggleHandler(config) {
            const {
                toggleButtonId,
                panelId,
                closeButtonId,
                otherPanelConfigs = []
            } = config;

            const $toggleButton = $(toggleButtonId.startsWith('.') ? toggleButtonId : `#${toggleButtonId}`);
            const $panel = $(panelId.startsWith('.') ? panelId : `#${panelId}`);
            const $closeButton = $(closeButtonId.startsWith('.') ? closeButtonId : `#${closeButtonId}`);

            // Fungsi untuk menutup panel lain
            function closeOtherPanels() {
                otherPanelConfigs.forEach(otherConfig => {
                    const $otherPanel = $(otherConfig.panelId.startsWith('.') ? otherConfig.panelId : `#${otherConfig.panelId}`);
                    const $otherToggleButton = $(otherConfig.toggleButtonId.startsWith('.') ? otherConfig.toggleButtonId : `#${otherConfig.toggleButtonId}`);

                    if ($otherPanel.hasClass('show')) {
                        $otherPanel.removeClass('show');
                        $otherToggleButton.removeClass('active');
                    }
                });
            }

            // Event listener untuk tombol toggle
            $toggleButton.on('click', function(e) {
                // Tutup panel lain terlebih dahulu
                closeOtherPanels();
                $('.icon-wrapper i').removeClass('active');
                // Toggle panel saat ini
                e.preventDefault();
                $panel.toggleClass('show');
                $toggleButton.toggleClass('active', $panel.hasClass('show'));
            });

            // Event listener untuk tombol close
            $closeButton.on('click', function(e) {
                e.preventDefault();
                $panel.removeClass('show');
                $toggleButton.removeClass('active');
            });
        }

        // Konfigurasi untuk layer panel
        createPanelToggleHandler({
            toggleButtonId: '.toggleLayers',
            panelId: 'layerPanel',
            closeButtonId: 'closeLayers',
            otherPanelConfigs: [{
                toggleButtonId: 'toggleMeasurement',
                panelId: 'measurementPanel'
            }]
        });

        // Konfigurasi untuk measurement panel
        createPanelToggleHandler({
            toggleButtonId: '.toggleMeasurement',
            panelId: 'measurementPanel',
            closeButtonId: 'closeMeasurement',
            otherPanelConfigs: [{
                toggleButtonId: 'toggleLayers',
                panelId: 'layerPanel'
            }]
        });

        createPanelToggleHandler({
            toggleButtonId: '.toggleCekKesesuaian',
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

    <?php if (session()->getFlashdata('success')) : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?= session()->getFlashdata('success'); ?>',
                timer: 2500,
            });
        </script>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= session()->getFlashdata('error'); ?>',
                timer: 3000,
            });
        </script>
    <?php endif; ?>

    <?= $this->renderSection('javascript') ?>

</body>


</html>