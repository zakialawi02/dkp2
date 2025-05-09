<?php $this->extend('Layouts/dashboardTemplate') ?>

<?php $this->section('title') ?>
<?= $title ?? ""; ?> • Dashboard
<?php $this->endSection() ?>

<?php $this->section('og_title') ?>
<?= $title ?? ""; ?> • Dashboard
<?php $this->endSection() ?>

<?php $this->section('css') ?>
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
                            <select class="form-select" id="pilihKegiatan" name="kegiatan" for="kegiatan" style="width: 100%;" required>
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
                            <div class="info_status" id="showKeteranganKegiatan"> - </div>
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
                    <span id="coordinates"></span>
                </div>
            </div>
        </div>
    </div>

</div>

<?php $this->endSection() ?>


<?php $this->section('javascript') ?>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/proj4js/1.1.0/proj4js-compressed.min.js"></script>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

<!-- Open Layers Component -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.5.0/proj4.js"></script>
<script src="https://cdn.jsdelivr.net/npm/ol@v7.4.0/dist/ol.js"></script>
<script src="https://cdn.jsdelivr.net/npm/elm-pep@1.0.6/dist/elm-pep.js"></script>
<script src="https://unpkg.com/ol-layerswitcher@4.1.1"></script>
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
        let GEOJSON = <?= $tampilIzin->lokasi; ?>;

        // Style Vector Geometry
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

        // Tentukan Style Berdasarkan Geometry Type
        let geometryType = GEOJSON.features[0].geometry.type;
        let styleDraw = markerStyle;
        if (geometryType === "Polygon") {
            styleDraw = polygonStyle;
        } else if (geometryType !== "Point") {
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
            style: styleDraw
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
            source: new ol.source.XYZ({
                url: 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiNjg2MzUzMyIsImEiOiJjbDh4NDExZW0wMXZsM3ZwODR1eDB0ajY0In0.6jHWxwN6YfLftuCFHaa1zw'.replace('{id}', 'mapbox/streets-v11')
            }),
            crossOrigin: 'anonymous',
            visible: false
        });

        // Group Base Maps
        const baseMaps = new ol.layer.Group({
            title: 'Base Map',
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

        // Layer Switcher
        const layerSwitcher = new ol.control.LayerSwitcher({
            tipLabel: 'Pilih Layer',
            groupSelectStyle: 'children'
        });
        map.addControl(layerSwitcher);

        // Fit View ke GeoJSON Extent
        const extent = vectorLayer.getSource().getExtent();
        map.getView().fit(extent, {
            padding: [100, 100, 100, 100],
            minResolution: map.getView().getResolutionForZoom(13),
            duration: 1500
        });


        // Parameter GeoServer RES/REQ KKPRL RTRW
        const GEOSERVER_URL = "<?= $_ENV['BASE_URL_GEOSERVER'] ?>";
        const WORKSPACE = "KKPRL";
        const LAYER_NAME = "KKPRL_RTRW_KALTIM_JOINTABLEWITH_RZWP";
        let INTERSECT_RESULT, INTERSECT_RESULT_PROPERTIES, INTERSECT_RESULT_PROPERTIES_UNIQUE;

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
            let valKegiatan = <?= $tampilIzin->id_kegiatan; ?>;
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

        $("#pilihKegiatan").change(function(e) {
            e.preventDefault();
            cekKesesuaian();
        });

        $("#pilihKegiatan").trigger("change");

    });

    function kirim() {

    }
</script>
<?php $this->endSection() ?>