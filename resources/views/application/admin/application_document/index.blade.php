@switch($applicationType)
@case('Mutation')
@include('application.admin.application_document.mutation')
@break
@case('Land Use Change')
@include('application.admin.application_document.luc')
@break
@case('Deed Of Apartment')
@include('application.admin.application_document.doa')
@break
@case('Conversion')
@include('application.admin.application_document.conversion')
@break
@case('Noc')
        @include('application.admin.application_document.noc')
    @break
@default
<div class="part-title mt-2">
    <h5>Property Document Details</h5>
</div>
<div class="part-details">
    <div class="container-fluid">
        <div class="row g-2">
            <div class="col-lg-12">
                <p>Property Documents Not Available</p>
            </div>
        </div>
    </div>
</div>
@endswitch