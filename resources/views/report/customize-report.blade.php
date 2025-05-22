@extends('layouts.app')

@section('title', 'Customized Report')

@section('content')
    <style>
        label.form-check-label {
            margin: auto -0.5rem;
            padding-left: 10px;
        }
    </style>
    {{-- <link rel="stylesheet" href="{{asset('assets/css/rgr.css')}}"> --}}
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Reports</div>
        {{-- @include('include.partials.breadcrumbs') --}}
    </div>
    <!--breadcrumb-->
    <!--end breadcrumb-->
    <hr>
    <div class="card">
        <div class="card-header">
            <h5>Customized Report</h5>
        </div>
        <div class="card-body">
            <form id="filter-form" method="get" action="{{ route('customizeReport') }}">
                <input type="hidden" name="export" value="1">
                <div class="row mb-2">
                    {{-- <div class="col-lg-8"> Commented to manage dynamic col-lg class for section dropdown by Lalit (11/March/2025) --}}
                    {{-- adding id="type_of_report" to mange dynamic col-lg class by Lalit Lalit (11/March/2025) --}}
                    <div id="type_of_report">
                        <label for="report_type">Type of Report</label>
                        <select name="report_type" id="report_type" class="form-select">
                            <option value="">Select</option>
                            @foreach ($reportTypes as $key => $reportType)
                                <option value="{{ $key }}">{{ $reportType }}</option>
                            @endforeach
                        </select>
                        {{-- Added div for Report Type validation - Lalit Lalit (11/March/2025) --}}
                        <div id="report_typeError" class="text-danger"></div>
                    </div>
                    {{-- Added new filter options section - Lalit Lalit (11/March/2025) --}}
                    <div id="sectionDiv" @style(['display: none'])>
                        <label for="section">Sections</label>
                        <select name="section" id="section" class="form-select">
                            <option value="">Select</option>
                            @foreach ($sections as $key => $section)
                                <option value="{{ $section->id }}">{!! $section->name !!} -
                                    ({{ $section->section_code }})
                                </option>
                            @endforeach
                        </select>
                        <div id="sectionError" class="text-danger"></div>
                    </div>
                    <div class="col-lg-2" @style(['padding-top : 20px'])>
                        <div class="btn-group-filter">
                            <button type="button" class="btn btn-primary px-5" id="apply-btn">Apply</button>
                        </div>
                    </div>
                    <div class="col-lg-2" @style(['padding-top : 20px'])>
                        <div class="btn-group-filter">
                            <button type="submit" class="btn btn-info px-5 filter-btn" id="export-btn">Export</button>
                        </div>
                    </div>
                </div>
            </form>
            @include('include.loader')
            <div id="data" class="mt-2 d-none">
                <table id="reportData" class="table table-bordered table-striped">
                    <thead>
                        <tr></tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="row mt-2" id="pagination">
                <div class="col-lg-6" id="pagination-total-info"></div>
                <div class="col-lg-6" id="pagination-container" @style(['display:flex', 'justify-content:right'])>
                </div>
            </div>

            {{-- <div class="table-responsive mt-2">
                        <table id="example" class="display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S. No.</th>
                                    <th>Colony Name</th>
                                    <th>Section</th>
                                    <th>Total Property</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $startNum = $properties->currentPage()
                                        ? ($properties->currentPage() - 1) * $properties->perPage()
                                        : 0;
                                @endphp
                                @forelse($properties as $property)
                                    <tr>
                                        <td>{{ $loop->iteration + $startNum }}</td>
        <td>{{ $property->colony_name }}</td>
        <td>{{ $property->section_name }}</td>
        <td>{{ $property->total_property_count }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="13">No Data to Display</td>
        </tr>
        @endforelse
        </tbody>
        </table>
    </div>
    <div class="row mt-2">
        @php
        $total = $properties->total();
        @endphp
        <div class="col-lg-6">Total {{ $total }} {{ $total != 1 ? 'proeperties' : 'proeperty' }} found
        </div>
        <div class="col-lg-6">

            <div style="float: right;">{{ $properties->appends(request()->input())->links() }}</div>
        </div>
    </div> --}}

        </div>

    </div>

@endsection

@section('footerScript')
    <script>
        /* $('#export-btn').click(function() {
                                                                            $('input[name="export"]').val(1);
                                                                            $('button[type="submit"]').click();
                                                                            setTimeout(function() {
                                                                                $('input[name="export"]').val(0);
                                                                            }, 500)
                                                                        }) */

        $(document).ready(function() {
            //Update given below code to manage Report Type Validation & filter by Section - Lalit (11/March/2025)
            $('#apply-btn').click(function() {
                var reportType = $('#report_type').val();
                var section = $('#section').val();
                var reportTypeError = $("#report_typeError");
                var sectionError = $("#sectionError");

                // Reset previous error messages
                reportTypeError.hide();
                sectionError.hide();

                if (!reportType) {
                    reportTypeError.text("Report type is required").show();
                    return false;
                }

                if (reportType === 'PIAS' && !section) {
                    sectionError.text("Section is required").show();
                    return false;
                }
                //Add section filter - Lalit (11/March/2025)
                getReport(reportType, reportType === 'PIAS' ? section : undefined);
            });


            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                var pageNo = $(this).data('page'); // Use data attribute instead of extracting text
                var reportType = $('#report_type').val();
                if (!reportType) return; // Exit early if reportType is not selected
                //Add section filter value & handle it for getReport method - Lalit (11/March/2025)
                var section = $('#section').val();
                getReport(reportType, section || undefined, pageNo);
            });

        })

        function getReport(reportType, section = false, pageNo = false) {
            $('#data').addClass('d-none');
            var loader = $(document).find('.loader_container');
            if (loader.hasClass('d-none')) {
                loader.removeClass('d-none');
            }
            let data = {
                report_type: reportType,
            };
            //Append section filter value in post json form data - Lalit (11/March/2025)
            if (section) {
                data.section = section;
            }
            if (pageNo) {
                data.page_no = pageNo;
            }
            $.ajax({
                type: "get",
                data: data,
                success: function(response) {
                    var headerNames = response.headerValues;
                    var dataValues = response.dataValues;
                    dataValues = Array.isArray(dataValues) ? dataValues : Object.values(dataValues);
                    var tableHeaderRow = $('#reportData thead tr');
                    var tableBody = $('#reportData tbody');
                    var paginationContainer = $('#pagination-container');
                    var paginationInfo = $('#pagination-total-info');
                    var pagination = response.pagination;
                    // Clear previous data
                    tableHeaderRow.empty();
                    tableBody.empty();
                    paginationContainer.empty();
                    paginationInfo.empty();

                    // Append headers
                    headerNames.forEach(header => {
                        // tableHeaderRow.append(`<th>${header.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')}</th>`);
                        tableHeaderRow.append(`<th>${header.replace(/_/g,' ').toUpperCase()}</th>`);
                    });

                    // Append data rows
                    dataValues.forEach(row => {
                        var rowHTML = `<tr>`;
                        headerNames.forEach(header => {
                            rowHTML += `<td>${row[header]}</td>`;
                        });
                        rowHTML += `</tr>`;
                        tableBody.append(rowHTML);
                    });

                    // Append pagination links if there are multiple pages
                    if (pagination && pagination.last_page > 1) {
                        console.log(pagination);
                        let paginationHTML = `<div class="pagination">`;

                        for (let i = 1; i <= pagination.last_page; i++) {
                            let activeClass = i === pagination.current_page ? "active" : ""
                            paginationHTML +=
                                `<a href="#" class="page-link ${activeClass}" data-page="${i}">${i}</a>`;
                        }

                        paginationHTML += `</div>`;
                        paginationContainer.html(paginationHTML);
                    }
                    if (pagination)
                        paginationInfo.text(`Total ${pagination.total} records found`);

                    loader.addClass('d-none');
                    $('#data').removeClass('d-none');
                }
            })
        }

        $(document).ready(function() {
            function updateLayout() {
                var selectedValue = $("#report_type").val();
                var classOne = selectedValue === 'PIAS' ? 'col-lg-6' : 'col-lg-8';
                var classSecond = 'col-lg-2';
                $("#type_of_report").attr("class", classOne);
                $("#sectionDiv").attr("class", classSecond).toggle(selectedValue === 'PIAS');
                console.log(selectedValue);
            }

            $("#report_type").change(updateLayout);
            updateLayout(); // Initialize on page load
        });
    </script>
@endsection
