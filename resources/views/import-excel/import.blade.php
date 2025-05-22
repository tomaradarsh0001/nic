@extends('layouts.app')

@section('title', 'Import Table Data')

@section('content')
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Upload Excel</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Upload Excel</li>
            </ol>
        </nav>
    </div>
    <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->
</div>
<!--end breadcrumb-->
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Import Excel Data</h5>
        <form action="{{ route('import.table') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
            <div class="mb-3">
                <label for="table" class="form-label">Select Table:</label>
                <select name="table" id="table" class="form-select" required>
                    <option value="" disabled selected>Select a table</option>
                    @foreach($tables as $table)
                        <option value="{{ $table }}">{{ $table }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    Please select a table.
                </div>
            </div>

            <div class="mb-3">
                <label for="file" class="form-label">Upload Excel File:</label>
                <input type="file" name="file" id="file" class="form-control" required>
                <div class="invalid-feedback">
                    Please upload a file.
                </div>
            </div>

            
            <button type="submit" class="btn btn-primary">Import</button>
            
        </form>
    </div>
</div>

@endsection
