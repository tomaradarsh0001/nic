@extends('layouts.app')

@section('title', 'Applicant Property History')

@section('content')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Application History</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item">Application</li>
                    <li class="breadcrumb-item active" aria-current="page">Application History</li>
                </ol>
            </nav>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
           

        </div>
    </div>

    {{-- Dynamic Element --}}
@endsection
@section('footerScript')
    
@endsection
