@extends('layouts.app')

@section('title', 'File Movement')

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
</style>
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
        <div class="application-movement">
            <!-- dd($fileMovement) -->
            <!-- Status -->
            <div class="movement-status-container">
                <div class="movement-status-item__status">
                    <div class="movement-status-item status--new">
                        <span class="status-circle"></span>
                        <h4 class="status-title">New</h4>
                    </div>
                    <div class="movement-status-item status--pending">
                        <span class="status-circle"></span>
                        <h4 class="status-title">Pending</h4>
                    </div>
                    <div class="movement-status-item status--recommend">
                        <span class="status-circle"></span>
                        <h4 class="status-title">Recommend</h4>
                    </div>
                    <div class="movement-status-item status--object">
                        <span class="status-circle"></span>
                        <h4 class="status-title">Object</h4>
                    </div>
                    <div class="movement-status-item status--underproof">
                        <span class="status-circle"></span>
                        <h4 class="status-title">Under Proof Reading</h4>
                    </div>
                    <div class="movement-status-item status--reject">
                        <span class="status-circle"></span>
                        <h4 class="status-title">Reject</h4>
                    </div>
                    <div class="movement-status-item status--approve">
                        <span class="status-circle"></span>
                        <h4 class="status-title">Approve</h4>
                    </div>
                </div>
            </div>
           
            <!-- End -->
            <div class="container-grid">
                <ol class="application-movement">
                    @if(count($data->fileMovement) > 0)
                    @foreach($data->fileMovement as $movement)
                    @if($movement['status'] != "In Progress")

                    <li class="{{ $movement['status'] =='New Application'? 'status__new':''}}">
                        <div class="grid-items-status">
                            <div class="movement-status">
                                <span class="status-pin"><i class="fas fa-map-pin fa-fw"></i></span>
                                <h4 class="application-no">{{$data->application_no}}</h4>
                                <h5 class="officer-name">{{$movement['assigned_by']}}</h5>
                                <span class="application-date-time">{{$movement['created_at']}}</span>
                            </div>
                        </div>
                    </li>
                    @else
                    <li class="status__action action-type--{{strtolower($movement['action'])}}">
                        <div class="recommend-action">
                            <h6 class="action-type">{{$movement['action']}}</h6>
                            <h5 class="officer-name">{{$movement['assigned_by']}} ({{$movement['assigned_by_role']}})
                            </h5>
                            @if(!is_null($movement['remark'])) <p class="remarks"><span style="font-weight: 600;">Remarks:</span>
                                {{$movement['remark'] }}
                            </p>@endif
                            <span class="application-date-time">{{$movement['created_at']}}</span>
                        </div>
                    </li>
                    @endif
                    @endforeach
                    @endif
                    {{-- <li class="status__inprogress status__new">
                        <div class="grid-items-status">
                            <div class="movement-status">
                                <span class="status-pin"><i class="fas fa-map-pin fa-fw"></i></span>
                                <h4 class="application-no">APL0000455 - 1</h4>
                                <span class="application-date-time">02-11-2024, 02:58 PM</span>
                            </div>
                        </div>
                    </li>
                    <li class="status__action action-type--recommend">
                        <div class="recommend-action">
                            <h6 class="action-type">Recommend</h6>
                            <h5 class="officer-name">Mr. Raj Nath Chauhan (DY. LDO)</h5>
                            <p class="remarks"><span style="font-weight: 600;">Remarks:</span> Lorem ipsum dolor sit
                                amet consectetur adipisicing elit. Nobis, quisquam?</p>
                            <span class="application-date-time">02-11-2024, 02:58 PM</span>
                        </div>
                    </li>
                    <li class="status__action action-type--recommend">
                        <div class="recommend-action">
                            <h6 class="action-type">Recommend</h6>
                            <h5 class="officer-name">Mr. Raj Nath Chauhan (DY. LDO)</h5>
                            <p class="remarks"><span style="font-weight: 600;">Remarks:</span> Lorem ipsum dolor sit
                                amet consectetur adipisicing elit. Nobis, quisquam?</p>
                            <span class="application-date-time">02-11-2024, 02:58 PM</span>
                        </div>
                    </li>
                    <li class="status__action action-type--recommend">
                        <div class="recommend-action">
                            <h6 class="action-type">Recommend</h6>
                            <h5 class="officer-name">Mr. Raj Nath Chauhan (DY. LDO)</h5>
                            <p class="remarks"><span style="font-weight: 600;">Remarks:</span> Lorem ipsum dolor sit
                                amet consectetur adipisicing elit. Nobis, quisquam?</p>
                            <span class="application-date-time">02-11-2024, 02:58 PM</span>
                        </div>
                    </li>
                    <li class="status__action action-type--recommend">
                        <div class="recommend-action">
                            <h6 class="action-type">Recommend</h6>
                            <h5 class="officer-name">Mr. Ankush Singh (CDV)</h5>
                            <p class="remarks"><span style="font-weight: 600;">Remarks:</span> Lorem ipsum dolor sit
                                amet consectetur adipisicing elit. Nobis, quisquam?</p>
                            <span class="application-date-time">02-11-2024, 02:58 PM</span>
                        </div>
                    </li>
                    <li class="status__action action-type--recommend">
                        <div class="recommend-action">
                            <h6 class="action-type">Recommend</h6>
                            <h5 class="officer-name">Mr. Ankush Singh (CDV)</h5>
                            <p class="remarks"><span style="font-weight: 600;">Remarks:</span> Lorem ipsum dolor sit
                                amet consectetur adipisicing elit. Nobis, quisquam?</p>
                            <span class="application-date-time">02-11-2024, 02:58 PM</span>
                        </div>
                    </li>
                    <li class="status__action action-type--recommend">
                        <div class="recommend-action">
                            <h6 class="action-type">Recommend</h6>
                            <h5 class="officer-name">Mr. Ankush Singh (CDV)</h5>
                            <p class="remarks"><span style="font-weight: 600;">Remarks:</span> Lorem ipsum dolor sit
                                amet consectetur adipisicing elit. Nobis, quisquam?</p>
                            <span class="application-date-time">02-11-2024, 02:58 PM</span>
                        </div>
                    </li>
                    <li class="status__action action-type--recommend">
                        <div class="recommend-action">
                            <h6 class="action-type">Recommend</h6>
                            <h5 class="officer-name">Mr. Ankush Singh (CDV)</h5>
                            <p class="remarks"><span style="font-weight: 600;">Remarks:</span> Lorem ipsum dolor sit
                                amet consectetur adipisicing elit. Nobis, quisquam?</p>
                            <span class="application-date-time">02-11-2024, 02:58 PM</span>
                        </div>
                    </li>
                    <li class="status__action action-type--recommend">
                        <div class="recommend-action">
                            <h6 class="action-type">Recommend</h6>
                            <h5 class="officer-name">Mr. Ankush Singh (CDV)</h5>
                            <p class="remarks"><span style="font-weight: 600;">Remarks:</span> Lorem ipsum dolor sit
                                amet consectetur adipisicing elit. Nobis, quisquam?</p>
                            <span class="application-date-time">02-11-2024, 02:58 PM</span>
                        </div>
                    </li>
                    <li class="status__action status-approved">
                        <div class="recommend-action">
                            <span class="status-pin"><i class="fas fa-map-pin fa-fw"></i></span>
                            <h6 class="action-type">Approved</h6>
                            <h5 class="officer-name">Mr. Raj Nath Chauhan (DY. LDO)</h5>
                            <span class="application-date-time">02-11-2024, 02:58 PM</span>
                        </div>
                    </li> --}}
                </ol>
            </div>
        </div>
    </div>
</div>

@endsection
@section('footerScript')
<script>
    const listItems = document.querySelectorAll(".application-movement > li");

    let currentRowOffsetTop = null;
    let previousRowStartIndex = 0;

    listItems.forEach((item, index) => {
        if (currentRowOffsetTop === null || item.offsetTop > currentRowOffsetTop) {
            currentRowOffsetTop = item.offsetTop;

            if (index - previousRowStartIndex > 1) {
                listItems[index - 1].classList.add("last-item-row");
            }

            previousRowStartIndex = index;
        }
    });

    if (listItems.length - previousRowStartIndex > 1) {
        listItems[listItems.length - 1].classList.add("last-item-row");
    }
</script>
@endsection