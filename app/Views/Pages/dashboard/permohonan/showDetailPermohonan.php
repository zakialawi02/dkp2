<?php $this->extend('Layouts/dashboardTemplate') ?>

<?php $this->section('title') ?>
<?= $title ?? ""; ?> • Dashboard
<?php $this->endSection() ?>

<?php $this->section('og_title') ?>
<?= $title ?? ""; ?> • Dashboard
<?php $this->endSection() ?>

<?php $this->section('css') ?>
<!-- Open Layers Component -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v7.4.0/ol.css">
<link rel="stylesheet" href="https://unpkg.com/ol-layerswitcher@4.1.1/dist/ol-layerswitcher.css" />
<link href=" https://cdn.jsdelivr.net/npm/ol-ext@4.0.11/dist/ol-ext.min.css " rel="stylesheet">

<style>
    #map {
        height: 75vh;
        cursor: grab;
    }

    .layer-switcher .panel {
        font-size: 13px;
    }

    .ol-ext-print-dialog {
        z-index: 10000000;
    }

    .ol-scale-line {
        right: 0;
        left: auto;
        bottom: 2em;
    }

    .ol-control-title {
        height: 2em;
    }

    .ol-print-compass {
        top: 1.5em !important;
    }

    .info_status {
        font-size: small;
        display: block;
    }

    p.boleh {
        font-size: small;
        display: block;
        background-color: #66ff66;
        width: 13rem;
        padding: 0.1rem 0.2rem 0.1rem 0.8rem;
        margin-left: 5px;
        font-weight: 700;
        border-radius: 12px;
    }

    p.bolehBersyarat {
        font-size: small;
        display: block;
        background-color: #ffff66;
        width: 22rem;
        padding: 0.1rem 0.2rem 0.1rem 0.8rem;
        margin-left: 5px;
        font-weight: 700;
        border-radius: 12px;
    }

    p.tidakBoleh {
        font-size: small;
        display: block;
        background-color: #ff6666;
        width: 19rem;
        padding: 0.1rem 0.2rem 0.1rem 0.8rem;
        margin-left: 5px;
        font-weight: 700;
        border-radius: 12px;
    }

    table tbody tr th,
    table tbody tr td {
        align-content: center;
    }
</style>
<?php $this->endSection() ?>


<?php $this->section('content') ?>
<?= $this->include('components/dependencies/_datatables') ?>

<div class="">
    <div class="mb-3">
        <h1 class="fs-3">Data Pengajuan Informasi</h1>
    </div>

    <div class="alert alert-<?= ($tampilDataIzin->stat_appv == 0) ? 'warning' : 'secondary'; ?> d-flex align-items-center" role="alert">
        <div>
            <i class="bi <?= ($tampilDataIzin->stat_appv == 0) ? 'bi-exclamation-triangle' : 'bi-check2-circle'; ?> " style="font-size: x-large;"></i>
            <?= ($tampilDataIzin->stat_appv == 0) ? 'Data Permohanan Informasi Ruang Laut Oleh <u>' . esc($tampilDataIzin->nama) . '</u> <b>Memerlukan Tindakan/Jawaban</b> Oleh Admin' : 'Data Permohanan Informasi Ruang Laut Oleh <u>' . esc($tampilDataIzin->nama) . '</u> <b>Telah Dibalas</b>'; ?>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="p-md-3">
                <h4 class="m-0">STATUS : <span class="badge bg-<?= ($tampilDataIzin->stat_appv == 0) ? 'warning' : (($tampilDataIzin->stat_appv == 1) ? 'success' : 'danger'); ?>"> <?= ($tampilDataIzin->stat_appv == 0) ? 'Menunggu Tindakan...' : (($tampilDataIzin->stat_appv == 1) ? 'Disetujui' : 'Tidak Disetujui'); ?> </span></h4>
                <?php if ($tampilDataIzin->stat_appv != 0) : ?>
                    <p style="font-size: smaller;">Pada: <?= date('d M Y H:i:s', strtotime($tampilDataIzin->date_updated)); ?></p>
                <?php endif ?>
                <?php if ($tampilDataIzin->stat_appv == 1) : ?>
                    <p class="card-text"><a <?= empty($tampilDataIzin->dokumen_lampiran) ?  'href="#" data-bs-toggle="tooltip" data-bs-title="Dokumen Belum Dikirim"' : 'href="/dokumen/lampiran-balasan/' . $tampilDataIzin->dokumen_lampiran . '" data-bs-toggle="tooltip" data-bs-title="Lihat Dokumen" target="_blank"'; ?>><i class="bi bi-file-earmark-pdf-fill" style="color: #6697de;"></i> Lihat Dokumen Balasan</a></p>
                <?php endif ?>
            </div>

            <div class="">
                <table class="table table-responsive">
                    <tbody>
                        <tr>
                            <td style="font-weight: 400; border-bottom-width: 1px; border-bottom-color: #dee2e6;">Nama Pemohon</td>
                            <th style="border-bottom-width: 1px; border-bottom-color: #dee2e6;">:</th>
                            <td style="font-weight: 400; border-bottom-width: 1px; border-bottom-color: #dee2e6;"><?= esc($tampilDataIzin->nama); ?></td>
                        </tr>
                        <tr>
                            <td>NIK (Nomor Induk Kependudukan)</td>
                            <th>:</th>
                            <td><?= (!empty($tampilDataIzin->nik)) ? esc($tampilDataIzin->nik) : '-'; ?></td>
                        </tr>
                        <tr>
                            <td>NIB (Nomor Izin Berusaha)</td>
                            <th>:</th>
                            <td><?= (!empty($tampilDataIzin->nib)) ? esc($tampilDataIzin->nib) : '-'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <th>:</th>
                            <td><?= (!empty($tampilDataIzin->alamat)) ? esc($tampilDataIzin->alamat) : '-'; ?></td>
                        </tr>
                        <tr>
                            <td>Kontak</td>
                            <th>:</th>
                            <td><?= (!empty($tampilDataIzin->kontak)) ? esc($tampilDataIzin->kontak) : '-'; ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Kegiatan</td>
                            <th>:</th>
                            <td><?= esc($tampilDataIzin->nama_kegiatan); ?></td>
                        </tr>
                        <tr>
                            <td>Wilayah Kegiatan</td>
                            <th>:</th>
                            <td>
                                <?php
                                if (!empty($tampilDataIzin->id_zona)) {
                                    $zoneName = explode(",", $tampilDataIzin->id_zona);
                                    $zoneName = array_unique($zoneName);
                                    foreach ($tampilZona as $value) {
                                        if (in_array($value->id_zona, $zoneName)) {
                                            echo "<span>" . esc($value->nama_zona) . "</span>"  . "<br>";
                                        }
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <?php if (!in_groups('User')) : ?>
                            <tr>
                                <td>Kesesuaian Kegiatan</td>
                                <th>:</th>
                                <td>
                                    <div class="info_status">
                                        <div class="info_status" id="showKegiatan">
                                            <div id="showKeteranganKegiatan" class="feedback mb-0 pb-0 fs-6"><?= $tampilDataIzin->hasilStatus ?? ""; ?></div>
                                            <button type="button" id="cekKesesuaian" class="btn btn-sm btn-primary bi bi-search-heart"> Cek kesesuaian terbaru</button>
                                            <button class="asbn btn btn-primary d-none" id="loadCekKesesuaian" type="button" disabled>
                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                Loading...
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endif ?>
                        <tr>
                            <td>Tanggal Pengajuan</td>
                            <th>:</th>
                            <td><?= date('d M Y H:i:s', strtotime($tampilDataIzin->created_at)); ?></td>
                        </tr>
                        <tr>
                            <td>Berkas</td>
                            <th>:</th>
                            <td>
                                <?php if ($tampilDataIzin->uploadFiles != null) : ?>
                                    <?php foreach ($tampilDataIzin->uploadFiles as $file) : ?>
                                        <div class="card mb-3 flex-grow-1 border border-dark">
                                            <div class="card-body py-2 d-flex justify-content-between gap-2">
                                                <p class="card-text m-0 p-0"><a href="/dokumen/upload-dokumen/<?= $file->uploadFiles; ?>" target="_blank"><?= $file->uploadFiles; ?></a></p>
                                                <div class=""><a href="/dokumen/upload-dokumen/<?= $file->uploadFiles; ?>" target="_blank" class="btn btn-sm btn-primary bi bi-download"></a></div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <p class="form-text">Tidak ada berkas</p>
                                <?php endif ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

    </div>

    <div class="card mb-2 p-2">
        <div class="map" id="map"></div>
        <span id="coordinates"></span>
    </div>

    <div class="card ambilTindakanJawaban">
        <div class="card-body d-flex justify-content-end py-3">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Ambil Tindakan
            </button>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Ambil Tindakan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">✕</button>
                    </div>
                    <div class="modal-body">

                        <form action="<?= route_to('admin.permohonan.kirimTindakan', $tampilDataIzin->id_perizinan); ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>

                            <div class="form-check mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="reject" class="reject" value="2" <?= $tampilDataIzin->stat_appv == 2 ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="reject">
                                        Tidak Disetujui
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="approve" class="approve" value="1" <?= $tampilDataIzin->stat_appv == 1 ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="approve">
                                        Disetujui
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3" id="lampiran" style="display: none;">
                                <label for="formFile" class="form-label">Lampirkan Dokumen</label>
                                <input class="form-control" name="lampiranFile" type="file" id="lampiranFile">
                            </div>
                            <div class="mt-3 gap-2 d-flex justify-content-end ">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Kiriman</button>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php $this->endSection() ?>


<?php $this->section('javascript') ?>
<script>
    <?php if (in_groups('User')) : ?>
        $('.ambilTindakanJawaban').remove('.ambilTindakanJawaban');
    <?php endif ?>
    <?php if (!empty($tampilDataIzin->dokumen_lampiran)) : ?>
        $('.ambilTindakanJawaban').remove('.ambilTindakanJawaban');
    <?php endif ?>
</script>
<script>
    <?php if ($tampilDataIzin->stat_appv != 0) : ?>
        $('#lampiran').show();
    <?php else : ?>
        $('#approve').click(function(e) {
            $('#lampiran').show();
        });

        $('#reject').click(function(e) {
            $('#lampiran').hide();
        });
    <?php endif ?>
</script>

<!-- Open Layers Component -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.5.0/proj4.js"></script>
<script src="https://cdn.jsdelivr.net/npm/ol@v7.4.0/dist/ol.js"></script>
<script src="https://cdn.jsdelivr.net/npm/elm-pep@1.0.6/dist/elm-pep.js"></script>
<script src="https://unpkg.com/ol-layerswitcher@4.1.1"></script>
<script src="https://api.tiles.mapbox.com/mapbox.js/plugins/turf/v2.0.0/turf.min.js"></script>
<!-- <script src="/assets/js/catiline.js"></script> -->
<script src="https://unpkg.com/shpjs@latest/dist/shp.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Turf.js/0.0.124/turf.min.js" integrity="sha512-jpnZ8xGKbS7L9S6d5fk/zDVgF6OoVKLMoEliLxf24BRX+orWhxqJuUcoM+vGmOaozS9dD9ABjQZKAgjjcwTndA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Open Layers Component -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src=" https://cdn.jsdelivr.net/npm/ol-ext@4.0.11/dist/ol-ext.min.js "></script>
<script src="/assets/js/catiline.js"></script>
<script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL,Object.assign"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/eligrey/FileSaver.js/aa9f4e0e/FileSaver.min.js"></script>
<script src="/assets/js/write-shp.js"></script> -->

<script>
    $(document).ready(function() {
        let Map = ol.Map;
        let View = ol.View;
        let OSM = ol.source.OSM;
        let TileLayer = ol.layer.Tile;
        let TileSource = ol.source.Tile;
        let Layer = ol.layer.WebGLTile;
        let Source = ol.source.ImageTile;
        let {
            fromLonLat,
            toLonLat,
            Projection,
            useGeographic,
            getProjection,
            getTransform,
            addCoordinateTransforms,
            addProjection,
            transform,
        } = ol.proj;
        let VectorLayer = ol.layer.Vector;
        let VectorSource = ol.source.Vector;
        let LayerGroup = ol.layer.Group;
        let Overlay = ol.Overlay;
        let TileWMS = ol.source.TileWMS;
        let {
            GeoJSON,
            KML
        } = ol.format;
        let Feature = ol.Feature;
        let {
            Point,
            Circle,
            LineString,
            Polygon
        } = ol.geom;
        let {
            Circle: CircleStyle,
            Style,
            Fill,
            Stroke,
            Text,
            IconImage,
            RegularShape,
            Icon,
        } = ol.style;
        let {
            Attribution,
            OverviewMap,
            ScaleLine,
            MousePosition
        } = ol.control;
        let {
            register
        } = ol.proj.proj4;
        let {
            format,
            toStringHDMS,
            toStringXY
        } = ol.coordinate;
        let {
            Draw,
            Modify
        } = ol.interaction;
        let {
            getArea,
            getLength
        } = ol.sphere;
        let {
            unByKey
        } = ol.Observable;

        // Daftarkan proyeksi jika SHP menggunakan proyeksi selain EPSG: 4326
        proj4.defs("EPSG:4326", "+proj=longlat +datum=WGS84 +no_defs"); // Jika EPSG:4326
        proj4.defs("EPSG:3857", "+proj=merc +lon_0=0 +k=1 +x_0=0 +y_0=0 +datum=WGS84 +units=m +no_defs"); // EPSG:3857
        proj4.defs("EPSG:3975", "+proj=cea +R_A +lat_ts=30 +lon_0=0 +x_0=0 +y_0=0 +datum=WGS84 +units=m +no_defs +type=crs");
        proj4.defs("ESRI:54030", "+proj=robin +lon_0=0 +x_0=0 +y_0=0 +datum=WGS84 +units=m +no_defs +type=crs");
        proj4.defs("ESRI:53034", "+proj=cea +lat_ts=0 +lon_0=0 +x_0=0 +y_0=0 +R=6371000 +units=m +no_defs +type=crs");
        proj4.defs("ESRI:54034", "+proj=cea +lat_ts=0 +lon_0=0 +x_0=0 +y_0=0 +datum=WGS84 +units=m +no_defs +type=crs");
        register(proj4); // Daftarkan ke OpenLayers


        let WGS84 = new Projection("EPSG:4326");
        let MERCATOR = new Projection("EPSG:3857");
        let UTM49S = new Projection("EPSG:32649");

        <?php
        list($lon, $lat) = explode(', ', $tampilData->coordinat_wilayah);
        $zoomView = $tampilData->zoom_view;
        ?>

        // GeoJSON Data
        let GEOJSON = <?= $tampilDataIzin->lokasi; ?>;

        // Style Vector Geometry
        const markerStyle = new ol.style.Style({
            image: new ol.style.Icon({
                anchor: [0.5, 1],
                anchorXUnits: 'fraction',
                anchorYUnits: 'fraction',
                opacity: 1,
                src: '/mapSystem/images/marker-icon.png',
                scale: 0.8
            })
        });

        const lineStyle = new ol.style.Style({
            stroke: new ol.style.Stroke({
                color: 'red',
                width: 2
            })
        });

        const polygonStyle = new ol.style.Style({
            fill: new ol.style.Fill({
                color: 'rgba(210, 0, 0, 0.4)'
            }),
            stroke: new ol.style.Stroke({
                color: 'red',
                width: 2
            })
        });

        // Style Vector Geometry Eksisting
        const markerStyleEks = new ol.style.Style({
            image: new ol.style.Icon({
                anchor: [0.5, 1],
                anchorXUnits: 'fraction',
                anchorYUnits: 'fraction',
                opacity: 1,
                src: '/mapSystem/images/marker-icon2.png',
                scale: 0.8
            })
        });

        const lineStyleEks = new ol.style.Style({
            stroke: new ol.style.Stroke({
                color: 'rgba(255, 191, 0)',
                width: 2
            })
        });

        const polygonStyleEks = new ol.style.Style({
            fill: new ol.style.Fill({
                color: 'rgba(255, 191, 0, 0.7)'
            }),
            stroke: new ol.style.Stroke({
                color: 'rgba(255, 191, 0)',
                width: 2
            })
        });

        // Tentukan Style Berdasarkan Geometry Type
        let geometryType = GEOJSON.features[0].geometry.type;
        let styleDraw = markerStyle;

        if (geometryType === 'Polygon') {
            styleDraw = polygonStyle;
        } else if (geometryType !== 'Point') {
            styleDraw = lineStyle;
        }

        // Vector Source & Layer
        const vectorSource = new ol.source.Vector({
            features: new ol.format.GeoJSON().readFeatures(GEOJSON, {
                featureProjection: 'EPSG:3857'
            })
        });

        const vectorLayer = new ol.layer.Vector({
            source: vectorSource,
            style: styleDraw,
            name: 'Data Pemohon',
            zIndex: 5
        });

        // Projection Custom
        const projection = new ol.proj.Projection({
            code: 'EPSG:54034',
            units: 'm',
            axisOrientation: 'neu'
        });

        // Base Maps
        const osmBaseMap = new ol.layer.Tile({
            title: 'Open Street Map',
            type: 'base',
            source: new ol.source.OSM(),
            crossOrigin: 'anonymous',
            visible: true
        });

        const bingAerialBaseMap = new ol.layer.Tile({
            title: 'Bing Aerial',
            type: 'base',
            preload: Infinity,
            source: new ol.source.BingMaps({
                key: 'AjQ2yJ1-i-j_WMmtyTrjaZz-3WdMb2Leh_mxe9-YBNKk_mz1cjRC7-8ILM7WUVEu',
                imagerySet: 'AerialWithLabels',
                maxZoom: 20
            }),
            crossOrigin: 'anonymous',
            visible: false
        });

        const mapboxBaseMap = new ol.layer.Tile({
            title: 'MapBox Road',
            type: 'base',
            visible: false,
            source: new ol.source.XYZ({
                url: 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiNjg2MzUzMyIsImEiOiJjbDh4NDExZW0wMXZsM3ZwODR1eDB0ajY0In0.6jHWxwN6YfLftuCFHaa1zw'.replace('{id}', 'mapbox/streets-v11')
            }),
            crossOrigin: 'anonymous'
        });

        // Group Base Maps
        const baseMaps = new ol.layer.Group({
            title: 'Base Map',
            openInLayerSwitcher: true,
            layers: [osmBaseMap, bingAerialBaseMap, mapboxBaseMap]
        });

        // Overlay Layers
        const overlays = new ol.layer.Group({
            title: 'Data Pemohon',
            layers: [vectorLayer]
        });

        // View
        const view = new ol.View({
            center: ol.proj.fromLonLat([<?= $lat; ?>, <?= $lon; ?>]),
            zoom: <?= $zoomView; ?>,
            Projection: projection
        });

        // Map Initialization
        const map = new ol.Map({
            target: 'map',
            layers: [baseMaps, overlays],
            controls: [
                //Define the default controls
                new ol.control.Zoom(),
                new ol.control.Attribution(),
                //Define some new controls
                new ol.control.ScaleLine(),
            ],
            view: view
        });

        // Fit View ke GeoJSON Extent
        const extent = vectorLayer.getSource().getExtent();
        map.getView().fit(extent, {
            padding: [100, 100, 100, 100],
            minResolution: map.getView().getResolutionForZoom(16),
            duration: 1500
        });

        // Layer Switcher
        const layerSwitcher = new ol.control.LayerSwitcher({
            tipLabel: 'Legend',
            groupSelectStyle: 'children'
        });
        map.addControl(layerSwitcher);



        // Parameter GeoServer RES/REQ KKPRL RTRW
        const GEOSERVER_URL = "<?= $_ENV['BASE_URL_GEOSERVER'] ?>";
        const WORKSPACE = "KKPRL";
        const LAYER_NAME = "KKPRL_RTRW_KALTIM_JOINTABLEWITH_RZWP";
        let INTERSECT_RESULT, INTERSECT_RESULT_PROPERTIES, INTERSECT_RESULT_PROPERTIES_UNIQUE;

        $("#cekKesesuaian").click(function(e) {
            cekKesesuaian();
            $("#cekKesesuaian").addClass("d-none");
            $("#loadCekKesesuaian").removeClass("d-none");
        });

        function cekKesesuaian() {
            checkIntersectionWithGeoServer(GEOJSON, GEOSERVER_URL, WORKSPACE, LAYER_NAME)
                .then(hasIntersection => {
                    if (hasIntersection) {
                        console.log("Ada fitur yang tumpang tindih di GeoServer!");
                    } else {
                        console.log("Tidak ada fitur yang tumpang tindih.");
                    }
                });
        }

        /**
         * Check if the GeoJSON data intersects with data in the given GeoServer layer
         * 
         * This function takes GeoJSON data, GeoServer URL, workspace and layer name as input.
         * It will return a boolean value indicating whether there is an intersection or not.
         * If there is an intersection, the intersecting features will be stored in the global
         * variable INTERSECT_RESULT and their properties will be stored in the global variable
         * INTERSECT_RESULT_PROPERTIES.
         * 
         * @param {Object} GEOJSON_DATA The GeoJSON data to check for intersection
         * @param {string} GEOSERVER_URL The URL of the GeoServer instance
         * @param {string} WORKSPACE The workspace name in GeoServer
         * @param {string} LAYER_NAME The layer name in GeoServer
         * @return {Promise.<boolean>} A promise resolving to a boolean indicating whether there is an intersection or not
         */
        function checkIntersectionWithGeoServer(GEOJSON_DATA, GEOSERVER_URL, WORKSPACE, LAYER_NAME) {
            $(".zona").html(loaderSpinner);
            $(".kawasan").html(loaderSpinner);
            $(".kode").html(loaderSpinner);

            // Konversi GeoJSON Geometry ke WKT tanpa Z
            function geojsonToWKT(geometry) {
                let wkt = "";

                // Fungsi untuk membersihkan koordinat (menghapus nilai Z)
                function cleanCoordinates(coords) {
                    return coords.map(coord => coord.slice(0, 2)); // Ambil hanya [X, Y]
                }

                // Fungsi untuk memastikan polygon tertutup
                function closePolygon(coords) {
                    // Periksa apakah titik pertama dan terakhir sama
                    if (coords[0][0] !== coords[coords.length - 1][0] || coords[0][1] !== coords[coords.length - 1][1]) {
                        // Jika tidak, tambahkan koordinat pertama ke akhir
                        coords.push(coords[0]);
                    }
                    return coords;
                }

                switch (geometry.type) {
                    case "Point":
                        let pointCoords = cleanCoordinates([geometry.coordinates]); // Pastikan format array
                        wkt = `POINT(${pointCoords[0].join(" ")})`;
                        break;

                    case "LineString":
                        let lineCoords = cleanCoordinates(geometry.coordinates);
                        wkt = `LINESTRING(${lineCoords.map(coord => coord.join(" ")).join(", ")})`;
                        break;

                    case "Polygon":
                        let polygonCoords = cleanCoordinates(geometry.coordinates[0]); // Ambil ring luar saja
                        polygonCoords = closePolygon(polygonCoords); // Pastikan polygon tertutup
                        wkt = `POLYGON((${polygonCoords.map(coord => coord.join(" ")).join(", ")}))`;
                        break;

                    default:
                        console.error("Unsupported GeoJSON type:", geometry.type);
                        return null;
                }
                return wkt;
            }

            INTERSECT_RESULT = [];
            INTERSECT_RESULT_PROPERTIES = [];

            // Buat CQL Filter INTERSECTS untuk semua fitur di GeoJSON
            let wktArray = GEOJSON_DATA.features.map(feature => {
                let wkt = geojsonToWKT(feature.geometry);
                return wkt ? `INTERSECTS(the_geom, ${wkt})` : null;
            }).filter(wkt => wkt !== null); // Hapus jika ada nilai null

            let cqlFilter = wktArray.join(" OR ");
            let encodedFilter = encodeURIComponent(cqlFilter);

            // Buat URL WFS dengan CQL Filter
            let wfsUrl = `${GEOSERVER_URL}/wfs?` +
                `service=WFS&version=1.0.0&request=GetFeature&` +
                `typeName=${WORKSPACE}:${LAYER_NAME}&` +
                `outputFormat=application/json&srsname=EPSG:4326&` +
                `cql_filter=${encodedFilter}`;

            // Fetch data dari GeoServer
            return fetch(wfsUrl)
                .then(response => response.json())
                .then(data => {
                    // console.log(data);
                    if (data?.features?.length > 0) {
                        console.log("Terdapat tumpang tindih:", data?.features);
                        INTERSECT_RESULT.push(data?.features);
                        let properties = extractFeatureProperties(data?.features);
                        INTERSECT_RESULT_PROPERTIES.push(properties);
                        displayResultPropertiesInTable(properties);
                        console.log(INTERSECT_RESULT_PROPERTIES_UNIQUE);
                        return true;
                    } else {
                        console.log("Tidak ada tumpang tindih.");
                        let properties = extractFeatureProperties(data?.features);
                        displayResultPropertiesInTable(properties);
                        return false;
                    }
                }).then((res) => {
                    if (res) {
                        // Jika ada tumpang tindih, panggil fungsi cek() untuk memproses hasilnya
                        cek();
                    } else {
                        $("#showKeteranganKegiatan").html('<p class="">Diluar Zona KKPRL Kalimantan Timur</p>');
                    }
                }).finally(() => {
                    // Menghilangkan loader spinner setelah mendapatkan hasil
                    $("#loadCekKesesuaian").addClass("d-none");
                    $("#cekKesesuaian").removeClass("d-none");
                })
                .catch(error => {
                    console.error("Error fetching WFS:", error);
                    // Menghilangkan loader spinner jika terjadi error
                    $("#loadCekKesesuaian").addClass("d-none");
                    $("#cekKesesuaian").removeClass("d-none");
                });
        }

        /**
         * Extracts properties from a GeoJSON feature array
         * 
         * This function takes an array of GeoJSON features and extracts the properties
         * KODKWS, JNSRPR and NAMOBJ from each feature. If any of the properties are
         * not present in a feature, the function will insert a null value in its place.
         * 
         * @param {Object[]} geojsonResponse The array of GeoJSON features
         * @return {Object[]} An array of objects containing the extracted properties
         */
        function extractFeatureProperties(geojsonResponse) {
            if (!Array.isArray(geojsonResponse)) {
                console.error("Input harus berupa array GeoJSON features.");
                return [];
            }

            return geojsonResponse.map(feature => {
                return {
                    OBJECTID: feature.properties?.OBJECTID || null,
                    KODKWS: feature.properties?.KODKWS || null,
                    SUBZONA: feature.properties?.SUBZONA || null,
                    JNSRPR: feature.properties?.JNSRPR || null,
                    NAMOBJ: feature.properties?.NAMOBJ || null
                };
            });
        }

        /**
         * Clean and store the intersection result data
         * 
         * This function takes the intersection result data, removes duplicates and stores it in a new variable.
         * The cleaned data is then returned and also stored in a global variable.
         * 
         * @param {Object[]} data The intersection result data
         * @return {Object} The cleaned data
         */
        function cleanUniqueAndStoreData(data) {
            console.log("data");
            console.log(data);

            INTERSECT_RESULT_PROPERTIES_UNIQUE = [];
            // Fungsi untuk menghilangkan duplikat
            function removeDuplicates(arr) {
                return [...new Set(arr)];
            }

            // Simpan hasil yang sudah dihapus duplikatnya ke dalam variabel baru
            let uniqueObjectIds = removeDuplicates(data.map(item => item.OBJECTID));
            let uniqueZones = removeDuplicates(data.map(item => item.NAMOBJ));
            let uniqueSubZones = removeDuplicates(data.map(item => item.SUBZONA2));
            let uniqueKawasan = removeDuplicates(data.map(item => item.JNSRPR));
            let uniqueCodes = removeDuplicates(data.map(item => item.KODKWS));

            // Simpan ke dalam variabel yang bisa digunakan di luar function
            let cleanedData = {
                objectId: uniqueObjectIds,
                zones: uniqueZones,
                subZones: uniqueSubZones,
                codes: uniqueCodes,
                kawasan: uniqueKawasan,
            };
            INTERSECT_RESULT_PROPERTIES_UNIQUE.push(cleanedData);
            return cleanedData;
        }

        /**
         * Displays the result properties in a table
         * @param {Object[]} data Object containing the result properties
         */
        function displayResultPropertiesInTable(data) {
            let cleanedData = cleanUniqueAndStoreData(data);
        }

        const isLoggedIn = <?= logged_in() ? 'true' : 'false' ?>;

        function cek() {
            console.log("cek");
            // console.log(INTERSECT_RESULT);
            // console.log(INTERSECT_RESULT_PROPERTIES);
            // console.log(INTERSECT_RESULT_PROPERTIES_UNIQUE);
            let csrfToken = $('input[name="csrf_test_name"]').val();
            let valKegiatan = <?= $tampilDataIzin->id_kegiatan; ?>;
            let getOverlapProperties = JSON.stringify(INTERSECT_RESULT_PROPERTIES[0]);

            $.ajax({
                method: "POST",
                url: "/data/cekStatus",
                data: {
                    csrf_test_name: csrfToken,
                    valKegiatan: valKegiatan,
                    getOverlapProperties: getOverlapProperties
                },
                dataType: "json",
                beforeSend: function() {
                    $('#lanjutKirim').prop('disabled', true);
                    $('#showKeteranganKegiatan').html(loaderSpinner);
                },
                success: function(response) {
                    // console.log(response);
                    const hasil = response.hasil;
                    const valZona = response.valZona;
                    let hasilStatus = "";
                    $("#idZona").val(valZona);
                    if (hasil.length !== 0) {
                        const diperbolehkan = hasil.filter(item => item.status === 'diperbolehkan');
                        const diperbolehkanBersyarat = hasil.filter(item => item.status === 'diperbolehkan bersyarat');
                        const tidakDiperbolehkan = hasil.filter(item => item.status === 'tidak diperbolehkan');
                        if (tidakDiperbolehkan.length !== 0) {
                            $('#lanjutKirim').prop('disabled', !isLoggedIn);
                            $("#showKeteranganKegiatan").html('<p class="tidakBoleh">Aktivitas yang tidak diperbolehkan</p>');
                            hasilStatus = "tidak diperbolehkan";
                        } else if (diperbolehkanBersyarat.length !== 0) {
                            $('#lanjutKirim').prop('disabled', !isLoggedIn);
                            $("#showKeteranganKegiatan").html('<p class="bolehBersyarat">Aktivitas diperbolehkan setelah memperoleh izin</p>');
                            hasilStatus = "diperbolehkan bersyarat";
                        } else {
                            $('#lanjutKirim').prop('disabled', !isLoggedIn);
                            $("#showKeteranganKegiatan").html('<p class="boleh">Aktivitas yang diperbolehkan</p>');
                            hasilStatus = "diperbolehkan";
                        }
                    } else {
                        if (valZona.length === 0 || valZona === null) {
                            $('#lanjutKirim').prop('disabled', !isLoggedIn);
                            $("#showKeteranganKegiatan").html('<p class="">Diluar Zona KKPRL Kalimantan Timur</p>');
                            hasilStatus = "Diluar Zona KKPRL Kalimantan Timur";
                        } else {
                            $('#lanjutKirim').prop('disabled', !isLoggedIn);
                            $("#showKeteranganKegiatan").html('<p class="">No Data</p>');
                            hasilStatus = "No Data";
                        }
                    }

                    $("#hasilStatus").val(hasilStatus);
                },
                error: function(error) {
                    console.error("Error:", error);
                    $('#showKeteranganKegiatan').html('-');
                },
                complete: function(response) {
                    $('#lanjutKirim').prop('disabled', false);
                    updateCSRFToken(response);
                }

            });
        }
    });
</script>
<?php $this->endSection() ?>