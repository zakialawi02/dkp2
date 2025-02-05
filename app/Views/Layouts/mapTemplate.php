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

        .layer-panel {
            position: absolute;
            top: 90px;
            left: 65px;
            min-width: 200px;
            max-width: 300px;
            background: #fff;
            padding: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            z-index: 10;
            max-height: 32rem;
            transition: transform 0.3s ease-in-out;
            transform: translateX(-200%);
        }

        .layer-panel.show {
            display: block;
            transform: translateX(0);
        }

        .layer-panel-header,
        .measurement-panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .close-btn {
            cursor: pointer;
            font-size: 24px;
        }

        .layer-panel-body {
            margin-top: 8px;
            padding: 6px;
            max-height: 28rem;
            overflow: auto;
        }

        .measurement-panel {
            position: absolute;
            top: 130px;
            left: 65px;
            background: #fff;
            padding: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            z-index: 10;
            transition: transform 0.3s ease-in-out;
            transform: translateX(-200%);
            max-height: 20rem;
            overflow: hidden;
        }

        .measurement-panel.show {
            display: block;
            transform: translateX(0);
        }

        .symbology kkprl-layer {
            display: block;
            font-size: 14px;
            color: #000000;
            padding-bottom: 1px;
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
        <i class="bi bi-geo" data-bs-toggle="tooltip" title="Cek Kesesuaian"></i>
        <i class="bi bi-geo-alt" data-bs-toggle="tooltip" title="Location"></i>
        <i class="bi bi-vector-pen" data-bs-toggle="tooltip" title="Draw"></i>
    </div>

    <div class="layer-panel" id="layerPanel">
        <div class="layer-panel-header">
            <h6>Layers</h6>
            <i class="bi bi-x close-btn" id="closeLayers"></i>
        </div>
        <div class="layer-panel-body">
            <label class="symbology kkprl-layer" style="margin-left: 0px"><input type="checkbox" value="KKPRL:Sistem_Jaringan_Energi" style="transform: scale(1.4); margin-right: 6px; color: blue;" checked autocomplete="off" name="czona_15" id="czona_15" value=""><span style="min-width: 50px; background-image: url('/assets/img/mapSystem/icon/jar minyak.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Jaringan Minyak dan Gas Bumi</label>
            <label class="symbology kkprl-layer" style="margin-left: 0px"><input type="checkbox" value="KKPRL:Sistem_Jaringan_Telekomunikasi" style="transform: scale(1.4); margin-right: 6px; color: blue;" checked autocomplete="off" name="czona_16" id="czona_16"><span style="min-width: 50px; background-image: url('/assets/img/mapSystem/icon/jar telekom.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Jaringan Telekomunikasi</label>
            <label class="symbology kkprl-layer" style="margin-left: 0px"><input type="checkbox" value="KKPRL:Alur_Migrasi_Mamalia_Laut" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_17" id="czona_17"><span style="min-width: 50px; background-image: url('/assets/img/mapSystem/icon/mamaliaa.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Alur Migrasi Mamalia Laut</label>
            <label class="symbology kkprl-layer" style="margin-left: 0px"><input type="checkbox" value="KKPRL:Alur_Migrasi_Penyu" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_18" id="czona_18"><span style="min-width: 50px; background-image: url('/assets/img/mapSystem/icon/penyu.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Alur Mingrasi Penyu</label>
            <label class="symbology kkprl-layer" style="margin-left: 0px"><input type="checkbox" value="KKPRL:Alur_Pelayaran_Umum_dan_Perlintasan" style="transform: scale(1.4); margin-right: 6px; color: blue;" checked autocomplete="off" name="czona_19" id="czona_19"><span style="min-width: 50px; background-image: url('/assets/img/mapSystem/icon/pelayaran3.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Alur Pelayaran Umum dan Perlintasan</label>
            <label class="symbology kkprl-layer" style="margin-left: 0px"><input type="checkbox" value="KKPRL:Lintas_Penyeberangan_Antarprovinsi" style="transform: scale(1.4); margin-right: 6px; color: blue;" checked autocomplete="off" name="czona_20" id="czona_20"><span style="min-width: 50px; background-image: url('/assets/img/mapSystem/icon/lintas.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Lintas Penyeberangan Antar Provinsi</label>
            <label class="symbology kkprl-layer" style="margin-left: 0px"><input type="checkbox" value="KKPRL:Lintas_Penyeberangan_Antarkabupaten_Kota_dalam_Provinsi" style="transform: scale(1.4); margin-right: 6px; color: blue;" checked autocomplete="off" name="czona_21" id="czona_21"><span style="min-width: 50px; background-image: url('/assets/img/mapSystem/icon/lintas2.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Lintas Penyeberangan Antar Kabupaten/Kota dalam Provinsi</label>

            <label class="symbology kkprl-layer" style="margin-left: 0px"><input type="checkbox" value="KKPRL:Kawasan_Konservasi_Lainnya" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_0" id="czona_0"><span style="min-width: 50px; background-image: url('/assets/img/mapSystem/icon/konservasi.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Kawasan Konservasi Lainnya</label>
            <label class="symbology kkprl-layer" style="margin-left: 0px"><input type="checkbox" value="KKPRL:Kawasan_Konservasi_Maritim" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_1" id="czona_1"><span style="min-width: 50px; background-image: url('/assets/img/mapSystem/icon/kkm.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Kawasan Konservasi Maritim</label>
            <label class="symbology kkprl-layer" style="margin-left: 0px"><input type="checkbox" value="KKPRL:Pencadangan_Indikasi_Kawasan_Konservasi	" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_2" id="czona_2"><span style="min-width: 50px; background-image: url('/assets/img/mapSystem/icon/konservasi2.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Pencadangan/Indikasi Kawasan Konservasi</label>
            <label class="symbology kkprl-layer" style="margin-left: 0px"><input type="checkbox" value="KKPRL:Taman" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_3" id="czona_3"><span style="min-width: 50px; background-image: url('/assets/img/mapSystem/icon/taman.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Taman</label>
            <label class="symbology kkprl-layer" style="margin-left: 0px"><input type="checkbox" value="KKPRL:Zona_Bandar_Udara" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_4" id="czona_4"><span style="min-width: 50px; background-image: url('/assets/img/mapSystem/icon/bandarudara.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Bandar Udara</label>
            <label class="symbology kkprl-layer" style="margin-left: 0px"><input type="checkbox" value="KKPRL:Zona_Industri" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_5" id="czona_5"><span style="min-width: 50px; background-image: url('/assets/img/mapSystem/icon/industri2.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Industri</label>
            <label class="symbology kkprl-layer" style="margin-left: 0px"><input type="checkbox" value="KKPRL:Zona_Pariwisata" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_6" id="czona_6"><span style="min-width: 50px; background-image: url('/assets/img/mapSystem/icon/wisata.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Pariwisata</label>
            <label class="symbology kkprl-layer" style="margin-left: 0px"><input type="checkbox" value="KKPRL:Zona_Pelabuhan_Perikanan" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_7" id="czona_7"><span style="min-width: 50px; background-image: url('/assets/img/mapSystem/icon/pelabuhan.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Pelabuhan Perikanan</label>
            <label class="symbology kkprl-layer" style="margin-left: 0px"><input type="checkbox" value="KKPRL:Zona_Pelabuhan_Umum" style="transform: scale(1.4); margin-right: 6px; color: blue;" checked autocomplete="off" name="czona_8" id="czona_8"><span style="min-width: 50px; background-image: url('/assets/img/mapSystem/icon/pelabuhan2.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Pelabuhan Umum</label>
            <label class="symbology kkprl-layer" style="margin-left: 0px"><input type="checkbox" value="KKPRL:Zona_Perdagangan_Barang_dan_atau_Jasa" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_9" id="czona_9"><span style="min-width: 50px; background-image: url('/assets/img/mapSystem/icon/dagangan.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Perdagangan Barang dan/atau Jasa</label>
            <label class="symbology kkprl-layer" style="margin-left: 0px"><input type="checkbox" value="KKPRL:Zona_Perikanan_Budi_Daya" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_10" id="czona_10"><span style="min-width: 50px; background-image: url('/assets/img/mapSystem/icon/budidayalaut.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Perikanan Budi Daya</label>
            <label class="symbology kkprl-layer" style="margin-left: 0px"><input type="checkbox" value="KKPRL:Zona_Perikanan_Tangkap" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_11" id="czona_11"><span style="min-width: 50px; background-image: url('/assets/img/mapSystem/icon/tangkap.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Perikanan Tangkap</label>
            <label class="symbology kkprl-layer" style="margin-left: 0px"><input type="checkbox" value="KKPRL:Zona_Permukiman" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_12" id="czona_12"><span style="min-width: 50px; background-image: url('/assets/img/mapSystem/icon/permukiman.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Permukiman</label>
            <label class="symbology kkprl-layer" style="margin-left: 0px"><input type="checkbox" value="KKPRL:Zona_Pertahanan_dan_Keamanan" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_13" id="czona_13"><span style="min-width: 50px; background-image: url('/assets/img/mapSystem/icon/pertahanan.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Pertahanan dan Keamanan</label>
            <label class="symbology kkprl-layer" style="margin-left: 0px"><input type="checkbox" value="KKPRL:Zona_Pertambangan_Minyak_dan_Gas_Bumi" style="transform: scale(1.4); margin-right: 6px; color: blue;" autocomplete="off" name="czona_14" id="czona_14"><span style="min-width: 50px; background-image: url('/assets/img/mapSystem/icon/zona tambangan.png'); ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Zona Pertambangan Minyak dan Gas Bumi</label>
        </div>
    </div>

    <div class="measurement-panel" id="measurementPanel">
        <div class="measurement-panel-header">
            <h6>Measurement Tools</h6>
            <i class="bi bi-x close-btn" id="closeMeasurement"></i>
        </div>
        <div>
            <button class="btn btn-sm btn-outline-primary" id="measureDistance">Measure Distance</button>
            <button class="btn btn-sm btn-outline-primary" id="measureArea">Measure Area</button>
        </div>
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
        })

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

        $(document).ready(function() {
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
        });

        // Catatan: 
        // 1. Pastikan jQuery sudah di-include sebelum script ini
        // 2. Struktur HTML harus memiliki id yang sesuai dengan konfigurasi
        // 3. Gunakan kelas 'show' untuk menampilkan/menyembunyikan panel
    </script>

    <?= $this->renderSection('javascript') ?>

</body>


</html>