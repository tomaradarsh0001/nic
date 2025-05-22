var google = L.tileLayer(
  "https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}",
  {
    zIndex: 50,
    opacity: 1,
    maxZoom: 20,
    subdomains: ["mt0", "mt1", "mt2", "mt3"],
    attribution: '©DFW, Google 2023© <a href="" target="_blank"></a>',
  }
);

var googlestreet = L.tileLayer(
  "https://mt1.google.com/vt/lyrs=r&x={x}&y={y}&z={z}",
  {
    zIndex: 50,
    opacity: 1,
    maxZoom: 20,
    attribution: '© Google 2023© <a href="" target="_blank"></a>',
  }
);

var map = L.map("map", {
  center: [28.635781888792277, 77.17983510997755],
  zoom: 15,
  minZoom: 8,
  scrollWheelZoom: true,
  dragging: true,
  doubleClickZoom: true,
  zoomControl: true,
  attributionControl: false,
  layers: [googlestreet],
  maxBounds: [
    [29.00708947145038, 76.64878806249736], // Southwest corner of the bounding box
    [28.363761223602285, 77.53999678065577], // Northeast corner of the bounding box
  ],
});

// Geocode(Deb)
var geocoder = L.Control.geocoder({
  query: "",
  placeholder: "Search your location",
  defaultMarkGeocode: false,
}).addTo(map);

var marker = null; // Initialize the marker variable

// Function to remove the marker
function removeMarker() {
  if (marker) {
    map.removeLayer(marker); // Remove the existing marker if it exists
    marker = null; // Reset the marker variable
  }
}

geocoder.on("markgeocode", function (event) {
  var latlng = event.geocode.center;

  removeMarker(); // Call the function to remove the marker

  marker = L.marker(latlng).addTo(map);
  marker.bindPopup(event.geocode.name).openPopup(); // Display geocode information in a popup on the marker

  map.setView(latlng, 15);
});

// Add an event listener to the "Delete Location Marker" button
document.getElementById("trash").addEventListener("click", function () {
  removeMarker();
});

//Load Layer
var vtLayer = L.vectorGrid.slicer(pro);
// Define styles for different properties(Debobrata Sadhukhan)
var freeHoldStyle = {
  color: "#006599",
  weight: 2,
  opacity: 1,
  fillOpacity: 0.7,
};

var leaseHoldStyle = {
  color: "#f0ad4e",
  weight: 2,
  opacity: 1,
  fillOpacity: 0.7,
};

// Function to determine the style
function getStyle(feature) {
  switch (feature.properties.status) {
    case "Free Hold":
      return freeHoldStyle;
    case "Lease Hold":
      return leaseHoldStyle;
    default:
      return {
        color: "grey",
        weight: 2,
        opacity: 1,
        fillOpacity: 0.7,
      };
  }
}

// Initialize  property layer
var property = L.geoJSON(pro, {
  style: getStyle,
  onEachFeature: function (feature, layer) {
    var properties = feature.properties;

    var backgroundColor = "";
    if (properties.status === "Free Hold") {
      backgroundColor = "#5394b53b";
      fontcolor = "#000";
      className = "freeHoldContent";
    } else if (properties.status === "Lease Hold") {
      backgroundColor = "#efb35e3b";
      fontcolor = "#000";
      className = "leaseHoldContent";
    } else if (properties.status === "Vacand Land") {
      backgroundColor = "##e5696c3b";
      fontcolor = "#000";
      className = "leaseHoldContent";
    } else {
      backgroundColor = "white";
      fontcolor = "#000";
      className = "";
    }
    var popupContent = `
                  <div class="popup-content ${className}" style="text-align: left; padding: 3px; font-size: 12px; background-color: ${backgroundColor}; color: ${fontcolor}">
                      <h3 style="text-align: center; font-size: 16px; margin-bottom: 15px; font-weight: bold;">Property Details</h3>
                      <hr style="border: 0; height: 1px; background: #333; margin-bottom: 10px;">
                      <p><strong>Property ID:</strong> ${properties.old_propert_id}</p>
                      <p><strong>Status:</strong> ${properties.status}</p>
                      <p><strong>Land Use:</strong> ${properties.land_use}</p>
                      <p><strong>Area (Sqmts):</strong> ${properties.area_in_sqm}</p>
                      <p><strong>Address:</strong> ${properties.address}</p>
                      <p><strong>Lessee Name:</strong> ${properties.lesse_name}</p>
                      <a href="/map" target="_blank" class="text-primary">View All Properties</a>
                  </div>
              `;

    layer.bindPopup(popupContent);

    layer.on("click", function () {
      layer.openPopup();
    });
  },
}).addTo(map);

var baseMaps = {
  "Google Satellite": google,
  "Google Street": googlestreet,
};
var overlayMaps = {
  Properties: property,
  // 'Vacant Land': property_v
};

var controlLayers = L.control
  .layers(baseMaps, overlayMaps, {
    position: "bottomleft",
    collapsed: true,
  })
  .addTo(map);

/* var legend = L.control
  .Legend({
    position: "bottomright",
    title: "Legend",
    collapsed: false,
    symbolWidth: 24,
    opacity: 0.8,
    legends: [
      {
        label: "Lease Hold",
        type: "image",
      },
      {
        label: "Free Hold",
        type: "image",
        // url: "./../assets/MIS/Blue.png",
      },
    ],
  })
  .addTo(map); */

var legend = L.control
  .Legend({
    position: "bottomright",
    title: "Legend",
    collapsed: false,
    symbolWidth: 24,
    opacity: 0.8,
    legends: [
      {
        label: "Selection",
        type: "image",
        // url: "assets/MIS_V3/logo/Green.png",
      },
      {
        label: "Lease Hold",
        type: "image",
        // url: "assets/MIS_V3/logo/Yellow.png",
      },
      {
        label: "Free Hold",
        type: "image",
        // url: "assets/MIS_V3/logo/Blue.png",
      },
      {
        label: "Vacant Land",
        type: "image",
        // url: "assets/MIS_V3/logo/Red.png",
      },
    ],
  })
  .addTo(map);

// Function to manage displaying labels for a specific feature
function displayLabelForFeature(propertyId) {
  var foundProperty = false;

  // Reset all labels by removing the label layer
  map.eachLayer(function (layer) {
    if (
      layer instanceof L.Marker &&
      layer.options.icon.options.className === "leaflet-label"
    ) {
      map.removeLayer(layer);
    }
  });

  // Add label for the found property
  property.eachLayer(function (layer) {
    var properties = layer.feature.properties;

    if (
      properties.old_propert_id === propertyId ||
      properties.unique_propert_id === propertyId
    ) {
      var labelMarker = L.marker(layer.getBounds().getCenter(), {
        icon: L.divIcon({
          className: "leaflet-label",
          html: properties.old_propert_id,
          iconSize: [60, 20],
          iconAnchor: [30, 10],
        }),
      }).addTo(map);

      foundProperty = true;

      // Zoom to the layer's bounds
      map.fitBounds(layer.getBounds());

      // Highlight the layer found
      layer.setStyle({
        color: "green",
        fillOpacity: 0.5,
      });
    }
  });

  if (!foundProperty) {
    $("#notFoundAlert").removeClass("d-none");
    setTimeout(() => {
      $("#notFoundAlert").addClass("d-none");
    }, 5000);
  }
}

// Remove all labels
map.eachLayer(function (layer) {
  if (
    layer instanceof L.Marker &&
    layer.options.icon.options.className === "leaflet-label"
  ) {
    map.removeLayer(layer);
  }
});
// });


function getBaseURLMap() {
  const { protocol, hostname, port } = window.location;
  return `${protocol}//${hostname}${port ? ":" + port : ""}`;
}


var iconLayersControl = new L.Control.IconLayers(
  [
    {
      title: "Map",
      layer: googlestreet,
      icon: getBaseURLMap() + "/assets/MIS/street.png",
    },
    {
      title: "Satellite",
      layer: google,
      icon: getBaseURLMap() + "/assets/MIS/sattelite.png",
    },
  ],
  {
    position: "bottomright",
    maxLayersInRow: 20,
  }
);

iconLayersControl.addTo(map);

iconLayersControl.on("activelayerchange", function (e) {
  console.log("layer switched", e.layer);
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
        iconSize: this._map.getSize().multiplyBy(2),
      })
    );
  },
});

// Measurement
var measure = L.control
  .measure({
    primaryLengthUnit: "kilometers",
    secondaryLengthUnit: "meters",
    primaryAreaUnit: "hectares",
    secondaryAreaUnit: "acres",
    position: "topleft",
    crs: L.CRS.EPSG3857,
  })
  .addTo(map);

function locate(propertyId) {
  $(".propId").text(propertyId);
  if (propertyId > 0) {
    setTimeout(function () {
      locateProperty(propertyId);
    }, 1000);
  }
}

$("#viewMapModal").on("show.bs.modal", function () {
  setTimeout(function () {
    map.invalidateSize();
  }, 400);
});
const defaultLatitude = 28.635781888792277;
const defaultLongitude = 77.1798351099775;

function locateProperty(propertyId) {
  propertyId = propertyId.toString();
  foundProperty = false;

  property.eachLayer(function (layer) {
    var properties = layer.feature.properties;
    if (
      properties.old_propert_id == propertyId ||
      properties.unique_propert_id == propertyId
    ) {
      foundProperty = true;

      // Zoom to the layer's bounds
      map.fitBounds(layer.getBounds());

      property.resetStyle();
      displayLabelForFeature(propertyId);
    }
  });
  if (!foundProperty) {
    $("#notFoundAlert").removeClass("d-none");
    setTimeout(() => {
      $("#notFoundAlert").addClass("d-none");
    }, 5000);
    map.setView([defaultLatitude, defaultLongitude], 15);
  }
}
