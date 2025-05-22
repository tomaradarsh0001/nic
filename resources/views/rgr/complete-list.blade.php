@extends('layouts.app')

@section('title', 'List | Revision of Ground Rent')

@section('content')
<link rel="stylesheet" href="{{asset('assets/css/rgr.css')}}">
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">RGR</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item">RGR</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Complete List</li>
            </ol>
        </nav>
    </div>
    <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->
</div>
<!--end breadcrumb-->

<hr>


<div class="card">
    <div class="card-body">
        <div class="row">
            @include('include.parts.rgr-list',['data'=>$data,'highlighted'=>$highlighted])
        </div>
    </div>
</div>

@endsection