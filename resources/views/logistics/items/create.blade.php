@extends('layouts.app')

@section('title', 'Items List')

@section('content')

    <style>
        .add-btn {
            background-color: #ffffff;
            color: gray;
            font-size: 10px;
            text-align: center;
            justify-content: center;
            border: 1px solid;
            border-color: gray;
            border-radius: 5px;
            cursor: pointer;
            transition: ease 1s;
            padding: 5px;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Logistic</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add Items</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-end py-3">
                <a href="{{ route('logistic.index') }}">
                    <button type="button" class="btn btn-danger px-2 mx-2">← Back</button>
                </a>
                <!-- <a href="{{ route('category.index') }}">
                                    <button type="button" class="btn btn-primary px-2">+ Add Category</button>
                                </a> -->
            </div>
            <!-- <h4 class=" text-uppercase tabular-record_font mb-3 mx-3">Add Items</h4> -->
            <form method="POST" id="category-form" action="{{ route('logistic_items.store') }}">
                @csrf
                <div class="form-row m-3">
                    <div class="form-group col-md-6">
                        <label class="form-label" for="label">Label:</label>
                        <input type="text" id="label" name="label" class="form-control" autocomplete="off">
                    </div>

                    <div class="form-group col-md-6">
                        <label class="form-label" for="name">Name:</label>
                        <input type="text" id="name" name="name" class="form-control" maxlength="30">
                    </div>
                </div>
                <!-- <div class="form-group">
                            <label for="category_id">Category ID:</label>
                            <input type="number" id="category_id" name="category_id" class="form-control" maxlength="10">
                        </div> -->
                <div class="form-row m-3">
                    <div class="form-group col-md-6">
                        <label class="form-label" for="category_id">Category:</label>
                        <a href="{{ route('category.index') }}" class="add-btn">&plus;&nbsp;Add
                            Category</a>
                        <select id="category_id" name="category_id" class="form-select mb-3" aria-label="Select">
                            <option value="" selected>Select</option>
                            @foreach ($categories as $category)
                                <!-- <option value="{{ $category->id }}" {{ $category->status == 'inactive' ? 'disabled' : '' }}>
                                                                                {{ $category->name }}
                                                                            </option> -->
                                @if ($category->status != 'inactive')
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="status">Status:</label>
                        <select id="status" name="status" class="form-control mb-3">
                            <option value='active'>Active</option>
                            <option value='inactive'>Inactive</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary m-3" id="submit-button">Submit</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#label").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('items.autocomplete') }}",
                        data: {
                            q: request.term
                        },
                        success: function(data) {
                            response(data);
                        },
                        error: function() {
                            console.error('Error fetching suggestions');
                        }
                    });
                },
                minLength: 2
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
