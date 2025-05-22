@extends('layouts.app')

@section('title', 'List | Revision of Ground Rent')

@section('content')
<link rel="stylesheet" href="{{asset('assets/css/rgr.css')}}">
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">RGR</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item">RGR</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">List</li>
            </ol>
        </nav>
    </div>
    <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->
</div>
<!--end breadcrumb-->

<hr>


<div class="card">
    <div class="card-body">
        <div class="row">
            @include('rgr.alert')
            <div class="col">
                <div class="row mb-3">
                    <div class="col">
                        <h5>Select a colony or property id to start</h5>
                    </div>
                </div>
                @include('include.parts.property-selector',['leaseHoldOnly'=>true])
            </div>
        </div>
        <div class="row mt-3 d-none detail-view" id="colony-summary">
            <div class="col-lg-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Total LH Properties</th>
                            <th>Total GR Revised</th>
                            <th>Draft Letter Generated</th>
                            <th>Email Not found</th>
                            <th>GR Letter Sent</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="summary_total_properties"></td>
                            <td id="summary_total"></td>
                            <td id="summary_pdfCount"></td>
                            <td id="summary_emailNotFound"></td>
                            <td id="summary_emailsentCount"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @include('include.parts.rgr-list')
        <div class="row d-none mt-3 detail-view" id="property-view">
            <div id="property-view-container" class="col">
                <table class="table table-bordered table-striped" id="table-property-view">
                    <tbody>
                        <tr>
                            <td><b>Property ID:</b> &nbsp;&nbsp; <span id="property_id"></span></td>
                            <td><b>Address:</b> &nbsp;&nbsp; <span id="address"></span></td>
                            <td><b>Plot area in Sqm.:</b> &nbsp;&nbsp; <span id="property_area_in_sqm"></span></td>
                        </tr>
                        <tr>
                            <td><b>L&DO Land Rate:</b> &nbsp;&nbsp; <span id="lndo_land_rate"></span></td>
                            <td><b>L&DO land value:</b> &nbsp;&nbsp; <span id="lndo_land_value"></span></td>
                            <td><b>L&DO RGR per Annum:</b> &nbsp;&nbsp; <span id="lndo_rgr_per_annum"></span></td>
                        </tr>
                        <tr>
                            <td><b>Circle Land Rate:</b> &nbsp;&nbsp; <span id="circle_land_rate"></span></td>
                            <td><b>Circle land value:</b> &nbsp;&nbsp; <span id="circle_land_value"></span></td>
                            <td><b>Circle RGR per Annum:</b> &nbsp;&nbsp; <span id="circle_rgr_per_annum"></span></td>
                        </tr>
                        <tr>
                            <td><b>Calculated on Rate:</b> &nbsp;&nbsp; <span id="calculated_on_rate"></span></td>
                            <td><b>Number of Days</b> &nbsp;&nbsp; <span id="no_of_days"></span></td>
                            <td><b>RGR Amount:</b> &nbsp;&nbsp; <span id="rgr_amount"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between">
                <div>
                    <b>Status of Draft:</b> &nbsp;&nbsp; <span id="status_of_draft"></span>
                </div>
                <div id="draft-buttons">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footerScript')
<script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
<script>
    let selectedRGRArray = [];
    $('#colony_id').change(function() {
        selectedColonyId = $(this).val();
        resetPage();
        if (selectedColonyId != "") {
            $.ajax({
                type: "post",
                url: "{{route('colonyRGRDetails')}}",
                data: {
                    _token: '{{csrf_token()}}',
                    selectedColonyId: selectedColonyId,
                    // startDate: startDate, selectedColonyId, not required we are taking a default period
                    doneOnly: 1 //this flag to get the properties where RGR is done
                },
                success: function(response) {
                    if (response.status == 'success') {

                        if (response.data.length > 0) {
                            tbody = $('#colony-rows');
                            tbody.empty();
                            let counter = 1; //
                            response.data.forEach(row => {

                                let calculated_on_rate = row.calculated_on_rate;
                                let calculatedonRate;
                                let selectColumn;
                                if (calculated_on_rate == "L") {
                                    selectColumn = 'lndo';
                                    calculatedonRate = "L&DO rate";
                                }
                                if (calculated_on_rate == "C") {
                                    selectColumn = 'circle';
                                    calculatedonRate = "Circle rate";
                                }
                                let landrate = row[selectColumn + '_land_rate'];
                                let landvalue = row[selectColumn + '_land_value'];
                                let rgr = row[selectColumn + '_rgr'];
                                /* <td>${(row.circle_land_rate) ? parseFloat(row.circle_land_rate).toFixed(2):'not available'}</td>
                                   <td>${(row.circle_land_value) ? parseFloat(row.circle_land_value).toFixed(2):'not available'}</td>
                                   <td>${(row.circle_rgr) ? parseFloat(row.circle_rgr).toFixed(2):'not available'}</td> */
                                let viewDraftBtn = `<a class="btn btn-draft" onclick="viewDraft(${row.id})"><i class="bx bx-check"></i>View Draft</a>`;
                                let viewPdfButton = `<a class="btn btn-pdf" href="/${row.draftPath}" target="_blank"><i class=\'bx bxs-file-pdf\'></i> View PDF</a>`;

                                let viewBtn = (row.draft_file_path) ? viewPdfButton : viewDraftBtn;
                                let createDate = new Date(row.created_at);

                                tbody.append(`<tr>
                                <td><input type="checkbox" class="line-checkbox" data-target-id="${row.id}"></td>
                                <td>${(row.property_master)? row.property_master.old_propert_id: (row.splited_property_detail)? row.splited_property_detail.old_property_id:'Not available'}</td>
                                <td>${row.address}</td>
                                <td>${parseFloat(row.property_area_in_sqm).toFixed(2)}</td>
                                <td>${(landrate) ? parseFloat(landrate).toFixed(2):'not available'}</td>
                                <td>${(landvalue) ? parseFloat(landvalue).toFixed(2):'not available'}</td>
                                <td>${(rgr) ? parseFloat(rgr).toFixed(2):'not available'}</td>
                                <td>${(calculated_on_rate) ? (calculated_on_rate == "L"? "L&DO rate":'Circle rate'):'not available'}</td>
                                <td>${createDate.getDate().toString().padStart(2, '0')+'-'+ (createDate.getMonth()+1).toString().padStart(2, '0')+'-'+ (createDate.getFullYear())}</td>createDate.getDate().toString().padStart(2, '0')
                                <td>${row.is_draft_sent == 1? '<div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">yes</div>':'<div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3">no</div>'}</td>
                                <td>${viewBtn} <button class="btn btn-primary ${(row.is_draft_sent > 0 || !row.draft_file_path) ? 'disabled-link' : ''}" onclick="sendDraft(${row.id}, ${(row.is_draft_sent > 0 || !row.draft_file_path)})"><i class='bx bx-send'></i>Send Letter</button></td>
                            </tr>`);
                                counter++;
                            });
                            $('#summary_total').html(response.data.length);
                            $('#summary_pdfCount').html(response.summary.pdfCount);
                            $('#summary_emailsentCount').html(response.summary.emailsentCount);
                            $('#summary_emailNotFound').html(response.summary.emailNotFound);
                            $('#summary_total_properties').html(response.summary.leaseHoldCount);
                            $('#colony-view').removeClass('d-none');
                            $('#colony-summary').removeClass('d-none');
                        } else {
                            showError("No lease hold property found for this colony")
                        }
                    } else {
                        showError(response.details)
                    }
                },
                error: response => {
                    if (response.responseJSON && response.responseJSON.message) {
                        showError(response.responseJSON.message)
                    }
                }
            })
        }
    });

    $('#plot').change(function() {
        let propertyId = $(this).val();
        getRGRDetails(propertyId);
    })


    $('#oldPropertyId').change(function() {
        let propertyId = $(this).val();
        if (!isNaN(propertyId) && propertyId.length == 5) {
            getRGRDetails(propertyId);
        }
    })

    const getRGRDetails = (propertyId) => {
        resetPage();
        $.ajax({
            type: 'get',
            url: "{{route('rgrDetailsForProperty')}}",
            data: {
                propertyId: propertyId
            },
            success: response => {
                if (response.status == 'success') {
                    let data = response.data;
                    if (data.length > 0) {
                        $('#property-view').removeClass('d-none')
                        if (data.length > 1) {
                            $('#property-view-container').prepend(`<h5>${data.length} RGR records found for property</h5>
                                <label>1</label>`)
                        }
                        data.forEach((row, index) => {

                            let targetTable;
                            if (index == 0) {
                                targetTable = $('#table-property-view');
                            } else {
                                $('#property-view-container').append(`<label>${data.length}</label>`)
                                let clonedTable = $('#table-property-view').clone();
                                clonedTable.find('span').html('');
                                clonedTable.appendTo('#property-view-container');
                                targetTable = clonedTable;
                            }

                            Object.keys(row).forEach(key => { //key and id of span where 
                                let targetElm = $(targetTable).find('span#' + key);
                                if (targetElm.length > 0) {
                                    targetElm.html(row[key] ? row[key] : 'not available')
                                }
                            });
                            $(targetTable).find('span#property_id').html((row.property_master) ? row.property_master.old_propert_id : (row.splited_property_detail) ? row.splited_property_detail.old_property_id : 'not available');
                            field_prefix = null;
                            if (data.calculated_on_rate == "L") {
                                $(targetTable).find('span#calculated_on_rate').html('L&DO land rate');
                                field_prefix = 'lndo';

                            } else {
                                $(targetTable).find('span#calculated_on_rate').html('circle land rate');
                                field_prefix = 'circle';
                            }
                            if (field_prefix) {
                                $(targetTable).find('span#rgr_amount').html(Math.round(parseInt(row[field_prefix + '_rgr'])) + '/-');
                            }
                        });
                        /**/
                        let viewDraftBtn = `<a class="btn btn-draft" onclick="viewDraft(${data[0].id})"><i class="bx bx-check"></i>View Draft</a>`;
                        let viewPdfButton = `<a class="btn btn-pdf" href="/${data[0].draftPath}" target="_blank"><i class=\'bx bxs-file-pdf\'></i> View PDF</a>`;
                        let viewBtn = (data[0].draft_file_path) ? viewPdfButton : viewDraftBtn;
                        $('span#status_of_draft').html(data[0].is_draft_sent == 1 ? 'Sent' : 'Not sent')
                        $('#draft-buttons').html(`${viewBtn} <button class="btn btn-primary"${data[0].is_draft_sent > 0 ? 'disabled':''} onclick="sendDraft(${data[0].id})"><i class='bx bx-send'></i>Send Letter</button>`);
                    } else {
                        showError('No Data Found!!')
                    }


                } else if (response.status == 'error') {
                    showError(response.details);
                }
            },
            error: err => {
                console.log(err)
                if (err.responseJSON && err.responseJSON.message) {
                    showError(err.responseJSON.message)
                } else {
                    showError('Unknown Error Occoured');
                }
            }
        })
    };

    const resetPage = () => { // removes all the modifications by scriot after selecteing a colony or ptoperty
        $('.detail-view').each((i, elm) => {
            if (!$(elm).hasClass('d-none')) {
                $(elm).addClass('d-none')
            }
            if (!$('#selected-controls').hasClass('d-none')) {
                $('#selected-controls').addClass('d-none');
            }
            $("#colony-rows").empty();
            $('#check-header').prop('checked', false);
            selectedRGRArray = [];
        })

        $('#check-header').change(function() {
            $('.line-checkbox').prop('checked', $(this).is(':checked')).trigger('change');

        });
        $(document).on('change', '.line-checkbox', function() {
            let targetId = $(this).data('target-id');
            if ($(this).is(':checked')) {
                if (selectedRGRArray.indexOf(targetId) < 0) {
                    selectedRGRArray.push(targetId);
                }
            } else {
                selectedRGRArray = selectedRGRArray.filter(val => val != targetId);
            }
            if (selectedRGRArray.length > 0) {
                if ($('#selected-controls').hasClass('d-none')) {
                    $('#selected-controls').removeClass('d-none')
                }
            } else {
                if (!$('#selected-controls').hasClass('d-none')) {
                    $('#selected-controls').addClass('d-none')
                }
            }
        })
    }

    const generatePdfForSelectedRGR = () => {
        if (selectedRGRArray.length > 0) {
            $.ajax({
                type: "post",
                url: "{{route('saveMultiplePdf')}}",
                data: {
                    _token: "{{csrf_token()}}",
                    ids: selectedRGRArray
                },
                success: response => {
                    if (response.status) { // when response is like ['status'=>'error', details=>'some details about error']
                        showError(response.details) //show error message
                    } else {
                        if (response.done > 0) {
                            showSuccess(` pdf file generated for ${response.done} rgr. Changes may reflect on  next refresh`)
                        }
                        if (response.errors.length > 0)
                            showError(response.errors)
                    }
                    $('#btn-selected-pdf').prop('disabled', false);
                },
                error: response => {
                    console.log(response)
                    $('#btn-selected-pdf').prop('disabled', false);
                    if (response.responseJSON && response.responseJSON.message) {
                        showError(response.responseJSON.message)
                    }
                }
            })
        }
    }
    const sendDraftForSelectedRGR = () => {
        if (selectedRGRArray.length > 0) {
            $.ajax({
                type: "post",
                url: "{{route('sendMultipleDrafts')}}",
                data: {
                    _token: "{{csrf_token()}}",
                    ids: selectedRGRArray
                },
                success: response => {
                    if (response.status) { // when response is like ['status'=>'error', details=>'some details about error']
                        showError(response.details) //show error message
                    } else {
                        if (response.done > 0) {
                            showSuccess(` Draft email sent to ${response.done} recipients `)
                        }
                        if (response.errors.length > 0)
                            showError(response.errors)
                    }
                },
                error: response => {
                    console.log(response);
                    if (response.responseJSON && response.responseJSON.message) {
                        showError(response.responseJSON.message)
                    }
                }
            })
        }
    }

    const sendDraft = (id, disabled) => {
        if (disabled) {
            return false;
        }
        $.ajax({
            type: "get",
                       url: `{{url('rgr/send-draft')}}` + '/' + id,

            success: response => {
                if (response.status == 'success') {
                    showSuccess(response.message);
                }
                if (response.status == 'error') {
                    showError(response.details);
                }
            },
            error: response => {
                if (response.responseJSON && response.responseJSON.message) {
                    showError(response.responseJSON.message)
                }
            }
        })
    }
</script>

@endsection
