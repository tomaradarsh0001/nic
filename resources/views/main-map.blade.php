<!DOCTYPE html>
<html lang="en">

<head>
    <title>e-Dharti Geo Portal 2.0</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{asset('assets/MIS_V5.1/Logo/logos.png')}}" type="image/x-icon" />
    <!-- Font SS -->
     
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merriweather|Open+Sans">
    <link href='https://fonts.googleapis.com/css?family=DM Sans' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.2.0/normalize.min.css">

    <!-- JSQUERY CSS -->

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" />
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/css/bootstrap-slider.min.css"rel="stylesheet"> -->

    <!-- Leaflet CSS-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- <link rel="stylesheet" href="./leaflet-labeler-master/leaflet-labeler.css" /> -->
    <link rel="stylesheet" href="https://samanbey.github.io/leaflet-labeler/leaflet-labeler.css" />
    
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@v0.74.0/dist/L.Control.Locate.min.css" /> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-tooltip@1.0.4/dist/tooltip.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <link rel="stylesheet" href="https://ptma.github.io/Leaflet.Legend/src/leaflet.legend.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-measure/dist/leaflet-measure.css" />
    <link rel="stylesheet" href="https://scanex.github.io/Leaflet-IconLayers/src/iconLayers.css">

    <!-- <link rel="stylesheet" href="./style.css"> -->
    <link rel="stylesheet" href="{{asset('assets/MIS_V5.1/style.css')}}">

</head>

<body>
    <header id="header">
        <div class="custom-inner-header">
            <div class="header-logo">
                <img style="height:auto;" src="{{asset('assets/MIS_V5.1/Logo/ldologo.png')}}" class="e-dharti-logo">
            </div>
    
            <div class="brand_label">
                <h3>
                    <span class="world">
                        <span class="images">
                            <svg>
                                <use href="#icon-repeated-world"></use>
                            </svg>
                        </span>
                    </span>
                    <span class="eDharti-bold">eDharti Geo Portal</span><sup class="superscript">V2.0</sup>
                </h3>
                <a href="#" target="_blank" class="metaverse-link">
                    <span style="display: block; font-size: 1.3em; color: #007bff ;">MetaVerse</span>
                </a>
            </div>
        </div>
    </header>
    

            <!-- SVG Globe Animation -->
            <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1"
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <defs>
                    <symbol id="icon-world" viewBox="0 0 216 100">
                        <!-- Path data for the world icon -->
                        <g fill-rule="nonzero">
                            <path
                                d="M48 94l-3-4-2-14c0-3-1-5-3-8-4-5-6-9-4-11l1-4 1-3c2-1 9 0 11 1l3 2 2 3 1 2 8 2c1 1 2 2 0 7-1 5-2 7-4 7l-2 3-2 4-2 3-2 1c-2 2-2 9 0 10v1l-3-2zM188 90l3-2h1l-4 2zM176 87h2l-1 1-1-1zM195 86l3-2-2 2h-1zM175 83l-1-2-2-1-6 1c-5 1-5 1-5-2l1-4 2-2 4-3c5-4 9-5 9-3 0 3 3 3 4 1s1-2 1 0l3 4c2 4 1 6-2 10-4 3-7 4-8 1zM100 80c-2-4-4-11-3-14l-1-6c-1-1-2-3-1-4 0-2-4-3-9-3-4 0-5 0-7-3-1-2-2-4-1-7l3-6 3-3c1-2 10-4 11-2l6 3 5-1c3 1 4 0 5-1s-1-2-2-2l-4-1c0-1 3-3 6-2 3 0 3 0 2-2-2-2-6-2-7 0l-2 2-1 2-3-2-3-3c-1 0-1 1 1 2l1 2-2-1c-4-3-6-2-8 1-2 2-4 3-5 1-1-1 0-4 2-4l2-2 1-2 3-2 3-2 2 1c3 0 7-3 5-4l-1-3h-1l-1 3-2 2h-1l-2-1c-2-1-2-1 1-4 5-4 6-4 11-3 4 1 4 1 2 2v1l3-1 6-1c5 0 6-1 5-2l2 1c1 2 2 2 2 1-2-4 12-7 14-4l11 1 29 3 1 2-3 3c-2 0-2 0-1 1l1 3h-2c-1-1-2-3-1-4h-4l-6 2c-1 1-1 1 2 2 3 2 4 6 1 8v3c1 3 0 3-3 0s-4-1-2 3c3 4 3 7-2 8-5 2-4 1-2 5 2 3 0 5-3 4l-2-1-2-2-1-1-1-1-2-2c-1-2-1-2-4 0-2 1-3 4-3 5-1 3-1 3-3 1l-2-4c0-2-1-3-2-3l-1-1-4-2-6-1-4-2c-1 1 3 4 5 4h2c1 1 0 2-1 4-3 2-7 4-8 3l-7-10 5 10c2 2 3 3 5 2 3 0 2 1-2 7-4 4-4 5-4 8 1 3 1 4-1 6l-2 3c0 2-6 9-8 9l-3-2zm22-51l-2-3-1-1v-1c-2 0-2 2-1 4 2 3 4 4 4 1z" />
                        </g>
                    </symbol>
                    <symbol id="icon-repeated-world" viewBox="0 0 432 100">
                        <use href="#icon-world" x="0"></use>
                        <use href="#icon-world" x="189"></use>
                    </symbol>
                </defs>
            </svg>


        </div>
    </header>



    <!-- <header id="header">
        <div class="custom-inner-header">
            <div class="header-logo">
                <img style="height:auto;"
                    src="https://dfwgnctd.maps.arcgis.com/sharing/rest/content/items/7292401d0ef943b584440df376f0b3ee/resources/media/instantAppsConfigPanel_1717672004862_customHeaderHTML_textEditor_1717672004472.png"
                    class="e-dharti-logo">
            </div>
            <div class="brand_label">
                <h3>e-Dharti Geo-Portal 2.0</h3>
                <a href="https://dfwgnctd.maps.arcgis.com/apps/instant/3dviewer/index.html?appid=7292401d0ef943b584440df376f0b3ee"
                    target="_blank" class="neon_animation">MetaVerse</a>
            </div>
            
        </div>
    </header> -->
    <main>

        <!-- change the DIV here -->

        <div id="map" class="map_view"></div>
        <div>
            <!-- <button class="leaflet-control-geocoder-icon" type="button" aria-label="Initiate a new search"><i class="fa-solid fa-magnifying-glass-location"></i></button> -->
            <div class="leaflet-control-geocoder-form"><input class="" type="text" placeholder="Search your location">
            </div>
            <a href="#"
                target="_blank" class="threed_btn" title="3D View">3D</a>
            <div class="map-search-float">
                <form id="searchForm">
                    <div class="form-group search-bar">
                        <input type="text" class="form-control" id="propertyId"
                            placeholder="Search by Property ID/Vacant Land">
                        <div class="search_btn-group">
                            <button type="submit" class="search_btn"><i class="fas fa-search"></i></button>
                            <button type="button" class="trash_btn" id="trash" title="Clear View"><i
                                    class="fas fa-times"></i></button>

                        </div>
                    </div>
                </form>
            </div>
        </div>

<!-- Binoculars Icon to Open Distance Modal -->
<div class="distance-icon" title="Search Nearby Properties" data-toggle="modal" data-target="#distanceInputModal">
    <i class="bi bi-binoculars-fill"></i>
</div>


<!-- Modal for Distance Input -->
<div class="modal fade" id="distanceInputModal" tabindex="-1" aria-labelledby="distanceInputModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="distanceInputModalLabel">Enter Distance From Current Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="number" id="distanceInput" class="form-control" placeholder="Enter distance in meters">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="submitDistance">Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Displaying Nearby Properties -->
<div class="modal fade" id="nearbyPropertiesModal" tabindex="-1" aria-labelledby="nearbyPropertiesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nearbyPropertiesModalLabel">Nearby Properties</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="feature-counter"></div>
                <table class="table" id="nearby-properties-table">
                    <thead>
                        <tr>
                            <th>Property No</th>
                            <th>Unique Property ID</th>
                            <th>Address</th>
                            <th>Lesse Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Rows will be populated here dynamically -->
                    </tbody>
                </table>

                <!-- Pagination Controls -->
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center" id="pagination">
                        <!-- Pagination items will be dynamically added here -->
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- feature tool  -->

<!-- Add this button to your HTML -->
<button id="toggle-draw" class="draw-button"  title="Select Properties">
    <i class="fas fa-pencil-alt"></i>
</button>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Selected Features</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-content">
                    <!-- Dynamic content will be injected here -->
                </div>
                <div id="paginations" class="d-flex justify-content-center mt-3">
                    <!-- Pagination buttons will be injected here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

        <!-- time control -->
        <!-- <div class="time-control">Shadows
            <input id="date" type="range" min="1" max="365" step="1"><label for="date"></label>
            <input id="time" type="range" min="0" max="23" step="1"><label for="time"></label>
        </div> -->

        <!-- Spinner (hidden initially) -->
        <div id="spinner" style="display: none;">
            <img src="{{asset('assets/MIS_V5.1/Logo/Spin.gif')}}" alt="Loading..." />
        </div>
        <!-- 
                <div class="spinner-border" id-  style="width: 3rem; height: 3rem;" role="status">
                    <span class="sr-only">Loading...</span>
                  </div> -->
        <!-- <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
                    <span class="sr-only">Loading...</span>
                  </div> -->

        <!-- Form for Search -->


        <!-- Table for property details -->
        <div id="floating-table" style="display: none;">
            <button type="button" class="close" aria-label="Close" id="closeFloatingTable">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4>Property Details</h4>
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
            <a id="downloadPDF" class="text-primary"> <i class="fas fa-file-pdf text-danger"></i> Download PDF</a>
        </div>



        
<!-- Button to open the modal -->
<!-- Icon for triggering the distance input modal -->


        <!-- Filter Modal -->
        <div class="filter-icon" title="Open Filter" data-toggle="modal" data-target="#filterModal">
            <i class="fas fa-filter"></i>
        </div>
        <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filterModalLabel">Filter Properties</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Filter Form -->
                        <form id="filterForm">
                            <!-- Layer Selection -->
                            <div class="form-group">
                                <label for="layerSelect">Choose Layer</label>
                                <select class="form-control" id="layerSelect">
                                    <option value="">Select Layer</option>
                                    <option value="property">Properties</option>
                                    <option value="vacant">Vacant Lands</option>
                                </select>
                            </div>

                            <!-- Attribute Selection -->
                            <div class="form-group">
                                <label for="attributeSelect">Choose Attribute</label>
                                <select class="form-control" id="attributeSelect">
                                    <option value="">Select Attribute</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                            </div>

                            <!-- Condition Selection -->
                            <div class="form-group">
                                <label for="conditionSelect">Condition</label>
                                <select class="form-control" id="conditionSelect">
                                    <option value="like">Like</option>
                                    <option value="equal">Equal to</option>
                                    <option value="greater">Greater than</option>
                                    <option value="less">Less than</option>
                                    <option value="notEqual">Not equal to</option>

                                    <option value="range">Range</option>
                                </select>
                            </div>

                            <!-- Value Input -->
                            <div class="form-group" id="valueInputContainer">
                                <label for="valueInput">Value</label>
                                <input type="text" class="form-control" id="valueInput" placeholder="Enter Value">
                            </div>

                            <!-- Range Input -->
                            <div class="form-group d-none" id="rangeInputContainer">
                                <label>Range</label>
                                <div class="row">
                                    <div class="col">
                                        <input type="number" class="form-control" id="rangeStart" placeholder="Start">
                                    </div>
                                    <div class="col">
                                        <input type="number" class="form-control" id="rangeEnd" placeholder="End">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Apply Filter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Floating Modal for Filtered Data -->
        <!-- Floating Modal for Filtered Data with Scrollable Content -->
        <div class="modal fade" id="filteredDataModal" tabindex="-1" role="dialog"
            aria-labelledby="filteredDataModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filteredDataModalLabel">Filtered Query</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Display total count of filtered records -->
                        <div id="filteredCount" class="mb-2">
                            <!-- Count will be injected here -->
                        </div>
                        <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                            <!-- Table for displaying filtered data -->
                            <table class="table table-bordered table-hover" id="filteredDataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Property No / Vacant Land Name</th>
                                        <th>Unique Property ID / Area (Sqmts)</th>
                                        <th>Address</th>
                                        <th>Lessee Name</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <!-- Pagination Controls inside modal footer -->
                            <nav aria-label="Page navigation" id="pagination" class="w-100">
                                <ul class="pagination justify-content-center mb-0">
                                    <!-- Pagination items will be dynamically added here -->
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bootstrap icon for filter modal -->
            <!-- <i class="fas fa-filter" id="filterIcon" data-toggle="modal" data-target="#filterModal"></i> -->


    </main>


    <footer id="footer" class="footer-color text-center w-100 py-1">
        <p class="text-white mb-0">© 2024 Land & Development Office. All rights reserved.</p>
    </footer>

    </div>

</body>
<!-- SCRIPT -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<!-- Bootstrap Script  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/bootstrap-slider.min.js"></script> -->

<!-- LEAFLET -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.4.4/proj4.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://samanbey.github.io/leaflet-hatchclass/leaflet-hatchclass.js"></script>
<script src="https://samanbey.github.io/leaflet-labeler/leaflet-labeler.js"></script>
<script src="https://unpkg.com/geojson-vt@3.2.0/geojson-vt.js"></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.74.0/dist/L.Control.Locate.min.js"
    charset="utf-8"></script>
<script src="https://unpkg.com/leaflet.vectorgrid@latest/dist/Leaflet.VectorGrid.js"></script>
<script src="https://unpkg.com/@mapbox/leaflet-vector-grid@latest/dist/Leaflet.VectorGrid.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet-tooltip@1.0.4/dist/L.Tooltip.min.js"></script>
<script src="https://unpkg.com/leaflet-measure/dist/leaflet-measure.js"></script>
<script src=" https://ish.lol/leaflet-groupedlayercontrol/src/leaflet.groupedlayercontrol.js"></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet-tooltip@1.0.4/dist/L.Tooltip.min.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script src="https://ptma.github.io/Leaflet.Legend/src/leaflet.legend.js"></script>
<script src="https://scanex.github.io/Leaflet-IconLayers/src/iconLayers.js"></script>


<script src="https://samanbey.github.io/leaflet-hatchclass/leaflet-hatchclass.js"></script>



<!-- jSPDF -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<!-- leafletprint -->
<!-- Print -->

<script src="https://cdn.jsdelivr.net/npm/leaflet.browser.print@2.0.2/dist/leaflet.browser.print.min.js"></script>


<!-- Geojson Data -->
<!-- <script src="./Geojson_s/Property_10739.js"></script> -->
<script src="{{asset('assets/MIS_V5.1/Geojson_s/Property_25999.js')}}"></script>
<!-- <script src="./Geojson_s/Vacant_Land.js"></script> -->
<script src="{{asset('assets/MIS_V5.1/Geojson_s/VacantLand_37.js')}}"></script>
<script src="{{asset('assets/MIS_V5.1/Logo/logo.js')}}"></script>
<script src="{{asset('assets/MIS_V5.1/Logo/mlogo.js')}}"></script>
<script src="{{asset('assets/MIS_V5.1/mains.js')}}"></script>
<script src="{{asset('assets/MIS_V5.1/Geojson_s/Lease_.js')}}"></script>
<script src="{{asset('assets/MIS_V5.1/Geojson_s/ps_I.js')}}"></script>
<script src="{{asset('assets/MIS_V5.1/Geojson_s/ps_II.js')}}"></script>
<script src="{{asset('assets/MIS_V5.1/Geojson_s/ps_III.js')}}"></script>
<script src="{{asset('assets/MIS_V5.1/Geojson_s/LBZ_D.js')}}"></script>
<script src="{{asset('assets/MIS_V5.1/Geojson_s/delhi.js')}}"></script>
<script src="{{asset('assets/MIS_V5.1/Geojson_s/LWZ_GB.js')}}"></script>

<!-- <script src="./Geojson_s/PS_I.geojson"></script>
<script src="./Geojson_s/PS_II.geojson"></script>
<script src="./Geojson_s/PS_III.geojson"></script> -->

<script src="https://cdn.jsdelivr.net/npm/pdfkit@0.15.0/js/pdfkit.standalone.min.js"></script>


<!-- 
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script> -->
<!-- Leaflet Routing Machine CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />

<!-- Leaflet Routing Machine JS -->
<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

<link rel="stylesheet" href="https://unpkg.com/leaflet-better-filelayer@0.1.1/dist/leaflet.betterfilelayer.css"
    crossorigin="anonymous" referrerpolicy="no-referrer">
</head>
<script type="application/javascript"
    src="https://unpkg.com/leaflet-better-filelayer@0.1.1/dist/leaflet.betterfilelayer.min.js"
    crossorigin="anonymous"></script>


<script src="https://cdn.osmbuildings.org/classic/0.2.2b/OSMBuildings-Leaflet.js"></script>

<link rel="stylesheet" href="https://unpkg.com/leaflet-draw/dist/leaflet.draw.css" />
<script src="https://unpkg.com/leaflet-draw/dist/leaflet.draw.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@turf/turf@7.1.0/turf.min.js"
    integrity="sha256-xFr0VRlS+kHwSTz0jDU5sYAHdPKr/AMexq9yrM8Yvp8=" crossorigin="anonymous"></script>


<!-- Bootstrap Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">

<!-- leaflet pannel -->
 
<script src="
https://cdn.jsdelivr.net/npm/leaflet-panel-layers@1.3.1/dist/leaflet-panel-layers.min.js
"></script>
<link href="
https://cdn.jsdelivr.net/npm/leaflet-panel-layers@1.3.1/dist/leaflet-panel-layers.min.css
" rel="stylesheet">


<!-- <script src="https://www.webglearth.com/v2/api.js"></script> -->

</html>