<script src="{{ asset('assets/js/map.js') }}"></script>
<script src="{{ asset('assets/MIS_V5.1/Geojson_s/Property_25999.js') }}"></script>

  <script>
    function locate2(propertyId){
        // console.log(propertyId,pro);
        let data = pro.features;
        let found = data.find(row=>row.properties.propertyid == propertyId.toString());
        if(found){
            let coordinates = found.geometry.coordinates[0];
            console.log(coordinates[0]);
            return coordinates[0];
        }
    }

      function initialize() {
        var [latt,longi] = locate2({{$propertyid}});
        const fenway = { lat:longi , lng: latt };
        const map = new google.maps.Map(document.getElementById("map"), {
          center: fenway,
          zoom: 14,
        });
        const panorama = new google.maps.StreetViewPanorama(
          document.getElementById("pano"),
          {
            position: fenway,
            pov: {
              heading: 34,
              pitch: 10,
            },
          }
        );
        map.setStreetView(panorama);
      }

      window.initialize = initialize;
    </script>
    <style>
      html,
      body {
        height: 100%;
        margin: 0;
        padding: 0;
      }

      #map,
      #pano {
        float: left;
        height: 100%;
        width: 50%;
      }
    </style>

    <div id="map"></div>
    <div id="pano"></div>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCas7Ce7ycj4zRlD3fx53GvhreTVS-g6TI&callback=initialize"
      async
      defer
    ></script>
  
