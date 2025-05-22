<style>
</style>

<div class="bs-stepper-content">
    <div id="" role="" class="" aria-labelledby="">
        <h5 class="mb-1">Locate Property</h5>
        <p class="mb-4">Select a colony</p>

        @include('include.parts.property-selector',['leaseHoldOnly'=>true])
        <div class="col col-lg-2 pt-1"><button type="button" class="btn btn-primary px-4 mt-4" id="submitButton1">Search<i class='bx bx-right-arrow-alt ms-2'></i></button></div>

        <div class="row mb-4">

            <div class="col col-lg-3"></div>

        </div>
    </div>
</div>


<div class="d-none" id="detail-card">
    <h5 class="mb-4 pt-3 text-decoration-underline">BASIC DETAILS</h5>
    <div class="pb-3">

        <table class="table table-bordered">
            <tbody id="detail-container">
            </tbody>
        </table>
    </div>
    <button type="button" class="btn btn-primary" id="btn-rgr" data-action="show">Start</button>

</div>


<form class="d-none" method="post" action="{{route('createRgr')}}" id="rgr-card">

    @csrf
    <input type="hidden" name="property_id" id="property_id">
    <input type="hidden" name="splited" value="0" id="splited">

    <div class="py-3">
        <div class="row g-3">

            <div class="col-12 col-lg-4">
                <label for="fromDate" class="form-label">Start Date</label>
                <input type="date" name="fromDate" id="fromDate" class="form-control" required>
                @error('fromDate')
                <span class="errorMsg">{{ $message }}</span>
                @enderror
                <div id="fromDateError" class="text-danger"></div>
            </div>

            {{--<div class="col-12 col-lg-4">
                <label for="reviseDate" class="form-label">RGR Date</label>
                <input type="text" id="reviseDate" class="form-control" readonly>

            </div>--}}

            <div class="col-12 col-lg-4">
                <label for="tillDate" class="form-label">Till Date</label>
                <input type="date" id="tillDate" class="form-control">
            </div>

        </div><!---end row-->


        <div class="row my-4 d-none" id="calculationContainer">
            <div class="container" id="rgrFactorContainer">
                <table class="table table-bordered table-striped table-info" id="rgrFactorTable">

                </table>
            </div>
            <div class="container">
                <table class="table table-bordered calculate-table" id="calculate-table">
                    <thead>
                        <tr>
                            <th>GRR as per L&DO rates</th>
                            <th>GRR as per circle rates</th>
                        </tr>
                    </thead>
                    <tbody id="calculate-tbody">
                        <tr>
                            <td><span class="label">Land Rate (₹/Sqm.) :</span> &nbsp; &nbsp;<span class="value" id="lndo_land_rate"></span></td>
                            <td><span class="label">Land Rate (₹/Sqm.) :</span> &nbsp; &nbsp;<span class="value" id="circle_land_rate"></span></td>
                        </tr>
                        <tr>
                            <td><span class="label">Land Rate Period :</span> &nbsp; &nbsp;<span class="value" id="lndo_land_rate_period"></span></td>
                            <td><span class="label">Land Rate Period :</span> &nbsp; &nbsp;<span class="value" id="circle_land_rate_period"></span></td>
                        </tr>
                        <tr>
                            <td><span class="label">Land Value (₹) :</span> &nbsp; &nbsp;<span id="lndo-land-value-calculation" class="value-calculation"></span>&nbsp;&nbsp;<span class="value" id="lndo_land_value"></span></td>
                            <td><span class="label">Land Value (₹) :</span> &nbsp; &nbsp;<span id="circle-land-value-calculation" class="value-calculation"></span>&nbsp;&nbsp;<span class="value" id="circle_land_value"></span></td>
                        </tr>
                        <tr>
                            <td><span class="label">RGR per year (₹) :</span> &nbsp; &nbsp;<span id="lndo-rgr-calculation" class="value-calculation"></span>&nbsp;&nbsp;<span class="value" id="lndo_rgr_per_annum"></span></td>
                            <td><span class="label">RGR per year (₹) :</span> &nbsp; &nbsp;<span id="circle-rgr-calculation" class="value-calculation"></span>&nbsp;&nbsp;<span class="value" id="circle_rgr_per_annum"></span></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <span class="label">No of Days for RGR :</span> &nbsp; &nbsp;<span class="value" id="no_of_days"></span>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="label">RGR (₹) :</span> &nbsp; &nbsp;<span class="value amount" id="lndo_rgr"></span></td>
                            <td><span class="label">RGR (₹) :</span> &nbsp; &nbsp;<span class="value amount" id="circle_rgr"></span></td>
                        </tr>
                    </tbody>
                </table>
                <div class="my-4 d-flex flex-row">
                    <h6>Revise ground rent using </h6>
                    <div class="px-3"><input type="radio" name="calculation_rate" required value="L" id="calculation_rate_lndo">&nbsp;&nbsp; L&DO rate</div>
                    <div class="px-3"><input type="radio" name="calculation_rate" required value="C" id="calculation_rate_circle">&nbsp;&nbsp; Circle rate</div>

                </div>
            </div>
        </div>
        <div class="g-3">
            <button class="btn btn-primary px-4 mt-4" type="button" id="submitButton3">Calculate Ground Rent</button> {{--changes to proceed after displaying calculation details--}}
            <div id="already-done" class="my-3 d-none">
                <div class="confirmation flex-col">
                    <h5>RGR already done for this property. This action will withdraw current RGR and create a new one.
                        <br>Do you wish to continue?
                    </h5><br>
                    <div class="confirmation-buttons">
                        <button type="button" class="btn btn-primary" id="confirmation-yes">Yes</button>
                        <button type="button" class="btn btn-danger" id="confirmation-no">No</button>
                    </div>
                    <div class="form-group d-none" id="input-reason">
                        <label for="reason_of_change">Reason for Change in RGR</label>
                        <select name="reason_of_change" id="reason_of_change" class="form-select">
                            <option value="">Select a Reason</option>
                            <option value="1">Change in land area</option>
                            <option value="2" disabled>Change in property status</option>
                            <option value="3">Others</option>
                        </select>
                    </div>


                </div>
            </div>
        </div>
</form>

<script>
    var area;
    var editing = false; // to allow edit already done RGR. default state false, set to true when user gives a reason for a change
    var selectedPropertyId = null; // make property id common - date 15-07-2024
    var selectedRGR = null; // make RGR common - date 15-07-2024
    var editFormData = null;

    $('#submitButton1').click(() => {
        resetDocumentToOriginalState();
        selectedPropertyId = $('#oldPropertyId').val() != "" ? $('#oldPropertyId').val() : $('#plot').val(); //using old peroperty id, colony-block-plot if not given
        if (selectedPropertyId.trim() != "") {
            getPropertyBasicDetail(selectedPropertyId)
        }
    })
    $('#btn-rgr').click(function() {
        if ($(this).data('action') == 'show') {

            let todayDate = dateToYYYYMMDD(); // Format date as dd-mm-yyyy
            $('#rgr-card').removeClass('d-none'); // show input fields
            // let tillDate;
            $('#reviseDate').val(todayDate);
            fromDate = `${todayDate.split('-')[2]}-01-01`
            tillDate = `${todayDate.split('-')[2]}-12-31`;
            $('#fromDate').val(fromDate); // display rgr start date
            $('#tillDate').val(tillDate); // display rgr end date
            $(this).data('action', 'hide'); // change attribute of the button to perform new action if clicked again
            $(this).html('Cancel') //change the text of button
            $('.value-calculation').html('') // clear the calculation so that it dont display any value on next show
        } else {
            resetDocumentToOriginalState();
        }
    });


    $('#submitButton3').click(function() {
        if ($(this).attr('type') == "button" && !editing) {
            $('input[name="calculation_rate"]').attr('disabled', false);
            let property_id = $('#property_id').val();
            let splited = $('#splited').val();
            let fromDate = $('#fromDate').val();
            let tillDate = $('#tillDate').val();
            if (property_id != "" && splited != "", fromDate != "") {
                $.ajax({
                    url: "{{route('calculateGroundRent')}}",
                    method: 'post',
                    data: {
                        _token: "{{csrf_token()}}",
                        property_id: property_id,
                        splited: splited,
                        fromDate: fromDate,
                        tillDate: tillDate,
                    },
                    success: function(response) {
                        if (response.failure) {
                            showError(response.failure);
                        }
                        if (response.data) {
                            selectedRGR = response.data; // need to check the params with respect to already done RGR
                            displayCalculation(selectedRGR, false)
                        }
                    }
                })
            }
        } else if (editing) {
            submitEditedForm();
        }

    });

    $('#rgr-card').find('input').change(() => {
        let fromDate = $('#fromDate').val();
        let radio = $('input[name="calculation_rate"]:checked').length;
        if (fromDate && radio > 0) {
            if (!editing) {
                $('#submitButton3').attr('type', 'submit');
            }

            $('#submitButton3').html('Proceed');
            $('#submitButton3').attr('disabled', false);
        } else {
            if (!$('#calculationContainer').hasClass('d-none')) { //do not allow submit if radio button is visble and both date and radio button have values
                $('#submitButton3').attr('type', 'button');
                $('#submitButton3').html('Input Required');
            }
        }
    })

    function getPropertyBasicDetail(propId) {
        $.ajax({
            type: "post",
            url: "{{route('propertyBasicdetail')}}",
            data: {
                _token: '{{csrf_token()}}',
                property_id: propId
            },
            success: function(response) {
                if (response.status == 'success')
                    displayPropertyDetails(response.data);
                else {
                    showError(response.message)
                }
            }
        })
    }

    function displayPropertyDetails(data) {
        $('#detail-container').empty();
        if (Array.isArray(data)) {
            $('#detail-container').html(`<tr>
                <td colspan="5"><h6>Given property has ${data.length} propert${data.length > 1 ? 'ies':'y'}</h6></td>
            </tr>`);
            data.forEach(function(row, i) {
                appendPropertyDetail(row, true, i + 1)
            })
            $('#detail-container').append(`<tr>
                <td colspan="5"><h5>Pease enter property id of splited property to continue</h5></td>
            </tr>`);
            $('#btn-rgr').prop('disabled', true);
        } else {
            appendPropertyDetail(data);
            $('#property_id').val(data.id);
            $('#splited').val(data.is_joint_property === undefined ? 1 : 0);

        }
        $('#detail-card').removeClass('d-none');
        area = data.landSize;


    }

    /** when user want to edit already created RGR */

    $('#confirmation-yes').click(function() {
        $('#input-reason').removeClass('d-none');
    })
    $('#confirmation-no').click(function() {
        $("#rgr-card").addClass('d-none'); //hide form
        $("#detail-card").addClass('d-none'); // hide property details info
        $('#fromDate').val(''); // reset from date
    })
    $('#reason_of_change').change(function() {
        let reason = $(this).val();
        if (reason != "") {
            if (reason == 1) { // when area change selected
                //check area-change
                /**check that area of the property is changed */
                $.ajax({
                    type: "POST",
                    url: "{{route('checAreaChanged')}}",
                    data: {
                        _token: "{{csrf_token()}}",
                        property_master_id: selectedRGR.property_master_id,
                        splited_property_detail_id: selectedRGR.splited_property_detail_id,
                        property_area_in_sqm: selectedRGR.property_area_in_sqm
                    },
                    success: async response => {
                        if (response.status && response.status != 'error') {
                            setEditingState();
                            let changeDate = response.data.date;

                            let RGRDate = dateFromString(changeDate);
                            let updatedArea = response.data.area;
                            let fromDate = dateFromString(selectedRGR.from_date.date.substr(0, 10));
                            let tillDate = dateFromString(selectedRGR.till_date.date.substr(0, 10));
                            if (RGRDate > fromDate && RGRDate < tillDate) {

                                fillEditForm(reason, selectedRGR.already_done.id, fromDate, tillDate, RGRDate, selectedRGR.property_area_in_sqm, updatedArea);
                                editFormData.append('area_changed', 1);
                                const oldHeader = $(`<tr id="old-header"><th colspan="100%">Withdrawn ground rent ${dateToYYYYMMDD(fromDate)} to ${dateToYYYYMMDD(tillDate)}</th></tr>`);
                                $('#calculate-tbody').before(oldHeader); //add heading row before withdrawn details
                                let no_of_days = timeDiffInDays(fromDate, RGRDate);
                                let newRGR1 = {
                                    ...selectedRGR,
                                    from_date: fromDate,
                                    till_date: RGRDate,
                                    no_of_days: no_of_days,
                                    lndo_rgr: (selectedRGR.lndo_rgr_per_annum) ? (selectedRGR.lndo_rgr_per_annum * no_of_days / 365).toFixed(2) : null,
                                    circle_rgr: (selectedRGR.circle_rgr_per_annum) ? (selectedRGR.circle_rgr_per_annum * no_of_days / 365).toFixed(2) : null,
                                }
                                await displayCalculation(newRGR1, true);
                                no_of_days = timeDiffInDays(RGRDate, tillDate);
                                let lndo_land_value = (selectedRGR.lndo_land_rate) ? (parseFloat(selectedRGR.lndo_land_rate) * parseFloat(updatedArea)).toFixed(2) : null;
                                let lndo_rgr_per_annum = (lndo_land_value && selectedRGR.lndoPercent) ? (lndo_land_value * selectedRGR.lndoPercent / 100).toFixed(2) : null;
                                let circle_land_value = (selectedRGR.circle_land_rate) ? (parseFloat(selectedRGR.circle_land_rate) * parseFloat(updatedArea)).toFixed(2) : null;
                                let circle_rgr_per_annum = (circle_land_value && selectedRGR.circlePercent) ? (circle_land_value * selectedRGR.circlePercent / 100).toFixed(2) : null;
                                newRGR2 = {
                                    ...selectedRGR,
                                    from_date: new Date(RGRDate.setDate(RGRDate.getDate() + 1)),
                                    property_area_in_sqm: updatedArea,
                                    no_of_days: no_of_days,
                                    lndo_rgr: (lndo_rgr_per_annum) ? Math.round(lndo_rgr_per_annum * no_of_days / 365) : null,
                                    lndo_land_value: lndo_land_value,
                                    lndo_rgr_per_annum: lndo_rgr_per_annum,
                                    circle_land_value: circle_land_value,
                                    circle_rgr_per_annum: circle_rgr_per_annum,
                                    circle_rgr: (circle_rgr_per_annum) ? Math.round(circle_rgr_per_annum * no_of_days / 365) : null,
                                    till_date: new Date(selectedRGR.till_date.date)
                                }
                                await displayCalculation(newRGR2, true);
                            }
                        } else {
                            showError(response.details);
                        }
                    }
                });
            }

            if (reason == 2) { // when land rate change selected
                $.ajax({
                    type: "POST",
                    url: "{{route('checkPropertyStatusChanged')}}",
                    data: {
                        _token: "{{csrf_token()}}",
                        property_master_id: selectedRGR.property_master_id,
                        splited_property_detail_id: selectedRGR.splited_property_detail_id,
                        property_area_in_sqm: selectedRGR.property_area_in_sqm
                    },
                    success: async response => {
                        if (response.status && response.status != 'error') {
                            setEditingState();
                            let changeDate = response.data.date;

                            let RGRDate = dateFromString(changeDate);
                            let fromDate = dateFromString(selectedRGR.from_date.date.substr(0, 10));
                            let tillDate = dateFromString(changeDate);
                            // if (RGRDate > fromDate && RGRDate < tillDate) {

                            fillEditForm(reason, selectedRGR.already_done.id, fromDate, tillDate);
                            const oldHeader = $(`<tr id="old-header"><th colspan="100%">Withdrawn ground rent ${dateToYYYYMMDD(fromDate)} to ${dateToYYYYMMDD(tillDate)}</th></tr>`);
                            $('#calculate-tbody').before(oldHeader); //add heading row before withdrawn details
                            let no_of_days = timeDiffInDays(fromDate, RGRDate);
                            let newRGR1 = {
                                ...selectedRGR,
                                from_date: fromDate,
                                till_date: RGRDate,
                                no_of_days: no_of_days,
                                lndo_rgr: (selectedRGR.lndo_rgr_per_annum) ? (selectedRGR.lndo_rgr_per_annum * no_of_days / 365).toFixed(2) : null,
                                circle_rgr: (selectedRGR.circle_rgr_per_annum) ? (selectedRGR.circle_rgr_per_annum * no_of_days / 365).toFixed(2) : null,
                            }
                            await displayCalculation(newRGR1, true);

                            // }
                        } else {
                            showError(response.details);
                        }
                    }
                });
            }
            // set editing as true to allow gr to edit
            // $('#submitButton3').html('Proceed');
        }
    })


    function displayCalculation(rgrData, isCopying = false) {
        const table = $('#calculate-table');
        let container;

        if (!isCopying) {
            container = $(document);
        } else {
            const clonedElem = cloneAndPrepareTable();
            container = clonedElem;
        }

        updateTableData(rgrData, container);
        handleButtonState(rgrData, container);

        function cloneAndPrepareTable() {
            // Clone the table body and add necessary classes and headers
            const clonedElem = $('#calculate-tbody').clone().addClass('cloned');

            d1 = dateToYYYYMMDD(rgrData.from_date);
            d2 = dateToYYYYMMDD(rgrData.till_date);

            const newHeader = $(`<tr><th colspan="100%">New Estimate  from ${d1} to ${d2}</th></tr>`);
            clonedElem.prepend(newHeader).appendTo(table);
            clonedElem.removeClass('d-none');
            return clonedElem;
        }

        function updateTableData(data, container) {
            $.each(data, (id, value) => {
                let target = container.find('span#' + id);
                if (target.length) {
                    if (value !== null && value !== undefined) {
                        target.html(value).toggleClass('hasValue', target.hasClass('amount'));
                        /* if (target.closest('td').hasClass('hasNoValue'))
                            target.closest('td').removeClass('hasNoValue'); */
                    } else {
                        target.html('Not Available').removeClass('hasValue');
                        /* target.closest('td').addClass('hasNoValue'); */
                    }
                }
            });

            if (data.lndo_land_rate) {
                const area = parseFloat(data.property_area_in_sqm);
                container.find('#lndo-land-value-calculation').html(`Property Area &times; Land Rate &rarr; ${Math.round(area * 100) / 100} &times; ${data.lndo_land_rate} &thickapprox;`);
                container.find('#lndo-rgr-calculation').html(`${data.lndoPercent}% of ${data.lndo_land_value} &thickapprox;`);
            }

            if (data.circle_land_rate) {
                const area = parseFloat(data.property_area_in_sqm);
                container.find('#circle-land-value-calculation').html(`Property Area &times; Land Rate &rarr; ${Math.round(area * 100) / 100} &times; ${data.circle_land_rate} &thickapprox;`);
                container.find('#circle-rgr-calculation').html(`${data.circlePercent}% of ${data.circle_land_value} &thickapprox;`);
            }

            displayRgrFactorTable(data.rgrFactor, container);
        }

        function displayRgrFactorTable(factor, container) {
            if (Object.keys(factor).length > 0) {
                let tableHTML = "<tr>";

                // Header row with keys
                Object.keys(factor).forEach(key => {
                    tableHTML += `<th colspan="${Object.keys(factor[key]).length}">${key}</th>`;
                });

                tableHTML += `</tr><tr>`;
                Object.values(factor).forEach(val => {
                    Object.keys(val).forEach(key => {
                        tableHTML += `<th>${key}</th>`;
                    });
                });

                tableHTML += `</tr><tr>`;
                Object.values(factor).forEach(val => {
                    Object.values(val).forEach(element => {
                        tableHTML += `<td>${element}% of Land Value</td>`;
                    });
                });

                tableHTML += `</tr>`;
                container.find('#rgrFactorTable').html(tableHTML);
            }
        }

        function handleButtonState(data, container) {
            if (!editing) {
                $('#submitButton3').attr('type', 'submit').html('Proceed');
            }

            $('#calculationContainer').removeClass('d-none');

            if (!data.lndo_land_rate) container.find('#calculation_rate_lndo').attr('disabled', true);
            if (!data.circle_land_rate) container.find('#calculation_rate_circle').attr('disabled', true);

            if ((data.already_done) && !editing) {
                container.find('#calculationContainer').addClass('d-none');
                container.find('#submitButton3').attr('disabled', true);
                container.find('#already-done').removeClass('d-none');
            }
        }
    }

    function timeDiffInDays(date1, date2) {
        const differenceMs = Math.abs(date2 - date1);
        return Math.ceil(differenceMs / (1000 * 60 * 60 * 24));
    }

    function resetDocumentToOriginalState() {
        $('#rgr-card').addClass('d-none'); // hide the form
        $('#fromDate').val(''); //clear the value of date if already entered
        $('#calculationContainer').addClass('d-none') //hide the calculations so that it is not visible when claculate button clicked again
        $('#already-done').addClass('d-none') //hide the already done warning so that it is not visible when claculate button clicked again
        $('#submitButton3').attr('type', 'button'); // do not submit form on next click // display new calculations
        $('#submitButton3').html('Calculate Ground Rent'); // change button content
        $('#submitButton3').prop('disabled', false); // undo disabled
        $('#btn-rgr').data('action', 'show'); // change attribute of the button to perform new action if clicked again
        $('#btn-rgr').html('Start') //change the text of button
        editing = false; //change edititng state to default
        $('.cloned').remove(); //remove edit rgr details from calculation
        if ($('#view-draft').length > 0) {
            $('#view-draft').remove(); //remove view draft button
        }
        $('#detail-card').addClass('d-none');
        $('input[name="calculation_rate"]').prop('checked', false); // reset calculation rate

    }

    function setEditingState() {
        $('#already-done').addClass('d-none') //hide the already done warning so that it is not visible when claculate button clicked again
        $('#submitButton3').attr('type', 'button'); // do not submit form on next click // display new calculations
        $('#submitButton3').html('Calculate Ground Rent'); // change button content
        $('#calculationContainer').removeClass('d-none');
        editing = true;
        $('#submitButton3').attr('type', 'button');

    }

    // Function to fill the form data for editing
    function fillEditForm(reasonForChange, oldRgrId, fromDate, tillDate, editDate = null, oldArea = null, updatedArea = null) {
        editFormData = new FormData(); // Initialize the FormData object
        editFormData.append('oldId', oldRgrId); // Append old RGR ID
        editFormData.append('_token', "{{csrf_token()}}"); // Append CSRF token

        if (editDate) { // handle the case when need to windraw and create 2 rgr 
            /** 
             * rgr1 -> from start date to edit date
             * rgr2 ->  from (edit date +1) to till date
             */
            let fromDate1 = dateToYYYYMMDD(fromDate); // Convert fromDate to YYYY-MM-DD format
            let tillDate1 = dateToYYYYMMDD(editDate); // Convert editDate to YYYY-MM-DD format
            let nextDay = new Date(editDate);
            nextDay.setDate(nextDay.getDate() + 1);
            let fromDate2 = dateToYYYYMMDD(nextDay);
            //let fromDate2 = dateToYYYYMMDD(editDate.setDate(editDate.getDate() + 1)); // Calculate next day of editDate
            let tillDate2 = dateToYYYYMMDD(tillDate); // Convert tillDate to YYYY-MM-DD format
            // Append dates to FormData, serializing them as arrays
            editFormData.append('from_date[]', fromDate1);
            editFormData.append('from_date[]', fromDate2);
            editFormData.append('till_date[]', tillDate1);
            editFormData.append('till_date[]', tillDate2);
        } else { //handle the case when duration of rgr is chaged.
            let fromDate = dateToYYYYMMDD(fromDate);
            let tillDate = dateToYYYYMMDD(tillDate);
            editFormData.append('from_date[]', fromDate);
            editFormData.append('till_date[]', tillDate);
        }

        if (oldArea) //when area changed
            editFormData.append('area[]', oldArea);
        if (updatedArea)
            editFormData.append('area[]', updatedArea);
        editFormData.append('reason_for_change', reasonForChange);
    }

    // Function to convert a date to YYYY-MM-DD format
    function dateToYYYYMMDD(iDate = '') {
        let d = iDate != "" ? new Date(iDate) : new Date(); // Create a new Date object
        let day = d.getDate().toString().padStart(2, '0'); // Ensure day is always two digits
        let month = (d.getMonth() + 1).toString().padStart(2, '0'); // Ensure month is always two digits
        let year = d.getFullYear(); // Get the year
        return `${day}-${month}-${year}`; // Format date as dd-mm-yyyy
    }

    // Function to submit the edited form data
    function submitEditedForm() {
        var selectedValue = $('input[name="calculation_rate"]:checked').val();
        editFormData.append('calculation_rate', selectedValue);
        $.ajax({
            type: "POST",
            url: "{{route('saveEditedRGR')}}",
            data: editFormData,
            processData: false, // Prevent jQuery from processing the data
            contentType: false, // Prevent jQuery from setting the content type
            success: (response) => {
                if (response.status && response.status == 'success') {
                    showSuccess(response.details);
                    resetDocumentToOriginalState();
                }
                if (response.status && response.status == 'error') {
                    showError(response.details);
                }
                editFormData = undefined; //clear form data;
            },
            error: (err) => {
                console.log(err); // Log any errors
            }
        });
    }

    function dateFromString(dateString) {
        let parts = dateString.split('-');
        // Date.UTC expects month in 0-11 range, so subtract 1 from the month
        return new Date(Date.UTC(parts[0], parts[1] - 1, parts[2]));
    }

    function appendPropertyDetail(data, isMultiple = false, rowNum = null) {
        if (isMultiple && rowNum) {
            $('#detail-container').append(`<tr>
                <td>${rowNum}</td><td colspan="4"></td>
            </tr>`);
        }
        // removed <td><b>Land Value : </b> &nbsp;-</td>
        let transferHTML = '';
        if (data.trasferDetails && data.trasferDetails.length > 0) {
            /* transferHTML = `
            <div class= "trafer-details" style="display: inline; position:relative">
            <a href="">&quest;</a>
            <table class="table table-striped">
            <thead>
                <tr>
                <th>#</th>
                <th>Transfer date</th>
                <th>Process of Transfer</th>
                <th>Lessee Name</th>
                </tr>
                </thead>
                <tbody>
                `;
            data.trasferDetails.forEach((row, i) => {
                transferHTML += `<tr>
                    <td>${i+1}</td>
                    <td>${row.transferDate}</td>
                    <td>${row.process_of_transfer}</td>
                    <td>${row.lesse_name}</td>
                    </tr>`
            });
            transferHTML + `</tbody></table></div>`; */
            transferHTML = `<div class= "transfer-details" style="display: inline; position:relative">
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
                    <div class="transfer-list-cell col">${i+1}</div>
                    <div class="transfer-list-cell col">${row.transferDate}</div>
                    <div class="transfer-list-cell col">${row.process_of_transfer}</div>
                    <div class="transfer-list-cell col">${row.lesse_name}</div>
                    </li>`
            });
            transferHTML + `</ul>
            </span> </div>`;
        }

        $('#detail-container').append(`
                        <tr>
                            <td><b>Property ID : </b> &nbsp;${data.unique_propert_id}( ${data.old_propert_id} )</td>
                            <td><b>Land Type : </b> &nbsp;${data.landTypeName}</td>
                            <td><b>Land Use Type : </b> &nbsp;${data.proprtyTypeName}</td>
                            <td><b>Land Use Subtype : </b> &nbsp;${data.proprtySubtypeName}</td>
                            <td><b>Land Size : </b> &nbsp;${Math.round(data.landSize*100)/100} Sq. Mtr.</td>
                        </tr>
                        <tr>
                            <td><b>Status of RGR : </b> &nbsp;<span class="rgrStatus">${data.rgr == 1 ?'Yes':'No'}</span></td>
                            <td><b>Lessee/Owner Name : </b> &nbsp;${data.lesseName ? data.lesseName: 'N/A'} ${(data.trasferDetails && data.trasferDetails.length > 0) ? transferHTML : ''}</td>
                            <td><b>Lease Type : </b> &nbsp;${data.leaseTypeName ? data.leaseTypeName: 'N/A'}</td>
                            <td><b>Owner&apos;s E-mail : </b> &nbsp;${data.email ? data.email: 'N/A'}</td>
                            <td><b>Owner&apos;s Phone Number: </b> &nbsp;${data.phone_no ? data.phone_no: 'N/A'}</td>
                        </tr>
                        <tr>
                            <td><b>Date of Allotment : </b> &nbsp;${data.leaseDate ? data.leaseDate.split('-').reverse().join('-') : 'N/A'}</td>
                            <td><b>Lease Tenure : </b> &nbsp;${data.leaseTenure ? data.leaseTenure +' years' : 'N/A'}</td>
                            <td colspan="3"><b>Address : </b> &nbsp;${data.address ?? 'N A'} </td>
                        </tr>
                    `);
        if (data.rgr_id) {
            $('#detail-card').prepend(`<div id="view-draft"><a class="btn btn-success"  onclick="viewDraft(${data.rgr_id})">View Draft</a></div>`)
        }
    }
</script>