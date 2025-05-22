<?php
return [
    'rgr_factor' => [
        'lndo' => [
            'residential' => 2.5,
            'commercial' => 5
        ],
        'circle' => [
            'residential' => 1,
            'commercial' => 2
        ]
    ],
    'ldo_logo_path' => 'https://upload.wikimedia.org/wikipedia/commons/8/84/Government_of_India_logo.svg',

    'conversion_calculation_rate' => 'circle', //lndo, circle
    'OTP_EXPIRY_TIME' => 2, // changed from 1 to 2  by Amita [27-02-2025]
    'unearned_increase_factor' => 0.25, //by Nitin 20/Nov/24
    'payment_type_id' => 0, //added by Nitin 10/Jan/2024 , to be used in payment data xml
    'paymentURL' => "https://training.pfms.gov.in/bharatkosh/bkepay",
    'paymentStatusURL' => "https://training.pfms.gov.in/bharatkosh/NTRPHome/GetStatusBK",
    'oldDemandByPropertyId' => 'https://ldo.gov.in/eDhartiAPI/Api/GetDemand/ByPropertyID',

];
