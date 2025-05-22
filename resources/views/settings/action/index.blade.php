@extends('layouts.app')

@section('title', 'Action Settings')

@section('content')
<style>
    .pagination .active a {
        color: #ffffff !important;
    }

    .required-error-message {
        display: none;
    }

    .required-error-message {
        margin-left: -1.5em;
        margin-top: 3px;
    }
    .required-error-edit-message{
        display: none;
    }

    .form-check-inputs[type=checkbox] {
        border-radius: .25em;
    }

    .form-check .form-check-inputs {
        float: left;
        margin-left: -1.5em;
    }

    .form-check-inputs {
        width: 1.5em;
        height: 1.5em;
        margin-top: 0;
    }

    .testWhatsapp {
        cursor: pointer;
    }

    .loader {
        display: none;
        border: 8px solid #7e7487;
        border-top: 8px solid #4fc4c1;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 1s linear infinite;
        position: absolute;
    }

    @keyframes spin {
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
                <li class="breadcrumb-item active" aria-current="page">Actions</li>
            </ol>
            </li>
            </ol>

        </nav>
    </div>
</div>

<hr>


<div class="row align-data-height">
    <div class="col-xl-8 col-12">
        <div class="card list-data-height">
            <div class="card-body">
                <div class="d-flex justify-content-between py-3">
                    <h6 class="mb-0 text-uppercase tabular-record_font align-self-end">Actions</h6>
                </div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Code</th>
                            @haspermission('settings.action.update')
                            <th scope="col">Edit</th>
                            @endhaspermission
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($actions as $index => $action)
                        <tr class="">
                            <th scope="row">{{$index+1}}</th>
                            <td>{{$action->item_name}}</td>
                            <td>{{$action->item_code}}</td>
                            @haspermission('settings.action.update')
                            <td>
                                <div class="d-flex gap-3">
                                    <a href="{{route('settings.action.edit',$action->id)}}"><button type="button"
                                            class="btn btn-primary px-3">Edit</button></a>
                                </div>
                            </td>
                            @endhaspermission
                        </tr>
                        @empty
                        <p class="text-danger text-center text-capitalize fs-5">No Actions available</p>
                        @endforelse

                    </tbody>
                </table>
                {{ $actions->links() }}
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-12">
        <div class="card map-same-height">
            <div class="card-body">
                @if (request()->routeIs('settings.action.index'))
                <div class="d-flex justify-content-between py-3">
                    <h6 class="mb-0 text-uppercase tabular-record_font align-self-end">Create Action</h6>
                </div>
                <form class="row g-3" id="actionCreateForm" method="post" action="{{route('settings.action.store')}}">
                    @csrf
                    <div class="col-md-12">
                        <label for="actionName" class="form-label">Action Name</label>
                        <input type="text" class="form-control required-for-action-setting-create" id="actionName"
                            name="actionName" placeholder="Action Name">
                        <div class="text-danger required-error-message px-4" id="actionNameError">Action name is required.
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="actionCode" class="form-label">Action Code</label>
                        <input type="text" class="form-control required-for-action-setting-create" id="actionCode"
                            name="actionCode" placeholder="Action Code">
                        <div class="text-danger required-error-message px-4" id="actionCodeError">Action code is required.
                        </div>
                    </div>
                    <div class="col-12 py-2">
                        <button type="button" id="actionButton" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                @elseif (request()->routeIs('settings.action.edit'))
                <div class="d-flex justify-content-between py-3">
                    <h6 class="mb-0 text-uppercase tabular-record_font align-self-end">Update Action</h6>
                </div>
                <form class="row g-3" id="actionEditForm" method="post" action="{{route('settings.action.update',$item->id)}}">
                    @csrf
                    @method('PUT')
                    <div class="col-md-12">
                        <label for="actionName" class="form-label">Action Name</label>
                        <input type="text" class="form-control required-for-action-setting-edit" id="actionName"
                            name="actionName" value="{{$item->item_name}}" placeholder="Action Name">
                        <div class="text-danger required-error-edit-message" id="actionNameError">Action name is required.
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="actionCode" class="form-label">Action Code</label>
                        <input type="text" class="form-control" id="actionCode"
                            name="actionCode" value="{{$item->item_code}}" placeholder="Action Code" disabled>
                    </div>
                    <div class="col-12 py-2 d-flex gap-3">
                        <button type="button" id="actionEditButton" class="btn btn-primary">Update</button>
                        <a href="{{route('settings.action.index')}}"><button type="button" id="actionEditButton" class="btn btn-secondary">Cancel</button></a>
                    </div>
                </form>
                @else
                    <p>Invalid action or URL.</p>
                @endif
            </div>
        </div>
    </div>
</div>






@endsection
@section('footerScript')
<script>
    $('#actionButton').click(function () {
        let allInputFilled = true;
        $('.required-for-action-setting-create').each(function () {
            const $input = $(this);
            const $errorMsg = $input.siblings('.required-error-message');

            if ($input.val() == '') {
                $errorMsg.show();
                allInputFilled = false;
            } else {
                $errorMsg.hide();
            }
        });
        if (allInputFilled) {
            $('#actionButton').prop('disabled', true);
            $('#actionButton').html('Submitting...');
            $('#actionCreateForm').submit();
        }
    });

    $('#actionEditButton').click(function () {
        let allInputFilled = true;
        $('.required-for-action-setting-edit').each(function () {
            const $input = $(this);
            const $errorMsg = $input.siblings('.required-error-edit-message');

            if ($input.val() == '') {
                $errorMsg.show();
                allInputFilled = false;
            } else {
                $errorMsg.hide();
            }
        });
        if (allInputFilled) {
            $('#actionEditButton').prop('disabled', true);
            $('#actionEditButton').html('Updating...');
            $('#actionEditForm').submit();
        }
    });
</script>

@endsection