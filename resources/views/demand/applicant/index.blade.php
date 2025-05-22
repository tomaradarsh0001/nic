@extends('layouts.app')

@section('title', 'Demand Listing')

@section('content')

<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Demand</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Demand</li>
                <li class="breadcrumb-item active" aria-current="page">List</li>
            </ol>
        </nav>
    </div>
    <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->
</div>

<hr>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="log-12">
                <table id="example" class="table table-striped display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Unique Demand Id</th>
                            <th>Property ID</th>
                            <th>Known As</th>
                            <th>Financial Year</th>
                            <th>Net Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($demands as $demand)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$demand->unique_id}}</td>
                            <td>{{$demand->old_property_id}}</td>
                            <td>{{$demand->property_known_as}}</td>
                            <td>{{$demand->current_fy}}</td>
                            <td>₹ {{customNumFormat($demand->net_total)}}</td>
                            <td>{{getServiceNameById($demand->status)}}</td>
                            <td>
                                <a href="{{route('applicant.viewDemand',$demand->id)}}">
                                    <button class="btn btn-info">View</button>
                                </a>
                                <a href="{{route('applicant.payForDemand',$demand->id)}}">
                                    <button class="btn btn-primary">Proceed to pay</button>
                                </a>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5"> Here we display unpaid demands!!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>


    </div>
</div>
@include('include.alerts.ajax-alert')
@endsection


@section('footerScript')
@endsection