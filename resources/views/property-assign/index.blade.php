@extends('layouts.app')

@section('title', 'Property Assignment')

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>


<style>
    .pagination .active a {
        color: #ffffff !important;
    }

    .checkbox-sm {
        font-size: 10px;
    }

    .loader {
        display: flex;
        justify-content: center;
        flex-direction: row;
        padding: 2rem;
    }

    .lds-roller {
        /* change color here */
        color: #116d6e
    }

    .lds-roller,
    .lds-roller div,
    .lds-roller div:after {
        box-sizing: border-box;
    }

    .lds-roller {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
    }

    .lds-roller div {
        animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        transform-origin: 40px 40px;
    }

    .lds-roller div:after {
        content: " ";
        display: block;
        position: absolute;
        width: 7.2px;
        height: 7.2px;
        border-radius: 50%;
        background: currentColor;
        margin: -3.6px 0 0 -3.6px;
    }

    .lds-roller div:nth-child(1) {
        animation-delay: -0.036s;
    }

    .lds-roller div:nth-child(1):after {
        top: 62.62742px;
        left: 62.62742px;
    }

    .lds-roller div:nth-child(2) {
        animation-delay: -0.072s;
    }

    .lds-roller div:nth-child(2):after {
        top: 67.71281px;
        left: 56px;
    }

    .lds-roller div:nth-child(3) {
        animation-delay: -0.108s;
    }

    .lds-roller div:nth-child(3):after {
        top: 70.90963px;
        left: 48.28221px;
    }

    .lds-roller div:nth-child(4) {
        animation-delay: -0.144s;
    }

    .lds-roller div:nth-child(4):after {
        top: 72px;
        left: 40px;
    }

    .lds-roller div:nth-child(5) {
        animation-delay: -0.18s;
    }

    .lds-roller div:nth-child(5):after {
        top: 70.90963px;
        left: 31.71779px;
    }

    .lds-roller div:nth-child(6) {
        animation-delay: -0.216s;
    }

    .lds-roller div:nth-child(6):after {
        top: 67.71281px;
        left: 24px;
    }

    .lds-roller div:nth-child(7) {
        animation-delay: -0.252s;
    }

    .lds-roller div:nth-child(7):after {
        top: 62.62742px;
        left: 17.37258px;
    }

    .lds-roller div:nth-child(8) {
        animation-delay: -0.288s;
    }

    .lds-roller div:nth-child(8):after {
        top: 56px;
        left: 12.28719px;
    }

    @keyframes lds-roller {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Settings</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item">Miscellaneous</li>
                <li class="breadcrumb-item active" aria-current="page">Property Assignment</li>
            </ol>
        </nav>
    </div>
    <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->
</div>

<hr>

<div class="card">
    <div class="card-body">
        <div class="col">
            <div class="row mb-3">
                <div class="col">
                    <h5>Property Assignment</h5>
                </div>
            </div>
            <form action="{{route('propertyAssignmentStore')}}" method="POST" id="form">
                @csrf
                <div class="row g-3">
                    <div class="col-12 col-lg-6">
                        <label for="colonyName" class="form-label">Colony</label>
                        <select class="form-control" name="colony" id="colony">
                            <option value="">Colony</option>
                            @foreach ($colonyList as $colony)
                            <option value="{{$colony->id}}">{{ $colony->name }}</option>
                            @endforeach
                        </select>
                        <div id="colonyIdError" class="text-danger"></div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <label for="colonyName" class="form-label">Section</label>
                        <select class="form-control" name="section" id="section">
                            <option value="">Section</option>
                            @foreach ($sections as $section)
                            <option value="{{$section->id}}">{{ $section->name }} - ({{$section->section_code}})</option>
                            @endforeach
                        </select>
                        <div id="sectionIdError" class="text-danger"></div>
                    </div>

                    <div class="loader">
                        <div class="lds-roller">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div id="property-types-container" class="py-3"></div>
                    </div>
                    <div class="col-12">
                        <button type="button" id="propertyButton" class="btn btn-primary" disabled>Submit</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- by Swati Mishra on 28-02-2025 to add datatable in index file start -->
        <hr>
        <div class="py-5">
            <h5>List of sections with their colonies</h5>
            <div class=" pt-3">
                <table id="propertyMappingTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Colony</th>
                            <th>Section</th>
                            <th>Property Type</th>
                            <th>Property Subtype</th>
                            <th>Created By</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        <!-- by Swati Mishra on 28-02-2025 to add datatable in index file end -->
        </div>
    </div>
</div>

@endsection


@section('footerScript')
<script>
    $(document).ready(function () {
        $('.loader').hide()
        //to check is the colony already assigned to any section
        $('#colony').on('change', function () {
            var colony = $('#colony').val();
            $('#property-types-container').hide()
            $('#section').val('');
            
            $.ajax({
                url: "{{route('isColonyAssignedToSection')}}",
                type: "POST",
                data: {
                    colony:colony,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    if(result.status == false){
                        $('#colonyIdError').html(result.message);
                    } else {
                        $('#colonyIdError').html('');
                    }
                   
                }
            })
        })

        // by Swati Mishra on 27-02-2025 to add datatable in index file 

        $('#propertyMappingTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('propertyAssignment') }}",
            columns: [
                    {
                        data: null,
                        name: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + 1; // Auto-increment ID based on row index
                        },
                        orderable: false,
                        searchable: false
                    },
                { data: 'colony_name', name: 'colony_name' },
                { data: 'section_name', name: 'section_name' },
                { data: 'property_type', name: 'property_type' },
                { data: 'property_subtype', name: 'property_subtype' },
                { data: 'created_by', name: 'created_by' }
            ],
            order: [[1, 'asc']]
        });

        //to get all property types on selecting colony
        $('#section').on('change', function () {
            $('.loader').show()
            $('#property-types-container').hide()
            var colony = $('#colony').val();
            if(colony == ''){
                $('#colonyIdError').html('Please select a colony');
            } else {
                $('#colonyIdError').html('');
                $.ajax({
                    url: "{{route('getAllPropertyTypes')}}",
                    type: "POST",
                    data: {
                        _token: '{{csrf_token()}}',
                        colony: colony
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('.loader').hide()
                        $('#property-types-container').show()
                        var formattedDataMap = {};
                        $.each(result.formattedData, function (index, item) {
                            formattedDataMap[item.typeId] = new Set(item.subtypes);
                        });

                        var propertyTypesHtml = '';
                        var heading = `<h6 class="mb-2 form-label">Property Types</h6>`;
                        propertyTypesHtml += heading;
    
                        // Start the table
                        propertyTypesHtml += `<table class="table table-bordered"><thead><tr>`;
    
                        // Add table headers
                        $.each(result.data, function (index, item) {
                            var isDisabled = formattedDataMap[item.typeId] ? 'onclick="return false"' : '';
                            console.log(isDisabled);
                            propertyTypesHtml += `
                                <th>
                                    <div class="form-check form-check-success">
                                        <input class="form-check-input" type="checkbox" value="${item.typeId}" name="propTypes[${item.typeId}]" id="property-type-${item.typeId}" ${isDisabled} checked>
                                        <label class="form-check-label" for="property-type-${item.typeId}">
                                            ${item.type}
                                        </label>
                                    </div>
                                </th>
                            `;
                        });
    
                        propertyTypesHtml += `</tr></thead><tbody><tr>`;
    
                        // Add table data for subtypes
                        $.each(result.data, function (index, item) {
                            var subTypesHtml = '';
    
                            $.each(item.subTypes, function (subIndex, subItem) {
                                var isDisabled = (formattedDataMap[item.typeId] && formattedDataMap[item.typeId].has(subItem.subId)) ? 'disabled' : '';
                                subTypesHtml += `
                                    <div class="form-check form-check-success">
                                        <input class="form-check-input checkbox-sm" type="checkbox" name="subTypes[${item.typeId}][${subItem.subId}]" value="${subItem.subId}" id="property-subtype-${item.typeId}-${subItem.subId}" ${isDisabled} checked>
                                        <label class="form-check-label" for="property-subtype-${subItem.subId}">
                                            ${subItem.subType}
                                        </label>
                                    </div>
                                `;
                            });
    
                            propertyTypesHtml += `<td>${subTypesHtml}</td>`;
                        });
    
                        propertyTypesHtml += `</tr></tbody></table>`;
    
                        $('#property-types-container').html(propertyTypesHtml);
                        $('#propertyButton').prop('disabled', false);
                    }
                })
            }
        })

        // Function to update the state of subType checkboxes based on propType checkbox
        function updateSubTypes(propTypeId, isChecked) {
            $('input[name^="subTypes[' + propTypeId + ']"]').each(function () {
                $(this).prop('checked', isChecked);
            });
        }

        // Event handler for propType checkboxes
        $(document).on('change', 'input[name^="propTypes["]', function () {
            var propTypeId = $(this).val();
            var isChecked = $(this).is(':checked');
            updateSubTypes(propTypeId, isChecked);
        });


        $('#propertyButton').on('click',function(){
            var colony = $('#colony').val()
            var section = $('#section').val()
            
            if(colony == ''){
                $('#colonyIdError').html('Please select colony')
                $('#sectionIdError').html('')
            } else if(section == ''){
                $('#sectionIdError').html('Please select section')
                $('#colonyIdError').html('')
            } else {
                $('#propertyButton').prop('disabled', true);
                $('#propertyButton').html('Submitting...');
                $('#colonyIdError').html('')
                $('#sectionIdError').html('')
                $('#form').submit()
            }

        })

    });
</script>


@endsection