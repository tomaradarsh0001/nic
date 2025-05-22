@extends('layouts.app')

@section('title', 'Edit Item')

@section('content')

    <div>
        <div class="col pt-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-0 text-uppercase tabular-record_font m-3">Edit Item details</h6>
                    <form action="{{ route('logistic.update', $data->id) }}" id="category-form" method="POST" class="m-4">
                        @csrf
                        @method('PUT')
                        <div class="row align-items-end">
                            <div class="col-12 col-lg-4">
                                <label for="role_name" class="form-label">Edit Label</label>
                                <input type="text" name="label" class="form-control" value="{{ $data->label }}"
                                    placeholder="Edit label">
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="role_name" class="form-label">Edit Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $data->name }}"
                                    placeholder="Edit Name">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="category_id">Update Item:</label>
                                <select id="category_id" name="category_id" class="form-select"
                                    aria-label="Default select example">
                                    <option value="select">select</option>
                                    @foreach ($categories as $category)
                                        @if ($category->status != 'inactive')
                                            <option value="{{ $category->id }}"
                                                {{ $category->id == $data->category_id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-lg-2">
                                <button type="submit" id="submit-button" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#category-form').on('submit', function(event) {
                $('#submit-button').text('Submitting...');
                $('#submit-button').attr('disabled', true);
            });
        });
    </script>
@endsection
