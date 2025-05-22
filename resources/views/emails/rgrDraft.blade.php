<!DOCTYPE html>
<html lang="en">
<!-- <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head> -->

<body>
    <div>
        @php
        $column_prefix = ($rgr->calculated_on_rate == "L") ? 'lndo':'circle';
        @endphp
        <div>
            <p>Dear Lessee</p>
            <h5>Subject: &nbsp; Rveision of Ground Rent</h5>
            <p>For your property situated at {{$gr->propertyMaster->oldColony->name}} known as {{$rgr->address}} with Property ID {{$gr->propertyMaster->old_propert_id}} Ground Rent for the period from {{date('d-m-Y',strtotime($rgr->from_date))}} to {{date('d-m-Y',strtotime($rgr->till_date))}} has been fixed / revised @ ₹ {{$rgr->{$column_prefix."_rgr_per_annum"}}} per annum. A Demand ID 12345 for a total amount of ₹ {{$rgr->{$column_prefix."_rgr"}}} has been generated</p>

            <p>Please find the detailed breakdown of the revised ground rent calculations:</p>

            <<p>Please pay the dues by ddmmyyyy to avoid any action as per terms of lease deed. Ignore if already paid.
                </p>

                <p>Thank you for your attention to this matter. We appreciate your cooperation and timely payment.</p>

                <p>Regards</p>
                <p><b>Land and Developemt Office</b></p>
                <p><b>Ministry of Housing aand Urban Affairs</b></p>

        </div>

    </div>
</body>

</html>