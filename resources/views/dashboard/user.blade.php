@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="card radius-10">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <img src="https://ldo.mohua.gov.in/assets/images/avatars/avatar-1.png" class="rounded-circle p-1 border" width="90" height="90" alt="...">
            <div class="flex-grow-1 ms-3">
                <h5 class="mt-0">Hello {{auth()->user()->name}}</h5>
                <p class="mb-0">Welcome to EDharti</p>
            </div>
        </div>
    </div>
</div> 
@endsection
<!-- end row -->

@section('footerScript')

@endsection
