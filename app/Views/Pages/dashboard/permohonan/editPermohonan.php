<?php $this->extend('Layouts/dashboardTemplate') ?>

<?php $this->section('title') ?>
<?= $title ?? ""; ?> • Dashboard
<?php $this->endSection() ?>

<?php $this->section('og_title') ?>
<?= $title ?? ""; ?> • Dashboard
<?php $this->endSection() ?>

<?php $this->section('css') ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />

<!-- Open Layers Component -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v7.4.0/ol.css">
<link rel="stylesheet" href="https://unpkg.com/ol-layerswitcher@4.1.1/dist/ol-layerswitcher.css" />

<style>
    #map {
        height: 70vh;
    }

    .layer-switcher .panel {
        font-size: 12px;
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

    .filepond {
        width: 100% !important;
        height: auto;
    }
</style>
<?php $this->endSection() ?>


<?php $this->section('content') ?>
<?= $this->include('components/dependencies/_datatables') ?>

<div class="">
    <div class="mb-3">
        <h1 class="fs-3"><?= $title ?? "Edit Data"; ?></h1>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">

                <div class="card-body">
                    <h4 class="card-title">Edit Data</h4>

                    <form class="row g-3" action="/data/updateAjuan/<?= $tampilIzin->id_perizinan; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                        <?= csrf_field(); ?>

                        <h5>a. Identitas Pemohon</h5>

                        <div class="form-group">
                            <label class="form-label">NIK (Nomor Induk Kependudukan)</label>
                            <input type="text" class="form-control" id="nik" aria-describedby="textlHelp" name="nik" value="<?= esc($tampilIzin->nik); ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">NIB (Nomor Induk Berusaha)</label>
                            <input type="text" class="form-control" id="nik" aria-describedby="textlHelp" name="nib" value="<?= esc($tampilIzin->nib); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" aria-describedby="textlHelp" name="nama" value="<?= esc($tampilIzin->nama); ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" aria-describedby="textlHelp" name="alamat" value="<?= esc($tampilIzin->alamat); ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">No. Telp/HP</label>
                            <input type="text" class="form-control" id="kontak" aria-describedby="textlHelp" name="kontak" value="<?= esc($tampilIzin->kontak); ?>" required>
                        </div>
                        <div class="mb-1"></div>

                        <h5>b. Pengajuan Informasi Ruang Laut</h5>

                        <div class="form-group">
                            <label class="col-md-12 mb-2">Jenis Kegiatan</label>
                            <select class="form-select" id="pilihKegiatan" name="kegiatan" for="kegiatan" style="width: 100%;" onchange="cek()" required>
                                <option></option>
                                <?php foreach ($jenisKegiatan as $K) : ?>
                                    <option value="<?= $K->id_kegiatan ?>" <?= $K->id_kegiatan == $tampilIzin->id_kegiatan ? 'selected' : '' ?>><?= esc($K->nama_kegiatan) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12 mb-2">Wilayah Kegiatan</label>
                            <?php
                            if (!empty($tampilIzin->id_zona)) {
                                $zoneName = explode(",", $tampilIzin->id_zona);
                                $zoneName = array_unique($zoneName);
                                foreach ($tampilZona as $value) {
                                    if (in_array($value->id_zona, $zoneName)) {
                                        echo "<span>" . esc($value->nama_zona) . "</span>"  . "<br>";
                                    }
                                }
                            } else {
                                echo "<span> - </span>"  . "<br>";
                            }
                            ?>
                        </div>

                        <div class="feedback fs-6">Keterangan kesesuaian:</div>
                        <div class="info_status">
                            <div class="info_status" id="showKegiatan"> - </div>
                        </div>

                        <h5>c. Upload Berkas</h5>
                        <div id="tempatFile">
                            <div class="p-md-2 gap-2">
                                <?php if ($tampilIzin->uploadFiles != null) : ?>
                                    <?php foreach ($tampilIzin->uploadFiles as $file) : ?>
                                        <div class="card mb-3 flex-grow-1 border border-dark" style="max-width: 500px; overflow-wrap: anywhere;">
                                            <div class="card-body py-2 d-flex justify-content-between gap-2">
                                                <button type="button" class="btn btn-sm btn-danger bi bi-trash3-fill me-2" onclick="hapusFile('<?= $file->uploadFiles; ?>')"></button>
                                                <p class="card-text small"><a href="/dokumen/upload-dokumen/<?= $file->uploadFiles; ?>" target="_blank"><?= $file->uploadFiles; ?></a></p>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </div>
                        </div>

                        <input type="file" class="filepond" name="filepond[]" value="" multiple data-dokumenUp="<?= $tampilIzin->id_perizinan; ?>" />


                        <button type="submit" id="lanjutKirim" class="btn btn-sm btn-primary lanjutKirim" onclick="kirim()">Perbarui</button>
                    </form>


                </div>
            </div>
        </div>



        <div class="col-lg-6">
            <div class="card card-title">
                <div class="card-body">
                    <div class="map" id="map"></div>
                    <span id="koordinat"></span>
                </div>
            </div>
        </div>
    </div>

</div>

<?php $this->endSection() ?>


<?php $this->section('javascript') ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/proj4js/1.1.0/proj4js-compressed.min.js"></script>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

<!-- Open Layers Component -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.5.0/proj4.js"></script>
<script src="https://cdn.jsdelivr.net/npm/ol@v7.4.0/dist/ol.js"></script>
<script src="https://cdn.jsdelivr.net/npm/elm-pep@1.0.6/dist/elm-pep.js"></script>
<script src="https://unpkg.com/ol-layerswitcher@4.1.1"></script>
<script src="https://api.tiles.mapbox.com/mapbox.js/plugins/turf/v2.0.0/turf.min.js"></script>
<script src="/assets/js/catiline.js"></script>
<script src="https://unpkg.com/shpjs@latest/dist/shp.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Turf.js/0.0.124/turf.min.js" integrity="sha512-jpnZ8xGKbS7L9S6d5fk/zDVgF6OoVKLMoEliLxf24BRX+orWhxqJuUcoM+vGmOaozS9dD9ABjQZKAgjjcwTndA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function() {
        $('#pilihKegiatan').select2({
            placeholder: "Pilih Jenis Kegiatan",
            allowClear: true
        });
        $('#SubZona').select2({
            placeholder: "Pilih Zona Wilayah Kegiatan",
            allowClear: true
        });

        function hapusFile(file) {
            // console.log(file);
            $.ajax({
                type: "POST",
                url: `/data/delete_file`,
                data: {
                    file
                },
                dataType: "html",
                success: function(response) {
                    $("#tempatFile").html(response);
                }
            });
        }
    });
</script>

<script>
    <?php $koordinat = $tampilData->coordinat_wilayah ?>
    <?php $zoomView = $tampilData->zoom_view ?>
    <?php $splitKoordinat = explode(', ', $koordinat) ?>
    <?php $lon = $splitKoordinat[0] ?>
    <?php $lat = $splitKoordinat[1] ?>

    proj4.defs("EPSG:54034", "+proj=cea +lat_ts=0 +lon_0=0 +x_0=0 +y_0=0 +datum=WGS84 +units=m +no_defs +type=crs");
    proj4.defs("EPSG:23836", "+proj=tmerc +lat_0=0 +lon_0=112.5 +k=0.9999 +x_0=200000 +y_0=1500000 +ellps=WGS84 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs");

    let geojson = <?= $tampilIzin->lokasi; ?>;
    // console.log(geojson);

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
    var styleDraw;
    let geometryType = geojson.features[0].geometry.type;
    if (geometryType == "Point") {
        styleDraw = markerStyle;
    } else if (geometryType == "Polygon") {
        styleDraw = polygonStyle;
    } else {
        styleDraw = lineStyle;
    }
    let vectorSource = new ol.source.Vector({
        features: new ol.format.GeoJSON().readFeatures(geojson, {
            featureProjection: 'EPSG:3857', // Proyeksi EPSG:3857 (Web Mercator)
        })
    });
    let vectorLayer = new ol.layer.Vector({
        source: vectorSource,
        style: styleDraw,
    });
    const projection = new ol.proj.Projection({
        code: 'EPSG:54034',
        units: 'm',
        axisOrientation: 'neu'
    });

    // BaseMap
    const osmBaseMap = new ol.layer.Tile({
        title: 'Open Street Map',
        type: 'base',
        source: new ol.source.OSM(),
        crossOrigin: 'anonymous',
        visible: true,
    });

    const sourceBingMaps = new ol.source.BingMaps({
        key: 'AjQ2yJ1-i-j_WMmtyTrjaZz-3WdMb2Leh_mxe9-YBNKk_mz1cjRC7-8ILM7WUVEu',
        imagerySet: 'AerialWithLabels',
        maxZoom: 20,
    });
    const bingAerialBaseMap = new ol.layer.Tile({
        title: 'Bing Aerial',
        type: 'base',
        preload: Infinity,
        source: sourceBingMaps,
        crossOrigin: 'anonymous',
        visible: false,
    });

    const mapboxBaseURL = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiNjg2MzUzMyIsImEiOiJjbDh4NDExZW0wMXZsM3ZwODR1eDB0ajY0In0.6jHWxwN6YfLftuCFHaa1zw';
    const mapboxStyleId = 'mapbox/streets-v11';
    const mapboxSource = new ol.source.XYZ({
        url: mapboxBaseURL.replace('{id}', mapboxStyleId),
    });
    const mapboxBaseMap = new ol.layer.Tile({
        title: 'MapBox Road',
        type: 'base',
        visible: false,
        source: mapboxSource,
        crossOrigin: 'anonymous',
    });

    const baseMaps = [osmBaseMap, bingAerialBaseMap, mapboxBaseMap];

    // Init To Canvas/View
    const view = new ol.View({
        center: ol.proj.fromLonLat([<?= $lat; ?>, <?= $lon; ?>]),
        zoom: <?= $zoomView; ?>,
        Projection: projection
    });
    const map = new ol.Map({
        layers: baseMaps,
        target: 'map',
        controls: [
            //Define the default controls
            new ol.control.Zoom(),
            new ol.control.Attribution(),
            //Define some new controls
            new ol.control.ScaleLine(),

        ],
        view: view,
    });
    const mainMap = map;

    var layerSwitcher = new ol.control.LayerSwitcher({
        tipLabel: 'Legend', // Optional label for button
        groupSelectStyle: 'children' // Can be 'children' [default], 'group' or 'none'
    });
    map.addControl(layerSwitcher);
    map.addLayer(vectorLayer);
    var extent = vectorLayer.getSource().getExtent();
    map.getView().fit(extent, {
        padding: [100, 100, 100, 100],
        minResolution: map.getView().getResolutionForZoom(13),
        duration: 1500,
    });
</script>
<?php $this->endSection() ?>