<!-- Font SS -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merriweather|Open+Sans" />
<link href="https://fonts.googleapis.com/css?family=DM Sans" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.2.0/normalize.min.css" />

<!-- JSQUERY CSS -->

<!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css" /> -->

<!-- Bootstrap -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" /> -->
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/css/bootstrap-slider.min.css"rel="stylesheet"> -->

<!-- Leaflet CSS-->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
{{-- <link rel="stylesheet" href="{{asset('assets/MIS_V3/leaflet-labeler.css')}}" /> --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-tooltip@1.0.4/dist/tooltip.min.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<link rel="stylesheet" href="https://ptma.github.io/Leaflet.Legend/src/leaflet.legend.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-measure/dist/leaflet-measure.css" />
<link rel="stylesheet" href="https://scanex.github.io/Leaflet-IconLayers/src/iconLayers.css" />

<!-- SCRIPT -->

<!-- jQuery -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> -->

<!-- Bootstrap Script  -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/bootstrap-slider.min.js"></script> -->

<!-- LEAFLET -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.4.4/proj4.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
{{-- <script src="{{asset('assets/MIS_V3/leaflet-labeler.js')}}"></script> --}}
<script src="https://unpkg.com/geojson-vt@3.2.0/geojson-vt.js"></script>
<script src="https://unpkg.com/leaflet.vectorgrid@latest/dist/Leaflet.VectorGrid.js"></script>
<script src="https://unpkg.com/@mapbox/leaflet-vector-grid@latest/dist/Leaflet.VectorGrid.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet-tooltip@1.0.4/dist/L.Tooltip.min.js"></script>
<script src="https://unpkg.com/leaflet-measure/dist/leaflet-measure.js"></script>
<script src=" https://ish.lol/leaflet-groupedlayercontrol/src/leaflet.groupedlayercontrol.js"></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet-tooltip@1.0.4/dist/L.Tooltip.min.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script src="https://ptma.github.io/Leaflet.Legend/src/leaflet.legend.js"></script>
<script src="https://scanex.github.io/Leaflet-IconLayers/src/iconLayers.js"></script>

<!-- jSPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>

<!-- Geojson Data -->
<script src="{{asset('assets/MIS_V5.1/Geojson_s/Property_25999.js')}}"></script>
{{-- <script src="{{asset('assets/MIS_V3/Geojson_s/Vacant_Land_P3.js')}}"></script>
<script src="{{asset('assets/MIS_V3/Logo.js')}}"></script>  --}}

</head>
<style>
    .leaflet-label {
        font-weight: bold;
        text-align: center;
        color: black;
        font-family: 'Times New Roman';
        font-size: 12px;
        white-space: normal;
        min-width: 60px;
        text-shadow: -1px -1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff, 1px 1px 0 #fff;
    }

    .popup-content p {
        border-bottom: 1px solid #bbb;
    }

    /* Div Height MAP */
    #map {
        height: 70vh;
    }

    .custom-tooltip-class {
        font-weight: bold;
        white-space: normal;
        text-align: center;
        color: rgb(255, 3, 70);
        min-width: 10px;
        text-shadow: 4px 3px 4px rgba(0, 0, 0, 0.5);
    }

    .leaflet-legend-title {
        font-weight: bold;
        font-size: 20px;
        margin: 3px;
        padding-bottom: 5px;
    }

    .leaflet-legend-item {
        font-weight: bold;
        font-size: 14px;
        display: table;
        margin: 2px 0;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: rgb(170, 168, 168);
        border-radius: 50%;
    }

    .custom-carousel-control {
        filter: invert(1);
    }


    #floating-table {
        display: none;
        position: absolute;
        top: 100px;
        right: 10px;
        background: white;
        border: 1px solid #ccc;
        padding: 10px;
        z-index: 9999;
        border: 2px solid #007bff;
        border-radius: 15px;
        text-align: center;
        width: 800px;
        font-family: 'Times New Roman';
    }

    #floating-table table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    #floating-table th,
    #floating-table td {
        border: 1px solid #ddd;
        padding: 8px;
        word-wrap: break-word;
        font-family: ' Times New Roman';
        user-select: text;
    }

    #floating-table th {
        font-weight: bold;
    }

    #floating-table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #floating-table td {
        font-weight: bold;
    }



    /* Diwakar Sinha */
    .custom-inner-header {
        padding: 1px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .custom-inner-header h3 {
        font-size: 22px;
        color: #0f3557;
    }

    .e-dharti-logo {
        width: 380px;
    }

    main header {
        padding: 16px 40px;
        background-color: white ! important;
        border-bottom: 15px solid #0f3557;
    }

    img.right_img {
        max-height: 80px;
        /* border-radius: 10px; */
        /* box-shadow: 0px 0px 10px #ddd; */
    }

    main {
        position: relative;
    }

    .map-search-float {
        position: absolute;
        width: 420px;
        height: auto;
        top: 10px;
        left: 60px;
        z-index: 999999;
    }

    .search-bar input {
        height: auto;
        font-size: 14px;
        color: #000 !important;
        border: 0px;
        padding: 10px 0px;
        border-right: 1px solid #ddd;
        border-radius: 0px;
        width: 100%;
        margin-right: 10px;
    }

    .search-bar {
        padding: 8px 22px;
        height: auto;
        background: white;
        border-radius: 50px;
        display: flex;
        align-items: center;
        margin-bottom: 0px;
        box-shadow: 4px 4px 4px 0px #00000030;
    }

    .form-control:focus {
        box-shadow: none !important;
        border: none !important;
    }

    .search_btn {
        border-radius: 50px;
        width: 40px !important;
        height: 40px !important;
        padding: 0px;
        line-height: 0px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #007bff;
        border: 0px;
        color: white;
        transition: .3s all;
    }

    .search_btn:hover {
        background: #007bffd6;
    }

    .map_view {
        position: relative;
    }

    ul#ui-id-1 {
        z-index: 9999999;
        border: 0px !important;
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
        padding: 0px 10px;
        box-shadow: 4px 4px 4px 0px #00000030;
    }

    ul#ui-id-1 li {
        padding: 10px;
        color: black;
        border-bottom: 1px solid #ddd;
    }

    ul#ui-id-1 li:last-child {
        border-bottom: 0px !important;
    }

    .search_btn-group {
        display: flex;
        gap: 4px;
    }

    .threed_btn {
        border-radius: 50px;
        width: 40px !important;
        height: 40px !important;
        padding: 0px;
        line-height: 0px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #007bff;
        border: 0px;
        color: #fff !important;
        transition: .3s all;
        border: 2px solid #007bff;
        font-weight: 600;
        font-size: 15px;
        box-shadow: 0px 1px 0px #007bff;
        position: absolute;
        z-index: 9999;
        right: 10px;
        top: 55px;
    }

    .threed_btn:hover {
        background: #007bffd7;
    }

    .trash_btn {
        border-radius: 50px;
        width: 40px !important;
        height: 40px !important;
        padding: 0px;
        line-height: 0px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border: 0px;
        color: #dc3545;
        transition: .3s all;
        border: 2px solid #dc3545;
        font-weight: 600;
        font-size: 15px;
        box-shadow: 0px 1px 0px #dc3545;
    }

    .trash_btn:hover {
        background: #dc3545;
        color: white;
    }

    .bs-actionsbox,
    .bs-donebutton,
    .bs-searchbox .form-control:focus {
        border-color: #86b7fe;
        outline: 0;
        box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25) !important;
        border: 1px solid #ced4da !important;
    }

    /* 
    .leaflet-bottom>div:nth-child(2) {
        margin-left: 25px;
    }

    .leaflet-legend-expanded .leaflet-legend-contents {
        padding: 6px !important;
    }

    .leaflet-touch .leaflet-bar button {
        border-radius: 50px;
        width: 38px !important;
        height: 38px !important;
        padding: 0px;
    }

    .leaflet-legend-title {
        font-weight: bold;
        font-size: 18px !important;
        margin: 0px !important;
        padding-bottom: 3px !important;
    }

    .leaflet-legend-column {
        float: left;
        margin-left: 0 !important;
    }

    .leaflet-legend.leaflet-bar.leaflet-control.leaflet-legend-expanded {
        border-radius: 10px;
    }

    .leaflet-legend-item {
        font-weight: bold;
        font-size: 12px;
        display: table;
        margin: 2px 0;
    }

    .leaflet-legend-item i {
        width: 18px !important;
        height: 18px !important;
        border-radius: 0px !important;
        margin-right: 8px;
    } */

    a {
        color: inherit !important;
        text-decoration: none;
    }

    .h3,
    h3 {
        font-size: 1.0rem;
    }

    #viewMapModal .modal-header {
        display: flex;
        justify-content: space-between;
    }

    #viewMapModal .btn-danger {
        margin: 0px 5px;
        flex: 2;
    }

    #viewMapModal .modal-header .btn-close {
        margin: 0 !important;
        padding: 0 !important;
    }

    a.btn-primary {
        color: #fff !important;
    }

    /* button.close {
        float: right;
        border: none;
        background: none;
    } */
    .leaflet-legend-item:nth-child(1) i {
    background-color: #66b070;
    border-radius: 5px;
    margin-right: 8px;
}
.leaflet-legend-item:nth-child(2) i {
    background-color: #eeb35f;
    border-radius: 5px;
    margin-right: 8px;
}
    .leaflet-legend-item:nth-child(3) i {
    background-color: #4f95b9;
    border-radius: 5px;
    margin-right: 8px;
}
.leaflet-legend-item:nth-child(4) i {
    background-color: #e5696c;
    border-radius: 5px;
    margin-right: 8px;
}
.leaflet-legend-item i img {
    display: none !important;
}
/* #5394b5 */
</style>


<!-- change the DIV here -->
<main>
    <div id="map" class="map_view">
        <a href="https://dfwgnctd.maps.arcgis.com/apps/instant/3dviewer/index.html?appid=7292401d0ef943b584440df376f0b3ee" target="_blank" class="threed_btn" title="3D View">3D</a>
        <div class="map-search-float" style="display:none">
            <form id="searchForm">
                <div class="form-group search-bar">
                    <input type="text" class="form-control" id="propertyId" placeholder="Search by Property ID/Vacant Land" />
                    <div class="search_btn-group">
                        <button type="submit" class="search_btn">
                            <i class="fas fa-search"></i>
                        </button>
                        <button type="button" class="trash_btn" id="trash">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Form for Search -->

    <!-- Table for property details -->
    <div id="floating-table" style="display: none">
        <button type="button" class="close" aria-label="Close" id="closeFloatingTable">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4>Property Details &nbsp;&nbsp; - &nbsp;&nbsp;<span id="prop-id"></span></h4>
        <table id="property-table" class="table">
            <thead>
                <tr>
                    <th>Attribute</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <!-- Table body dynamic -->
            </tbody>
        </table>
        <!-- <button id="downloadPDFButton">Download PDF</button> -->
        <!-- <button id="downloadPDF" class="btn btn-primary">Download PDF</button> -->
    </div>
</main>
