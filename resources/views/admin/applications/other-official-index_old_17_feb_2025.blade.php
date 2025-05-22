@extends('layouts.app')

@section('title', 'Application Listing')

@section('content')

<style>
    div.dt-buttons {
        float: none !important;
        width: 19%;
    }

    div.dt-buttons.btn-group {
        margin-bottom: 20px;
    }

    div.dt-buttons.btn-group .btn {
        font-size: 12px;
        padding: 5px 10px;
        border-radius: 4px;
    }

    /* Ensure responsiveness on smaller screens */
    @media (max-width: 768px) {
        div.dt-buttons.btn-group {
            flex-direction: column;
            align-items: flex-start;
        }

        div.dt-buttons.btn-group .btn {
            width: 100%;
            text-align: left;
        }
    }


    .alertDot {
        width: 9px;
        height: 9px;
        background-color: #007bff;
        border-radius: 50%;
        box-shadow: 0 0 10px #007bff, 0 0 20px #007bff, 0 0 30px #007bff;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            box-shadow: 0 0 10px #007bff, 0 0 20px #007bff, 0 0 30px #007bff;
        }

        50% {
            transform: scale(1.2);
            box-shadow: 0 0 15px #007bff, 0 0 30px #007bff, 0 0 45px #007bff;
        }

        100% {
            transform: scale(1);
            box-shadow: 0 0 10px #007bff, 0 0 20px #007bff, 0 0 30px #007bff;
        }
    }
</style>
@php
$statusClasses = [
'APP_REJ' => 'text-danger bg-light-danger',
'APP_NEW' => 'text-primary bg-light-primary',
'APP_IP' => 'text-warning bg-light-warning',
'RS_REW' => 'text-white bg-secondary',
'RS_PEN' => 'text-info bg-light-info',
'APP_APR' => 'text-success bg-light-success',
];
@endphp
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Applications</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Applications List</li>
            </ol>
        </nav>
    </div>
    <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->
</div>

<hr>
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-end">
            <ul class="d-flex gap-3">
                <li class="list-group-item d-flex gap-2 align-items-center flex-wrap">
                    <div class="alertDot"></div>
                    <span class="text-secondary">Have To Take Action</span>
                </li>
                <li class="list-group-item d-flex gap-2 align-items-center flex-wrap">
                    <i class="lni lni-spellcheck fs-5" style="color:#6610f2"></i>
                    <span class="text-secondary">Mis Is Checked</span>
                </li>
                <li class="list-group-item d-flex gap-2 align-items-center flex-wrap">|</li>
                <li class="list-group-item d-flex gap-2 align-items-center flex-wrap">
                    <i class="fadeIn animated bx bx-file-find fs-5" style="color:#20c997"></i>
                    <span class="text-secondary">Scanned Files Checked</span>
                </li>
                <li class="list-group-item d-flex gap-2 align-items-center flex-wrap">|</li>
                <li class="list-group-item d-flex gap-2 align-items-center flex-wrap">
                    <i class="lni lni-cloud-upload fs-5" style="color:#fd7e14"></i>
                    <span class="text-secondary">Uploaded Documents Checked</span>
                </li>
            </ul>
        </div>
        <table id="example" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Applicant No.</th>
                    <th>Property ID</th>
                    <th>Locality</th>
                    <th>Block</th>
                    <th>Plot No.</th>
                    <th>Known As</th>
                    <th>Section</th>
                    <th>Applied For</th>
                    <th>Activity</th>
                    <th>Status
                        {{-- <select class="form-control form-select form-select-sm" name="status" id="status"
                            style="font-weight: bold;">
                            <option value="">Status</option>
                            @foreach ($items as $item)
                            <option class="text-capitalize" value="{{ $item->id }}" @if ($getStatusId==$item->id)
                                @selected(true)
                                @endif>{{ $item->item_name }}
                            </option>
                            @endforeach
                        </select> --}}
                    </th>
                    <th>Applied At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $row)
                <tr>
                    <td>{{$loop->iteration}}</td>

                    <td>
                        <div class="d-flex gap-2 align-items-center">{{$row->application_no}} @if($showAssigned) <div
                                class="alertDot"></div> @endif</div>
                    </td>
                    <td>{{$row->applicationData->old_property_id}}</td>
                    <td>{{$row->applicationData->propertyMaster->newColony->name}}</td>
                    <td>{{$row->applicationData->propertyMaster->block_no}}</td>
                    <td>{{$row->applicationData->propertyMaster->plot_or_property_no}}</td>
                    <td>{{$row->applicationData->propertyMaster->propertyLeaseDetail->presently_known_as}}</td>
                    <td>{{$row->applicationData->sectionCode}}</td>
                    <td>{{getServiceCodeById($row->service_type)}}</td>
                    <td>
                        @if(!empty($row->applicationStatuses))
                        @php
                        $appStatus = $row->applicationStatuses;
                        @endphp
                        @if($appStatus->is_mis_checked == 1)
                        <div class="list-inline-item d-flex align-items-center">
                            <i class="lni lni-spellcheck fs-5"
                                style="color:{{getServiceTypeColorCode('MIS_CHECK')}}"></i> <span
                                class="px-2 fst-italic">{{getUserNameById($appStatus->mis_checked_by)}}</span>
                        </div>
                        @endif
                        @if($appStatus->is_scan_file_checked == 1)
                        <div class="list-inline-item d-flex align-items-center pt-1">
                            <i class="fadeIn animated bx bx-file-find fs-5"
                                style="color:{{getServiceTypeColorCode('SCAN_CHECK')}}"></i><span
                                class="px-2 fst-italic">{{getUserNameById($appStatus->scan_file_checked_by)}}</span>
                        </div>
                        @endif
                        @if($appStatus->is_uploaded_doc_checked == 1)
                        <div class="list-inline-item d-flex align-items-center pt-1">
                            <i class="fadeIn animated bx bx-file-find fs-5"
                                style="color:{{getServiceTypeColorCode('UP_DOC_CHE')}}"></i><span
                                class="px-2 fst-italic">{{getUserNameById($appStatus->uploaded_doc_checked_by)}}</span>
                        </div>
                        @endif
                        @endif
                    </td>
                    <td>
                        @php
                        $item = getStatusDetailsById($row->status);
                        $itemCode = $item->item_code;
                        $itemName = $item->item_name;
                        $class = $statusClasses[$itemCode] ?? 'text-secondary bg-light';
                        @endphp
                        <div class="badge rounded-pill  {{$class}} p-2 text-uppercase px-3">{{$itemName}}</div>
                    </td>
                    <td>{{date('Y-m-d',strtotime($row->created_at))}}</td>
                    <td>
                        <a href="{{ route('applications.view', ['id' => $row->model_id]) }}?type={{ base64_encode($row->model_name) }}">
                            <button type="button" class="btn btn-primary px-5">View</button>
                        </a>
                        

                    </td>
                </tr>
                @empty

                @endforelse
            </tbody>
        </table>

    </div>
</div>
<div id="tooltip"></div>

<div class="modal fade" id="fileMovementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">File Movement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a target="_blank" href=""><button type="button" class="btn btn-primary">View More</button></a>
            </div>
        </div>
    </div>
</div>

{{-- @include('include.alerts.application.schedule-meeting-link-application') --}}
@include('include.alerts.ajax-alert')
@endsection


@section('footerScript')
<script>
    $(document).ready(function () {
        var table = $('#example').DataTable({responsive: true});
    });
</script>
@endsection