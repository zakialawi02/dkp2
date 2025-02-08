/**
 * Style for the measurement features.
 *
 * @type {module:ol/style/Style~Style}
 */
const measureStyle = new Style({
    fill: new Fill({
        color: "rgba(255, 255, 255, 0.2)",
    }),
    stroke: new Stroke({
        color: "rgba(0, 0, 0, 0.5)",
        lineDash: [10, 10],
        width: 2,
    }),
    image: new CircleStyle({
        radius: 5,
        stroke: new Stroke({
            color: "rgba(0, 0, 0, 0.7)",
        }),
        fill: new Fill({
            color: "rgba(255, 255, 255, 0.2)",
        }),
    }),
});

/**
 * Style for the measurement labels.
 *
 * @type {module:ol/style/Style~Style}
 * @const
 */
const labelMeasureStyle = new Style({
    text: new Text({
        font: "14px Calibri,sans-serif",
        fill: new Fill({
            color: "rgba(255, 255, 255, 1)",
        }),
        backgroundFill: new Fill({
            color: "rgba(0, 0, 0, 0.7)",
        }),
        padding: [3, 3, 3, 3],
        textBaseline: "bottom",
        offsetY: -15,
    }),
    image: new RegularShape({
        radius: 8,
        points: 3,
        angle: Math.PI,
        displacement: [0, 10],
        fill: new Fill({
            color: "rgba(0, 0, 0, 0.7)",
        }),
    }),
});

/**
 * Style for the measurement tips.
 *
 * @type {module:ol/style/Style~Style}
 */
const tipMeasureStyle = new Style({
    text: new Text({
        font: "12px Calibri,sans-serif",
        fill: new Fill({
            color: "rgba(255, 255, 255, 1)",
        }),
        backgroundFill: new Fill({
            color: "rgba(0, 0, 0, 0.4)",
        }),
        padding: [2, 2, 2, 2],
        textAlign: "left",
        offsetX: 15,
    }),
});

/**
 * Style for the measurement modification features.
 *
 * @type {module:ol/style/Style~Style}
 * @const
 */
const modifyMeasureStyle = new Style({
    image: new CircleStyle({
        radius: 5,
        stroke: new Stroke({
            color: "rgba(0, 0, 0, 0.7)",
        }),
        fill: new Fill({
            color: "rgba(0, 0, 0, 0.4)",
        }),
    }),
    text: new Text({
        text: "Drag to modify",
        font: "12px Calibri,sans-serif",
        fill: new Fill({
            color: "rgba(255, 255, 255, 1)",
        }),
        backgroundFill: new Fill({
            color: "rgba(0, 0, 0, 0.7)",
        }),
        padding: [2, 2, 2, 2],
        textAlign: "left",
        offsetX: 15,
    }),
});

/**
 * Style for the segment measurement features.
 *
 * @type {module:ol/style/Style~Style}
 */
const segmentMeasureStyle = new Style({
    text: new Text({
        font: "12px Calibri,sans-serif",
        fill: new Fill({
            color: "rgba(255, 255, 255, 1)",
        }),
        backgroundFill: new Fill({
            color: "rgba(0, 0, 0, 0.4)",
        }),
        padding: [2, 2, 2, 2],
        textBaseline: "bottom",
        offsetY: -12,
    }),
    image: new RegularShape({
        radius: 6,
        points: 3,
        angle: Math.PI,
        displacement: [0, 8],
        fill: new Fill({
            color: "rgba(0, 0, 0, 0.4)",
        }),
    }),
});

const segmentMeasureStyles = [segmentMeasureStyle];

/**
 * Vector source for the measure drawing.
 * @type {module:ol/source/Vector~VectorSource}
 */
const vectorSourceMeasure = new VectorSource();

/**
 * Modify interaction for the drawn features.
 * @type {module:ol/interaction/Modify~Modify}
 */
const modifyMeasure = new Modify({
    source: vectorSourceMeasure,
    style: modifyMeasureStyle,
});

/**
 * Vector layer for the measure drawing.
 * @type {module:ol/layer/Vector~VectorLayer}
 */
const vectorLayerMeasure = new VectorLayer({
    source: vectorSourceMeasure,
    style: function (feature) {
        return measureStyleFunction(feature, true);
    },
});

/**
 * Point used for displaying measurement tips.
 * @type {module:ol/geom/Point~Point}
 */
let measureTipPoint;

/**
 * Generate styles for the measure drawing and tips.
 * @param {module:ol/Feature~Feature} feature Feature to get the geometry from.
 * @param {boolean} [segments=false] Should the segment lengths be displayed.
 * @param {string} [drawType] Type of drawing. If not set, the type of the feature's geometry will be used.
 * @param {string} [tip] Tip text to be displayed when drawing.
 * @return {Array<module:ol/style/Style~Style>} An array of styles.
 */
function measureStyleFunction(feature, segments, drawType, tip) {
    const styles = [];
    const geometry = feature.getGeometry();
    const type = geometry.getType();
    let point, label, line;
    if (!drawType || drawType === type || type === "Point") {
        styles.push(measureStyle);
        if (type === "Polygon") {
            point = geometry.getInteriorPoint();
            label = formatArea(geometry);
            line = new LineString(geometry.getCoordinates()[0]);
        } else if (type === "LineString") {
            point = new Point(geometry.getLastCoordinate());
            label = formatLength(geometry);
            line = geometry;
        }
    }
    if (segments && line) {
        let count = 0;
        line.forEachSegment(function (a, b) {
            const segment = new LineString([a, b]);
            const label = formatLength(segment);
            if (segmentMeasureStyles.length - 1 < count) {
                segmentMeasureStyles.push(segmentMeasureStyle.clone());
            }
            const segmentPoint = new Point(segment.getCoordinateAt(0.5));
            segmentMeasureStyles[count].setGeometry(segmentPoint);
            segmentMeasureStyles[count].getText().setText(label);
            styles.push(segmentMeasureStyles[count]);
            count++;
        });
    }
    if (label) {
        labelMeasureStyle.setGeometry(point);
        labelMeasureStyle.getText().setText(label);
        styles.push(labelMeasureStyle);
    }
    if (tip && type === "Point" && !modifyMeasure.getOverlay().getSource().getFeatures().length) {
        measureTipPoint = geometry;
        tipMeasureStyle.getText().setText(tip);
        styles.push(tipMeasureStyle);
    }
    return styles;
}

map.addInteraction(modifyMeasure);

/**
 * Start measuring.
 * @param {string} [drawType="Polygon"] Draw type to use.
 *    Possible values are "Point", "LineString", "Polygon", "Circle".
 */
function measureStart(drawType = "Polygon") {
    map.getViewport().style.cursor = "crosshair";
    const activeTip = "Click to continue drawing the " + (drawType === "Polygon" ? "polygon" : "line");
    const idleTip = "Click to start measuring";
    let tip = idleTip;
    draw = new Draw({
        source: vectorSourceMeasure,
        type: drawType,
        style: function (feature) {
            return measureStyleFunction(feature, true, drawType, tip);
        },
    });
    draw.on("drawstart", function () {
        vectorSourceMeasure.clear();

        modifyMeasure.setActive(false);
        tip = activeTip;
    });
    draw.on("drawend", function () {
        modifyMeasureStyle.setGeometry(measureTipPoint);
        modifyMeasure.setActive(true);
        map.once("pointermove", function () {
            modifyMeasureStyle.setGeometry();
        });
        tip = idleTip;
        draw.setActive(false);
        map.getViewport().style.cursor = "grab";
    });
    modifyMeasure.setActive(true);
    map.addInteraction(draw);
    map.addLayer(vectorLayerMeasure);
}

function measureClear() {
    vectorSourceMeasure.clear();
    modifyMeasure.setActive(false);
}
