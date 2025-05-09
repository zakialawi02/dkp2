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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />

<!-- Open Layers Component -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v7.4.0/ol.css">

<link rel="stylesheet" href="<?= base_url('assets/css/map.css'); ?>">

<style>
    #map {
        height: 60vh;
    }
</style>
<?php $this->endSection() ?>

<?php $this->section('content') ?>

<section class="px-2 py-3">
    <div class="container">
        <h2>Lengkapi Data Pengajuan Informasi</h2>

        <div class="row g-2">
            <div class="col col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <form id="form-ajuan" class="row g-3" action="/data/tambahAjuan" method="post" enctype="multipart/form-data" autocomplete="off">

                            <?= csrf_field(); ?>
                            <?php
                            $datas = $ajuanData ?? NULL;
                            $geojson = json_decode($datas['geojson'] ?? '');
                            $getOverlap = json_decode($datas['getOverlap'] ?? '[]');
                            $overlapProperties = json_decode($ajuanData['getOverlapProperties'] ?? '[]', true)[0] ?? [];
                            $valZona = old('idZona', $datas['valZona'] ?? null);
                            $hasil  =  $datas['hasilStatus'] ?? NULL;
                            $valKegiatan = old('idKegiatan', $datas['kegiatanValue'] ?? null);
                            if (!empty($valZona)) {
                                $valZonaArray = explode(',', $valZona);
                                $valZonaUnique = array_unique($valZonaArray);
                                $valZonaString = implode(',', $valZonaUnique);
                            }
                            if (!empty($overlapProperties['codes'] ?? [])) {
                                $codeKawasanArray = $overlapProperties['codes'];
                                $codeKawasanString = implode(',', $codeKawasanArray);
                            }
                            ?>


                            <input type="hidden" class="form-control" id="hasilStatus" aria-describedby="textlHelp" name="hasilStatus" value="">
                            <input type="hidden" class="form-control" id="kawasan" aria-describedby="textlHelp" name="kawasan" value="">
                            <input type="hidden" class="form-control" id="idZona" aria-describedby="textlHelp" name="idZona" value="">
                            <input type="hidden" class="form-control" id="idKegiatan" aria-describedby="textlHelp" name="idKegiatan" value="">
                            <input type="hidden" class="form-control" id="drawFeatures" aria-describedby="textlHelp" name="drawFeatures">

                            <h5>a. Identitas Pemohon</h5>

                            <p class="m-0 p-0"><span style="color: red;">*</span> <span class="form-text">Wajib di isi</span> </p>
                            <div class="form-group">
                                <label class="form-label">NIB (Nomor Induk Berusaha)</label>
                                <input type="text" class="form-control" id="nib" aria-describedby="textlHelp" name="nib" maxlength="14" pattern="[0-9]*" title="Format berupa angka" value="<?= old('nib'); ?>">
                                <?php if (session()->has('errors')) : ?>
                                    <span class="text-danger"><?= session('errors.nib') ?></span>
                                <?php endif ?>
                            </div>
                            <div class="form-group">
                                <label class="form-label">NIK (Nomor Induk Kependudukan) <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="nik" aria-describedby="textlHelp" name="nik" maxlength="16" pattern="[0-9]*" title="Format berupa angka" value="<?= old('nik'); ?>" required>
                                <?php if (session()->has('errors')) : ?>
                                    <span class="text-danger"><?= session('errors.nik') ?></span>
                                <?php endif ?>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nama <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="nama" aria-describedby="textlHelp" name="nama" value="<?= old('nama'); ?>" required>
                                <?php if (session()->has('errors')) : ?>
                                    <span class="text-danger"><?= session('errors.nama') ?></span>
                                <?php endif ?>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Alamat <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="alamat" aria-describedby="textlHelp" name="alamat" value="<?= old('alamat'); ?>" required>
                                <?php if (session()->has('errors')) : ?>
                                    <span class="text-danger"><?= session('errors.alamat') ?></span>
                                <?php endif ?>
                            </div>
                            <div class="form-group">
                                <label class="form-label">No. Telp/HP <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="kontak" aria-describedby="textlHelp" name="kontak" pattern="^\+?[0-9]+$" title="Format No. Telp/HP tidak sesuai" maxlength="15" value="<?= old('kontak'); ?>" required>
                                <?php if (session()->has('errors')) : ?>
                                    <span class="text-danger"><?= session('errors.kontak') ?></span>
                                <?php endif ?>
                            </div>
                            <div class="mb-1"></div>

                            <h5>b. Pengajuan Informasi Ruang Laut</h5>

                            <div class="form-group">
                                <label class="col-md-12 mb-2">Jenis Kegiatan <span style="color: red;">*</span></label>
                                <select class="form-select" id="pilihKegiatan" name="kegiatan" style="width: 100%;" required disabled>
                                    <option></option>
                                    <?php foreach ($jenisKegiatan as $K) : ?>
                                        <option value=" <?= $K->id_kegiatan ?>" <?= $K->id_kegiatan == $ajuanData['kegiatanValue'] ? 'selected' : '' ?>><?= $K->nama_kegiatan ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12 mb-2" for="SubZona">Zona</label>
                                <?php
                                if (!empty($overlapProperties ?? [])) {
                                    // dd($overlapProperties['zones']);
                                    foreach ($overlapProperties['zones'] as $row) {
                                        echo "<span>" . $row . "</span>"  . "<br>";
                                    }
                                } else {
                                    echo "<span>-</span>";
                                }
                                ?>
                            </div>

                            <div class="feedback">Keterangan Kesesuaian:</div>
                            <div class="info_status">
                                <div class="info_status" id="showKegiatan"> - </div>
                            </div>


                            <h5>c. Upload Berkas</h5>

                            <input type="file" class="filepond" name="filepond[]" multiple />

                            <button type="submit" class="btn btn-primary" onclick="kirim()">Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <div class="map" id="map"></div>
                        <div class="d-none d-lg-block" id="mousePosition"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->endSection() ?>

<?php $this->section('javascript') ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

<!-- Open Layers Component -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.5.0/proj4.js"></script>
<script src="https://cdn.jsdelivr.net/npm/ol@v7.4.0/dist/ol.js"></script>
<script src="https://cdn.jsdelivr.net/npm/elm-pep@1.0.6/dist/elm-pep.js"></script>

<script>
    $(document).ready(function() {
        $('#pilihKegiatan').select2({
            placeholder: "Pilih Jenis Kegiatan",
            allowClear: true
        });

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

        let geojson = <?= $ajuanData['geojson'] ?? []; ?>;
        console.log(geojson);
        if (Array.isArray(geojson)) {
            geojson = geojson[0];
        }

        let WGS84 = new Projection("EPSG:4326");
        let MERCATOR = new Projection("EPSG:3857");
        let UTM49S = new Projection("EPSG:32649");

        <?php
        list($lon, $lat) = explode(', ', $tampilData->coordinat_wilayah);
        $zoomView = $tampilData->zoom_view;
        ?>

        // style vector geometry
        const markerStyle = new ol.style.Style({
            image: new ol.style.Icon({
                anchor: [0.5, 1],
                anchorXUnits: 'fraction',
                anchorYUnits: 'fraction',
                opacity: 1,
                src: '/mapSystem/images/marker-icon.png'
            })
        });
        const lineStyle = new ol.style.Style({
            stroke: new ol.style.Stroke({
                color: 'red',
                width: 2,
            }),
        });
        const polygonStyle = new ol.style.Style({
            fill: new ol.style.Fill({
                color: 'rgba(210, 0, 0, 0.4)',
            }),
            stroke: new ol.style.Stroke({
                color: 'red',
                width: 2,
            }),
        });

        // Buat source vector dari geojson
        const vectorSource = new ol.source.Vector({
            features: new ol.format.GeoJSON().readFeatures(geojson, {
                featureProjection: 'EPSG:3857' // pastikan pakai projection yang sesuai sama peta
            })
        });

        // Buat layer vector
        const vectorLayer = new ol.layer.Vector({
            source: vectorSource,
            style: function(feature) {
                const geomType = feature.getGeometry().getType();
                if (geomType === 'Polygon') {
                    return polygonStyle;
                } else if (geomType === 'LineString') {
                    return lineStyle;
                } else if (geomType === 'Point') {
                    return markerStyle;
                }
            }
        });

        // Init View
        const view = new View({
            // projection: "EPSG:4326",
            center: fromLonLat([<?= $lat; ?>, <?= $lon; ?>]),
            zoom: 8,
        });

        // BaseMap
        const osmBaseMap = new TileLayer({
            source: new OSM(),
            crossOrigin: "anonymous",
            visible: false,
            preload: 15,
        });

        const sourceBingMaps = new ol.source.BingMaps({
            key: "AjQ2yJ1-i-j_WMmtyTrjaZz-3WdMb2Leh_mxe9-YBNKk_mz1cjRC7-8ILM7WUVEu",
            imagerySet: "AerialWithLabels",
            maxZoom: 20,
        });
        const bingAerialBaseMap = new ol.layer.Tile({
            preload: Infinity,
            source: sourceBingMaps,
            crossOrigin: "anonymous",
            visible: true,
        });

        const mapboxBaseURL =
            "https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiNjg2MzUzMyIsImEiOiJjbDh4NDExZW0wMXZsM3ZwODR1eDB0ajY0In0.6jHWxwN6YfLftuCFHaa1zw";
        const mapboxStyleId = "mapbox/streets-v11";
        const mapboxSource = new ol.source.XYZ({
            url: mapboxBaseURL.replace("{id}", mapboxStyleId),
        });
        const mapboxBaseMap = new ol.layer.Tile({
            source: mapboxSource,
            crossOrigin: "anonymous",
            visible: false,
            preload: 15,
        });

        const baseMaps = [osmBaseMap, bingAerialBaseMap, mapboxBaseMap];

        // Attribution
        const attribution = new Attribution({
            target: document.getElementById("attribution"),
            collapsible: true,
            className: "ol-attribution",
        });

        // ScaleLine
        const scaleControl = new ScaleLine({
            target: document.getElementById("scaleline"),
            units: "metric",
            bar: true,
            steps: 4,
            text: true,
            minWidth: 140,
            maxWidth: 180,
            className: "ol-scale-line",
        });

        // zoom
        const zoomControl = new ol.control.Zoom({
            target: document.getElementById("zoomToggle"),
            className: "ol-custom-zoom",
            zoomInClassName: "btn ol-custom-zoom-in",
            zoomOutClassName: "btn ol-custom-zoom-out",
            zoomInLabel: "",
            zoomOutLabel: "",
        });

        // Mouse Position
        const mousePositionControl = new MousePosition({
            target: document.getElementById("mousePosition"),
            coordinateFormat: function(coordinate) {
                const {
                    formattedLon,
                    formattedLat
                } = coordinateFormatIndo(
                    coordinate,
                    "dd"
                );

                return (
                    "Long: " + formattedLon + " &nbsp&nbsp&nbsp  Lat: " + formattedLat
                );
            },
            projection: "EPSG:4326",
            placeholder: "Long: - &nbsp&nbsp&nbsp  Lat: -",
            className: "ol-custom-mouse-position",
        });

        /**
         * Formats the given coordinate into a specific format for Indo coordinates.
         *
         * @param {Array<number>} coordinate - The coordinate to be formatted. It should be an array with two elements: [longitude, latitude].
         * @param {string} [format="dd"] - The format to use for the coordinate. It can be "dd" for decimal degrees, or "dms" for degrees, minutes, and seconds.
         * @return {Object} An object containing the formatted longitude and latitude.
         * @example
         * dd=> {"formattedLon": "112.74719° BT", "formattedLat": "7.26786° LS"}
         * or
         * dms=> {"formattedLon": "112° 47' 17.00\" BT", "formattedLat": "7° 24' 46.00\" LS"}
         */
        function coordinateFormatIndo(coordinate, format = "dd") {
            const lon = coordinate[0];
            const lat = coordinate[1];

            const lonDirection = lon < 0 ? "BB" : "BT";
            const latDirection = lat < 0 ? "LS" : "LU"; // LS: Lintang Selatan, LU: Lintang Utara

            if (format === "dms") {
                const convertToDMS = (coord, direction) => {
                    const absoluteCoord = Math.abs(coord);
                    const degrees = Math.floor(absoluteCoord);
                    const minutes = Math.floor((absoluteCoord - degrees) * 60);
                    const seconds = (
                        (absoluteCoord - degrees - minutes / 60) *
                        3600
                    ).toFixed(2);
                    return `${degrees}° ${minutes}' ${seconds}" ${direction}`;
                };
                const formattedLon = convertToDMS(lon, lonDirection);
                const formattedLat = convertToDMS(lat, latDirection);
                return {
                    formattedLon,
                    formattedLat
                };
            } else {
                const formattedLon = `${Math.abs(lon).toFixed(5)}° ${lonDirection}`;
                const formattedLat = `${Math.abs(lat).toFixed(5)}° ${latDirection}`;
                return {
                    formattedLon,
                    formattedLat
                };
            }
        }

        // Init To Canvas/View
        let map = new Map({
            target: "map",

            layers: [
                new LayerGroup({
                    layers: baseMaps,
                }),
            ],

            view: view,

            controls: [
                zoomControl,
                scaleControl,
                // overviewMapControl,
                attribution,
                mousePositionControl,
            ],
        });
        map.getViewport().style.cursor = 'grab';
        map.addLayer(vectorLayer);
        var extent = vectorLayer.getSource().getExtent();
        map.getView().fit(extent, {
            padding: [100, 100, 100, 100],
            minResolution: map.getView().getResolutionForZoom(16),
            duration: 1500,
        });


        const hasilStatus = "<?= $ajuanData['hasilStatus'] ?? null; ?>"

        if (hasilStatus == "diperbolehkan") {
            $('#showKegiatan').html('<p class="boleh">Aktivitas yang diperbolehkan</p>');
        } else if (hasilStatus == "diperbolehkan bersyarat") {
            $('#showKegiatan').html('<p class="bolehBersyarat">Aktivitas diperbolehkan setelah memperoleh izin</p>');
        } else if (hasilStatus == "tidak diperbolehkan") {
            $('#showKegiatan').html('<p class="tidakBoleh">Aktivitas yang tidak diperbolehkan</p>');
        } else {
            $('#showKegiatan').html('<span class="text-warning">No Data</span>');
        }

    });

    function kirim() {
        const idZona = "<?= $valZonaString; ?>";
        const valKegiatan = "<?= $valKegiatan; ?>";
        const kawasanOverlap = "<?= $codeKawasanString; ?>";
        const hasilStatus = "<?= $hasil; ?>";
        const geojson = <?= json_encode($geojson[0]); ?>;
        console.log(valKegiatan);
        console.log(kawasanOverlap);
        console.log(hasilStatus);
        console.log(geojson);
        $("#kawasan").val(JSON.stringify(kawasanOverlap));
        $("#idZona").val(idZona);
        $("#hasilStatus").val(hasilStatus);
        $("#idKegiatan").val(valKegiatan);
        $("#drawFeatures").val(JSON.stringify(geojson));
    }
</script>
<?php $this->endSection() ?>