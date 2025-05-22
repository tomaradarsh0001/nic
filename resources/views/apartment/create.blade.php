@extends('layouts.app')
@section('title', 'Application For Deed Of Apartment')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Application</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item">Deed Of Apartment</li>
                    {{-- <li class="breadcrumb-item active" aria-current="page">Fill Application</li> --}}
                </ol>
            </nav>
        </div>
    </div>
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="part-title">
                <h5>Fill Application Form</h5>
            </div>
            <form action="{{ route('application.apartment.store') }}" method="POST" enctype="multipart/form-data"
                id="deedOfApartmentForm">
                @csrf
                <div class="part-details">
                    <div class="container-fluid">
                    </div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label for="applicantName" class="form-label">Name</label>
                                <input type="text" class="form-control" name="applicantName" id="applicantName"
                                    placeholder="Enter Name" value="{{ old('applicantName') }}">
                                @error('applicantName')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="text-danger" id="applicantNameError"></div>
                            </div>
                            <div class="col-lg-4">
                                <label for="applicantAddress" class="form-label">Address</label>
                                <input type="text" class="form-control" name="applicantAddress" id="applicantAddress"
                                    placeholder="Enter Address" value="{{ old('applicantAddress') }}">
                                @error('applicantAddress')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="text-danger" id="applicantAddressError"></div>
                            </div>
                            <div class="col-lg-4">
                                <label for="buildingName" class="form-label">Building Name <small
                                        class="form-text text-muted">(In
                                        which the apartment exists.)</small></label>
                                <input type="text" class="form-control" name="buildingName" id="buildingName"
                                    placeholder="Building name" value="{{ old('buildingName') }}">
                                @error('buildingName')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="text-danger" id="buildingNameError"></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label for="locality" class="form-label">Locality</label>
                                <select name="locality" id="locality" class="form-select">
                                    <option value="">Select</option>
                                    @foreach ($colonyList as $colony)
                                        <option value="{{ $colony->id }}">{{ $colony->name }}</option>
                                    @endforeach
                                </select>
                                @error('locality')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="text-danger" id="localityError"></div>
                            </div>
                            <div class="col-lg-4">
                                <label for="block" class="form-label">Block</label>
                                <select name="block" id="block" class="form-select">
                                    <option value="">Select</option>
                                </select>
                                @error('block')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="text-danger" id="blockError"></div>
                            </div>
                            <div class="col-lg-4">
                                <label for="plot" class="form-label">Plot No. <small class="form-text text-muted">(Where
                                        the
                                        building/property exists.)</small></label>
                                <select name="plot" id="plot" class="form-select">
                                    <option value="">Select</option>
                                </select>
                                @error('plot')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="text-danger" id="plotError"></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label for="knownas" class="form-label">Known As</label>
                                <select name="knownas" id="knownas" class="form-select">
                                    <option value="">Select</option>
                                </select>
                                @error('knownas')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="text-danger" id="knownasError"></div>
                            </div>
                            <div class="col-lg-4">
                                <label for="FlatNumber" class="form-label">Flat No.</label>
                                <input type="text" class="form-control" name="FlatNumber" id="FlatNumber"
                                    placeholder="Enter Flat No" value="{{ old('FlatNumber') }}">
                                @error('FlatNumber')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="text-danger" id="FlatNumberError"></div>
                            </div>

                            <div class="col-lg-4">
                                <label for="originalBuyerName" class="form-label">Name Of Original Buyer</label>
                                <input type="text" class="form-control" name="originalBuyerName"
                                    id="originalBuyerName" placeholder="Enter Name Of Original Buyer"
                                    value="{{ old('originalBuyerName') }}">
                                @error('originalBuyerName')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="text-danger" id="originalBuyerNameError"></div>
                            </div>


                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label for="presentOccupantName" class="form-label">Name Of Present Occupant</label>
                                <input type="text" class="form-control" name="presentOccupantName"
                                    id="presentOccupantName" placeholder="Enter Name Of Present Occupant"
                                    value="{{ old('presentOccupantName') }}">
                                @error('presentOccupantName')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="text-danger" id="presentOccupantNameError"></div>
                            </div>
                            <div class="col-lg-4">
                                <label for="purchasedFrom" class="form-label">Purchased From</label>
                                <input type="text" class="form-control" name="purchasedFrom" id="purchasedFrom"
                                    placeholder="Enter Purchased From" value="{{ old('purchasedFrom') }}">
                                @error('purchasedFrom')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="text-danger" id="purchasedFromError"></div>
                            </div>
                            <div class="col-lg-4">
                                <label for="plotArea" class="form-label">Plot Area <small
                                        class="form-text text-muted">(Leased
                                        From L&DO in Sq. Mtr.)</small> </label>
                                <input type="text" class="form-control" name="plotArea" id="plotArea"
                                    placeholder="Enter Total Plot Area" value="{{ old('plotArea') }}">
                                @error('plotArea')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="text-danger" id="plotAreaError"></div>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label for="apartmentArea" class="form-label">Apartment Area <small
                                        class="form-text text-muted">(In Sq.
                                        Mtr. including common area.)</small></label>
                                <input type="text" class="form-control" name="apartmentArea" id="apartmentArea"
                                    placeholder="Enter Total Apartment Area" value="{{ old('apartmentArea') }}">
                                @error('apartmentArea')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="text-danger" id="apartmentAreaError"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="part-title mt-2">
                    <h5>OWNERSHIP DOCUMENTS</h5>
                </div>
                <div class="part-details">
                    <div class="container-fluid">
                    </div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="builderAgreementDoc" class="form-label">Builder & Buyer
                                        Agreement</label>
                                    <input type="file" name="builderAgreementDoc" class="form-control"
                                        accept="application/pdf" id="builderAgreementDoc">
                                    <small class="text-muted">Upload documents (pdf file, up to 50 MB)</small>

                                    @error('builderAgreementDoc')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="text-danger" id="builderAgreementDocError"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label for="saleDeedDoc" class="form-label">Sale Deed <small
                                        class="form-text text-muted">(PDF)</small></label>
                                <input type="file" name="saleDeedDoc" id="saleDeedDoc" class="form-control"
                                    accept="application/pdf">
                                <small class="form-text text-muted">Upload PDF document (Max: 5MB)</small>
                                @error('saleDeedDoc')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="text-danger" id="saleDeedDocError"></div>
                            </div>
                            <div class="col-lg-4">
                                <label for="otherDoc" class="form-label">Other Documents <small
                                        class="form-text text-muted">(PDF)</small></label>
                                <input type="file" name="otherDoc" id="otherDoc" class="form-control"
                                    accept="application/pdf">
                                <small class="form-text text-muted">Upload PDF document (Max: 5MB)</small>
                                @error('otherDoc')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="text-danger" id="otherDocError"></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label for="buildingPlanDoc" class="form-label">Building Plan <small
                                        class="form-text text-muted">(PDF)</small></label>
                                <input type="file" name="buildingPlanDoc" id="buildingPlanDoc" class="form-control"
                                    accept="application/pdf">
                                <small class="form-text text-muted">Upload PDF document (Max: 5MB)</small>
                                @error('buildingPlanDoc')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="text-danger" id="buildingPlanDocError"></div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" id="submitDeedOfApartmentFormBtn"
                                class="btn btn-primary btn-theme">Submit</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
    </div>

    </div>
    </div>
    {{-- Dynamic Element --}}
@endsection
@section('footerScript')
    <script>
        // //get all blocks of selected locality
        // $('#locality').on('change', function() {
        //     var locality = this.value;
        //     $("#block").html('');
        //     $.ajax({
        //         url: "{{ route('localityBlocks') }}",
        //         type: "POST",
        //         data: {
        //             locality: locality,
        //             _token: '{{ csrf_token() }}'
        //         },
        //         dataType: 'json',
        //         success: function(result) {
        //             $('#block').html('<option value="">Select Block</option>');
        //             $.each(result, function(key, value) {
        //                 $("#block").append('<option value="' + value.block_no + '">' + value
        //                     .block_no + '</option>');
        //             });
        //         }
        //     });
        // });
        // //get all plots of selected block
        // $('#block').on('change', function() {
        //     var locality = $('#locality').val();
        //     var block = this.value;
        //     $("#plot").html('');
        //     $.ajax({
        //         url: "{{ route('blockPlots') }}",
        //         type: "POST",
        //         data: {
        //             locality: locality,
        //             block: block,
        //             _token: '{{ csrf_token() }}'
        //         },
        //         dataType: 'json',
        //         success: function(result) {
        //             // console.log(result);
        //             $('#plot').html('<option value="">Select Plot</option>');
        //             $.each(result, function(key, value) {
        //                 $("#plot").append('<option value="' + value.plot_or_property_no + '">' +
        //                     value.plot_or_property_no + '</option>');
        //             });
        //         }
        //     });
        // });
        // //get known as of selected plot
        // $('#plot').on('change', function() {
        //     var locality = $('#locality').val();
        //     var block = $('#block').val();
        //     var plot = this.value;
        //     $("#knownas").html('');
        //     $.ajax({
        //         url: "{{ route('plotKnownas') }}",
        //         type: "POST",
        //         data: {
        //             locality: locality,
        //             block: block,
        //             plot: plot,
        //             _token: '{{ csrf_token() }}'
        //         },
        //         dataType: 'json',
        //         success: function(result) {
        //             // console.log(result);
        //             $('#knownas').html('<option value="">Select Known as</option>');
        //             $.each(result, function(key, value) {
        //                 $("#knownas").append('<option value="' + value + '">' + value +
        //                     '</option>');
        //             });
        //         }
        //     });
        // });

        //get all blocks of selected locality
        $('#locality').on('change', function() {
            var locality = this.value;
            $("#block").html('');
            $.ajax({
                url: "{{ route('localityBlocks') }}",
                type: "POST",
                data: {
                    locality: locality,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#block').html('<option value="">Select Block</option>');
                    $.each(result, function(key, value) {
                        $("#block").append('<option value="' + value.block_no + '">' + value
                            .block_no + '</option>');
                    });
                }
            });
        });

        //get all plots of selected block
        $('#block').on('change', function() {
            var locality = $('#locality').val();
            var block = this.value;
            $("#plot").html('');
            $.ajax({
                url: "{{ route('blockPlots') }}",
                type: "POST",
                data: {
                    locality: locality,
                    block: block,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    // console.log(result);
                    $('#plot').html('<option value="">Select Plot</option>');
                    $.each(result, function(key, value) {

                        $("#plot").append('<option value="' + value + '">' +
                            value + '</option>');
                    });
                }
            });
        });


        //get known as of selected plot
        $('#plot').on('change', function() {
            var locality = $('#locality').val();
            var block = $('#block').val();
            var plot = this.value;
            $("#knownas").html('');
            $.ajax({
                url: "{{ route('plotKnownas') }}",
                type: "POST",
                data: {
                    locality: locality,
                    block: block,
                    plot: plot,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    // console.log(result);
                    $('#knownas').html('<option value="">Select Known as</option>');
                    $.each(result, function(key, value) {

                        $("#knownas").append('<option value="' + value + '">' + value +
                            '</option>');
                    });
                }
            });
        });


        $(document).ready(function() {
            $('#submitDeedOfApartmentFormBtn').click(function(e) {
                e.preventDefault(); // Prevent default form submission

                // Clear previous error messages
                $('.text-danger').text('');

                let isValid = true;

                // Validate primary form fields
                if (!$('#applicantName').val()) {
                    $('#applicantName').next('.text-danger').text('Please enter the applicant name.');
                    isValid = false;
                }

                if (!$('#applicantAddress').val()) {
                    $('#applicantAddress').next('.text-danger').text('Please enter the address.');
                    isValid = false;
                }

                if (!$('#buildingName').val()) {
                    $('#buildingName').next('.text-danger').text('Please enter the building name.');
                    isValid = false;
                }

                if (!$('#locality').val()) {
                    $('#locality').next('.text-danger').text('Please select a locality.');
                    isValid = false;
                }

                if (!$('#block').val()) {
                    $('#block').next('.text-danger').text('Please select a block.');
                    isValid = false;
                }

                if (!$('#plot').val()) {
                    $('#plot').next('.text-danger').text('Please select a plot.');
                    isValid = false;
                }

                if (!$('#knownas').val()) {
                    $('#knownas').next('.text-danger').text('Please select a known as.');
                    isValid = false;
                }

                if (!$('#originalBuyerName').val()) {
                    $('#originalBuyerName').next('.text-danger').text(
                        'Please enter the original buyer\'s name.');
                    isValid = false;
                }

                if (!$('#presentOccupantName').val()) {
                    $('#presentOccupantName').next('.text-danger').text(
                        'Please enter the present occupant\'s name.');
                    isValid = false;
                }

                if (!$('#purchasedFrom').val()) {
                    $('#purchasedFrom').next('.text-danger').text('Please enter the firm name.');
                    isValid = false;
                }

                if (!$('#plotArea').val()) {
                    $('#plotArea').next('.text-danger').html(
                        'Please enter the plot area <small class="form-text text-danger" style="font-size:x-small;">(Leased From L&DO in Sq. Mtr.)</small>'
                    );

                    isValid = false;
                }

                if (!$('#apartmentArea').val()) {
                    $('#apartmentArea').next('.text-danger').html(
                        'Please enter the  apartment area <small class="form-text text-danger" style="font-size:x-small;">(In Sq. Mtr. including common area).</small>'
                    );
                    isValid = false;
                }

                const fileInputs = [{
                        id: 'builderAgreementDoc',
                        errorId: 'builderAgreementDocError',
                        label: 'Builder & Buyer Agreement'
                    },
                    {
                        id: 'saleDeedDoc',
                        errorId: 'saleDeedDocError',
                        label: 'Sale Deed'
                    },
                    {
                        id: 'otherDoc',
                        errorId: 'otherDocError',
                        label: 'Other Documents'
                    },
                    {
                        id: 'buildingPlanDoc',
                        errorId: 'buildingPlanDocError',
                        label: 'Building Plan'
                    }
                ];

                fileInputs.forEach(input => {
                    const fileInput = document.getElementById(input.id);
                    if (fileInput.files.length === 0) {
                        $('#' + input.errorId).text('Please upload the ' + input.label + '.');
                        isValid = false;
                    } else if (fileInput.files[0].size > 50 * 1024 * 1024) { // 50 MB limit
                        $('#' + input.errorId).text(input.label + ' file must be less than 50 MB.');
                        isValid = false;
                    }
                });

                if (!isValid) {
                    return; // Prevent form submission if validation fails
                }

                // Submit the form if valid
                $('#submitDeedOfApartmentFormBtn').prop('disabled', true);
                $('#submitDeedOfApartmentFormBtn').html('Submitting...');
                $('#deedOfApartmentForm').submit();
            });
        });
    </script>
@endsection
