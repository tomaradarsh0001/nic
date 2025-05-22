@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<style>
    .subtypes {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
    }

    .typeName {
        text-align: center;
    }

    .custom-col {
        flex: 1;
        margin: 0 5px;
    }

    .custom-col:first-child {
        margin-left: 0;
    }

    .custom-col:last-child {
        margin-right: 0;
    }

    h6 {
        font-size: 11px !important;
    }
</style>
<div class="container-fluid">
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 custom_card_container">
        @foreach($registrations as $index=>$registration)
        <div class="col custom-col" style="{{ $index == 'total' ? 'cursor: pointer;' : '' }}" id="{{ $index == 'total' ? 'register_user_listing' : '' }}">
            <div class="card radius-10 border-start border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin"><img src="{{asset('assets/images/properties-icon-hand-Total.svg')}}" alt="properties">
                        </div>
                        <div>
                            <h4 class="my-1 grid-icons-size text-dark" id="tile_total_count">{{$registration}}</h4>
                            <p class="mb-0 text-secondary">{{ucfirst($index)}} Registrations</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        {{-- <div class="col custom-col">
            <div class="card radius-10 border-start border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin"><img src="{{asset('assets/images/properties-icon-hand-Total.svg')}}" alt="properties">
    </div>
    <div>
        <h4 class="my-1 grid-icons-size text-dark" id="tile_total_count">{{$registrations['pending']}}</h4>
        <p class="mb-0 text-secondary">Pending Registrations</p>
    </div>
</div>
</div>
</div>
</div>
<div class="col custom-col">
    <div class="card radius-10 border-start border-0">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin" style="background-color: #FFF3E0;"><img src="{{asset('assets/images/pageless-Total.svg')}}" alt="Pageless">
                </div>
                <div>
                    <h4 class="my-1 grid-icons-size text-dark" id="tile_total_area_formatted">{{$registrations['approved']}}</h4>
                    <p class="mb-0 text-secondary">Approved Registrations</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col custom-col">
    <div class="card radius-10 border-start border-0">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin" style="background-color: #F3E5F5;"><img src="{{asset('assets/images/sell-Total.svg')}}" alt="Land Value">
                </div>
                <div>
                    <h4 class="my-1 grid-icons-size text-dark" id="tile_total_land_value_ldo_formatted">{{$registrations['rejected']}}</h4>
                    <p class="mb-0 text-secondary">Rejected Registrations
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col custom-col">
    <div class="card radius-10 border-start border-0">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin" style="background-color: #E0F2F1;"><img src="{{asset('assets/images/payments-Total.svg')}}" alt="properties">
                </div>
                <div>
                    <h4 class="my-1 text-dark grid-icons-size">{{$registrations['transferred']}}</h4>
                    <p class="mb-0 text-secondary">Transferred Registrations

                    </p>
                </div>
            </div>
        </div>
    </div>
</div> --}}

</div>
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 custom_card_container">
    @foreach($applications as $index=>$application)
    <div class="col custom-col">
        <div class="card radius-10 border-start border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin"><img src="{{asset('assets/images/properties-icon-hand-Total.svg')}}" alt="properties">
                    </div>
                    <div>
                        <h4 class="my-1 grid-icons-size text-dark" id="tile_total_count">{{$application}}</h4>
                        <p class="mb-0 text-secondary">{{ucwords(str_replace('_',' ',$index))}} Applications</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 custom_card_container">
    @foreach($application_types as $ind=>$type)
    <div class="col custom-col">
        <div class="card radius-10 border-start border-0">
            <div class="card-body">
                <div class="d-flex flex-column">
                    <!-- <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin" style="background-color: #FFEBEE;"><img src="{{asset('assets/images/properties-icon-hand.svg')}}" alt="properties">
                    </div> -->
                    <div class="subtypes" style="display:flex;flex-direction:row;">
                        @foreach($type as $k=>$val)
                        <div class="subtype-details" style="display:flex; flex-direction:column">
                            <h4>{{$val}}</h4>
                            <h6>{{ucwords(str_replace('_',' ',$k))}}</h6>
                        </div>
                        @endforeach
                    </div>
                    <div class="typeName">
                        <h5>{{str_replace(' Of',' of',ucwords(str_replace('_',' ',$ind)) )}}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    {{-- <div class="col custom-col">
        <div class="card radius-10 border-start border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin" style="background-color: #FFF3E0;"><img src="{{asset('assets/images/pageless.svg')}}" alt="Pageless">
</div>
<div>
    <h4 class="my-1 grid-icons-size text-dark">{{customNumFormat(round(324251177))}}</h4>
    <p class="mb-0 text-secondary">Total Area of FH Properties (Sqm)</p>
</div>
</div>
</div>
</div>
</div>
<div class="col custom-col">
    <div class="card radius-10 border-start border-0">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin" style="background-color: #F3E5F5;"><img src="{{asset('assets/images/sell.svg')}}" alt="Land Value">
                </div>
                <div>
                    <h4 class="my-1 grid-icons-size text-dark">₹{{customNumFormat(round(234354775/10000000))}} Cr.</h4>
                    <p class="mb-0 text-secondary">Total FH Land Value (L&DO)</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col custom-col">
    <div class="card radius-10 border-start border-0">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin" style="background-color: #E0F2F1;"><img src="{{asset('assets/images/payments.svg')}}" alt="properties">
                </div>
                <div>
                    <h4 class="my-1 text-dark grid-icons-size" id="tile_free_hold_land_value_circle_formatted">₹{{customNumFormat(round(123467890/10000000))}} Cr.</h4>
                    <p class="mb-0 text-secondary">Total FH Land Value (Circle rate)

                    </p>
                </div>
            </div>
        </div>
    </div>
</div> --}}
</div>

<script>
    document.getElementById("register_user_listing").onclick = function(){
        window.location.href = "{{ route('reviewApplicationsListings')}}";
    }
</script>
@endsection
