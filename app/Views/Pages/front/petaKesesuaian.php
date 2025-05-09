<?php $this->extend('Layouts/mapTemplate'); ?>

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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v10.3.1/ol.css">

<link rel="stylesheet" href="<?= base_url('assets/css/map.css'); ?>">

<style>
    ::-webkit-scrollbar {
        width: .4rem;
        background: rgb(172, 172, 172);
    }

    ::-webkit-scrollbar-thumb {
        background: rgb(68, 102, 194);
        border-radius: .2rem;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: rgb(39, 80, 191);
    }

    #map {
        width: 100%;
        height: calc(100vh - 55px);
    }
</style>
<?php $this->endSection() ?>

<?php $this->section('content') ?>
<div class="layer-panel" id="layerPanel">
    <div class="layer-panel-header">
        <h6>Layers</h6>
        <i class="bi bi-x close-btn" id="closeLayers"></i>
    </div>
    <div class="layer-panel-body">
        <div class="small mb-3">
            <p style="margin: 3px">Transparansi</p>
            <input type="range" class="form-range custom-slider" id="slider" min="0" max="1" value="0.8" step="0.05">
            <div class="nouislider px-3 " id="transparansiSlider"></div>
        </div>

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
        <button class="btn btn-sm btn-outline-danger" id="measureClear">clear</button>
    </div>
</div>

<div class="cek-kesesuaian-panel" id="cekKesesuaianPanel">
    <div class="cek-kesesuaian-panel-header">
        <h6>Cek Kesesuaian</h6>
        <i class="bi bi-x close-btn" id="closeCekKesesuaian"></i>
    </div>

    <div class="" id="firstStep">
        <div class="cek-kesesuaian-panel-body px-1">
            <!-- CHOSE TYPE -->
            <div class="type-input pb-1">
                <label class="mb-2">Berdasar :</label>

                <!-- Format Selection -->
                <div class="row mb-2">
                    <div class="col-auto">
                        <div class="form-check">
                            <input class="form-check-input form-radio" type="radio" name="coordinateType" id="coord_file">
                            <label class="form-check-label" for="coord_file">Dengan File</label>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="form-check">
                            <input class="form-check-input form-radio" type="radio" name="coordinateType" id="coord_dd" checked>
                            <label class="form-check-label" for="coord_dd">Degree Decimal</label>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="form-check">
                            <input class="form-check-input form-radio" type="radio" name="coordinateType" id="coord_dms">
                            <label class="form-check-label" for="coord_dms">Degree Minute Second</label>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="form-check">
                            <input class="form-check-input form-radio" type="radio" name="coordinateType" id="drawPolygon">
                            <label class="form-check-label" for="drawPolygon">Gambar Polygon</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-none" id="drawPolygonField">
                <button class="btn btn-sm btn-primary" id="drawPolygonBtn" role="button"><i class="bi bi-vector-pen"></i>&nbsp;&nbsp; gambar polygon</button>
            </div>


            <!-- FORM INPUT FILE -->
            <div class="input-by-file d-none col-auto">
                <div class="mb-2">
                    <input type="file" class="form-control form-control-sm file-input" name="inputByFile" id="inputByFile"
                        accept=".zip,.kmz,.topojson,.xlsx,.xls,.csv" aria-describedby="fileHelpId">
                    <div id="fileHelpId" class="form-text mt-1">Pilih file csv, xlsx, shp(zip), kml</div>
                </div>
            </div>
            <div id="errorSHP" class="fs-6 text-danger"></div>
            <div id="loadFile" class="fs-6 text-danger"></div>


            <!-- BODY FORM INPUT COORDINATE -->
            <div class="coordinate-field-form">
                <!-- CHOOSE DATA TYPE -->
                <label class="mb-2">Tipe Data: </label>
                <div class="row">
                    <div class="col-auto">
                        <div class="form-check">
                            <input class="form-check-input form-radio" type="radio" name="dataType" id="point_type" value="POINT" checked>
                            <label class="form-check-label" for="point_type">Point</label>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="form-check">
                            <input class="form-check-input form-radio" type="radio" name="dataType" id="line_type" value="LINESTRING">
                            <label class="form-check-label" for="line_type">Line</label>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="form-check">
                            <input class="form-check-input form-radio" type="radio" name="dataType" id="polygon_type" value="POLYGON">
                            <label class="form-check-label" for="polygon_type">Polygon</label>
                        </div>
                    </div>
                </div>

                <!-- MAINFORM INPUT COORDINATE -->
                <div class="coordinate-field" id="coordinateInput">
                    <!-- First Coordinate Input -->
                    <div class="form-group mb-1 pb-1">
                        <div class="row">
                            <div class="col-md-6">
                                <b>Longitude</b><br>
                                <input id="tx_x" value="117.040" type="text" class="form-control form-control-sm dd-input" alt="posisi X">
                            </div>

                            <div class="col-md-6">
                                <b>Latitude</b><br>
                                <input id="tx_y" value="-1.175" type="text" class="form-control form-control-sm dd-input" alt="posisi Y">
                            </div>
                        </div>
                    </div>

                    <div class="form-group pb-1">
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <b>Longitude</b><br>
                                <div class="row">
                                    <div class="col-md-3">
                                        Degree<br>
                                        <input id="md1_1" disabled value="117" type="text" class="form-control form-control-sm dms-input" alt="posisi X">
                                    </div>
                                    <div class="col-md-3">
                                        Minute<br>
                                        <input id="md1_2" disabled value="2" type="text" class="form-control form-control-sm dms-input" alt="posisi X">
                                    </div>
                                    <div class="col-md-3">
                                        Second<br>
                                        <input id="md1_3" disabled value="24" type="text" class="form-control form-control-sm dms-input" alt="posisi X">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-1">
                                <b>Latitude</b><br>
                                <div class="row">
                                    <div class="col-md-3">
                                        Degree<br>
                                        <input id="md2_1" disabled value="-1" type="text" class="form-control form-control-sm dms-input" alt="posisi Y">
                                    </div>
                                    <div class="col-md-3">
                                        Minute<br>
                                        <input id="md2_2" disabled value="10" type="text" class="form-control form-control-sm dms-input" alt="posisi Y">
                                    </div>
                                    <div class="col-md-3">
                                        Second<br>
                                        <input id="md2_3" disabled value="32" type="text" class="form-control form-control-sm dms-input" alt="posisi Y">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-1" style="border-top: 1px dotted rgb(130, 130, 130);"></div>

                </div>
            </div>
        </div>

        <div>
            <div id="coordinateToogle">
                <div class="pb-1">
                    <span class="small">Jumlah Titik: <span id="jumlahCounterK">1</span></span>
                </div>
                <div class="d-flex align-items-center gap-1">
                    <button type="button" class="btn btn-sm btn-outline-dark" id="resetKoordinat" onclick="resetKoordinat()">Reset</button>
                    <button type="button" class="btn btn-sm btn-outline-dark" id="hapusKoordinat" disabled="true" onclick="hapusKoordinat()">- Hapus Titik</button>
                    <button type="button" class="btn btn-sm btn-outline-dark" id="tambahKoordinat" onclick="tambahKoordinat()">+ Tambah Titik</button>
                </div>
            </div>

            <div class="float-end">
                <button type="button" class="btn btn-sm btn-primary d-none" id="nextStepByFile">Lanjut</button>
                <button type="button" class="btn btn-sm btn-outline-primary" id="previewInput">Preview</button>
                <button type="button" class="btn btn-sm btn-primary" id="nextStep">Lanjut</button>
            </div>
        </div>
    </div>

    <div class="d-none" id="secondStep">
        <div class="cek-kesesuaian-panel-body px-1" style="font-size: 0.94rem !important;">
            <div id="intersectResult" class="mb-2 small">
                <p class="form-text small text-muted">*Zona Yang Saling Tumpang Tindih Dengan Lokasi Geometry</p>
                <div class="table-responsive">
                    <table class="table align-middle" width="100%">
                        <tbody>
                            <tr>
                                <td class="thead">Nama Objek</td>
                                <td class="tspace">:</td>
                                <td class="zona">
                                    Zona Perikanan Tangkap <br>
                                    Zona Pelabuhan Umum <br>
                                </td>
                            </tr>
                            <tr>
                                <td class="thead">Kawasan</td>
                                <td class="tspace">:</td>
                                <td class="kawasan">
                                    Kawasan Pemanfaatan Umum <br>
                                </td>
                            </tr>
                            <tr>
                                <td class="thead">Kode</td>
                                <td class="tspace">:</td>
                                <td class="kode">
                                    KPU-PT-10 <br>
                                    KPU-PL-06 <br>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <form action="/data/isiAjuan" id="formCekKesesuaian" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>

                    <input type="hidden" class="form-control" for="geojson" id="geojson" name="geojson" value="">
                    <input type="hidden" class="form-control" for="getOverlap" id="getOverlap" name="getOverlap" value="">
                    <input type="hidden" class="form-control" for="getOverlapProperties" id="getOverlapProperties" name="getOverlapProperties" value="">
                    <input type="hidden" class="form-control" for="idZona" id="idZona" name="idZona" value="">
                    <input type="hidden" class="form-control" for="hasilStatus" id="hasilStatus" name="hasilStatus" value="">

                    <div class="form-group">
                        <label class="col-md-12 mb-2">Jenis Kegiatan</label>
                        <select class="form-select form-select-sm" id="pilihKegiatan" name="kegiatan" for="kegiatan" style="width: 100%;" onchange="cek()" required>
                            <option>-- Pilih Jenis Kegiatan --</option>
                            <?php foreach ($jenisKegiatan as $K) : ?>
                                <option value="<?= $K->id_kegiatan; ?>"><?= esc($K->nama_kegiatan); ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="feedback small">Keterangan:</div>
                    <div class="float-start small">
                        <div class="" id="showKeteranganKegiatan"> - </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="float-end mt-2">
            <button type="button" class="btn btn-sm btn-secondary mb-2" id="backToFirst">Kembali</button>
            <button type="button" class="btn btn-sm btn-primary mb-2" id="lanjutKirim" onclick="kirim()">Lanjut</button>
        </div>
    </div>
</div>


<section class="position-relative map-section">
    <div id="map"></div>

    <div class="" id="topLeft">

    </div>

    <div class="" id="topRight">

    </div>

    <div class="" id="bottomLeft">
        <div class="d-flex align-items-end">
            <!-- Mouse Position -->
            <div class="position-relative mb-1" id="mousePosition"></div>

            <!-- Scaleline -->
            <div class="position-relative" id="scaleline"></div>

            <!-- Basemap -->
            <div class="basemap-switcher">
                <div class="trigger-basemap" onclick="toggleOptions()">
                    <img id="active-basemap" src="/assets/img/mapSystem/icon/here_satelliteday.png" alt="Active Basemap">
                    <span class="d-block">Basemap</span>
                </div>
                <div class="basemap-options">
                    <label class="basemap-option">
                        <input type="radio" name="basemap" value="bing" checked onclick="setBasemap('bing', this)">
                        <img src="/assets/img/mapSystem/icon/here_satelliteday.png" alt="Satellite">
                        <span>Satellite</span>
                    </label>
                    <label class="basemap-option">
                        <input type="radio" name="basemap" value="mapbox" onclick="setBasemap('mapbox', this)">
                        <img src="/assets/img/mapSystem/icon/here_normalday.png" alt="Mapbox">
                        <span>Street Mapbox</span>
                    </label>
                    <label class="basemap-option">
                        <input type="radio" name="basemap" value="osm" onclick="setBasemap('osm', this)">
                        <img src="/assets/img/mapSystem/icon/openstreetmap_mapnik.png" alt="OpenStreet">
                        <span>OpenStreet Map</span>
                    </label>
                    <label class="basemap-option">
                        <input type="radio" name="basemap" value="esriTerrain" onclick="setBasemap('esriTerrain', this)">
                        <img src="/assets/img/mapSystem/icon/esri_worldterrain.png" alt="Esri Terrain">
                        <span>Esri Terrain</span>
                    </label>
                </div>
            </div>

        </div>
    </div>



    <div class="" id="bottomRight">
        <!-- Zoom Toggle -->
        <div class="position-relative" id="zoomToggle"></div>

        <!-- Minimap -->
        <div class="position-relative" id="minimap"></div>


        <!-- attribution -->
        <div class="position-relative" id="attribution"></div>
    </div>
</section>
<?php $this->endSection() ?>

<?php $this->section('javascript') ?>
<script src="https://cdn.jsdelivr.net/npm/ol@v10.3.1/dist/ol.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.15.0/proj4-src.min.js" integrity="sha512-Hzlk8LOpeLtZLCTLvwaTlQo6iJKTEd/QRH8XgxB9QG7gXApOvOOOsmPYGneRWH2fcscI7Pb/UI6UTv56yfutXw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/@turf/turf@7/turf.min.js"></script>
<script src="https://unpkg.com/shpjs@latest/dist/shp.min.js"></script>
<script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js" integrity="sha512-XMVd28F1oH/O71fzwBnV7HucLxVwtxf26XV8P4wPk26EDxuGZ91N8bsOttmnomcCD3CS5ZMRL50H0GgOHvegtg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $('#pilihKegiatan').select2({
        placeholder: "Pilih Jenis Kegiatan",
        allowClear: true
    });
</script>


<script>
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

    const esriMap = new Layer({
        source: new Source({
            attributions: 'Tiles © <a href="https://services.arcgisonline.com/ArcGIS/' +
                'rest/services/World_Topo_Map/MapServer">ArcGIS</a>',
            url: 'https://server.arcgisonline.com/ArcGIS/rest/services/' +
                'World_Topo_Map/MapServer/tile/{z}/{y}/{x}',
        }),
        crossOrigin: "anonymous",
        visible: false
    });

    const baseMaps = [osmBaseMap, bingAerialBaseMap, mapboxBaseMap, esriMap];

    // Minimap
    const overviewMapControl = new OverviewMap({
        layers: [
            new TileLayer({
                source: new OSM(),
            }),
        ],
        target: document.getElementById("minimap"),
        className: "ol-overviewmap ol-custom-overviewmap",
        collapsed: false,
        tipLabel: "Minimap",
        collapseLabel: "\u00BB",
        label: "\u00AB",
    });

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
            overviewMapControl,
            attribution,
            mousePositionControl,
        ],
    });
    map.getViewport().style.cursor = 'grab';

    function setBasemap(mapType, element = null) {
        document.getElementById('active-basemap').src = element?.nextElementSibling?.src ?? element?.querySelector('img')?.src;
        if (mapType === 'osm') {
            setOsmBasemap();
        } else if (mapType === 'bing') {
            setBingmapBasemap();
        } else if (mapType === 'mapbox') {
            setMapboxBasemap();
        } else if (mapType === 'esriTerrain') {
            setEsriBasemap();
        }

        localStorage.setItem("basemap", mapType);
    }

    function toggleOptions() {
        document.querySelector('.basemap-options').classList.toggle('d-flex');
    }

    function initBasemap() {
        const savedBasemap = localStorage.getItem("basemap");
        if (savedBasemap) {
            const element = document.querySelector(`input[name='basemap'][value='${savedBasemap}']`).parentElement;
            setBasemap(savedBasemap, element);
        } else {
            const checkedInput = document.querySelector("input[name='basemap']:checked");
            setBasemap(checkedInput.value, checkedInput.parentElement);
        }
    }
    initBasemap();

    function setOsmBasemap() {
        osmBaseMap.setVisible(true);
        bingAerialBaseMap.setVisible(false);
        mapboxBaseMap.setVisible(false);
        esriMap.setVisible(false);
    }

    function setBingmapBasemap() {
        osmBaseMap.setVisible(false);
        bingAerialBaseMap.setVisible(true);
        mapboxBaseMap.setVisible(false);
        esriMap.setVisible(false);
    }

    function setMapboxBasemap() {
        osmBaseMap.setVisible(false);
        bingAerialBaseMap.setVisible(false);
        mapboxBaseMap.setVisible(true);
        esriMap.setVisible(false);
    }

    function setEsriBasemap() {
        osmBaseMap.setVisible(false);
        bingAerialBaseMap.setVisible(false);
        mapboxBaseMap.setVisible(false);
        esriMap.setVisible(true);
    }

    // wms source layer
    const KKPRL_LAYER = new LayerGroup({
        title: "KKPRL (Kesesuaian Kegiatan Pemanfaatan Ruang Laut)",
    });
    map.addLayer(KKPRL_LAYER);

    const KKPRL_LAYER_DATA = [{
            name: "Alur_Migrasi_Mamalia_Laut",
            title: "Alur_Migrasi_Mamalia_Laut",
            visible: false,
            opacity: 0.7,
            zIndex: 5,
        },
        {
            name: "Alur_Migrasi_Penyu",
            title: "Alur_Migrasi_Penyu",
            visible: false,
            opacity: 0.7,
            zIndex: 5,
        },
        {
            name: "Alur_Pelayaran_Umum_dan_Perlintasan",
            title: "Alur_Pelayaran_Umum_dan_Perlintasan",
            visible: false,
            opacity: 0.7,
            zIndex: 5,
        },
        {
            name: "Alur_Pelayaran_dan_Perlintasan_Internasional",
            title: "Alur_Pelayaran_dan_Perlintasan_Internasional",
            visible: false,
            opacity: 0.7,
            zIndex: 5,
        },
        {
            name: "Alur_Pelayaran_dan_Perlintasan_Khusus",
            title: "Alur_Pelayaran_dan_Perlintasan_Khusus",
            visible: false,
            opacity: 0.7,
            zIndex: 5,
        },
        {
            name: "Alur_Pelayaran_dan_Perlintasan_Nasional",
            title: "Alur_Pelayaran_dan_Perlintasan_Nasional",
            visible: false,
            opacity: 0.7,
            zIndex: 5,
        },
        {
            name: "Alur_Pelayaran_dan_Perlintasan_Regional",
            title: "Alur_Pelayaran_dan_Perlintasan_Regional",
            visible: false,
            opacity: 0.7,
            zIndex: 5,
        },
        {
            name: "Kawasan_Konservasi_Lainnya",
            title: "Kawasan_Konservasi_Lainnya",
            visible: false,
            opacity: 0.7,
            zIndex: 1,
        },
        {
            name: "Kawasan_Konservasi_Maritim",
            title: "Kawasan_Konservasi_Maritim",
            visible: false,
            opacity: 0.7,
            zIndex: 1,
        },
        {
            name: "Lintas_Penyeberangan_Antarkabupaten_Kota_dalam_Provinsi",
            title: "Lintas_Penyeberangan_Antarkabupaten_Kota_dalam_Provinsi",
            visible: false,
            opacity: 0.7,
            zIndex: 1,
        },
        {
            name: "Lintas_Penyeberangan_Antarprovinsi",
            title: "Lintas_Penyeberangan_Antarprovinsi",
            visible: false,
            opacity: 0.7,
            zIndex: 1,
        },
        {
            name: "Pencadangan_Indikasi_Kawasan_Konservasi",
            title: "Pencadangan_Indikasi_Kawasan_Konservasi",
            visible: false,
            opacity: 0.7,
            zIndex: 1,
        },
        {
            name: "Sistem_Jaringan_Energi",
            title: "Sistem_Jaringan_Energi",
            visible: false,
            opacity: 0.7,
            zIndex: 1,
        },
        {
            name: "Sistem_Jaringan_Telekomunikasi",
            title: "Sistem_Jaringan_Telekomunikasi",
            visible: false,
            opacity: 0.7,
            zIndex: 1,
        },
        {
            name: "Taman",
            title: "Taman",
            visible: false,
            opacity: 0.7,
            zIndex: 1,
        },
        {
            name: "Zona_Bandar_Udara",
            title: "Zona_Bandar_Udara",
            visible: false,
            opacity: 0.7,
            zIndex: 1,
        },
        {
            name: "Zona_Industri",
            title: "Zona_Industri",
            visible: false,
            opacity: 0.7,
            zIndex: 1,
        },
        {
            name: "Zona_Pariwisata",
            title: "Zona_Pariwisata",
            visible: false,
            opacity: 0.7,
            zIndex: 1,
        },
        {
            name: "Zona_Pelabuhan_Perikanan",
            title: "Zona_Pelabuhan_Perikanan",
            visible: false,
            opacity: 0.7,
            zIndex: 1,
        },
        {
            name: "Zona_Pelabuhan_Umum",
            title: "Zona_Pelabuhan_Umum",
            visible: false,
            opacity: 0.7,
            zIndex: 1,
        },
        {
            name: "Zona_Perdagangan_Barang_dan_atau_Jasa",
            title: "Zona_Perdagangan_Barang_dan_atau_Jasa",
            visible: false,
            opacity: 0.7,
            zIndex: 1,
        },
        {
            name: "Zona_Perikanan_Budi_Daya",
            title: "Zona_Perikanan_Budi_Daya",
            visible: false,
            opacity: 0.7,
            zIndex: 1,
        },
        {
            name: "Zona_Perikanan_Tangkap",
            title: "Zona_Perikanan_Tangkap",
            visible: false,
            opacity: 0.7,
            zIndex: 1,
        },
        {
            name: "Zona_Permukiman",
            title: "Zona_Permukiman",
            visible: false,
            opacity: 0.7,
            zIndex: 1,
        },
        {
            name: "Zona_Pertahanan_dan_Keamanan",
            title: "Zona_Pertahanan_dan_Keamanan",
            visible: false,
            opacity: 0.7,
            zIndex: 1,
        },
        {
            name: "Zona_Pertambangan_Minyak_dan_Gas_Bumi",
            title: "Zona_Pertambangan_Minyak_dan_Gas_Bumi",
            visible: false,
            opacity: 0.7,
            zIndex: 1,
        },
    ];


    /**
     * Creates a new TileLayer with a TileWMS source.
     *
     * @param {string} title - The title of the layer.
     * @param {string} layerName - The name of the layer in the WMS(Geoserver).
     * @param {boolean} visible - Whether the layer is visible.
     * @param {number} zIndex - The z-index of the layer.
     * @return {TileLayer} The created TileLayer.
     */
    const createWMSLayer = (title, layerName, visible, opacity, zIndex) => {
        return new TileLayer({
            title,
            source: new TileWMS({
                url: "<?= $_ENV['BASE_URL_GEOSERVER'] ?>/wms",
                attributions: "KKPRL DKP KALTIM 2023",
                params: {
                    LAYERS: `KKPRL:${layerName}`,
                    TILED: true,
                    FORMAT: "image/png",
                    TRANSPARENT: true,
                },
                serverType: "geoserver",
                crossOrigin: "anonymous",
            }),
            preload: 10,
            opacity: opacity ?? 0.6,
            visible: visible ?? true,
            zIndex: zIndex ?? 1,
        });
    };

    KKPRL_LAYER_DATA.map(({
        name,
        title,
        visible,
        opacity,
        zIndex,
    }) => {
        const layer = createWMSLayer(title, name, visible, opacity, zIndex);
        KKPRL_LAYER.getLayers().push(layer);
    });

    // const kkp = new LayerGroup({
    //     title: "KKPRL DKP KALTIM 2023",
    //     layers: [
    //         new TileLayer({
    //             source: new TileWMS({
    //                 title: "KKPRL DKP KALTIM 2023",
    //                 url: "<?= $_ENV['BASE_URL_GEOSERVER'] ?>/KKPRL/wms",
    //                 attributions: "KKPRL DKP KALTIM 2023",
    //                 params: {
    //                     LAYERS: "KKPRL:KKPRL_KALTIM_05_01_2023_FIX",
    //                     TILED: true,
    //                     FORMAT: "image/png",
    //                     TRANSPARENT: true,
    //                     TIMESTAMP: new Date().getTime(),
    //                     CQL_FILTER: "NAMOBJ='Zona Pelabuhan Umum'", // filter hanya data dengan attribute property table
    //                 },
    //                 serverType: "geoserver",
    //                 crossOrigin: "anonymous",
    //             }),
    //             visible: true,
    //             opacity: 0.8,
    //             zIndex: 20,
    //         }),
    //     ],
    // });
    // map.addLayer(kkp);

    const toggleLayerVisibility = (layerName, checked) => {
        const name = layerName.split(":")[1];
        const index = KKPRL_LAYER_DATA.findIndex((layer) => layer.name === name);
        if (index >= 0) {
            KKPRL_LAYER.getLayers().item(index).setVisible(checked);
        }
    };

    const checkboxesLayer = document.querySelectorAll(".layer-panel-body .symbology.kkprl-layer");

    // Ambil data dari localStorage
    let storedLayers = JSON.parse(localStorage.getItem("kkprl-layer")) || [];

    // Fungsi untuk memperbarui localStorage
    const updateLocalStorage = () => {
        const checkedLayers = [...checkboxesLayer]
            .map(checkbox => checkbox.querySelector("input[type='checkbox']"))
            .filter(input => input.checked)
            .map(input => input.value);

        localStorage.setItem("kkprl-layer", JSON.stringify(checkedLayers));
    };

    // Setel checkbox berdasarkan localStorage atau simpan jika pertama kali
    checkboxesLayer.forEach((checkbox) => {
        const input = checkbox.querySelector("input[type='checkbox']");
        const layerValue = input.value;

        if (storedLayers && storedLayers.length > 0) {
            input.checked = storedLayers.includes(layerValue);
        } else if (storedLayers.length == 0) {
            input.checked = false;
        }

        toggleLayerVisibility(layerValue, input.checked);

        // Event listener untuk perubahan checkbox
        input.addEventListener("change", (event) => {
            toggleLayerVisibility(event.target.value, event.target.checked);
            updateLocalStorage();
        });
    });

    // Simpan data awal jika localStorage kosong
    if (!storedLayers) {
        updateLocalStorage();
    }

    $("#coord_dd").click(function() {
        $("#errorSHP").html("");
        $(".dd-input").prop("disabled", false);
        $(".dms-input").prop("disabled", true);
        $('.coordinate-field-form').removeClass('d-none');
        $('#coordinateToogle').removeClass('d-none');
        $('.input-by-file').addClass('d-none');
        $('#nextStepByFile').addClass('d-none');
        $('#drawPolygonField').addClass('d-none');
        $('#nextStep').removeClass('d-none');
    });
    $("#coord_dms").click(function() {
        $("#errorSHP").html("");
        $(".dd-input").prop("disabled", true);
        $(".dms-input").prop("disabled", false);
        $('.coordinate-field-form').removeClass('d-none');
        $('#coordinateToogle').removeClass('d-none');
        $('.input-by-file').addClass('d-none');
        $('#nextStepByFile').addClass('d-none');
        $('#drawPolygonField').addClass('d-none');
        $('#nextStep').removeClass('d-none');
    });
    $("#coord_file").click(function() {
        $("#errorSHP").html("");
        $(".dd-input").prop("disabled", true);
        $(".dms-input").prop("disabled", true);
        $('.coordinate-field-form').addClass('d-none');
        $('#coordinateToogle').addClass('d-none');
        $('.input-by-file').removeClass('d-none');
        $('#nextStepByFile').removeClass('d-none');
        $('#drawPolygonField').addClass('d-none');
        $('#nextStep').addClass('d-none');
    });
    $("#drawPolygon").click(function() {
        $("#errorSHP").html("");
        $(".dd-input").prop("disabled", true);
        $(".dms-input").prop("disabled", true);
        $('.coordinate-field-form').addClass('d-none');
        $('#coordinateToogle').addClass('d-none');
        $('.input-by-file').addClass('d-none');
        $('#nextStepByFile').addClass('d-none');
        $("#drawPolygonField").removeClass('d-none');
        $('#nextStep').addClass('d-none');
    })

    /**
     * Function to convert DMS to Decimal Degrees (DD)
     * @param {number} degrees - degrees of the coordinate
     * @param {number} minutes - minutes of the coordinate
     * @param {number} seconds - seconds of the coordinate
     * @param {string} direction - direction of the coordinate (S, LS, BB)
     * @returns {number} decimal degrees of the coordinate
     */
    const dmsToDecimal = (degrees, minutes, seconds, direction) => {
        let decimal = degrees + minutes / 60 + seconds / 3600;
        if (direction === "S" || direction === "BB" || direction === "LS") {
            decimal = decimal * -1; // Ubah menjadi negatif untuk Lintang Selatan & Bujur Barat
        }
        return decimal;
    };

    /**
     ** Variables to manage the number of coordinates
     ** This variable is used to store the number of coordinates that the user has input
     ** The maximum number of coordinates that can be input is 10
     */
    let coordinateCount = 1;
    const maxCoordinates = 10;

    /**
     * Variable to store the new field input for the coordinate form
     * This variable is used to generate a new input field for the user to input the coordinates
     * @type {string}
     */
    const newFieldInput = `
                <div class="form-group mb-1 pb-1">
                        <div class="row">
                            <div class="col-md-6">
                                <b>Longitude</b><br>
                                <input id="tx_x" value="117.040" type="text" class="form-control form-control-sm dd-input" alt="posisi X">
                            </div>

                            <div class="col-md-6">
                                <b>Latitude</b><br>
                                <input id="tx_y" value="-1.175" type="text" class="form-control form-control-sm dd-input" alt="posisi Y">
                            </div>
                        </div>
                    </div>

                    <div class="form-group pb-1">
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <b>Longitude</b><br>
                                <div class="row">
                                    <div class="col-md-3">
                                        Degree<br>
                                        <input id="md1_1" disabled value="117" type="text" class="form-control form-control-sm dms-input" alt="posisi X">
                                    </div>
                                    <div class="col-md-3">
                                        Minute<br>
                                        <input id="md1_2" disabled value="2" type="text" class="form-control form-control-sm dms-input" alt="posisi X">
                                    </div>
                                    <div class="col-md-3">
                                        Second<br>
                                        <input id="md1_3" disabled value="24" type="text" class="form-control form-control-sm dms-input" alt="posisi X">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-1">
                                <b>Latitude</b><br>
                                <div class="row">
                                    <div class="col-md-3">
                                        Degree<br>
                                        <input id="md2_1" disabled value="-1" type="text" class="form-control form-control-sm dms-input" alt="posisi Y">
                                    </div>
                                    <div class="col-md-3">
                                        Minute<br>
                                        <input id="md2_2" disabled value="10" type="text" class="form-control form-control-sm dms-input" alt="posisi Y">
                                    </div>
                                    <div class="col-md-3">
                                        Second<br>
                                        <input id="md2_3" disabled value="32" type="text" class="form-control form-control-sm dms-input" alt="posisi Y">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-1" style="border-top: 1px dotted rgb(130, 130, 130);"></div>

                </div>
            `;

    /**
     * Function to add a new coordinate
     * 
     * This function adds a new row input for coordinates. It increments the coordinate count,
     * updates the counter text, and enables the remove button. It also creates a new div
     * element with the class 'coordinate-field' and appends it to the parent element.
     * If the maximum number of coordinates is reached, it disables the add button.
     */
    function tambahKoordinat() {
        coordinateCount++;
        $('#jumlahCounterK').html(coordinateCount);
        $('#hapusKoordinat').prop('disabled', false);
        // Create a new input row for coordinates
        const coordinateDiv = document.createElement('div');
        coordinateDiv.classList.add('coordinate-field', 'mb-2');
        coordinateDiv.innerHTML = newFieldInput;
        document.getElementById('coordinateInput').appendChild(coordinateDiv);
        updateInputState();
        if (coordinateCount >= maxCoordinates) {
            $('#tambahKoordinat').prop('disabled', true);
        }
    }

    /**
     * Removes the last coordinate input field.
     *
     * This function decreases the coordinate count and updates the counter display.
     * It removes the last coordinate input field from the DOM. If only one coordinate
     * remains, the remove button is disabled.
     */
    function hapusKoordinat() {
        coordinateCount--;
        $('#jumlahCounterK').html(coordinateCount);
        if (coordinateCount === 1) {
            $('#hapusKoordinat').prop('disabled', true);
        }
        $('.coordinate-field:last').remove();
    }

    /**
     * Resets the coordinate form.
     *
     * This function resets the coordinate form to its initial state by removing all
     * dynamically added coordinate input fields and setting the coordinate count to 1.
     * It also updates the counter display and calls the updateInputState function to
     * update the state of the input fields.
     */
    function resetKoordinat() {
        const parent = document.getElementById('coordinateInput');
        parent.innerHTML = newFieldInput;
        coordinateCount = 1;
        document.getElementById('jumlahCounterK').innerText = coordinateCount;
        updateInputState();
    }

    /**
     * Updates the state of the input fields based on the current selection.
     *
     * This function is called whenever the selection changes. It updates the state
     * of the input fields (Decimal Degrees or Degree Minute Second) depending on
     * the current selection.
     */
    function updateInputState() {
        if ($('#coord_dd').is(":checked")) {
            $(".dd-input").prop("disabled", false);
            $(".dms-input").prop("disabled", true);
        } else {
            $(".dd-input").prop("disabled", true);
            $(".dms-input").prop("disabled", false);
        }
    }

    /**
     * Style for different geometries
     *
     * This style defines the appearance of features in the map. It is used for
     * points, lines and polygons.
     *
     * @type {Style}
     */
    const pointStyle = new Style({
        image: new Icon({
            anchor: [0.5, 0.99],
            anchorXUnits: "fraction",
            anchorYUnits: "fraction",
            with: 50,
            height: 50,
            opacity: 0.9,
            src: "./assets/img/mapSystem/icon/marker.svg",
        }),
    });
    const lineStyle = new Style({
        stroke: new Stroke({
            color: 'red',
            width: 3
        })
    });
    const polygonStyle = new Style({
        stroke: new Stroke({
            color: 'red',
            width: 2
        }),
        fill: new Fill({
            color: 'rgba(255, 0, 0, 0.3)'
        })
    });
    const pointInDraw = new Style({
        fill: new Fill({
            color: 'rgba(255, 255, 255, 0.2)',
        }),
        stroke: new Stroke({
            color: 'rgba(0, 0, 0, 0.5)',
            lineDash: [10, 10],
            width: 2,
        }),
        image: new CircleStyle({
            radius: 5,
            stroke: new Stroke({
                color: 'rgba(0, 0, 0, 0.7)',
            }),
            fill: new Fill({
                color: 'rgba(255, 255, 255, 0.2)',
            }),
        }),
    });

    /**
     * Function to choose the style based on geometry type.
     * 
     * @param {module:ol/Feature~Feature} feature The feature to get the style for.
     * @return {module:ol/style/Style~Style} The style for the given feature.
     */
    const getStyle = (feature) => {
        const type = feature.getGeometry().getType();
        if (type == 'Point') {
            if (drawingRunning) {
                return pointInDraw;
            }
            return pointStyle;
        } else if (type == 'LineString') {
            return lineStyle;
        } else if (type == 'Polygon') {
            return polygonStyle;
        }
        return null;
    };

    /**
     * Changes the style of all features from KML/KMZ to the one defined in getStyle function.
     * 
     * @param {module:ol/Feature~Feature[]} features The array of features to change the style of.
     */
    const styleKMLKMZ = (features) => {
        features.forEach((feature) => {
            feature.setStyle(getStyle(feature));
        });
    };


    /**
     * Vector source for drawing.
     * @type {VectorSource}
     */
    let vectorSourceDraw = new VectorSource();
    let vectorLayerDraw = new VectorLayer({
        source: vectorSourceDraw,
        style: getStyle,
        zIndex: 100
    });
    map.addLayer(vectorLayerDraw);

    /**
     ** Variables used to store coordinate data and other properties needed for the drawing process
     ** dataType: The type of data input (POINT, LINESTRING, POLYGON)
     ** jsonCoordinatesInput: Array containing input coordinates from the form
     ** geometryData: Array containing geometry data (featuresCollection) created from input coordinates
     ** geojsonFeature: Array containing feature data created from geometryData
     ** GEOJSON_DATA: Array containing feature data created from geojsonFeature
     ** geojsonArea: Area value if the input is a POLYGON
     ** drawingRunning: Boolean value indicating if drawing is in progress
     ** drawed: Boolean value indicating if drawing is completed
     */
    let dataType, jsonCoordinatesInput, geometryData, geojsonFeature, GEOJSON_DATA, geojsonArea;
    let drawingRunning = null;
    let drawed;


    /**
     * store current drawing interaction
     */
    let draw;

    /**
     * Currently drawn feature.
     * @type {import("../src/ol/Feature.js").default}
     */
    let sketch;

    /**
     * The help tooltip element.
     * @type {HTMLElement}
     */
    let helpTooltipElement;

    /**
     * Overlay to show the help messages.
     * @type {Overlay}
     */
    let helpTooltip;

    /**
     * The measure tooltip element.
     * @type {HTMLElement}
     */
    let measureTooltipElement;

    /**
     * Overlay to show the measurement.
     * @type {Overlay}
     */
    let measureTooltip;

    /**
     * Message to show when the user is drawing a polygon.
     * @type {string}
     */
    const continuePolygonMsg = "Click to continue drawing the polygon";

    /**
     * Message to show when the user is drawing a line.
     * @type {string}
     */
    const continueLineMsg = "Click to continue drawing the line";

    /**
     * Handle pointer move.
     * @param {import("../src/ol/MapBrowserEvent").default} evt The event.
     */
    const pointerMoveHandler = function(evt) {
        if (evt.dragging) {
            return;
        }
        /** @type {string} */
        let helpMsg = "Click to start drawing";

        if (sketch) {
            const geom = sketch.getGeometry();
            if (geom instanceof Polygon) {
                helpMsg = continuePolygonMsg;
            } else if (geom instanceof LineString) {
                helpMsg = continueLineMsg;
            }
        }

        if (helpTooltipElement) {
            helpTooltipElement.innerHTML = helpMsg;
            helpTooltip.setPosition(evt.coordinate);
            helpTooltipElement.classList.remove("hidden");
        }
    };
    map.on("pointermove", pointerMoveHandler);

    map.getViewport().addEventListener("mouseout", function() {
        if (helpTooltipElement) {
            helpTooltipElement.classList.add("hidden");
        }
    });

    /**
     * Format length output.
     * @param {LineString} line The line.
     * @return {string} The formatted length.
     */
    const formatLength = function(line) {
        const length = getLength(line);
        let output;
        if (length > 100) {
            output = Math.round((length / 1000) * 100) / 100 + " " + "km";
        } else {
            output = Math.round(length * 100) / 100 + " " + "m";
        }
        return output;
    };

    /**
     * Format area output.
     * @param {Polygon} polygon The polygon.
     * @return {string} Formatted area.
     */
    const formatArea = function(polygon) {
        const area = getArea(polygon);
        let output;
        if (area > 10000) {
            output = Math.round((area / 10000) * 100) / 100 + " ha";
        } else {
            output = Math.round(area * 100) / 100 + " m²";
        }
        return output;
    };

    /**
     * Creates a new help tooltip
     * @returns {void}
     */
    function createHelpTooltip() {
        if (helpTooltipElement) {
            helpTooltipElement.remove();
        }
        helpTooltipElement = document.createElement("div");
        helpTooltipElement.className = "ol-tooltip hidden";
        helpTooltip = new Overlay({
            element: helpTooltipElement,
            offset: [15, 0],
            positioning: "center-left",
        });
        map.addOverlay(helpTooltip);
    }

    /**
     * Creates a new measure tooltip
     * @returns {void}
     */
    function createMeasureTooltip() {
        if (measureTooltipElement) {
            measureTooltipElement.remove();
        }
        measureTooltipElement = document.createElement("div");
        measureTooltipElement.className = "ol-tooltip ol-tooltip-measure";
        measureTooltip = new Overlay({
            element: measureTooltipElement,
            offset: [0, -15],
            positioning: "bottom-center",
            stopEvent: false,
            insertFirst: false,
        });
        map.addOverlay(measureTooltip);
    }

    // Parameter GeoServer RES/REQ KKPRL RTRW
    const GEOSERVER_URL = "<?= $_ENV['BASE_URL_GEOSERVER'] ?>";
    const WORKSPACE = "KKPRL";
    const LAYER_NAME = "KKPRL_RTRW_KALTIM_JOINTABLEWITH_RZWP";
    let INTERSECT_RESULT, INTERSECT_RESULT_PROPERTIES, INTERSECT_RESULT_PROPERTIES_UNIQUE;


    $("#nextStep").click(function(e) {
        displayInputToMap().then(() => {
            checkIntersectionWithGeoServer(GEOJSON_DATA, GEOSERVER_URL, WORKSPACE, LAYER_NAME)
                .then(hasIntersection => {
                    if (hasIntersection) {
                        console.log("Ada fitur yang tumpang tindih di GeoServer!");
                    } else {
                        console.log("Tidak ada fitur yang tumpang tindih.");
                    }
                });
        })
        $("#firstStep").addClass("d-none");
        $("#secondStep").removeClass("d-none");
    });

    $("#backToFirst").click(function(e) {
        $("#firstStep").removeClass("d-none");
        $("#secondStep").addClass("d-none");
    });

    $("#previewInput").click(function(e) {
        displayInputToMap();
    });

    function displayInputToMap() {
        return new Promise((resolve, reject) => {
            try {
                vectorSourceDraw.clear(); // Hapus data sebelumnya

                jsonCoordinatesInput = [];
                geometryData = [];
                geojsonFeature = [];
                GEOJSON_DATA = [];
                const selectedCounter = coordinateCount;
                dataType = $("input[name='dataType']:checked").val();

                // Ambil nilai koordinat
                $('.coordinate-field').each(function() {
                    if ($("#coord_dms").is(":checked")) {
                        let degree1 = $(this).find('#md1_1').val();
                        let minute1 = $(this).find('#md1_2').val();
                        let second1 = $(this).find('#md1_3').val();
                        let degree2 = $(this).find('#md2_1').val();
                        let minute2 = $(this).find('#md2_2').val();
                        let second2 = $(this).find('#md2_3').val();

                        // Validasi data DMS
                        if (degree1 == '') degree1 = '0';
                        if (minute1 == '') minute1 = '0';
                        if (second1 == '') second1 = '0';
                        if (minute1 < 0) minute1 = -minute1;
                        if (second1 < 0) second1 = -second1;
                        if (degree1 < 0 || degree1 == '-0') {
                            minute1 = -minute1;
                            second1 = -second1;
                        }
                        if (degree2 == '') degree2 = '0';
                        if (minute2 == '') minute2 = '0';
                        if (second2 == '') second2 = '0';
                        if (minute2 < 0) minute2 = -minute2;
                        if (second2 < 0) second2 = -second2;
                        if (degree2 < 0 || degree2 == '-0') {
                            minute2 = -minute2;
                            second2 = -second2;
                        }

                        let longitude = parseFloat(degree1) + parseFloat((minute1) / 60) + parseFloat((second1) / 3600);
                        let latitude = parseFloat(degree2) + parseFloat((minute2) / 60) + parseFloat((second2) / 3600);
                        jsonCoordinatesInput.push([longitude, latitude]);
                    } else {
                        const longitudeInput = parseFloat($(this).find('#tx_x').val());
                        const latitudeInput = parseFloat($(this).find('#tx_y').val());
                        jsonCoordinatesInput.push([longitudeInput, latitudeInput]);
                    }
                });
                console.log(jsonCoordinatesInput);

                // Proses GeoJSON berdasarkan tipe data
                if (dataType == 'POINT') {
                    jsonCoordinatesInput.map((item) => {
                        var geometry = {
                            type: "Point",
                            coordinates: item
                        };
                        geometryData.push(geometry);
                        var feature = turf.feature(geometry);
                        geojsonFeature.push(feature);
                    })
                    var collection = turf.featureCollection(geojsonFeature);
                    GEOJSON_DATA.push(collection);
                } else if (dataType == 'LINESTRING') {
                    if (jsonCoordinatesInput.length < 2) {
                        alert('Minimal 2 koordinat');
                        reject('Error: Minimal 2 koordinat'); // Reject jika error
                        return false;
                    }
                    var geometry = {
                        type: "LineString",
                        coordinates: jsonCoordinatesInput
                    };
                    var feature = turf.feature(geometry);
                    var collection = turf.featureCollection([feature]);
                    geometryData.push(geometry);
                    geojsonFeature.push(feature);
                    GEOJSON_DATA.push(collection);
                } else if (dataType == 'POLYGON') {
                    if (jsonCoordinatesInput.length < 3) {
                        alert('Minimal 3 koordinat');
                        reject('Error: Minimal 3 koordinat'); // Reject jika error
                        return false;
                    }
                    jsonCoordinatesInput.push(jsonCoordinatesInput[0]);
                    var geometry = {
                        type: "Polygon",
                        coordinates: [jsonCoordinatesInput]
                    };
                    var feature = turf.feature(geometry);
                    var collection = turf.featureCollection([feature]);
                    geometryData.push(geometry);
                    geojsonFeature.push(feature);
                    GEOJSON_DATA.push(collection);
                }

                console.log(geojsonFeature);
                console.log(GEOJSON_DATA);

                if (GEOJSON_DATA.length > 0) {
                    GEOJSON_DATA.forEach(data => {
                        const features = new GeoJSON().readFeatures(data, {
                            featureProjection: 'EPSG:4326'
                        });
                        features.forEach(feature => {
                            const geometry = feature.getGeometry();
                            geometry.transform('EPSG:4326', 'EPSG:3857');
                        });
                        vectorSourceDraw.addFeatures(features);
                    });

                    if (vectorSourceDraw.getFeatures().length > 0) {
                        const extent = vectorSourceDraw.getExtent();
                        map.getView().fit(extent, {
                            duration: 1000,
                            padding: [100, 100, 100, 100],
                            minResolution: map.getView().getResolutionForZoom(17),
                        });
                    }
                }

                resolve(); // Promise resolved
            } catch (error) {
                reject(error); // Jika ada error, reject Promise
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
        let wktArray = GEOJSON_DATA[0].features.map(feature => {
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
                console.log(data);
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
            })
            .catch(error => {
                console.error("Error fetching WFS:", error);
                return false;
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

        // Ambil elemen tabel
        let zonaTd = document.querySelector(".zona");
        let kawasanTd = document.querySelector(".kawasan");
        let kodeTd = document.querySelector(".kode");

        // Pengecekan jika data kosong, tampilkan teks default
        let zonaText = cleanedData.zones.length > 0 ? cleanedData.zones.join("<br>") : "Maaf, Tidak ada data / Tidak terdeteksi";
        let kawasanText = cleanedData.kawasan.length > 0 ? cleanedData.kawasan.join("<br>") : "Maaf, Tidak ada data / Tidak terdeteksi";
        let kodeText = cleanedData.codes.length > 0 ? cleanedData.codes.join("<br>") : "-";

        // Masukkan ke dalam tabel
        zonaTd.innerHTML = zonaText;
        kawasanTd.innerHTML = kawasanText;
        kodeTd.innerHTML = kodeText;
    }

    const isLoggedIn = <?= logged_in() ? 'true' : 'false' ?>;

    function cek() {
        console.log("cek");
        // console.log(INTERSECT_RESULT);
        // console.log(INTERSECT_RESULT_PROPERTIES);
        // console.log(INTERSECT_RESULT_PROPERTIES_UNIQUE);
        let csrfToken = $('input[name="csrf_test_name"]').val();
        let valKegiatan = $('#pilihKegiatan').val();
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
                    if (valZona.length === 0) {
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

    function kirim() {
        let valKegiatan = $('#pilihKegiatan').val();
        let hasilStatus = $("#hasilStatus").val();
        let geojson = GEOJSON_DATA;
        let getOverlap = INTERSECT_RESULT_PROPERTIES[0];
        let getOverlapProperties = INTERSECT_RESULT_PROPERTIES_UNIQUE;
        // console.log("kirim");
        // console.log(geojson);
        // console.log(getOverlap);
        // console.log(INTERSECT_RESULT_PROPERTIES_UNIQUE);
        // console.log(hasilStatus);
        $("#geojson").val(JSON.stringify(geojson));
        $("#getOverlap").val(JSON.stringify(getOverlap));
        $("#getOverlapProperties").val(JSON.stringify(getOverlapProperties));
        $("#hasilStatus").val(hasilStatus);
        $("#formCekKesesuaian").submit();
    }

    /**
     * Function to handle SHP file and add it to the map
     * @param {File} file SHP file to be processed
     */
    const handleShpFile = (file) => {
        $("#loadFile").html(loaderSpinner);
        vectorSourceDraw.clear(); // Hapus data sebelumnya
        const reader = new FileReader();
        reader.onload = function(event) {
            const arrayBuffer = event.target.result;
            shp(arrayBuffer).then(function(geojson) {
                GEOJSON_DATA = [];
                GEOJSON_DATA.push(geojson);

                // Tampilkan sistem proyeksi ke alert
                const crs = geojson.crs ? geojson.crs.properties.name : "Tidak ditemukan"; // Mendapatkan sistem proyeksi
                alert("Sistem Proyeksi: " + crs);

                // Jika SHP dalam proyeksi selain EPSG:4326, ubah ke EPSG:3857
                const features = new GeoJSON().readFeatures(geojson, {
                    featureProjection: 'EPSG:3857' // Ubah koordinat ke EPSG:3857
                });
                vectorSourceDraw.addFeatures(features);
                // Zoom otomatis ke data
                const extent = vectorSourceDraw.getExtent();

                map.getView().fit(extent, {
                    size: map.getSize(),
                    duration: 1000,
                    padding: [100, 100, 100, 100],
                    minResolution: map.getView().getResolutionForZoom(17),
                });
                $("#loadFile").html('');
                console.log("GeoJSON yang dimuat:", GEOJSON_DATA[0]);
            });
        };

        reader.readAsArrayBuffer(file);
    };

    /**
     * Handle XLSX file and convert it to GeoJSON
     * @param {File} file XLSX file to be processed
     */
    const handleXlsxFile = (file) => {
        $("#loadFile").html(loaderSpinner); // Tampilkan loaderSpinner
        vectorSourceDraw.clear();
        const reader = new FileReader();
        reader.onload = function(event) {
            const data = new Uint8Array(event.target.result);
            const workbook = XLSX.read(data, {
                type: "array"
            });

            const sheetName = workbook.SheetNames[0]; // Ambil sheet pertama
            const sheet = workbook.Sheets[sheetName];
            const jsonData = XLSX.utils.sheet_to_json(sheet);

            let _geojsonData = {
                type: "FeatureCollection",
                features: []
            };
            let groupedData = {};

            // DETEKSI FORMAT
            const isDMSFormat = jsonData[0].hasOwnProperty("bujur_derajat");
            const isDecimalFormat = jsonData[0].hasOwnProperty("Longitude");

            if (!isDMSFormat && !isDecimalFormat) {
                console.error("Format XLSX tidak dikenali.");
                $("#loadXLSX").html("⚠️ Format tidak valid.");
                return;
            }

            // Kelompokkan data berdasarkan 'Kode_Titik'
            jsonData.forEach(row => {
                const kodeTitik = row["Kode_Titik"];
                if (!groupedData[kodeTitik]) groupedData[kodeTitik] = [];

                let lon, lat;

                // Jika format DMS (bujur_derajat, bujur_menit, bujur_detik)
                if (isDMSFormat) {
                    lon = dmsToDecimal(row["bujur_derajat"], row["bujur_menit"], row["bujur_detik"], row["BT_BB"]);
                    lat = dmsToDecimal(row["lintang_derajat"], row["lintang_menit"], row["lintang_detik"], row["LU_LS"]);
                }

                // Jika format Desimal Degree (Longitude, Latitude)
                if (isDecimalFormat) {
                    lon = parseFloat(row["Longitude"]);
                    lat = parseFloat(row["Latitude"]);
                }


                // Pastikan koordinat valid sebelum menambah ke array
                if (!isNaN(lon) && !isNaN(lat)) {
                    groupedData[kodeTitik].push([lon, lat]);
                }
            });

            // Buat fitur berdasarkan jumlah titik/membangun fitur geojson
            Object.keys(groupedData).forEach(kodeTitik => {
                const coordinates = groupedData[kodeTitik];

                if (coordinates.length === 0) return; // Skip jika tidak ada koordinat valid

                let geometryType = "Point"; // Default tipe Point
                let geometryCoordinates = coordinates[0]; // Untuk Point

                if (coordinates.length === 2) {
                    geometryType = "LineString"; // Jika ada 2 titik, buat Line
                    geometryCoordinates = coordinates;
                } else if (coordinates.length > 2) {
                    geometryType = "Polygon"; // Jika lebih dari 2 titik, buat Polygon
                    coordinates.push(coordinates[0]); // Tutup poligon
                    geometryCoordinates = [coordinates];
                }

                _geojsonData.features.push({
                    type: "Feature",
                    properties: {
                        kode_titik: kodeTitik
                    },
                    geometry: {
                        type: geometryType,
                        coordinates: geometryCoordinates
                    }
                });
            });

            // Cek apakah GeoJSON valid sebelum ditambahkan ke peta
            if (_geojsonData.features.length === 0) {
                console.error("Tidak ada fitur valid dalam GeoJSON.");
                $("#loadFile").html("⚠️ Data tidak valid.");
                return;
            }

            GEOJSON_DATA = [];
            GEOJSON_DATA.push(_geojsonData);

            // Tambahkan data ke OpenLayers
            const features = new GeoJSON().readFeatures(_geojsonData, {
                featureProjection: "EPSG:3857"
            });
            vectorSourceDraw.addFeatures(features);

            // Zoom ke data
            const extent = vectorSourceDraw.getExtent();
            map.getView().fit(extent, {
                size: map.getSize(),
                duration: 1000,
                padding: [100, 100, 100, 100]
            });

            $("#loadFile").html(""); // Hapus loaderSpinner
            console.log("GeoJSON dari XLSX:", GEOJSON_DATA);
        };

        reader.readAsArrayBuffer(file);
    };

    /**
     * Read a KML/KMZ file and display it on the map.
     *
     * @param {File} file The file to read.
     */
    const handleKmlFile = (file) => {
        $("#loadFile").html(loaderSpinner);
        vectorSourceDraw.clear();
        const reader = new FileReader();
        reader.onload = function(event) {
            const kmlText = event.target.result;
            const kmlFormat = new KML();
            const features = kmlFormat.readFeatures(kmlText, {
                featureProjection: "EPSG:3857"
            });

            if (features.length === 0) {
                alert("Tidak ada fitur dalam file KML.");
                return;
            }

            // Konversi fitur ke GeoJSON & Transformasi setiap fitur ke EPSG:4326
            const geojsonFormat = new ol.format.GeoJSON();
            let transformedFeatures = features.map(feature => {
                let clonedFeature = feature.clone();
                let geom = clonedFeature.getGeometry();
                geom.transform("EPSG:3857", "EPSG:4326");
                return clonedFeature;
            });
            let _geojsonData = geojsonFormat.writeFeaturesObject(transformedFeatures);
            GEOJSON_DATA = [];
            GEOJSON_DATA.push(_geojsonData);

            styleKMLKMZ(features);

            vectorSourceDraw.addFeatures(features);

            const extent = vectorSourceDraw.getExtent();
            map.getView().fit(extent, {
                size: map.getSize(),
                duration: 1000,
                padding: [100, 100, 100, 100]
            });

            $("#loadFile").html("");
            console.log("KML berhasil diproses:", features);
        };
        reader.readAsText(file);
    };
    /**
     * Read a KMZ file and display it on the map.
     *
     * @param {File} file The file to read.
     */
    const handleKmzFile = (file) => {
        const reader = new FileReader();
        reader.onload = function(event) {
            const zip = new JSZip();
            zip.loadAsync(event.target.result).then(function(zipFiles) {
                // Cari file KML dalam KMZ
                let kmlFile = null;
                Object.keys(zipFiles.files).forEach(filename => {
                    if (filename.toLowerCase().endsWith(".kml")) {
                        kmlFile = zipFiles.files[filename];
                    }
                });

                if (!kmlFile) {
                    alert("File KML tidak ditemukan dalam KMZ.");
                    return;
                }

                kmlFile.async("text").then(function(kmlText) {
                    handleKmlFile(new Blob([kmlText], {
                        type: "text/xml"
                    }));
                });
            }).catch(error => {
                alert("Gagal membaca file KMZ.");
                console.error(error);
            });
        };
        reader.readAsArrayBuffer(file);
    };

    // Event listener untuk memilih file
    $("#inputByFile").change(function(e) {
        e.preventDefault();
        $("#loadFile").html('');
        $("#errorSHP").html('');
        const file = event.target.files[0];
        if (file) {
            const fileName = file.name.toLowerCase();
            if (fileName.endsWith(".xlsx") || fileName.endsWith(".xls")) {
                handleXlsxFile(file); // Proses file Excel
            } else if (fileName.endsWith(".zip")) {
                handleShpFile(file); // Proses file SHP (dalam format ZIP)
            } else if (fileName.endsWith(".kml")) {
                handleKmlFile(file);
            } else if (fileName.endsWith(".kmz")) {
                handleKmzFile(file);
            } else {
                $("#errorSHP").html("Format file tidak didukung! Harap unggah file SHP (ZIP) atau XLSX.");
            }
        }
    });

    // Event listener untuk tombol 'Lanjut'
    $("#nextStepByFile").click(function(e) {
        e.preventDefault();
        // Menampilkan log data GeoJSON setelah tombol diklik
        console.log("Data GeoJSON yang dimuat pada klik Lanjut:", GEOJSON_DATA[0]);

        // Cek tumpang tindih dengan data di GeoServer
        // Panggil fungsi untuk cek intersect
        checkIntersectionWithGeoServer(GEOJSON_DATA, GEOSERVER_URL, WORKSPACE, LAYER_NAME)
            .then(hasIntersection => {
                if (hasIntersection) {
                    console.log("Ada fitur yang tumpang tindih di GeoServer!");
                } else {
                    console.log("Tidak ada fitur yang tumpang tindih.");
                }
            });
    });


    let listener;
    /**
     * Adds a draw interaction to the map for drawing in map.
     * @param {string} [type="Polygon"] The type of geometry to draw. Can be "Polygon" or "LineString".
     * @returns {void}
     */
    function addInteraction(type = "Polygon") {
        // Remove previous draw layer and tooltips if any
        if (vectorLayerDraw) {
            map.removeLayer(vectorLayerDraw);
        }

        // Clear the vector source to remove any existing features
        vectorSourceDraw.clear();
        GEOJSON_DATA = [];

        // Remove previous tooltips from the DOM if they exist
        if (measureTooltipElement) {
            measureTooltipElement.remove(); // Remove tooltip element from DOM
        }

        // Remove the tooltip overlay from the map if it exists
        if (measureTooltip) {
            map.removeOverlay(measureTooltip); // Remove the overlay from the map
        }

        // Remove previous help tooltip if any
        if (helpTooltipElement) {
            helpTooltipElement.remove();
        }

        // Create the vector layer for drawing
        vectorLayerDraw = new VectorLayer({
            source: vectorSourceDraw,
            style: getStyle,
            zIndex: 999,
        });
        map.addLayer(vectorLayerDraw);

        // Create a new draw interaction
        draw = new Draw({
            source: vectorSourceDraw,
            type: type,
            style: getStyle,
        });

        // Add the new draw interaction to the map
        map.addInteraction(draw);

        createMeasureTooltip();
        createHelpTooltip();

        draw.on('drawstart', function(evt) {
            // set sketch
            sketch = evt.feature;

            /** @type {import("../src/ol/coordinate.js").Coordinate|undefined} */
            let tooltipCoord = evt.coordinate;

            listener = sketch.getGeometry().on('change', function(evt) {
                const geom = evt.target;
                let output;
                if (geom instanceof Polygon) {
                    output = formatArea(geom);
                    tooltipCoord = geom.getInteriorPoint().getCoordinates();
                } else if (geom instanceof LineString) {
                    output = formatLength(geom);
                    tooltipCoord = geom.getLastCoordinate();
                }
                measureTooltipElement.innerHTML = output;
                measureTooltip.setPosition(tooltipCoord);
            });
        });

        draw.on("drawend", function(evt) {
            drawed = true;

            // Get the feature drawn by the user
            const feature = evt.feature;

            // Convert the feature to GeoJSON
            const geojsonFormat = new GeoJSON();
            const geojson = geojsonFormat.writeFeature(feature, {
                dataProjection: "EPSG:4326",
                featureProjection: "EPSG:3857",
            });
            geojsonFeature = JSON.parse(geojson);
            let featureCollection = {
                type: "FeatureCollection",
                features: [geojsonFeature]
            }
            GEOJSON_DATA.push(featureCollection);

            drawingEnd();
        });
    }

    /**
     * Start the draw interaction and clear the vector layer if exists
     * @returns {void}
     */
    function drawingStart() {
        addInteraction();
        drawingRunning = true;
        drawed = null;
        buttonStateDrawing();
        map.getViewport().style.cursor = 'crosshair';
    }

    /**
     * End the draw interaction
     * @returns {void}
     */
    function drawingEnd() {
        drawingRunning = false;
        map.getViewport().style.cursor = 'grab';
        // Remove the measurement tooltip overlay from the map
        if (measureTooltip) {
            map.removeOverlay(measureTooltip);
        }

        measureTooltipElement.className = "ol-tooltip ol-tooltip-static";
        measureTooltip.setOffset([0, -7]);
        // unset sketch
        sketch = null;
        // unset tooltip so that a new one can be created
        measureTooltipElement = null;
        createMeasureTooltip();

        // Remove tooltips and overlays
        if (measureTooltipElement) {
            measureTooltipElement.remove();
        }
        if (helpTooltipElement) {
            helpTooltipElement.remove();
        }

        // Remove the draw interaction and vector layer after drawing is done
        map.removeInteraction(draw);

        // Unset the listener to avoid memory leaks
        unByKey(listener);

        buttonStateDrawing();

        if (GEOJSON_DATA.length > 0) {
            $("#firstStep").addClass("d-none");
            $("#secondStep").removeClass("d-none");
            console.log("Data GeoJSON yang dimuat:", GEOJSON_DATA[0]);

            // Cek tumpang tindih dengan data di GeoServer
            // Panggil fungsi untuk cek intersect
            checkIntersectionWithGeoServer(GEOJSON_DATA, GEOSERVER_URL, WORKSPACE, LAYER_NAME)
                .then(hasIntersection => {
                    if (hasIntersection) {
                        console.log("Ada fitur yang tumpang tindih di GeoServer!");
                    } else {
                        console.log("Tidak ada fitur yang tumpang tindih.");
                    }
                });


        }
    }

    /**
     * Update the draw button state and text based on the value of drawingRunning
     * @returns {void}
     */
    function buttonStateDrawing() {
        $("#drawPolygonBtn").html(
            drawingRunning ?
            "Batal" :
            "<i class='bi bi-vector-pen'></i>&nbsp;&nbsp; gambar polygon"
        );
        $("#drawPolygonBtn")
            .removeClass()
            .addClass(drawingRunning ? "btn btn-sm btn-danger" : "btn btn-sm btn-primary");
    }

    // Button to start/cancel the draw/measurement
    /**
     * Handles the button click event to start/cancel the draw/measurement interaction.
     * If the interaction is already running, it cancels the interaction.
     * If the interaction is not running, it starts the interaction.
     * @param {Event} e - The event object.
     */
    $("#drawPolygonBtn").click(function(e) {
        if (drawingRunning) {
            drawingEnd();
        } else {
            drawingStart();
        }
    });

    /**
     * Event listener for the Measure Area and Measure Distance buttons.
     * When the buttons are clicked, the measureStart function is called with the appropriate type.
     * @param {Event} e - The event object.
     */
    $("#measureArea").click(function(e) {
        measureStart("Polygon");
    })
    $("#measureDistance").click(function(e) {
        measureStart("LineString");
    })
    $("#measureClear").click(function(e) {
        measureClear()
    })
</script>
<script src="<?= base_url('assets/js/measureOpenLayers.js') ?>"></script>
<?php $this->endSection() ?>