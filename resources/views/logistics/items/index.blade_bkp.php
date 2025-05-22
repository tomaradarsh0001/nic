@extends('layouts.app')

@section('title', 'Items')

@section('content')

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-editable.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('assets/js/editableui.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-tooltip@1.0.4/dist/tooltip.min.css" />

    <style>
        .repeater-item-template {
            display: none;
        }

        .warning_icon {
            width: 80px;
            margin-bottom: 10px;
        }

        .btn-width {
            width: 40%;
        }

        .remove-btn {
            margin-top: 28px;
        }

        .btn-group {
            gap: 0 !important;
            border-radius: 0.375rem !important;
        }

        .btn-group,
        .btn-group-vertical {
            position: relative !important;
            display: inline-flex !important;
            vertical-align: middle !important;
            margin-bottom: 25px !important;
        }
    </style>

    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Logistic</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Items</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content py-3">
                <a href="{{ route('logistic.create') }}">
                    <button type="button" class="btn btn-primary py-2">+ Add Items</button>
                </a>
            </div>
            <input type="text" id="urlToDelete" hidden />
            <table class="table table-striped table-bordered" id="myDataTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Label</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        @can('items.status')
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $key => $item)
                        <tr>
                            @php
                                $status = $item->LogisticCategory->status;
                            @endphp
                            <th scope="row">{{ $key + 1 }}</th>
                            <td class="editablelabel" data-type="text" data-name="title" data-pk="{{ $item->id }}"
                                style="color: {{ $status === 'inactive' ? '#ccc' : 'inherit' }};"
                                {{ $status === 'inactive' ? 'data-bs-toggle=tooltip title=Disabled' : '' }}>
                                {{ $item->label }}<i class='bx bx-pencil ms-2'></i>
                            </td>
                            <td class="editablename" data-type="text" data-name="title" data-pk="{{ $item->id }}"
                                style="color: {{ $status === 'inactive' ? '#ccc' : 'inherit' }};"
                                {{ $status === 'inactive' ? 'data-bs-toggle=tooltip title=Disabled' : '' }}>
                                {{ $item->name }}</i>
                            </td>
                            <td style="color: {{ $status === 'inactive' ? '#ccc' : 'inherit' }};"
                                {{ $status === 'inactive' ? 'data-bs-toggle=tooltip title=Disabled' : '' }}>
                                {{ $item->LogisticCategory->name }}</td>
                            <td>
                                <div class="d-flex gap-3">
                                    @php
                                        $isDisabled = $item->LogisticCategory->status == 'inactive';
                                        if ($isDisabled) {
                                            $item->status = 'inactive';
                                            $item->save();
                                        }
                                    @endphp
                                    @can('items.status')
                                        <div class="form-check form-switch form-check-success">
                                            <input class="form-check-input status-switch" type="checkbox" role="switch"
                                                id="status" name="status" {{ $item->status === 'active' ? 'checked' : '' }}
                                                data-item-id="{{ $item->id }}" {{ $isDisabled ? 'disabled' : '' }}>
                                        </div>
                                    @endcan
                                </div>
                            </td>
                            @can('items.status')
                                <td>
                                    <a href="{{ route('logistic.edit', $item->id) }}">
                                        <button type="button" class="btn btn-primary px-5"
                                            {{ $isDisabled ? 'disabled' : '' }}>Edit</button>
                                    </a>
                                </td>
                            @endcan
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('include.alerts.status-change')

    <script>
        $(document).ready(function() {
            var table = $('#myDataTable').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#myDataTable_wrapper .col-md-6:eq(0)');

            // Function to reapply event listeners
            function reapplyEventListeners() {
                $('.status-switch').off('click').on('click', function(e) {
                    e.preventDefault();
                    var itemIdToUpdate = $(this).data('item-id');
                    $('#statusChangeModal').modal('show');

                    $('.confirm-approve').off('click').on('click', function() {
                        window.location.href = `/logistic/items/${itemIdToUpdate}/update-status`;
                        $('#statusChangeModal').modal('hide');
                    });
                });

                $('[data-toggle="tooltip"]').tooltip();
            }

            // Initial application of event listeners
            reapplyEventListeners();

            // Reapply event listeners after each table redraw
            table.on('draw', function() {
                reapplyEventListeners();
            });
        });

        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });

        $.fn.editable.defaults.mode = "inline";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        $('.editablelabel').editable({
            url: "/logistic/items/updatelabel",
            type: 'text',
            pk: 1,
            name: 'name'
        });

        $(document).on('click', '#smallButton', function(event) {
            event.preventDefault();
            let url = $(this).attr('data-url');
            let item = document.getElementById('urlToDelete');
            item.value = url;
        });

        $(document).ready(function() {
            var deleteUrl;
            var rowId;

            $('#confirmDelete').click(function() {
                let input = document.getElementById('urlToDelete');
                deleteUrl = input.value;

                $.ajax({
                    url: deleteUrl,
                    type: 'GET',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(response) {
                        console.log('Error:', response);
                    }
                });
            });
        });
    </script>
@endsection
