<?php

return [
    'mis' => [
        'success' => [
            //MIS MODULE SUCCESS MESSAGE
            'mis_approved' => 'MIS approved successfully.',
            'mis_rejected' => 'User registration has been rejected successfully.',
            'edit_mis_request' => 'The request to update MIS has been successfully sent.',
            'edit_mis_request_granted' => 'The request to update MIS has been granted.',
            'scanned_files_checked' => 'Scanned files have been checked successfully.',
            'user_registration_under_review' => 'The application has been successfully forwarded to the Deputy L&Do for review.',
        ],
        'error' => [
            //MIS MODULE FAILED MESSAGE
            'mis_approved_failed' => 'Failed to approve MIS. Please try again.',
            'mis_rejected_failed' => 'Failed to reject user registration. Please try again.',
            'edit_mis_request_failed' => 'Failed to send the request. Please try again.',
            'edit_mis_request_granted_failed' => 'Failed to grant the request to update MIS. Please try again.',
            'scanned_files_check_failed' => 'Failed to check scanned files. Please try again.',
            'user_registration_under_review_failed' => 'The application failed to be reviewed.',
            'edit_mis_request_granted_failed_1' => 'Failed to update the application status. Please try again.',
            'edit_mis_request_granted_failed_2' => 'Invalid input data. Please try again.',
        ],
    ],
    'general' => [
        //GENERAL MESSAGE
        'success' => [
            'create' => 'Record successfully created.',
            'update' => 'Record successfully updated.',
            'delete' => 'Record successfully deleted.',
            'fetched' => 'Record successfully fetched.',
        ],
        'error' => [
            'create' => 'An error occoured when creating the record.',
            'update' => 'An error occoured when updating the record.',
            'delete' => 'An error occoured when deleting the record.',
            'fetched' => 'An error occoured when getting the record.',
            'unknown' => 'Something went wrong.',
            'noDataFound' => 'No data found.',
            'tryAgain' => 'Something went wrong. Please try after sometime.',
            'accessDenied' => 'You are not allowed to access this data',
        ]
    ],
    'landUseChange' => [
        'success' => [
            'applicationSubmitted' => 'Land use change application submitted successfully.'
        ],
        'error' => [
            'notLeaseHoldProperty' => 'Given property is not lease Hold. Please provide a lease hold property.',
            'applicationAlreadyExist' => 'LUC application already in draft. Please submit or delete that application to continue.',
            'propertyIdMissing' => 'Property id not provided.',
            'terms' => 'Please agree to terms & conditions.',
            'dataNotAvailable' => 'Requested data is not availabale.'
        ]
    ],
    'rgr' => [
        'success' => [],

        'error' => [
            'noRGRPropFound' => 'No property found with revised ground rent.',
        ]
    ],
    'userRegistration' => [
        'success' => [
            'user_created' => 'The user has been created successfully.',
        ],
        'error' => [
            'age' => 'User must be 18 or older to continue.',
            'user_creation_failed' => 'Failed to create the user. Please try again.',
        ]
    ],
    'property' => [
        'success' => [],
        'error' => [
            'notFound' => 'Given property not found.',
            'invalidId' => 'Invalid property id given.',
            'accessDenied' => 'You can not access details of this property.',
            'notLeaseHold' => 'Given property is not lease hold.',
            'invalidArea' => 'Correct area is not available for this property.',
            'landRateNotFound' => 'Land rates not available for this property.',
            'dataNotAvailable' => 'Data not available for this property.'
        ]
    ],
    'doa' => [
        'success' => [
            'deedOfAparatmentStep1Success' => 'Deed of apartment details saved successfully.'
        ],
        'error' => [
            'applicationAlreadyExist' => 'Deed of apartmetn application already in draft. Please submit or delete that application to continue.',
            'somethingWentWrong' => 'Something went wrong!',
        ]
    ],
    'flat' => [
        'success' => [
            'flat_deleted' => 'The flats has been deleted successfully.',
        ],
        'error' => [
            'flat_deleted_error' => 'The flats has not been deleted.',
        ]
    ],
    'application' => [
        'success' => [
            'appointmentScheduled' => 'Appointment scheduled successfully.'
        ],
        'error' => [
            'appNotFound' => 'Application not found',
            'appointmentLinkNotFound' => 'Invalid appointment URL',
            'linkExpired' => 'Given link is not active',
            'rescheduleLimitExceeded' => 'Appointment can be rescheduled only once',
            'appointmentTaken' => 'This date is taken. Choose another date'
        ]
    ],
];
