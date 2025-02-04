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

<style>
    #map {
        width: 100%;
        height: calc(100vh - 55px);
    }


    #topLeft {
        position: absolute;
        top: 5px;
        left: 5px;
        width: max-content;
    }

    #topRight {
        position: absolute;
        top: 5px;
        right: 5px;
        width: max-content;
    }

    #bottomLeft {
        position: absolute;
        bottom: 5px;
        left: 5px;
        width: max-content;
    }

    #bottomRight {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: max-content;
    }


    /* Mouse Position */
    .ol-custom-mouse-position {
        padding: 0.3rem 0.5rem;
        background-color: #ffffff;
        border-radius: 5px;
        color: #303030;
        font-size: 0.8rem;
    }

    /* Scaleline */
    .ol-scale-line {
        max-width: 200px;
        background-color: #ffffff;
        padding: 0.2rem 0.8rem;
    }

    .ol-scale-line-inner {
        display: flex;
        border: 0 solid grey;
        transition: none;
    }

    /* attribution */
    .ol-attribution {
        top: auto;
        bottom: 0;
        left: auto;
        right: 0;
        width: max-content;
        max-width: max-content;
    }

    /* Zoom Toggle */
    .ol-custom-zoom {
        bottom: 30px;
        right: 0;
        font-size: 1.2rem;
        border-radius: 5px;
    }

    .ol-custom-zoom-in {
        background-image: url("data:image/svg+xml,%3Csvg class='w-6 h-6 text-gray-800 dark:text-white' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' viewBox='0 0 24 24'%3E%3Cpath stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 12h14m-7 7V5'/%3E%3C/svg%3E%0A");
        background-repeat: no-repeat no-repeat;
        background-position: center center;
        background-size: cover;
        padding: 0.8rem;
    }

    .ol-custom-zoom-out {
        background-image: url("data:image/svg+xml,%3Csvg class='w-6 h-6 text-gray-800 dark:text-white' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' viewBox='0 0 24 24'%3E%3Cpath stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 12h14'/%3E%3C/svg%3E%0A");
        background-repeat: no-repeat no-repeat;
        background-position: center center;
        background-size: cover;
        padding: 0.8rem;
    }

    /* minimap */
    .ol-custom-overviewmap,
    .ol-custom-overviewmap.ol-uncollapsible {
        top: auto;
        bottom: 30px;
        left: auto;
        right: 30px;
    }

    .ol-custom-overviewmap button {
        padding: 0.7rem;
        font-size: 1.2rem;
    }

    .ol-custom-overviewmap:not(.ol-collapsed) button {
        top: 0;
        bottom: auto;
        left: 0;
        right: auto;
    }

    .ol-custom-overviewmap span {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .ol-custom-overviewmap:not(.ol-collapsed) {
        border: 1px solid black;
    }

    .ol-custom-overviewmap .ol-overviewmap-map {
        border: none;
        width: 15rem;
    }

    .ol-custom-overviewmap .ol-overviewmap-box {
        border: 2px solid red;
    }
</style>
<?php $this->endSection() ?>

<?php $this->section('content') ?>

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

<?php $this->section('javascript') ?>
<script src="https://cdn.jsdelivr.net/npm/ol@v10.3.1/dist/ol.js"></script>

<script>
    let Map = ol.Map;
    let View = ol.View;
    let OSM = ol.source.OSM;
    let TileLayer = ol.layer.Tile;
    let TileSource = ol.source.Tile;
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
    let GeoJSON = ol.format.GeoJSON;
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
    let Draw = ol.interaction.Draw;
    let {
        getArea,
        getLength
    } = ol.sphere;
    let {
        unByKey
    } = ol.Observable;

    let WGS84 = new Projection("EPSG:4326");
    let MERCATOR = new Projection("EPSG:3857");
    let UTM49S = new Projection("EPSG:32649");

    const loader = `<div class="text-center"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></>`;

    // Init View
    const view = new View({
        // projection: "EPSG:4326",
        center: ol.proj.fromLonLat([117.83872038517481, -0.31515712103976057]),
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

    // wms source layer
    const KKPRL_LAYER = new LayerGroup({
        title: "KKPRL (Kesesuaian Kegiatan Pemanfaatan Ruang Laut)",
    });
    map.addLayer(KKPRL_LAYER);

    const KKPRL_LAYER_DATA = [{
            name: "Alur_Migrasi_Mamalia_Laut",
            title: "Alur_Migrasi_Mamalia_Laut",
            visible: true,
            opacity: 0.7,
            zIndex: 5,
        },
        {
            name: "Alur_Migrasi_Penyu",
            title: "Alur_Migrasi_Penyu",
            visible: true,
            opacity: 0.7,
            zIndex: 5,
        },
        {
            name: "Alur_Pelayaran_Umum_dan_Perlintasan",
            title: "Alur_Pelayaran_Umum_dan_Perlintasan",
            visible: true,
            opacity: 0.7,
            zIndex: 5,
        },
        {
            name: "Alur_Pelayaran_dan_Perlintasan_Internasional",
            title: "Alur_Pelayaran_dan_Perlintasan_Internasional",
            visible: true,
            opacity: 0.7,
            zIndex: 5,
        },
        {
            name: "Alur_Pelayaran_dan_Perlintasan_Khusus",
            title: "Alur_Pelayaran_dan_Perlintasan_Khusus",
            visible: true,
            opacity: 0.7,
            zIndex: 5,
        },
        {
            name: "Alur_Pelayaran_dan_Perlintasan_Nasional",
            title: "Alur_Pelayaran_dan_Perlintasan_Nasional",
            visible: true,
            opacity: 0.7,
            zIndex: 5,
        },
        {
            name: "Alur_Pelayaran_dan_Perlintasan_Regional",
            title: "Alur_Pelayaran_dan_Perlintasan_Regional",
            visible: true,
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
            visible: true,
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

    // KKPRL_LAYER_DATA.map(({
    //     name,
    //     title,
    //     visible,
    //     opacity,
    //     zIndex,
    // }) => {
    //     const layer = createWMSLayer(title, name, visible, opacity, zIndex);
    //     KKPRL_LAYER.getLayers().push(layer);
    // });


    const kkp = new LayerGroup({
        title: "KKPRL DKP KALTIM 2023",
        layers: [
            new TileLayer({
                source: new TileWMS({
                    title: "KKPRL DKP KALTIM 2023",
                    url: "<?= $_ENV['BASE_URL_GEOSERVER'] ?>/KKPRL/wms",
                    attributions: "KKPRL DKP KALTIM 2023",
                    params: {
                        LAYERS: "KKPRL:KKPRL_KALTIM_05_01_2023_FIX",
                        TILED: true,
                        FORMAT: "image/png",
                        TRANSPARENT: true,
                        TIMESTAMP: new Date().getTime(),
                        CQL_FILTER: "NAMOBJ='Zona Pelabuhan Umum'", // filter hanya data dengan attribute property table
                    },
                    serverType: "geoserver",
                    crossOrigin: "anonymous",
                }),
                visible: true,
                opacity: 0.8,
                zIndex: 20,
            }),
        ],
    });
    map.addLayer(kkp);
</script>
<?php $this->endSection() ?>

<?php $this->endSection() ?>