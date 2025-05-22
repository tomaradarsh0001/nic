@extends('layouts.app')

@section('title', 'Category')

@section('content')
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-editable.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <script src="{{ asset('assets/js/editableui.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    <li class="breadcrumb-item active" aria-current="page">Add Category</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card ">
        <div class="card-body m-3">

            <div class="d-flex justify-content-end py-3">
                <a href="{{ route('logistic.index') }}">
                    <button type="button" class="btn btn-danger px-2 mx-2">← Back</button>
                </a>
            </div>
            <input type="text" id="urlToDelete" hidden />
            <form method="POST" action="{{ route('logistic_category.store') }}" id="category-form">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="name">Name:</label>
                    <input type="text" id="name" name="name" class="form-control" maxlength="30">
                    <span id="name-error" style="color:red;"></span>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="status">Status:</label>
                    <select id="status" name="status" class="form-control mb-3">
                        <option value='active'>Active</option>
                        <option value='inactive'>Inactive</option>
                    </select>
                </div>
                <button type="submit" id="submit-button" class="btn btn-primary" disabled>Submit</button>
            </form>
            <hr class="my-5 my-4">
            <div class="categories">
                <h6 class="mb-0 text-uppercase tabular-record_font pb-4">Category List</h6>
                <table class="table mb-0 table-striped table-bordered" id="myDataTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            @can('category.status')
                                <th scope="col">Status</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $key => $item)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td class="editable" data-type="text" data-name="title" data-pk="{{ $item->id }}">
                                    {{ $item->name }}<i class='bx bx-pencil ms-2'></i>
                                </td>
                                <td>
                                    @can('category.status')
                                        <div class="form-check form-switch form-check-success">
                                            <input class="form-check-input toggle-status" data-id="{{ $item->id }}"
                                                type="checkbox" role="switch" id="status" name="status"
                                                {{ $item->status === 'active' ? 'checked' : '' }}>
                                        </div>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('include.alerts.status-change')

    <script>
        $.fn.editable.defaults.mode = "inline";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        $('.editable').editable({
           // url: "/logistic/category/update",
           url:  "{{ route('category.update') }}",
            type: 'text',
            pk: 1,
            name: 'name',
            name: 'name'
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).on('click', '#smallButton', function(event) {
            event.preventDefault();
            let url = $(this).attr('data-url');
            let item = document.getElementById('urlToDelete');
            item.value = url;
        });
    </script>
    <script>
        $(document).ready(function() {
            var deleteUrl;
            var rowId;

            $('#confirmDelete').click(function() {
                let input = document.getElementById('urlToDelete');
                console.log(input);
                deleteUrl = input.value;
                console.log(deleteUrl);

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
    <script>
        $(document).ready(function() {
            var table = $('#myDataTable').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#myDataTable_wrapper .col-md-6:eq(0)');
        });

         let categoryId; // Store the category ID for the status change

    // Predefined route template from Laravel
    const updateStatusUrlTemplate = "{{ route('category.updateStatus', ['itemId' => '__ID__']) }}";

    // Event listener for toggle switch
    $('.toggle-status').on('change', function() {
        categoryId = $(this).data('id');
        $('#statusChangeModal').modal('show');
    });

    // Event listener for the confirm button in the modal
    $('.confirm-approve').on('click', function() {
        $('#statusChangeModal').modal('hide');

        const finalUrl = updateStatusUrlTemplate.replace('__ID__', categoryId);

        $('<form>', {
            id: "status-form",
            method: "POST",
            action: finalUrl,
            html: `
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="POST">
            `
        }).appendTo(document.body).submit();
    });
        $(document).ready(function() {
            $('#name').on('input', function() {
                var name = $(this).val();
                var token = "{{ csrf_token() }}";

                if (name.length > 0) {
                    $.ajax({
                        url: "{{ route('logistic_category.checkName') }}",
                        method: 'POST',
                        data: {
                            _token: token,
                            name: name
                        },
                        success: function(response) {
                            if (response.exists) {
                                $('#name-error').text('Category name already exists.');
                                $('#submit-button').attr('disabled', 'disabled');
                            } else {
                                $('#name-error').text('');
                                $('#submit-button').removeAttr('disabled');
                            }
                        }
                    });
                } else {
                    $('#name-error').text('');
                    $('#submit-button').removeAttr('disabled');
                }
            });
        });
        $('#category-form').on('submit', function() {
            $('#submit-button').attr('disabled', 'disabled');
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#category-form').on('submit', function(event) {
                $('#submit-button').text('Submitting...');
                $('#submit-button').attr('disabled', true);
            });
        });
    </script>

@endsection
