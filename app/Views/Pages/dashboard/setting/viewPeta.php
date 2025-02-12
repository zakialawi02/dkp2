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

<style>
    #map {
        height: 70vh;
        cursor: grab;
    }

    .ol-control .panel {
        font-size: 0.9rem;
    }
</style>
<?php $this->endSection() ?>


<?php $this->section('content') ?>

<div class="">
    <div class="mb-3">
        <h1 class="fs-3">Setting View Peta</h1>
    </div>

    <div class="card pt-2 mb-4">
        <div class="card-body">
            <form class="row g-3" action="<?= route_to('admin.setting.updateSettingMap'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <div class="col-md-8">
                    <label for="koordinatView" class="form-label">Koordinat</label>
                    <input type="text" class="form-control" name="coordinat_wilayah" value="<?= $tampilData->coordinat_wilayah; ?>" id="koordinatView" placeholder="Latitude, Longitude">
                    <div id="passwordHelpBlock" class="form-text">
                        contoh: Latitude, Longitude <br>
                        contoh: -7.0385384, 112.8998345
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="zoomView" class="form-label">Zoom</label>
                    <input type="number" min="1" max="20" step="0.01" inputmode=" numeric" class="form-control" name="zoom_view" id="zoomView" value="<?= $tampilData->zoom_view; ?>" lang="en">
                    <div id="passwordHelpBlock" class="form-text">
                        min: 1, Max: 20
                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </form>
        </div>

    </div>

    <div class="card card-title">
        <div class="card-body">
            <div class="map" id="map"></div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>


<?php $this->section('javascript') ?>
<!-- Open Layers Component -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.5.0/proj4.js"></script>
<script src="https://cdn.jsdelivr.net/npm/ol@v7.4.0/dist/ol.js"></script>
<script src="https://cdn.jsdelivr.net/npm/elm-pep@1.0.6/dist/elm-pep.js"></script>
<script src="https://unpkg.com/ol-layerswitcher@4.1.1"></script>

<script type="text/javascript">
    <?php $koordinat = $tampilData->coordinat_wilayah ?>
    <?php $zoomView = $tampilData->zoom_view ?>
    <?php $splitKoordinat = explode(', ', $koordinat) ?>
    <?php $lon = $splitKoordinat[0] ?>
    <?php $lat = $splitKoordinat[1] ?>

    proj4.defs("EPSG:32750", "+proj=utm +zone=50 +south +ellps=WGS84 +datum=WGS84 +units=m +no_defs");
    proj4.defs("EPSG:23836", "+proj=tmerc +lat_0=0 +lon_0=112.5 +k=0.9999 +x_0=200000 +y_0=1500000 +ellps=WGS84 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs");

    const projection = new ol.proj.Projection({
        code: 'EPSG:32750',
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

    view.on('change', function() {
        const zoomView = view.getZoom();
        const centerCoordinate = view.getCenter();
        const lonLatCenter = ol.proj.toLonLat(centerCoordinate);
        $('#koordinatView').val(lonLatCenter[1] + ', ' + lonLatCenter[0])
        $('#zoomView').val(zoomView.toFixed(1));
    });
    const zoomInput = document.getElementById('zoomView');
    zoomInput.addEventListener('input', function() {
        this.value = this.value.replace(',', '.');
    });
</script>

<?php $this->endSection() ?>