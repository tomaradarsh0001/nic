document.addEventListener('DOMContentLoaded', function () {
    var google = L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
        zIndex: 50,
        opacity: 1,
        maxZoom: 21,
        subdomains: ["mt0", "mt1", "mt2", "mt3"],
        attribution: '©DFW, Google 2023© <a href="" target="_blank"></a>',

    });

    var googlestreet = L.tileLayer('https://mt1.google.com/vt/lyrs=r&x={x}&y={y}&z={z}', {
        zIndex: 50,
        opacity: 1,
        maxZoom: 20,
        attribution: '© Google 2023© <a href="" target="_blank"></a>',

    });

    var blankMap = L.tileLayer('', { attribution: '' });

    var osmb = new OSMBuildings(map).load('https://{s}.data.osmbuildings.org/0.2/59fcc2e8/tile/{z}/{x}/{y}.json');



    //map   


    var map = L.map('map', {
        center: [28.635781888792277, 77.17983510997755],
        zoom: 21,
        minZoom: 8,
        scrollWheelZoom: true,
        dragging: true,
        doubleClickZoom: true,
        zoomControl: true,
        attributionControl: false,
        layers: [googlestreet],
        maxBounds: [
            [29.00708947145038, 76.64878806249736], // Southwest corner of the bounding box
            [28.363761223602285, 77.53999678065577]  // Northeast corner of the bounding box
        ]
    });


   /*  var
        now,
        date, time,
        timeRange, dateRange,
        timeRangeLabel, dateRangeLabel;

    function changeDate() {
        var Y = now.getFullYear(),
            M = now.getMonth(),
            D = now.getDate(),
            h = now.getHours(),
            m = 0;

        timeRangeLabel.innerText = pad(h) + ':' + pad(m);
        dateRangeLabel.innerText = Y + '-' + pad(M + 1) + '-' + pad(D);

        osmb.date(new Date(Y, M, D, h, m));
    }

    function onTimeChange() {
        now.setHours(this.value);
        now.setMinutes(0);
        changeDate();
    }

    function onDateChange() {
        now.setMonth(0);
        now.setDate(this.value);
        changeDate();
    }

    function pad(v) {
        return (v < 10 ? '0' : '') + v;
    }

    timeRange = document.getElementById('time');
    dateRange = document.getElementById('date');
    timeRangeLabel = document.querySelector('*[for=time]');
    dateRangeLabel = document.querySelector('*[for=date]');

    now = new Date;
    changeDate();

    // init with day of year
    var Jan1 = new Date(now.getFullYear(), 0, 1);
    dateRange.value = Math.ceil((now - Jan1) / 86400000);

    timeRange.value = now.getHours();

    timeRange.addEventListener('change', onTimeChange);
    dateRange.addEventListener('change', onDateChange);
    timeRange.addEventListener('input', onTimeChange);
    dateRange.addEventListener('input', onDateChange); */

    // Variable to store the current marker
    let currentMarkers = null;
    let currentMarker = null; // Variable to hold the currentmarkera
    // Define the custom icon
    const customIcon = L.icon({
        iconUrl: 'assets/MIS_V5.1/Logo/steet_view.png',
        iconSize: [38, 38],
        iconAnchor: [19, 38],
        popupAnchor: [0, -38]
    });

    // Initialize marker with Street View link
    const initialMarker = L.marker([28.635781888792277, 77.17983510997755], { icon: customIcon })
        .bindPopup(
            '<div style="text-align: center;">' +

            '<a href="http://maps.google.com/maps?q=&layer=c&cbll=28.635781888792277,77.17983510997755&cbp=11,0,0,0,0" target="_blank">' +
            '<b style="color: blue; text-decoration: underline; font-family: \'Times New Roman\', Times, serif;">Google Street View</b></a><br>' +
            '<a href="https://www.google.com/maps/dir/?api=1&destination=28.635781888792277,77.17983510997755" target="_blank">' +
            '<b style="color: green; text-decoration: underline; font-family: \'Times New Roman\', Times, serif;">Navigate to this location</b></a>' +
            '</div>'
        )
        .openPopup();

    map.on('click', function (e) { 
        let lat = e.latlng.lat.toPrecision(8);
        let lon = e.latlng.lng.toPrecision(8);

        // Remove the previous marker if it exists
        if (currentMarkers) {
            map.removeLayer(currentMarkers);
        }

        // Add new marker with updated popup containing both links
        currentMarkers = L.marker([lat, lon], { icon: customIcon }).addTo(map)
            .bindPopup(
                '<div style="text-align: center;">' +

                '<a href="http://maps.google.com/maps?q=&layer=c&cbll=' + lat + ',' + lon + '&cbp=11,0,0,0,0" target="_blank">' +
                '<b style="color: blue; text-decoration: underline; font-family: \'Times New Roman\', Times, serif;">Google Street View</b></a><br>' +
                '<a href="https://www.google.com/maps/dir/?api=1&destination=' + lat + ',' + lon + '" target="_blank">' +
                '<b style="color: green; text-decoration: underline; font-family: \'Times New Roman\', Times, serif;">Navigate to this location</b></a>' +
                '</div>'
            )
            .openPopup();
    });



    L.control.scale({
        maxWidth: 100,
        imperial: false,
        position: 'bottomleft'
    }).addTo(map);


    // Geocode(Deb)
    var geocoder = L.Control.geocoder({
        query: "",
        placeholder: "Search your location",
        defaultMarkGeocode: false,
        position: 'topleft'
    }).addTo(map);

    var marker = null;

    // Function to remove the marker
    function removeMarker() {
        if (marker) {
            map.removeLayer(marker);
            marker = null;
        }
    }

    geocoder.on('markgeocode', function (event) {
        var latlng = event.geocode.center;

        removeMarker();

        marker = L.marker(latlng).addTo(map);
        marker.bindPopup(event.geocode.name).openPopup();

        map.setView(latlng, 15);
    });

    // Add an event listener to the "Delete Location Marker" button
    document.getElementById('trash').addEventListener('click', function () {
        removeMarker();
    });







    // Geolocation
    L.control.locate({
        position: "topleft"
    }).addTo(map);







   // Define styles for different properties (Debobrata Sadhukhan)
   var freeHoldStyle = {
    color: "#006599",
    weight: 2,
    opacity: 1,
    fillOpacity: 0.7
};

var leaseHoldStyle = {
    color: "#f0ad4e",
    weight: 2,
    opacity: 1,
    fillOpacity: 0.7
};

// Function to determine the style
function getStyle(feature) {
    switch (feature.properties.status) {
        case 'Free Hold':
            return freeHoldStyle;
        case 'Lease Hold':
            return leaseHoldStyle;
        default:
            return {
                color: "grey",
                weight: 2,
                opacity: 1,
                fillOpacity: 0.7
            };
    }
}

// Define the GeoJSON layer with the style
var property = L.geoJSON(pro, {
    style: getStyle,

    onEachFeature: function (feature, layer) {
        var tooltipContent = `
                                                    <div>
                                                        <strong>Property No.:</strong> ${feature.properties.old_propert_id || '****'}<br>
                                                        <strong>Address:</strong> ${feature.properties.address || '****'}<br>
                                                    </div>
                                                `;
        layer.bindTooltip(tooltipContent, {
            permanent: false, // Tooltip only shows on hover
            direction: "top", // Position the tooltip above the feature
            className: "custom-tooltip" // Optional: Add a custom class for styling
        });

        // Handle click event on the GeoJSON layer
        layer.on('click', function () {
            var properties = feature.properties;
            $('#property-table').empty();
            $('#property-table').append(`
                <tr>
                    <td>Property No:</td>
                    <td>${properties.old_propert_id || '****'}</td>
                    <td>Unique Property ID:</td>
                    <td>${properties.unique_propert_id || '****'}</td>
                </tr>
                <tr>
                    <td>Locality Name:</td>
                    <td>${properties.loacalityn || '****'}</td>
                    <td>Status:</td>
                    <td>${properties.status || '****'}</td>
                </tr>
                <tr>
                    <td>Land Use:</td>
                    <td>${properties.land_use || '****'}</td>
                    <td>Area (Sqmts):</td>
                    <td>${properties.area_in_sqm || '****'}</td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td>${properties.address || '****'}</td>
                    <td>Lessee Name:</td>
                    <td>${properties.lesse_name || '****'}</td>
                </tr>
                <tr>
                    <td>Land Type:</td>
                    <td>${properties.land_type || '****'}</td>
                    <td>Lease Tenure:</td>
                    <td>${properties.lease_tenure || '****'}</td>
                </tr>
            `);

            $('#floating-table').show();
        });
    }
}).addTo(map);

// Fit the map to the layer bounds
map.fitBounds(property.getBounds());


pro.features.forEach(feature => {
    var oldPropertyId = feature.properties?.old_propert_id || '****';
    var address = feature.properties?.address || 'No Address';
    var addressPart = address.includes('/')
        ? address.split('/').slice(0, 2).join('/')
        : address;
    feature.properties.label = `${oldPropertyId} - ${addressPart}`; // Add a new label property
});

// Initialize the labeler with the new property
var propertyLabeler = L.labeler(pro, {
    labelProp: 'label', // Use the dynamically added property
    labelPos: 'cc',
    labelStyle: {
        fontWeight: 'bold',
        whiteSpace: 'normal',
        minWidth: '60px',
        textAlign: 'center',
        color: 'black',
        fontFamily: 'Times New Roman',
        fontSize: '8px'
    },
    style: { opacity: 0.0 },
    onEachFeature: function (feature, layer) {
        var tooltipContent = `
                                                    <div>
                                                        <strong>Property No.:</strong> ${feature.properties.old_propert_id || '****'}<br>
                                                        <strong>Address:</strong> ${feature.properties.address || '****'}<br>
                                                    </div>
                                                `;

        layer.bindTooltip(tooltipContent);
        layer.on('click', function () {
            var properties = feature.properties;
            $('#property-table').empty();
            $('#property-table').append(`
        <tr>
            <td>Property No:</td>
            <td>${properties.old_propert_id || '****'}</td>
            <td>Unique Property ID:</td>
            <td>${properties.unique_propert_id || '****'}</td>
        </tr>
        <tr>
            <td>Locality Name:</td>
            <td>${properties.loacalityn || '****'}</td>
            <td>Status:</td>
            <td>${properties.status || '****'}</td>
        </tr>
        <tr>
            <td>Land Use:</td>
            <td>${properties.land_use || '****'}</td>
            <td>Area (Sqmts):</td>
            <td>${properties.area_in_sqm || '****'}</td>
        </tr>
        <tr>
            <td>Adress:</td>
            <td>${properties.address || '****'}</td>
            <td>Lessee Name:</td>
            <td>${properties.lesse_name || '****'}</td>
        </tr>
        <tr>
            <td>Land Type:</td>
            <td>${properties.land_type || '****'}</td>
            <td>Lease Tenure:</td>
            <td>${properties.lease_tenure || '****'}</td>
        </tr>
    `);

            $('#floating-table').show();
        });
    }
});

// Function to show/hide the spinner
function toggleSpinner(show) {
    if (show) {
        $('#spinner').show();
    } else {
        $('#spinner').hide();
    }
}

function toggleLabels() {
    var currentZoom = map.getZoom();
    toggleSpinner(true); // Show spinner

    if (map.hasLayer(property) && currentZoom > 19) {
        map.addLayer(propertyLabeler);
    } else {
        map.removeLayer(propertyLabeler);
    }

    toggleSpinner(false); // Hide spinner
}

map.on('zoomend', toggleLabels);
toggleLabels();

// Add event listeners for layer add/remove events
map.on('layeradd', function (e) {
    if (e.layer === property) {
        toggleLabels();
    }
});

map.on('layerremove', function (e) {
    if (e.layer === property) {
        toggleLabels(); // Ensure spinner shows/hides correctly
    }
});

map.on('movestart', function () {
    toggleSpinner(true); // Show spinner when starting to move
});

map.on('moveend', function () {
    toggleSpinner(false); // Hide spinner when moving ends
});

// Also show the spinner when tiles are loading
map.on('loading', function () {
    toggleSpinner(true);
});

map.on('load', function () {
    toggleSpinner(false);
});







    // let h0 = L.hatchClass(['blue','none'],4); // strokeWidth: 6, angle: 45 degrees
    // function hatch(feature) {
    //     let p= feature.properties.Name;
    //     return { className: Name=h0, fillOpacity: 0.3, color: 'red', opacity: 0.6, weight: 1 };
    // }
    // // Apply L.geoJSON with hatch pattern and labels
    // var leases = L.geoJSON(lease, {
    //     onEachFeature: function (feature, layer) {
    //         var tooltipContent = `
    //                                                         <div>
    //                                                             <strong>Lease Section I:</strong> ${feature.properties.Name || '****'}<br>
    //                                                         </div>
    //                                                     `;

    //                     layer.bindTooltip(tooltipContent);
    //         // Bind popup with dynamic content based on properties
    //         if (feature.properties && feature.properties.Name) {
    //             layer.bindPopup(`<b>Name:</b> ${feature.properties.Name}`);
    //         }

    //         // // Optional: Add label to the feature if needed (permanent labels centered on the polygon)
    //         // if (feature.properties && feature.properties.Name) {
    //         //     layer.bindTooltip(feature.properties.Name, { 
    //         //         permanent: true, 
    //         //         direction: 'center', 
    //         //         className: 'leaflet-tooltip'  // Optional: custom class for styling tooltip
    //         //     });
    //         // }
    //     },
    //     style: hatch

    // }).addTo(map);



    // Define hatch patterns with improved colors and stroke width
    let h0 = L.hatchClass(['lightblue', 'none'], 4);  // Lease Section (Light Blue)
    let h1 = L.hatchClass(['orange', 'none'], 4);  // Property Section I (Orange)
    let h2 = L.hatchClass(['lightgreen', 'none'], 4); // Property Section II (Light Green)
    let h3 = L.hatchClass(['darkblue', 'none'], 4);  // Property Section III (Dark Blue)

    // Function to return style for 'Lease' sections
    function hatch0(feature) {
        let p0 = feature.properties.Name;
        return {
            className: Name = h0,
            fillOpacity: 0.1,
            color: 'brown',
            opacity: 1,
            weight: 3
        };
    }

    // Function to return style for 'Property Section I'
    function hatch1(feature) {
        let p1 = feature.properties.Name;
        return {
            className: Name = h1,
            fillOpacity: 0.3,
            color: 'green',
            opacity: 1,
            weight: 2
        };
    }

    // Function to return style for 'Property Section II'
    function hatch2(feature) {
        let p2 = feature.properties.Name;
        return {
            className: Name = h2,
            fillOpacity: 0.3,
            color: '#ab47bc',
            opacity: 1,
            weight: 2
        };
    }

    // Function to return style for 'Property Section III'
    function hatch3(feature) {
        let p3 = feature.properties.Name;
        return {
            className: Name = h3,
            fillOpacity: 0.3,
            color: 'blue',
            opacity: 1,
            weight: 2
        };
    }

    // Apply L.geoJSON with hatch pattern and tooltips for 'Lease'
    var leases = L.geoJSON(lease, {
        onEachFeature: function (feature, layer) {
            var tooltipContent = `
            <div>
                <strong>Lease Section I:</strong> ${feature.properties.Name || '****'}<br>
            </div>
        `;
            layer.bindTooltip(tooltipContent);
            if (feature.properties && feature.properties.Name) {
                layer.bindPopup(`<b>Name:</b> ${feature.properties.Name}`);
            }
        },
        style: hatch0 // Use hatch pattern 0 for Lease
    });

    // Apply L.geoJSON with hatch pattern and tooltips for 'Property Section I'
    var ps_I = L.geoJSON(ps_i, {
        onEachFeature: function (feature, layer) {
            var tooltipContent = `
            <div>
                <strong>Property Section I:</strong> ${feature.properties.Name || '****'}<br>
            </div>
        `;
            layer.bindTooltip(tooltipContent);
            if (feature.properties && feature.properties.Name) {
                layer.bindPopup(`<b>Name:</b> ${feature.properties.Name}`);
            }
        },
        style: hatch1 // Use hatch pattern 1 for Property Section I
    });

    // Apply L.geoJSON with hatch pattern and tooltips for 'Property Section II'
    var pss_II = L.geoJSON(ps_II, {
        onEachFeature: function (feature, layer) {
            var tooltipContent = `
            <div>
                <strong>Property Section II:</strong> ${feature.properties.Name || '****'}<br>
            </div>
        `;
            layer.bindTooltip(tooltipContent);
            if (feature.properties && feature.properties.Name) {
                layer.bindPopup(`<b>Name:</b> ${feature.properties.Name}`);
            }
        },
        style: hatch2 // Use hatch pattern 2 for Property Section II
    });

    // Apply L.geoJSON with hatch pattern and tooltips for 'Property Section III'
    var pss_III = L.geoJSON(ps_III, {
        onEachFeature: function (feature, layer) {
            var tooltipContent = `
            <div>
                <strong>Property Section III:</strong> ${feature.properties.Name || '****'}<br>
            </div>
        `;
            layer.bindTooltip(tooltipContent);
            if (feature.properties && feature.properties.Name) {
                layer.bindPopup(`<b>Name:</b> ${feature.properties.Name}`);
            }
        },
        style: hatch3 // Use hatch pattern 3 for Property Section III
    });

    var lbz = L.geoJSON(lbz_d, {
        onEachFeature: function (feature, layer) {
            var tooltipContent = `
            <div>
                <strong>LS-I Plot No(LBZ Zone):</strong> ${feature.properties.Bungalow_N || '****'}<br>
            </div>
        `;
            layer.bindTooltip(tooltipContent);
            if (feature.properties && feature.properties.Bungalow_N) {
                layer.bindPopup(`<b>Name:</b> ${feature.properties.Bungalow_N}`);
            }
        },
        style: {
            color: "#FF5F1F",
            weight: 2,
            opacity: 1,
            fillOpacity: 0.3
        },

    });



    var del = L.geoJSON(delhi, {
        style: {
            color: "#FF5F1F", // Orange color
            weight: 2, // Line thickness
            opacity: 1, // Line opacity
            fillOpacity: 0.0, // Polygon fill opacity
            dashArray: "4 4" // Dotted line pattern (4px dash, 4px gap)
        },
    }).addTo(map);


    var lbz_gb = L.geoJSON(lbzb, {
        style: {
            color: "green", // Orange color
            weight: 2, // Line thickness
            opacity: 1, // Line opacity
            fillOpacity: 0.0, // Polygon fill opacity
            dashArray: "4 4" // Dotted line pattern (4px dash, 4px gap)
        },
    });



    // labeler 
  /*   var propertyLabeler = L.labeler(pro, {
        labelProp: 'old_propert_id',
        labelPos: 'cc',
        labelStyle: { fontWeight: 'bold', whiteSpace: 'normal', minWidth: '60px', textAlign: 'center', color: 'black', fontFamily: 'Times New Roman', fontSize: '12px' },
        style: { opacity: 0.0 },
        onEachFeature: function (feature, layer) {
            var tooltipContent = `
                                                        <div>
                                                            <strong>Property No.:</strong> ${feature.properties.old_propert_id || '****'}<br>
                                                        </div>
                                                    `;

            layer.bindTooltip(tooltipContent);
            layer.on('click', function () {
                var properties = feature.properties;
                $('#property-table').empty();
                $('#property-table').append(`
            <tr>
                <td>Property No:</td>
                <td>${properties.old_propert_id || '****'}</td>
                <td>Unique Property ID:</td>
                <td>${properties.unique_propert_id || '****'}</td>
            </tr>
            <tr>
                <td>Locality Name:</td>
                <td>${properties.loacalityn || '****'}</td>
                <td>Status:</td>
                <td>${properties.status || '****'}</td>
            </tr>
            <tr>
                <td>Land Use:</td>
                <td>${properties.land_use || '****'}</td>
                <td>Area (Sqmts):</td>
                <td>${properties.area_in_sqm || '****'}</td>
            </tr>
            <tr>
                <td>Adress:</td>
                <td>${properties.address || '****'}</td>
                <td>Lessee Name:</td>
                <td>${properties.lesse_name || '****'}</td>
            </tr>
            <tr>
                <td>Land Type:</td>
                <td>${properties.land_type || '****'}</td>
                <td>Lease Tenure:</td>
                <td>${properties.lease_tenure || '****'}</td>
            </tr>
        `);

                $('#floating-table').show();
            });
        }
    });

    // Function to show/hide the spinner
    function toggleSpinner(show) {
        if (show) {
            $('#spinner').show();
        } else {
            $('#spinner').hide();
        }
    }

    function toggleLabels() {
        var currentZoom = map.getZoom();
        toggleSpinner(true); // Show spinner

        if (map.hasLayer(property) && currentZoom > 19) {
            map.addLayer(propertyLabeler);
        } else {
            map.removeLayer(propertyLabeler);
        }

        toggleSpinner(false); // Hide spinner
    }

    map.on('zoomend', toggleLabels);
    toggleLabels();

    // Add event listeners for layer add/remove events
    map.on('layeradd', function (e) {
        if (e.layer === property) {
            toggleLabels();
        }
    });

    map.on('layerremove', function (e) {
        if (e.layer === property) {
            toggleLabels(); // Ensure spinner shows/hides correctly
        }
    });

    map.on('movestart', function () {
        toggleSpinner(true); // Show spinner when starting to move
    });

    map.on('moveend', function () {
        toggleSpinner(false); // Hide spinner when moving ends
    });

    // Also show the spinner when tiles are loading
    map.on('loading', function () {
        toggleSpinner(true);
    });

    map.on('load', function () {
        toggleSpinner(false);
    });

 */


    var property_v = L.geoJSON(vacant, {
        style: {
            color: "Red",
            weight: 2,
            opacity: 1,
            fillOpacity: 0.3
        },

        onEachFeature: function (feature, layer) {
            var tooltipContent = `
        <div>
            <strong>Vacant Land Name:</strong> ${feature.properties.Name}<br>
            <strong>Area (Sqmts):</strong> ${feature.properties.Area.toFixed(2)}
        </div>
    `;

            layer.bindTooltip(tooltipContent);


            // Handle click event
            layer.on('click', function () {
                var properties = feature.properties;
                $('#property-table').empty();
                $('#property-table').append(`
            <tr>
                <td>Vacant Land Name:</td>
                <td>${properties.Name}</td>
                <td>Area (Sqmts):</td>
                <td>${properties.Area.toFixed(2)}</td>
            </tr>
        `);
                $('#floating-table').show();
            });
        },
    });







    //Feature tool to select
    // Create a draw control
    var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);
    // Create a draw control
    var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    var drawControl = new L.Control.Draw({
        edit: {
            featureGroup: drawnItems
        },
        draw: {
            polygon: true,
            polyline: false,
            rectangle: false,
            circle: false,
            marker: false,
            CircleMarker: false
        }
    });

    //// Variable to track if drawControl is active
    var drawControlActive = false;

    // Function to toggle the draw control
    function toggleDrawControl() {
        if (drawControlActive) {
            map.removeControl(drawControl); // Remove draw control
            drawControlActive = false; // Update state
        } else {
            map.addControl(drawControl); // Add draw control
            drawControlActive = true; // Update state
        }
    }

    // Add event listener for the button click
    document.getElementById('toggle-draw').addEventListener('click', function () {
        toggleDrawControl();
    });

    // Declare selectedProperties and selectedVacants outside the function
    var selectedProperties = [];
    var selectedVacants = [];
    map.on('draw:created', function (event) {
        var layer = event.layer; // The drawn layer (polygon)
        drawnItems.addLayer(layer); // Add the drawn layer to a LayerGroup
        var drawnPolygon = layer.toGeoJSON(); // Convert the drawn layer to GeoJSON

        // Clear previous selections
        selectedProperties = [];
        selectedVacants = [];

        // Function to check intersections and add results
        function checkIntersections(layerGroup, type) {
            layerGroup.eachLayer(function (featureLayer) {
                var feature = featureLayer.feature; // Access the feature
                console.log(`Checking ${type} feature:`, feature);

                // Check if the feature's geometry intersects with the drawn polygon
                if (turf.booleanIntersects(feature.geometry, drawnPolygon.geometry)) {
                    // Add to the results with type
                    const coordinates = feature.geometry.coordinates;
                    if (type === 'property') {
                        selectedProperties.push({
                            ...feature.properties,
                            latitude: coordinates[0][0][1], // Adjust as needed for your geometry
                            longitude: coordinates[0][0][0], // Adjust as needed for your geometry
                            type: 'Property'
                        });
                    } else {
                        selectedVacants.push({
                            ...feature.properties,
                            latitude: coordinates[0][0][1], // Adjust as needed for your geometry
                            longitude: coordinates[0][0][0], // Adjust as needed for your geometry
                            type: 'Vacant'
                        });
                    }
                    console.log(`${type} intersects:`, feature.properties);
                } else {
                    console.log(`${type} does not intersect:`, feature.properties);
                }
            });
        }

        // Check for intersections with both properties and vacant lands
        checkIntersections(property, 'property');
        checkIntersections(property_v, 'vacant');

        // Log the final selected properties and vacants
        console.log('Final Selected Properties:', selectedProperties);
        console.log('Final Selected Vacants:', selectedVacants);

        // Show the results in a modal
        showResultsInModal(selectedProperties, selectedVacants);

        // Remove the drawn polygon layer after showcasing the modal
        drawnItems.removeLayer(layer);
    });

    function showResultsInModal(selectedProperties, selectedVacants) {
        console.log('Incoming Selected Properties:', selectedProperties);
        console.log('Incoming Selected Vacants:', selectedVacants);

        $('#modal-content').empty(); // Clear previous content

        // Combine properties and vacants into a single array
        const combinedResults = [...selectedProperties, ...selectedVacants];

        // Calculate total count
        var totalCounts = combinedResults.length;
        console.log('Total count of selected features:', totalCounts);

        // Pagination setup
        var itemsPerPage = 15;
        var currentPage = 1;
        var totalPages = Math.ceil(totalCounts / itemsPerPage);

        // Function to display a specific page
        function displayPage(page) {
            $('#modal-content').empty();  // Clear modal content

            // Re-add total count to the top every time the page is displayed
            $('#modal-content').prepend(`
            <div class="total-count" style="font-weight: bold; margin-bottom: 10px;">
                Total Count of Selected Features: ${totalCounts}
            </div>
        `);

            // Calculate start and end indices for slicing the array
            var start = (page - 1) * itemsPerPage;
            var end = Math.min(start + itemsPerPage, totalCounts); // Ensure no overflow on the last page

            console.log(`Displaying page ${page} with items from ${start} to ${end}`);

            // Slice the combined results array for the current page and display
            combinedResults.slice(start, end).forEach(function (item) {
                if (item.type === 'Property') {
                    $('#modal-content').append(`
                    <div class="modal-row property-row" 
                         data-lat="${item.latitude}" 
                         data-lng="${item.longitude}" 
                         style="border-bottom: 1px solid #ccc; padding: 10px;">
                        <strong>Property ID:</strong> ${item.old_propert_id}<br>
                        <strong>Lesse Name:</strong> ${item.lesse_name|| '****'}<br>
                        <strong>Locality:</strong> ${item.loacalityn}<br>
                        <strong>Address:</strong> ${item.address|| '****'}<br>
                        <button class="btn btn-info view-button" data-lat="${item.latitude}" data-lng="${item.longitude}">View</button>
                    </div>
                `);
                } else if (item.type === 'Vacant') {
                    $('#modal-content').append(`
                    <div class="modal-row vacant-row" 
                         data-lat="${item.latitude}" 
                         data-lng="${item.longitude}" 
                         style="border-bottom: 1px solid #ccc; padding: 10px;">
                        <strong>Vacant Land Name:</strong> ${item.Name}<br>
                        <strong>Area (Sqmts):</strong> ${item.Area.toFixed(2)}<br>
                        <button class="btn btn-info view-button" data-lat="${item.latitude}" data-lng="${item.longitude}">View</button>
                    </div>
                `);
                }
            });

            // Update pagination buttons
            $('#paginations').empty();  // Clear previous pagination controls

            // Previous button
            if (page > 1) {
                $('#paginations').append(`<button class="page-button btn btn-sm btn-outline-primary" data-page="${page - 1}">Previous</button>`);
            } else {
                $('#paginations').append(`<button class="btn btn-sm btn-outline-secondary" disabled>Previous</button>`);
            }

            // Page number buttons
            for (let i = 1; i <= totalPages; i++) {
                $('#paginations').append(`
                <button class="page-button btn btn-sm ${i === page ? 'btn-primary' : 'btn-outline-primary'}" data-page="${i}">
                    ${i}
                </button>
            `);
            }

            // Next button
            if (page < totalPages) {
                $('#paginations').append(`<button class="page-button btn btn-sm btn-outline-primary" data-page="${page + 1}">Next</button>`);
            } else {
                $('#paginations').append(`<button class="btn btn-sm btn-outline-secondary" disabled>Next</button>`);
            }

            // Rebind pagination buttons to click event
            bindPaginationEvents();
        }

        // Function to bind pagination buttons
        function bindPaginationEvents() {
            $('.page-button').off('click');  // Unbind any previous event to avoid duplication
            $('.page-button').on('click', function () {
                var page = $(this).data('page');
                if (page) {
                    currentPage = page;  // Update current page
                    displayPage(currentPage);  // Load the selected page
                }
            });
        }

        // Initial call to display the first page
        displayPage(currentPage);

        // After displaying the content, bind the view button events
        bindViewButtonClickEvents();

        console.log('Modal Content Before Show:', $('#modal-content').html());
        if ($('#modal-content').children().length === 0) {
            console.warn('No content found in modal content before showing.');
        }
        $('#myModal').modal('show'); // Show the modal
    }

    // Function to bind view button click events
    function bindViewButtonClickEvents() {
        $('.view-button').off('click').on('click', function () {
            var lat = $(this).data('lat');
            var lng = $(this).data('lng');

            // Check if coordinates are valid
            if (lat !== 'N/A' && lng !== 'N/A') {
                map.setView([lat, lng], 18); // Zoom to feature location

                // Hide the modal
                $('#myModal').modal('hide'); // Hide the modal here
            } else {
                console.warn('Invalid coordinates for view:', lat, lng);
            }
        });
    }

    // Store the markers to be able to remove them later
    var markers = [];

    // Function to bind row click events
    function bindRowClickEvents() {
        // Row click event to zoom and highlight
        $('#modal-content').off('click', '.modal-row').on('click', '.modal-row', function () {
            var lat = $(this).data('lat');
            var lng = $(this).data('lng');

            // Check if lat and lng are valid
            if (lat !== 'N/A' && lng !== 'N/A') {
                // Zoom to feature location
                map.setView([lat, lng], 18); // Adjust zoom level as needed

                // Clear previous markers from the map
                markers.forEach(marker => map.removeLayer(marker));
                markers = []; // Clear the array

                // Create a new marker
                var marker = L.marker([lat, lng]).addTo(map).bindPopup('Selected Feature').openPopup();
                markers.push(marker); // Store marker for later removal
            } else {
                console.warn('Invalid coordinates for zoom:', lat, lng);
            }
        });
    }

    // Function to remove the current marker
    function removeCurrentMarkers() {
        if (markers.length > 0) {
            var currentMarker = markers.pop(); // Get the last added marker
            map.removeLayer(currentMarker); // Remove it from the map
            console.log('Current marker removed');
        } else {
            console.warn('No markers to remove');
        }
    }

    // Call this function to bind click events
    bindRowClickEvents();
    // bindViewButtonClickEvents();

    // Add an event listener to the "Delete Location Marker" button
    document.getElementById('trash').addEventListener('click', function () {
        removeCurrentMarkers();
    });

//Filter module Layer
    // Variable to track the filtered layer
    var dynamicLayer = null;

    // Function to keep track of active layers
    var activeLayers = {};
    // Store the filtered features globally for pagination
    var filteredFeatures = [];

    function displayPaginatedData(page) {
        var itemsPerPage = 10;
        var totalItems = filteredFeatures.length;
        var totalPages = Math.ceil(totalItems / itemsPerPage);

        // Calculate the start and end indices for slicing
        var startIndex = (page - 1) * itemsPerPage;
        var endIndex = Math.min(startIndex + itemsPerPage, totalItems);

        // Clear the table body
        $('#filteredDataTable tbody').empty();

        // Add the paginated data to the table
        for (var i = startIndex; i < endIndex; i++) {
            var feature = filteredFeatures[i];
            var rowContent = `
            <tr class="feature-row" data-index="${i}">
                <td>${i + 1}</td>
                <td>${feature.properties.old_propert_id || feature.properties.Name || '****'}</td>
                <td>${feature.properties.unique_propert_id || feature.properties.Area?.toFixed(2)}</td>
                <td>${feature.properties.address || 'L&DO' || '****'}</td>
                <td>${feature.properties.lesse_name || 'L&DO' || '****'}</td>
            </tr>
        `;
            $('#filteredDataTable tbody').append(rowContent);
        }

        // Update pagination controls
        updatePaginationControls(page, totalPages);

        // Add click event listener to each row for zooming to the feature and showing property details
        $('.feature-row').on('click', function () {
            var featureIndex = $(this).data('index');
            var feature = filteredFeatures[featureIndex];
            var coordinates = feature.geometry.coordinates;

            // Remove existing highlight from any previous feature
            if (dynamicLayer) {
                dynamicLayer.resetStyle();
            }

            // Assuming your GeoJSON data uses the standard [longitude, latitude] format
            if (feature.geometry.type === 'Point') {
                var latlng = [coordinates[1], coordinates[0]];
                map.setView(latlng, 18);  // Zoom to the point with a high zoom level
                highlightFeature(feature);  // Highlight the feature
            } else if (feature.geometry.type === 'Polygon' || feature.geometry.type === 'MultiPolygon') {
                var bounds = L.geoJSON(feature).getBounds();
                map.fitBounds(bounds);  // Fit the map to the bounds of the polygon
                highlightFeature(feature);  // Highlight the feature
            }

            // Display details in the floating table based on layer type (vacant land or property)
            $('#property-table').empty();
            if (feature.properties.Name) {  // Vacant land
                $('#property-table').append(`
                <tr>
                    <td>Vacant Land Name:</td>
                    <td>${feature.properties.Name}</td>
                    <td>Area (Sqmts):</td>
                    <td>${feature.properties.Area.toFixed(2)}</td>
                </tr>
            `);
            } else {  // Property
                $('#property-table').append(`
                <tr>
                    <td>Property No:</td>
                    <td>${feature.properties.old_propert_id || '****'}</td>
                    <td>Unique Property ID:</td>
                    <td>${feature.properties.unique_propert_id || '****'}</td>
                </tr>
                <tr>
                    <td>Locality Name:</td>
                    <td>${feature.properties.loacalityn || '****'}</td>
                    <td>Status:</td>
                    <td>${feature.properties.status || '****'}</td>
                </tr>
                <tr>
                    <td>Land Use:</td>
                    <td>${feature.properties.land_use || '****'}</td>
                    <td>Area (Sqmts):</td>
                    <td>${feature.properties.area_in_sqm || '****'}</td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td>${feature.properties.address || '****'}</td>
                    <td>Lessee Name:</td>
                    <td>${feature.properties.lesse_name || '****'}</td>
                </tr>
                <tr>
                    <td>Land Type:</td>
                    <td>${feature.properties.land_type || '****'}</td>
                    <td>Lease Tenure:</td>
                    <td>${feature.properties.lease_tenure || '****'}</td>
                </tr>
            `);
            }

            // Show the floating table
            $('#floating-table').show();

            // Close the modal
            $('#filteredDataModal').modal('hide');
        });
    }

    // Function to highlight the feature in green
    function highlightFeature(feature) {
        if (!dynamicLayer) return;

        // Loop through the layers and find the feature to highlight
        dynamicLayer.eachLayer(function (layer) {
            if (layer.feature === feature) {
                layer.setStyle({
                    color: 'green',
                    weight: 3,
                    opacity: 1,
                    fillOpacity: 0.6
                });
            }
        });
    }
    // Function to update pagination controls (limited to 10 visible pages at a time)
    function updatePaginationControls(currentPage, totalPages) {
        var pagination = $('#pagination .pagination');
        pagination.empty(); // Clear existing pagination

        var maxVisiblePages = 10;
        var startPage = Math.floor((currentPage - 1) / maxVisiblePages) * maxVisiblePages + 1;
        var endPage = Math.min(startPage + maxVisiblePages - 1, totalPages);

        // Previous button
        pagination.append(`
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a>
        </li>
    `);

        // Page number buttons (only show up to 10 at a time)
        for (var i = startPage; i <= endPage; i++) {
            pagination.append(`
            <li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>
        `);
        }

        // Next button
        pagination.append(`
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${currentPage + 1}">Next</a>
        </li>
    `);

        // Event listener for page links
        $('#pagination .page-link').on('click', function (e) {
            e.preventDefault();
            var selectedPage = parseInt($(this).data('page'));
            if (selectedPage > 0 && selectedPage <= totalPages) {
                displayPaginatedData(selectedPage);
            }
        });
    }

    // Show modal with filtered data and pagination
    function showFilteredDataInModal(filteredData) {
        filteredFeatures = filteredData;  // Store filtered features globally
        $('#filteredCount').text(`Total Records: ${filteredFeatures.length}`); // Update count
        displayPaginatedData(1);  // Show the first page initially
        $('#filteredDataModal').modal('show');  // Show the modal
    }
// Variable to store active layers
var activeLayers = {};

// Function to hide all other layers except the filtered one
function hideOtherLayers() {
    // Clear the activeLayers object before storing
    activeLayers = {};

    // Loop through all layers and store the active ones
    map.eachLayer(function (layer) {
        for (var name in overlayMaps) {
            if (overlayMaps[name] === layer && layer !== dynamicLayer) {
                activeLayers[name] = layer; // Store the active layer
                map.removeLayer(layer); // Remove the layer from the map
            }
        }
    });

    console.log("Stored Active Layers:", activeLayers); // Debugging log
}

// Function to restore previously active layers when the filtered layer is removed
function restorePreviousLayers() {
    for (var name in activeLayers) {
        if (activeLayers[name]) {
            map.addLayer(activeLayers[name]); // Re-add each previously active layer to the map
        }
    }
    console.log("Restored Active Layers:", activeLayers); // Debugging log
    activeLayers = {}; // Clear the activeLayers list after restoration
}

// Function to remove the old control layer
function removeControlLayer() {
    if (controlLayers) {
        map.removeControl(controlLayers); // Remove the current control layers
    }
}

// Function to refresh the control layers dynamically
function refreshControlLayer() {
    removeControlLayer(); // Ensure previous control layer is removed

    // Rebuild control layers with updated overlayMaps and baseMaps
    controlLayers = L.control.layers(baseMaps, overlayMaps, {
        position: 'bottomleft', // Adjust position if needed
        collapsed: true, // Set to false if you want the control expanded by default
    }).addTo(map);
}

function filterFeatures(layerType, attribute, condition, value) {
    // Clear the previous filtered layer
    if (dynamicLayer) {
        map.removeLayer(dynamicLayer);
        delete overlayMaps['Filtered Layer'];
        removeControlLayer();
        restorePreviousLayers();
    }

    // Preprocess the input value
    var normalizedValue = preprocessSearchQuery(value);

    // Filter the features based on the condition
    var layerData = layerType === 'property' ? pro : vacant;
    filteredFeatures = layerData.features
        .map(feature => {
            var featureValue = feature.properties[attribute];
            if (!featureValue) return null;

            // Preprocess the feature value
            var normalizedFeatureValue = preprocessSearchQuery(featureValue.toString());

            switch (condition) {
                case 'like':
                    // Split both values into tokens
                    var searchTokens = normalizedValue.split(/\s+/);
                    var featureTokens = normalizedFeatureValue.split(/\s+/);

                    // Exact match for the first token, partial for the rest
                    var exactMatch = featureTokens[0] === searchTokens[0];
                    var partialMatches = searchTokens.every(token =>
                        featureTokens.some(ft => ft.includes(token))
                    );

                    // Scoring: prioritize exact matches
                    var score = (exactMatch ? 1 : 0) + (partialMatches ? 1 : 0);

                    // Return feature and score for sorting later
                    return score > 0 ? { feature, score } : null;
                case 'equal':
                    return featureValue == value ? { feature, score: 2 } : null;
                case 'greater':
                    return featureValue > value ? { feature, score: 2 } : null;
                case 'less':
                    return featureValue < value ? { feature, score: 2 } : null;
                case 'notEqual':
                    return featureValue != value ? { feature, score: 2 } : null;
                case 'range':
                    return featureValue >= value[0] && featureValue <= value[1]
                        ? { feature, score: 2 }
                        : null;
                default:
                    return null;
            }
        })
        .filter(item => item !== null) // Remove nulls
        .sort((a, b) => b.score - a.score) // Sort by score descending
        .map(item => item.feature); // Extract features only

    // Create the filtered GeoJSON layer
    dynamicLayer = L.geoJSON({
        type: 'FeatureCollection',
        features: filteredFeatures
    }, {
        style: layerType === 'property' ? getStyle : { color: "Red", weight: 2, opacity: 1, fillOpacity: 0.3 },
        onEachFeature: function (feature, layer) {
            var properties = feature.properties;
            var tooltipContent = `
            <div>
                ${layerType === 'property'
                    ? `<strong>Property No:</strong> ${properties.old_propert_id || '****'}`
                    : `<strong>Vacant Land Name:</strong> ${properties.Name}<br>
                       <strong>Area (Sqmts):</strong> ${properties.Area.toFixed(2)}`
                }
            </div>`;
            layer.bindTooltip(tooltipContent);

            // Add a click event to open the property table
            layer.on('click', function () {
                // Populate the #property-table with feature details
                $('#property-table').empty();
                $('#property-table').append(`
                    <tr>
                        <td>Property No:</td>
                        <td>${properties.old_propert_id || '****'}</td>
                        <td>Unique Property ID:</td>
                        <td>${properties.unique_propert_id || '****'}</td>
                    </tr>
                    <tr>
                        <td>Locality Name:</td>
                        <td>${properties.loacalityn || '****'}</td>
                        <td>Status:</td>
                        <td>${properties.status || '****'}</td>
                    </tr>
                    <tr>
                        <td>Land Use:</td>
                        <td>${properties.land_use || '****'}</td>
                        <td>Area (Sqmts):</td>
                        <td>${properties.area_in_sqm || '****'}</td>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <td>${properties.address || '****'}</td>
                        <td>Lessee Name:</td>
                        <td>${properties.lesse_name || '****'}</td>
                    </tr>
                    <tr>
                        <td>Land Type:</td>
                        <td>${properties.land_type || '****'}</td>
                        <td>Lease Tenure:</td>
                        <td>${properties.lease_tenure || '****'}</td>
                    </tr>
                    <tr>
                        <td>Total Dues:</td>
                        <td>${properties.total_dues || '****'}</td>
                        <td>Phone No:</td>
                        <td>${properties.phone_no || '****'}</td>
                    </tr>
                `);

                // Show the floating table
                $('#floating-table').show();
            });
        }
    }).addTo(map);

    // Add the filtered layer to overlayMaps
    overlayMaps[
        `<div style="display: flex; align-items: center;">
            <img src="assets/MIS_V5.1/Logo/Green.png" alt="Filtered Layer" style="width:16px; height:16px; margin-right:5px;">
            Filtered Layer
        </div>`
    ] = dynamicLayer;

    // Hide other layers
    hideOtherLayers();

    // Refresh the control layers to reflect the new filtered layer
    refreshControlLayer();

    // Show the filtered data in a modal
    showFilteredDataInModal(filteredFeatures);

    // Fit the map to the bounds of the filtered layer
    if (filteredFeatures.length) {
        map.fitBounds(dynamicLayer.getBounds());
    }
}

// Helper function to preprocess search queries and feature values
function preprocessSearchQuery(query) {
    return query
        .toLowerCase() // Convert to lowercase
        .trim() // Trim spaces
        .replace(/([a-z]+)\/\s*\/\s*/g, ' ')
        .replace(/\s+|\/+/g, ' ');
}
// Handle overlay removal to restore layers
map.on('overlayremove', function (e) {
    // Check if the removed layer is the filtered layer
    if (e.name === 'Filtered Layer') {
        console.log("Filtered Layer Removed");

        // Restore previously active layers
        restorePreviousLayers();

        // Remove the filtered layer from overlayMaps
        delete overlayMaps['Filtered Layer'];

        // Rebuild the control layers with the restored overlayMaps
        refreshControlLayer();
    }
});
//     // Update the filterFeatures function to show data in the modal
//     function filterFeatures(layerType, attribute, condition, value) {
//         // Clear previous dynamic filtered layer and restore other layers
//         if (dynamicLayer) {
//             map.removeLayer(dynamicLayer);
//             delete overlayMaps['Filtered Layer'];
//             removeControlLayer();
//             restorePreviousLayers();
//         }

//         // Fetch appropriate layer data based on layerType
//         var layerData = layerType === 'property' ? pro : vacant;
//         filteredFeatures = layerData.features.filter(function (feature) {
//             var featureValue = feature.properties[attribute];

//             switch (condition) {
//                 case 'like':
//                     return featureValue && featureValue.toString().toLowerCase().includes(value.toLowerCase());
//                 case 'equal':
//                     return featureValue == value;
//                 case 'greater':
//                     return featureValue > value;
//                 case 'less':
//                     return featureValue < value;
//                 case 'notEqual':
//                     return featureValue != value;
//                 case 'range':
//                     return featureValue >= value[0] && featureValue <= value[1];
//                 default:
//                     return false;
//             }
//         });

//         // Create filtered GeoJSON layer
//         dynamicLayer = L.geoJSON({
//             type: 'FeatureCollection',
//             features: filteredFeatures
//         }, {
//             style: layerType === 'property' ? getStyle : { color: "Red", weight: 2, opacity: 1, fillOpacity: 0.3 },
//             onEachFeature: function (feature, layer) {
//                 var tooltipContent = `
//                 <div>
//                     ${layerType === 'property'
//                         ? `<strong>Property No:</strong> ${feature.properties.old_propert_id || '****'}`
//                         : `<strong>Vacant Land Name:</strong> ${feature.properties.Name}<br>
//                            <strong>Area (Sqmts):</strong> ${feature.properties.Area.toFixed(2)}`
//                     }
//                 </div>`;

//                 layer.bindTooltip(tooltipContent);
//             }
//         }).addTo(map);

//         // Add filtered layer to overlayMaps
//         overlayMaps[
//             `<div style="display: flex; align-items: center;">
//                 <img src="assets/MIS_V5.1/logo/Green.png" alt="Filtered Layer" style="width:16px; height:16px; margin-right:5px;">
//                 Filtered Layer
//             </div>`
//         ] = dynamicLayer;

//         // Remove other active layers
//         hideOtherLayers();

//         // Rebuild the control layers to reflect filtered layer
//         refreshControlLayer();

//         // Show data in modal
//         showFilteredDataInModal(filteredFeatures);

//         // Fit map to the bounds of the filtered layer
//         if (filteredFeatures.length) {
//             map.fitBounds(dynamicLayer.getBounds());
//         }
//     }



//     // Function to hide all other layers except the filtered one
//     function hideOtherLayers() {
//         // Store currently active layers before hiding
//         map.eachLayer(function (layer) {
//             for (var name in overlayMaps) {
//                 if (overlayMaps[name] === layer && layer !== dynamicLayer) {
//                     activeLayers[name] = layer;  // Keep track of active layers
//                     map.removeLayer(layer);  // Remove the layer from the map
//                 }
//             }
//         });
//     }

//     // Function to restore previously active layers when filter is removed
//     function restorePreviousLayers() {
//         for (var name in activeLayers) {
//             if (activeLayers[name]) {
//                 map.addLayer(activeLayers[name]);  // Add layer back to the map
//             }
//         }
//         activeLayers = {};  // Reset activeLayers tracking
//     }

//     // Function to remove the old control layer
//     function removeControlLayer() {
//         if (controlLayers) {
//             map.removeControl(controlLayers);  // Remove the current control layers
//         }
//     }

//     // Function to refresh the control layers dynamically
//     function refreshControlLayer() {
//         removeControlLayer();  // Ensure previous control layer is removed

//         // Rebuild control layers with current overlayMaps and baseMaps
//         controlLayers = L.control.layers(baseMaps, overlayMaps, {
//             position: 'bottomleft',
//             collapsed: true,
//         }).addTo(map);
//     }

// // Reset layers when filtered layer is turned off
// map.on('overlayremove', function (e) {
//     // Check if the removed layer is the filtered layer
//     if (e.name === 'Filtered Layer') {
//         // Restore other layers that were hidden
//         restorePreviousLayers();

//         // Remove the filtered layer from overlayMaps
//         delete overlayMaps['Filtered Layer'];

//         // Remove the current control layers
//         removeControlLayer();

//         // Rebuild the control layers with the restored overlayMaps
//         refreshControlLayer();

//         // Optionally fit the map to the bounds of the restored layers
//         var restoredBounds = null;
//         for (var name in activeLayers) {
//             if (activeLayers[name]) {
//                 if (!restoredBounds) {
//                     restoredBounds = activeLayers[name].getBounds();
//                 } else {
//                     restoredBounds.extend(activeLayers[name].getBounds());
//                 }
//             }
//         }
//         if (restoredBounds) {
//             map.fitBounds(restoredBounds);
//         }
//     }
// });
    //    HTML DIV
     // });
     $(document).ready(function () {
        // Define attributes for each layer
        var layerAttributes = {
            property: [
                { value: 'status', label: 'Lease Type' },
                { value: 'area_in_sqm', label: 'Area (Sqmts)' },
                { value: 'land_use', label: 'Land Use' },
                { value: 'address', label: 'Address' },
                { value: 'lesse_name', label: 'Lessee Name' },
                { value: 'land_type', label: 'Land Type' },
                { value: 'lease_tenure', label: 'Lease Tenure' }
            ],
            vacant: [
                { value: 'Name', label: 'Vacant Land Name' },
                { value: 'Area', label: 'Area (Sqmts)' }
            ]
        };
    
        // Function to populate attributes based on selected layer
        function populateAttributes(layerType) {
            var attributeSelect = $('#attributeSelect');
            attributeSelect.empty(); // Clear existing options
    
            // Add new options based on selected layer
            layerAttributes[layerType].forEach(function (attribute) {
                attributeSelect.append(new Option(attribute.label, attribute.value));
            });
        }
    
        // Event listener for layer selection change
        $('#layerSelect').on('change', function () {
            var selectedLayer = $(this).val();
            populateAttributes(selectedLayer);
    
            // Reset inputs
            $('#attributeSelect').val('');
            $('#conditionSelect').val('like');
            $('#valueInput').val('');
            $('#rangeInputContainer').addClass('d-none');
            $('#valueInputContainer').removeClass('d-none');
        });
    
        // Toggle between single value input and range inputs based on condition selected
        $('#conditionSelect').on('change', function () {
            var selectedCondition = $(this).val();
    
            if (selectedCondition === 'range') {
                $('#valueInputContainer').addClass('d-none');
                $('#rangeInputContainer').removeClass('d-none');
            } else {
                $('#valueInputContainer').removeClass('d-none');
                $('#rangeInputContainer').addClass('d-none');
            }
        });
    
        // Form submission logic with validation
        $('#filterForm').on('submit', function (e) {
            e.preventDefault();
    
            var selectedLayer = $('#layerSelect').val();
            var selectedAttribute = $('#attributeSelect').val();
            var selectedCondition = $('#conditionSelect').val();
            var value = $('#valueInput').val().trim();
            var rangeStart = $('#rangeStart').val().trim();
            var rangeEnd = $('#rangeEnd').val().trim();
    
            // Validate selections
            if (!selectedLayer) {
                alert('Please select a layer.');
                return;
            }
    
            if (!selectedAttribute) {
                alert('Please select an attribute.');
                return;
            }
    
            if (!selectedCondition) {
                alert('Please select a condition.');
                return;
            }
    
            if (selectedCondition === 'range' && (!rangeStart || !rangeEnd)) {
                alert('Please provide both start and end values for the range.');
                return;
            }
    
            if (selectedCondition !== 'range' && !value) {
                alert('Please provide a value.');
                return;
            }
    
            // Call the filter function
            filterFeatures(
                selectedLayer,
                selectedAttribute,
                selectedCondition,
                selectedCondition === 'range' ? [Number(rangeStart), Number(rangeEnd)] : value
            );
    
            // Close the modal
            $('#filterModal').modal('hide');
        });
    });


    //Near by

    document.addEventListener('DOMContentLoaded', function () {
        const distanceInputIcon = document.getElementById('distance-input-icon');
        if (distanceInputIcon) {
            distanceInputIcon.addEventListener('click', function () {
                $('#distanceInputModal').modal('show'); // Open the modal when the icon is clicked
            });
        } else {
            console.error("Element with id 'distance-input-icon' not found.");
        }
    });

    document.getElementById('submitDistance').addEventListener('click', function () {
        const distance = parseFloat(document.getElementById('distanceInput').value);

        if (!distance || distance <= 0) {
            alert("Please enter a valid distance.");
            return;
        }

        // Get user's current location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                const userLatLng = [position.coords.latitude, position.coords.longitude];

                // Fetch nearby properties from local data
                fetchNearbyProperties(userLatLng, distance);
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }

        $('#distanceInputModal').modal('hide');
    });



    let nearbyProperties = []; // To store fetched nearby properties
    let currentPage = 1; // Track the current page
    const itemsPerPage = 10; // Define the number of items per page
    async function fetchNearbyProperties(userLatLng, distance) {
        try {
            nearbyProperties = []; // Reset properties on new fetch
            removeCurrentMarker(); // Remove previous marker

            // Extract GeoJSON features from the L.geoJSON layers
            const propertyFeatures = property.toGeoJSON().features;
            const propertyVFeatures = property_v.toGeoJSON().features;

            // Combine both property and property_v features into a single array
            const combinedFeatures = [...propertyFeatures, ...propertyVFeatures];

            combinedFeatures.forEach(feature => {
                const geometry = feature.geometry;

                // Check if the geometry exists and has coordinates
                if (geometry && geometry.coordinates) {
                    let coordinates;

                    // Handle different geometry types
                    switch (geometry.type) {
                        case 'Point':
                            coordinates = geometry.coordinates;
                            break;
                        case 'MultiPoint':
                            coordinates = geometry.coordinates[0]; // Take the first point
                            break;
                        case 'Polygon':
                            coordinates = geometry.coordinates[0][0]; // Take the first point of the outer ring
                            break;
                        case 'MultiPolygon':
                            coordinates = geometry.coordinates[0][0][0]; // Take the first point of the first polygon
                            break;
                        default:
                            console.error(`Unsupported geometry type: ${geometry.type}`, geometry);
                            return; // Skip unsupported geometry
                    }

                    // Validate coordinates
                    if (Array.isArray(coordinates) && coordinates.length >= 2) {
                        const propertyLocation = [coordinates[1], coordinates[0]]; // [lat, lng]

                        // Ensure latitude and longitude are numbers
                        if (typeof propertyLocation[0] === 'number' && typeof propertyLocation[1] === 'number') {
                            const point = turf.point(propertyLocation);
                            const userPoint = turf.point(userLatLng);

                            // Calculate distance between user and property
                            const dist = turf.distance(userPoint, point, { units: 'meters' });

                            // Check if within specified distance
                            if (dist <= distance) {
                                // Check if the feature is from the vacant land layer (property_v)
                                const isVacantLand = feature.properties.hasOwnProperty('Name') && feature.properties.hasOwnProperty('Area');
                                if (isVacantLand) {
                                    nearbyProperties.push({
                                        type: 'vacant',
                                        name: feature.properties.Name,
                                        area: feature.properties.Area.toFixed(2),
                                        coordinates: propertyLocation
                                    });
                                } else {
                                    // Regular property
                                    nearbyProperties.push({
                                        type: 'property',
                                        id: feature.properties.old_propert_id,
                                        uniqueId: feature.properties.unique_propert_id,
                                        address: feature.properties.address|| '****',
                                        lesse_name: feature.properties.lesse_name|| '****',
                                        coordinates: propertyLocation
                                    });
                                }
                            }
                        } else {
                            console.error(`Invalid property location coordinates: ${propertyLocation}`);
                        }
                    } else {
                        console.error(`Feature does not have valid coordinates:`, feature);
                    }
                } else {
                    console.error(`Feature does not have valid geometry:`, feature);
                }
            });

            // Check if any properties were found
            if (nearbyProperties.length === 0) {
                alert("No properties found within the specified distance.");
            } else {
                // Reset current page to 1 and populate the modal with nearby properties
                currentPage = 1;
                paginateNearbyProperties();
            }

        } catch (error) {
            console.error("Error fetching nearby properties:", error);
        }
    }


    function paginateNearbyProperties() {
        const totalPages = Math.ceil(nearbyProperties.length / itemsPerPage);

        // Check if the page is within bounds
        if (currentPage < 1 || currentPage > totalPages) return;

        // Slice the properties to show only the current page's items
        const currentPageProperties = nearbyProperties.slice((currentPage - 1) * itemsPerPage, currentPage * itemsPerPage);

        // Populate the table
        populateNearbyPropertiesTable(currentPageProperties);

        // Update the feature counter
        document.getElementById('feature-counter').innerText = `Showing ${currentPageProperties.length} of ${nearbyProperties.length} properties`;

        // Handle pagination buttons
        const paginationElement = document.getElementById('pagination');
        paginationElement.innerHTML = ''; // Clear previous pagination buttons

        if (totalPages > 1) {
            // Previous button
            if (currentPage > 1) {
                const prevButton = createPaginationButton("Previous", currentPage - 1);
                paginationElement.appendChild(prevButton);
            }

            // Page numbers
            const startPage = Math.max(1, currentPage - 2);
            const endPage = Math.min(totalPages, currentPage + 2);

            for (let i = startPage; i <= endPage; i++) {
                const pageButton = createPaginationButton(i, i);
                paginationElement.appendChild(pageButton);
            }

            // Next button
            if (currentPage < totalPages) {
                const nextButton = createPaginationButton("Next", currentPage + 1);
                paginationElement.appendChild(nextButton);
            }
        }
    }

    function createPaginationButton(text, page) {
        const button = document.createElement('button');
        button.className = 'btn btn-secondary btn-sm pagination-button';
        button.innerText = text;
        button.onclick = () => {
            currentPage = page; // Update the current page
            paginateNearbyProperties(); // Refresh the displayed properties
        };
        return button;
    }

    function populateNearbyPropertiesTable(properties) {
        const tableBody = document.getElementById('nearby-properties-table').getElementsByTagName('tbody')[0];
        tableBody.innerHTML = ''; // Clear existing rows

        properties.forEach(property => {
            const row = tableBody.insertRow();

            if (property.type === 'vacant') {
                // Vacant land
                row.insertCell(0).innerText = "Vacant Land"; // Property No placeholder
                row.insertCell(1).innerText = ""; // Unique Property ID placeholder
                row.insertCell(2).innerHTML = `<strong>Vacant Land Name:</strong> ${property.name}<br>
                                                            <strong>Area (Sqmts):</strong> ${property.area}`;
            } else {
                // Regular property
                row.insertCell(0).innerText = property.id;
                row.insertCell(1).innerText = property.uniqueId;
                row.insertCell(2).innerText = property.address|| '****';
                row.insertCell(3).innerText = property.lesse_name|| '****';
            }

            const actionCell = row.insertCell(4);
            const viewButton = document.createElement('button');
            viewButton.innerText = 'View';
            viewButton.className = 'btn btn-primary btn-sm';

            // Add spinner logic when viewing a property
            viewButton.onclick = async () => {
                $('#spinner').show(); // Show the spinner
                await new Promise((resolve) => setTimeout(resolve, 100)); // Simulate loading time, remove in production
                zoomToProperty(property.coordinates);
                $('#nearbyPropertiesModal').modal('hide'); // Close the modal after viewing
                $('#spinner').hide(); // Hide the spinner after loading
            };

            actionCell.appendChild(viewButton);
        });

        $('#nearbyPropertiesModal').modal('show');
    }

    function zoomToProperty(coordinates) {
        const latLng = L.latLng(coordinates[0], coordinates[1]);
        map.setView(latLng, 19); // Zoom level can be adjusted

        // Highlight the property or vacant land by adding the layer again in green
        highlightLayer(latLng);

        // Create a new marker at the selected property location
        addCurrentMarker(latLng);
    }

    // Function to add a marker at a specific location
    function addCurrentMarker(latLng) {
        console.log("Adding current marker at:", latLng); // Log the latLng for debugging
        removeCurrentMarker(); // Remove any existing marker
        currentMarker = L.marker(latLng).addTo(map); // Create and add the new marker
    }

    // Function to remove the current marker
    function removeCurrentMarker() {
        if (currentMarker) {
            console.log("Removing existing marker."); // Log removal action
            map.removeLayer(currentMarker); // Remove the existing marker from the map
            currentMarker = null; // Reset the currentMarker variable
        } else {
            console.log("No current marker to remove."); // Log if there's no marker to remove
        }
    }

    function highlightLayer(latLng) {
        // Remove any existing highlights if needed
        map.eachLayer(layer => {
            if (layer instanceof L.GeoJSON && layer.options.highlighted) {
                map.removeLayer(layer);
            }
        });

        // Create a new GeoJSON layer for highlighting
        L.geoJSON(null, {
            style: {
                color: 'green',
                weight: 3,
                fillOpacity: 0.5,
                highlighted: true // Custom option to track highlighted layers
            }
        }).addData({
            type: 'Point',
            coordinates: [latLng.lng, latLng.lat]
        });
    }

    // Add an event listener to the "Delete Location Marker" button
    document.getElementById('trash').addEventListener('click', function () {
        removeCurrentMarker();
    });

    //

    // var cr_park = L.tileLayer.wms('http://localhost:8080/geoserver/drone/wms', {
    //     layers: "drone:CR_PARK_ORI_Clip",
    //     format: "image/png",
    //     maxZoom: 23,
    //     transparent: true
    // });
    // var delhi = L.tileLayer.wms('http://localhost:8080/geoserver/drone/wms', {
    //     layers: "drone:delhis",
    //     format: "image/png",
    //     maxZoom: 23,
    //     transparent: true,
    //     tiled: false,
    //     tileSize: 3064,  // Large tile size to cover more area
    //     noWrap: true     // Prevents tiles from wrapping around at zoom levels
    // }).addTo(map);

    // var india = L.tileLayer.wms('http://localhost:8080/geoserver/drone/wms', {
    //     layers: "drone:india",
    //     format: "image/png",
    //     maxZoom: 23,
    //     transparent: true,
    //     tiled: false,
    //     tileSize: 3064,  // Large tile size to cover more area
    //     noWrap: true     // Prevents tiles from wrapping around at zoom levels
    // }).addTo(map);

    // Corrected label layer with L.labeler and tooltip on hover

// // Define the base maps
// var baseMaps = {
//     'Google Satellite': google,
//     'Google Street': googlestreet,
//     'Blank Map': blankMap,
// };

// // Define the overlays with custom labels
// var overlayMaps = {};

// // Add overlays with icons
// overlayMaps['<i class="fa fa-home"></i> Properties'] = property;
// overlayMaps['<i class="fa fa-tree"></i> Vacant Land'] = property_v;
// overlayMaps['<i class="fa fa-building"></i> 3D Building'] = osmb;
// overlayMaps['<i class="fa fa-folder"></i> Lease Section I'] = leases;
// overlayMaps['<i class="fa fa-map-marker"></i> Property Section I'] = ps_I;
// overlayMaps['<i class="fa fa-map-pin"></i> Property Section II'] = pss_II;
// overlayMaps['<i class="fa fa-map-signs"></i> Property Section III'] = pss_III;
// overlayMaps['<i class="fa fa-university"></i> LBZ'] = lbz;

// // Create the control layers with custom labels
// var controlLayers = L.control.layers(baseMaps, overlayMaps, {
//     position: 'bottomleft',
//     collapsed: true,
// }).addTo(map);

// // Add custom CSS for the icons if necessary
// var style = document.createElement('style');
// style.innerHTML = `
//     .leaflet-control-layers label span {
//         display: inline-block;
//         margin-left: 5px;
//     }
//     .leaflet-control-layers label i {
//         margin-right: 5px;
//     }
// `;
// document.head.appendChild(style);
// Define the base maps
// Define the base maps
// Define the base maps
// Define the base maps
var baseMaps = {
    'Google Satellite': google,
    'Google Street': googlestreet,
    'Blank Map': blankMap,
};

// Define the overlays with custom labels and local image icons
var overlayMaps = {};

// Add overlays with icons using local image sources
overlayMaps['<img src="assets/MIS_V5.1/Logo/Property.png" alt="Vacant Land" style="width:16px; height:16px; vertical-align:middle; margin-right:5px;"> Properties of L&DO'] = property;
overlayMaps['<img src="assets/MIS_V5.1/Logo/3d.png" alt="Vacant Land" style="width:16px; height:16px; vertical-align:middle; margin-right:5px;"> 3D Building'] = osmb;
overlayMaps['<img src="assets/MIS_V5.1/Logo/Red.png" alt="Vacant Land" style="width:16px; height:16px; vertical-align:middle; margin-right:5px;"> Vacant Land'] = property_v;
overlayMaps['<img src="assets/MIS_V5.1/Logo/Lease.png" alt="Lease Section I" style="width:16px; height:16px; vertical-align:middle; margin-right:5px;"> Lease Section I'] = leases;
overlayMaps['<img src="assets/MIS_V5.1/Logo/ps1.png" alt="Property Section I" style="width:16px; height:16px; vertical-align:middle; margin-right:5px;"> Property Section I'] = ps_I;
overlayMaps['<img src="assets/MIS_V5.1/Logo/ps2.png" alt="Property Section II" style="width:16px; height:16px; vertical-align:middle; margin-right:5px;"> Property Section II'] = pss_II;
overlayMaps['<img src="assets/MIS_V5.1/Logo/ps_3.png" alt="Property Section III" style="width:16px; height:16px; vertical-align:middle; margin-right:5px;"> Property Section III'] = pss_III;
overlayMaps['<img src="assets/MIS_V5.1/Logo/LBZ.png" alt="LBZ" style="width:16px; height:16px; vertical-align:middle; margin-right:5px;"> LBZ Properties'] = lbz;
overlayMaps['<img src="assets/MIS_V5.1/Logo/LBZ_GBS.png" alt="LBZ Clause 2B" style="width:16px; height:16px; vertical-align:middle; margin-right:5px;"> LBZ Clause 2B']= lbz_gb;
overlayMaps['<img src="assets/MIS_V5.1/Logo/Delhis.png" alt="Delhi" style="width:16px; height:16px; vertical-align:middle; margin-right:5px;"> Delhi Boundary']= del

// Create the control layers with custom labels
var controlLayers = L.control.layers(baseMaps, overlayMaps, {
    position: 'bottomleft',
    collapsed: true,
}).addTo(map);

// Add custom CSS for styling the panel
var style = document.createElement('style');
style.innerHTML = `
    .leaflet-control-layers-expanded {
        border: 2px solid #4CAF50; /* Green border */
        border-radius: 8px; /* Rounded corners */
        background-color: #ffffff; /* White background */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow effect */
        padding: 10px; /* Padding inside the panel */
    }
    .leaflet-control-layers label {
        display: block;
        margin-bottom: 8px;
        padding: 5px;
        border: 1px solid #ccc; /* Light border around each section */
        border-radius: 4px; /* Rounded corners for each section */
        background-color: #f9f9f9; /* Light gray background */
        cursor: pointer;
    }
    .leaflet-control-layers label:hover {
        background-color: #e8f5e9; /* Slightly green on hover */
    }
    .leaflet-control-layers label img {
        vertical-align: middle;
        margin-right: 8px;
    }
    .leaflet-control-layers-separator {
        margin: 10px 0;
        border-top: 1px solid #ccc; /* Separator line between sections */
    }
`;
document.head.appendChild(style);

// // Add custom CSS for better styling if needed
// var style = document.createElement('style');
// style.innerHTML = `
//     .leaflet-control-layers label img {
//         vertical-align: middle;
//         margin-right: 5px;
//     }
// `;
// document.head.appendChild(style);



    var legend = L.control.Legend({
        position: "bottomright",
        title: "Legend",
        collapsed: false,
        symbolWidth: 24,
        opacity: 0.8,
        legends: [
            {
                label: "Selection",
                type: "image",
                url: "assets/MIS_V5.1/Logo/Green.png"
            },
            {
                label: "Lease Hold",
                type: "image",
                url: "assets/MIS_V5.1/Logo/Yellow.png"
            },
            {
                label: "Free Hold",
                type: "image",
                url: "assets/MIS_V5.1/Logo/Blue.png"
            },
            {
                label: "LBZ Properties",
                type: "image",
                url: "assets/MIS_V5.1/Logo/LBZ.png"
            },

            {
                label: "Vacant Land",
                type: "image",
                url: "assets/MIS_V5.1/Logo/Red.png"
            },
            {
                label: "Lease Section I",
                type: "image",
                url: "assets/MIS_V5.1/Logo/Lease.png"
            },
            {
                label: "Property Section I",
                type: "image",
                url: "assets/MIS_V5.1/Logo/ps1.png"
            },
            {
                label: "Property Section II",
                type: "image",
                url: "assets/MIS_V5.1/Logo/ps2.png"
            },
            {
                label: "Property Section III",
                type: "image",
                url: "assets/MIS_V5.1/Logo/ps_3.png"
            },
            {
                label: "LBZ Clause 2B",
                type: "image",
                url: "assets/MIS_V5.1/Logo/LBZ_GBS.png"
            },
            {
                label: "Delhi Boundary",
                type: "image",
                url: "assets/MIS_V5.1/Logo/Delhis.png"
            },


        ],








            
    }).addTo(map);



    // $(document).ready(function () {
    //     // Function to read URL parameters
    //     function getUrlParameter(name) {
    //         name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    //         var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    //         var results = regex.exec(location.search);
    //         return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    //     }

    //     // Extract and store property names for autocomplete
    //     var vacantLandNames = [];
    //     property_v.eachLayer(function (layer) {
    //         vacantLandNames.push(layer.feature.properties.Name);
    //     });

    //     var propertyNames = [];
    //     property.eachLayer(function (layer) {
    //         propertyNames.push(layer.feature.properties.old_propert_id);
    //     });

    //     // Combine both arrays
    //     var combinedNames = vacantLandNames.concat(propertyNames);

    //     // Initialize autocomplete
    //     $('#propertyId').autocomplete({
    //         source: function (request, response) {
    //             const filteredNames = combinedNames.filter(name =>
    //                 name.toLowerCase().includes(request.term.toLowerCase())
    //             );
    //             response(filteredNames.slice(0, 3));
    //         },
    //         select: function (event, ui) {
    //             $('#propertyId').val(ui.item.value);
    //             $('#searchForm').submit();
    //             return false;
    //         }
    //     });

    //     // Handle Enter key for form submission
    //     $('#propertyId').on('keypress', function (event) {
    //         if (event.which === 13) {
    //             event.preventDefault();
    //             $('#searchForm').submit();
    //         }
    //     });

    //     // Make the floating table draggable
    //     $('#floating-table').draggable();

    //     // Form submission handler
    //     $('#searchForm').submit(function (event) {
    //         event.preventDefault();
    //         var propertyId = $('#propertyId').val().trim();

    //         // Show spinner and add 'loading' class to the map
    //         $('#spinner').show();
    //         $('#map').addClass('loading');

    //         // Simulating property search 
    //         setTimeout(function () {
    //             locatePropertyById(propertyId);

    //             // Hide spinner and remove 'loading' class from the map once search is done
    //             $('#spinner').hide();
    //             $('#map').removeClass('loading');
    //         }, 2000); // Simulate a delay in the search process
    //     });

    //     // Function to locate property by ID
    //     function locatePropertyById(propertyId) {
    //         var foundProperty = false;

    //         $('#property-table').empty();
    //         $('#floating-table').hide();
    //         $('#propertyId').val('');

    //         // Search in the property layer
    //         property.eachLayer(function (layer) {
    //             var properties = layer.feature.properties;

    //             if (properties.old_propert_id === propertyId || properties.unique_propert_id === propertyId) {
    //                 $('#property-table').append(`
    //                     <tr>
    //                         <td>Property No:</td>
    //                         <td>${properties.old_propert_id || '****'}</td>
    //                         <td>Unique Property ID:</td>
    //                         <td>${properties.unique_propert_id || '****'}</td>
    //                     </tr>
    //                     <tr>
    //                         <td>Locality Name:</td>
    //                         <td>${properties.loacalityn || '****'}</td>
    //                         <td>Status:</td>
    //                         <td>${properties.status || '****'}</td>
    //                     </tr>
    //                     <tr>
    //                         <td>Land Use:</td>
    //                         <td>${properties.land_use || '****'}</td>
    //                         <td>Area (Sqmts):</td>
    //                         <td>${properties.area_in_sqm || '****'}</td>
    //                     </tr>
    //                     <tr>
    //                         <td>Address:</td>
    //                         <td>${properties.address || '****'}</td>
    //                         <td>Lessee Name:</td>
    //                         <td>${properties.lesse_name || '****'}</td>
    //                     </tr>
    //                     <tr>
    //                         <td>Land Type:</td>
    //                         <td>${properties.land_type || '****'}</td>
    //                         <td>Lease Tenure:</td>
    //                         <td>${properties.lease_tenure || '****'}</td>
    //                     </tr>
    //                     <tr>
    //                         <td>Total Dues:</td>
    //                         <td>${properties.total_dues || '****'}</td>
    //                         <td>Phone No:</td>
    //                         <td>${properties.phone_no || '****'}</td>
    //                     </tr>
    //                 `);

    //                 $('#floating-table').show();
    //                 foundProperty = true;
    //                 // map.fitBounds(layer.getBounds());
    //                 map.setView(layer.getBounds().getCenter(), 20);
    //                 property.resetStyle();
    //                 layer.setStyle({
    //                     color: 'green',
    //                     fillOpacity: 0.5
    //                 });
    //             }
    //         });

    //         // Search in the property_v layer
    //         property_v.eachLayer(function (layer) {
    //             var properties = layer.feature.properties;

    //             if (properties.Name === propertyId || properties.Area === propertyId) {
    //                 $('#property-table').append(`
    //                     <tr>
    //                         <td>Vacant Land Name:</td>
    //                         <td>${properties.Name}</td>
    //                         <td>Area (Sqmts):</td>
    //                         <td>${properties.Area.toFixed(2)}</td>
    //                     </tr>
    //                 `);

    //                 $('#floating-table').show();
    //                 foundProperty = true;
    //                 // map.fitBounds(layer.getBounds());
    //                 // Set map view to center of the layer with zoom level 18
    //                 map.setView(layer.getBounds().getCenter(), 20);

    //                 property_v.resetStyle();
    //                 layer.setStyle({
    //                     color: 'green',
    //                     fillOpacity: 0.5
    //                 });
    //             }
    //         });

    //         if (!foundProperty) {
    //             alert('Property not found!');
    //         }
    //     }

    //     // Close floating table handler
    //     $('#closeFloatingTable').click(function () {
    //         $('#floating-table').hide();
    //     });

    //     // Delete location marker handler
    //     $('#trash').click(function () {
    //         property.resetStyle();
    //         property_v.resetStyle();
    //         $('#floating-table').hide();
    //     });

    //     // Initial URL parameter handling
    //     var initialPropertyId = getUrlParameter('propertyId');
    //     if (initialPropertyId) {
    //         locatePropertyById(initialPropertyId);
    //     }
    // });

    $(document).ready(function () {
        // Function to read URL parameters
        function getUrlParameter(name) {
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            var results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        }
    
        // Extract and store property names and addresses for autocomplete
        var vacantLandNames = [];
        property_v.eachLayer(function (layer) {
            vacantLandNames.push(layer.feature.properties.Name);
            vacantLandNames.push(layer.feature.properties.Area); // Include Area for autocomplete
            vacantLandNames.push(layer.feature.properties.Address); // Include Address
        });
    
        var propertyNames = [];
        property.eachLayer(function (layer) {
            propertyNames.push(layer.feature.properties.old_propert_id);
            propertyNames.push(layer.feature.properties.unique_propert_id);
            propertyNames.push(layer.feature.properties.address); // Include Address
        });
    
        // Combine both arrays
        var combinedNames = vacantLandNames.concat(propertyNames);
    
        $('#propertyId').autocomplete({
            source: function (request, response) {
                // Filter out undefined or null values before searching
                const filteredNames = combinedNames
                    .filter(name => typeof name === 'string') // Ensure only valid strings
                    .filter(name =>
                        name.toLowerCase().includes(request.term.toLowerCase()) // Perform the search
                    );
                response(filteredNames.slice(0, 3));
            },
            select: function (event, ui) {
                $('#propertyId').val(ui.item.value);
                $('#searchForm').submit();
                return false;
            }
        });
    
        // Handle Enter key for form submission
        $('#propertyId').on('keypress', function (event) {
            if (event.which === 13) {
                event.preventDefault();
                $('#searchForm').submit();
            }
        });
    
        // Make the floating table draggable
        $('#floating-table').draggable();
    
        $('#searchForm').submit(function (event) {
            event.preventDefault();
            var propertyId = $('#propertyId').val().trim();

            // Check if propertyId is empty
            if (!propertyId) {
                alert('Please enter a property ID or address to search.');
                return;
            }

            // Show spinner and add 'loading' class to the map
            $('#spinner').show();
            $('#map').addClass('loading');

            // Simulating property search 
            setTimeout(function () {
                locatePropertyById(propertyId);

                // Hide spinner and remove 'loading' class from the map once search is done
                $('#spinner').hide();
                $('#map').removeClass('loading');
            }, 100); 
        });
    
        // Function to locate property by ID or address
        function locatePropertyById(propertyId) {
            var foundProperty = false;
    
            $('#property-table').empty();
            $('#floating-table').hide();
            $('#propertyId').val('');
    
            // Search in the property layer
            property.eachLayer(function (layer) {
                var properties = layer.feature.properties;
    
                if (
                    properties.old_propert_id === propertyId ||
                    properties.unique_propert_id === propertyId ||
                    (properties.address && properties.address.toLowerCase().includes(propertyId.toLowerCase()))
                ) {
                    $('#property-table').append(`
                        <tr>
                            <td>Property No:</td>
                            <td>${properties.old_propert_id || '****'}</td>
                            <td>Unique Property ID:</td>
                            <td>${properties.unique_propert_id || '****'}</td>
                        </tr>
                        <tr>
                            <td>Locality Name:</td>
                            <td>${properties.loacalityn || '****'}</td>
                            <td>Status:</td>
                            <td>${properties.status || '****'}</td>
                        </tr>
                        <tr>
                            <td>Land Use:</td>
                            <td>${properties.land_use || '****'}</td>
                            <td>Area (Sqmts):</td>
                            <td>${properties.area_in_sqm || '****'}</td>
                        </tr>
                        <tr>
                            <td>Address:</td>
                            <td>${properties.address || '****'}</td>
                            <td>Lessee Name:</td>
                            <td>${properties.lesse_name || '****'}</td>
                        </tr>
                        <tr>
                            <td>Land Type:</td>
                            <td>${properties.land_type || '****'}</td>
                            <td>Lease Tenure:</td>
                            <td>${properties.lease_tenure || '****'}</td>
                        </tr>
                        <tr>
                            <td>Total Dues:</td>
                            <td>${properties.total_dues || '****'}</td>
                            <td>Phone No:</td>
                            <td>${properties.phone_no || '****'}</td>
                        </tr>
                    `);
    
                    $('#floating-table').show();
                    foundProperty = true;
                    map.setView(layer.getBounds().getCenter(), 20);
                    property.resetStyle();
                    layer.setStyle({
                        color: 'green',
                        fillOpacity: 0.5
                    });
                }
            });
    
            // Search in the property_v layer
            property_v.eachLayer(function (layer) {
                var properties = layer.feature.properties;
    
                if (
                    properties.Name === propertyId ||
                    properties.Area === propertyId ||
                    (properties.Address && properties.Address.toLowerCase().includes(propertyId.toLowerCase()))
                ) {
                    $('#property-table').append(`
                        <tr>
                            <td>Vacant Land Name:</td>
                            <td>${properties.Name}</td>
                            <td>Area (Sqmts):</td>
                            <td>${properties.Area.toFixed(2)}</td>
                            <td>Address:</td>
                            <td>${properties.Address || '****'}</td>
                        </tr>
                    `);
    
                    $('#floating-table').show();
                    foundProperty = true;
                    map.setView(layer.getBounds().getCenter(), 20);
    
                    property_v.resetStyle();
                    layer.setStyle({
                        color: 'green',
                        fillOpacity: 0.5
                    });
                }
            });
    
            if (!foundProperty) {
                alert('Property not found!');
            }
        }
    
        // Close floating table handler
        $('#closeFloatingTable').click(function () {
            $('#floating-table').hide();
        });
    
        // Delete location marker handler
        $('#trash').click(function () {
            property.resetStyle();
            property_v.resetStyle();
            $('#floating-table').hide();
        });
    
        // Initial URL parameter handling
        var initialPropertyId = getUrlParameter('propertyId');
        if (initialPropertyId) {
            locatePropertyById(initialPropertyId);
        }
    });
    

     function getBaseURLMap() {
    const { protocol, hostname, port } = window.location;
    return `${protocol}//${hostname}${port ? ":" + port : ""}`;
    }


    var iconLayersControl = new L.Control.IconLayers(
        [
            {
                title: 'Map',
                layer: googlestreet,
                icon: getBaseURLMap() + '/assets/MIS_V5.1/Logo/street.png'
            },
            {
                title: 'Satellite',
                layer: google,
                icon: getBaseURLMap() + '/assets/MIS_V5.1/Logo/sattelite.png'
            }
        ], {
        position: 'bottomright',
        maxLayersInRow: 20
    }
    );

    iconLayersControl.addTo(map);

    iconLayersControl.on('activelayerchange', function (e) {
        console.log('layer switched', e.layer);
        // map.setZoom(20);
    });

    // Extend the L.Control.Measure class
    L.Control.Measure.include({
        // Override the _setCaptureMarkerIcon function
        _setCaptureMarkerIcon: function () {
            // Disable autopan
            this._captureMarker.options.autoPanOnFocus = false;

            // Default function
            this._captureMarker.setIcon(
                L.divIcon({
                    iconSize: this._map.getSize().multiplyBy(2)
                })
            );
        }
    });

    // Measurement
    var measure = L.control.measure({
        primaryLengthUnit: 'kilometers',
        secondaryLengthUnit: 'meters',
        primaryAreaUnit: 'hectares',
        secondaryAreaUnit: 'acres',
        position: 'topleft',
        crs: L.CRS.EPSG3857
    }).addTo(map);


    // Download PDF button event listener
    document.getElementById('downloadPDF').addEventListener('click', function () {
        downloadPDF();
    });

    //
    async function downloadPDF() {
        const { jsPDF } = window.jspdf;
        if (!jsPDF) {
            console.error("jsPDF is not loaded correctly.");
            return;
        }

        var doc = new jsPDF('p', 'pt', 'letter');

        // Calculate watermark dimensions
        const watermarkText = 'Land and Development Authority';
        const fontSize = 5;
        const opacity = 0.03;
        const textWidth = doc.getStringUnitWidth(watermarkText) * fontSize / doc.internal.scaleFactor;
        const textHeight = fontSize / doc.internal.scaleFactor;
        const pageWidth = doc.internal.pageSize.width;
        const pageHeight = doc.internal.pageSize.height;

        const numCols = Math.ceil(pageWidth / textWidth);
        const numRows = Math.ceil(pageHeight / textHeight);

        // Add watermark on every page in a block-wise pattern
        for (let col = 0; col < numCols; col++) {
            for (let row = 0; row < numRows; row++) {
                const x = col * textWidth - (row % 2 === 0 ? 0 : textWidth / 2);
                const y = row * textHeight;

                // Set semi-transparent fill color for watermark
                doc.setFillColor(255, 255, 255);
                doc.rect(x, y, textWidth, textHeight, 'F');

                // Set watermark text properties
                doc.setFontSize(fontSize);
                doc.setTextColor(244, 244, 244);
                doc.setFont('helvetica', 'italic');

                // Write watermark text
                doc.text(watermarkText, x, y, {
                    angle: 0, // No rotation
                    opacity: opacity // Adjust opacity
                });
            }
        }

        // Add the Logo
        const logoBase64 = logo;
        const aspectRatio = 480 / 520;
        const desiredWidth = 100;
        const desiredHeight = desiredWidth / aspectRatio;
        doc.addImage(logoBase64, 'PNG', 260, 45, desiredWidth, desiredHeight);

        // Add the header text with improved styling
        doc.setFontSize(16);
        doc.setFont('helvetica', 'bold');
        doc.setTextColor(0, 102, 204);
        doc.text('Land and Development Office', doc.internal.pageSize.width / 2, 180, { align: 'center' });

        // Add the header text with improved styling
        doc.setFontSize(16);
        doc.setFont('helvetica', 'bold');
        doc.setTextColor(0, 102, 204);
        doc.text('Ministry of Housing and Urban Affairs', doc.internal.pageSize.width / 2, 200, { align: 'center' });

        doc.setFontSize(11);
        doc.setFont('helvetica', 'normal');
        doc.setTextColor(0, 0, 0); // Set color to black
        doc.text('Address: Gate-4, A Wing, 6th floor, Moulana Azad Road, Nirman Bhawan, New Delhi, Delhi 110011', doc.internal.pageSize.width / 2, 218, { align: 'center' });

        doc.setFontSize(14);
        doc.setFont('helvetica', 'bold');
        doc.setTextColor(0, 102, 204);
        doc.text('Property/Plot Details', doc.internal.pageSize.width / 2, 260, { align: 'center' });

        // Get the property ID from the input field
        const propertyId = $('#propertyId').val().trim();

        // Get the old property ID from the table
        const table = document.getElementById('property-table');
        let oldPropertyId = '';
        for (let row of table.rows) {
            for (let cell of row.cells) {
                if (cell.textContent.includes('Property No:')) {
                    oldPropertyId = cell.nextElementSibling.textContent.trim();
                    break;
                }
            }
        }

        // Generate a unique code
        const uniqueCode = Math.floor(Math.random() * 1000000).toString().padStart(6, '0');

        // Add the current date to the top right corner
        const date = new Date();
        const formattedDate = date.toLocaleDateString();
        doc.setFontSize(10);
        doc.setFont('helvetica', 'normal');
        doc.setTextColor(0, 0, 0);
        doc.text(`Date: ${formattedDate}`, doc.internal.pageSize.width - 60, 60, { align: 'right' });

        // Add the unique code below the date
        doc.text(`Issue No: ${uniqueCode}`, doc.internal.pageSize.width - 60, 80, { align: 'right' });

        // Calculate the width of each column dynamically
        const margin = 30;
        const tableWidth = pageWidth - 2.8 * margin;
        const columnWidth = tableWidth / table.rows[0].cells.length;

        // Prepare column styles
        let columnStyles = {};
        for (let i = 0; i < table.rows[0].cells.length; i++) {
            columnStyles[i] = { cellWidth: columnWidth, overflow: 'linebreak' };
        }

        // Add the table 
        doc.autoTable({
            html: '#property-table',
            startY: 280,
            theme: 'striped',
            styles: {
                fontSize: 10,
                cellPadding: 10,
                overflow: 'linebreak',
                fontStyle: 'bold',
                lineColor: [0, 0, 0],
                lineWidth: 0.5,
                halign: 'justify'
            },
            headStyles: {
                fillColor: [0, 102, 204],
                textColor: [255, 255, 255],
            },
            alternateRowStyles: {
                fillColor: [238, 238, 228]
            },
            columnStyles: columnStyles,
            margin: { top: 50 },
            pageBreak: 'auto',
            tableWidth: 'wrap'
        });

        // Generate the QR code
        const qrCodeUrl = await new Promise((resolve) => {
            const qrCodeElement = document.createElement('div');
            new QRCode(qrCodeElement, {
                // text: `file:///C:/Program%20Files/Apache%20Software%20Foundation/Tomcat%209.0/webapps/webapps/MIS%20-%20Copy/MIS-Copy%20-V2.html?propertyId=${oldPropertyId}`,
                text: `http://edharti.eu-north-1.elasticbeanstalk.com/map?propertyId=${oldPropertyId}`,
                width: 100,
                height: 100,
                correctLevel: QRCode.CorrectLevel.H
            });
            const qrCodeImg = qrCodeElement.querySelector('img');
            qrCodeImg.onload = () => resolve(qrCodeImg.src);
        });


        // Add the QR code in the left corner above the note with blunt edges and a border
        const qrCodeX = margin + 50;
        const qrCodeY = pageHeight - 220;
        const qrCodeSize = 100;
        const borderRadius = 2;

        // Draw the rounded rectangle border
        doc.setDrawColor(0, 0, 0);
        doc.setLineWidth(1);
        doc.roundedRect(qrCodeX - 2, qrCodeY - 2, qrCodeSize + 4, qrCodeSize + 4, borderRadius, borderRadius);

        // Clip the QR code with a rounded rectangle
        doc.setFillColor(255, 255, 255);
        doc.roundedRect(qrCodeX, qrCodeY, qrCodeSize, qrCodeSize, borderRadius, borderRadius, 'F');
        doc.addImage(qrCodeUrl, 'PNG', qrCodeX, qrCodeY, qrCodeSize, qrCodeSize);
        // doc.addImage(qrCodeUrl, 'PNG', qrCodeX, qrCodeY, 100, 100);

        const logoBases64 = mlogo;
        const logoWidth = 576 / 4; // Set the desired width of the logo
        const logoHeight = 420 / 4; // Set the desired height of the logo
        const logoX = qrCodeX + qrCodeSize + 220;
        const logoY = qrCodeY + (qrCodeSize - logoHeight) / 2;
        doc.addImage(logoBases64, 'PNG', logoX, logoY, logoWidth, logoHeight);

        // Add the portal URL link below the QR code
        // const portalUrl = `file:///C:/Program%20Files/Apache%20Software%20Foundation/Tomcat%209.0/webapps/webapps/MIS%20-%20Copy/MIS-Copy%20-V2.html?propertyId=${oldPropertyId}`;
        // const portalUrl = `${window.location.origin}${window.location.pathname}?propertyId=${oldPropertyId}`; //CHange this url
        const portalUrl = `http://edharti.eu-north-1.elasticbeanstalk.com/map?propertyId=${oldPropertyId}`; //CHange this url
        doc.setFontSize(3);
        doc.setFont('helvetica', 'normal');
        doc.setTextColor(0, 0, 0);
        doc.text(portalUrl, 60, 70, { align: 'left' });

        // Add the footer
        doc.setFontSize(12);
        doc.setFont('helvetica', 'bold');
        doc.setTextColor(0, 0, 0);
        doc.text('Authorised Signatory', doc.internal.pageSize.width / 2, pageHeight - 90, { align: 'center' });

        doc.setFontSize(10);
        doc.setFont('helvetica', 'normal');
        doc.text('Note:', 45, pageHeight - 80);

        doc.setFontSize(8);
        doc.text('(1) This is a digitally signed document only for generic information', 45, pageHeight - 70);

        const noteText = '(2) The information provided is as per updation made by the concerned division based on available records with them. It does not have any legal authenticity till certified by the Competent Authority';
        const wrappedNoteText = doc.splitTextToSize(noteText, 500);

        doc.text(wrappedNoteText, 45, pageHeight - 60);

        // Add a border 
        const contentWidth = pageWidth - 2 * margin;
        const contentHeight = pageHeight - 2 * margin;
        doc.setDrawColor(165, 42, 42); // Brown color
        doc.setLineWidth(3); // Thickness

        doc.rect(margin, margin, contentWidth, contentHeight);

        doc.setDrawColor(0);
        doc.setLineWidth(0.5);

        // Save the PDF
        doc.save('property_details.pdf');
    }



    // MAP Print
    var customActionToPrint = function (context, mode) {
        return function () {
            context._printMode(mode);
        }
    };

    var printControl = L.control.browserPrint({
        title: 'Land and Development Office',
        documentTitle: 'Property Details',
        closePopupsOnPrint: false,
        cancelWithEsc: false,
        contentSelector: "[leaflet-browser-print-content], #header, #map, [leaflet-browser-print-pages]", // Include header content selector
        pagesSelector: "[leaflet-browser-print-pages]",
        printModes: [
            L.BrowserPrint.Mode.Landscape(),
            L.BrowserPrint.Mode.Portrait(),
            L.BrowserPrint.Mode.Custom("A3", {
                title: "Select area",
                action: customActionToPrint,
                pageSize: "A3",
                orientation: 'Landscape'
            })
        ]
    });

    // Adding the print control to your map instance
    printControl.addTo(map); // Assuming `map` is your Leaflet map instance

    // Ensure the content selector includes all necessary elements
    var updateContentSelector = function () {
        var header = document.getElementById('header');
        if (header) {
            header.setAttribute('leaflet-browser-print-content', 'true');
        }
    };
    updateContentSelector();

    //betterFileLayer Plugin
    let fileLayers = [];  // Array to store file layers

    let betterFileLayerControl;
    betterFileLayerControl = L.Control.betterFileLayer({
        fileSizeLimit: 102400,
        position: 'topleft',

        onEachFeature: function (feature, layer) {
            let popupContent = '<div class="popup-scroller">'; // Start of scrollable container

            if (feature.geometry.type === 'Point') {
                // For point features
                popupContent += `<strong>Details</strong><br>
                Latitude: ${feature.geometry.coordinates[1]}<br>
                Longitude: ${feature.geometry.coordinates[0]}<br>`;

                // Label the feature
                layer.bindTooltip(feature.properties.name, { permanent: true, direction: 'center' });
            } else if (feature.geometry.type === 'LineString' || feature.geometry.type === 'Polygon') {
                // For line and polygon features
                popupContent += `<strong>Details</strong><br>`;
                // Label the feature
                layer.bindTooltip(feature.properties.name, { permanent: true, direction: 'center' });
            } else if (feature.geometry.type === 'FeatureCollection') {
                // For FeatureCollection, you may want to loop through individual features
                feature.geometry.features.forEach(subFeature => {
                    popupContent += `<strong>Details</strong><br>
                    Latitude: ${subFeature.geometry.coordinates[1]}<br>
                    Longitude: ${subFeature.geometry.coordinates[0]}<br>`;
                });
            }

            // Display all properties in the popup content
            Object.keys(feature.properties).forEach(key => {
                popupContent += `${key}: ${feature.properties[key]}<br>`;
            });

            popupContent += 'Details'; // End of scrollable container
            // Label the feature
            layer.bindTooltip(feature.properties.name, { permanent: true, direction: 'center' });
            layer.bindPopup(popupContent);
        },
        layer: L.customLayer,
        formats: ['.gpx', '.kml', '.kmz', '.geojson', '.json', '.csv', '.topojson', '.wkt', '.shp', '.shx', '.prj', '.dbf', '.zip'],
        importOptions: {
            csv: {
                delimiter: ';',
                latfield: 'LAT',
                lonfield: 'LONG',
            },
        },
        text: {
            title: "'.gpx', '.kmz', '.geojson', '.json', '.csv', '.topojson', '.wkt', '.shp', '.shx', '.prj', '.dbf', '.zip'",
        },

    });
    betterFileLayerControl.addTo(map);
    document.getElementById('trash').addEventListener('click', function () {
        // Remove all file layers added by the BetterFileLayer control
        fileLayers.forEach(layer => {
            map.removeLayer(layer);
        });

        // Clear the array
        fileLayers = [];

        // showMessage("KML deleted successfully.");
    });

    // Listen for the 'bfl:layerloaded' event to track added layers
    map.on('bfl:layerloaded', function (event) {
        fileLayers.push(event.layer);
    });


    //         } catch (error) {
    //             console.error('Error loading shapefile:', error);
    //             throw error; // Rethrow the error for handling elsewhere if needed.
    //         }
    //     };

    //     // Call the function to load and add the shapefile to the map
    //     loadAndAddShapefileToMap();

});

