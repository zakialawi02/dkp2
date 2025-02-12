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
                                    <div class="feedback fs-6">Keterangan:</div>
                                    <div class="info_status">
                                        <div class="info_status" id="showKegiatan"> <button type="button" id="cekKesesuaian" class="btn btn-sm btn-primary bi bi-search-heart"> Cek kesesuaian</button>
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
        <div id="map" class="map"> </div>
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://unpkg.com/ol-layerswitcher@4.1.1"></script>
<script src=" https://cdn.jsdelivr.net/npm/ol-ext@4.0.11/dist/ol-ext.min.js "></script>
<script src="/assets/js/catiline.js"></script>
<script src="https://unpkg.com/shpjs@latest/dist/shp.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Turf.js/0.0.124/turf.min.js" integrity="sha512-jpnZ8xGKbS7L9S6d5fk/zDVgF6OoVKLMoEliLxf24BRX+orWhxqJuUcoM+vGmOaozS9dD9ABjQZKAgjjcwTndA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL,Object.assign"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/eligrey/FileSaver.js/aa9f4e0e/FileSaver.min.js"></script>
<script src="/assets/js/write-shp.js"></script>

<script>
    $(document).ready(function() {
        <?php $koordinat = $tampilData->coordinat_wilayah ?>
        <?php $zoomView = $tampilData->zoom_view ?>
        <?php $splitKoordinat = explode(', ', $koordinat) ?>
        <?php $lon = $splitKoordinat[0] ?>
        <?php $lat = $splitKoordinat[1] ?>

        proj4.defs('EPSG:54034', '+proj=cea +lat_ts=0 +lon_0=0 +x_0=0 +y_0=0 +datum=WGS84 +units=m +no_defs +type=crs');
        proj4.defs('EPSG:32750', '+proj=utm +zone=50 +south +ellps=WGS84 +datum=WGS84 +units=m +no_defs');

        const geojson = <?= $tampilDataIzin->lokasi; ?>;

        // style vector geometry
        const markerStyle = new ol.style.Style({
            image: new ol.style.Icon({
                anchor: [0.5, 1],
                anchorXUnits: 'fraction',
                anchorYUnits: 'fraction',
                opacity: 1,
                src: '/mapSystem/images/marker-icon.png',
                scale: 0.8,
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
        // style vector geometry eksisting
        const markerStyleEks = new ol.style.Style({
            image: new ol.style.Icon({
                anchor: [0.5, 1],
                anchorXUnits: 'fraction',
                anchorYUnits: 'fraction',
                opacity: 1,
                src: '/mapSystem/images/marker-icon2.png',
                scale: 0.8,
            })
        });
        const lineStyleEks = new ol.style.Style({
            stroke: new ol.style.Stroke({
                color: 'rgba(255, 191, 0)',
                width: 2,
            }),
        });
        const polygonStyleEks = new ol.style.Style({
            fill: new ol.style.Fill({
                color: 'rgba(255, 191, 0, 0.7)',
            }),
            stroke: new ol.style.Stroke({
                color: 'rgba(255, 191, 0)',
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
            name: 'Data Pemohon',
            zIndex: 5
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
            baseLayer: true,
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
            baseLayer: true,
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
            baseLayer: true,
        });

        const baseMaps = new ol.layer.Group({
            title: 'Base Layers',
            openInLayerSwitcher: true,
            layers: [
                osmBaseMap, bingAerialBaseMap, mapboxBaseMap
            ]
        });

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

        var extent = vectorLayer.getSource().getExtent();
        map.getView().fit(extent, {
            padding: [100, 100, 100, 100],
            minResolution: map.getView().getResolutionForZoom(16),
            duration: 1500,
        });

        var layerSwitcher = new ol.control.LayerSwitcher({
            tipLabel: 'Legend', // Optional label for button
            groupSelectStyle: 'children' // Can be 'children' [default], 'group' or 'none'
        });
        map.addControl(layerSwitcher);
        map.addLayer(vectorLayer);


        // Select  interaction
        var select = new ol.interaction.Select({
            hitTolerance: 5,
            multi: true,
            condition: ol.events.condition.singleClick
        });
        map.addInteraction(select);
        // Select control
        var popup = new ol.Overlay.PopupFeature({
            popupClass: 'default anim',
            select: select,
            canFix: true,
            template: function(f) {
                return {
                    // title: function(f) {
                    //     return f.get('NAMA')
                    // },
                    attributes: {
                        NAMA: 'nama',
                        NIK: 'nik',
                        NIB: 'nib',
                        ALAMAT: 'alamat',
                        JNS_KEGIATAN: 'kegiatan',
                    }
                }
            }
        });
        map.addOverlay(popup);
    });
</script>
<?php $this->endSection() ?>