@extends('layouts.app')

@section('title', 'Supplier Vendor')

@section('content')

    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Store</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Vendors</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body">


            <form method="POST" action="{{ route('logistic_category.storeCategory') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="name">Name:</label>
                    <input type="text" id="name" name="name" class="form-control" maxlength="30">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="contact">Contact:</label>
                    <input type="number" id="contact" name="contact" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" maxlength="30">
                </div>


                <div class="mb-3">
                    <label class="form-label" for="address">Address:</label>
                    <input type="textarea" id="text" name="text" class="form-control" maxlength="30">
                </div>


                <div class="mb-3">
                    <label class="form-label" for="status">Status:</label>
                    <select id="status" name="status" class="form-control mb-3">
                        <option value='active'>Active</option>
                        <option value='inactive'>Inactive</option>
                    </select>
                </div>


                <div class="mb-3">
                    <label class="form-label" for="date">Is Tender:</label>
                    <input type="date" id="td" name="tender" class="form-control">
                </div>


                <div class="mb-3">
                    <label class="form-label" for="address">From Tender:</label>
                    <input type="date" id="text" name="text" class="form-control">
                </div>


                <div class="mb-3">
                    <label class="form-label" for="address">To Tender:</label>
                    <input type="date" id="text" name="text" class="form-control">
                </div>



                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
