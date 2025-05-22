@extends('layouts.app')

@section('title', 'Colonywise Property Data')

@section('content')

<style>
    .card-header h4{
        font-size: 16px;
        margin: 10px 0;
    }
</style>
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Dashboard</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Colonywise Property List</li>

            </ol>
        </nav>
    </div>
    <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->
</div>

<hr>
<div class="card">
    <div class="card-header">
        <h4>Colonywise Proeprty Details</h4>
    </div>
    <div class="card-body">
        <table id="example" class="table table-striped display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Colony</th>
                    <th>No of Porperties</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $row)
                @php
                $queryParams = [
                'section_id[]' => $sectionId,
                'colony[]' => $row->colonyId
                ];
                $url = route('detailedReport') . '?' . http_build_query($queryParams);
                @endphp
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$row->colony_name}}</td>

                    <td>
                        <a href="{{$url}}">
                            {{$row->counter}}
                        </a>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8"> No Data to Display</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>
@include('include.alerts.ajax-alert')
@endsection


@section('footerScript')
@endsection