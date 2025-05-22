<!DOCTYPE html>
<html lang="en">

<head>
    <title>Deed Of Apartment Letter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- External CSS libraries -->
    <!-- Favicon icon -->
    <link rel="shortcut icon" href="{{ asset('assets/frontend/assets/img/favicon.ico') }}" type="image/x-icon" />

    <!-- Custom Stylesheet -->
</head>
<style>
    @font-face {
        font-family: 'DejaVu Sans';
        src: url('/assets/fonts/DejaVuSans.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    .draft.container {
        font-size: 14px;
        font-family: 'DejaVu Sans', sans-serif;
    }

    .draft.container p {
        margin-bottom: 0.5rem;
    }

    .draft.container p {
        margin-bottom: 0.5rem;
    }

    .container {
        padding: 15px 30px;
    }

    #details-table {
        margin-top: 2%;
    }

    #details-table th,
    #details-table td {
        padding: 0.25em 0 !important;
    }

    #details-table thead {
        background: #ace;
    }

    #details-table th,
    #details-table td {
        text-align: center;
    }

    #details-table tbody tr:nth-child(even) {
        background: #def;
    }

    #details-table tbody tr:nth-child(odd) {
        background: #cadfff;
    }
</style>

<body id="top">
    <!-- Login 8 section start -->
    <nav class="navbar">
        <!-- <div class="container"> -->
        <div class="row align-items-center">
            <div class="col-lg-12" style="padding: 0 30px">
                @php
                    $logoPath = config('constants.ldo_logo_path');
                @endphp
                <a class="navbar-brand" href="#">
                    <img src="{{ $logoPath }}" alt="Land and Development Office" height="60" />
                </a>
            </div>
        </div>
        <!-- </div> -->
    </nav>
    <div>
        <div class="container draft">
            <div class="row">
                <div class="col-lg-12">
                    <h5 class="flex">Deed Of Apartment Letter</h5>



                    <table class="table" id="details-table" style="width: 100%;">
                        <!--width 100% added for pdf. In blade view it is not required-->
                        <tbody>
                            <tr>
                                <th>NO.</th>
                                <td>LDO/ LS1/242511</td>
                            </tr>
                            <tr>
                                <th>Report Date: </th>
                                <td>05-Aug-2024 12:00:00 AM</td>
                            </tr>
                            <tr>
                                <th>Property ID: </th>
                                <td>24702</td>
                            </tr>
                            <tr>
                                <th>Application ID: </th>
                                <td>100222619</td>
                            </tr>
                        </tbody>
                    </table>
                    <p>With number reference 16A / 1 to known the application as 13/ Plot dated / PRITHVI 01-Jul-2024
                        RAJ ROÁD regarding Mutation of Ownership rights (freehold) in respect of Property , Delhi / New
                        Delhi</p>
                    <p>Yours sincerely,</p>
                    <p><b>Land and Developemt Office</b></p>
                    <p><b>Ministry of Housing aand Urban Affairs</b></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom JS Script -->
</body>

</html>
