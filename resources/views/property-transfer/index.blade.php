@extends('layouts.app')
@section('title', 'Property Transfer')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/rgr.css') }}" />
    <style>
        .subhead-input {
            margin: 10px 0 !important;
            padding: 10px 0 !important;
            border-radius: 10px;
        }

        #detail-container>tr>td:not(:nth-child(2)) {
            width: 15%;
        }
    </style>
       <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Miscellaneous</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Property Transfer</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--breadcrumb-->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 mb-2">
                    @include('include.parts.property-selector')
                </div>
            </div>
            <div class="col col-lg-2 pt-1 mb-2">
                <button type="button" class="btn btn-primary px-4 mt-4" id="submitButton">Search<i
                        class="bx bx-right-arrow-alt ms-2"></i></button>
            </div>
            <div class="d-none" id="detail-card">
                {{-- <h5 class="mb-4 pt-3 text-decoration-underline">BASIC DETAILS</h5> --}}
                <div class="pb-3">

                    <div class=""> <!-- this div add by anil on 21-01-2025-->
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th colspan="5">BASIC DETAILS</th>
                            </thead>
                            <tbody id="detail-container">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-12 col-12" id="propertyDetailsDiv">
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label for="section" class="form-label">Section</label>
                            <select class="form-control selectpicker" name="section" id="section">
                                <option value="">Select</option>
                                @foreach ($sections as $section)
                                    @if ($section->section_code !== 'ITC')
                                        <option value="{{ $section->id }}">{!! $section->name !!} -
                                            ({{ $section->section_code }})
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <div id="sectionError" class="text-danger"></div>
                        </div>
                        <div class="col-lg-3" style="padding-top: 35px;">
                            <!-- Button to open modal -->
                            <button class="btn btn-primary" id="propertyTransferModalBtn">Transfer</button>
                        </div>
                    </div>
                </div>
                <div id="errorDiv" style="color: red; display: none;"></div> <!-- Error container -->
            </div>
        </div>
    </div>

    <!-- Transfer Property Modal -->
    <div class="modal fade" id="propertyTransferConfirmModal" tabindex="-1"
        aria-labelledby="propertyTransferConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="propertyTransferConfirmModalLabel">Property Transfer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to transfer this property to selected section?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="propertyTransferConfirmBtn">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    @include('include.loader')
    @include('include.alerts.ajax-alert')
@endsection
@section('footerScript')
    <script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
    <script>
        $("#submitButton").click(function() {
            propertyId = !isNaN($("#oldPropertyId").val()) && $("#oldPropertyId").val().length == 5 ?
                $("#oldPropertyId").val() :
                $("#property").length > 0 && $("#property").val() != "" ?
                $("#property").val() :
                $("#plot").length > 0 && $("#plot").val() != "" ? $("#plot").val() : "";
            getPropertyBasicDetail(propertyId);
        });

        function getPropertyBasicDetail(propId) {
            $.ajax({
                type: "post",
                url: "{{ route('propertyCommonBasicdetail') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    property_id: propId,
                    skipAccessCheck: {{ $skipAccessCheck }},
                },
                success: function(response) {
                    if (response.status == "success") displayPropertyDetails(response.data);
                    else {
                        showError(response.message);
                    }
                },
            });
        }

        function displayPropertyDetails(data) {
            $("#detail-container").empty();
            if (Array.isArray(data)) {
                $("#detail-container").html(`<tr>
                      <td colspan="5"><h6>Given property has ${data.length} propert${
              data.length > 1 ? "ies" : "y"
            }</h6></td>
                  </tr>`);
                data.forEach(function(row, i) {
                    appendPropertyDetail(row, true, i + 1);
                });
                $("#detail-container").append(`<tr>
                <td colspan="5"><h5>Pease enter property id of splited property to continue</h5></td>
            </tr>`);
                $("#btn-rgr").prop("disabled", true);
            } else {
                appendPropertyDetail(data);
                $("#property_id").val(data.id);
                $("#splited").val(data.is_joint_property === undefined ? 1 : 0);
            }
            $("#selectedOldPropertyId").val(
                data.old_property_id ?? data.old_propert_id
            );
            $("#detail-card").removeClass("d-none");
        }

        function appendPropertyDetail(data, isMultiple = false, rowNum = null) {
            if (isMultiple && rowNum) {
                $("#detail-container").append(`<tr>
                <td>${rowNum}</td><td colspan="4"></td>
            </tr>`);
            }
            // removed <td><b>Land Value : </b> &nbsp;-</td>
            let transferHTML = "";
            if (data.trasferDetails && data.trasferDetails.length > 0) {
                transferHTML = `<input type="hidden" name="property_master_id" id="property_master_id" value="${data.id}"><div class= "transfer-details" style="display: inline; position:relative">
            <span class="qmark">&#8505;
            <ul class="transfer-list container">
                <li class="transfer-list-item row row-lg-4">
                    <div class="transfer-list-cell col">#</div>
                    <div class="transfer-list-cell col">Transfer Date</div>
                    <div class="transfer-list-cell col">Process </div>
                    <div class="transfer-list-cell col">Lessee Name</div>
                    </li>
            `;
                data.trasferDetails.forEach((row, i) => {
                    transferHTML += `<li class="transfer-list-item row row-lg-4">
                    <div class="transfer-list-cell col">${i + 1}</div>
                    <div class="transfer-list-cell col">${row.transferDate}</div>
                    <div class="transfer-list-cell col">${row.process_of_transfer}</div>
                    <div class="transfer-list-cell col">${row.lesse_name}</div>
                    </li>`;
                });
                transferHTML +
                    `</ul>
            </span> </div>`;
            }

            $("#detail-container").append(`
          <tr>
            <td><b>Property ID : </b> &nbsp;${data.unique_propert_id} (${data.old_propert_id})</td>
            <td><b>Land Type : </b> &nbsp;${data.landTypeName}</td>
            <td><b>Land Use Type : </b> &nbsp;${data.proprtyTypeName}</td>
            <td><b>Land Use Subtype : </b> &nbsp;${data.proprtySubtypeName}</td>
            <td><b>Land Size : </b> &nbsp;${ Math.round(data.landSize * 100) / 100} Sq. Mtr.</td>
          </tr>
          <tr>
              <td><b>Status of RGR : </b> &nbsp;<span class="rgrStatus">${data.rgr == 1 ? "Yes" : "No"}</span></td>
              <td><b>Lessee/Owner Name : </b> &nbsp;${data.lesseName ? data.lesseName.replaceAll(',', ', ') : "N/A"} ${ data.trasferDetails && data.trasferDetails.length > 0 ? transferHTML : ""}</td>
              <td><b>Lease Type : </b> &nbsp;${data.leaseTypeName ? data.leaseTypeName : "N/A"}</td>
              <td><b>Owner&apos;s E-mail : </b> &nbsp;${data.email ? data.email : "N/A"}</td>
              <td><b>Owner&apos;s Phone Number: </b> &nbsp;${data.phone_no ? data.phone_no : "N/A"}</td>
          </tr>
          <tr>
            <td><b>Date of Allotment : </b> &nbsp;${data.leaseDate? data.leaseDate.split("-").reverse().join("-"):"N/A"}</td>
            <td><b>Lease Tenure : </b> &nbsp;${data.leaseTenure? data.leaseTenure + " years": "N/A"}</td>
            <td colspan="4"><b>Address : </b> &nbsp;${data.address ?? "N A"} </td>
          </tr>
        `);
        }

        $(document).ready(function() {
            let propertyMasterId; // Defined Variable propertyMasterId
            let sectionId;
            let errorDiv = document.getElementById('errorDiv');

            // Open modal and store the record ID from the button
            $('#propertyTransferModalBtn').click(function() {
                propertyMasterId = $('#property_master_id').val();
                sectionId = $('#section').val();
                if (!propertyMasterId) {
                    errorDiv.innerText = 'Search property to transfer!';
                    errorDiv.style.display = 'block'; // Show error
                    return false;
                }
                if (!sectionId) {
                    errorDiv.innerText = 'Select section to transfer property!';
                    errorDiv.style.display = 'block'; // Show error
                    return false;
                }
                $('#propertyTransferConfirmModal').modal('show'); // Show modal
            });

            // Handle Confirm button click inside modal
            $('#propertyTransferConfirmBtn').click(function() {
                propertyMasterId = $('#property_master_id').val();
                sectionId = $('#section').val();
                $.ajax({
                    url: '{{ route('property.transfer.section') }}', // Replace with your actual route
                    type: 'POST', // Change to DELETE if needed
                    data: {
                        _token: '{{ csrf_token() }}', // Laravel CSRF token
                        propertyMasterId: propertyMasterId, // Send property ID
                        sectionId: sectionId, // Send section ID
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            $('#propertyTransferConfirmModal').modal(
                                'hide'); // Hide modal on success
                            showSuccess(response.message);
                            location.reload(); // Reload page (optional)
                        } else {
                            $('#propertyTransferConfirmModal').modal(
                                'hide'); // Hide modal on success
                            // alert(response.message); // Show success message
                            showError(response.message);
                        }
                    },
                    error: function(xhr) {
                        $('#propertyTransferConfirmModal').modal('hide');
                        alert('Error: ' + xhr.responseJSON.message);

                    }
                });
            });
        });
    </script>

@endsection
